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
                                <div class="card-header-action">
                                    <a href="{{ route('fuel-logs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                            </div>
                            <div class="card-body">
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
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Vehicle</th>
                                                    <th>Booking</th>
                                                    <th>Date</th>
                                                    <th>Fuel Amount</th>
                                                    <th>Fuel Cost</th>
                                                    <th>KM Before</th>
                                                    <th>KM After</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fuel_logs_list">
                                                @foreach($fuelLogs as $fuelLog)
                                                <tr>
                                                    <td>{{ $fuelLog->id }}</td>
                                                    <td>{{ $fuelLog->vehicle->name ?? '-' }}</td>
                                                    <td>{{ $fuelLog->booking->destination ?? '-' }}</td>
                                                    <td>{{ $fuelLog->date }}</td>
                                                    <td>{{ $fuelLog->fuel_amount }}</td>
                                                    <td>{{ $fuelLog->fuel_cost }}</td>
                                                    <td>{{ $fuelLog->km_before }}</td>
                                                    <td>{{ $fuelLog->km_after }}</td>
                                                    <td>
                                                        <a href="{{ route('fuel-logs.show', $fuelLog->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                        <a href="{{ route('fuel-logs.edit', $fuelLog->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <button type="button" class="btn btn-danger btn-sm btn-delete-fuel-log" data-id="{{ $fuelLog->id }}">Delete</button>
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