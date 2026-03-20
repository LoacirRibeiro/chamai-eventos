<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoacaoItem extends Model
{
    protected $table = 'doacao_itens';

    protected $fillable = [
        'doacao_id',
        'nome',
        'quantidade_meta',
        'quantidade_arrecadada',
        'unidade_medida'
    ];

    public function doacao(): BelongsTo
    {
        return $this->belongsTo(Doacao::class);
    }

    public function participantes() {
    // Um item tem muitos participantes
    return $this->hasMany(DoacaoParticipante::class, 'doacao_itens_id');
    }
}