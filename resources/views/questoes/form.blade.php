@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cadastrar Questões</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('questoes.salvar') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Pergunta:') }}</label>
                            <div class="col-md-6">
                                <input id="descricao_pergunta" type="text" class="form-control @error('descricao_pergunta') is-invalid @enderror" name="descricao_pergunta" value="{{old('descricao_pergunta') }}" required autocomplete="descricao_pergunta" autofocus>
                                @error('descricao_pergunta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Pontuação:') }}</label>
                            <div class="col-md-6">
                                <input type="text" name="pontuacao" class="form-control" id="pontuacao" value="{{old('pontuacao') }}">
                            </div>
                        </div>
                        <div data-identifier='group-cotent-add'>
                            <div data-identifier='group-form-selects'>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Resposta:') }}</label>
                                    <div class="col-md-6">
                                        <input type="radio" name="resposta" value="1" id="resposta">
                                        <label for="resposta"  id="opcao_resposta" data-soma="1">Resposta 1</label>
                                        <textarea class="form-control" name="descricao_opcao[]" id="descricao_opcao"></textarea>
                                    </div>
                                    <span class="mb-4 mb-sm-3 text-center button-add-rem">
                                        <a href="javascript:void(0)" data-identifier="remInput" class="" title="Remover Resposta">
                                            <i class="fa fa-minus-square"></i>
                                        </a>
                                        &nbsp&nbsp&nbsp
                                        <a href="javascript:void(0)" data-identifier="addInput" class="" title="Adicionar Resposta">
                                            <i class="fa fa-plus-square"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Salvar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var APP = {
    setup: function() {
        APP.Respostas.setup();
    },
    Respostas: {
        setup: function() {
            APP.Respostas.Opcoes();
        },
        Opcoes: function() {

            let boxContent = $("[data-identifier='group-cotent-add']");
            var soma = $('#opcao_resposta').attr('data-soma');
            var resposta = $('#resposta').val();

            $(document).on("click", "[data-identifier='addInput'],[data-identifier='remInput']", function(){
                let _this = $(this);

                boxDaddy = _this.closest("[data-identifier='group-form-selects']");

                if(_this.data('identifier') == 'addInput'){
                    soma = parseInt(soma) + 1;

                    // boxContent.append($('<div class="form-group row" data-identifier="group-form-selects">'+'<label for="name" class="col-md-4 col-form-label text-md-right">Resposta:</label> <div class="col-md-6"> <input type="radio" name="resposta" id="resposta" value="'+soma+'"> <label for="opcao_resposta" id="opcao_resposta" data-soma="'+soma+'">Resposta '+soma+'</label> <textarea class="form-control" name="descricao_opcao[]" id="descricao_opcao"></textarea> </div> <span class="mb-4 mb-sm-3 text-center button-add-rem"> <a href="javascript:void(0)" data-identifier="remInput" class="" title="Remover Resposta"> <i class="fa fa-minus-square"></i> </a> &nbsp;&nbsp;&nbsp; <a href="javascript:void(0)" data-identifier="addInput" class="" title="Adicionar Resposta"> <i class="fa fa-plus-square"></i> </a> </span>'+'</div>'));

                    boxContent.append($('<div data-identifier="group-form-selects"> <div class="form-group row"> <label for="name" class="col-md-4 col-form-label text-md-right">Resposta:</label> <div class="col-md-6"> <input type="radio" name="resposta" value="'+soma+'" id="resposta"> <label for="opcao_resposta"  id="opcao_resposta" data-soma="'+soma+'">Resposta '+soma+'</label> <textarea class="form-control" name="descricao_opcao[]" id="descricao_opcao"></textarea> </div> <span class="mb-4 mb-sm-3 text-center button-add-rem"> <a href="javascript:void(0)" data-identifier="remInput" class="" title="Remover Resposta"> <i class="fa fa-minus-square"></i> </a> &nbsp&nbsp&nbsp <a href="javascript:void(0)" data-identifier="addInput" class="" title="Adicionar Resposta"> <i class="fa fa-plus-square"></i> </a> </span> </div></div>'+'</div>'));

                    console.log(resposta);
                    // var obj = $(this)[0];
                    // if (!obj.hasPicker) {
                    //  var picker = new jscolor.color(obj, {});
                    //  obj.hasPicker = true;
                    //  picker.showPicker();
                    // }


                }else{
                    if(boxContent.children().length > 1) {
                        boxDaddy.remove();
                        soma = parseInt(soma) - 1;
                        resposta = $('#resposta').val(soma);
                        $('#opcao_resposta').text('Resposta '+ soma);
                    }
                }
            });



        }
    }
}
jQuery(document).ready(function($) {
    APP.setup();
});

</script>
@endsection
