<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroDoacao extends Model
{
    protected $fillable = ['item_doacao_id', 'nome_doador', 'quantidade_doada'];
}
