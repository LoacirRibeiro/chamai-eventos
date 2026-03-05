<!-- <x-guest-layout>
    <div class="max-w-md mx-auto py-6 px-4">
        
        {{-- CABEÇALHO --}}
        <div class="text-center mb-10">
            <div class="inline-flex w-20 h-20 bg-emerald-600 rounded-md items-center justify-center shadow-2xl shadow-emerald-100 rotate-6 mb-6">
                <i class="fa-solid fa-hand-holding-heart text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tighter leading-tight">{{ $campanha->titulo }}</h1>
        </div>

        {{-- FORMULÁRIO COM ID PARA O JS --}}
        <form id="formDoacao" action="{{ route('doacao.registrar', $campanha->token) }}" method="POST" class="space-y-6">
            @csrf

            {{-- INPUT NOME --}}
            <div class="bg-white p-6 rounded-md shadow-sm border border-slate-100">
                <label class="block text-[11px] font-black uppercase text-slate-400 mb-3 ml-2 tracking-widest">Quem está doando?</label>
                <input type="text" name="nome_doador" id="nome_doador" placeholder="Seu nome ou apelido" 
                       class="w-full bg-slate-50 border-none rounded-md py-4 px-5 font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all">
            </div>

            {{-- LISTA DE ITENS --}}
            <div class="space-y-3">
                @foreach($campanha->itens as $item)
                    @php
                        $totalDoado = $item->registros_sum_quantidade_doada ?? 0;
                        $restante = max(0, $item->quantidade_necessaria - $totalDoado);
                    @endphp

                    @if($restante > 0)
                    <div class="bg-white p-5 rounded-md border border-slate-50 shadow-sm flex items-center justify-between">
                        <div class="min-w-0 pl-2">
                            <p class="font-black text-slate-800 text-base truncate">{{ $item->nome }}</p>
                            <span class="text-[10px] font-bold text-emerald-500 uppercase">Faltam {{ $restante }}</span>
                        </div>
                        <input type="number" name="itens[{{ $item->id }}]" min="0" max="{{ $restante }}" value="0"
                               class="input-qtd w-20 bg-slate-100 border-none rounded-md py-3 text-center font-black text-slate-800 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    @endif
                @endforeach
            </div>

            <button type="button" onclick="validarEEnviar()" class="w-full bg-slate-900 text-white py-6 rounded-md font-black uppercase tracking-[0.2em] shadow-xl hover:bg-emerald-600 transition-all duration-300">
                Confirmar Doação
            </button>
        </form>
    </div>

    {{-- SCRIPTS SWEETALERT --}}
    <script>
        // 1. Mensagem de Sucesso (Vinda do Controller via Session)
        @if(session('success'))
            Swal.fire({
                title: 'Obaaa!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'DE NADA!',
                confirmButtonColor: '#059669', // Emerald-600
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-md',
                    confirmButton: 'rounded-md px-8 py-3 font-black uppercase text-xs tracking-widest'
                }
            });
        @endif

        // 2. Validação Antes de Enviar
        function validarEEnviar() {
            const nome = document.getElementById('nome_doador').value.trim();
            const inputsQtd = document.querySelectorAll('.input-qtd');
            let totalItens = 0;

            inputsQtd.forEach(input => {
                totalItens += parseInt(input.value);
            });

            // Valida se o nome foi preenchido
            if (nome === "") {
                Swal.fire({
                    title: 'Ops!',
                    text: 'Precisamos saber seu nome para registrar a doação.',
                    icon: 'warning',
                    confirmButtonColor: '#1e293b', // Slate-900
                    customClass: { popup: 'rounded-md' }
                });
                return;
            }

            // Valida se escolheu pelo menos um item
            if (totalItens === 0) {
                Swal.fire({
                    title: 'Carrinho vazio?',
                    text: 'Por favor, selecione a quantidade de pelo menos um item.',
                    icon: 'info',
                    confirmButtonColor: '#1e293b',
                    customClass: { popup: 'rounded-md' }
                });
                return;
            }

            // Se tudo estiver OK, confirma antes de enviar
            Swal.fire({
                title: 'Tudo certo?',
                text: "Deseja confirmar sua doação de " + totalItens + " item(ns)?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#f43f5e',
                confirmButtonText: 'SIM, CONFIRMAR!',
                cancelButtonText: 'REVISAR',
                customClass: {
                    popup: 'rounded-md',
                    confirmButton: 'rounded-md px-6 py-3 font-black',
                    cancelButton: 'rounded-md px-6 py-3 font-black'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formDoacao').submit();
                }
            });
        }
    </script>
</x-guest-layout> -->