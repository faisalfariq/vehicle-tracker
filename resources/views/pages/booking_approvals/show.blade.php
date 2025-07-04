@extends('layouts.app')

@section('title', 'Detail Booking Approval')

@push('style')
    <!-- CSS Libraries -->
    <style>
         .table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
         padding: 0 25px;
         height: 35px;
         vertical-align: middle;
     }
     </style>
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
                            <div class="card-body">
                                <div class="float-right mt-2">
                                    <a type="button" href="#" class="btn btn-info"><i class="fas fa-paper-plane"></i> Submit</a>
                                    <a type="button" href="#" class="btn btn-danger"><i class="fas fa-times"></i> Reject</a>
                                    <a type="button" href="#" class="btn btn-primary"><i class="fas fa-check"></i> Approve</a>
                                    <a type="button" href="#" class="btn btn-info"><i class="fas fa-car"></i> Used</a>
                                    <a type="button" href="#" class="btn btn-success"><i class="fas fa-flag-checkered"></i> Finish</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td width="200" class="text-primary font-weight-bold">
                                                        <i class="fas fa-id-card"></i> ID
                                                    </td>
                                                    <td width="50" class="text-center">:</td>
                                                    <td>{{ $approval->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-calendar-check"></i> Booking
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $approval->booking->destination ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-user-check"></i> Approver
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $approval->approver->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-layer-group"></i> Level
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $approval->level }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-info-circle"></i> Status
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>
                                                        @if($approval->status == 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($approval->status == 'approved')
                                                            <span class="badge badge-success">Approved</span>
                                                        @elseif($approval->status == 'rejected')
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @else
                                                            <span class="badge badge-light">{{ ucfirst($approval->status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-comment"></i> Note
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $approval->note }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-clock"></i> Approved At
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $approval->approved_at }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
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