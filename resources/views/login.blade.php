@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center h-screen">
        <form method="POST" action="{{ route('login.perform') }}"
            class="bg-white shadow p-8 rounded-lg w-full max-w-sm">
            
            @csrf

            <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>

            @if ($errors->any())
                <div class="mb-4 text-red-600">{{ $errors->first() }}</div>
            @endif

            <label class="block mb-2 font-semibold">Email</label>
            <input type="email" name="email" required
                class="w-full border px-3 py-2 rounded-lg mb-4">

            <label class="block mb-2 font-semibold">Password</label>
            <input type="password" name="password" required
                class="w-full border px-3 py-2 rounded-lg mb-6">

            <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                Login
            </button>
        </form>
    </div>
@endsection