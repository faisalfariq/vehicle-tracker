@extends('layouts.app')

@section('title', 'Detail Vehicle')

@push('style')
    <!-- CSS Libraries -->
    <style>
         .table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
         padding: 0 25px;
         height: 35px;
         vertical-align: middle;
     }
     </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Vehicles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Vehicles</a></div>
                    <div class="breadcrumb-item">Detail Vehicle</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Detail Vehicle</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td width="200" class="text-primary font-weight-bold">
                                                        <i class="fas fa-id-card"></i> ID
                                                    </td>
                                                    <td width="50" class="text-center">:</td>
                                                    <td>{{ $vehicle->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-car"></i> Nama
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $vehicle->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-hashtag"></i> No Polisi
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $vehicle->plate_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-tag"></i> Tipe
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $vehicle->type->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-gas-pump"></i> BBM
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $vehicle->fuel_type }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-map-marker-alt"></i> Region
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $vehicle->region->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-info-circle"></i> Status
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>
                                                        @if($vehicle->is_available)
                                                            <span class="badge badge-success">Tersedia</span>
                                                        @else
                                                            <span class="badge badge-secondary">Tidak Tersedia</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-key"></i> Kendaraan Disewa?
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>
                                                        @if($vehicle->is_rented)
                                                            <span class="badge badge-warning">Disewa</span>
                                                        @else
                                                            <span class="badge badge-info">Milik Sendiri</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('vehicles.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                <a type="button" href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
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
@endpush