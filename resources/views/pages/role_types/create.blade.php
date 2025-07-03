@extends('layouts.app')
@section('title', 'Tambah Role Type')
@section('content')
    <h1>Tambah Role Type</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('role-types.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('role-types.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection