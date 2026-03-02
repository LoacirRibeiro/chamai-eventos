<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Event;
use App\Models\Convidado;
use App\Models\Activity; // Importação necessária
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Exibir a lista de itens (Visão do Organizador)
     */
    public function index(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $event->load([
            'itens.convidados', 
            'convidados.itens'
        ]);
        
        return view('events.itens', compact('event'));
    }

    /**
     * Adicionar item ao evento
     */
    public function store(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) { abort(403); }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:1',
        ]);

        $item = $event->itens()->create($validated);

        // --- REGISTRO DE ATIVIDADE ---
        Activity::create([
            'event_id' => $event->id,
            'mensagem' => "Novo item adicionado à lista: {$item->quantidade}x {$item->nome}",
            'tipo' => 'item'
        ]);

        return back()->with('success', 'Item adicionado com sucesso!');
    }

    /**
     * VINCULAR: Convidado escolhe o item e a quantidade
     */

    public function vincularConvidado(Request $request, Item $item)
    {
        $request->validate([
            'convidado_id' => 'required|exists:convidados,id',
            'quantidade_levada' => 'required|integer|min:1'
        ]);

        // 1. Verificar reserva atual deste convidado para este item
        $registroExistente = $item->convidados()->where('convidado_id', $request->convidado_id)->first();
        $quantidadeJaReservadaPorEle = $registroExistente ? $registroExistente->pivot->quantidade_levada : 0;

        // 2. Cálculo inteligente de estoque:
        // (Total do Item) - (Tudo que já foi prometido) + (O que esse convidado já tinha prometido)
        $totalPrometidoGeral = $item->convidados()->sum('quantidade_levada');
        $disponivelParaEle = $item->quantidade - $totalPrometidoGeral + $quantidadeJaReservadaPorEle;

        if ($request->quantidade_levada > $disponivelParaEle) {
            return back()->with('error', "Desculpe, só restam {$disponivelParaEle} unidades de {$item->nome}.");
        }

        // 3. Atualizar ou Criar o vínculo (Substitui a quantidade anterior)
        $item->convidados()->syncWithoutDetaching([
            $request->convidado_id => ['quantidade_levada' => $request->quantidade_levada]
        ]);

        // 4. Registro de Atividade com mensagem dinâmica
        $convidado = Convidado::find($request->convidado_id);
        $acao = $registroExistente ? "alterou para" : "reservou";
        
        Activity::create([
            'event_id' => $item->event_id,
            'mensagem' => "{$convidado->nome} {$acao} {$request->quantidade_levada}x {$item->nome}",
            'tipo' => 'item'
        ]);

        return back()->with('success', "Sucesso! Você vai levar {$request->quantidade_levada}x {$item->nome}.");
    }

    /**
     * DESVINCULAR: Remove a escolha do convidado
     */
    public function desvincular(Item $item, Request $request)
    {
        $request->validate([
            'convidado_id' => 'required|exists:convidados,id'
        ]);

        $convidado = Convidado::find($request->convidado_id);

        // --- REGISTRO DE ATIVIDADE (Antes de deletar) ---
        Activity::create([
            'event_id' => $item->event_id,
            'mensagem' => "{$convidado->nome} removeu a reserva de {$item->nome}",
            'tipo' => 'item'
        ]);

        $item->convidados()->detach($request->convidado_id);

        return back()->with('success', 'Reserva removida com sucesso!');
    }

    /**
     * DELETAR: Remove o item do evento
     */
    public function destroy(Item $item)
    {
        if ($item->event->user_id !== Auth::id()) { abort(403); }
        
        $nomeItem = $item->nome;
        $eventId = $item->event_id;

        // --- REGISTRO DE ATIVIDADE ---
        Activity::create([
            'event_id' => $eventId,
            'mensagem' => "O item '{$nomeItem}' foi removido da lista oficial.",
            'tipo' => 'item'
        ]);

        $item->delete();
        return back()->with('success', 'Item removido.');
    }

    // No arquivo App\Models\Item.php

    public function convidados()
    {
        // O withPivot é crucial para o Laravel ler a coluna extra na tabela de ligação
        return $this->belongsToMany(Convidado::class, 'convidado_item')
                    ->withPivot('quantidade_levada')
                    ->withTimestamps();
    }
}