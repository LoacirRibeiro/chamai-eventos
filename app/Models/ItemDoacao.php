<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemDoacao extends Model
{
    protected $fillable = ['campanha_doacao_id', 'nome', 'quantidade_necessaria'];
    
    public function registros() { 
        return $this->hasMany(RegistroDoacao::class); 
    }
}
