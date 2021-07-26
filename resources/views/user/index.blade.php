@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Usuários Cadastrados') }}
                    <a style="margin-left: 875px;" href="{{route('register')}}">Novo Usuário</a>
                </div>
                <div class="card-body">
                    @if(Session::has('mensagem_sucesso'))
                        <div class="alert alert-success text-center">{{ Session::get('mensagem_sucesso') }}</div>
                    @elseif(Session::has('erro'))
                        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
                    @endif
                    <hr>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ __('Id') }}</th>
                                <th>{{ __('Nome') }}</th>
                                <th>{{ __('Data de Cadastro') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($users && count($users))
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Nenhum usuário cadastrada.</td>
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



















