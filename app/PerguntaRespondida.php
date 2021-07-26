<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerguntaRespondida extends Model
{
    protected $fillable = [
        'id', 'nome_pessoa', 'idade_pessoa', 'sexo_pessoa', 'id_pergunta', 'id_opcao_resposta', 'pontuacao'
    ];
}
