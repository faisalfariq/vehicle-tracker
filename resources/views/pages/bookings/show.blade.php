@extends('layouts.app')

@section('title', 'Detail Booking')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Bookings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Bookings</a></div>
                    <div class="breadcrumb-item">Detail a Booking</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-">Detail a Booking</h2>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Booking Code</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $booking->code }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Employee</label>
                                        <div class="col-md-8">
                                            <label
                                                class="custom-switch-description">{{ $booking->user->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Vehicle</label>
                                        <div class="col-md-8">
                                            <label
                                                class="custom-switch-description">{{ $booking->vehicle->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Driver</label>
                                        <div class="col-md-8">
                                            <label
                                                class="custom-switch-description">{{ $booking->driver->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Destination</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $booking->destination }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Reason</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $booking->reason ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Start Date</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $booking->start_datetime }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">End Date</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $booking->end_datetime }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Status</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ ucfirst($booking->status) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Approver 1</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">
                                                {{ optional($booking->approvals->where('level', 1)->first())->approver->name ?? '-' }}
                                                ({{ optional($booking->approvals->where('level', 1)->first())->status ?? '-' }})
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Approver 2</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">
                                                {{ optional($booking->approvals->where('level', 2)->first())->approver->name ?? '-' }}
                                                ({{ optional($booking->approvals->where('level', 2)->first())->status ?? '-' }})
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('bookings.index') }}" class="btn btn-danger"><i
                                        class="fas fa-angle-left"></i> Back</a>
                                <a type="button" href="{{ route('bookings.edit', $booking->id) }}"
                                    class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
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
