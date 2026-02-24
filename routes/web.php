<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Event;

Route::get('/dashboard', function () {
    // Busca os eventos do usuário logado, ordenados pela data mais próxima
    $eventos = Event::where('user_id', auth()->id())
                    ->orderBy('data_horario', 'asc')
                    ->get();

    return view('dashboard', compact('eventos'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rota para mostrar o formulário
Route::get('/eventos/criar', [EventController::class, 'create'])->name('events.create')->middleware('auth');

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

require __DIR__.'/auth.php';
