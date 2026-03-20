<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel principal do usuário.
     * Se o usuário não tiver nenhum evento ou doação, exibe a tela de escolha.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Busca os dados separadamente
        $events = $user->events()->orderBy('data_horario', 'asc')->get();
        $doacoes = $user->doacoes()->orderBy('created_at', 'desc')->get();

        // Se ambos estiverem vazios, redireciona o usuário para a tela de escolha
        if ($events->isEmpty() && $doacoes->isEmpty()) {
            return view('dashboard.escolha');
        }

        // Caso contrário, retorna a dashboard com as listas preenchidas
        return view('dashboard.index', compact('events', 'doacoes'));
    }
}