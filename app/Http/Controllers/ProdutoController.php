<?php namespace estoque\Http\Controllers;

use Illuminate\Support\Facades\DB;
use estoque\Produto;
use Request;
use estoque\Http\Requests\ProdutosRequest;

class ProdutoController extends Controller {

	public function lista(){

		$produtos = Produto::all();

		return view('produto.listagem')->with('produtos', $produtos);
	}
	
	public function mostra($id){
	
		$produto = Produto::find($id);
		if (empty($produto)) {
			return "Esse produto não existe";
		}
		return view('produto.detalhes')->with('p', $produto);
	}
	
	public function edita($id){
		$produto = Produto::find($id);
		if (empty($produto)) {
			return "Esse produto não existe";
		}
		return view('produto.edicao')->with('p', $produto);
	}
	
	public function novo(){
		return view('produto.formulario');
	}
	
	public function adiciona(ProdutosRequest $request){
	
		Produto::create($request->all());
		
		return redirect()
		->action('ProdutoController@lista')
		->withInput(Request::only('nome'));
	}
	
	public function atualiza(){
	
		$produto = Produto::find(Request::input('id'));
		$produto->nome = Request::input('nome');
		$produto->valor = Request::input('valor');
		$produto->descricao = Request::input('descricao');
		$produto->quantidade = Request::input('quantidade');
		
		$produto->save();
		
		return redirect()
		->action('ProdutoController@lista');
	}
	
	public function listaJson(){
		$produtos = Produto::all();
		return response()->json($produtos);
	}
	
	public function remove($id){
		$produto = Produto::find($id);	
		$produto->delete();
		return redirect()->action('ProdutoController@lista');
	}
}
