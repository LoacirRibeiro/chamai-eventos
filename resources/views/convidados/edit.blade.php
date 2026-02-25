<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            {{-- Botão Voltar para a página do Evento --}}
            <a href="{{ route('events.show', $convidado->event_id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-black text-2xl text-slate-800 tracking-tight">
                Editar <span class="text-indigo-600">Convidado</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-[3rem] border border-slate-100">
                <div class="p-10">
                    <div class="flex items-center gap-4 mb-10">
                        {{-- Ícone de edição em vez de adição --}}
                        <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-100">
                            <i class="fa-solid fa-user-pen text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 uppercase tracking-tighter">Atualizar dados?</h3>
                            <p class="text-sm text-slate-400 font-bold uppercase tracking-widest text-[10px]">Altere as informações de {{ explode(' ', $convidado->nome)[0] }}</p>
                        </div>
                    </div>

                    {{-- Rota de Update com o ID do Convidado --}}
                    <form action="{{ route('convidados.update', $convidado->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Campo Nome --}}
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">Nome Completo</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="nome" value="{{ old('nome', $convidado->nome) }}" required
                                    class="block w-full pl-11 pr-4 py-4 rounded-2xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 font-bold">
                            </div>
                            @error('nome') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campo Telefone --}}
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">WhatsApp (com DDD)</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                                    <i class="fa-brands fa-whatsapp text-lg"></i>
                                </span>
                                <input type="text" name="telefone" value="{{ old('telefone', $convidado->telefone) }}" required
                                    class="block w-full pl-11 pr-4 py-4 rounded-2xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-slate-700 font-bold">
                            </div>
                            <p class="mt-2 text-[10px] text-slate-400 font-medium ml-1">Apenas números com DDD.</p>
                            @error('telefone') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campo E-mail --}}
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">E-mail (Opcional)</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" name="e_mail" value="{{ old('e_mail', $convidado->e_mail) }}"
                                    class="block w-full pl-11 pr-4 py-4 rounded-2xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 font-bold">
                            </div>
                        </div>

                        <div class="pt-6 flex flex-col gap-3">
                            {{-- Botão Salvar --}}
                            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Salvar Alterações
                            </button>

                            {{-- Botão Cancelar --}}
                            <a href="{{ route('events.show', $convidado->event_id) }}" class="w-full text-center py-4 text-slate-400 font-black text-xs uppercase tracking-[0.2em] hover:text-slate-600 transition">
                                Cancelar e Voltar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>