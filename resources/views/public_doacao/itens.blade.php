<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 px-2 sm:px-0">
            <a href="{{ route('dashboard') }}" 
               class="w-9 h-9 flex items-center justify-center rounded-md bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>

            <h2 class="font-black text-[30px] sm:text-[40px] text-slate-800 tracking-tight">
                Lista de <span class="text-indigo-600">Doações</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 px-2 sm:px-4">
        <div class="max-w-3xl mx-auto">
            
            {{-- CARD PRINCIPAL: ADICIONAR ITEM --}}
            <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.04)] rounded-md border border-slate-200 mb-6">
                <div class="p-5 sm:p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-emerald-500 rounded-md flex items-center justify-center text-white shadow-lg shadow-emerald-100 rotate-3 shrink-0">
                            <i class="fa-solid fa-plus text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tighter">O que precisamos?</h3>
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Defina o item e a meta de arrecadação</p>
                        </div>
                    </div>

                    {{-- FORMULÁRIO DE ADIÇÃO (Reutilizando seu método addItem) --}}
                    <form action="{{ route('eventos.items.add', $event->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                        @csrf
                        <div class="sm:col-span-7">
                            <input type="text" name="nome" required placeholder="Ex: Arroz (pacote 5kg)" 
                                   class="w-full px-4 py-3.5 border border-slate-200 rounded-md focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700 placeholder:text-slate-300 text-sm transition-all">
                        </div>
                        <div class="sm:col-span-3">
                            <input type="text" name="quantidade" placeholder="Meta (ex: 10)" 
                                   class="w-full px-4 py-3.5 border border-slate-200 rounded-md focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700 placeholder:text-slate-300 text-sm text-center transition-all">
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit" class="w-full h-full bg-slate-900 text-white rounded-md font-black uppercase text-[11px] tracking-widest hover:bg-indigo-600 transition shadow-lg">
                                Adicionar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- LISTA DE ITENS JÁ CADASTRADOS --}}
            <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.04)] rounded-md border border-slate-200">
                <div class="p-0">
                    <div class="p-5 border-b border-slate-50 flex justify-between items-center">
                        <h4 class="font-black text-slate-800 uppercase text-xs tracking-widest">Itens da Campanha</h4>
                        <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-3 py-1 rounded-md uppercase">
                            {{ $event->itens->count() }} Itens
                        </span>
                    </div>

                    @if($event->itens->isEmpty())
                        <div class="p-10 text-center">
                            <i class="fa-solid fa-box-open text-slate-200 text-4xl mb-4 block"></i>
                            <p class="text-slate-400 font-bold text-sm uppercase tracking-widest">Nenhum item na lista ainda</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-50">
                            @foreach($event->itens as $item)
                                <div class="p-5 flex items-center justify-between group hover:bg-slate-50 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="w-8 h-8 rounded-md bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-white group-hover:text-indigo-500 transition border border-transparent group-hover:border-slate-100">
                                            <i class="fa-solid fa-check text-[10px]"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-700 uppercase text-sm tracking-tighter">{{ $item->nome }}</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Meta: {{ $item->quantidade ?? 'Não definida' }}</p>
                                        </div>
                                    </div>

                                    <form action="{{ route('eventos.items.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remover este item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-300 hover:text-red-500 transition p-2">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- BOTÃO FINALIZAR --}}
            <div class="mt-8 text-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-10 py-4 rounded-md font-black uppercase text-[12px] tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-rocket"></i>
                    Finalizar e ir para o Painel
                </a>
            </div>

        </div>
    </div>
</x-app-layout>