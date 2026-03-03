

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chamaí') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">

@php
    $activeEvent = $event ?? request()->route('event');
@endphp

<div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

    <!-- OVERLAY MOBILE -->
    <div 
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition.opacity
        class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
    ></div>

    <!-- SIDEBAR -->
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-100 flex flex-col transform transition-transform duration-300 ease-in-out lg:static lg:translate-x-0"
    >

        <div class="flex flex-col h-full p-8">

            <!-- BOTÃO FECHAR MOBILE -->
            <button 
                @click="sidebarOpen = false" 
                class="lg:hidden absolute top-6 right-6 text-slate-400 hover:text-indigo-600"
            >
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>

            <!-- LOGO -->
            <div class="flex items-center gap-3 mb-12">
                <div class="w-12 h-12 bg-indigo-600 rounded-md flex items-center justify-center text-white shadow-xl">
                    <i class="fa-solid fa-bolt-lightning text-xl"></i>
                </div>
                <div>
                    <span class="font-black text-[36px] tracking-tighter text-slate-800 block leading-none">
                        Chama<span class="text-indigo-600">í</span>
                    </span>
                    
                    <span class="text-[12px] font-bold text-slate-400 uppercase tracking-widest">
                       Eventos & Festas
                    </span>
                </div>
            </div>

            <!-- MENU -->
            <nav class="space-y-3 flex-1 overflow-y-auto">

                <!-- DASHBOARD -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-md transition-all
                   {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i class="fa-solid fa-house text-lg"></i>
                    <span class="font-black text-sm uppercase tracking-tight">Inicio</span>
                </a>

                @if($activeEvent)
                <div class="pt-4 pb-2 border-t border-slate-50 mt-4">

                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] ml-5 mb-3 italic">
                        Gerenciar Evento 
                    </p>

                    <a href="{{ route('events.show', $activeEvent) }}"
                       class="flex items-center gap-3 px-5 py-3 rounded-md transition-all
                       {{ request()->routeIs('events.show') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-users text-lg"></i>
                        Convidados
                    </a>

                    <a href="{{ route('itens.index', $activeEvent) }}"
                       class="flex items-center gap-3 px-5 py-3 rounded-md transition-all
                       {{ request()->routeIs('itens.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-basket-shopping text-lg"></i>
                        Itens da Festa
                    </a>

                    <a href="{{ route('events.galeria', $activeEvent) }}"
                       class="flex items-center gap-3 px-5 py-3 rounded-md transition-all
                       {{ request()->routeIs('events.galeria') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-images text-lg"></i>
                        Galeria
                    </a>

                    <a href="{{ route('events.detalhes', $activeEvent) }}"
                       class="flex items-center gap-3 px-5 py-3 rounded-md transition-all
                       {{ request()->routeIs('events.detalhes') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                        Detalhes & Logs
                    </a>

                </div>
                @endif

                <!-- PERFIL -->
                <div class="pt-4">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 px-5 py-3 rounded-md transition-all
                       {{ request()->routeIs('profile.edit') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-user-gear text-lg"></i>
                        Meu Perfil
                    </a>
                </div>

            </nav>

            <!-- USER -->
            <div class="mt-auto pt-8 border-t border-slate-50">

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-slate-100 rounded-md flex items-center justify-center font-black text-slate-500 text-xs uppercase">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="font-black text-sm text-slate-800 truncate">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-[10px] font-bold text-slate-400 truncate">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-4 px-5 py-4 text-rose-400 hover:bg-rose-50 hover:text-rose-600 rounded-md transition-all font-black text-sm uppercase tracking-tight">
                        <i class="fa-solid fa-power-off"></i>
                        Sair do App
                    </button>
                </form>

            </div>

        </div>
    </aside>

    <!-- CONTEÚDO -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- HEADER MOBILE -->
        <div class="lg:hidden bg-white border-b p-4 flex items-center justify-between sticky top-0 z-30">
            <div>
                    <h1 class="text-[36px] font-black tracking-tighter text-slate-800 mt-2">Chama<span class="text-indigo-600">í</span></h1>
                    <p class="text-[14px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                        Organizar eventos nunca foi tão fácil
                    </p>
                </div>
            <button @click="sidebarOpen = true"
                class="w-10 h-10 flex items-center justify-center bg-slate-50 rounded-md border">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </div>

        @isset($header)
        <header class="bg-white/70 backdrop-blur-md border-b sticky top-0 lg:static z-20">
            <div class="max-w-7xl mx-auto py-6 px-6 lg:px-12">
                {{ $header }}
            </div>
        </header>
        @endisset

        <main class="min-h-screen bg-slate-50 pb-20">
    <div class="max-w-7xl mx-auto pt-8 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-12 text-center">
            <div class="inline-flex flex-col items-center gap-2">
                <div class="w-14 h-14 bg-indigo-600 rounded-md flex items-center justify-center shadow-lg shadow-indigo-100 rotate-3">
                    <i class="fa-solid fa-rocket text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-black tracking-tighter text-slate-800 mt-2">Chama<span class="text-indigo-600">í</span></h1>
            </div>
        </div>

        <div class="w-full bg-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden rounded-md md:rounded-md p-4 md:p-10">
            {{ $slot }}
        </div>

        <footer class="mt-12 mb-8 text-center px-4">
    <div class="flex flex-col items-center gap-2">
        <p class="text-slate-400 text-[12px] font-bold  tracking-[0.2em]">
            © 2026 Chama<span class="text-indigo-600">í</span> • Todos os direitos reservados
        </p>
        
        <p class="text-slate-300 text-[10px] font-medium uppercase tracking-widest flex items-center gap-2">
            <span>Seu evento decola aqui</span>
            <span class="text-slate-200">•</span>
            <span>Criado por <span class="text-indigo-300">Loacir Ribeiro Bueno</span></span>
        </p>
    </div>
</footer>
        
    </div>
</main>

    </div>

</div>


@stack('scripts')

</body>
</html>