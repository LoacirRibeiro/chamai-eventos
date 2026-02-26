<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                {{-- Botão Voltar para o Show --}}
                <a href="{{ route('events.show', $event) }}" 
                   class="w-10 h-10 flex items-center justify-center rounded-md bg-white border-4 border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-slate-800 tracking-tight leading-none">
                        Detalhes & Log
                    </h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">
                        {{ $event->titulo }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- COLUNA DA ESQUERDA: Informações Rápidas --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-md border-4 border-slate-100 shadow-sm">
                        <h4 class="font-black text-slate-800 uppercase tracking-tighter mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-indigo-500"></i>
                            Resumo do Evento
                        </h4>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-slate-50 rounded-md border-4 border-white shadow-sm">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Localização</p>
                                <p class="text-sm font-bold text-slate-700 mt-1">{{ $event->local }}</p>
                            </div>

                            <div class="p-4 bg-slate-50 rounded-md border-4 border-white shadow-sm">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Data e Hora</p>
                                <p class="text-sm font-bold text-slate-700 mt-1">
                                    {{ \Carbon\Carbon::parse($event->data_horario)->format('d/m/Y - H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Card de Ação Rápida --}}
                    <div class="bg-indigo-600 p-8 rounded-md border-4 border-indigo-400 shadow-xl text-white">
                        <h4 class="font-black uppercase tracking-tighter mb-2 italic">Dica do Chamaí!</h4>
                        <p class="text-xs font-bold opacity-80 leading-relaxed">
                            Acompanhe quem entra e sai da lista em tempo real através da Timeline ao lado.
                        </p>
                    </div>
                </div>

                {{-- COLUNA DA DIREITA: A INTERFACE DE DETALHES (TIMELINE) --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-md border-4 border-slate-100 shadow-sm overflow-hidden">
                        
                        {{-- Cabeçalho da Timeline --}}
                        <div class="p-8 border-b-4 border-slate-50 bg-slate-50/30 flex items-center justify-between">
                            <div>
                                <h3 class="font-black text-slate-800 uppercase tracking-tighter text-xl flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-600 rounded-md flex items-center justify-center text-white shadow-lg -rotate-3">
                                        <i class="fa-solid fa-stream"></i>
                                    </div>
                                    Linha do Tempo
                                </h3>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 ml-1">
                                    Histórico completo de interações
                                </p>
                            </div>
                        </div>

                        {{-- Lista de Atividades --}}
                        <div class="p-8">
                            <div class="space-y-8 relative">
                                {{-- Linha Conectora --}}
                                <div class="absolute left-[23px] top-2 bottom-2 w-1.5 bg-slate-50 rounded-md"></div>

                                @forelse($event->activities()->latest()->get() as $activity)
                                    <div class="flex gap-6 relative group">
                                        {{-- Ícone do Log --}}
                                        <div class="w-12 h-12 rounded-md border-4 border-white shadow-md flex items-center justify-center z-10 shrink-0 transition-transform group-hover:scale-110 duration-300
                                            {{ $activity->tipo == 'presenca' ? 'bg-emerald-500 text-white' : '' }}
                                            {{ $activity->tipo == 'item' ? 'bg-indigo-600 text-white' : '' }}
                                            {{ $activity->tipo == 'sistema' ? 'bg-slate-800 text-white' : '' }}">
                                            
                                            @if($activity->tipo == 'presenca')
                                                <i class="fa-solid fa-user-check text-sm"></i>
                                            @elseif($activity->tipo == 'item')
                                                <i class="fa-solid fa-cart-shopping text-sm"></i>
                                            @else
                                                <i class="fa-solid fa-rocket text-sm"></i>
                                            @endif
                                        </div>

                                        {{-- Conteúdo --}}
                                        <div class="flex flex-col pt-1">
                                            <p class="text-md font-bold text-slate-700 leading-tight group-hover:text-indigo-600 transition-colors">
                                                {{ $activity->mensagem }}
                                            </p>
                                            <div class="flex items-center gap-3 mt-2">
                                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                                    <i class="fa-regular fa-clock text-indigo-400"></i>
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </span>
                                                <span class="w-1 h-1 bg-slate-200 rounded-md"></span>
                                                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">
                                                    {{ $activity->tipo }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-20 text-center">
                                        <i class="fa-solid fa-radar text-slate-100 text-6xl mb-4"></i>
                                        <p class="text-slate-400 font-bold italic">Nenhum registro encontrado...</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Estilo para suavizar o visual --}}
    <style>
        body { background-color: #f8fafc; }
    </style>
</x-app-layout>