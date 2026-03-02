<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convite Especial | Chamaí</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
        
        .swal2-confirm { background-color: #4f46e5 !important; border-radius: 1rem !important; font-weight: bold !important; }
        .swal2-styled.swal2-cancel { border-radius: 1rem !important; }
    </style>
</head>
<body class="bg-indigo-600 min-h-screen flex flex-col items-center">

    <div class="bg-white w-full min-h-screen md:min-h-0 md:max-w-4xl md:my-10 md:rounded-md shadow-2xl overflow-hidden p-6 md:p-12 text-center relative">
        
        <div class="text-6xl mb-6 animate-bounce mt-4">🎉</div>
        
        <h2 class="text-slate-500 font-medium text-lg md:text-xl mb-1 italic">Olá, {{ $convidado->nome }}!</h2>
        <h1 class="text-3xl md:text-5xl font-black text-slate-800 mb-8 tracking-tighter">Você foi convidado para:</h1>

        <div class="bg-slate-50 rounded-md p-6 md:p-10 mb-10 border border-slate-100 shadow-inner">
            <h3 class="text-2xl md:text-4xl font-black text-indigo-600 mb-4">{{ $evento->titulo }}</h3>
            <p class="text-slate-600 text-base md:text-lg mb-8 max-w-2xl mx-auto leading-relaxed">{{ $evento->descricao }}</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 text-left max-w-2xl mx-auto">
                <div class="flex items-center gap-4 bg-white p-4 rounded-md shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-indigo-100 rounded-md flex items-center justify-center text-indigo-500 shrink-0">
                        <i class="fa-solid fa-calendar text-xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Quando</p>
                        <p class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($evento->data_horario)->format('d/m/Y - H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-white p-4 rounded-md shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-indigo-100 rounded-md flex items-center justify-center text-indigo-500 shrink-0">
                        <i class="fa-solid fa-location-dot text-xl"></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Onde</p>
                        <p class="font-bold text-slate-800 truncate">{{ $evento->local }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto">
            @if($convidado->presenca == 'pendente')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <form id="form-confirmar" action="{{ route('convite.confirmar', $convidado->token_acesso) }}" method="POST">
                        @csrf
                        <input type="hidden" name="presenca" value="confirmado">
                        <button type="button" onclick="confirmarPresenca()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-5 rounded-md font-black text-xl transition shadow-xl shadow-emerald-100 active:scale-95 flex items-center justify-center gap-3">
                            <span>Vou com certeza!</span> ✅
                        </button>
                    </form>

                    <form id="form-recusar" action="{{ route('convite.confirmar', $convidado->token_acesso) }}" method="POST">
                        @csrf
                        <input type="hidden" name="presenca" value="recusado">
                        <button type="button" onclick="recusarPresenca()" class="w-full bg-white text-slate-400 py-5 rounded-md font-bold text-base hover:text-rose-500 transition border-2 border-transparent hover:border-rose-100">
                            Infelizmente não poderei ir
                        </button>
                    </form>
                </div>
            @elseif($convidado->presenca == 'recusado')
                <div class="animate-fadeIn">
                    <div class="py-6 px-8 bg-rose-50 text-rose-600 border border-rose-100 rounded-md font-black text-xl mb-6 w-full text-center">
                        Poxa, você marcou que não poderia ir... 😢
                    </div>
                    <form id="form-confirmar" action="{{ route('convite.confirmar', $convidado->token_acesso) }}" method="POST">
                        @csrf
                        <input type="hidden" name="presenca" value="confirmado">
                        <button type="button" onclick="confirmarPresenca()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-md font-bold text-lg transition shadow-lg active:scale-95 flex items-center justify-center gap-3 mx-auto">
                            Mudei de ideia, eu vou! 🚀
                        </button>
                    </form>
                </div>
            @else
                <div class="animate-fadeIn">
                    <div class="py-6 px-8 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-md font-black text-xl md:text-2xl mb-4 shadow-sm inline-block w-full text-center">
                        Sua presença está confirmada! Nos vemos lá! 🥳
                    </div>
                    <form id="form-recusar" action="{{ route('convite.confirmar', $convidado->token_acesso) }}" method="POST" class="mb-10">
                        @csrf
                        <input type="hidden" name="presenca" value="recusado">
                        <button type="button" onclick="recusarPresenca()" class="text-slate-400 hover:text-rose-500 text-xs font-medium underline transition">
                            Não poderei mais ir (cancelar presença)
                        </button>
                    </form>
                </div>

                {{-- LISTA DE ITENS --}}
                <div class="text-left mt-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 border-b border-slate-50 pb-4">
                        <h3 class="font-black text-slate-800 text-2xl flex items-center gap-3">
                            <div class="w-12 h-12 bg-indigo-600 text-white rounded-md flex items-center justify-center shadow-lg">
                                <i class="fa-solid fa-basket-shopping"></i>
                            </div>
                            O que levar?
                        </h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($evento->itens as $item)
                            @php
                                $jaPrometido = $item->convidados->sum('pivot.quantidade_levada');
                                $restante = max(0, $item->quantidade - $jaPrometido);
                                $minhaReserva = $item->convidados->where('id', $convidado->id)->first();
                            @endphp

                            <div class="flex flex-col p-5 bg-white border-2 border-slate-50 rounded-md shadow-sm hover:border-indigo-100 transition-all group">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition">{{ $item->nome }}</p>
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">
                                            Faltam: {{ $restante }} / Total: {{ $item->quantidade }}
                                        </p>
                                    </div>

                                    @if($minhaReserva)
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="text-[10px] font-black px-3 py-2 rounded-md bg-indigo-600 text-white shadow-md uppercase">
                                                LEVANDO {{ $minhaReserva->pivot->quantidade_levada }}x
                                            </span>
                                            <button type="button" onclick="toggleEdit('{{ $item->id }}')" class="text-[10px] font-bold text-indigo-400 hover:text-indigo-600 flex items-center gap-1 transition">
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-auto">
                                    @if($minhaReserva)
                                        {{-- ÁREA DE EDIÇÃO OCULTA --}}
                                        <div id="edit-area-{{ $item->id }}" class="hidden mb-4 p-3 bg-indigo-50/50 rounded-md border border-indigo-100 animate-fadeIn">
                                            <form action="{{ route('itens.vincular', $item->id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="convidado_id" value="{{ $convidado->id }}">
                                                <div class="flex flex-col flex-1">
                                                    <label class="text-[9px] font-black uppercase text-indigo-400 mb-1">Nova Qtd:</label>
                                                    <input type="number" name="quantidade_levada" value="{{ $minhaReserva->pivot->quantidade_levada }}" min="1" max="{{ $restante + $minhaReserva->pivot->quantidade_levada }}" 
                                                           class="w-full py-2 rounded border-slate-200 font-black text-center text-sm focus:ring-indigo-500">
                                                </div>
                                                <button type="submit" class="h-10 self-end px-4 bg-indigo-600 text-white text-[10px] font-black uppercase rounded hover:bg-indigo-700 transition">
                                                    Salvar
                                                </button>
                                            </form>
                                        </div>

                                        <form action="{{ route('itens.desvincular', $item->id) }}" method="POST" id="form-remover-{{ $item->id }}">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="convidado_id" value="{{ $convidado->id }}">
                                            <button type="button" onclick="removerItem({{ $item->id }}, '{{ $item->nome }}')" class="w-full text-[10px] font-bold text-rose-400 hover:text-rose-600 underline py-2 transition">
                                                Remover da minha lista
                                            </button>
                                        </form>
                                    @elseif($restante > 0)
                                        <form action="{{ route('itens.vincular', $item->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="convidado_id" value="{{ $convidado->id }}">
                                            
                                            <div class="flex items-center bg-slate-50 rounded-md border border-slate-200 px-2 shrink-0">
                                                <input type="number" name="quantidade_levada" value="1" min="1" max="{{ $restante }}" 
                                                       class="w-10 py-2 bg-transparent font-black text-center text-slate-700 text-sm focus:outline-none">
                                            </div>

                                            <button type="button" onclick="confirmarItemComQtd(this, '{{ $item->nome }}')" class="flex-1 text-xs font-black text-indigo-600 bg-indigo-50 px-4 py-3 rounded-md hover:bg-indigo-600 hover:text-white transition-all uppercase border border-indigo-100 active:scale-95">
                                                Eu levo!
                                            </button>
                                        </form>
                                    @else
                                        <div class="text-center py-2 bg-slate-50 rounded-md border border-dashed border-slate-200">
                                            <span class="text-[10px] font-black text-slate-400 uppercase">✅ Item Completo</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-10 text-center bg-slate-50 rounded-md border-2 border-dashed border-slate-200">
                                <p class="text-slate-400 italic">Nenhum item solicitado.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- GALERIA DE FOTOS --}}
                @if($evento->fotos->count() > 0)
                    <div class="mt-16 pt-10">
                        <button onclick="document.getElementById('galeria-expandida').classList.toggle('hidden'); this.querySelector('.icon-arrow').classList.toggle('rotate-180')" 
                            class="w-full bg-slate-800 hover:bg-black text-white p-6 rounded-md flex items-center justify-between transition-all group shadow-xl">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white/10 rounded-md flex items-center justify-center text-xl">
                                    <i class="fa-solid fa-camera-retro"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-black text-lg leading-none">Álbum da Festa</p>
                                    <p class="text-xs text-white/50 uppercase tracking-widest font-bold mt-1">Veja as fotos do evento</p>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-down icon-arrow transition-transform duration-300 mr-2"></i>
                        </button>

                        <div id="galeria-expandida" class="hidden mt-8 animate-fadeIn">
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($evento->fotos as $foto)
                                    <a href="{{ asset('storage/' . $foto->caminho) }}" target="_blank" class="aspect-square rounded-md overflow-hidden shadow-md border-4 border-white relative group">
                                        <img src="{{ asset('storage/' . $foto->caminho) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-125" alt="Foto do evento">
                                        <div class="absolute inset-0 bg-indigo-600/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                            <i class="fa-solid fa-expand text-white text-2xl"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <div class="mt-20 pt-8 border-t border-slate-50 text-slate-300 text-[10px] font-black uppercase tracking-[0.3em]">
            Powered by Chamaí
        </div>
    </div>

    <script>
        // --- Feedback de Sucesso ---
        @if(session('success'))
            if("{{ session('success') }}".includes("confirmada") || "{{ session('success') }}".includes("Sucesso")) {
                confetti({
                    particleCount: 150,
                    spread: 70,
                    origin: { y: 0.6 },
                    colors: ['#4f46e5', '#10b981', '#fbbf24']
                });
            }

            Swal.fire({
                icon: 'success',
                title: 'Tudo certo!',
                text: '{{ session("success") }}',
                confirmButtonText: 'Entendido',
                timer: 3500
            });
        @endif

        // --- Presença ---
        function confirmarPresenca() {
            Swal.fire({
                title: 'Confirmar Presença?',
                text: "Uhul! Mal podemos esperar para te ver lá!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sim, vou com certeza!',
                cancelButtonText: 'Voltar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-confirmar').submit();
                }
            });
        }

        function recusarPresenca() {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Sentiremos sua falta no evento!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                confirmButtonText: 'Não poderei ir',
                cancelButtonText: 'Voltar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-recusar').submit();
                }
            });
        }

        // --- Itens ---
        function toggleEdit(itemId) {
            const area = document.getElementById('edit-area-' + itemId);
            area.classList.toggle('hidden');
        }

        function confirmarItemComQtd(button, itemName) {
            const form = button.closest('form');
            const qtd = form.querySelector('input[name="quantidade_levada"]').value;

            Swal.fire({
                title: 'Reservar ' + itemName + '?',
                text: "Você confirma que levará " + qtd + " unidade(s)?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Sim, eu levo!',
                cancelButtonText: 'Agora não',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function removerItem(itemId, itemName) {
            Swal.fire({
                title: 'Remover ' + itemName + '?',
                text: "Deseja desmarcar este item? Ele voltará a ficar disponível para os outros.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                confirmButtonText: 'Sim, remover',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-remover-' + itemId).submit();
                }
            });
        }
    </script>
</body>
</html>