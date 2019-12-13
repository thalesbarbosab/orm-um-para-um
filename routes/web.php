<?php

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
use \App\Cliente;
use \App\Endereco;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clientes', function(){
    $clientes = Cliente::all();
    foreach($clientes as $c){
        echo "<p>" . $c->id | $c->nome | $c->telefone . "</p> ";
        echo "Rua: <p>" . $c->endereco->rua . "</p>";
        echo "Numero: <p> " . $c->endereco->numero . "</p>";
        echo "Bairro: <p> " . $c->endereco->bairro . "</p>";
        echo "Cidade: <p> " . $c->endereco->cidade . "</p>";
        echo "UF: <p>" . $c->endereco->uf . "</p>";
    }
});

Route::get('/enderecos', function(){
    $enderecos = Endereco::all();
    foreach($enderecos as $e){
        echo "Cliente: <p>" . $e->cliente->nome . "</p>";
        echo "Telefone: <p>" . $e->cliente->telefone . "</p>";
        echo "Rua: <p>$e->rua</p>";
        echo "Numero: <p>$e->numero</p>";
        echo "Bairro: <p>$e->bairro</p>";
        echo "Cidade: <p>$e->cidade</p>";
        echo "UF: <p>$e->uf</p>";
    }
});

Route::get('/inserir', function(){
    $cl = new Cliente();
    $cl->nome = 'Thales';
    $cl->telefone = '11 12255232';
    $cl->save();

    $en = new Endereco();
    $en->rua = 'Rua dos palmitos';
    $en->numero = 15;
    $en->bairro = 'Cidade grande';
    $en->cidade = 'Limoes';
    $en->uf = 'SP';

    $cl->endereco()->save($en);

});

Route::get('/clientes/json', function(){
    //$clientes = Cliente::all();
    $clientes = Cliente::with(['endereco'])->get();
    return json_encode($clientes);
});

Route::get('/enderecos/json', function(){
    //laze loading - carregamento lento
    //$enderecos = endereco::all();
    //eager loading - carregamento rapido
    $enderecos = endereco::with(['cliente'])->get();
    return json_encode($enderecos);
});
