<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    // Define o nome correto da tabela
    protected $table = 'itens'; 

    protected $fillable = [
        'event_id', 
        'nome', 
        'quantidade',
        // 'convidado_id' -> REMOVIDO: Não usaremos mais esta coluna direta
    ];

    /**
     * Relação com o Evento (Um item pertence a um evento)
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * Relação Muitos para Muitos com Convidados
     * Isso permite que vários convidados tragam o mesmo item (ex: 5 pessoas trazendo Cerveja)
     */
    public function convidados(): BelongsToMany
    {
        return $this->belongsToMany(Convidado::class, 'convidado_item')
                    ->withPivot('quantidade_levada')
                    ->withTimestamps();
    }
}