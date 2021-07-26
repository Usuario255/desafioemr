<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'IndexController@index')->name('welcome');

Route::get('/questoes', 'QuestoesController@index')->name('questoes.index');
Route::get('/questoes/form', 'QuestoesController@form')->name('questoes.form');
Route::post('/questoes/salvar', 'QuestoesController@salvar')->name('questoes.salvar');
Route::get('/questoes/editar/{questao}', 'QuestoesController@editar')->name('questoes.editar');
Route::post('/questoes/atualizar/{questao}', 'QuestoesController@atualizar')->name('questoes.atualizar');
Route::get('/questoes/excluir/{questao}', 'QuestoesController@excluir')->name('questoes.excluir');
Route::get('/questoes/buscar', 'QuestoesController@buscar')->name('questoes.buscar');

Route::get('/usuarios/index', 'UserController@index')->name('user.index');
Route::get('/questoes-respondidas/index', 'PerguntasRespondidasController@index')->name('perguntas.respondidas');

Route::post('/enviarRespostas', 'IndexController@enviarRespostas')->name('enviarRespostas');
