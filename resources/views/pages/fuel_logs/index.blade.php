@extends('layouts.app')
@section('title', 'Fuel Logs List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Fuel Logs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Fuel Logs List</a></div>
                    <div class="breadcrumb-item">Data Fuel Logs</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                        
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Fuel Logs List</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="{{ route('fuel-logs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                                <div class="float-right mb-3">
                                    <form action="{{ route('fuel-logs.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div id="fuelLogsTableList">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th>Vehicle</th>
                                                    <th>Booking</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-right">Fuel Amount</th>
                                                    <th class="text-right">Fuel Cost</th>
                                                    <th class="text-right">KM Before</th>
                                                    <th class="text-right">KM After</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fuel_logs_list">
                                                @foreach($fuelLogs as $fuelLog)
                                                <tr>
                                                    <td class="text-center">{{ $fuelLog->id }}</td>
                                                    <td>{{ $fuelLog->vehicle->name ?? '-' }}</td>
                                                    <td>{{ $fuelLog->booking->destination ?? '-' }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($fuelLog->date)->format('d-m-Y') }}</td>
                                                    <td class="text-right">{{ number_format($fuelLog->fuel_amount, 2) }}</td>
                                                    <td class="text-right">{{ number_format($fuelLog->fuel_cost, 0, ',', '.') }}</td>
                                                    <td class="text-right">{{ number_format($fuelLog->km_before, 0, ',', '.') }}</td>
                                                    <td class="text-right">{{ number_format($fuelLog->km_after, 0, ',', '.') }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="{{ route('fuel-logs.show', $fuelLog->id) }}" class="btn btn-info">Detail</a>
                                                            <a href="{{ route('fuel-logs.edit', $fuelLog->id) }}" class="btn btn-warning">Edit</a>
                                                            <button type="button" class="btn btn-danger btn-delete-fuel-log" data-id="{{ $fuelLog->id }}">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $fuelLogs->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom_js/pages/fuel_logs/fuel_logs_index.js') }}"></script>
@endpush