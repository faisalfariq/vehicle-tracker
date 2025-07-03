@extends('layouts.app')

@section('title', 'Detail Driver')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Drivers</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Drivers</a></div>
                    <div class="breadcrumb-item">Detail a Driver</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Detail a Driver</h2>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">ID</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $driver->id }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Name</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $driver->name }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">License Number</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $driver->license_number }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Phone</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $driver->phone }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Region</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $driver->region->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Status</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">
                                                @if($driver->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('drivers.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                <a type="button" href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush