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

        $jaReservado = $item->convidados()->sum('quantidade_levada'); 
        $disponivel = $item->quantidade - $jaReservado;

        if ($request->quantidade_levada > $disponivel) {
            return back()->with('error', "Desculpe, só restam {$disponivel} unidades de {$item->nome}.");
        }

        $item->convidados()->attach($request->convidado_id, [
            'quantidade_levada' => $request->quantidade_levada
        ]);

        // --- REGISTRO DE ATIVIDADE ---
        $convidado = Convidado::find($request->convidado_id);
        Activity::create([
            'event_id' => $item->event_id,
            'mensagem' => "{$convidado->nome} reservou {$request->quantidade_levada}x {$item->nome}",
            'tipo' => 'item'
        ]);

        return back()->with('success', "Sucesso! Você vai levar {$request->quantidade_levada} unidades de {$item->nome}.");
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
}