@extends('layouts.app')

@section('title', 'Edit Booking Log')

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
                    <div class="breadcrumb-item">Edit a Booking Log</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Edit Booking Log</h2>
                            </div>
                            <form action="{{ route('booking-logs.update', $log->id) }}" id="form_edit_booking_log" method="POST">
                                @csrf @method('PUT')
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Booking</label>
                                            <select class="form-control select2" name="booking_id">
                                                <option value="">Pilih</option>
                                                @foreach ($bookings as $booking)
                                                    <option value="{{ $booking->id }}" @if($log->booking_id == $booking->id) selected @endif>{{ $booking->destination }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback booking_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Event</label>
                                            <select class="form-control" name="event">
                                                <option value="start" @if($log->event == 'start') selected @endif>Start</option>
                                                <option value="stop" @if($log->event == 'stop') selected @endif>Stop</option>
                                                <option value="pause" @if($log->event == 'pause') selected @endif>Pause</option>
                                            </select>
                                            <div class="invalid-feedback event_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Datetime</label>
                                            <input type="datetime-local" class="form-control" name="datetime" value="{{ old('datetime', \Carbon\Carbon::parse($log->datetime)->format('Y-m-d\TH:i')) }}">
                                            <div class="invalid-feedback datetime_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Odometer</label>
                                            <input type="number" class="form-control" name="odometer" value="{{ old('odometer', $log->odometer) }}">
                                            <div class="invalid-feedback odometer_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-primary">Notes</label>
                                            <textarea class="form-control" name="notes">{{ old('notes', $log->notes) }}</textarea>
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
    <script src="{{ asset('js/custom_js/pages/booking_logs/booking_logs_edit.js') }}"></script>
@endpush