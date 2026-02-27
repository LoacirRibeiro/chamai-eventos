<!-- <!DOCTYPE html>
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
    
    {{-- 1. ADICIONADO x-data para controlar o estado do menu --}}
    <body class="font-sans antialiased bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">
    
    @php
        $activeEvent = $event ?? request()->route('event');
    @endphp

    <div class="flex h-screen overflow-hidden">
        
        {{-- 2. OVERLAY PARA MOBILE: Escurece a tela quando o menu abre --}}
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden transition-opacity"
             x-transition:enter="transition opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        {{-- 3. SIDEBAR AJUSTADA: fixed no mobile, static no desktop --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-100 flex-shrink-0 flex flex-col transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">
            
            <div class="p-8 flex flex-col h-full relative">
                
                {{-- Botão Fechar (Só Mobile) --}}
                <button @click="sidebarOpen = false" class="lg:hidden absolute top-8 right-6 text-slate-400 hover:text-indigo-600">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
                
                <div class="flex items-center gap-3 px-2 mb-12">
                    <div class="w-12 h-12 bg-indigo-600 rounded-md flex items-center justify-center text-white shadow-xl shadow-indigo-200 flex-shrink-0">
                        <i class="fa-solid fa-bolt-lightning text-xl"></i>
                    </div>
                    <div>
                        <span class="font-black text-2xl tracking-tighter text-slate-800 block leading-none">Chamaí</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Party Planner</span>
                    </div>
                </div>

                <nav class="space-y-3 flex-1 overflow-y-auto">
                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}" 
                        class="flex items-center gap-4 px-5 py-4 rounded-md transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-house text-lg"></i>
                        <span class="font-black text-sm uppercase tracking-tight">Dashboard</span>
                    </a>

                    @if($activeEvent)
                        <div class="pt-4 pb-2 border-t border-slate-50 mt-4">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] ml-5 mb-3 italic">Evento Ativo</p>
                            
                            <a href="{{ route('events.show', $activeEvent) }}" 
                               class="flex items-center gap-4 px-5 py-4 rounded-md transition-all {{ request()->routeIs('events.show') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                                <i class="fa-solid fa-users text-lg"></i>
                                <span class="font-black text-sm uppercase tracking-tight">Convidados</span>
                            </a>

                            <a href="{{ route('itens.index', $activeEvent) }}" 
                               class="flex items-center gap-4 px-5 py-4 rounded-md transition-all {{ request()->routeIs('itens.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                                <i class="fa-solid fa-basket-shopping text-lg"></i>
                                <span class="font-black text-sm uppercase tracking-tight">Itens da Festa</span>
                            </a>

                            <a href="{{ route('events.galeria', $activeEvent) }}" 
                                class="flex items-center gap-4 px-5 py-4 rounded-md transition-all {{ request()->routeIs('events.galeria') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                                <i class="fa-solid fa-images text-lg"></i>
                                <span class="font-black text-sm uppercase tracking-tight">Galeria</span>
                            </a>

                            <a href="{{ route('events.detalhes', $activeEvent) }}" 
                                class="flex items-center gap-4 px-5 py-4 rounded-md transition-all {{ request()->routeIs('events.detalhes') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                                <i class="fa-solid fa-chart-line text-lg"></i>
                                <span class="font-black text-sm uppercase tracking-tight">Detalhes & Logs</span>
                            </a>
                        </div>
                    @endif

                    <div class="pt-4">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-5 py-4 rounded-md transition-all {{ request()->routeIs('profile.edit') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                            <i class="fa-solid fa-user-gear text-lg"></i>
                            <span class="font-black text-sm uppercase tracking-tight">Meu Perfil</span>
                        </a>
                    </div>
                </nav>

                <div class="mt-auto pt-8 border-t border-slate-50">
                    <div class="flex items-center gap-3 px-2 mb-6">
                        <div class="w-10 h-10 bg-slate-100 rounded-md flex items-center justify-center font-black text-slate-500 text-xs flex-shrink-0 uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="font-black text-sm text-slate-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-bold text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 px-5 py-4 text-rose-400 hover:bg-rose-50 hover:text-rose-600 rounded-md transition-all font-black text-sm uppercase tracking-tight">
                            <i class="fa-solid fa-power-off"></i>
                            <span>Sair do App</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="flex-1 overflow-y-auto bg-slate-50/50 flex flex-col">
            
            {{-- 4. BARRA DE TOPO MOBILE: Só aparece abaixo de 1024px (lg) --}}
            <div class="lg:hidden bg-white border-b border-slate-100 p-4 sticky top-0 z-30 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-md flex items-center justify-center text-white">
                        <i class="fa-solid fa-bolt-lightning text-xs"></i>
                    </div>
                    <span class="font-black text-lg tracking-tighter">Chamaí</span>
                </div>
                <button @click="sidebarOpen = true" class="w-10 h-10 flex items-center justify-center bg-slate-50 rounded-md text-slate-600 border border-slate-200 shadow-sm">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            </div>

            @isset($header)
                <header class="bg-white/70 backdrop-blur-md sticky top-0 lg:static z-10 border-b border-slate-100/50">
                    <div class="max-w-7xl mx-auto py-6 px-6 lg:py-8 lg:px-12">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <div class="p-6 lg:p-12">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html> -->

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
                    <span class="font-black text-2xl tracking-tighter text-slate-800 block leading-none">
                        Chamaí
                    </span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        Party Planner
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
                    <span class="font-black text-sm uppercase tracking-tight">Dashboard</span>
                </a>

                @if($activeEvent)
                <div class="pt-4 pb-2 border-t border-slate-50 mt-4">

                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] ml-5 mb-3 italic">
                        Evento Ativo
                    </p>

                    <a href="{{ route('events.show', $activeEvent) }}"
                       class="flex items-center gap-4 px-5 py-4 rounded-md transition-all
                       {{ request()->routeIs('events.show') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-users text-lg"></i>
                        Convidados
                    </a>

                    <a href="{{ route('itens.index', $activeEvent) }}"
                       class="flex items-center gap-4 px-5 py-4 rounded-md transition-all
                       {{ request()->routeIs('itens.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-basket-shopping text-lg"></i>
                        Itens da Festa
                    </a>

                    <a href="{{ route('events.galeria', $activeEvent) }}"
                       class="flex items-center gap-4 px-5 py-4 rounded-md transition-all
                       {{ request()->routeIs('events.galeria') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-images text-lg"></i>
                        Galeria
                    </a>

                    <a href="{{ route('events.detalhes', $activeEvent) }}"
                       class="flex items-center gap-4 px-5 py-4 rounded-md transition-all
                       {{ request()->routeIs('events.detalhes') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                        Detalhes & Logs
                    </a>

                </div>
                @endif

                <!-- PERFIL -->
                <div class="pt-4">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-4 px-5 py-4 rounded-md transition-all
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
            <span class="font-black text-lg tracking-tighter">Chamaí</span>
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

        <main class="flex-1 p-6 lg:p-12 overflow-x-hidden">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

    </div>

</div>

@stack('scripts')

</body>
</html>