<!-- <x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[3rem] p-10 border border-slate-100">
                
                {{-- CABEÇALHO --}}
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <h2 class="text-3xl font-black text-slate-800 tracking-tighter italic">Lançar Campanha</h2>
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-1">Defina o nome e a data do seu evento</p>
                    </div>
                    
                    {{-- CONTADOR (Aparece ao selecionar a data) --}}
                    <div id="countdown" class="bg-indigo-50 px-6 py-3 rounded-2xl text-center border border-indigo-100 hidden animate-bounce">
                        <span id="timer" class="block font-black text-indigo-600 text-lg tabular-nums">00:00:00</span>
                        <span class="text-[9px] font-black uppercase text-indigo-400 tracking-tighter">Tempo Restante</span>
                    </div>
                </div>

                {{-- FORMULÁRIO --}}
                <form id="mainForm" action="{{ route('doacao.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    {{-- CAMPO: TÍTULO --}}
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-3 ml-4 tracking-widest group-focus-within:text-indigo-500 transition-colors">Título da Campanha</label>
                        <input type="text" name="titulo" required 
                               placeholder="Ex: Arrecadação de Natal 2026" 
                               class="w-full border-none bg-slate-50 rounded-[2rem] py-5 px-8 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300">
                    </div>

                    {{-- CAMPO: DATA --}}
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-3 ml-4 tracking-widest group-focus-within:text-indigo-500 transition-colors">Data e Hora do Evento</label>
                        <input type="datetime-local" name="data_evento" id="data_evento" required 
                               onchange="startCountdown(this.value)"
                               class="w-full border-none bg-slate-50 rounded-[2rem] py-5 px-8 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 transition-all">
                    </div>

                    {{-- BOTÕES DE AÇÃO --}}
                    <div class="flex flex-col gap-4 pt-4">
                        <button type="button" onclick="confirmarSalvamento()" 
                                class="w-full bg-slate-900 text-white py-6 rounded-[2.5rem] font-black uppercase tracking-[0.2em] shadow-2xl shadow-slate-200 hover:bg-indigo-600 hover:-translate-y-1 transition-all duration-300 active:scale-95">
                            Próximo Passo: Itens
                        </button>
                        
                        <a href="{{ route('doacao.index') }}" 
                           class="text-center py-2 text-slate-400 font-black uppercase text-[10px] tracking-widest hover:text-slate-600 transition-colors">
                            Voltar para a lista
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Função do Contador Regressivo
        function startCountdown(dateValue) {
            const display = document.getElementById('countdown');
            const timer = document.getElementById('timer');
            if(!dateValue) return;

            display.classList.remove('hidden');
            
            const updateTimer = () => {
                const now = new Date().getTime();
                const eventDate = new Date(dateValue).getTime();
                const distance = eventDate - now;

                if (distance < 0) {
                    timer.innerHTML = "JÁ INICIOU!";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                timer.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            };

            updateTimer();
            setInterval(updateTimer, 1000);
        }

        // SweetAlert de Confirmação
        function confirmarSalvamento() {
            const titulo = document.querySelector('input[name="titulo"]').value;
            if(!titulo) {
                Swal.fire({ icon: 'error', title: 'Atenção', text: 'Dê um nome para sua campanha!', customClass: { popup: 'rounded-[2rem]' }});
                return;
            }

            Swal.fire({
                title: 'Confirmar Campanha?',
                text: "Você poderá adicionar os itens de doação na próxima tela.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e293b',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'BORA!',
                cancelButtonText: 'ESPERA',
                customClass: {
                    popup: 'rounded-[2.5rem]',
                    confirmButton: 'rounded-full px-8 py-3 font-black',
                    cancelButton: 'rounded-full px-8 py-3 font-black'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('mainForm').submit();
                }
            })
        }
    </script>
</x-app-layout> -->