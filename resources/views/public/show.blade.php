<!-- <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $doacao->titulo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .step-hidden { display: none; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans antialiased text-slate-900">
    
    <div class="max-w-md mx-auto py-12 px-6">
        
        <div class="text-center mb-10">
            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Campanha de Doação</span>
            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter mt-4 leading-tight">
                {{ $doacao->titulo }}
            </h1>
            <p class="text-slate-500 mt-3 font-medium text-sm leading-relaxed">
                {{ $doacao->descricao }}
            </p>
        </div>

        <div id="step-1" class="transition-all">
            <button type="button" onclick="goToStep(2)" class="w-full bg-emerald-600 text-white py-5 rounded-2xl font-black uppercase text-lg shadow-xl shadow-emerald-200 hover:bg-emerald-700 transition active:scale-95">
                Quero Participar <i class="fa-solid fa-heart ml-2"></i>
            </button>
        </div>

        <div id="step-2" class="step-hidden space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest text-center mb-4">Quem está ajudando?</h3>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-1 ml-1">Seu Nome Completo</label>
                    <input type="text" id="input_nome" placeholder="Ex: João Silva"
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 p-4 bg-slate-50 font-semibold">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-1 ml-1">Seu WhatsApp</label>
                    <input type="text" id="input_zap" placeholder="(00) 00000-0000"
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 p-4 bg-slate-50 font-semibold">
                </div>
            </div>
            <button type="button" onclick="validateStep2()" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-slate-800 transition shadow-lg">
                Ver Lista de Itens <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
        </div>

        <div id="step-3" class="step-hidden space-y-6">
            <div class="px-2">
                <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest text-center">O que você vai levar?</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase text-center mt-1">Toque em "Confirmar" no item escolhido</p>
            </div>

            <div class="space-y-4">
                @forelse($doacao->itens as $item)
                    <form action="{{ route('public.doacao.confirm_single', [$doacao->token, $item->id]) }}" method="POST" 
                          class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between gap-4">
                        @csrf
                        <input type="hidden" name="nome_doador" class="hidden-nome">
                        <input type="hidden" name="whatsapp_doador" class="hidden-zap">

                        <div class="flex-1">
                            <p class="font-bold text-slate-800">{{ $item->nome }}</p>
                            <p class="text-[10px] text-slate-400 font-black uppercase">Meta: {{ $item->quantidade_meta }} {{ $item->unidade_medida }}</p>
                            <input type="number" name="quantidade" min="1" value="1" 
                                   class="w-20 mt-2 border-slate-200 rounded-lg text-center font-bold text-emerald-600">
                        </div>
                        <button type="submit" class="bg-emerald-600 text-white px-5 py-4 rounded-2xl font-black text-xs uppercase shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition active:scale-95">
                            Confirmar
                        </button>
                    </form>
                @empty
                    <p class="p-8 text-center text-slate-400 font-medium">Não há itens disponíveis no momento.</p>
                @endforelse
            </div>

            <button type="button" onclick="goToStep(2)" class="w-full text-slate-400 font-bold text-xs uppercase tracking-widest py-2">
                <i class="fa-solid fa-chevron-left mr-1"></i> Voltar meus dados
            </button>
        </div>

        <div class="mt-12 text-center text-slate-300 font-bold text-[10px] uppercase tracking-[0.2em]">
            Desenvolvido por Chamaí
        </div>
    </div>

    <script>
        function goToStep(step) {
            document.getElementById('step-1').classList.add('step-hidden');
            document.getElementById('step-2').classList.add('step-hidden');
            document.getElementById('step-3').classList.add('step-hidden');
            document.getElementById('step-' + step).classList.remove('step-hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateStep2() {
            const nome = document.getElementById('input_nome').value;
            const zap = document.getElementById('input_zap').value;

            if (nome.length < 3 || zap.length < 8) {
                alert('Por favor, preencha seu nome e WhatsApp corretamente.');
                return;
            }

            // Injeta os dados nos formulários individuais do step-3
            document.querySelectorAll('.hidden-nome').forEach(el => el.value = nome);
            document.querySelectorAll('.hidden-zap').forEach(el => el.value = zap);
            
            goToStep(3);
        }
    </script>
</body>
</html> -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $doacao->titulo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .step-hidden { display: none; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans antialiased text-slate-900">
    
    <div class="max-w-md mx-auto py-12 px-6">
        
        <div class="text-center mb-10">
            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Campanha de Doação</span>
            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter mt-4 leading-tight">{{ $doacao->titulo }}</h1>
            <p class="text-slate-500 mt-3 font-medium text-sm leading-relaxed">{{ $doacao->descricao }}</p>
        </div>

        @if($minhasParticipacoes->count() > 0)
                <div class="bg-emerald-50 border border-emerald-100 p-5 rounded-3xl mb-8">
                    <h3 class="text-emerald-800 font-black text-xs uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i> Você já confirmou itens:
                    </h3>
                    <div class="mt-3 space-y-2">
                        @foreach($minhasParticipacoes as $p)
                            <div class="flex justify-between text-sm border-b border-emerald-100 pb-1">
                                <span class="text-emerald-700 font-bold">{{ $p->item->nome }}</span>
                                <span class="font-black text-emerald-600">{{ $p->quantidade }} {{ $p->item->unidade_medida }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-emerald-500 mt-3 italic text-center">
                        Precisa alterar algo? Entre em contato com o organizador.
                    </p>
                </div>
            @endif

        <div id="step-1" class="transition-all">
            <button type="button" onclick="goToStep(2)" class="w-full bg-emerald-600 text-white py-5 rounded-2xl font-black uppercase text-lg shadow-xl shadow-emerald-200 hover:bg-emerald-700 transition active:scale-95">
                Quero Participar <i class="fa-solid fa-heart ml-2"></i>
            </button>
        </div>

        <div id="step-2" class="step-hidden space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest text-center mb-4">Seus Dados</h3>
                <input type="text" id="input_nome" placeholder="Seu Nome Completo" class="w-full border-slate-200 rounded-xl p-4 bg-slate-50 font-semibold focus:ring-emerald-500">
                <input type="text" id="input_zap" placeholder="(00) 00000-0000" class="w-full border-slate-200 rounded-xl p-4 bg-slate-50 font-semibold focus:ring-emerald-500">
            </div>
            <button type="button" onclick="validateStep2()" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-slate-800 transition shadow-lg">
                Ver Itens da Campanha <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
        </div>

        <form id="form-final" action="{{ route('public.doacao.confirmar_tudo', $doacao->token) }}" method="POST" class="step-hidden space-y-6">
            @csrf
            <input type="hidden" name="nome_doador" id="final_nome">
            <input type="hidden" name="whatsapp_doador" id="final_zap">

            <div class="px-2">
                <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest text-center">O que você vai levar?</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase text-center mt-1">Preencha as quantidades</p>
            </div>

            

            <div class="space-y-4">
                @forelse($doacao->itens as $item)
                    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <p class="font-bold text-slate-800">{{ $item->nome }}</p>
                            <p class="text-[10px] text-slate-400 font-black uppercase">Meta: {{ $item->quantidade_meta }} {{ $item->unidade_medida }}</p>
                        </div>
                        <input type="number" name="itens[{{ $item->id }}]" min="0" value="0" 
                               class="w-20 border-slate-200 rounded-lg text-center font-bold text-emerald-600 p-2">
                    </div>
                @empty
                    <p class="p-8 text-center text-slate-400 font-medium">Nenhum item disponível.</p>
                @endforelse
            </div>

            <button type="submit" class="w-full bg-emerald-600 text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-lg hover:bg-emerald-700 transition">
                Finalizar Doação
            </button>
            <button type="button" onclick="goToStep(2)" class="w-full text-slate-400 font-bold text-xs uppercase underline py-2">Voltar meus dados</button>
        </form>
    </div>

    <script>
        function goToStep(step) {
            document.querySelectorAll('#step-1, #step-2, #form-final').forEach(el => el.classList.add('step-hidden'));
            if(step === 3) document.getElementById('form-final').classList.remove('step-hidden');
            else document.getElementById('step-' + step).classList.remove('step-hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateStep2() {
            const nome = document.getElementById('input_nome').value;
            const zap = document.getElementById('input_zap').value;
            if(nome.length < 3 || zap.length < 8) return alert('Preencha nome e WhatsApp corretamente.');
            document.getElementById('final_nome').value = nome;
            document.getElementById('final_zap').value = zap;
            goToStep(3);
        }

        // Submissão com SweetAlert2
        document.getElementById('form-final').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirmar intenção?',
                text: "Sua doação será registrada agora.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                confirmButtonText: 'Confirmar'
            }).then((result) => { if(result.isConfirmed) this.submit(); });
        });

        @if(session('success'))
    Swal.fire({
        title: 'Sucesso!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#10b981',
        confirmButtonText: 'Entendido'
    });
@endif

@if(session('error'))
    Swal.fire({
        title: 'Ops!',
        text: "{{ session('error') }}",
        icon: 'error',
        confirmButtonColor: '#ef4444'
    });
@endif
    </script>
</body>
</html>