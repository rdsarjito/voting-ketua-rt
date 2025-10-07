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
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <div class="flex">
                <aside class="w-64 bg-white dark:bg-gray-800 min-h-screen p-4 hidden md:block">
                    <div class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="block text-gray-700 dark:text-gray-200">Dashboard</a>
                        <a href="{{ route('vote.categories') }}" class="block text-gray-700 dark:text-gray-200">Kategori Voting</a>
                        @auth
                        @if(auth()->user()->role === 'admin')
                        <hr class="my-2 border-gray-600" />
                        <a href="{{ route('admin.categories.index') }}" class="block text-gray-700 dark:text-gray-200">Kelola Kategori</a>
                        <a href="{{ route('admin.candidates.index') }}" class="block text-gray-700 dark:text-gray-200">Kelola Kandidat</a>
                        <a href="{{ route('admin.results') }}" class="block text-gray-700 dark:text-gray-200">Hasil Voting</a>
                        @endif
                        @endauth
                    </div>
                </aside>

                <div class="flex-1">
                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white dark:bg-gray-800 shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main class="p-4">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
