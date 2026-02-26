<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 px-4 sm:px-0">
            <a href="{{ route('dashboard') }}" 
               class="w-10 h-10 flex items-center justify-center rounded-md bg-white border-4 border-slate-200 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <h2 class="font-black text-xl sm:text-2xl text-slate-800 tracking-tight">
                Novo <span class="text-indigo-600">Evento</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 sm:py-16 px-4">
        <div class="max-w-3xl mx-auto">
            
            <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.04)] 
                        rounded-md border-4 border-slate-200">

                <div class="p-6 sm:p-10">

                    <!-- Cabeçalho interno -->
                    <div class="flex items-center gap-4 mb-8 sm:mb-10">
                        <div class="w-14 h-14 bg-indigo-600 rounded-md flex items-center justify-center text-white shadow-xl shadow-indigo-100 rotate-3">
                            <i class="fa-solid fa-wand-magic-sparkles text-2xl"></i>
                        </div>

                        <div>
                            <h3 class="text-lg sm:text-xl font-black text-slate-800 uppercase tracking-tighter">
                                O começo de tudo
                            </h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                Preencha os dados do seu foguete
                            </p>
                        </div>
                    </div>

                    <!-- FORM -->
                    <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Nome -->
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">
                                Nome da Celebração
                            </label>

                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fa-solid fa-cake-candles"></i>
                                </span>

                                <input type="text" name="titulo" required
                                       placeholder="Ex: Churrasco da Família Loacir"
                                       class="w-full pl-11 pr-4 py-4 
                                              border-4 border-slate-200 
                                              rounded-md 
                                              focus:ring-indigo-500 focus:border-indigo-500 
                                              font-bold text-slate-700 placeholder:text-slate-300">
                            </div>
                        </div>

                        <!-- Data + Local -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">
                                    Quando será?
                                </label>

                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </span>

                                    <input type="datetime-local" name="data_horario" required
                                           class="w-full pl-11 pr-4 py-4 
                                                  border-4 border-slate-200 
                                                  rounded-md 
                                                  focus:ring-indigo-500 focus:border-indigo-500 
                                                  font-bold text-slate-700">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">
                                    Onde será?
                                </label>

                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </span>

                                    <input type="text" name="local" required
                                           placeholder="Endereço ou Google Maps"
                                           class="w-full pl-11 pr-4 py-4 
                                                  border-4 border-slate-200 
                                                  rounded-md 
                                                  focus:ring-indigo-500 focus:border-indigo-500 
                                                  font-bold text-slate-700 placeholder:text-slate-300">
                                </div>
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">
                                Instruções aos Convidados
                            </label>

                            <textarea name="descricao" rows="3"
                                      placeholder="Ex: Tragam roupas leves e muita alegria!"
                                      class="w-full px-5 py-4 
                                             border-4 border-slate-200 
                                             rounded-md 
                                             focus:ring-indigo-500 focus:border-indigo-500 
                                             font-medium text-slate-700 placeholder:text-slate-300">
                            </textarea>
                        </div>

                        <!-- Botões -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4">
                            
                            <a href="{{ route('dashboard') }}"
                               class="text-xs text-center sm:text-left font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">
                                Cancelar
                            </a>
                            
                            <button type="submit"
                                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-md font-black uppercase text-xs tracking-widest transition shadow-xl shadow-indigo-100 flex items-center justify-center gap-2">
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