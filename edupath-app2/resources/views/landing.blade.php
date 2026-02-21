<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to Baganga Online Enrollment</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        // Try multiple possible image paths (similar to guest layout)
        $candidates = [
            'images/dorsu-logo.png',
            'images/dorsu-logo.webp',
            'images/dorsu-logo.jpg',
            'images/baganga-building.jpg',
            'images/baganga-building.png',
            'images/building.jpg',
            'images/building.png',
            'dorsu-logo.png',
            'dorsu-logo.webp',
            'dorsu-logo.jpg',
            'logo.png',
            'logo.jpg'
        ];
        $bgLogo = null;
        foreach ($candidates as $c) {
            if (file_exists(public_path($c))) {
                $bgLogo = asset($c);
                break;
            }
        }
        if (!$bgLogo && is_dir(public_path('images'))) {
            $any = glob(public_path('images/*.{png,PNG,webp,jpg,jpeg,JPG,JPEG,gif}'), GLOB_BRACE);
            if (!empty($any)) {
                $bgLogo = asset('images/'.basename($any[0]));
            }
        }
    @endphp

    <style>
        .landing-hero {
            min-height: 100vh;
            background: linear-gradient(to-br, #dbeafe 0%, #ffffff 50%, #dbeafe 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .landing-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            @if($bgLogo)
            background-image: url('{{ $bgLogo }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            @endif
            z-index: 0;
        }

        .landing-hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 1;
        }

        .landing-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #1f2937;
            padding: 2rem;
        }

        .welcome-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1f2937;
            animation: fadeInUp 1s ease-out;
        }

        .welcome-subtitle {
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 2rem;
            color: #4b5563;
            animation: fadeInUp 1s ease-out 0.3s;
            animation-fill-mode: both;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
            animation: fadeInUp 1s ease-out 0.6s;
            animation-fill-mode: both;
        }

        .nav-button {
            padding: 0.75rem 2rem;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            color: #1f2937;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-button:hover {
            background:rgb(21, 83, 206);
            border-color:rgb(166, 176, 170);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(193, 16, 16, 0.15);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .welcome-title {
                font-size: 2.5rem;
            }
            .welcome-subtitle {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="landing-hero">
        <div class="landing-content">
            <h1 class="welcome-title">Welcome to Baganga Extention Campus</h1>
            <h2 class="welcome-subtitle">Online Enrollment System</h2>
            
            <div class="nav-links">
                <a href="{{ route('career.index') }}" class="nav-button">Click View </a>
            </div>
        </div>
    </div>
</body>
</html>

