@extends('layouts.app')

@section('title', 'Booking Approval List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Booking Approvals</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Booking Approval List</a></div>
                    <div class="breadcrumb-item">Data Booking Approvals</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Booking Approval List</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="{{ route('booking-approvals.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                                <div class="float-right">
                                    <form action="{{ route('booking-approvals.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div id="bookingApprovalTableList">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Booking</th>
                                                    <th>Approver</th>
                                                    <th>Level</th>
                                                    <th>Status</th>
                                                    <th>Note</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="booking_approvals_list">
                                                @foreach($approvals as $approval)
                                                <tr>
                                                    <td>{{ $approval->id }}</td>
                                                    <td>{{ $approval->booking->destination ?? '-' }}</td>
                                                    <td>{{ $approval->approver->name ?? '-' }}</td>
                                                    <td>{{ $approval->level }}</td>
                                                    <td>{{ ucfirst($approval->status) }}</td>
                                                    <td>{{ $approval->note }}</td>
                                                    <td>
                                                        <a href="{{ route('booking-approvals.show', $approval->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                        <a href="{{ route('booking-approvals.edit', $approval->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <button type="button" class="btn btn-danger btn-sm btn-delete-booking-approval" data-id="{{ $approval->id }}">Hapus</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $approvals->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom_js/pages/booking_approvals/booking_approvals_index.js') }}"></script>
@endpush