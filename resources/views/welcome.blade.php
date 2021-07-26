<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .card-header {
                text-align: center;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .container {
                position: absolute;
                height: 800px;
                width: 1000px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12">
                        <br>
                        <div class="card">
                            <div class="card-header">
                                <h2 class="text-center">{{ __('QUESTIONÁRIO') }}</h2>
                            </div>
                            <br>
                            <form action="{{route('enviarRespostas')}}" method="POST" id="form-enviar-respostas">
                                @csrf
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="nome">Nome Completo *</label>
                                        <input class="form-control" id="nome" name="nome" required type="text">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">Idade *</label>
                                        <input class="form-control" id="idade" name="idade" required type="text">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">Sexo *</label>
                                        <select name="sexo" id="sexo" class="form-control" required>
                                            <option value="M">Masculino</option>
                                            <option value="F">Feminino</option>
                                        </select>
                                    </div>
                                </div>
                            {{-- <div class="col-md-12">
                                <label>Seu nome completo:</label>
                                <input type="text" class="form-control" name="nome_cliente">
                            </div> --}}
                                <hr>
                                <div class="card-body">
                                    @if(Session::has('mensagem_sucesso'))
                                        <div class="alert alert-success text-center">{{ Session::get('mensagem_sucesso') }}</div>
                                    @elseif(Session::has('erro'))
                                        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
                                    @endif
                                    <hr>
                                    @if($perguntas && count($perguntas))
                                        @php
                                        $soma = 0;
                                        @endphp
                                        @foreach($perguntas as $pergunta)
                                            @php
                                                $soma = $soma + 1;
                                            @endphp
                                            <h5>{{$soma}} ) - {{$pergunta->descricao_pergunta}} <small><b>({{number_format($pergunta->pontuacao, 2, ',', '.')}}) Pts</b></small></h5>
                                            <br>
                                            <div class="form-group row">
                                                @php
                                                $opcoesRespostas = App\Http\Controllers\QuestoesController::retornaOpcoesRespostaPorIdPergunta($pergunta->id);
                                                @endphp
                                                <input type="hidden" name="pergunta[]" value="{{$pergunta->id}}">
                                                @foreach($opcoesRespostas as $opcaoResposta)
                                                    <div class="col-md-12">
                                                        <input type="radio" name="opcao_resposta-{{$pergunta->id}}" id="opcao_resposta-{{$pergunta->id}}-{{$opcaoResposta->id}}" value="{{$opcaoResposta->id}}">
                                                        <label for="opcao_resposta-{{$pergunta->id}}-{{$opcaoResposta->id}}">{{$opcaoResposta->descricao_opcao}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr>
                                        @endforeach
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="col-md-12 btn btn-primary">
                                                {{ __('Enviar Respostas') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
