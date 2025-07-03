@extends('layouts.app')

@section('title', 'Edit Role')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Roles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Roles</a></div>
                    <div class="breadcrumb-item">Edit Role</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Edit Role</h2>
                            </div>
                            <form action="{{ route('roles.update', $role->id) }}" id="form_edit_role" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Role Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $role->name) }}">
                                            <div class="invalid-feedback name_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('roles.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
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
    <script src="{{ asset('js/custom_js/pages/roles/roles_edit.js') }}"></script>
@endpush
