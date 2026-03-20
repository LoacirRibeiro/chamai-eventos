<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoacaoParticipante extends Model
{
    protected $table = 'doacao_participantes'; // Força o nome da sua tabela
    protected $fillable = [
        'doacao_id',
        'doacao_itens_id', 
        'nome', 
        'quantidade', 
        'whatsapp'
    ];

    public function item()
    {
        // Um registro de doação pertence a um item específico
        return $this->belongsTo(DoacaoItem::class, 'doacao_itens_id');
    }

    public function doacao()
    {
        // Um registro de doação pertence a uma doação específica
        return $this->belongsTo(Doacao::class, 'doacao_id');
    }
}
