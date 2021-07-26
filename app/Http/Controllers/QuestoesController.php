<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pergunta;
use App\OpcaoResposta;
use App\Resposta;
use DB;

class QuestoesController extends Controller
{
    public function __construct(Pergunta $pergunta)
    {
        $this->middleware('auth');
        $this->pergunta = $pergunta;
    }

    public function index(Request $request)
    {
        if (isset($request->qtd_respostas)) {
            $having = "HAVING count(op.id) = {$request->qtd_respostas}";
        }else{
            $having = NULL;
        }

        if (isset($request->nome_pergunta)) {
            $where = "WHERE p.descricao_pergunta LIKE '%{$request->nome_pergunta}%'";
        }else{
            $where = NULL;
        }

        $sql = "SELECT p.id, p.descricao_pergunta, p.pontuacao, p.created_at, p.updated_at FROM perguntas p
                INNER JOIN opcao_respostas op ON (op.id_pergunta = p.id)
                {$where}
                GROUP BY p.id, p.descricao_pergunta, p.pontuacao, p.created_at, p.updated_at
                {$having}";

        $perguntas = DB::select($sql);

        return view('questoes.index', compact('perguntas', 'request'));

    }

    public function form()
    {
        return view('questoes.form');
    }

    public function salvar(Request $request)
    {
        $post = $request->all();
        $pergunta = self::retornaPerguntaPorDescricao($post['descricao_pergunta']);

        if (!$pergunta) {
            $pergunta = new Pergunta();
            $pergunta->descricao_pergunta = $post['descricao_pergunta'];
            $pergunta->pontuacao = $post['pontuacao'];
            $pergunta->save();

            foreach ($post['descricao_opcao'] as $descricao_opcao) {
                $opcaoResposta = new OpcaoResposta();
                $opcaoResposta->id_pergunta = $pergunta->id;
                $opcaoResposta->descricao_opcao = $descricao_opcao;
                $opcaoResposta->save();
            }

            $opcoesRespostas = self::retornaOpcoesRespostaPorIdPergunta($pergunta->id);

            $resposta = new Resposta();
            $resposta->id_pergunta = $pergunta->id;
            $resposta->id_opcao_resposta = $opcoesRespostas[$post['resposta'] - 1]->id;
            $resposta->save();
        }else{
            \Session::flash('erro', 'Pergunta já cadastrada no sistema');
            return redirect(route('questoes.index'));
        }

        \Session::flash('successo', 'Pergunta cadastrada com sucesso');
        return redirect(route('questoes.index'));

    }

    public function editar($id)
    {
        $pergunta = Pergunta::findOrFail($id);
        $opcoesRespostas = self::retornaOpcoesRespostaPorIdPergunta($pergunta->id);
        $resposta = self::retornaRespostaPorIdPergunta($pergunta->id);

        $countOpcoesRespostas = OpcaoResposta::where('id_pergunta', '=', $pergunta->id)->count();

        return view('questoes.editar', compact('pergunta', 'opcoesRespostas', 'resposta', 'countOpcoesRespostas'));
    }

    public function atualizar(Request $request, $id)
    {
        $post = $request->all();

        $pergunta = Pergunta::findOrFail($id);
        $pergunta->descricao_pergunta = $post['descricao_pergunta'];
        $pergunta->pontuacao = $post['pontuacao'];
        $pergunta->save();

        foreach ($post['descricao_opcao'] as $descricao_opcao) {
            $opcaoResposta = self::retornaOpcaoRespostaPorDescricao($descricao_opcao);
            if ($opcaoResposta) {
                $opcaoResposta->descricao_opcao = $descricao_opcao;
                $opcaoResposta->save();
            }else{
                $opcaoResposta = new OpcaoResposta();
                $opcaoResposta->id_pergunta = $pergunta->id;
                $opcaoResposta->descricao_opcao = $descricao_opcao;
                $opcaoResposta->save();
            }
        }

        $opcoesRespostas = self::retornaOpcoesRespostaPorIdPergunta($pergunta->id);

        $resposta        = self::retornaRespostaPorIdPergunta($pergunta->id);
        $resposta->id_pergunta = $pergunta->id;
        $resposta->id_opcao_resposta = $opcoesRespostas[$post['resposta'] - 1]->id;
        $resposta->save();

        \Session::flash('successo', 'Pergunta atualizada com sucesso');
        return redirect(route('questoes.index'));

    }

    public function excluir(Request $request, $id)
    {
        $pergunta = Pergunta::findOrFail($id);

        $opcoesRespostas = self::retornaOpcoesRespostaPorIdPergunta($pergunta->id);

        foreach($opcoesRespostas as $opcaoResposta){
            $opcaoResposta->delete();
        }
        $resposta = self::retornaRespostaPorIdPergunta($pergunta->id);
        $pergunta->delete();
        $resposta->delete();

        \Session::flash('successo', 'Perguntas e respostas deletados com sucesso');
        return redirect(route('questoes.index'));
    }

    public function buscar(Request $request)
    {
        if ($request->qtd_respostas) {
            $having = "HAVING count(op.id) = {$request->qtd_respostas}";
        }else{
            $having = NULL;
        }

        if (isset($request->nome_pergunta)) {
            $where = "WHERE p.descricao_pergunta LIKE '%{$request->nome_pergunta}%'";
        }else{
            $where = NULL;
        }

        $sql = "SELECT p.id, p.descricao_pergunta, p.pontuacao, p.created_at, p.updated_at FROM perguntas p
                INNER JOIN opcao_respostas op ON (op.id_pergunta = p.id)
                {$where}
                GROUP BY p.id, p.descricao_pergunta, p.pontuacao, p.created_at, p.updated_at
                {$having}";

        $perguntas = DB::select($sql);

        return view('questoes.index', compact('perguntas', 'request'));
    }

    public static function retornaOpcoesRespostaPorIdPergunta($idPergunta)
    {
        $opcoesRespostas = OpcaoResposta::where('id_pergunta', '=', $idPergunta)->get();

        if ($opcoesRespostas) {
            return $opcoesRespostas;
        }else{
            return false;
        }
    }

    public static function retornaRespostaPorIdPergunta($idPergunta)
    {
        $resposta = Resposta::where('id_pergunta', '=', $idPergunta)->first();

        if ($resposta) {
            return $resposta;
        }else{
            return false;
        }
    }

    public static function retornaOpcaoRespostaPorDescricao($descricao)
    {
        $opcoes = OpcaoResposta::where('descricao_opcao', 'LIKE', '%' . $descricao . '%')->first();

        if ($opcoes) {
            return $opcoes;
        }else{
            return false;
        }
    }

    public static function retornaPerguntaPorDescricao($descricao)
    {
        $pergunta = Pergunta::where('descricao_pergunta', '=', $descricao)->first();

        if ($pergunta) {
            return $pergunta;
        }else{
            return false;
        }
    }
}
