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
    <body class="font-sans antialiased text-slate-300 bg-slate-900 min-h-screen selection:bg-indigo-500 selection:text-white">
        <!-- Dashboard Background Blurs -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-500/10 blur-[120px]"></div>
            <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-purple-500/10 blur-[120px]"></div>
        </div>

        <div class="flex h-screen overflow-hidden">
            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col relative overflow-y-auto overflow-x-hidden">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-slate-800/60 backdrop-blur-2xl border-b border-slate-700/50 shadow-sm sticky top-0 z-40">
                        <div class="max-w-7xl mx-auto py-6 px-8 sm:px-10 lg:px-12 flex items-center justify-between">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 w-full max-w-7xl mx-auto p-6 sm:p-10 lg:p-12">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
