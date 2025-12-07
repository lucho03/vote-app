@extends('layouts.admin')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Candidates</h2>

        <a href="{{ route('admin.candidates.create') }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            + Add Candidate
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Party</th>
                    <th class="py-3 px-4">Reference #</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($candidates as $candidate)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $candidate->name }}</td>
                        <td>{{ $candidate->party->name ?? 'No party' }}</td>
                        <td class="py-3 px-4">{{ $candidate->reference_number }}</td>

                        <td class="py-3 px-4 text-right space-x-2">
                            <a href="{{ route('admin.candidates.edit', $candidate) }}"
                            class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>

                            <form action="{{ route('admin.candidates.destroy', $candidate) }}"
                                method="POST" class="inline-block"
                                onsubmit="return confirm('Delete this candidate?')">
                                @csrf
                                @method('DELETE')

                                <button class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
