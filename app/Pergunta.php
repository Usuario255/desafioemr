<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    protected $fillable = [
        'id', 'descricao_pergunta', 'pontuacao',
    ];

    public function questionario()
    {
        return $this->belongsTo('App\Questionario');
    }
}
