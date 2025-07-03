@extends('layouts.app')

@section('title', 'Edit Booking Approval')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Booking Approvals</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Booking Approvals</a></div>
                    <div class="breadcrumb-item">Edit a Booking Approval</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Edit Booking Approval</h2>
                            </div>
                            <form action="{{ route('booking-approvals.update', $approval->id) }}" id="form_edit_booking_approval" method="POST">
                                @csrf @method('PUT')
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="pending" @if($approval->status == 'pending') selected @endif>Pending</option>
                                                <option value="approved" @if($approval->status == 'approved') selected @endif>Approved</option>
                                                <option value="rejected" @if($approval->status == 'rejected') selected @endif>Rejected</option>
                                            </select>
                                            <div class="invalid-feedback status_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Note</label>
                                            <textarea class="form-control" name="note">{{ old('note', $approval->note) }}</textarea>
                                            <div class="invalid-feedback note_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('booking-approvals.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
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
    <script src="{{ asset('js/custom_js/pages/booking_approvals/booking_approvals_edit.js') }}"></script>
@endpush