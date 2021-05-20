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
            $clientes = Clientes::all();
            return view('system.dashboard')->with('pedidos', $pedidos)->with('clientes', $clientes);
        }else{
            return redirect()->route('login');
        }
    }
}