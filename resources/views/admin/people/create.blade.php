@extends('layouts.admin')
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.people.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Personal ID</label>
            <input type="text" name="personal_id" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" required>
        </div>

        <button class="btn btn-primary">Create Person</button>
    </form>
</div>
@endsection
