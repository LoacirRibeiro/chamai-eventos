<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConvidadoController extends Controller
{
    // Exibe a página do convite para o convidado
    public function exibirConvite($token)
    {
        // Busca o convidado pelo token ou retorna erro 404 se não existir
        $convidado = Convidado::where('token_acesso', $token)->firstOrFail();
        
        // Busca o evento ligado a esse convidado
        $evento = $convidado->evento; 

        return view('convite.pagina', compact('convidado', 'evento'));
    }

    // Processa a confirmação de presença (Clique no botão)
    public function confirmar(Request $request, $token)
    {
        $convidado = Convidado::where('token_acesso', $token)->firstOrFail();
        $evento = $convidado->evento;
        $donoDoEvento = $evento->user; // O criador da festa

        $convidado->update(['presenca' => $request->presenca]);

        if ($request->presenca == 'confirmado') {
            // Envia a notificação para o dono
            $donoDoEvento->notify(new \App\Notifications\ConvidadoConfirmou($convidado, $evento));
        }

        return back()->with('sucesso', 'Obrigado por responder!');
    }

    public function escolherItem(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        
        // Verifica se o item já foi escolhido (Feedback Visual do seu plano)
        if ($item->convidado_id) {
            return back()->with('erro', 'Este item já foi escolhido por outra pessoa!');
        }

        $item->update([
            'convidado_id' => $request->convidado_id
        ]);

        return back()->with('sucesso', 'Obrigado por colaborar!');
    }

    
}
