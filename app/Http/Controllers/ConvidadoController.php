<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; 
use App\Models\Convidado;
use App\Models\Item;
use App\Models\Activity; // Importando o Model de Atividades
use Illuminate\Support\Str;

class ConvidadoController extends Controller
{
    /**
     * EXIBIÇÃO PÚBLICA: Página do convite via Token
     */
    public function exibirConvite($token)
    {
        $convidado = Convidado::where('token_acesso', $token)->firstOrFail();
        $evento = $convidado->event; 

        return view('convite.pagina', compact('convidado', 'evento'));
    }

    /**
     * AÇÃO PÚBLICA: Confirmar presença via Token
     */
    public function confirmar(Request $request, $token)
    {
        $convidado = Convidado::where('token_acesso', $token)->firstOrFail();
        $event = $convidado->event;
        
        $convidado->update(['presenca' => $request->presenca]);

        // --- REGISTRO DE ATIVIDADE ---
        $statusTexto = $request->presenca == 'confirmado' ? 'confirmou presença!' : 'avisou que não poderá ir.';
        Activity::create([
            'event_id' => $event->id,
            'mensagem' => "{$convidado->nome} {$statusTexto}",
            'tipo' => 'presenca'
        ]);

        if ($request->presenca == 'confirmado') {
            $donoDoEvento = $event->user;
            if (class_exists('\App\Notifications\ConvidadoConfirmou')) {
                $donoDoEvento->notify(new \App\Notifications\ConvidadoConfirmou($convidado, $event));
            }
        }

        return back()->with('sucesso', 'Resposta registrada! Obrigado.');
    }

    /**
     * AÇÃO PÚBLICA/PRIVADA: Escolher item da lista
     */
    public function escolherItem(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        
        if ($item->convidado_id) {
            return back()->with('erro', 'Este item já foi escolhido por outra pessoa!');
        }

        $item->update([
            'convidado_id' => $request->convidado_id
        ]);

        // --- REGISTRO DE ATIVIDADE ---
        $convidado = Convidado::find($request->convidado_id);
        Activity::create([
            'event_id' => $item->event_id,
            'mensagem' => "{$convidado->nome} escolheu levar: {$item->nome}",
            'tipo' => 'item'
        ]);

        return back()->with('sucesso', 'Obrigado por colaborar!');
    }

    /**
     * ADMIN: Salvar novo convidado e GERAR TOKEN
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string',
            'email' => 'nullable|email',
        ]);

        $convidado = $event->convidados()->create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'presenca' => 'pendente',
            'token_acesso' => Str::random(32), 
        ]);

        // --- REGISTRO DE ATIVIDADE (OPCIONAL) ---
        Activity::create([
            'event_id' => $event->id,
            'mensagem' => "{$convidado->nome} foi adicionado à lista.",
            'tipo' => 'presenca'
        ]);

        return redirect()->route('events.show', $event->id)
            ->with('success', 'Convidado adicionado com sucesso!');
    }

    /**
     * ADMIN: Atualizar dados
     */
    public function update(Request $request, Convidado $convidado)
    {
        if ($request->has('presenca') && !$request->has('nome')) {
            $convidado->update(['presenca' => $request->presenca]);
            
            // Log de alteração manual pelo admin
            Activity::create([
                'event_id' => $convidado->event_id,
                'mensagem' => "Status de {$convidado->nome} alterado para {$request->presenca}.",
                'tipo' => 'presenca'
            ]);

            return back()->with('success', 'Status de ' . $convidado->nome . ' atualizado!');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string',
        ]);

        $convidado->update($request->all());

        return redirect()->route('events.show', $convidado->event_id)
                        ->with('success', 'Dados atualizados!');
    }

    public function create(Event $event) { return view('convidados.create', compact('event')); }
    public function edit(Convidado $convidado) { return view('convidados.edit', compact('convidado')); }
    public function destroy(Convidado $convidado) 
    {
        $eventId = $convidado->event_id;
        $nome = $convidado->nome;
        $convidado->delete();

        // Log de remoção
        Activity::create([
            'event_id' => $eventId,
            'mensagem' => "{$nome} foi removido da lista.",
            'tipo' => 'presenca'
        ]);

        return redirect()->route('events.show', $eventId)->with('success', 'Removido!');
    }
}