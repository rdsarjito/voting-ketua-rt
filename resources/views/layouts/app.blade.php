<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div
        class="min-h-screen bg-gradient-to-br from-gray-50 via-emerald-50 to-teal-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header
                class="bg-gradient-to-r from-white via-emerald-50 to-teal-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-800 shadow-lg border-b border-emerald-100 dark:border-gray-700">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Real-time notification container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Real-time status indicator -->
    <div id="connection-status" class="fixed bottom-4 left-4 z-50">
        <div class="bg-gray-800 text-white px-3 py-1 rounded-full text-xs flex items-center gap-2">
            <div id="status-dot" class="w-2 h-2 bg-red-500 rounded-full"></div>
            <span id="status-text">Connecting...</span>
        </div>
    </div>

    <script>
        // Connection status indicator
        document.addEventListener('DOMContentLoaded', function () {
            const statusDot = document.getElementById('status-dot');
            const statusText = document.getElementById('status-text');

            // Check if Echo is available
            if (window.Echo) {
                statusDot.className = 'w-2 h-2 bg-green-500 rounded-full';
                statusText.textContent = 'Connected';
            } else {
                statusDot.className = 'w-2 h-2 bg-yellow-500 rounded-full';
                statusText.textContent = 'Loading...';
            }
        });
    </script>
</body>

</html>