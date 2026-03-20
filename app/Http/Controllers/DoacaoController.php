<?php

namespace App\Http\Controllers;

use App\Models\Doacao;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DoacaoController extends Controller

{
    use AuthorizesRequests;
    /**
     * Lista todas as doações do usuário logado.
     */
    public function index(): View
    {
        $doacoes = Doacao::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('doacoes.index', compact('doacoes'));
    }

    /**
     * Exibe o formulário de criação de uma nova doação.
     */
    public function create(): View
    {
        return view('doacoes.create');
    }


    public function store(Request $request)
{
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'nullable|string',
        'data_limite' => 'nullable|date',
    ]);

    $doacao = auth()->user()->doacoes()->create([
        'titulo'      => $request->titulo,
        'descricao'   => $request->descricao,
        'data_limite' => $request->data_limite,
        'token'       => Str::random(32),
        'status'      => 'ativa',
    ]);

    return redirect()->route('dashboard')->with('success', 'Campanha de doação criada com sucesso!');
}

    /**
     * Exibe os detalhes de uma doação específica.
     */
    public function show(Doacao $doacao): View
    {
        // Garante que apenas o dono acesse
        $this->authorize('view', $doacao);
        $doacao->load('itens.participantes');

        // Conta doadores únicos vinculados aos itens desta doação
        $totalDoadores = \DB::table('doacao_participantes')
            ->whereIn('doacao_itens_id', $doacao->itens->pluck('id'))
            ->distinct('whatsapp') // Conta a pessoa apenas uma vez
            ->count();

        return view('doacoes.show', compact('doacao', 'totalDoadores'));
    }

    /**
     * Remove uma doação.
     */
    public function destroy(Doacao $doacao): RedirectResponse
    {
        $this->authorize('delete', $doacao);
        
        $doacao->delete();

        return redirect()->route('doacoes.index')
            ->with('success', 'Doação removida.');
    }

    public function gerarPdf($id)
    {
        $doacao = Doacao::with(['itens.participantes'])->findOrFail($id);
        
        // Carrega a view específica do relatório e passa os dados
        $pdf = Pdf::loadView('doacoes.doacao_pdf', compact('doacao'));
        
        // Retorna o PDF para o navegador (download automático ou abrir em nova aba)
        return $pdf->stream('relatorio_' . str($doacao->titulo) . '.pdf');
    }
}
