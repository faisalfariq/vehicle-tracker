@extends('layouts.app')
@section('title', 'Fuel Log Detail')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Fuel Logs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Fuel Logs</a></div>
                    <div class="breadcrumb-item">Fuel Log Detail</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Fuel Log Detail</h2>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">ID</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $fuelLog->id }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Vehicle</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $fuelLog->vehicle->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Booking</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $fuelLog->booking->destination ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Date</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $fuelLog->date }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label text-primary">Fuel Amount</label>
                                        <div class="col-md-6">
                                            <label class="custom-switch-description">{{ $fuelLog->fuel_amount }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label text-primary">Fuel Cost</label>
                                        <div class="col-md-6">
                                            <label class="custom-switch-description">{{ $fuelLog->fuel_cost }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label text-primary">Date</label>
                                        <div class="col-md-6">
                                            <label class="custom-switch-description">{{ $fuelLog->date }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label text-primary">KM Before</label>
                                        <div class="col-md-6">
                                            <label class="custom-switch-description">{{ $fuelLog->km_before }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label text-primary">KM After</label>
                                        <div class="col-md-6">
                                            <label class="custom-switch-description">{{ $fuelLog->km_after }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('fuel-logs.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                <a type="button" href="{{ route('fuel-logs.edit', $fuelLog->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush