@extends('layouts.app')

@section('title', 'Booking Log List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Booking Logs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Booking Log List</a></div>
                    <div class="breadcrumb-item">Data Booking Logs</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Booking Log List</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="{{ route('booking-logs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                                <div class="float-right">
                                    <form action="{{ route('booking-logs.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div id="bookingLogTableList">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Booking</th>
                                                    <th>Event</th>
                                                    <th>Datetime</th>
                                                    <th>Odometer</th>
                                                    <th>Notes</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="booking_logs_list">
                                                @foreach($logs as $log)
                                                <tr>
                                                    <td>{{ $log->id }}</td>
                                                    <td>{{ $log->booking->destination ?? '-' }}</td>
                                                    <td>{{ ucfirst($log->event) }}</td>
                                                    <td>{{ $log->datetime }}</td>
                                                    <td>{{ $log->odometer }}</td>
                                                    <td>{{ $log->notes }}</td>
                                                    <td>
                                                        <a href="{{ route('booking-logs.show', $log->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                        <a href="{{ route('booking-logs.edit', $log->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <button type="button" class="btn btn-danger btn-sm btn-delete-booking-log" data-id="{{ $log->id }}">Hapus</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $logs->links() }}
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
    <script src="{{ asset('js/custom_js/pages/booking_logs/booking_logs_index.js') }}"></script>
@endpush