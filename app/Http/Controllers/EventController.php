<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Models\Foto;

class EventController extends Controller
{
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'data_horario' => 'required',
            'local' => 'required|string',
        ]);

        Event::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_horario' => $request->data_horario,
            'local' => $request->local,
            'slug' => Str::slug($request->titulo) . '-' . rand(1000, 9999), // Ex: niver-1234
        ]);

        return redirect()->route('dashboard')->with('success', 'Evento criado com sucesso!');
    }

    public function addItem(Request $request, Event $event)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'nullable|string|max:100',
        ]);

        $event->itens()->create([
            'nome' => $request->nome,
            'quantidade' => $request->quantidade,
        ]);

        return back()->with('sucesso', 'Item adicionado à lista!');
    }

    public function show(Event $event)
    {
        // O Laravel faz o "Route Model Binding", ou seja, ele já busca o $event pelo ID automaticamente.
        // Carregamos os relacionamentos (convidados e itens) para a página.
        $event->load(['convidados', 'itens.quemLeva']);

        return view('events.show', compact('event'));
    }

    public function uploadFotos(Request $request, Event $event)
    {
        $request->validate([
            'fotos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120' // Máximo 5MB por foto
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $fotoArquivo) {
                // Salva o arquivo na pasta 'public/festas'
                $caminho = $fotoArquivo->store('festas', 'public');

                // Salva no banco de dados
                $event->fotos()->create([
                    'caminho' => $caminho,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return back()->with('sucesso', 'Fotos enviadas com sucesso para o álbum!');
    }
}