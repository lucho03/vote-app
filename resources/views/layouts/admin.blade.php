<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Laravel') }} Admin Panel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-100 text-gray-800">
        <nav class="bg-white shadow-md mb-6">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Admin Panel</h1>

                <a href="{{ route('admin.parties.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold">
                    Parties
                </a>

                <a href="{{ route('admin.candidates.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold">
                    Candidates
                </a>

                <a href="{{ route('admin.people.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold">
                    People
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <main class="container mx-auto px-6">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </body>
</html>
