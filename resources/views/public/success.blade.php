<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doação Confirmada!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center">
    
    <div class="max-w-md w-full px-6 py-12 text-center">
        <div class="mb-8 relative">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <i class="fa-solid fa-check text-4xl text-emerald-600"></i>
            </div>
            <div class="absolute top-0 right-1/4 w-4 h-4 bg-amber-400 rounded-full animate-ping"></div>
        </div>

        @php
            // Recupera os dados da sessão enviados pelo Controller
            $successData = session('success_data');
            $nomeDoador = $successData['nome_doador'] ?? 'Doador';
            $itensDoados = $successData['itens_doados'] ?? [];
        @endphp

        <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-tight">
            Tudo certo, {{ explode(' ', $nomeDoador)[0] }}!
        </h1>
        
        <p class="text-slate-500 mt-4 font-medium leading-relaxed">
            Seu compromisso de doação foi registrado. Agradecemos imensamente pela sua generosidade! ❤️
        </p>

        @if(count($itensDoados) > 0)
        <div class="bg-white rounded-3xl border border-slate-100 p-6 my-8 shadow-sm">
            <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-4">Seu Resumo</h4>
            <ul class="space-y-3">
                @foreach($itensDoados as $item)
                    <li class="flex justify-between items-center text-sm">
                        <span class="font-bold text-slate-700">{{ $item['nome'] }}</span>
                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full font-black text-xs">
                            {{ $item['quantidade'] }} {{ $item['unidade'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mt-10 space-y-4">
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Ajude-nos a chegar mais longe</p>
            
            @php
                // Formata uma mensagem legal para o WhatsApp
                $msgWhatsapp = "Acabei de participar da campanha *{$doacao->titulo}* no Chamaí! 🎁\n\nVeja como você também pode ajudar acessando o link abaixo:";
                $linkCampanha = route('public.doacao.show', $doacao->token);
                $urlFinal = "https://wa.me/?text=" . urlencode($msgWhatsapp . "\n\n" . $linkCampanha);
            @endphp

            <a href="{{ $urlFinal }}" 
               target="_blank"
               class="flex items-center justify-center gap-3 w-full bg-emerald-600 text-white py-5 rounded-2xl font-black uppercase text-sm shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition">
                <i class="fa-brands fa-whatsapp text-xl"></i> Compartilhar no WhatsApp
            </a>

            <a href="{{ route('public.doacao.show', $doacao->token) }}" 
               class="block w-full py-4 text-slate-400 font-bold text-xs uppercase tracking-widest hover:text-slate-600 transition">
                <i class="fa-solid fa-house mr-2"></i> Voltar para a Campanha
            </a>
        </div>

        <div class="mt-20 text-slate-300 font-bold text-[10px] uppercase tracking-[0.2em]">
            Chamaí • Gestão de Eventos e Doações
        </div>
    </div>

</body>
</html>