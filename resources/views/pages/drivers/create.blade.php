@extends('layouts.app')

@section('title', 'Create Driver')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Drivers</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Drivers</a></div>
                    <div class="breadcrumb-item">Create a Driver</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Create New Driver</h2>
                            </div>
                            <form action="#" id="form_add_driver" method="POST">
                                @csrf
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Name</label>
                                            <input type="text" class="form-control" name="name">
                                            <div class="invalid-feedback name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">License Number</label>
                                            <input type="text" class="form-control" name="license_number">
                                            <div class="invalid-feedback license_number_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Phone</label>
                                            <input type="text" class="form-control" name="phone">
                                            <div class="invalid-feedback phone_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Region</label>
                                            <select class="form-control select2" name="region_id">
                                                <option value="">-</option>
                                                @foreach($regions as $region)
                                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback region_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Status</label>
                                            <select class="form-control" name="is_active">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <div class="invalid-feedback is_active_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('drivers.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
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
    <script src="{{ asset('js/custom_js/pages/drivers/drivers_create.js') }}"></script>
@endpush