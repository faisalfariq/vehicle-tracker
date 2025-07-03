@extends('layouts.app')

@section('title', 'Create Booking')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('css/custom_css/pages/user/user_create.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/custom_css/pages/bookings/bookings_create.css') }}"> --}}
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Bookings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Bookings</a></div>
                    <div class="breadcrumb-item">Create a Booking</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-\">Form Create New Booking</h2>
                            </div>
                            <form action="#"
                                    id="form_add_booking" method="POST">
                                    @csrf
                                    <div class="card-body row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-primary">Employee</label>
                                                <select class="form-control select2" name="user_id">
                                                    <option value="">Pilih</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback user_id_error">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-primary">Vehicle</label>
                                                <select class="form-control select2" name="vehicle_id">
                                                    <option value="">Pilih</option>
                                                    @foreach ($vehicles as $vehicle)
                                                        <option value="{{ $vehicle->id }}">
                                                            {{ $vehicle->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback vehicle_id_error">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-primary">Driver</label>
                                                <select class="form-control select2" name="driver_id">
                                                    <option value="">Pilih</option>
                                                    @foreach ($drivers as $driver)
                                                        <option value="{{ $driver->id }}">
                                                            {{ $driver->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback driver_id_error">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-primary">Destination</label>
                                                <input type="text" class="form-control" name="destination">
                                                <div class="invalid-feedback destination_error">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-primary">Reason</label>
                                                <input type="text" class="form-control" name="reason">
                                                <div class="invalid-feedback reason_error">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="text-primary">Start Date</label>
                                                        <input type="text" class="form-control datetimepicker"
                                                            name="start_datetime">
                                                        <div class="invalid-feedback start_datetime_error">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="text-primary">End Date</label>
                                                        <input type="text" class="form-control datetimepicker"
                                                            name="end_datetime">
                                                        <div class="invalid-feedback end_datetime_error">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-primary">Approver 1</label>
                                                <select class="form-control select2" name="approver1_id">
                                                    <option value="">Pilih</option>
                                                    @foreach ($approvers as $approver)
                                                        <option value="{{ $approver->id }}">
                                                            {{ $approver->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback approver1_id_error">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-primary">Approver 2</label>
                                                <select class="form-control select2" name="approver2_id">
                                                    <option value="">Pilih</option>
                                                    @foreach ($approvers as $approver)
                                                        <option value="{{ $approver->id }}">
                                                            {{ $approver->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback approver2_id_error">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <a type="button" href="{{ route('bookings.index') }}" class="btn btn-danger"><i
                                                class="fas fa-angle-left"></i> Back</a>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i>
                                            Save</button>
                                    </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script src="{{ asset('js/custom_js/pages/bookings/bookings_create.js') }}"></script>
@endpush
