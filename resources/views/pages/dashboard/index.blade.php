@extends('layouts.app')
@section('title', 'Dashboard')

@push('style')
<style>
    .dashboard-card {
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        border-radius: 1rem;
    }
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 class="text-primary">Dashboard</h1>
        </div>
        <div class="section-body">
            <!-- Filter Form -->
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
            <!-- End Filter Form -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-header">
                            <h4 class="text-primary mb-0">Top 10 Vehicle Usage</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="vehicleUsageChart" height="220"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-header">
                            <h4 class="text-primary mb-0">Bookings Per Day (Last 14 Days)</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="bookingsPerDayChart" height="220"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Vehicle Usage Bar Chart
    const vehicleUsageCtx = document.getElementById('vehicleUsageChart').getContext('2d');
    const vehicleUsageChart = new Chart(vehicleUsageCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($vehicleUsage->pluck('name')) !!},
            datasets: [{
                label: 'Total Bookings',
                data: {!! json_encode($vehicleUsage->pluck('bookings_count')) !!},
                backgroundColor: 'rgba(103, 119, 239, 0.7)',
                borderColor: 'rgba(103, 119, 239, 1)',
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Bookings Per Day Line Chart
    const bookingsPerDayCtx = document.getElementById('bookingsPerDayChart').getContext('2d');
    const bookingsPerDayChart = new Chart(bookingsPerDayCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bookingsPerDay->pluck('date')) !!},
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($bookingsPerDay->pluck('total')) !!},
                fill: true,
                backgroundColor: 'rgba(103, 119, 239, 0.15)',
                borderColor: 'rgba(103, 119, 239, 1)',
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: 'rgba(103, 119, 239, 1)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush 