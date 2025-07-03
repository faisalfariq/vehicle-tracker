@extends('layouts.app')
@section('title', 'Edit Role Type')
@section('content')
    <h1>Edit Role Type</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('role-types.update', $roleType->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $roleType->name) }}" required>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('role-types.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection