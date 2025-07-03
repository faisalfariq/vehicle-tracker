@extends('layouts.app')

@section('title', 'Detail Vehicle')

@push('style')
    <!-- CSS Libraries -->
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
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">ID</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $vehicle->id }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Nama</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $vehicle->name }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">No Polisi</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $vehicle->plate_number }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Tipe</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $vehicle->type->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">BBM</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $vehicle->fuel_type }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Region</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $vehicle->region->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Status</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">
                                                @if($vehicle->is_available)
                                                    <span class="badge bg-success">Tersedia</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Tersedia</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Kendaraan Disewa?</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">
                                                @if($vehicle->is_rented)
                                                    <span class="badge bg-warning text-dark">Disewa</span>
                                                @else
                                                    <span class="badge bg-info text-dark">Milik Sendiri</span>
                                                @endif
                                            </label>
                                        </div>
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