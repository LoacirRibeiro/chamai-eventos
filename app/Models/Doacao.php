<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doacao extends Model
{
    protected $table = 'doacoes';
    protected $fillable = 
        [
            'titulo', 
            'descricao', 
            'token',
            'data_limite', 
            'status'  
        ];

    // Relacionamento: Uma doação pertence a um usuário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function participantes(): HasMany
    {
        // O primeiro argumento é o Model de destino
        // O segundo argumento é a chave estrangeira na tabela de participantes
        return $this->hasMany(DoacaoParticipante::class, 'doacao_id');
    }

    // Relacionamento: Uma doação tem muitos itens
    public function itens(): HasMany
    {
        return $this->hasMany(DoacaoItem::class, 'doacao_id');
    }
}