<x-guest-layout> {{-- Use o layout de visitante --}}
    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-md p-8 shadow-xl border border-slate-100 text-center">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-md flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-hand-holding-heart text-3xl"></i>
            </div>
            
            <h1 class="font-black text-3xl text-slate-800 mb-2">{{ $event->titulo }}</h1>
            <p class="text-slate-500 font-medium mb-8">Ajude-nos nesta causa! Clique abaixo para ver os itens necessários.</p>

            <button onclick="abrirIdentificacao()" class="w-full bg-emerald-500 text-white py-4 rounded-md font-black uppercase tracking-widest hover:bg-emerald-600 transition shadow-lg shadow-emerald-200">
                Quero Participar
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function abrirIdentificacao() {
            Swal.fire({
                title: 'Como podemos te chamar?',
                input: 'text',
                inputPlaceholder: 'Seu nome ou apelido',
                showCancelButton: true,
                confirmButtonText: 'CONFIRMAR',
                confirmButtonColor: '#10b981',
                customClass: { popup: 'rounded-md' },
                preConfirm: (nome) => {
                    if (!nome) {
                        Swal.showValidationMessage('Por favor, digite seu nome');
                    }
                    return nome;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('doacao.participar', $event->public_token) }}";
                    form.innerHTML = `@csrf <input type="hidden" name="nome" value="${result.value}">`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-guest-layout>