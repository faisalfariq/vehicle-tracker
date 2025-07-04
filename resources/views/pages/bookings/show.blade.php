@extends('layouts.app')

@section('title', 'Detail Booking')

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
                                <h2 class="section-title text-primary m-0">Detail a Booking</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-right mt-2">
                                    @if($booking->status == 'draft')
                                        <form action="{{ route('bookings.submit', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-submit" data-type="submit"><i class="fas fa-paper-plane"></i> Submit</button>
                                        </form>
                                    @elseif($booking->status == 'pending')
                                        @php
                                            $currentUser = Auth::user();
                                            $userApproval = $booking->approvals()->where('approver_id', $currentUser->id)->first();
                                        @endphp

                                        @if($userApproval && $userApproval->status == 'pending')
                                            <div class="d-inline-block mr-2">
                                                <form action="{{ route('bookings.reject', $booking->id) }}" method="POST" id="rejectForm">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm btn-reject" data-type="reject">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                        </div>
                                            <div class="d-inline-block">
                                                <form action="{{ route('bookings.approve', $booking->id) }}" method="POST" id="approveForm">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm btn-approve" data-type="approve">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                    </div>
                                        @elseif($userApproval && $userApproval->status != 'pending')
                                            <span class="badge badge-info">You have already {{ $userApproval->status }} this booking</span>
                                        @elseif(Auth::user() && Auth::user()->role == 'admin')
                                            <span class="badge badge-secondary">You are admin, waiting for approver action</span>
                                        @else
                                            <span class="badge badge-secondary">You are not an approver for this booking</span>
                                        @endif
                                    @elseif($booking->status == 'approved' && Auth::user() && Auth::user()->role && Auth::user()->role->name == 'admin')
                                        <form action="{{ route('bookings.used', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-used" data-type="used"><i class="fas fa-car"></i> Used</button>
                                        </form>
                                    @elseif($booking->status == 'onuse')
                                        <form action="{{ route('bookings.finish', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-finish" data-type="finish"><i class="fas fa-flag-checkered"></i> Finish</button>
                                        </form>
                                    @endif
                                </div>
                                        </div>
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-md-8">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td width="200" class="text-primary font-weight-bold">
                                                        <i class="fas fa-hashtag"></i> Booking Code
                                                    </td>
                                                    <td width="50" class="text-center">:</td>
                                                    <td id="booking_code">{{ $booking->code }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-user"></i> Employee
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $booking->user->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-car"></i> Vehicle
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $booking->vehicle->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-user-tie"></i> Driver
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $booking->driver->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-map-marker-alt"></i> Destination
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $booking->destination }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-comment"></i> Reason
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $booking->reason ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-calendar-plus"></i> Start Date
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $booking->start_datetime }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-calendar-minus"></i> End Date
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $booking->end_datetime }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-info-circle"></i> Status
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>
                                                        @if($booking->status == 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($booking->status == 'approved')
                                                            <span class="badge badge-success">Approved</span>
                                                        @elseif($booking->status == 'rejected')
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @elseif($booking->status == 'completed')
                                                            <span class="badge badge-info">Completed</span>
                                                        @elseif($booking->status == 'cancelled')
                                                            <span class="badge badge-secondary">Cancelled</span>
                                                        @else
                                                            <span class="badge badge-light">{{ ucfirst($booking->status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-user-check"></i> Approver 1
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>
                                                {{ optional($booking->approvals->where('level', 1)->first())->approver->name ?? '-' }}
                                                        @if(optional($booking->approvals->where('level', 1)->first())->status)
                                                            @if(optional($booking->approvals->where('level', 1)->first())->status == 'approved')
                                                                <span class="badge badge-success ml-2">Approved</span>
                                                            @elseif(optional($booking->approvals->where('level', 1)->first())->status == 'rejected')
                                                                <span class="badge badge-danger ml-2">Rejected</span>
                                                            @elseif(optional($booking->approvals->where('level', 1)->first())->status == 'pending')
                                                                <span class="badge badge-warning ml-2">Pending</span>
                                                            @else
                                                                <span class="badge badge-light ml-2">{{ ucfirst(optional($booking->approvals->where('level', 1)->first())->status) }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-user-shield"></i> Approver 2
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>
                                                {{ optional($booking->approvals->where('level', 2)->first())->approver->name ?? '-' }}
                                                        @if(optional($booking->approvals->where('level', 2)->first())->status)
                                                            @if(optional($booking->approvals->where('level', 2)->first())->status == 'approved')
                                                                <span class="badge badge-success ml-2">Approved</span>
                                                            @elseif(optional($booking->approvals->where('level', 2)->first())->status == 'rejected')
                                                                <span class="badge badge-danger ml-2">Rejected</span>
                                                            @elseif(optional($booking->approvals->where('level', 2)->first())->status == 'pending')
                                                                <span class="badge badge-warning ml-2">Pending</span>
                                                            @else
                                                                <span class="badge badge-light ml-2">{{ ucfirst(optional($booking->approvals->where('level', 2)->first())->status) }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('bookings.index') }}" class="btn btn-danger"><i
                                        class="fas fa-angle-left"></i> Back</a>
                                @if($booking->status === 'draft')
                                <a type="button" href="{{ route('bookings.edit', $booking->id) }}"
                                    class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('js/custom_js/pages/bookings/bookings_show.js') }}"></script>
@endpush
