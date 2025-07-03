@extends('layouts.app')

@section('title', 'Vehicle List')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_css/pages/products/products_index.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Vehicles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Vehicle List</a></div>
                    <div class="breadcrumb-item">Data Vehicles</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">All <span id="total_data"
                                                class="badge badge-white"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('vehicles.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                                    Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form action="{{ route('vehicles.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword"
                                                placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div id="vehicleTableList">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    {{-- <th class="pt-2 text-center">
                                                        <div class="custom-checkbox custom-checkbox-table custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup"
                                                                data-checkbox-role="dad" class="custom-control-input"
                                                                id="checkbox-all">
                                                            <label for="checkbox-all"
                                                                class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </th> --}}
                                                    <th>ID</th>
                                                    <th>Nama</th>
                                                    <th>No Polisi</th>
                                                    <th>Tipe</th>
                                                    <th>BBM</th>
                                                    <th>Region</th>
                                                    <th>Status</th>
                                                    <th>Disewa</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="vehicles_list">
                                                @foreach ($vehicles as $vehicle)
                                                    <tr>
                                                        <td>{{ $vehicle->id }}</td>
                                                        <td>{{ $vehicle->name }}</td>
                                                        <td>{{ $vehicle->plate_number }}</td>
                                                        <td>{{ $vehicle->type->name ?? '-' }}</td>
                                                        <td>{{ $vehicle->fuel_type }}</td>
                                                        <td>{{ $vehicle->region->name ?? '-' }}</td>
                                                        <td>
                                                            @if ($vehicle->is_available)
                                                                <span class="badge bg-success text-white">Tersedia</span>
                                                            @else
                                                                <span class="badge bg-secondary text-white">Tidak Tersedia</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($vehicle->is_rented)
                                                                <span class="badge bg-warning text-white">Disewa</span>
                                                            @else
                                                                <span class="badge bg-info text-white">Milik Sendiri</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                                                class="btn btn-info btn-sm">Detail</a>
                                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete-vehicle" data-id="{{ $vehicle->id }}">Delete</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $vehicles->links() }}
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script src="{{ asset('js/custom_js/pages/products/products_index.js') }}"></script>
    <script src="{{ asset('js/custom_js/pages/vehicles/vehicles_index.js') }}"></script>
@endpush
