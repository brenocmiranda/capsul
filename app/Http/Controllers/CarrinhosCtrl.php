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
                        return '<div class="row mx-auto py-2"><div class="my-auto mx-3"><img src="'.url("storage/app/".$dados->RelationProduto->RelationImagensPrincipal->first()['caminho']).'" alt="Imagem do produto" style="height: auto; width: 60px;"></div><a href="javascript:void(0)" id="detalhes" class="text-decoration-none"><div class="text-left col"><p class="my-auto nome">'.$dados->RelationProduto->nome.'</p></div></a></div>';
                    })->editColumn('cliente', function(Pedidos $dados){
                        return '<p class="text-capitalize text-left font-weight-bolder mb-0">'.($dados->id_cliente != null ? strtolower($dados->RelationCliente->nome) : "<b>-</b>").'</p>';
                    })->editColumn('data', function(Pedidos $dados){
                        return '<div class="text-left">'.date_format($dados->created_at, "d/m/Y H:i:s").'</div><div class="text-left font-weight-bold">'.$dados->created_at->subMinutes(2)->diffForHumans().'</div>';
                    })->editColumn('valor', function(Pedidos $dados){
                        return 'R$ '.number_format($dados->valor_compra, 2, ',', '.');
                    })->editColumn('telefone', function(Pedidos $dados){
                        return ($dados->id_cliente != null ? $dados->RelationTelefones->numero : "<b>--</b>");
                    })->rawColumns(['produto', 'cliente','data','valor','telefone'])->make(true);
    }
}
