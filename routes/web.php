<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ConvidadoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FotoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas PÚBLICAS (NÃO exigem login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Interface do Convidado (Acesso via link do WhatsApp)
Route::controller(ConvidadoController::class)->group(function () {
    // Redireciona tanto /v/ quanto /convite/ para o mesmo método seguro
    Route::get('/v/{token}', 'exibirConvite')->name('convite.publico');
    Route::get('/convite/{token}', 'exibirConvite')->name('convite.vip');
    
    // Processa a confirmação de presença e escolha de itens (se for via ConvidadoController)
    Route::post('/convite/{token}/confirmar', 'confirmar')->name('convite.confirmar');
    Route::post('/convite/item/{item_id}', 'escolherItem')->name('convite.escolherItem');
});

// Rota pública para vincular item (Caso use o ItemController para isso)
Route::put('/itens/{item}/vincular', [ItemController::class, 'vincularConvidado'])->name('itens.vincular');
Route::put('/itens/{item}/desvincular', [ItemController::class, 'desvincular'])->name('itens.desvincular');


/*
|--------------------------------------------------------------------------
| Rotas PRIVADAS (Apenas Organizadores Logados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $events = auth()->user()->events()
            ->withCount('convidados')
            ->orderBy('data_horario', 'asc')
            ->get();
        return view('dashboard', compact('events'));
    })->name('dashboard');

    // Perfil do Usuário
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Gerenciamento de Eventos (Organizador)
    Route::controller(EventController::class)->group(function () {
        Route::get('/eventos/criar', 'create')->name('events.create');
        Route::post('/eventos', 'store')->name('events.store');
        Route::get('/eventos/{event}', 'show')->name('events.show');
        Route::get('/eventos/{event}/exportar', 'exportarLista')->name('events.export');
    });

    // Gerenciamento de Convidados (Organizador)
    Route::controller(ConvidadoController::class)->group(function () {
        Route::get('/eventos/{event}/convidados/novo', 'create')->name('convidados.create');
        Route::post('/eventos/{event}/convidados/salvar', 'store')->name('convidados.store');
        Route::get('/convidados/{convidado}/edit', 'edit')->name('convidados.edit');
        Route::match(['put', 'patch'], '/convidados/{convidado}', 'update')->name('convidados.update');
        Route::delete('/convidados/{convidado}', 'destroy')->name('convidados.destroy');
    });

    // Gerenciamento de Itens (Organizador)
    Route::controller(ItemController::class)->group(function () {
        Route::get('/eventos/{event}/itens', 'index')->name('itens.index');
        Route::post('/eventos/{event}/itens', 'store')->name('itens.store');
        Route::put('/itens/{item}', 'update')->name('itens.update');
        Route::delete('/itens/{item}', 'destroy')->name('itens.destroy');
    });

    // Galeria de Fotos (Organizador)
    Route::controller(FotoController::class)->group(function () {
        Route::get('/eventos/{event}/galeria', 'index')->name('events.galeria');
        Route::post('/eventos/{event}/fotos', 'store')->name('fotos.store');
        Route::delete('/fotos/{foto}', 'destroy')->name('fotos.destroy');
    });

    //detalhes do evento
    Route::get('/events/{event}/detalhes', [EventController::class, 'detalhes'])->name('events.detalhes');

    // Imprimir lista de convidados e itens (Organizador)
    Route::get('/eventos/{event}/imprimir', [EventController::class, 'imprimirLista'])->name('events.print');
});

require __DIR__.'/auth.php';