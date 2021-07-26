<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerguntaRespondidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pergunta_respondidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_pergunta');
            $table->unsignedInteger('id_opcao_resposta');
            $table->unsignedInteger('id_opcao_correta');
            $table->string('situacao');
            $table->string('nome_pessoa');
            $table->string('idade_pessoa');
            $table->enum('sexo_pessoa', ['M', 'F'])->default('M');
            $table->double('pontuacao', 25,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pergunta_respondidas');
    }
}
