@extends('layouts.app')

@section('title', 'Detail Setting')

@push('style')
    <!-- CSS Libraries -->
    <style>
         .table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
         padding: 0 25px;
         height: 35px;
         vertical-align: middle;
     }
     </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Settings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Settings</a></div>
                    <div class="breadcrumb-item">Detail a Setting</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Detail a Setting</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td width="200" class="text-primary font-weight-bold">
                                                        <i class="fas fa-id-card"></i> ID
                                                    </td>
                                                    <td width="50" class="text-center">:</td>
                                                    <td>{{ $setting->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-key"></i> Key
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $setting->key }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-value"></i> Value
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $setting->value }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('settings.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                <a type="button" href="{{ route('settings.edit', $setting->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush