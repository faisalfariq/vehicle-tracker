@extends('layouts.app')

@section('title', 'Edit Region')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Regions</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Regions</a></div>
                    <div class="breadcrumb-item">Edit Region</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Edit Region</h2>
                            </div>
                            <form action="{{ route('regions.update', $region->id) }}" id="form_edit_region" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $region->name) }}">
                                            <div class="invalid-feedback name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Type</label>
                                            <select name="type" class="form-control select2">
                                                <option value="">Pilih</option>
                                                <option value="pusat" @if($region->type=='pusat') selected @endif>Pusat</option>
                                                <option value="cabang" @if($region->type=='cabang') selected @endif>Cabang</option>
                                                <option value="tambang" @if($region->type=='tambang') selected @endif>Tambang</option>
                                            </select>
                                            <div class="invalid-feedback type_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-primary">Address</label>
                                            <input type="text" class="form-control" name="address" value="{{ old('address', $region->address) }}">
                                            <div class="invalid-feedback address_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('regions.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom_js/pages/regions/regions_edit.js') }}"></script>
@endpush