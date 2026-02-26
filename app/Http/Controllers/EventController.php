<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Convidado;
use App\Models\Item;
use App\Models\Foto;
use App\Models\Activity; // Importação necessária
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $event = Event::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_horario' => $request->data_horario,
            'local' => $request->local,
            'slug' => Str::slug($request->titulo) . '-' . rand(1000, 9999),
        ]);

        // --- REGISTRO DE ATIVIDADE ---
        Activity::create([
            'event_id' => $event->id,
            'mensagem' => "O foguete foi lançado! O evento '{$event->titulo}' foi criado.",
            'tipo' => 'presenca' // Usando 'presenca' como tipo geral de sistema
        ]);

        return redirect()->route('dashboard')->with('success', 'Evento criado com sucesso!');
    }

    public function addItem(Request $request, Event $event)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'nullable|string|max:100',
        ]);

        $item = $event->itens()->create([
            'nome' => $request->nome,
            'quantidade' => $request->quantidade,
        ]);

        // --- REGISTRO DE ATIVIDADE ---
        Activity::create([
            'event_id' => $event->id,
            'mensagem' => "Novo item adicionado: {$item->nome} ({$item->quantidade})",
            'tipo' => 'item'
        ]);

        return back()->with('sucesso', 'Item adicionado à lista!');
    }

    public function show(Event $event)
    {
        $event->load(['convidados' => function($query) {
            $query->orderBy('presenca', 'asc'); 
        }, 'activities' => function($query) {
            $query->latest()->take(15); // Carrega as últimas 15 atividades
        }]);

        $totalConvidados = $event->convidados->count();
        $confirmados = $event->convidados->where('presenca', 'confirmado')->count();
        $pendentes = $event->convidados->where('presenca', 'pendente')->count();

        return view('events.show', compact('event', 'confirmados', 'pendentes', 'totalConvidados'));
    }

    public function uploadFotos(Request $request, Event $event)
    {
        $request->validate([
            'fotos.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if ($request->hasFile('fotos')) {
            $count = 0;
            foreach ($request->file('fotos') as $fotoArquivo) {
                $caminho = $fotoArquivo->store('festas', 'public');

                $event->fotos()->create([
                    'caminho' => $caminho,
                    'user_id' => auth()->id(),
                ]);
                $count++;
            }

            // --- REGISTRO DE ATIVIDADE ---
            $userName = auth()->user()->name ?? 'Alguém';
            Activity::create([
                'event_id' => $event->id,
                'mensagem' => "{$userName} subiu {$count} nova(s) foto(s) no álbum!",
                'tipo' => 'item' // Pode usar um tipo 'foto' se criar no banco depois
            ]);
        }

        return back()->with('sucesso', 'Fotos enviadas com sucesso para o álbum!');
    }

    public function exportarLista(Event $event)
    {
        $event->load('itens.convidados'); // Ajustado para carregar convidados (quem leva)
        
        $texto = "📋 *LISTA DE COMPRAS: {$event->titulo}*\n";
        $texto .= "📅 *Data:* " . \Carbon\Carbon::parse($event->data_horario)->format('d/m H:i') . "\n";
        $texto .= "📍 *Local:* {$event->local}\n";
        $texto .= "------------------------------\n\n";

        foreach ($event->itens as $item) {
            $jaReservado = $item->convidados->sum('pivot.quantidade_levada');
            $status = $jaReservado > 0 ? "✅ Total: " . $jaReservado : "❌ _Pendente_";
            $texto .= "• {$item->nome} (Meta: {$item->quantidade}) - {$status}\n";
        }

        $texto .= "\n_Gerado pelo sistema Chamaí!_ 🚀";

        return back()->with('lista_texto', $texto);
    }

    public function removeGuest(Convidado $convidado) 
    {
        $eventId = $convidado->event_id;
        $nome = $convidado->nome;
        
        // Activity Log
        Activity::create([
            'event_id' => $eventId,
            'mensagem' => "O convidado {$nome} foi removido da lista.",
            'tipo' => 'presenca'
        ]);

        $convidado->delete();
        return back()->with('sucesso', 'Convidado removido!');
    }

    public function removeItem(Item $item) 
    {
        $eventId = $item->event_id;
        $nome = $item->nome;

        Activity::create([
            'event_id' => $eventId,
            'mensagem' => "O item '{$nome}' foi retirado da lista de necessidades.",
            'tipo' => 'item'
        ]);

        $item->delete();
        return back()->with('sucesso', 'Item removido da lista!');
    }

    public function removeFoto(Foto $foto) 
    {
        $eventId = $foto->event_id;

        if (Storage::disk('public')->exists($foto->caminho)) {
            Storage::disk('public')->delete($foto->caminho);
        }

        $foto->delete();

        Activity::create([
            'event_id' => $eventId,
            'mensagem' => "Uma foto foi removida da galeria.",
            'tipo' => 'item'
        ]);

        return back()->with('sucesso', 'Foto removida!');
    }

    public function detalhes(Event $event)
{
    // Carrega o evento com todas as atividades
    $event->load('activities');
    return view('events.detalhes', compact('event'));
}
}