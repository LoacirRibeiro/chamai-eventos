<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Item; 
use App\Models\Convidado; 
use Illuminate\Http\Request;

class PublicDoacaoController extends Controller
{
    // public function index($token)
    // {
    //     $event = Event::where('public_token', $token)->firstOrFail();
        
    //      Se o usuário já "se identificou" nesta sessão, mostra a lista direto
    //     if (session()->has("doador_nome_{$event->id}")) {
    //         $event->load('itens');
    //         return view('public_doacao.lista', compact('event'));
    //     }

    //      Caso contrário, mostra a tela de "Participar"
    //     return view('public_doacao.index', compact('event'));
    // }

    public function index($token)
    {
        $event = Event::where('public_token', $token)->firstOrFail();
        $nomeDoador = session("doador_nome_{$event->id}");

        if ($nomeDoador) {
            $event->load('itens.convidados');
            
            // Busca o registro deste doador específico para este evento
            $meuRegistro = \App\Models\Convidado::where('event_id', $event->id)
                ->where('nome', $nomeDoador)
                ->with('itens')
                ->first();

            return view('public_doacao.lista', compact('event', 'meuRegistro'));
        }

        return view('public_doacao.index', compact('event'));
    }

    public function participar(Request $request, $token)
    {
        $event = Event::where('public_token', $token)->firstOrFail();
        
        $request->validate(['nome' => 'required|string|max:50']);

        // Salva o nome na sessão por 2 horas
        session(["doador_nome_{$event->id}" => $request->nome]);

        return redirect()->route('doacao.publica', $token);
    }

    public function registrarDoacao(Request $request, Item $item)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
            'nome_doador' => 'required|string'
        ]);

        // 1. Encontrar ou Criar o "Convidado" para este evento baseado no nome da sessão
        // Isso evita duplicar o convidado se ele doar dois itens diferentes
        $convidado = Convidado::firstOrCreate(
            [
                'event_id' => $item->event_id,
                'nome' => $request->nome_doador
            ]
        );

        // 2. Vincular o item ao convidado (ou somar se já existir)
        // Usamos syncWithoutDetaching para não apagar doações anteriores
        $convidado->itens()->syncWithoutDetaching([
            $item->id => ['quantidade_levada' => $request->quantidade]
        ]);

        return back()->with('success', 'Muito obrigado! Sua doação foi registrada.');
    }

    public function cancelar($token, Item $item)
    {
        $event = Event::where('public_token', $token)->firstOrFail();
        $nomeDoador = session("doador_nome_{$event->id}");

        $convidado = \App\Models\Convidado::where('event_id', $event->id)
            ->where('nome', $nomeDoador)
            ->first();

        if ($convidado) {
            $convidado->itens()->detach($item->id);
        }

        return back()->with('success', 'Contribuição removida.');
    }
}
