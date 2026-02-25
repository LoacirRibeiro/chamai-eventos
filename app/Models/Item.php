<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    // Correto: O Laravel por padrão buscaria 'items', então definir 'itens' é essencial
    protected $table = 'itens'; 

    protected $fillable = [
        'event_id', 
        'nome', 
        'quantidade', 
        'convidado_id'
    ];

    /**
     * Relação com o Evento
     */
    public function event(): BelongsTo // Alterado de 'evento' para 'event' para manter o padrão
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * Relação com o Convidado que vai trazer o item
     */
    public function convidado(): BelongsTo // Alterado de 'quemLeva' para 'convidado'
    {
        return $this->belongsTo(Convidado::class, 'convidado_id');
    }
}