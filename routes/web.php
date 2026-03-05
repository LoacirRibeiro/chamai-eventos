<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ConvidadoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\DoacaoController;
use App\Http\Controllers\PublicDoacaoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas PÚBLICAS (NÃO exigem login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Interface do Convidado (Links de WhatsApp)
Route::controller(ConvidadoController::class)->group(function () {
    Route::get('/v/{token}', 'exibirConvite')->name('convite.publico');
    Route::get('/convite/{token}', 'exibirConvite')->name('convite.vip');
    Route::post('/convite/{token}/confirmar', 'confirmar')->name('convite.confirmar');
    Route::post('/convite/item/{item_id}', 'escolherItem')->name('convite.escolherItem');
});

    // Doação Pública Para Eventos do tipo "comum" (Links de Compartilhamento)
    Route::get('/doar/{token}', [DoacaoController::class, 'show'])->name('doacao.publica');
    Route::post('/doar/{token}', [DoacaoController::class, 'registrarDoacao'])->name('doacao.registrar');
    // Itens (Vínculo público)
    Route::put('/itens/{item}/vincular', [ItemController::class, 'vincularConvidado'])->name('itens.vincular');
    Route::put('/itens/{item}/desvincular', [ItemController::class, 'desvincular'])->name('itens.desvincular');


    // Rota aberta para doadores externos para eventos do tipo "doacao" (Links de Compartilhamento)
    Route::get('/contribuir/{token}', [PublicDoacaoController::class, 'show'])->name('doacao.publica');
    // Rota para a "Landing Page" da doação
    Route::get('/doar/{token}', [PublicDoacaoController::class, 'index'])->name('doacao.publica');
    // Rota para salvar o nome na sessão e liberar a lista
    Route::post('/doar/{token}/participar', [PublicDoacaoController::class, 'participar'])->name('doacao.participar');
    // Rota para processar a doação do item
    Route::post('/doar/registrar/{item}', [PublicDoacaoController::class, 'registrarDoacao'])->name('doacao.registrar');
    Route::delete('/doar/{token}/cancelar/{item}', [PublicDoacaoController::class, 'cancelar'])->name('doacao.cancelar');

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

    // Perfil
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Gerenciamento de Eventos e Doações (EventController)
    Route::controller(EventController::class)->group(function () {
        Route::get('/eventos/criar', 'create')->name('events.create');
        Route::post('/eventos', 'store')->name('events.store');
        Route::get('/eventos/{event}', 'show')->name('events.show');
        Route::get('/events/{event}/detalhes', 'detalhes')->name('events.detalhes');
        Route::get('/eventos/{event}/exportar', 'exportarLista')->name('events.export');
        Route::get('/eventos/{event}/imprimir', 'imprimirLista')->name('events.print');        
        // Rota unificada para Gerenciar Itens (Onde estava o erro 404)
        Route::get('/eventos/{slug}/itens', 'gerenciarItens')->name('doacao.itens');       
        // Adicionar itens (usado tanto em festa quanto em doação)
        Route::post('/eventos/{event}/itens/adicionar', 'addItem')->name('eventos.items.add');
    });

    // Gerenciamento de Convidados
    Route::controller(ConvidadoController::class)->group(function () {
        Route::get('/eventos/{event}/convidados/novo', 'create')->name('convidados.create');
        Route::post('/eventos/{event}/convidados/salvar', 'store')->name('convidados.store');
        Route::get('/convidados/{convidado}/edit', 'edit')->name('convidados.edit');
        Route::match(['put', 'patch'], '/convidados/{convidado}', 'update')->name('convidados.update');
        Route::delete('/convidados/{convidado}', 'destroy')->name('convidados.destroy');
    });

    // Gerenciamento de Itens (ItemController)
    Route::controller(ItemController::class)->group(function () {
        Route::get('/eventos/{event}/itens-lista', 'index')->name('itens.index'); 
        Route::post('/eventos/{event}/itens-lista', 'store')->name('itens.store');
        Route::post('/eventos/{event}/itens/adicionar', 'store')->name('eventos.items.add');
        // No seu web.php, mude para:
        Route::delete('/itens/{item}/remover', 'destroy')->name('eventos.items.remove');
        Route::put('/itens/{item}', 'update')->name('itens.update');
        Route::delete('/itens/{item}', 'destroy')->name('itens.destroy');
    });

    // Galeria de Fotos
    Route::controller(FotoController::class)->group(function () {
        Route::get('/eventos/{event}/galeria', 'index')->name('events.galeria');
        Route::post('/eventos/{event}/fotos', 'store')->name('fotos.store');
        Route::delete('/fotos/{foto}', 'destroy')->name('fotos.destroy');
    });
   
});

require __DIR__.'/auth.php';