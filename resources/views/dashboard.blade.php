<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 px-2">
            <div>
                <h2 class="font-black text-2xl md:text-3xl text-slate-800 tracking-tight leading-none">
                    Meus <span class="text-indigo-600">Eventos</span>
                </h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">
                    Painel de Controle Geral
                </p>
            </div>
            <a href="{{ route('events.create') }}" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3.5 rounded-md font-black text-xs transition shadow-lg shadow-indigo-100 flex items-center justify-center gap-2 uppercase tracking-widest">
                <i class="fa-solid fa-plus text-[10px]"></i> Novo Evento
            </a>
        </div>
    </x-slot>

    <div class="py-6 md:py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- 1. NOTIFICAÇÕES --}}
        @if(auth()->user()->unreadNotifications->count() > 0)
            <div class="mb-10">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2 mb-4">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-md bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-md h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Feed de Atividade
                </h3>
                
                <div class="space-y-2">
                    @foreach(auth()->user()->unreadNotifications as $notification)
                        <div class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-md shadow-sm">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8 h-8 shrink-0 bg-indigo-50 text-indigo-500 rounded-md flex items-center justify-center">
                                    <i class="fa-solid fa-bell text-[10px]"></i>
                                </div>
                                <div class="truncate">
                                    <p class="text-[11px] text-slate-700 font-bold truncate">{{ $notification->data['mensagem'] }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ $notification->data['link'] }}" class="ml-4 px-3 py-1.5 text-[9px] font-black bg-slate-50 text-slate-500 rounded-md hover:bg-indigo-600 hover:text-white transition uppercase">
                                Ver
                            </a>
                        </div>
                        @php $notification->markAsRead(); @endphp
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 2. GRID DE EVENTOS --}}
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Seus Eventos Ativos</h3>
            <span class="text-[9px] font-black text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md uppercase">
                {{ $events->count() }} Total
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            @forelse ($events as $evento)
                <div class="group bg-white rounded-md border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="p-6 flex-1">
                        
                        {{-- DATA DO EVENTO ( data_horario) --}}
                        <div class="flex justify-between items-start mb-6">
                            <div class="bg-slate-50 border border-slate-100 rounded-md px-3 py-2 text-center transition group-hover:bg-indigo-600 group-hover:border-indigo-600">
                                <span class="block text-slate-800 font-black text-lg leading-none group-hover:text-white">
                                    {{ \Carbon\Carbon::parse($evento->data_horario)->format('d') }}
                                </span>
                                <span class="text-[9px] uppercase font-black text-slate-400 tracking-tighter group-hover:text-indigo-100">
                                    {{ \Carbon\Carbon::parse($evento->data_horario)->translatedFormat('M') }}
                                </span>
                            </div>
                            
                            <div class="text-right">
                                <span class="text-[9px] font-black bg-emerald-50 text-emerald-600 px-2 py-1 rounded-md uppercase border border-emerald-100">
                                    {{ $evento->convidados_count ?? $evento->convidados->count() }} Convidados
                                </span>
                            </div>
                        </div>

                        <h3 class="text-lg font-black text-slate-800 mb-1 group-hover:text-indigo-600 transition-colors leading-tight">
                            {{ $evento->titulo }}
                        </h3>
                        
                        <p class="text-[11px] text-slate-400 font-bold mb-6 flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot text-indigo-400"></i>
                            <span class="truncate">{{ $evento->local ?? 'Local a definir' }}</span>
                        </p>

                        {{-- CONTADOR DE DIAS (Comparando com data_horario) --}}
                        <div class="bg-slate-50/50 rounded-md p-3 border border-slate-50 text-center">
                            @php
                                $dataEvento = \Carbon\Carbon::parse($evento->data_horario)->startOfDay();
                                $hoje = \Carbon\Carbon::today();
                                $diasRestantes = $hoje->diffInDays($dataEvento, false);
                            @endphp

                            @if($diasRestantes > 0)
                                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">
                                    Faltam {{ $diasRestantes }} {{ $diasRestantes > 1 ? 'Dias' : 'Dia' }}
                                </p>
                            @elseif($diasRestantes == 0)
                                <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest animate-pulse">
                                    É HOJE! 🥳
                                </p>
                            @else
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">
                                    Evento Finalizado
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 py-4 bg-slate-50/30 border-t border-slate-50 flex items-center justify-between">
                         <span class="text-[10px] font-black text-slate-300 uppercase tracking-tighter italic">Status: Ativo</span>
                         
                         <a href="{{ route('events.show', $evento->id) }}" class="flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-md font-black text-[10px] uppercase hover:bg-indigo-600 transition shadow-sm">
                            Gerenciar <i class="fa-solid fa-chevron-right text-[8px]"></i>
                         </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-md border-2 border-dashed border-slate-100">
                    <div class="w-20 h-20 bg-slate-50 rounded-mdl flex items-center justify-center mx-auto mb-4 text-slate-200 text-4xl">
                        <i class="fa-regular fa-calendar-plus"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Nenhum evento criado.</h3>
                    <a href="{{ route('events.create') }}" class="mt-4 bg-indigo-600 text-white px-8 py-4 rounded-md font-black uppercase text-xs tracking-widest hover:bg-indigo-700 transition inline-flex items-center gap-3">
                        Criar meu primeiro evento
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>