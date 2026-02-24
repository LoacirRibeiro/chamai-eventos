<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convidado extends Model
{
    // O Laravel busca por 'convidados' automaticamente, mas podemos reforçar:
    protected $table = 'convidados';

    protected $fillable = [
        'event_id',
        'nome',
        'contato',
        'token_acesso',
        'presenca'
    ];

    // Criar o link único (token) automaticamente antes de salvar no banco
    protected static function booted()
    {
        static::creating(function ($convidado) {
            $convidado->token_acesso = Str::random(40);
        });
    }

    public function evento() 
    {
    return $this->belongsTo(Event::class, 'event_id');
    }
}