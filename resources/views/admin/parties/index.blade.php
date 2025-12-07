@extends('layouts.admin')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Parties</h2>

        <a href="{{ route('admin.parties.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add Party
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <th class="py-3 px-4">Party</th>
                    <th class="py-3 px-4">Reference</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($parties as $party)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $party->name }}</td>
                        <td class="py-3 px-4">{{ $party->reference_number }}</td>

                        <td class="py-3 px-4 text-right space-x-2">
                            <a href="{{ route('admin.parties.edit', $party) }}"
                            class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>

                            <form action="{{ route('admin.parties.destroy', $party) }}"
                                method="POST" class="inline-block"
                                onsubmit="return confirm('Delete this party?')">
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