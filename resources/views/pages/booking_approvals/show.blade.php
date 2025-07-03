@extends('layouts.app')

@section('title', 'Detail Booking Approval')

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
                    <div class="breadcrumb-item">Detail a Booking Approval</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Detail a Booking Approval</h2>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">ID</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $approval->id }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Booking</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $approval->booking->destination ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Approver</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $approval->approver->name ?? '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Level</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $approval->level }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Status</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ ucfirst($approval->status) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Note</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $approval->note }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-primary">Approved At</label>
                                        <div class="col-md-8">
                                            <label class="custom-switch-description">{{ $approval->approved_at }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('booking-approvals.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                <a type="button" href="{{ route('booking-approvals.edit', $approval->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush