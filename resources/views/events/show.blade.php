@php $event = $event; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-md bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-slate-800 tracking-tight leading-none">
                        {{ $event->titulo }}
                    </h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">
                        <i class="fa-solid fa-location-dot text-indigo-400 mr-1"></i> {{ $event->local }}
                    </p>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('convidados.create', $event) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Convidar
                </a>
                <a href="{{ route('dashboard') }}" class="bg-slate-100 text-slate-500 px-4 py-2 rounded-md font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition flex items-center gap-2">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Cards de Resumo --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-md border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-md flex items-center justify-center text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total</p>
                        <h4 class="text-2xl font-black text-slate-800">{{ $event->convidados->count() }}</h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-md border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-md flex items-center justify-center text-xl">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Confirmados</p>
                        <h4 class="text-2xl font-black text-emerald-600">
                            {{ $event->convidados->where('presenca', 'confirmado')->count() }}
                        </h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-md border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-md flex items-center justify-center text-xl">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Pendentes</p>
                        <h4 class="text-2xl font-black text-amber-600">
                            {{ $event->convidados->where('presenca', 'pendente')->count() }}
                        </h4>
                    </div>
                </div>
            </div>

            {{-- Tabela de Convidados --}}
            <div class="bg-white rounded-md border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-white">
                    <h3 class="font-black text-lg text-slate-800 uppercase tracking-tighter">Lista de Convidados</h3>
                    <button onclick="window.print()" class="text-slate-400 hover:text-indigo-600 transition text-sm font-bold uppercase tracking-widest">
                        <i class="fa-solid fa-print"></i> Imprimir
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nome</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($event->convidados as $convidado)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-md flex items-center justify-center font-black text-sm uppercase">
                                                {{ substr($convidado->nome, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-700 leading-tight">{{ $convidado->nome }}</p>
                                                <p class="text-[10px] text-slate-400 font-bold tracking-tight">
                                                    <i class="fa-brands fa-whatsapp text-emerald-400"></i> {{ $convidado->telefone ?? 'Sem telefone' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        @php
                                            $statusClasses = [
                                                'confirmado' => 'bg-emerald-100 text-emerald-700',
                                                'recusado' => 'bg-rose-100 text-rose-700',
                                                'pendente' => 'bg-slate-100 text-slate-400'
                                            ];
                                            $status = $convidado->presenca ?? 'pendente';
                                        @endphp
                                        <span class="px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest {{ $statusClasses[$status] }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex justify-end gap-2 items-center">
                                            
                                            {{-- AÇÃO: ENVIAR WHATSAPP --}}
                                            @if($convidado->telefone)
                                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $convidado->telefone) }}?text={{ urlencode('Olá ' . explode(' ', $convidado->nome)[0] . '! 🚀' . PHP_EOL . 'Confirme sua presença pelo link:' . PHP_EOL . route('convite.publico', $convidado->token_acesso)) }}" 
                                                target="_blank"
                                                class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-md hover:bg-emerald-600 hover:text-white transition-all border border-emerald-100" 
                                                title="Enviar WhatsApp">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                    <span class="text-[10px] font-black uppercase tracking-widest">Enviar</span>
                                                </a>
                                            @endif

                                            {{-- AÇÃO: EDITAR --}}
                                            <a href="{{ route('convidados.edit', $convidado) }}" 
                                            class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition-all border border-indigo-100" 
                                            title="Editar Convidado">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Editar</span>
                                            </a>

                                            {{-- AÇÃO: STATUS (Mudar Status) --}}
                                            <!-- <button type="button" 
                                                    onclick="escolherStatus('{{ $convidado->id }}', '{{ $convidado->nome }}')" 
                                                    class="flex items-center gap-2 px-3 py-1.5 bg-amber-50 text-amber-600 rounded-md hover:bg-amber-600 hover:text-white transition-all border border-amber-100 cursor-pointer" 
                                                    title="Mudar Status">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Status</span>
                                            </button> -->

                                            <!-- {{-- Formulário Oculto para o Status --}}
                                            <form id="status-form-{{ $convidado->id }}" action="{{ route('convidados.update', $convidado) }}" method="POST" class="hidden">
                                                @csrf 
                                                @method('PUT')
                                                <input type="hidden" name="presenca" id="status-input-{{ $convidado->id }}">
                                            </form> -->

                                            {{-- AÇÃO: EXCLUIR --}}
                                            <button type="button" 
                                                    onclick="confirmarExclusao('{{ $convidado->id }}', '{{ $convidado->nome }}')" 
                                                    class="flex items-center gap-2 px-3 py-1.5 bg-rose-50 text-rose-600 rounded-md hover:bg-rose-600 hover:text-white transition-all border border-rose-100 cursor-pointer">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Excluir</span>
                                            </button>

                                            {{-- Formulário oculto para exclusão --}}
                                            <form id="delete-form-{{ $convidado->id }}" action="{{ route('convidados.destroy', $convidado) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center text-slate-400 font-medium italic bg-slate-50/30">
                                        Nenhum convidado na lista ainda.
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
                customClass: { popup: 'rounded-[2.5rem]' }
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
                customClass: { popup: 'rounded-[2.5rem]' }
            });
        @endif
    </script>
</x-app-layout>