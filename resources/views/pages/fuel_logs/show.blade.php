@extends('layouts.app')
@section('title', 'Fuel Log Detail')

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
                <h1 class="text-primary">Fuel Logs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Fuel Logs</a></div>
                    <div class="breadcrumb-item">Fuel Log Detail</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="section-title text-primary m-0">Fuel Log Detail</h2>
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
                                                    <td>{{ $fuelLog->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-car"></i> Vehicle
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $fuelLog->vehicle->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-calendar-check"></i> Booking
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $fuelLog->booking->destination ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-calendar"></i> Date
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $fuelLog->date }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-gas-pump"></i> Fuel Amount
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $fuelLog->fuel_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-money-bill"></i> Fuel Cost
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $fuelLog->fuel_cost }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-tachometer-alt"></i> KM Before
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $fuelLog->km_before }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-primary font-weight-bold">
                                                        <i class="fas fa-tachometer-alt"></i> KM After
                                                    </td>
                                                    <td class="text-center">:</td>
                                                    <td>{{ $fuelLog->km_after }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a type="button" href="{{ route('fuel-logs.index') }}" class="btn btn-danger"><i class="fas fa-angle-left"></i> Back</a>
                                <a type="button" href="{{ route('fuel-logs.edit', $fuelLog->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush