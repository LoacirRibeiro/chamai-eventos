<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'data_horario',
        'local',
        'slug',
    ];

    public function convidados()
    {
        return $this->hasMany(Convidado::class, 'event_id');
    }

    public function fotos() 
    { 
        return $this->hasMany(Foto::class, 'event_id'); 
    }
}
