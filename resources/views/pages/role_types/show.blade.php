@extends('layouts.app')
@section('title', 'Detail Role Type')
@section('content')
    <h1>Detail Role Type</h1>
    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $roleType->id }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $roleType->name }}</td>
        </tr>
    </table>
    <a href="{{ route('role-types.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('role-types.edit', $roleType->id) }}" class="btn btn-warning">Edit</a>
@endsection