<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\ConvidadoController;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Event;

Route::get('/dashboard', function () {
    // Busca os eventos do usuário logado, ordenados pela data mais próxima
    $events = auth()->user()->events()
        ->withCount('convidados') // Conta os convidados sem carregar a lista toda (mais rápido)
        ->orderBy('data_horario', 'asc')
        ->get();

    return view('dashboard', compact('events'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rota para mostrar o formulário
Route::get('/eventos/criar', [EventController::class, 'create'])->name('events.create')->middleware('auth');

// Rota que o seu botão na linha 22 está procurando:
    Route::get('/eventos/{event}/convidados/novo', [ConvidadoController::class, 'create'])->name('convidados.create');
    
    // Rota para salvar o convidado (POST)
    Route::post('/eventos/{event}/convidados/salvar', [ConvidadoController::class, 'store'])->name('convidados.store');

// Rota para salvar os dados no banco
Route::post('/eventos', [EventController::class, 'store'])->name('events.store')->middleware('auth');

// Rota pública para o convidado confirmar presença
Route::get('/convite/{token}', [App\Http\Controllers\ConvidadoController::class, 'exibirConvite'])
    ->name('convite.vip');

// Rota pública para confirmação de presença via POST
Route::get('/convite/{token}', [ConvidadoController::class, 'exibirConvite'])->name('convite.vip');
Route::post('/convite/{token}/confirmar', [ConvidadoController::class, 'confirmar'])->name('convite.confirmar');

// Rota para o organizador adicionar itens à festa
Route::post('/eventos/{event}/itens', [App\Http\Controllers\EventController::class, 'addItem'])->name('events.addItem');

// Rota para visualizar e gerenciar um evento específico
Route::get('/eventos/{event}', [App\Http\Controllers\EventController::class, 'show'])->name('events.show')->middleware('auth');

// Rota para o organizador subir fotos da festa
Route::post('/eventos/{event}/fotos', [App\Http\Controllers\EventController::class, 'uploadFotos'])->name('events.uploadFotos');

// Rota para gerar o texto da lista para o organizador
Route::get('/eventos/{event}/exportar', [App\Http\Controllers\EventController::class, 'exportarLista'])->name('events.export');

// Deletar um convidado
Route::delete('/convidados/{convidado}', [App\Http\Controllers\EventController::class, 'removeGuest'])->name('guests.destroy');

// Deletar um item
Route::delete('/itens/{item}', [App\Http\Controllers\EventController::class, 'removeItem'])->name('items.destroy');

// Deletar uma foto
Route::delete('/fotos/{foto}', [App\Http\Controllers\EventController::class, 'removeFoto'])->name('fotos.destroy');

// Rota para o convidado abrir o convite
Route::get('/convite/{id}', [App\Http\Controllers\ConvidadoController::class, 'showPublic'])->name('convite.publico');

// Rota para o convidado clicar no botão de confirmar
Route::post('/convite/{id}/confirmar', [App\Http\Controllers\ConvidadoController::class, 'confirmarPublico'])->name('convite.confirmar');

Route::put('/convidados/{convidado}', [ConvidadoController::class, 'update'])->name('convidados.update');
Route::match(['put', 'patch'], '/convidados/{convidado}', [ConvidadoController::class, 'update'])->name('convidados.update');
Route::get('/convidados/{convidado}/edit', [ConvidadoController::class, 'edit'])->name('convidados.edit');
Route::delete('/convidados/{convidado}', [ConvidadoController::class, 'destroy'])->name('convidados.destroy');


Route::get('/eventos/{event}/itens', [ItemController::class, 'index'])->name('itens.index');
Route::post('/eventos/{event}/itens', [ItemController::class, 'store'])->name('itens.store');
Route::put('/itens/{item}/vincular', [ItemController::class, 'vincularConvidado'])->name('itens.vincular');
Route::delete('/itens/{item}', [ItemController::class, 'destroy'])->name('itens.destroy');
Route::put('/itens/{item}', [ItemController::class, 'update'])->name('itens.update');

require __DIR__.'/auth.php';
