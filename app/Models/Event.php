<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'data_horario',
        'local',
        'slug',
        'public_token',
        'tipo'
    ];

    // Garante que o Laravel trate a data como um objeto Carbon automaticamente
    protected $casts = [
        'data_horario' => 'datetime',
    ];

    /**
     * RELAÇÃO QUE ESTAVA FALTANDO
     * Um evento possui muitos itens (bebidas, comidas, etc).
     */
    public function itens(): HasMany
    {
        return $this->hasMany(Item::class, 'event_id');
    }

    public function convidados(): HasMany
    {
        return $this->hasMany(Convidado::class, 'event_id');
    }

    public function fotos(): HasMany 
    { 
        return $this->hasMany(Foto::class, 'event_id'); 
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}