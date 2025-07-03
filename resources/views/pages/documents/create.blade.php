@extends('layouts.app')

@section('title', 'Create Document')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Documents</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Documents</a></div>
                    <div class="breadcrumb-item">Create a Document</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Create New Document</h2>
                            </div>
                            <form action="#" id="form_add_document" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Booking</label>
                                            <select class="form-control select2" name="booking_id">
                                                <option value="">Pilih</option>
                                                @foreach($bookings as $booking)
                                                    <option value="{{ $booking->id }}">{{ $booking->destination }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback booking_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">File</label>
                                            <input type="file" class="form-control" name="file">
                                            <small class="text-muted">Format: pdf, jpg, jpeg, png, doc, docx, xls, xlsx. Maks 2MB.</small>
                                            <div class="invalid-feedback file_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('documents.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
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
    <script src="{{ asset('js/custom_js/pages/documents/documents_create.js') }}"></script>
@endpush