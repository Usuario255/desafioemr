<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpcaoResposta extends Model
{
    protected $fillable = [
        'id', 'descricao_opcao', 'id_pergunta'
    ];
}
