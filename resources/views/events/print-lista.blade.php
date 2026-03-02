<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório: {{ $event->titulo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
        }
    </style>
</head>
<body class="bg-white p-10" onload="window.print()">
    <div class="max-w-4xl mx-auto border-b-2 border-black pb-4 mb-6">
        <h1 class="text-2xl font-black uppercase">{{ $event->titulo }}</h1>
        <p class="text-sm font-bold text-gray-600">
            Data: {{ \Carbon\Carbon::parse($event->data_horario)->format('d/m/Y H:i') }} | Local: {{ $event->local }}
        </p>
    </div>

    {{-- Resumo Numérico --}}
    <div class="grid grid-cols-3 gap-4 mb-8 border border-black p-4 rounded text-center">
        <div><p class="text-[10px] uppercase font-bold">Total Convidados</p><p class="text-xl font-black">{{ $stats['total'] }}</p></div>
        <div><p class="text-[10px] uppercase font-bold">Confirmados</p><p class="text-xl font-black">{{ $stats['confirmados'] }}</p></div>
        <div><p class="text-[10px] uppercase font-bold">Pendentes/Recusados</p><p class="text-xl font-black">{{ $stats['pendentes'] }}</p></div>
    </div>

    {{-- Tabela de Convidados e Itens --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 p-2 text-left text-xs uppercase">Nome do Convidado</th>
                <th class="border border-gray-300 p-2 text-center text-xs uppercase">Status</th>
                <th class="border border-gray-300 p-2 text-left text-xs uppercase">O que vai levar?</th>
            </tr>
        </thead>
        <tbody>
            @foreach($event->convidados->sortBy('nome') as $convidado)
            <tr>
                <td class="border border-gray-300 p-2 font-bold text-sm">{{ $convidado->nome }}</td>
                <td class="border border-gray-300 p-2 text-center text-[10px] uppercase">
                    {{ $convidado->presenca == 'confirmado' ? '✅ Confirmado' : '⏳ Pendente' }}
                </td>
                <td class="border border-gray-300 p-2 text-sm italic text-gray-700">
                    @foreach($convidado->itens as $it)
                        {{ $it->pivot->quantidade_levada }}x {{ $it->nome }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-10 no-print text-center">
        <button onclick="window.close()" class="bg-black text-white px-6 py-2 rounded font-bold uppercase text-xs">Fechar e Voltar</button>
    </div>
</body>
</html>