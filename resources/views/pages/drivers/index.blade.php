@extends('layouts.app')

@section('title', 'Driver List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Drivers</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Driver List</a></div>
                    <div class="breadcrumb-item">Data Drivers</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Driver List</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="{{ route('drivers.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                                <div class="float-right">
                                    <form action="{{ route('drivers.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div id="driverTableList">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th>Name</th>
                                                    <th>License Number</th>
                                                    <th>Phone</th>
                                                    <th>Region</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="drivers_list">
                                                @foreach ($drivers as $driver)
                                                    <tr>
                                                        <td class="text-center">{{ $driver->id }}</td>
                                                        <td>{{ $driver->name }}</td>
                                                        <td>{{ $driver->license_number }}</td>
                                                        <td>{{ $driver->phone }}</td>
                                                        <td>{{ $driver->region->name ?? '-' }}</td>
                                                        <td class="text-center">
                                                            @if ($driver->is_active)
                                                                <span class="badge badge-success">Active</span>
                                                            @else
                                                                <span class="badge badge-secondary">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{ route('drivers.show', $driver->id) }}" class="btn btn-info">Detail</a>
                                                                <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-warning">Edit</a>
                                                                <button type="button" class="btn btn-danger btn-delete-driver" data-id="{{ $driver->id }}">Hapus</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $drivers->links() }}
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
    <script src="{{ asset('js/custom_js/pages/drivers/drivers_index.js') }}"></script>
@endpush
