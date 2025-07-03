@extends('layouts.app')

@section('title', 'Settings List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">Data Settings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Settings List</a></div>
                    <div class="breadcrumb-item">Data Settings</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Settings List</h2>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="{{ route('settings.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                                </div>
                                <div class="float-right">
                                    <form action="{{ route('settings.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div id="settingsTableList">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Key</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="settings_list">
                                                @foreach($settings as $setting)
                                                <tr>
                                                    <td>{{ $setting->id }}</td>
                                                    <td>{{ $setting->key }}</td>
                                                    <td>{{ $setting->value }}</td>
                                                    <td>
                                                        <a href="{{ route('settings.show', $setting->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                        <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <button type="button" class="btn btn-danger btn-sm btn-delete-setting" data-id="{{ $setting->id }}">Hapus</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right" id="pagination">
                                        {{ $settings->links() }}
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
    <script src="{{ asset('js/custom_js/pages/settings/settings_index.js') }}"></script>
@endpush