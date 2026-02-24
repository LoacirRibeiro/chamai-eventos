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
        'e_mail',
        'telefone',
        'token_acesso',
        'presenca'
    ];

    // Criar o link único (token) automaticamente antes de salvar no banco
    protected static function booted()
    {
        static::creating(function ($convidado) {
            $convidado->token_acesso = bin2hex(random_bytes(8));
        });
    }

    public function evento() 
    {
    return $this->belongsTo(Event::class, 'event_id');
    }
}