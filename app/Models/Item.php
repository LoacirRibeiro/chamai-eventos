<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'itens'; // Garante que o Laravel use o nome em português

    protected $fillable = ['event_id', 'nome', 'quantidade', 'convidado_id'];

    public function evento()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function quemLeva()
    {
        return $this->belongsTo(Convidado::class, 'convidado_id');
    }
}
