<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FotoController extends Controller
{
    /**
     * Exibir a galeria do evento.
     */
    public function index(Event $event)
    {
        // Carrega as fotos com os usuários que as enviaram (Eager Loading)
        $event->load(['fotos.user']);
        
        return view('events.galeria', compact('event'));
    }

    /**
     * Salvar múltiplas fotos na galeria.
     */
    public function store(Request $request, Event $event)
    {
        // Validação: máximo de 5MB por foto e apenas imagens
        $request->validate([
            'fotos' => 'required|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $arquivo) {
                // Salva o arquivo fisicamente: storage/app/public/eventos/{id}
                $caminho = $arquivo->store("eventos/{$event->id}", 'public');

                // Cria o registro no banco de dados
                Foto::create([
                    'event_id' => $event->id,
                    'user_id'  => Auth::id(),
                    'caminho'  => $caminho,
                    'legenda'  => $request->legenda ?? null,
                ]);
            }
        }

        return back()->with('success', 'As fotos foram eternizadas na galeria!');
    }

    /**
     * Remover uma foto (apenas dono do evento ou quem subiu a foto).
     */
    public function destroy(Foto $foto)
    {
        // Verifica se o usuário logado é o dono da foto OU o organizador do evento
        if (Auth::id() === $foto->user_id || Auth::id() === $foto->evento->user_id) {
            
            // Remove o arquivo físico do Storage
            if (Storage::disk('public')->exists($foto->caminho)) {
                Storage::disk('public')->delete($foto->caminho);
            }

            // Remove o registro do banco
            $foto->delete();

            return back()->with('success', 'Foto removida com sucesso.');
        }

        abort(403, 'Você não tem permissão para remover esta foto.');
    }
}