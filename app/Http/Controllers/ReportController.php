<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Region;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingsExport;

class ReportController extends Controller
{
    public function bookings(Request $request)
    {
        $allVehicles = Vehicle::orderBy('name')->get();
        $allUsers = User::orderBy('name')->get();
        $allRegions = Region::orderBy('name')->get();
        $statusList = ['draft','pending','approved','rejected','onuse','finish'];

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $vehicleId = $request->vehicle_id;
        $status = $request->status;
        $userId = $request->user_id;
        $regionId = $request->region_id;

        $query = Booking::with(['user','vehicle','driver','approvals','fuelLogs','bookingLogs','documents']);
        if ($startDate) {
            $query->whereDate('start_datetime', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('end_datetime', '<=', $endDate);
        }
        if ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        if ($regionId) {
            $query->whereHas('vehicle', function($q) use ($regionId) {
                $q->where('region_id', $regionId);
            });
        }
        $bookings = $query->latest()->paginate(20);

        return view('pages.reports.bookings', compact('bookings','allVehicles','allUsers','allRegions','statusList'));
    }

    public function exportBookings(Request $request)
    {
        // Query bookings with filters (same as in bookings method)
        $query = \App\Models\Booking::with(['user','vehicle','driver','approvals']);
        if ($request->start_date) {
            $query->whereDate('start_datetime', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('end_datetime', '<=', $request->end_date);
        }
        if ($request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->region_id) {
            $query->whereHas('vehicle', function($q) use ($request) {
                $q->where('region_id', $request->region_id);
            });
        }
        $bookings = $query->latest()->get();

        // Create spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Headings
        $headings = [
            'Kode Booking', 'Tanggal Mulai', 'Tanggal Selesai', 'User', 'Kendaraan', 'Plat', 'Driver', 'Status',
            'Approver 1', 'Status Approver 1', 'Approver 2', 'Status Approver 2'
        ];
        $sheet->fromArray($headings, null, 'A1');
        // Data
        $row = 2;
        foreach ($bookings as $booking) {
            $approver1 = $booking->approvals->where('level',1)->first();
            $approver2 = $booking->approvals->where('level',2)->first();
            $sheet->fromArray([
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
            ], null, 'A'.$row);
            $row++;
        }
        // Output
        $fileName = 'bookings_report_'.now()->format('Ymd_His').'.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output'); 
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    } 
} 