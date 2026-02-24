<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Chamaí - Organizar festas nunca foi tão fácil</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="antialiased text-slate-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50">
            <div class="mb-8 text-center">
                <a href="/" class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 bg-indigo-600 rounded-[1.5rem] flex items-center justify-center shadow-xl shadow-indigo-200 rotate-3 hover:rotate-0 transition-transform duration-300">
                        <i class="fa-solid fa-rocket text-white text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-black tracking-tighter text-slate-800 mt-2">Chama<span class="text-indigo-600">í</span></h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden sm:rounded-[3rem]">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-slate-400 text-xs font-bold uppercase tracking-widest">
                © 2026 Chamaí • Seu evento decola aqui
            </p>
        </div>
    </body>
</html>