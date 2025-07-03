@extends('layouts.app')
@section('title', 'Add Fuel Log')

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
                    <div class="breadcrumb-item">Add Fuel Log</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Add Fuel Log</h2>
                            </div>
                            <form action="#" id="form_add_fuel_log" method="POST">
                                @csrf
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Vehicle</label>
                                            <select class="form-control select2" name="vehicle_id">
                                                <option value="">Select</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback vehicle_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Booking</label>
                                            <select class="form-control select2" name="booking_id">
                                                <option value="">Select</option>
                                                @foreach($bookings as $booking)
                                                    <option value="{{ $booking->id }}">{{ $booking->destination }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback booking_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-primary">Date</label>
                                            <input type="date" class="form-control" name="date">
                                            <div class="invalid-feedback date_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-primary">Fuel Amount</label>
                                            <input type="number" step="0.01" class="form-control" name="fuel_amount">
                                            <div class="invalid-feedback fuel_amount_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-primary">Fuel Cost</label>
                                            <input type="number" step="0.01" class="form-control" name="fuel_cost">
                                            <div class="invalid-feedback fuel_cost_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">KM Before</label>
                                            <input type="number" class="form-control" name="km_before">
                                            <div class="invalid-feedback km_before_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">KM After</label>
                                            <input type="number" class="form-control" name="km_after">
                                            <div class="invalid-feedback km_after_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('fuel-logs.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom_js/pages/fuel_logs/fuel_logs_create.js') }}"></script>
@endpush