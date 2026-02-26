<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'mensagem',
        'tipo',
    ];

    /**
     * Relacionamento: A atividade pertence a um evento.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}