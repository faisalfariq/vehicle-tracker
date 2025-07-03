@extends('layouts.app')

@section('title', 'Edit User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Users</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Users</a></div>
                    <div class="breadcrumb-item">Edit a User</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Edit User</h2>
                            </div>
                            <form action="{{ route('users.update', $user->id) }}" id="form_edit_user" method="POST">
                                @csrf
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                                            <div class="invalid-feedback name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                                            <div class="invalid-feedback email_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Password <small>(Leave blank if not changing)</small></label>
                                            <input type="password" class="form-control" name="password">
                                            <div class="invalid-feedback password_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Role</label>
                                            <select class="form-control select2" name="role_id">
                                                <option value="">Pilih</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback role_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Status</label>
                                            <select class="form-control" name="is_active">
                                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <div class="invalid-feedback is_active_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('users.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
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
    <script src="{{ asset('js/custom_js/pages/user/user_edit.js') }}"></script>
@endpush 