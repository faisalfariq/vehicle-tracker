@extends('layouts.app')

@section('title', 'Detail Service Log')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Service Logs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Service Logs</a></div>
                    <div class="breadcrumb-item">Detail Service Log</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Detail Service Log</h2>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">ID</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $serviceLog->id }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Vehicle</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $serviceLog->vehicle->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Service Date</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $serviceLog->service_date }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Description</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $serviceLog->description }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">KM</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $serviceLog->km }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Cost</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $serviceLog->cost }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('service-logs.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                <a type="button" href="{{ route('service-logs.edit', $serviceLog->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
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