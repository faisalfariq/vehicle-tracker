@extends('layouts.app')

@section('title', 'Create Service Log')

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
                    <div class="breadcrumb-item">Create a Service Log</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Create New Service Log</h2>
                            </div>
                            <form action="#" id="form_add_service_log" method="POST">
                                @csrf
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Vehicle</label>
                                            <select name="vehicle_id" class="form-control select2">
                                                <option value="">Pilih</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback vehicle_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Service Date</label>
                                            <input type="date" class="form-control" name="service_date">
                                            <div class="invalid-feedback service_date_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-primary">Description</label>
                                            <input type="text" class="form-control" name="description">
                                            <div class="invalid-feedback description_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">KM</label>
                                            <input type="number" class="form-control" name="km">
                                            <div class="invalid-feedback km_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Cost</label>
                                            <input type="number" class="form-control" name="cost">
                                            <div class="invalid-feedback cost_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('service-logs.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom_js/pages/service_logs/service_logs_create.js') }}"></script>
@endpush