<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convite Especial | Chamaí</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-indigo-600 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden text-center p-8 my-8">
        
        <div class="text-5xl mb-4">🎉</div>
        
        <h2 class="text-slate-500 font-medium text-lg mb-1 italic">Olá, {{ $convidado->nome }}!</h2>
        <h1 class="text-2xl font-black text-slate-800 mb-6">Você foi convidado para:</h1>

        <div class="bg-slate-50 rounded-3xl p-6 mb-8 border border-slate-100">
            <h3 class="text-xl font-bold text-indigo-600 mb-2">{{ $evento->titulo }}</h3>
            <p class="text-slate-600 text-sm mb-4">{{ $evento->descricao }}</p>
            
            <div class="text-left space-y-3 text-slate-700">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-calendar text-indigo-400 w-5"></i>
                    <span class="font-bold">{{ \Carbon\Carbon::parse($evento->data_horario)->format('d/m/Y - H:i') }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-location-dot text-indigo-400 w-5"></i>
                    <span class="font-medium">{{ $evento->local }}</span>
                </div>
            </div>
        </div>

        @if(session('sucesso'))
            <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded-xl text-sm font-bold">
                {{ session('sucesso') }}
            </div>
        @endif
        @if(session('erro'))
            <div class="mb-4 p-3 bg-rose-100 text-rose-700 rounded-xl text-sm font-bold">
                {{ session('erro') }}
            </div>
        @endif

        @if($convidado->presenca == 'pendente')
            <div class="space-y-3">
                <form action="{{ route('convite.confirmar', $convidado->token_acesso) }}" method="POST">
                    @csrf
                    <input type="hidden" name="presenca" value="confirmado">
                    <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-4 rounded-2xl font-black text-lg transition shadow-lg shadow-emerald-100">
                        Vou com certeza! ✅
                    </button>
                </form>

                <form action="{{ route('convite.confirmar', $convidado->token_acesso) }}" method="POST">
                    @csrf
                    <input type="hidden" name="presenca" value="recusado">
                    <button class="w-full bg-white text-slate-400 py-3 rounded-2xl font-bold text-sm hover:text-rose-500 transition">
                        Infelizmente não poderei ir
                    </button>
                </form>
            </div>
        @else
            <div class="py-4 px-6 bg-emerald-50 text-emerald-600 rounded-2xl font-bold mb-6">
                @if($convidado->presenca == 'confirmado')
                    Sua presença está confirmada! Nos vemos lá! 🥳
                @else
                    Poxa, sentiremos sua falta! 😢
                @endif
            </div>

            @if($convidado->presenca == 'confirmado')
                <div class="mt-8 text-left border-t border-slate-100 pt-8">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-basket-shopping text-indigo-500"></i>
                        O que levar?
                    </h3>
                    <p class="text-slate-500 text-xs mb-4">Escolha um item da lista para colaborar com a festa:</p>
                    
                    <div class="space-y-3">
                        @forelse($evento->itens as $item)
                            <div class="flex items-center justify-between p-4 bg-white border border-slate-100 rounded-2xl shadow-sm">
                                <div>
                                    <p class="font-bold text-slate-700 text-sm">{{ $item->nome }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">{{ $item->quantidade }}</p>
                                </div>
                                
                                @if($item->convidado_id)
                                    <div class="text-right">
                                        <span class="text-[10px] font-black px-2 py-1 rounded-md {{ $item->convidado_id == $convidado->id ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-400' }}">
                                            {{ $item->convidado_id == $convidado->id ? 'VOCÊ VAI LEVAR' : 'JÁ RESERVADO' }}
                                        </span>
                                    </div>
                                @else
                                    <form action="{{ route('convite.escolherItem', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="convidado_id" value="{{ $convidado->id }}">
                                        <button class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-2 rounded-xl hover:bg-indigo-600 hover:text-white transition-all uppercase">
                                            Eu levo!
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <p class="text-center text-slate-400 text-sm italic py-4">Nenhum item necessário para esta festa.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        @endif

    </div>

    <div class="fixed bottom-4 text-white/50 text-[10px] font-bold uppercase tracking-widest">
        Powered by Chamaí
    </div>

    @if($evento->fotos->count() > 0 && now() >= \Carbon\Carbon::parse($evento->data_horario))
            <div class="mt-12 text-left border-t border-slate-100 pt-8">
                <h3 class="font-black text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-images text-indigo-500"></i>
                    Álbum da Festa
                </h3>
                <p class="text-slate-500 text-xs mb-6 font-medium uppercase tracking-widest">Reviva os melhores momentos!</p>
                
                <div class="grid grid-cols-2 gap-3">
                    @foreach($evento->fotos as $foto)
                        <div class="aspect-square rounded-[1.5rem] overflow-hidden shadow-sm border border-slate-100 relative group">
                            <img src="{{ asset('storage/' . $foto->caminho) }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            
                            <a href="{{ asset('storage/' . $foto->caminho) }}" target="_blank" 
                               class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <i class="fa-solid fa-magnifying-glass-plus text-white text-xl"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 text-center">
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Toque na foto para ampliar</p>
                </div>
            </div>
        @endif

</body>
</html>