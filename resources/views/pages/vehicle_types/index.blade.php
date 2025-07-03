@extends('layouts.app')

@section('title', 'Vehicle Type List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Vehicle Types</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Vehicle Type List</a></div>
                    <div class="breadcrumb-item">Data Vehicle Types</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Vehicle Type List</h2>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="float-left">
                                    <a href="{{ route('vehicle-types.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                                <div class="float-right">
                                    <form action="{{ route('vehicle-types.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div id="vehicleTypeTableList">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="vehicle_types_list">
                                                @foreach ($types as $type)
                                                    <tr>
                                                        <td>{{ $type->id }}</td>
                                                        <td>{{ $type->name }}</td>
                                                        <td>
                                                            <a href="{{ route('vehicle-types.show', $type->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                            <a href="{{ route('vehicle-types.edit', $type->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete-vehicle-type" data-id="{{ $type->id }}">Delete</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $types->links() }}
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
    <!-- JS Libraies -->
    <script src="{{ asset('js/custom_js/pages/vehicle_types/vehicle_types_index.js') }}"></script>
@endpush