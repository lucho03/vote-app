@extends('layouts.app')
@section('header')
    <div>
        <h1>Welcome to the National Voting System</h1>
        <p>Secure, transparent and modern digital voting. Your voice matters—make it count today.</p>
    </div>
@endsection

@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
            background: #f6f7fb;
            color: #333;
        }

        header {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)),
                        url('https://images.unsplash.com/photo-1580050536435-98fefc7f9c71?q=80&w=1200') center/cover;
            height: 65vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 20px;
        }

        header h1 {
            font-size: 3.2rem;
            margin-bottom: 15px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }

        header p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: auto;
            text-shadow: 0 2px 6px rgba(0,0,0,0.4);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .card-front {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .card-front img {
            width: 90px;
            margin-bottom: 15px;
        }

        .card-front h3 {
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .btn-container {
            text-align: center;
            margin-top: 40px;
        }

        .btn {
            background: #0066ff;
            color: white;
            padding: 15px 35px;
            font-size: 1.1rem;
            border-radius: 40px;
            text-decoration: none;
            display: inline-block;
            transition: 0.25s;
        }

        .btn:hover {
            background: #004fcc;
            transform: translateY(-2px);
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #111;
            color: #bbb;
            margin-top: 40px;
        }
    </style>
    <div class="container">
        <div class="features">

            <div class="card-front">
                <img src="{{ Vite::asset('resources/images/front-image-1.png') }}" alt="Security">
                <h3>Secure Voting</h3>
                <p>Your vote is encrypted and protected using modern cryptographic protocols.</p>
            </div>

            <div class="card-front">
                <img src="{{ Vite::asset('resources/images/front-image-2.png') }}" alt="Transparency">
                <h3>Transparent Counting</h3>
                <p>All results are processed fairly, ensuring accuracy and trustworthiness.</p>
            </div>

            <div class="card-front">
                <img src="{{ Vite::asset('resources/images/front-image-3.png') }}" alt="Accessibility">
                <h3>Easy to Use</h3>
                <p>Vote in just a few clicks from any device. No registration complexity.</p>
            </div>

        </div>

        <div class="btn-container">
            <a class="btn" href="{{ route('vote.index') }}">Go to Voting</a>
        </div>
    </div>
@endsection

@section('footer')
    <footer>
        &copy; {{ date('Y'). ' ' . config('app.name', 'Laravel') }} — All rights reserved.
    </footer>
@endsection