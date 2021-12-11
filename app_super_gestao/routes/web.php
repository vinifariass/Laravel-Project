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

Route::get('/', [\App\Http\Controllers\PrincipalController::class, 'principal'])->name('site.index');

Route::get('/sobre-nos', [\App\Http\Controllers\SobreNosController::class, 'sobreNos'])->name('site.sobrenos');

Route::get('/contato', [\App\Http\Controllers\ContatoController::class, 'contato'])->name('site.contato');
Route::post('/contato', [\App\Http\Controllers\ContatoController::class, 'contato'])->name('site.contato');

Route::prefix('app')->group(function () {

  Route::get('/clientes', function () {
    return 'Clientes';
  })->name('app.clientes');
  Route::get('/fornecedores',[\App\Http\Controllers\FornecedorController::class,'index'])->name('app.fornecedores');
  Route::get('/produtos', function () {
    return 'Produtos';
  })->name('app.produtos');
});

Route::get('/teste/{p1}/{p2}', [\App\Http\Controllers\TesteController::class, 'teste'])->name('site.teste');


// rota de contingencia para nao retornar o erro na rota

Route::fallback(function(){
  echo 'A rota acessada não existe. <a href="'.route('site.index').'">Clique aqui</a> para ir para a pagina inicial';
});
