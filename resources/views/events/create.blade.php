<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-black text-2xl text-slate-800 tracking-tight">
                Novo <span class="text-indigo-600">Evento</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.04)] sm:rounded-[3rem] border border-slate-100">
                
                <div class="p-10">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-100 rotate-3">
                            <i class="fa-solid fa-wand-magic-sparkles text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter">O começo de tudo</h3>
                            <p class="text-sm text-slate-400 font-bold uppercase tracking-widest text-[10px]">Preencha os dados do seu foguete</p>
                        </div>
                    </div>

                    <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="titulo" class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Nome da Celebração</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fa-solid fa-cake-candles"></i>
                                </span>
                                <input type="text" name="titulo" id="titulo" placeholder="Ex: Churrasco da Família Loacir" 
                                       class="w-full pl-11 pr-4 py-4 border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm font-bold text-slate-700 placeholder:text-slate-300 placeholder:font-medium" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="data_horario" class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Quando será?</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </span>
                                    <input type="datetime-local" name="data_horario" id="data_horario" 
                                           class="w-full pl-11 pr-4 py-4 border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm font-bold text-slate-700" required>
                                </div>
                            </div>

                            <div>
                                <label for="local" class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Onde será?</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </span>
                                    <input type="text" name="local" id="local" placeholder="Endereço ou Google Maps" 
                                           class="w-full pl-11 pr-4 py-4 border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm font-bold text-slate-700 placeholder:text-slate-300 placeholder:font-medium" required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="descricao" class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Instruções aos Convidados</label>
                            <textarea name="descricao" id="descricao" rows="3" placeholder="Ex: Tragam roupas leves e muita alegria!" 
                                      class="w-full px-5 py-4 border-slate-200 rounded-[2rem] focus:ring-indigo-500 focus:border-indigo-500 shadow-sm font-medium text-slate-700 placeholder:text-slate-300"></textarea>
                        </div>

                        <div class="flex items-center justify-between gap-4 pt-4">
                            <a href="{{ route('dashboard') }}" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">Cancelar</a>
                            
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition shadow-xl shadow-indigo-100 flex items-center gap-2">
                                <i class="fa-solid fa-rocket"></i> Lançar Evento
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>