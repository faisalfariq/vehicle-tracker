@extends('layouts.app')
@section('title', 'Daftar Role Type')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Role Type</h1>
        <a href="{{ route('role-types.create') }}" class="btn btn-primary">Tambah Role Type</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roleTypes as $roleType)
            <tr>
                <td>{{ $roleType->id }}</td>
                <td>{{ $roleType->name }}</td>
                <td>
                    <a href="{{ route('role-types.show', $roleType->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('role-types.edit', $roleType->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('role-types.destroy', $roleType->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $roleTypes->links() }}
@endsection