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