@php $event = $event; @endphp
<x-app-layout>
    <x-slot name="header">
        {{-- Header  --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 px-1">
            <div class="flex items-center gap-3 w-full">
                <a href="{{ route('dashboard') }}" class="w-8 h-8 flex shrink-0 items-center justify-center rounded-md bg-white border border-slate-200 text-slate-400 shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <div class="min-w-0">
                    <h2 class="font-black text-[26px] md:text-[26px] text-slate-800 tracking-tight truncate leading-tight">
                        {{ $event->titulo }}
                    </h2>
                    <p class="text-[12px] font-bold text-slate-400 uppercase tracking-widest truncate">
                        {{ $event->local }}
                    </p>
                </div>
            </div>

            {{-- Botões lado a lado mesmo no mobile pequeno --}}
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ route('convidados.create', $event) }}" class="flex-1 sm:flex-none justify-center bg-indigo-600 text-white px-3 py-2 rounded-md font-black text-[12px] uppercase tracking-widest hover:bg-indigo-700 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Convidar
                </a>
                <a href="{{ route('dashboard') }}" class="flex-1 sm:flex-none justify-center bg-slate-100 text-slate-500 px-3 py-2 rounded-md font-black text-[12px] uppercase tracking-widest hover:bg-slate-200 flex items-center gap-2">
                    <i class="fa-solid fa-house"></i> Início
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Reduzi o padding de py-12 para py-4 em telas pequenas --}}
    <div class="py-4 md:py-10">
        {{-- Mudança crucial: px-2 abaixo de 640px para ganhar espaço --}}
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 space-y-4 md:space-y-8">
            
            {{-- Cards de Resumo: Grid 1 coluna no mobile e 3 colunas acima de 640px --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-6">
                <div class="bg-white p-4 rounded-md border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-10 h-10 bg-slate-50 text-slate-400 rounded-md flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[12px] font-black text-slate-400 uppercase tracking-tighter ">Total</p>
                        <h4 class="text-lg font-black text-slate-800 leading-none">{{ $event->convidados->count() }}</h4>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-md border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-md flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[12px] font-black text-slate-400 uppercase tracking-tighter">Confirmados</p>
                        <h4 class="text-lg font-black text-emerald-600 leading-none">{{ $event->convidados->where('presenca', 'confirmado')->count() }}</h4>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-md border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-md flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-clock text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[12px] font-black text-slate-400 uppercase tracking-tighter">Pendentes</p>
                        <h4 class="text-lg font-black text-amber-600 leading-none">{{ $event->convidados->where('presenca', 'pendente')->count() }}</h4>
                    </div>
                </div>
            </div>

            {{-- Container da Tabela --}}
            <div class="bg-white rounded-md border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-4 md:p-8 border-b border-slate-50 flex justify-between items-center bg-white">
                    <h3 class="font-black text-xs md:text-lg text-slate-800 uppercase">Lista</h3>
                    <a href="{{ route('events.print', $event) }}" target="_blank" class="text-slate-400 text-[15px] font-bold uppercase tracking-widest hover:text-indigo-600 transition">
                        <i class="fa-solid fa-print"></i> <span class="hidden xs:inline">Imprimir Relatório</span>
                    </a>
                </div>

                {{-- Tabela: Lista' --}}
                <div class="w-full overflow-x-auto">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-4 md:px-8 py-3 text-[12px] font-black text-slate-400 uppercase text-left">Nome</th>
                                    <th class="px-4 md:px-8 py-3 text-[12px] font-black text-slate-400 uppercase text-center">Status</th>
                                    <th class="px-4 md:px-8 py-3 text-[12px] font-black text-slate-400 uppercase text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 bg-white">
                                @forelse($event->convidados as $convidado)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-4 md:px-8 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded flex shrink-0 items-center justify-center font-black text-[14px] uppercase">
                                                    {{ substr($convidado->nome, 0, 1) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-bold text-[14px] text-slate-700 leading-tight truncate max-w-[100px] xs:max-w-none">{{ $convidado->nome }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $convidado->telefone ?? 'S/ Tel' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 md:px-8 py-4 text-center whitespace-nowrap">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-tighter
                                                {{ $convidado->presenca == 'confirmado' ? 'bg-emerald-100 text-emerald-700' : ($convidado->presenca == 'recusado' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-500') }}">
                                                {{ $convidado->presenca ?? 'Pendente' }}
                                            </span>
                                        </td>
                                        <td class="px-4 md:px-8 py-4 text-right whitespace-nowrap">
                                            <div class="flex justify-end gap-1">
                                                {{-- WhatsApp Compacto --}}
                                                @if($convidado->telefone)
                                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $convidado->telefone) }}" target="_blank" class="p-2 bg-emerald-50 text-emerald-600 rounded-md border border-emerald-100">
                                                        <i class="fa-brands fa-whatsapp text-xs"></i>
                                                    </a>
                                                @endif
                                                {{-- Editar --}}
                                                <a href="{{ route('convidados.edit', $convidado) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-md border border-indigo-100">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                                </a>
                                                {{-- Excluir --}}
                                                <button onclick="confirmarExclusao('{{ $convidado->id }}', '{{ $convidado->nome }}')" class="p-2 bg-rose-50 text-rose-600 rounded-md border border-rose-100">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- ... empty ... --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // 1. Função de Exclusão
        function confirmarExclusao(id, nome) {
            Swal.fire({
                title: 'Remover Convidado?',
                text: `Deseja tirar ${nome} da lista?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'SIM, REMOVER',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true,
                customClass: { popup: 'rounded-md' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // 2. Função de Escolha de Status
        function escolherStatus(id, nome) {
            Swal.fire({
                title: 'Alterar Status',
                text: `Como deseja marcar ${nome}?`,
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Confirmado',
                denyButtonText: 'Recusado',
                cancelButtonText: 'Pendente',
                confirmButtonColor: '#10b981',
                denyButtonColor: '#f43f5e',
                cancelButtonColor: '#94a3b8',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2.5rem]',
                    confirmButton: 'rounded-xl font-black uppercase text-[10px] px-4 py-2',
                    denyButton: 'rounded-xl font-black uppercase text-[10px] px-4 py-2',
                    cancelButton: 'rounded-xl font-black uppercase text-[10px] px-4 py-2'
                }
            }).then((result) => {
                let novoStatus = '';
                if (result.isConfirmed) novoStatus = 'confirmado';
                else if (result.isDenied) novoStatus = 'recusado';
                else if (result.dismiss === Swal.DismissReason.cancel) novoStatus = 'pendente';
                else return;

                document.getElementById('status-input-' + id).value = novoStatus;
                document.getElementById('status-form-' + id).submit();
            });
        }

        // 3. Feedback de Sucesso (Executa se houver sessão)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                customClass: { popup: 'rounded-md' }
            });
        @endif
    </script>
</x-app-layout>