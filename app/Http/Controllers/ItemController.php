<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Exibir a lista de itens do evento.
     */
    public function index(Event $event)
    {
        // Segurança: Verificar se o evento pertence ao usuário logado
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        // Eager Loading: Carrega itens (ordenados) e convidados para evitar o problema N+1
        $event->load([
            'itens' => function ($query) {
                $query->orderBy('nome', 'asc');
            },
            'convidados' => function ($query) {
                $query->orderBy('nome', 'asc');
            }
        ]);
        
        return view('events.itens', compact('event'));
    }

    /**
     * Salvar um novo item na lista do evento.
     */
    public function store(Request $request, Event $event)
    {
        // Segurança: Verificar se o evento pertence ao usuário logado
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'nullable|string|max:255',
        ]);

        // Cria o item vinculado automaticamente ao event_id através da relação
        $event->itens()->create($validated);

        return back()->with('success', 'Item adicionado com sucesso!');
    }

    /**
     * Atribuir (ou remover) um convidado como responsável pelo item.
     */
    public function vincularConvidado(Request $request, Item $item)
    {
        // Validar se o convidado_id existe na tabela de convidados
        $request->validate([
            'convidado_id' => 'nullable|exists:convidados,id'
        ]);

        $item->update([
            'convidado_id' => $request->convidado_id
        ]);

        return back()->with('success', 'Responsável pelo item atualizado!');
    }

    /**
     * Remover um item da lista.
     */
    public function destroy(Item $item)
    {
        // Opcional: Validar se o item pertence a um evento do usuário logado
        if ($item->event->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();
        
        return back()->with('success', 'Item removido da lista.');
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'nullable|string|max:255',
        ]);

        $item->update($validated);

        return back()->with('success', 'Item atualizado com sucesso!');
    }

    public function desvincular(Item $item)
    {
        // Opcional: verificar se o item realmente pertence ao convidado que está tentando desmarcar
        $item->update(['convidado_id' => null]);

        return back()->with('sucesso', 'Item liberado com sucesso! Você pode escolher outro.');
    }
}