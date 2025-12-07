@extends('layouts.admin')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">People</h2>

        <a href="{{ route('admin.people.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add Person
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Address</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($people as $person)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $person->name }}</td>
                        <td class="py-3 px-4">{{ $person->address }}</td>

                        <td class="py-3 px-4 text-right space-x-2">
                            <form action="{{ route('admin.people.destroy', $person) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this person?')">
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