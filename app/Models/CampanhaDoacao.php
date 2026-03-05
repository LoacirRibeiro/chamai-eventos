<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampanhaDoacao extends Model
{
    protected $fillable = ['titulo', 'token', 'ativa'];
    
    public function itens() { 
        return $this->hasMany(ItemDoacao::class); 
    }
}
