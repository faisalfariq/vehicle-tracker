@extends('layouts.app')

@section('title', 'Documents List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Documents</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Documents List</a></div>
                    <div class="breadcrumb-item">Data Documents</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Documents List</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="{{ route('documents.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                                <div class="float-right">
                                    <form action="{{ route('documents.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div id="documentsTableList">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Booking</th>
                                                    <th>File</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="documents_list">
                                                @foreach($documents as $document)
                                                <tr>
                                                    <td>{{ $document->id }}</td>
                                                    <td>{{ $document->booking->destination ?? '-' }}</td>
                                                    <td>
                                                        @if($document->file_path)
                                                            <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank">Lihat File</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('documents.show', $document->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                        <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <button type="button" class="btn btn-danger btn-sm btn-delete-document" data-id="{{ $document->id }}">Hapus</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $documents->links() }}
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
    <script src="{{ asset('js/custom_js/pages/documents/documents_index.js') }}"></script>
@endpush