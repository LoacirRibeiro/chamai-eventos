<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">

        <div class="flex flex-wrap justify-between items-end gap-6 mb-10">
            <div>
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-emerald-600 text-sm font-bold transition flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-arrow-left"></i> Voltar ao Painel
                </a>
                <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase">
                    {{ $doacao->titulo }}
                </h2>
                <p class="text-slate-500 mt-2 max-w-2xl font-medium">
                    {{ $doacao->descricao ?? 'Nenhuma descrição fornecida para esta campanha.' }}
                </p>
            </div>

            <div class="flex gap-3">
                <button onclick="abrirOpcoesRelatorio()"
                    class="bg-slate-800 text-white px-6 py-3 rounded-xl font-black text-sm hover:bg-slate-900 transition flex items-center gap-2 shadow-lg shadow-slate-200">
                    <i class="fa-solid fa-file-export text-emerald-400"></i>
                    Exportar Relatório
                </button>

                <button onclick="compartilharWhatsApp()"
                    class="bg-white border border-slate-200 text-slate-600 px-6 py-3 rounded-xl font-black text-sm hover:bg-slate-50 transition flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-emerald-500 text-lg"></i>
                    Compartilhar no WhatsApp
                </button>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm mb-4">O que é necessário?</h3>
                    <form action="{{ route('doacao_itens.store', $doacao) }}" method="POST" class="flex flex-wrap gap-4 items-end">
                        @csrf
                        <div class="w-64">
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Item</label>
                            <input type="text" name="nome" placeholder="Ex: Cestas Básicas" required
                                class="w-full border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Meta</label>
                            <input type="number" name="quantidade_meta" value="1" min="1" required
                                class="w-full border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div class="w-32">
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Unidade</label>
                            <select name="unidade_medida" class="w-full border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="un">un</option>
                                <option value="kg">kg</option>
                                <option value="litros">litros</option>
                                <option value="pacotes">pacotes</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-black text-sm hover:bg-emerald-700 h-[42px] transition">
                            Adicionar
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Lista de Necessidades</h3>
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black px-2 py-1 rounded uppercase">
                            {{ $doacao->itens->count() }} Itens
                        </span>
                    </div>

                    <div class="divide-y divide-slate-50">
                        @forelse($doacao->itens as $item)
                            <div class="p-6 flex justify-between items-center hover:bg-slate-50 transition">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $item->nome }}</p>
                                    <p class="text-xs text-slate-400 font-medium">
                                        Meta: {{ $item->quantidade_meta }} {{ $item->unidade_medida }}
                                        <span class="mx-1">•</span>
                                        Já temos: {{ $item->quantidade_arrecadada }} {{ $item->unidade_medida }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="text-right">
                                        @php
                                            $porcentagem = $item->quantidade_meta > 0 ? ($item->quantidade_arrecadada / $item->quantidade_meta) * 100 : 0;
                                            $exibirPorcentagem = $porcentagem > 100 ? 100 : $porcentagem;
                                        @endphp
                                        <p class="text-sm font-black text-emerald-600">{{ number_format($porcentagem, 0) }}%</p>
                                        <div class="w-16 h-1 bg-slate-100 rounded-full mt-1 overflow-hidden">
                                            <div class="bg-emerald-500 h-full transition-all duration-500" style="width: {{ $exibirPorcentagem }}%"></div>
                                        </div>
                                    </div>

                                    <div class="flex gap-2">
                                        <a href="{{ route('doacao_itens.edit', $item) }}" class="text-slate-300 hover:text-amber-500 transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('doacao_itens.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-delete text-slate-300 hover:text-rose-500 transition">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <i class="fa-solid fa-box-open text-4xl text-slate-200 mb-4"></i>
                                <p class="text-slate-400 font-medium text-sm">Nenhum item cadastrado.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-emerald-900 text-white rounded-2xl p-8 shadow-xl relative overflow-hidden">
                    <i class="fa-solid fa-heart absolute -right-4 -bottom-4 text-8xl text-emerald-800/50 rotate-12"></i>
                    <h4 class="font-black text-xs uppercase tracking-[0.2em] mb-6 opacity-70 text-emerald-300">Status</h4>
                    <div class="relative z-10">
                        <p class="text-4xl font-black mb-2 uppercase">{{ $doacao->status }}</p>
                        <p class="text-emerald-300 text-sm font-medium">
                            {{ $doacao->data_limite ? 'Expira em ' . \Carbon\Carbon::parse($doacao->data_limite)->format('d/m/Y') : 'Campanha Vitalícia' }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h4 class="font-black text-slate-800 text-xs uppercase tracking-widest">Doadores Recentes</h4>
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black px-2 py-1 rounded uppercase">
                            {{ $doacao->itens->flatMap->participantes->count() }} total
                        </span>
                    </div>

                    <div class="divide-y divide-slate-50 max-h-[500px] overflow-y-auto custom-scrollbar">
                        @php
                            // Coleta participantes de todos os itens e ordena pela data de criação
                            $todosParticipantes = $doacao->itens->flatMap(function($item) {
                                return $item->participantes;
                            })->sortByDesc('created_at');
                        @endphp

                        @forelse($todosParticipantes as $participante)
                            <div class="p-4 hover:bg-slate-50 transition group">
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 capitalize">{{ $participante->nome }}</p>
                                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $participante->whatsapp) }}"
                                           target="_blank"
                                           class="text-[10px] text-emerald-600 font-bold hover:text-emerald-700 flex items-center gap-1 mt-0.5">
                                            <i class="fa-brands fa-whatsapp text-xs"></i>
                                            {{ $participante->whatsapp }}
                                        </a>
                                    </div>
                                    <span class="text-[9px] font-bold text-slate-300 uppercase whitespace-nowrap">
                                        {{ $participante->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <div class="mt-3 bg-slate-100/50 rounded-xl p-2 border border-transparent group-hover:border-emerald-100 group-hover:bg-white transition">
                                    <p class="text-[9px] font-black text-slate-400 uppercase leading-none mb-1">Doação efetuada:</p>
                                    <p class="text-xs font-bold text-slate-700">
                                        <span class="text-emerald-600">{{ $participante->quantidade }}x</span>
                                        {{ $participante->item->nome ?? 'Item da Lista' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <i class="fa-solid fa-user-clock text-slate-200 text-3xl mb-3"></i>
                                <p class="text-xs text-slate-400 font-medium italic">Nenhuma doação registrada.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center text-[10px] font-black uppercase tracking-wider">
                        <span class="text-slate-400">Total Arrecadado</span>
                        <span class="text-emerald-600 text-sm">
                            {{ $doacao->itens->sum('quantidade_arrecadada') }} itens
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Captura todos os botões de excluir com a classe 'btn-delete'
            const deleteButtons = document.querySelectorAll('.btn-delete');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Tem certeza?',
                        text: "Você não poderá reverter esta ação!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981', // emerald-600
                        cancelButtonColor: '#ef4444', // rose-500
                        confirmButtonText: 'Sim, excluir!',
                        cancelButtonText: 'Cancelar',
                        background: '#ffffff',
                        borderRadius: '1.25rem',
                        customClass: {
                            title: 'font-black text-slate-800',
                            popup: 'rounded-2xl border border-slate-100 shadow-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

        function abrirOpcoesRelatorio() {
            Swal.fire({
                title: 'Gerar Relatório',
                text: "Deseja visualizar o relatório completo de doações em PDF?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#10b981', // emerald-600
                cancelButtonColor: '#0f172a', // slate-900
                confirmButtonText: '<i class="fa-solid fa-file-pdf mr-2"></i> Visualizar PDF',
                cancelButtonText: 'Cancelar',
                background: '#ffffff',
                borderRadius: '1.25rem',
                customClass: {
                    title: 'font-black text-slate-800',
                    popup: 'rounded-2xl border border-slate-100 shadow-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Esta é a parte que abre a rota que criamos no web.php
                    window.open("{{ route('doacoes.pdf', $doacao->id) }}", '_blank');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#10b981', // emerald-600
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#ef4444', // rose-500
                });
            @endif
        });

        function compartilharWhatsApp() {
            // Pegamos o token e o título direto do Blade
            const token = "{{ $doacao->token }}";
            const titulo = "{{ $doacao->titulo }}";
            
            // Monta a URL pública (ajusta automaticamente se estiver em localhost ou produção)
            const urlPublica = window.location.origin + '/doar/' + token;
            
            const mensagem = encodeURIComponent(
                `Olá! 👋 Estou organizando a campanha *${titulo}* e precisamos de ajuda com alguns itens. \n\n` +
                `Você pode escolher como ajudar clicando no link abaixo: \n` +
                urlPublica
            );

            // Abre o WhatsApp em uma nova aba
            window.open(`https://wa.me/?text=${mensagem}`, '_blank');
        }
    </script>
    
</x-app-layout>