<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; 
use App\Models\Convidado;

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

    public function showPublic($id)
    {
        $convidado = Convidado::findOrFail($id);
        $event = $convidado->event; // Certifique-se de que a relação 'event' existe no model Convidado

        return view('convidados.public_show', compact('convidado', 'event'));
    }

    public function confirmarPublico($id)
    {
        $convidado = Convidado::findOrFail($id);
        $convidado->update(['confirmado' => true]);

        return back()->with('success', 'Presença confirmada com sucesso!');
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string', // Campo obrigatório para o Zap
            'email' => 'nullable|email',
        ]);

        $event->convidados()->create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'presenca' => 'pendente',
        ]);

       return redirect()->route('events.show', $event->id)
            ->with('success', 'Convidado adicionado com sucesso!');
    }

    public function create(Event $event)
    {
        // Retorna a view 'resources/views/convidados/create.blade.php'
        return view('convidados.create', compact('event'));
    }

    public function edit(Convidado $convidado)
    {
        // Retorna a view de edição passando o convidado
        return view('convidados.edit', compact('convidado'));
    }

    public function update(Request $request, Convidado $convidado)
    {
        // Se a requisição contiver apenas o campo 'presenca', é a troca de status via SweetAlert
        if ($request->has('presenca') && !$request->has('nome')) {
            $convidado->update([
                'presenca' => $request->presenca
            ]);
            
            return back()->with('success', 'Status de ' . $convidado->nome . ' atualizado para ' . ucfirst($request->presenca));
        }

        // Lógica para a Edição Completa (Nome, Telefone, etc)
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string',
        ]);

        $convidado->update($request->all());

        return redirect()->route('events.show', $convidado->event_id)
                        ->with('success', 'Dados atualizados com sucesso!');
    }

    public function destroy(Convidado $convidado)
    {
        $eventId = $convidado->event_id; // Guarda o ID para voltar à página certa
        //dd($convidado);
        $convidado->delete();

        return redirect()->route('events.show', $eventId)
            ->with('success', 'Convidado removido com sucesso!');
    }
}
