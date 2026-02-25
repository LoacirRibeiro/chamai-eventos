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
        // Lógica para detectar o evento em qualquer página do fluxo de gerenciamento
        $activeEvent = $event ?? request()->route('event');
    @endphp

    <div class="flex h-screen overflow-hidden">
        
        {{-- SIDEBAR LATERAL --}}
        <aside class="w-72 bg-white border-r border-slate-100 flex-shrink-0 flex flex-col">
            <div class="p-8 flex flex-col h-full">
                
                <div class="flex items-center gap-3 px-2 mb-12">
                    <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-200 flex-shrink-0">
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
                        class="flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-house text-lg"></i>
                        <span class="font-black text-sm uppercase tracking-tight">Dashboard</span>
                    </a>

                    {{-- Meus Eventos --}}
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all text-slate-400 hover:bg-slate-50 hover:text-indigo-600">
                        <i class="fa-solid fa-calendar-days text-lg"></i>
                        <span class="font-black text-sm uppercase tracking-tight">Meus Eventos</span>
                    </a>

                    {{-- MENU DO EVENTO (Agora usando a detecção automática) --}}
                    @if($activeEvent)
                        <div class="pt-4 pb-2 border-t border-slate-50 mt-4">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] ml-5 mb-3 italic">Evento Ativo</p>
                            
                            {{-- Link para Gerenciar Convidados (Página que você já tem) --}}
                            <a href="{{ route('events.show', $activeEvent) }}" 
                               class="flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all {{ request()->routeIs('events.show') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                                <i class="fa-solid fa-users text-lg"></i>
                                <span class="font-black text-sm uppercase tracking-tight">Convidados</span>
                            </a>

                            {{-- Link para Itens da Festa --}}
                            <a href="{{ route('itens.index', $activeEvent) }}" 
                               class="flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all {{ request()->routeIs('itens.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                                <i class="fa-solid fa-basket-shopping text-lg"></i>
                                <span class="font-black text-sm uppercase tracking-tight">Itens da Festa</span>
                            </a>
                        </div>
                    @endif

                    <div class="pt-4">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all {{ request()->routeIs('profile.edit') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-400 hover:bg-slate-50 hover:text-indigo-600' }}">
                            <i class="fa-solid fa-user-gear text-lg"></i>
                            <span class="font-black text-sm uppercase tracking-tight">Meu Perfil</span>
                        </a>
                    </div>
                </nav>

                <div class="mt-auto pt-8 border-t border-slate-50">
                    <div class="flex items-center gap-3 px-2 mb-6">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center font-black text-slate-500 text-xs flex-shrink-0 uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="font-black text-sm text-slate-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-bold text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 px-5 py-4 text-rose-400 hover:bg-rose-50 hover:text-rose-600 rounded-[1.25rem] transition-all font-black text-sm uppercase tracking-tight">
                            <i class="fa-solid fa-power-off"></i>
                            <span>Sair do App</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="flex-1 overflow-y-auto bg-slate-50/50">
            @isset($header)
                <header class="bg-white/70 backdrop-blur-md sticky top-0 z-10 border-b border-slate-100/50">
                    <div class="max-w-7xl mx-auto py-8 px-8 lg:px-12">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <div class="p-8 lg:p-12">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>