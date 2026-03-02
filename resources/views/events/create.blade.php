<x-app-layout>
    <x-slot name="header">
        {{-- Ajuste: px-4 no mobile para não colar na borda --}}
        <div class="flex items-center gap-4 px-2 sm:px-0">
            <a href="{{ route('dashboard') }}" 
               class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>

            <h2 class="font-black text-lg sm:text-2xl text-slate-800 tracking-tight">
                Novo <span class="text-indigo-600">Evento</span>
            </h2>
        </div>
    </x-slot>

    {{-- Ajuste: py-6 no mobile para não sobrar muito espaço branco --}}
    <div class="py-6 sm:py-16 px-2 sm:px-4">
        <div class="max-w-3xl mx-auto">
            
            {{-- Ajuste: Troquei border-4 por border simples e rounded-md por rounded-xl --}}
            <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.04)] 
                        rounded-xl border border-slate-200">

                {{-- Ajuste: p-5 no mobile (635px pede menos respiro interno) --}}
                <div class="p-5 sm:p-10">

                    <div class="flex items-center gap-4 mb-6 sm:mb-10">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-xl shadow-indigo-100 rotate-3 shrink-0">
                            <i class="fa-solid fa-wand-magic-sparkles text-xl sm:text-2xl"></i>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-base sm:text-xl font-black text-slate-800 uppercase tracking-tighter truncate">
                                O começo de tudo
                            </h3>
                            <p class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                Preencha os dados do seu Evento
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('events.store') }}" method="POST" class="space-y-5 sm:space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1 tracking-widest">
                                Nome da Celebração
                            </label>

                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fa-solid fa-cake-candles"></i>
                                </span>

                                <input type="text" name="titulo" required
                                       placeholder="Ex: Churrasco da Família"
                                       class="w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 placeholder:text-slate-300 text-sm sm:text-base transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1 tracking-widest">
                                    Quando será?
                                </label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </span>
                                    <input type="datetime-local" name="data_horario" required
                                           class="w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1 tracking-widest">
                                    Onde será?
                                </label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </span>
                                    <input type="text" name="local" required
                                           placeholder="Local do evento"
                                           class="w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 placeholder:text-slate-300 text-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1 tracking-widest">
                                Instruções
                            </label>
                            <textarea name="descricao" rows="3"
                                      placeholder="Ex: Tragam roupas leves!"
                                      class="w-full px-4 py-3.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium text-slate-700 placeholder:text-slate-300 text-sm"></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4">
                            <a href="{{ route('dashboard') }}"
                               class="order-2 sm:order-1 text-[10px] text-center font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">
                                Cancelar
                            </a>
                            
                            <button type="submit"
                                    class="order-1 sm:order-2 w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-xl font-black uppercase text-[10px] tracking-widest transition shadow-lg shadow-indigo-100 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-rocket"></i>
                                Lançar Evento
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>