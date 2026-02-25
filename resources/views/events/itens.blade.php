<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('events.show', $event) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-slate-800 tracking-tight leading-none">
                        Itens da Festa
                    </h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">
                        <i class="fa-solid fa-bolt-lightning text-indigo-400 mr-1"></i> Gerenciar suprimentos para: {{ $event->titulo }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- 1. CARD DE ADICIONAR ITEM (Design Original Permanecido) --}}
            <div class="max-w-md" id="novo-item">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="font-black text-lg text-slate-800 uppercase tracking-tighter mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-cart-plus text-indigo-600"></i> Adicionar Item
                    </h3>

                    <form action="{{ route('itens.store', $event) }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-1 block">O que levar?</label>
                            <input type="text" name="nome" placeholder="Ex: Cerveja, Bolo, Refrigerante..." required
                                class="w-full border-slate-100 bg-slate-50 rounded-2xl focus:ring-indigo-600 focus:border-indigo-600 font-bold text-sm">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-1 block">Quanto?</label>
                            <input type="text" name="quantidade" placeholder="Ex: 2 fardos, 10kg..."
                                class="w-full border-slate-100 bg-slate-50 rounded-2xl focus:ring-indigo-600 focus:border-indigo-600 font-bold text-sm">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">
                            Adicionar à Lista
                        </button>
                    </form>
                </div>
            </div>

            {{-- 2. LISTA DE ITENS --}}
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-white">
                    <h3 class="font-black text-lg text-slate-800 uppercase tracking-tighter">Itens Necessários</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Item</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Qtd.</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Responsável</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($event->itens as $item)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-8 py-5">
                                        <p class="font-bold text-slate-700 leading-tight">{{ $item->nome }}</p>
                                    </td>
                                    <td class="px-8 py-5 text-sm font-bold text-slate-500">
                                        {{ $item->quantidade ?? '-' }}
                                    </td>
                                    <td class="px-8 py-5">
                                        <form action="{{ route('itens.vincular', $item) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="convidado_id" onchange="this.form.submit()" 
                                                class="text-[11px] font-bold uppercase tracking-tight bg-slate-50 border-none rounded-xl focus:ring-indigo-500 py-1.5 pr-8">
                                                <option value="">Ninguém ainda</option>
                                                @foreach($event->convidados as $convidado)
                                                    <option value="{{ $convidado->id }}" {{ $item->convidado_id == $convidado->id ? 'selected' : '' }}>
                                                        {{ $convidado->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex justify-end gap-2" x-data="{}"> {{-- x-data garante que o Alpine rode aqui --}}
                                            
                                            {{-- BOTÃO EDITAR --}}
                                            <button type="button" 
                                                    x-on:click.prevent="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                    class="w-9 h-9 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all border border-indigo-100">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            {{-- BOTÃO EXCLUIR --}}
                                            <button type="button" 
                                                    onclick="confirmarExclusaoItem('{{ $item->id }}', '{{ $item->nome }}')" 
                                                    class="w-9 h-9 flex items-center justify-center bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition-all border border-rose-100">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <form id="delete-item-{{ $item->id }}" action="{{ route('itens.destroy', $item) }}" method="POST" class="hidden">
                                                    @csrf @method('DELETE')
                                                </form>
                                        </div>

                                        {{-- O MODAL --}}
                                        <x-modal name="edit-item-{{ $item->id }}" focusable>
                                            <div class="p-8 text-left"> {{-- Div interna para padding --}}
                                                <form action="{{ route('itens.update', $item) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <h2 class="text-lg font-black text-slate-800 uppercase tracking-tighter mb-6">
                                                        Editar Item
                                                    </h2>

                                                    <div class="space-y-4">
                                                        <div>
                                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-1 block">Nome do Item</label>
                                                            <input type="text" name="nome" value="{{ $item->nome }}" required
                                                                class="w-full border-slate-100 bg-slate-50 rounded-2xl focus:ring-indigo-600 focus:border-indigo-600 font-bold text-sm h-12">
                                                        </div>

                                                        <div>
                                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-1 block">Quantidade</label>
                                                            <input type="text" name="quantidade" value="{{ $item->quantidade }}"
                                                                class="w-full border-slate-100 bg-slate-50 rounded-2xl focus:ring-indigo-600 focus:border-indigo-600 font-bold text-sm h-12">
                                                        </div>
                                                    </div>

                                                    <div class="mt-8 flex justify-end gap-3">
                                                        <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                                            Salvar Alterações
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </x-modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center">
                                        <p class="text-slate-400 font-bold italic text-sm text-center">Sua lista está vazia. Comece adicionando o que não pode faltar!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarExclusaoItem(id, nome) {
            Swal.fire({
                title: 'Remover da lista?',
                text: `Deseja excluir "${nome}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'SIM, REMOVER',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true,
                customClass: { popup: 'rounded-[2.5rem]' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-item-' + id).submit();
                }
            });
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Perfeito!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'rounded-[2.5rem]' }
            });
        @endif
    </script>
</x-app-layout>