<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('events.show', $event) }}" class="w-10 h-10 flex items-center justify-center rounded-md bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-slate-800 tracking-tight leading-none">Itens da Festa</h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">
                         <i class="fa-solid fa-bolt-lightning text-indigo-400 mr-1"></i> Gerenciar suprimentos para: {{ $event->titulo }}

                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24 md:space-y-24">
            
            {{-- 1. ADICIONAR ITEM --}}
            <div class="max-w-md mx-auto md:mx-0">
                <div class="bg-white p-4 md:p-8 rounded-md border border-slate-100 shadow-sm">
                    <h3 class="font-black text-lg text-slate-800 uppercase tracking-tighter mb-6">
                        <i class="fa-solid fa-plus-circle text-indigo-600 mr-2"></i>Novo Item
                    </h3>
                    <form action="{{ route('itens.store', $event) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="nome" placeholder="Nome do Item" required class="w-full border-slate-100 bg-slate-50 rounded-md font-bold text-sm focus:ring-indigo-500">
                        <input type="number" name="quantidade" placeholder="Qtd. Total" min="1" required class="w-full border-slate-100 bg-slate-50 rounded-md font-bold text-sm focus:ring-indigo-500">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-md font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg">
                            Adicionar à Lista
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="py-12 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24 md:space-y-24">
            {{-- 2. LISTA DE ITENS --}}
            <div class="bg-white rounded-md md:rounded-md border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-4 md:p-4 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-base md:text-lg text-slate-800 uppercase tracking-tighter">Itens Necessários (Gestão)</h3>
                </div>
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left min-w-[600px]"> {{-- min-w garante que a tabela não quebre em telas pequenas --}}
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 md:px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Item</th>
                                <th class="px-6 md:px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Qtd. Total</th>
                                <th class="px-6 md:px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Vagas Livres</th>
                                <th class="px-6 md:px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($event->itens as $item)
                                @php
                                    $jaOcupados = $item->convidados->sum('pivot.quantidade_levada');
                                    $vagasLivres = max(0, $item->quantidade - $jaOcupados);
                                @endphp
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-6 md:px-8 py-5 font-bold text-slate-700">{{ $item->nome }}</td>
                                    <td class="px-6 md:px-8 py-5 text-center font-bold text-slate-500">{{ $item->quantidade }}</td>
                                    <td class="px-6 md:px-8 py-5 text-center">
                                        <span class="px-3 py-1 rounded-md text-[10px] font-black {{ $vagasLivres > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                            {{ $vagasLivres }} DISPONÍVEIS
                                        </span>
                                    </td>
                                    <td class="px-6 md:px-8 py-5 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button x-data x-on:click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                                class="w-8 h-8 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            
                                            <button onclick="confirmarExclusaoItem('{{ $item->id }}', '{{ $item->nome }}')" class="w-8 h-8 flex items-center justify-center bg-rose-50 text-rose-500 rounded-md hover:bg-rose-500 hover:text-white transition">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>

                                            <form id="delete-item-{{ $item->id }}" action="{{ route('itens.destroy', $item) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {{-- Modal de Edição (fora da <tr> para evitar bugs de CSS em tabelas) --}}
                                <x-modal name="edit-item-{{ $item->id }}" focusable>
                                    <div class="p-8">
                                        <form action="{{ route('itens.update', $item) }}" method="POST">
                                            @csrf @method('PUT')
                                            <h2 class="font-black text-slate-800 uppercase mb-6">Editar {{ $item->nome }}</h2>
                                            <div class="space-y-4">
                                                <input type="text" name="nome" value="{{ $item->nome }}" class="w-full border-slate-100 bg-slate-50 rounded-md font-bold focus:ring-indigo-500">
                                                <input type="number" name="quantidade" value="{{ $item->quantidade }}" class="w-full border-slate-100 bg-slate-50 rounded-md font-bold focus:ring-indigo-500">
                                            </div>
                                            <div class="mt-8 flex justify-end gap-4">
                                                <button type="button" x-on:click="$dispatch('close')" class="font-bold text-slate-400 uppercase text-xs">Cancelar</button>
                                                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-black text-xs uppercase">Salvar Alterações</button>
                                            </div>
                                        </form>
                                    </div>
                                </x-modal>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-32 md:space-y-40">
            {{-- 3. Itens  DOS CONVIDADOS --}}
            <div class="bg-white rounded-md md:rounded-md border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 md:p-8 border-b border-slate-50">
                    <h3 class="font-black text-base md:text-lg text-slate-800 uppercase tracking-tighter">Itens dos Convidados</h3>
                </div>
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left border-collapse min-w-[500px]">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 md:px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Convidado</th>
                                <th class="px-6 md:px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Contribuição</th>
                                <th class="px-6 md:px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ação Rápida</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($event->convidados as $convidado)
                                <tr>
                                    <td class="px-6 md:px-8 py-5">
                                        <span class="font-bold text-slate-700 block min-w-[120px]">{{ $convidado->nome }}</span>
                                    </td>
                                    <td class="px-6 md:px-8 py-5 text-center">
                                        @if($convidado->itens->count() > 0)
                                            <div class="flex flex-wrap justify-center gap-1 min-w-[150px]">
                                                @foreach($convidado->itens as $itemViculado)
                                                    <span class="bg-indigo-600 text-white px-2 py-1 rounded-md text-[10px] font-black uppercase whitespace-nowrap">
                                                        {{ $itemViculado->pivot->quantidade_levada }}x {{ $itemViculado->nome }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-slate-300 font-bold text-xs italic">Aguardando...</span>
                                        @endif
                                    </td>
                                    <td class="px-6 md:px-8 py-5 text-right">
                                        <form action="#" method="POST" class="inline-block">
                                            @csrf @method('PUT')
                                            <select onchange="atribuirItem(this, '{{ $convidado->id }}')" class="text-[10px] font-black uppercase bg-slate-50 border-none rounded-md focus:ring-0 cursor-pointer">
                                                <option value="">Atribuir 1un.</option>
                                                @foreach($event->itens as $it)
                                                    @php
                                                        $ocupados = $it->convidados->sum('pivot.quantidade_levada');
                                                        $disponivel = $it->quantidade - $ocupados;
                                                    @endphp
                                                    @if($disponivel > 0)
                                                        <option value="{{ route('itens.vincular', $it) }}">{{ $it->nome }} ({{ $disponivel }})</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarExclusaoItem(id, nome) {
            Swal.fire({
                title: 'Remover Item?',
                text: `Deseja apagar "${nome}" da lista de estoque?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'SIM, EXCLUIR',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true,
                customClass: { popup: 'rounded-md' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-item-' + id).submit();
                }
            });
        }

        function atribuirItem(selectElement, convidadoId) {
            const url = selectElement.value;
            if (url) {
                const form = selectElement.closest('form');
                form.action = url;
                
                const inputConvidado = document.createElement("input");
                inputConvidado.type = "hidden"; inputConvidado.name = "convidado_id"; inputConvidado.value = convidadoId;
                form.appendChild(inputConvidado);

                const inputQtd = document.createElement("input");
                inputQtd.type = "hidden"; inputQtd.name = "quantidade_levada"; inputQtd.value = "1";
                form.appendChild(inputQtd);

                form.submit();
            }
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Perfeito!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'rounded-md' }
            });
        @endif
    </script>
</x-app-layout>