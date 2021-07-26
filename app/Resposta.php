<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    protected $fillable = [
        'id', 'id_pergunta', 'id_opcao_resposta',
    ];
}
