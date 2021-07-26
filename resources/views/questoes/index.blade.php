@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}
                    <a style="margin-left: 875px;" href="{{route('questoes.form')}}">Nova Questão</a>
                </div>
                <div class="card-body">
                    @if(Session::has('mensagem_sucesso'))
                        <div class="alert alert-success text-center">{{ Session::get('mensagem_sucesso') }}</div>
                    @elseif(Session::has('erro'))
                        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
                    @endif
                    <hr>
                    <div>
                        <form action="{{route('questoes.buscar')}}" method="GET" id="form-buscar-perguntas">
                            @csrf
                            <div class="row col-md-12">
                                <div class="form-group col-md-3">
                                    <label for="nome">Pergunta:</label>
                                    <input class="form-control" id="nome_pergunta" name="nome_pergunta" value="{{isset($request->nome_pergunta) ? $request->nome_pergunta : ''}}" type="text">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="email">Qtd Respostas:</label>
                                    <input class="form-control" id="qtd_respostas" name="qtd_respostas" value="{{isset($request->qtd_respostas) ? $request->qtd_respostas : ''}}" type="text">
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 31px;">
                                    <label for="email"> </label>
                                    <button type="submit" class="btn btn-primary">&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp &nbsp Buscar &nbsp &nbsp&nbsp&nbsp &nbsp&nbsp&nbsp<i class="fa fa-search"></i></button>
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 31px;  margin-left: -48px;">
                                    <label for="email"> </label>
                                    <a href="{{route('questoes.index')}}" class="btn btn-danger">&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp &nbsp Limpar &nbsp &nbsp&nbsp&nbsp <i class="fa fa-eraser"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ __('Id') }}</th>
                                <th>{{ __('Pergunta') }}</th>
                                <th>{{ __('Data de Criação') }}</th>
                                <th class="text-center">{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($perguntas && count($perguntas))
                            @foreach($perguntas as $pergunta)
                                <tr>
                                    <td>{{ $pergunta->id }}</td>
                                    <td>{{ $pergunta->descricao_pergunta }}</td>
                                    <td>{{ $pergunta->created_at }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('questoes/editar') }}/{{ $pergunta->id }}" class="btn btn-sm" title="{{ __('Editar')}} {{$pergunta->id}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ url('questoes/excluir') }}/{{ $pergunta->id }}" class="btn btn-sm" title="{{ __('Excluir')}} {{$pergunta->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Nenhuma pergunta cadastrada.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



















