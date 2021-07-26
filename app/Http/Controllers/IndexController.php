<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pergunta;
use App\OpcaoResposta;
use App\Resposta;
use App\PerguntaRespondida;
use App\Http\Controllers\QuestoesController;


class IndexController extends Controller
{
    public function __construct()
    {
        // definindo que o usuario nao precisa estar logado para acessar este controller.
        $this->middleware('guest');
    }

    public function index()
    {
        // pegando as perguntas do banco
        $perguntas = Pergunta::get();

        // retornando a view do questionario com as perguntas.
        return view('welcome', compact('perguntas'));
    }

    public function enviarRespostas(Request $request)
    {
        // pegando os valores dos campos na view.
        $post = $request->all();

        // pontuacao comeca com a nota maxima
        $nota = Pergunta::sum('pontuacao');
        $pontuacao = 0;
        $situacao  = NULL;

        // estipulando as medias
        $media = $nota / 2;

        foreach($post['pergunta'] as $idPergunta){
            $pergunta = Pergunta::find($idPergunta);
            $resposta = QuestoesController::retornaRespostaPorIdPergunta($pergunta->id);

            // verificando se a resposta esta certa, se estiver errada subtrai com a pontuacao da pergunta.
            if ($post['opcao_resposta-'.$idPergunta] == $resposta->id_opcao_resposta) {
                $nota = $nota - 0;
                $pontuacao = $pergunta->pontuacao;
                $situacao  = "Correto";
            }else{
                $nota = $nota - $pergunta->pontuacao;
                $situacao  = "Errado";
            }

            // salvando a pergunta respondida.
            $perguntaRespondida = new PerguntaRespondida();
            $perguntaRespondida->id_pergunta       = $pergunta->id;
            $perguntaRespondida->id_opcao_resposta = $post['opcao_resposta-'.$idPergunta];
            $perguntaRespondida->id_opcao_correta  = $resposta->id_opcao_resposta;
            $perguntaRespondida->situacao          = $situacao;
            $perguntaRespondida->nome_pessoa       = $post['nome'];
            $perguntaRespondida->idade_pessoa      = $post['idade'];
            $perguntaRespondida->sexo_pessoa       = $post['sexo'];
            $perguntaRespondida->pontuacao         = $pontuacao;
            $perguntaRespondida->save();
        }

        // enviando as notificacoes para o questionario na view.
        if ($nota >= $media) {
            \Session::flash('mensagem_sucesso', 'Parabéns, Sua nota foi '.$nota.'!');
        }else{
            \Session::flash('erro', 'Que Pena, Sua nota foi '.$nota.'!');
        }

        // redirecionando para o questionario apos responder as perguntas
        return redirect(route('welcome'));

    }

}
