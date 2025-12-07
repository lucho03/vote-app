@extends('layouts.admin')
@section('content')
    <h2 class="text-3xl font-bold mb-6">Edit Candidate</h2>
    <form action="{{ route('admin.candidates.update', $candidate) }}" method="POST"
        class="bg-white shadow rounded-lg p-6 max-w-xl">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Name</label>
            <input type="text" name="name" required
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300"
                value="{{ old('name', $candidate->name) }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Party</label>
            <select name="party_id" class="form-select">
                @foreach ($parties as $party)
                    <option value="{{ $party->id }}" 
                        {{ (old('party_id', $candidate->party_id) == $party->id) ? 'selected' : '' }}>
                        {{ $party->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Reference Number</label>
            <input type="number" name="reference_number" required
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300"
                value="{{ old('reference_number', $candidate->reference_number) }}">
        </div>

        <button class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
            Update Candidate
        </button>
    </form>
@endsection
