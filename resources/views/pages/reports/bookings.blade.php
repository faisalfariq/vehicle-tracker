@extends('layouts.app')
@section('title', 'Laporan Booking Kendaraan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 class="text-primary">Laporan Booking Kendaraan</h1>
        </div>
        <div class="section-body">
            <form method="GET" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-2">
                        <label class="text-primary">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="text-primary">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="text-primary">Kendaraan</label>
                        <select name="vehicle_id" class="form-control select2">
                            <option value="">Semua</option>
                            @foreach($allVehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="text-primary">Status</label>
                        <select name="status" class="form-control select2">
                            <option value="">Semua</option>
                            @foreach($statusList as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="text-primary">User</label>
                        <select name="user_id" class="form-control select2">
                            <option value="">Semua</option>
                            @foreach($allUsers as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="text-primary">Region</label>
                        <select name="region_id" class="form-control select2">
                            <option value="">Semua</option>
                            @foreach($allRegions as $region)
                                <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-2">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-filter"></i> Filter</button>
                    </div>
                </div>
            </form>
            <form method="GET" action="{{ route('reports.bookings.export') }}">
                @foreach(request()->except('page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <button type="submit" class="btn btn-success mb-3"><i class="fas fa-file-excel"></i> Export Excel</button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Kode</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>User</th>
                            <th>Kendaraan</th>
                            <th>Plat</th>
                            <th>Driver</th>
                            <th>Status</th>
                            <th>Approver 1</th>
                            <th>Status 1</th>
                            <th>Approver 2</th>
                            <th>Status 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking->code }}</td>
                                <td>{{ $booking->start_datetime }}</td>
                                <td>{{ $booking->end_datetime }}</td>
                                <td>{{ optional($booking->user)->name }}</td>
                                <td>{{ optional($booking->vehicle)->name }}</td>
                                <td>{{ optional($booking->vehicle)->plate_number }}</td>
                                <td>{{ optional($booking->driver)->name }}</td>
                                <td>{{ $booking->status }}</td>
                                <td>{{ optional($booking->approvals->where('level',1)->first()->approver ?? null)->name }}</td>
                                <td>{{ $booking->approvals->where('level',1)->first()->status ?? '' }}</td>
                                <td>{{ optional($booking->approvals->where('level',2)->first()->approver ?? null)->name }}</td>
                                <td>{{ $booking->approvals->where('level',2)->first()->status ?? '' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="15" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $bookings->withQueryString()->links() }}
            </div>
        </div>
    </section>
</div>
@endsection 