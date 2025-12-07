@extends('layouts.admin')
@section('content')
    <h2 class="text-3xl font-bold mb-6">Add New Candidate</h2>
    <form action="{{ route('admin.candidates.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 max-w-xl">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Name</label>
            <input type="text" name="name" required
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300"
                value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Party</label>
            <select name="party_id" class="form-select">
                <option value="">Select Party</option>

                @foreach ($parties as $party)
                    <option value="{{ $party->id }}" {{ old('party_id') == $party->id ? 'selected' : '' }}>
                        {{ $party->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Reference Number</label>
            <input type="number" name="reference_number" required
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300"
                value="{{ old('reference_number') }}">
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Create Candidate
        </button>
    </form>
@endsection
