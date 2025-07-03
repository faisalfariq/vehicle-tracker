@extends('layouts.app')

@section('title', 'Create Booking Log')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Booking Logs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Booking Logs</a></div>
                    <div class="breadcrumb-item">Create a Booking Log</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Create New Booking Log</h2>
                            </div>
                            <form action="#" id="form_add_booking_log" method="POST">
                                @csrf
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Booking</label>
                                            <select class="form-control select2" name="booking_id">
                                                <option value="">Pilih</option>
                                                @foreach ($bookings as $booking)
                                                    <option value="{{ $booking->id }}">{{ $booking->destination }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback booking_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Event</label>
                                            <select class="form-control" name="event">
                                                <option value="start">Start</option>
                                                <option value="stop">Stop</option>
                                                <option value="pause">Pause</option>
                                            </select>
                                            <div class="invalid-feedback event_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Datetime</label>
                                            <input type="datetime-local" class="form-control" name="datetime">
                                            <div class="invalid-feedback datetime_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Odometer</label>
                                            <input type="number" class="form-control" name="odometer">
                                            <div class="invalid-feedback odometer_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-primary">Notes</label>
                                            <textarea class="form-control" name="notes"></textarea>
                                            <div class="invalid-feedback notes_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('booking-logs.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
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
    <script src="{{ asset('js/custom_js/pages/booking_logs/booking_logs_create.js') }}"></script>
@endpush