<?php

namespace App\Http\Controllers;

use App\Models\Doacao;
use App\Models\DoacaoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class PublicDonationController extends Controller
{
    public function show(Request $request, $token)
    {
        $doacao = Doacao::with('itens')->where('token', $token)->firstOrFail();
        
        // 1. Verifica se existe o cookie de doação para esta campanha específica
        $cookieName = 'doacao_token_' . $token;
        $whatsappDoador = $request->cookie($cookieName) ?? session('doador_whatsapp');

        $minhasParticipacoes = collect();

        // 2. Se identificamos o doador, buscamos o que ele já se comprometeu a doar
        if ($whatsappDoador) {
            $minhasParticipacoes = $doacao->participantes()
                ->where('whatsapp', $whatsappDoador)
                ->with('item') // Carrega o relacionamento com o item para pegar o nome
                ->get();
        }

        return view('public.show', compact('doacao', 'minhasParticipacoes'));
    }

    public function confirmarTudo(Request $request, $token)
    {
        $doacao = Doacao::where('token', $token)->firstOrFail();

        $request->validate([
            'nome_doador' => 'required|string|max:255',
            'whatsapp_doador' => 'required|string|max:20',
            'itens' => 'required|array',
        ]);

        $itens_doados = [];

        DB::transaction(function () use ($request, $doacao, &$itens_doados) {
            foreach ($request->itens as $itemId => $quantidade) {
                if ($quantidade > 0) {
                    $itemModel = DoacaoItem::findOrFail($itemId);

                    $doacao->participantes()->create([
                        'doacao_id' => $doacao->id,
                        'doacao_itens_id' => $itemId, 
                        'nome' => $request->nome_doador,
                        'whatsapp' => $request->whatsapp_doador,
                        'quantidade' => $quantidade,
                    ]);

                    $itemModel->increment('quantidade_arrecadada', $quantidade);

                    $itens_doados[] = [
                        'nome' => $itemModel->nome,
                        'quantidade' => $quantidade,
                        'unidade' => $itemModel->unidade_medida
                    ];
                }
            }
        });

        if (empty($itens_doados)) {
            return back()->with('error', 'Por favor, selecione ao menos um item para doar.');
        }

        // 3. Salva o WhatsApp na Session e cria um Cookie de 30 dias
        session(['doador_whatsapp' => $request->whatsapp_doador]);
        $cookie = cookie('doacao_token_' . $token, $request->whatsapp_doador, 43200); // 30 dias

        return redirect()->route('public.doacao.success', $token)
            ->with('success_data', [
                'nome_doador' => $request->nome_doador,
                'itens_doados' => $itens_doados
            ])
            ->withCookie($cookie); // Envia o cookie na resposta do redirect       
    }

    public function success($token)
    {
        $doacao = Doacao::where('token', $token)->firstOrFail();
        $dados = session('success_data');

        return view('public.success', compact('doacao', 'dados'));
    }
}