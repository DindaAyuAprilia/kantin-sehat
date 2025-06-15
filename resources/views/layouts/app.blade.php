<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Page Title -->
        <title>{{ config('Kantin Sehat', 'Kantin Sehat') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- SweetAlert CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <!-- Loading Animation Styles -->
        <style>
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 10000;
                flex: 0 0 auto;
                display: flex;
                width: 100%;
                height: 100%;
                align-items: center;
                justify-content: center;
                background: rgba(0, 112, 34, 0.3);
                transition: opacity 0.3s ease;
            }
            .loading-overlay.hidden {
                opacity: 0;
                pointer-events: none;
            }
            .spinner {
                width: 50px;
                height: 50px;
                border: 5px solid #e0e0e0;
                border-top: 5px solid #007022;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .content-hidden {
                display: none;
            }
            .content-visible {
                display: flex;
            }
            /* Main Content Padding */
            .main-content {
                padding-top: 1rem;
            }
            @media (min-width: 640px) {
                .main-content {
                    padding-top: 1rem;
                }
            }
        </style>
    </head>
    <body class="antialiased font-sans">
        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="spinner"></div>
        </div>

        <!-- Main Content -->
        <div class="relative flex min-h-screen flex-col content-hidden" id="mainContent">
            <!-- Background Overlay -->
            <div class="absolute inset-0 bg-theme-primary bg-opacity-30 z-10"></div>

            <!-- Navigation -->
            <div class="relative z-20">
                @include('layouts.navigation')
            </div>

            <!-- Page Content -->
            <main class="relative z-10 flex-1 main-content">
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
        @stack('scripts')
    </body>
</html>