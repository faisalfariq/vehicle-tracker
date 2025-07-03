@extends('layouts.app')

@section('title', 'Edit Setting')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Settings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Settings</a></div>
                    <div class="breadcrumb-item">Edit a Setting</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Edit Setting</h2>
                            </div>
                            <form action="{{ route('settings.update', $setting->id) }}" id="form_edit_setting" method="POST">
                                @csrf @method('PUT')
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Key</label>
                                            <input type="text" class="form-control" name="key" value="{{ old('key', $setting->key) }}">
                                            <div class="invalid-feedback key_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Value</label>
                                            <input type="text" class="form-control" name="value" value="{{ old('value', $setting->value) }}">
                                            <div class="invalid-feedback value_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('settings.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
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
    <script src="{{ asset('js/custom_js/pages/settings/settings_edit.js') }}"></script>
@endpush