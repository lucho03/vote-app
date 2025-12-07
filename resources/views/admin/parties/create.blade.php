@extends('layouts.admin')
@section('content')
    <h2 class="text-3xl font-bold mb-6">Add New Party</h2>
    <form action="{{ route('admin.parties.store') }}" method="POST"
        class="bg-white shadow rounded-lg p-6 max-w-xl">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Name</label>
            <input type="text" name="name" required
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300"
                value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Reference Number</label>
            <input type="number" name="reference_number" required
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300"
                value="{{ old('reference_number') }}">
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Create Party
        </button>
    </form>
@endsection
