@extends('layouts.app')

@section('title', 'Create Vehicle')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Vehicles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Vehicles</a></div>
                    <div class="breadcrumb-item">Create a Vehicle</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Form Create New Vehicle</h2>
                            </div>
                            <form action="#" id="form_add_vehicle" method="POST">
                                @csrf
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Nama</label>
                                            <input type="text" class="form-control" name="name">
                                            <div class="invalid-feedback name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">No Polisi</label>
                                            <input type="text" class="form-control" name="plate_number">
                                            <div class="invalid-feedback plate_number_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Tipe</label>
                                            <select name="type_id" class="form-control select2">
                                                <option value="">Pilih</option>
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback type_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">BBM</label>
                                            <input type="text" class="form-control" name="fuel_type">
                                            <div class="invalid-feedback fuel_type_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Region</label>
                                            <select name="region_id" class="form-control select2">
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
                                            <select name="is_available" class="form-control select2">
                                                <option value="1">Tersedia</option>
                                                <option value="0">Tidak Tersedia</option>
                                            </select>
                                            <div class="invalid-feedback is_available_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-primary">Kendaraan Disewa?</label>
                                            <select name="is_rented" class="form-control select2">
                                                <option value="0">Milik Sendiri</option>
                                                <option value="1">Disewa</option>
                                            </select>
                                            <div class="invalid-feedback is_rented_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a type="button" href="{{ route('vehicles.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
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
    <script src="{{ asset('js/custom_js/pages/vehicles/vehicles_create.js') }}"></script>
@endpush