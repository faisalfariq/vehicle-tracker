@extends('layouts.app')

@section('title', 'Booking List')

@push('style')
    <!-- CSS Libraries -->

    {{-- <link rel="stylesheet" href="{{ asset('css/custom_css/pages/bookings/bookings_index.css') }}"> --}}
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Bookings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Booking List</a></div>
                    <div class="breadcrumb-item">Data Bookings</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Booking List</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="{{ route('bookings.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i>
                                        Add New</a>
                                </div>
                                <div class="float-right">
                                    <form action="{{ route('bookings.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword"
                                                placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div id="userTableList">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    <th>Booking Code</th>
                                                    <th>Employee</th>
                                                    <th>Vehicle</th>
                                                    <th>Driver</th>
                                                    <th>Destination</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bookings_list">
                                                @foreach ($bookings as $booking)
                                                    <tr>
                                                        <td>
                                                            {{ $booking->code ?? '-' }}
                                                        </td>
                                                        <td>
                                                            {{ $booking->user->name ?? '-' }}
                                                        </td>
                                                        <td>{{ $booking->vehicle->name ?? '-' }}</td>
                                                        <td>{{ $booking->driver->name ?? '-' }}</td>
                                                        <td>{{ $booking->destination }}</td>
                                                        <td>{{ $booking->start_datetime }}</td>
                                                        <td>{{ $booking->end_datetime }}</td>
                                                        <td>{{ ucfirst($booking->status) }}</td>
                                                        <td>
                                                            <a href="{{ route('bookings.show', $booking->id) }}"
                                                                class="btn btn-info btn-sm">Detail</a>
                                                            <a href="{{ route('bookings.edit', $booking->id) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm btn-delete-booking"
                                                                data-id="{{ $booking->id }}">
                                                                Hapus
                                                            </button>
                                                            {{-- <form action="{{ route('bookings.destroy', $booking->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf @method('DELETE')
                                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $bookings->links() }}
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
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script src="{{ asset('js/custom_js/pages/bookings/bookings_index.js') }}"></script>
@endpush
