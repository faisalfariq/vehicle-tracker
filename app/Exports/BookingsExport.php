<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Booking::with(['user','vehicle','driver','approvals','fuelLogs','bookingLogs','documents']);
        if ($this->request->start_date) {
            $query->whereDate('start_datetime', '>=', $this->request->start_date);
        }
        if ($this->request->end_date) {
            $query->whereDate('end_datetime', '<=', $this->request->end_date);
        }
        if ($this->request->vehicle_id) {
            $query->where('vehicle_id', $this->request->vehicle_id);
        }
        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }
        if ($this->request->user_id) {
            $query->where('user_id', $this->request->user_id);
        }
        if ($this->request->region_id) {
            $query->whereHas('vehicle', function($q) {
                $q->where('region_id', $this->request->region_id);
            });
        }
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Kode Booking',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'User',
            'Kendaraan',
            'Plat',
            'Driver',
            'Status',
            'Approver 1',
            'Status Approver 1',
            'Approver 2',
            'Status Approver 2',
            'Total Log',
            'Total Fuel',
            'Total Dokumen',
        ];
    }

    public function map($booking): array
    {
        $approver1 = $booking->approvals->where('level',1)->first();
        $approver2 = $booking->approvals->where('level',2)->first();
        return [
            $booking->code,
            $booking->start_datetime,
            $booking->end_datetime,
            optional($booking->user)->name,
            optional($booking->vehicle)->name,
            optional($booking->vehicle)->plate_number,
            optional($booking->driver)->name,
            $booking->status,
            optional($approver1->approver ?? null)->name,
            $approver1->status ?? '',
            optional($approver2->approver ?? null)->name,
            $approver2->status ?? '',
            $booking->bookingLogs->count(),
            $booking->fuelLogs->count(),
            $booking->documents->count(),
        ];
    }
} 