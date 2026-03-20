<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ConvidadoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\DoacaoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoacaoItemController;
use App\Http\Controllers\PublicDonationController;
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
    Route::get('/convite/{token}', [App\Http\Controllers\ConvidadoController::class, 'exibirConvite'])
    ->name('convite.exibir');
    //Route::get('/convite/{token}', 'exibirConvite')->name('convite.vip');
    
    // Processa a confirmação de presença e escolha de itens (se for via ConvidadoController)
    Route::post('/convite/{token}/confirmar', 'confirmar')->name('convite.confirmar');
    Route::post('/convite/item/{item_id}', 'escolherItem')->name('convite.escolherItem');
});

// Rota pública: acessada pelo link do WhatsApp
    Route::get('/doacao/{token}', [PublicDonationController::class, 'show'])
    ->name('public.doacao.show');

    Route::get('/doar/{token}', [PublicDonationController::class, 'show'])->name('public.show');

// Rota para processar a escolha dos itens
//Route::post('/doar/{token}/confirmar', [PublicDonationController::class, 'confirm'])
//    ->name('public.doacao.confirm');

Route::post('/doar/{token}/confirmar/{itemId}', [PublicDonationController::class, 'confirmSingle'])
    ->name('public.doacao.confirm_single');

Route::get('/doacao/{token}/sucesso', [PublicDonationController::class, 'success'])
    ->name('public.doacao.success');

Route::post('/doacao/{token}/confirmar-tudo', [PublicDonationController::class, 'confirmarTudo'])
    ->name('public.doacao.confirmar_tudo');

// Rota pública para vincular item 
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
        // Rota específica para o SweetAlert de Status
        Route::patch('/convidados/{id}/status', [App\Http\Controllers\ConvidadoController::class, 'updateStatus'])->name('convidados.updateStatus');

        // Sua rota de update normal (mantenha ela)
        Route::match(['put', 'patch'], '/convidados/{convidado}', [App\Http\Controllers\ConvidadoController::class, 'update'])->name('convidados.update');
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

    /*
|--------------------------------------------------------------------------
| MÓDULO DE DOAÇÕES (Novo e Isolado)
|--------------------------------------------------------------------------
*/
// Rotas de Doações
    Route::get('/doacoes/criar', [DoacaoController::class, 'create'])->name('doacoes.create');
    Route::post('/doacoes', [DoacaoController::class, 'store'])->name('doacoes.store');
    Route::get('/doacoes/{doacao}', [DoacaoController::class, 'show'])->name('doacoes.show');
});

Route::middleware(['auth'])->group(function () {
    // Rotas para Itens de Doação
    Route::post('/doacoes/{doacao}/itens', [DoacaoItemController::class, 'store'])->name('doacao_itens.store');
    Route::delete('/doacao-itens/{item}', [DoacaoItemController::class, 'destroy'])->name('doacao_itens.destroy');
    Route::get('/doacao-itens/{item}/editar', [DoacaoItemController::class, 'edit'])->name('doacao_itens.edit');
    Route::put('/doacao-itens/{item}', [DoacaoItemController::class, 'update'])->name('doacao_itens.update');
    Route::get('/doacoes/{id}/pdf', [DoacaoController::class, 'gerarPdf'])->name('doacoes.pdf');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');




require __DIR__.'/auth.php';