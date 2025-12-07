@extends('layouts.app')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Election Summary</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Votes by Party</h3>
            
            <div style="height:400px; width:100%;">
                <canvas id="partyChart"></canvas>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Detailed table</h3>

            <table class="w-full text-left">
                <thead>
                    <tr class="text-sm text-gray-600 uppercase">
                        <th class="py-2">Party</th>
                        <th class="py-2 text-right">Votes</th>
                    </tr>
                </thead>
                <tbody id="summary-table-body">
                    @foreach($partyCounts as $row)
                        <tr class="border-t">
                            <td class="py-2">{{ $row['party'] }}</td>
                            <td class="py-2 text-right font-semibold">{{ $row['votes'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex space-x-2">
                <form method="GET" action="{{ route('summary.index') }}">
                    <button class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">Reload</button>
                </form>

                <button id="exportCsv"
                        class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Export CSV
                </button>
            </div>
        </div>
    </div>
@endsection

<script>
    window.partyCounts = @json($partyCounts);
</script>
@push('scripts')
    @vite('resources/js/summary.js')
@endpush