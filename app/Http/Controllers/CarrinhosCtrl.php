<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use App\Pedidos;

class CarrinhosCtrl extends Controller
{	
	public function __construct(){
        $this->middleware('auth');
    }

    //  Listar carrinhos abandonados
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_pedidos == 1 || Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            $carrinhos = Pedidos::WhereNull('transacao_pagarme')->count();
            return view('carrinhos.lista')->with('carrinhos', $carrinhos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
        return datatables()->of(Pedidos::WhereNull('transacao_pagarme')->get())
                    ->editColumn('produto', function(Pedidos $dados){ 
                        return '<div class="d-flex my-2"><div class="my-auto col"><img src="'. (isset($dados->RelationProduto->RelationImagensPrincipal) ? asset('storage/app/'.$dados->RelationProduto->RelationImagensPrincipal->first()->caminho) : asset('public/img/product.png')).'" alt="Imagem atual" style="height: 55px; width: 60px;" class="rounded" ></div><div class="col-9 text-left my-auto"><a href="javascript:void(0)" class="text-decoration-none" id="detalhes"><p class="nome m-0">'.(strlen($dados->RelationProduto->nome) <= 40 ? $dados->RelationProduto->nome : substr($dados->RelationProduto->nome, 0, 41)."...").'</p></a><label class="mb-0">'.$dados->RelationProduto->cod_sku.'</label></div></div>';
                    })->editColumn('cliente', function(Pedidos $dados){
                        return '<p class="text-capitalize text-left font-weight-bolder mb-0">'.($dados->id_cliente != null ? strtolower($dados->RelationCliente->nome) : "<b>-</b>").'</p>';
                    })->editColumn('data', function(Pedidos $dados){
                        return '<div class="text-left">'.date_format($dados->created_at, "d/m/Y H:i:s").'</div><div class="text-left font-weight-bold">'.$dados->created_at->subMinutes(2)->diffForHumans().'</div>';
                    })->editColumn('valor', function(Pedidos $dados){
                        return 'R$ '.number_format($dados->valor_compra, 2, ',', '.');
                    })->editColumn('telefone', function(Pedidos $dados){
                        return ($dados->id_cliente != null ? $dados->RelationTelefones->numero : "<b>--</b>");
                    })->editColumn('relation_produto', function(Pedidos $dados){
                        return $dados->RelationProduto;
                    })->editColumn('relation_cliente', function(Pedidos $dados){
                        return $dados->RelationCliente;
                    })->rawColumns(['produto', 'cliente','data','valor','telefone','relation_produto','relation_cliente'])->make(true);
    }
}
