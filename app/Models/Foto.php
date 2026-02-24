<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = ['event_id', 'caminho', 'legenda', 'user_id'];

    public function evento() {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
