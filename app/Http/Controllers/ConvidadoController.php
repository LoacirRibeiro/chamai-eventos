<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; 
use App\Models\Convidado;
use App\Models\Item;
use Illuminate\Support\Str;

class ConvidadoController extends Controller
{
    /**
     * EXIBIÇÃO PÚBLICA: Página do convite via Token
     */
    public function exibirConvite($token)
    {
        // Usamos 'with' para carregar os itens e fotos de uma vez só (Eager Loading)
        $convidado = Convidado::where('token_acesso', $token)->firstOrFail();
        $evento = $convidado->event; // Padronizado para 'event' conforme seu Model Item

        return view('convite.pagina', compact('convidado', 'evento'));
    }

    /**
     * AÇÃO PÚBLICA: Confirmar presença via Token
     */
    public function confirmar(Request $request, $token)
    {
        $convidado = Convidado::where('token_acesso', $token)->firstOrFail();
        
        $convidado->update(['presenca' => $request->presenca]);

        // Notificação opcional para o dono do evento
        if ($request->presenca == 'confirmado') {
            $event = $convidado->event;
            $donoDoEvento = $event->user;
            
            // Verifica se a classe de notificação existe antes de disparar
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

        // Geramos um token único de 32 caracteres para o link do Zap
        $event->convidados()->create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'presenca' => 'pendente',
            'token_acesso' => Str::random(32), 
        ]);

        return redirect()->route('events.show', $event->id)
            ->with('success', 'Convidado adicionado com sucesso!');
    }

    /**
     * ADMIN: Atualizar dados (incluindo status via Dashboard)
     */
    public function update(Request $request, Convidado $convidado)
    {
        // Se for apenas atualização rápida de status (SweetAlert/Botão rápido)
        if ($request->has('presenca') && !$request->has('nome')) {
            $convidado->update(['presenca' => $request->presenca]);
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

    // Mantive seus métodos create, edit e destroy como estavam, pois estão corretos.
    public function create(Event $event) { return view('convidados.create', compact('event')); }
    public function edit(Convidado $convidado) { return view('convidados.edit', compact('convidado')); }
    public function destroy(Convidado $convidado) 
    {
        $eventId = $convidado->event_id;
        $convidado->delete();
        return redirect()->route('events.show', $eventId)->with('success', 'Removido!');
    }
}