<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4 px-1">
            <div class="flex items-center gap-3">
                <a href="{{ route('events.show', $event) }}" class="w-8 h-8 flex shrink-0 items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <div class="min-w-0">
                    <h2 class="font-black text-[38px] md:text-[38px] text-slate-800 tracking-tight truncate leading-tight">Itens da Festa</h2>
                    <p class="text-[12px] font-bold text-slate-400 uppercase tracking-widest truncate">
                         <i class="fa-solid fa-bolt-lightning text-indigo-400 mr-2 text-[14px]"></i> {{ $event->titulo }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-10">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 space-y-4 md:space-y-8">
            
            {{-- 1. FORMULÁRIO COMPACTO (Estilo Card) --}}
            <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm md:max-w-sm">
                <h3 class="font-black text-[12px] text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-indigo-500"></i> Novo Item
                </h3>
                <form action="{{ route('itens.store', $event) }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    <input type="text" name="nome" placeholder="Nome do Item" required 
                           class="w-full border-slate-100 bg-slate-50 rounded-lg font-bold text-[14px] focus:ring-indigo-500 py-2.5">
                    <input type="number" name="quantidade" placeholder="Qtd. Total" min="1" required 
                           class="w-full border-slate-100 bg-slate-50 rounded-lg font-bold text-[14px] focus:ring-indigo-500 py-2.5">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-black text-[14px] uppercase tracking-widest hover:bg-indigo-700 transition">
                        Adicionar à Lista
                    </button>
                </form>
            </div>

            {{-- 2. LISTA DE ESTOQUE --}}
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-50 bg-white">
                    <h3 class="font-black text-[12px] md:text-[12px] text-slate-800 uppercase tracking-widest">Itens Necessários</h3>
                </div>

                <div class="w-full overflow-x-auto">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-4 py-3 text-[12px] font-black text-slate-400 uppercase text-left">Item</th>
                                    <th class="px-4 py-3 text-[12px] font-black text-slate-400 uppercase text-center">Qtd</th>
                                    <th class="px-4 py-3 text-[12px] font-black text-slate-400 uppercase text-center">Disponivel</th>
                                    <th class="px-4 py-3 text-[12px] font-black text-slate-400 uppercase text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 bg-white">
                                @foreach($event->itens as $item)
                                    @php
                                        $jaOcupados = $item->convidados->sum('pivot.quantidade_levada');
                                        $vagasLivres = max(0, $item->quantidade - $jaOcupados);
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-4 py-4 whitespace-nowrap font-bold text-[14px] text-slate-700">{{ $item->nome }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center font-bold text-[14px] text-slate-500">{{ $item->quantidade }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <span class="px-2 py-0.5 rounded text-[12px] font-black uppercase tracking-tighter {{ $vagasLivres > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                {{ $vagasLivres }} Disponíveis
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right">
                                            <div class="flex justify-end gap-1">
                                                <button onclick="confirmarExclusaoItem('{{ $item->id }}', '{{ $item->nome }}')" 
                                                        class="p-2 bg-rose-50 text-rose-600 rounded-lg border border-rose-100">
                                                    <i class="fa-solid fa-trash text-[12px]"></i>
                                                </button>
                                                <form id="delete-item-{{ $item->id }}" action="{{ route('itens.destroy', $item) }}" method="POST" class="hidden">
                                                    @csrf @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 3. QUEM LEVA O QUÊ (Contribuição) --}}
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-50 bg-white">
                    <h3 class="font-black text-[12px] md:text-[12px] text-slate-800 uppercase tracking-widest">Quem leva o quê?</h3>
                </div>

                <div class="w-full overflow-x-auto">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-4 py-3 text-[12px] font-black text-slate-400 uppercase text-left">Convidado</th>
                                    <th class="px-4 py-3 text-[12px] font-black text-slate-400 uppercase text-center">Itens</th>
                                    <th class="px-4 py-3 text-[12px] font-black text-slate-400 uppercase text-right">Atribuir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 bg-white">
                                @foreach($event->convidados as $convidado)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        {{-- Nome do Convidado --}}
                                        <td class="px-4 py-4 font-bold text-[14px] text-slate-700">
                                            {{ $convidado->nome }}
                                        </td>

                                        {{-- Itens Vinculados --}}
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex flex-wrap justify-center gap-1 min-w-[120px]">
                                                @forelse($convidado->itens as $itemViculado)
                                                    <span class="inline-block bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-md text-[10px] font-black uppercase whitespace-nowrap">
                                                        {{ $itemViculado->pivot->quantidade_levada }}x {{ $itemViculado->nome }}
                                                    </span>
                                                @empty
                                                    <span class="text-slate-300 text-[10px] font-bold italic whitespace-nowrap">Nenhum item</span>
                                                @endforelse
                                            </div>
                                        </td>

                                        {{-- Ação de Atribuir --}}
                                        <td class="px-4 py-4 whitespace-nowrap text-right">
                                            <form action="#" method="POST" class="inline-block">
                                                @csrf @method('PUT')
                                                <select onchange="atribuirItem(this, '{{ $convidado->id }}')" 
                                                        class="text-[12px] font-black uppercase bg-slate-50 border-slate-100 rounded-md focus:ring-0 cursor-pointer py-1 px-2">
                                                    <option value="">+ Item</option>
                                                    @foreach($event->itens as $it)
                                                        @php
                                                            $disponivel = $it->quantidade - $it->convidados->sum('pivot.quantidade_levada');
                                                        @endphp
                                                        @if($disponivel > 0)
                                                            <option value="{{ route('itens.vincular', $it) }}">
                                                                {{ $it->nome }} ({{ $disponivel }})
                                                            </option>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarExclusaoItem(id, nome) {
            Swal.fire({
                title: 'Remover Item?',
                text: `Deseja apagar "${nome}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'SIM, EXCLUIR',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true,
                customClass: { popup: 'rounded-[2.5rem]' } {{-- Mantendo o estilo que você gostou --}}
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
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'rounded-[2.5rem]' }
            });
        @endif
    </script>
</x-app-layout>