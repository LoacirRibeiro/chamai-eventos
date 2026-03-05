<x-guest-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-2">
            <div>
                <h2 class="font-black text-2xl text-slate-800 tracking-tight">{{ $event->titulo }}</h2>
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">
                    Olá, {{ session("doador_nome_{$event->id}") }}! Escolha como ajudar:
                </p>
            </div>
        </div>
    </x-slot>

    {{-- SEÇÃO: MINHAS DOAÇÕES --}}
@if($meuRegistro && $meuRegistro->itens->count() > 0)
    <div class="mb-10">
        <h3 class="font-black text-[12px] text-emerald-600 uppercase tracking-widest mb-4 px-2">
            <i class="fa-solid fa-circle-check mr-1"></i> Minhas Contribuições
        </h3>
        <div class="space-y-3">
            @foreach($meuRegistro->itens as $meuItem)
                <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-md flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-emerald-900">{{ $meuItem->nome }}</h4>
                        <p class="text-[11px] font-black text-emerald-600 uppercase">Você vai levar: {{ $meuItem->pivot->quantidade_levada }} un.</p>
                    </div>
                    
                    <div class="flex gap-2">
                        {{-- Botão Editar --}}
                        <button onclick="confirmarDoacao('{{ $meuItem->id }}', '{{ $meuItem->nome }}', 100, {{ $meuItem->pivot->quantidade_levada }})" 
                                class="w-8 h-8 bg-white text-emerald-600 rounded-md shadow-sm flex items-center justify-center hover:bg-emerald-100">
                            <i class="fa-solid fa-pen text-[10px]"></i>
                        </button>

                        {{-- Botão Cancelar --}}
                        <form action="{{ route('doacao.cancelar', [$event->public_token, $meuItem->id]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-8 h-8 bg-white text-rose-500 rounded-md shadow-sm flex items-center justify-center hover:bg-rose-50">
                                <i class="fa-solid fa-times text-[10px]"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <hr class="mt-8 border-slate-100">
    </div>
@endif

    <div class="py-6 px-4 max-w-2xl mx-auto space-y-4">
        @foreach($event->itens as $item)
            @php
                $jaOcupados = $item->convidados->sum('pivot.quantidade_levada');
                $vagasLivres = max(0, $item->quantidade - $jaOcupados);
            @endphp

            <div class="bg-white p-5 rounded-md border border-slate-100 shadow-sm flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <h3 class="font-black text-slate-700 text-lg truncate">{{ $item->nome }}</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter">
                        {{ $vagasLivres }} unidades restantes
                    </p>
                </div>

                @if($vagasLivres > 0)
                    <button onclick="confirmarDoacao('{{ $item->id }}', '{{ $item->nome }}', {{ $vagasLivres }})" 
                            class="bg-emerald-500 text-white px-6 py-3 rounded-md font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition shadow-md shadow-emerald-100 shrink-0">
                        Doar
                    </button>
                @else
                    <span class="bg-slate-100 text-slate-400 px-4 py-3 rounded-md font-black text-xs uppercase tracking-widest shrink-0">
                        Completo
                    </span>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Script para processar a doação --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarDoacao(itemId, itemNome, maxQtd) {
            Swal.fire({
                title: `Doar ${itemNome}`,
                text: 'Quantas unidades você pode levar?',
                input: 'number',
                inputAttributes: { min: 1, max: maxQtd, step: 1 },
                inputValue: 1,
                showCancelButton: true,
                confirmButtonText: 'CONFIRMAR DOAÇÃO',
                confirmButtonColor: '#10b981',
                customClass: { popup: 'rounded-md' }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aqui enviaremos para a rota que registra a doação
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/doar/registrar/${itemId}`; // Criaremos esta rota a seguir
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="quantidade" value="${result.value}">
                        <input type="hidden" name="nome_doador" value="{{ session("doador_nome_{$event->id}") }}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-guest-layout>