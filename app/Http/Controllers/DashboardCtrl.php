<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use App\Usuarios;
use App\Produtos;
use App\Pedidos;
use App\Clientes;
use App\Imagens;

class DashboardCtrl extends Controller
{	
	public function __construct(){
		$this->middleware('auth');
	}
	
    public function Lista(){
        if (Auth::check()){
            $pedidos = Pedidos::all();
            $pedidos_aguardando = Pedidos::all();
            $pedidos_aprovados = Pedidos::all();
            $pedidos_entregues = Pedidos::all();
            $pedidos_valor = Pedidos::whereNotNull('transacao_pagarme')->sum('valor_compra');
            $clientes = Clientes::all();

            return view('system.dashboard')->with('pedidos', $pedidos)->with('pedidos_aguardando', $pedidos_aguardando)->with('pedidos_aprovados', $pedidos_aprovados)->with('pedidos_entregues', $pedidos_entregues)->with('pedidos_valor', $pedidos_valor)->with('clientes', $clientes);
        }else{
            return redirect()->route('login');
        }
    }
}