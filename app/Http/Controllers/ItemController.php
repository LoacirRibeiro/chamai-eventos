<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Event;
use App\Models\Convidado;
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

        // Carrega itens e convidados com os dados da tabela pivô
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

        $event->itens()->create($validated);

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

        // 1. Soma quanto já foi reservado por todos os convidados para este item
        $jaReservado = $item->convidados()->sum('quantidade_levada'); 
        $disponivel = $item->quantidade - $jaReservado;

        // 2. Valida se a quantidade escolhida ultrapassa o estoque
        if ($request->quantidade_levada > $disponivel) {
            return back()->with('error', "Desculpe, só restam {$disponivel} unidades de {$item->nome}.");
        }

        // 3. Salva na tabela pivô usando o nome da coluna definido no Model
        $item->convidados()->attach($request->convidado_id, [
            'quantidade_levada' => $request->quantidade_levada
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

        // Remove a linha específica na tabela pivô
        $item->convidados()->detach($request->convidado_id);

        return back()->with('success', 'Reserva removida com sucesso!');
    }

    /**
     * DELETAR: Remove o item do evento
     */
    public function destroy(Item $item)
    {
        if ($item->event->user_id !== Auth::id()) { abort(403); }
        $item->delete();
        return back()->with('success', 'Item removido.');
    }
}