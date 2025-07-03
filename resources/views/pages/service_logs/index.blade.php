@extends('layouts.app')

@section('title', 'Service Log List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Service Logs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Service Log List</a></div>
                    <div class="breadcrumb-item">Data Service Logs</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Service Log List</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="{{ route('service-logs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                                <div class="float-right">
                                    <form action="{{ route('service-logs.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div id="serviceLogTableList">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Vehicle</th>
                                                    <th>Service Date</th>
                                                    <th>Description</th>
                                                    <th>KM</th>
                                                    <th>Cost</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="service_logs_list">
                                                @foreach ($serviceLogs as $log)
                                                    <tr>
                                                        <td>{{ $log->id }}</td>
                                                        <td>{{ $log->vehicle->name ?? '-' }}</td>
                                                        <td>{{ $log->service_date }}</td>
                                                        <td>{{ $log->description }}</td>
                                                        <td>{{ $log->km }}</td>
                                                        <td>{{ $log->cost }}</td>
                                                        <td>
                                                            <a href="{{ route('service-logs.show', $log->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                            <a href="{{ route('service-logs.edit', $log->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete-service-log" data-id="{{ $log->id }}">Delete</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $serviceLogs->links() }}
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
    <script src="{{ asset('js/custom_js/pages/service_logs/service_logs_index.js') }}"></script>
@endpush