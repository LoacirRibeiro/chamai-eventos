<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('events.show', $event->id) }}" class="w-10 h-10 flex items-center justify-center rounded-md bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-black text-[40px] text-slate-800 tracking-tight">
                Novo <span class="text-indigo-600">Convidado</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-md border border-slate-100">
                <div class="p-10">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-indigo-600 rounded-md flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                            <i class="fa-solid fa-user-plus text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 uppercase tracking-tighter">Quem vamos chamar?</h3>
                            <p class="text-sm text-slate-400 font-bold uppercase tracking-widest text-[10px]">Adicione os detalhes do convidado abaixo</p>
                        </div>
                    </div>

                    <form action="{{ route('convidados.store', $event->id) }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-[12px] font-black uppercase text-slate-400 mb-2 ml-1">Nome Completo</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="nome" placeholder="Ex: João Silva" required
                                    class="block w-full pl-11 pr-4 py-4 rounded-md border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 font-bold">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[12px] font-black uppercase text-slate-400 mb-2 ml-1">WhatsApp (com DDD)</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                                    <i class="fa-brands fa-whatsapp text-lg"></i>
                                </span>
                                <input type="text" name="telefone" placeholder="Ex: 63992001122" required
                                    class="block w-full pl-11 pr-4 py-4 rounded-md border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-slate-700 font-bold">
                            </div>
                            <p class="mt-2 text-[12px] text-slate-400 font-medium ml-1">Digite apenas números com o DDD para o disparo automático funcionar.</p>
                        </div>

                        <div>
                            <label class="block text-[12px] font-black uppercase text-slate-400 mb-2 ml-1">E-mail (Opcional)</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" name="e_mail" placeholder="email@exemplo.com"
                                    class="block w-full pl-11 pr-4 py-4 rounded-md border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 font-bold">
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-md font-black text-[15px] uppercase tracking-[0.2em] hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-plus"></i> Adicionar à Lista
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>