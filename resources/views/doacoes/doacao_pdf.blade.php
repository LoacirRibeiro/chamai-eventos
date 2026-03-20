<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Relatório - {{ $doacao->titulo }}</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; color: #334155; line-height: 1.5; }
        
        /* Cabeçalho */
        .header { border-bottom: 3px solid #10b981; padding-bottom: 15px; margin-bottom: 25px; }
        .campanha-nome { font-size: 22px; font-weight: bold; color: #1e293b; text-transform: uppercase; margin: 0; }
        .meta-info { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; }

        /* Resumo */
        .resumo-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; margin-bottom: 25px; }
        .resumo-item { display: inline-block; width: 30%; font-size: 12px; }
        .resumo-label { display: block; font-size: 10px; font-weight: bold; color: #94a3b8; text-transform: uppercase; }
        .resumo-valor { font-size: 16px; font-weight: bold; color: #10b981; }

        /* Tabela */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f1f5f9; color: #475569; text-align: left; padding: 12px 10px; font-size: 10px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
        td { padding: 12px 10px; font-size: 11px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        /* Estilos de célula */
        .doador-nome { font-weight: bold; color: #1e293b; }
        .zap-link { color: #059669; text-decoration: none; font-weight: bold; }
        .badge-item { background: #ecfdf5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 10px; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #cbd5e1; border-top: 1px solid #f1f5f9; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="campanha-nome">{{ $doacao->titulo }}</h1>
        <div class="meta-info">Relatório de Doações • Gerado em {{ date('d/m/Y H:i') }}</div>
    </div>

    <div class="resumo-box">
        <div class="resumo-item">
            <span class="resumo-label">Total de Doadores</span>
            <span class="resumo-valor">{{ $doacao->itens->flatMap->participantes->count() }}</span>
        </div>
        <div class="resumo-item">
            <span class="resumo-label">Itens Arrecadados</span>
            <span class="resumo-valor">{{ $doacao->itens->sum('quantidade_arrecadada') }}</span>
        </div>
        <div class="resumo-item" style="text-align: right;">
            <span class="resumo-label">Status</span>
            <span class="resumo-valor" style="color: #1e293b;">{{ strtoupper($doacao->status) }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="25%">Doador</th>
                <th width="20%">WhatsApp</th>
                <th width="25%">Item</th>
                <th width="15%">Quantidade</th>
                <th width="15%">Data</th>
            </tr>
        </thead>
        <tbody>
            @php
                $todosParticipantes = $doacao->itens->flatMap(function($item) {
                    return $item->participantes;
                })->sortByDesc('created_at');
            @endphp

            @forelse($todosParticipantes as $p)
                <tr>
                    <td><span class="doador-nome">{{ $p->nome }}</span></td>
                    <td><span class="zap-link">{{ $p->whatsapp }}</span></td>
                    <td>{{ $p->item->nome ?? 'Item da Lista' }}</td>
                    <td><span class="badge-item">{{ $p->quantidade }} {{ $p->item->unidade_medida ?? 'un' }}</span></td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">Nenhuma doação registrada até o momento.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Chamaí • Gestão Inteligente de Doações e Eventos • {{ url('/') }}
    </div>
</body>
</html>