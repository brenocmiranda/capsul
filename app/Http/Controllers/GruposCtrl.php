<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\GruposRqt;

use App\Atividades;
use App\Grupos;

class GruposCtrl extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
    }

    // Lista grupos
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_clientes == 1 || Auth::user()->RelationGrupo->gerenciar_clientes == 1){
            $grupos = Grupos::all()->count();
            return view('grupos.lista')->with('grupos', $grupos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
        return datatables()->of(Grupos::all())
                    ->editColumn('grupo', function(Grupos $dados){ 
                        return '<a href="'.route('grupos.editar', $dados->id).'" class=" text-decoration-none"><p class="nome">'.$dados->nome.'</p></a>';
                    })->editColumn('status', function(Grupos $dados){
                        return '<div class="text-'.($dados->ativo==1 ? 'success' : 'danger').'"><i class="fas fa-circle"></i></div>';
                    })->rawColumns(['grupo', 'status'])->make(true);
    }
    
    // Adicionando grupos
    public function Adicionar(){
        if(Auth::user()->RelationGrupo->gerenciar_clientes == 1){
    	   return view('grupos.adicionar');
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarAdicionar(Request $request){
        $grupos = Grupos::create([
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'pedido_minimo' =>  str_replace(",", ".", str_replace(".", "",$request->pedido_minimo)),
            'operacao' => $request->operacao,
            'porcentagem' => $request->porcentagem,
            'inserrir_novos_clientes' => (isset($request->operacao) ? 's' : 'n')
        ]);

        Atividades::create([
            'nome' => 'Inserção de novo grupo de clientes',
            'descricao' => 'Você cadastrou um novo grupo de clientes, '.$grupos['nome'].".",
            'icone' => 'mdi-plus-thick',
            'url' => route('grupos.editar', $grupos->id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('grupos.lista'));
    }

    // Editando grupos
    public function Editar(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_clientes == 1){
            $grupo = Grupos::find($id);
            return view('grupos.editar')->with('grupo', $grupo);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarEditar(Request $request, $id){
        $grupos = Grupos::where('id', $id)->update([
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'pedido_minimo' =>  str_replace(",", ".", str_replace(".", "",$request->pedido_minimo)),
            'operacao' => $request->operacao,
            'porcentagem' => $request->porcentagem,
            'inserrir_novos_clientes' => (isset($request->operacao) ? 's' : 'n')
        ]);

        Atividades::create([
            'nome' => 'Edição de um grupo de usuários',
            'descricao' => 'Você alterou algumas informações do grupo '.$grupos['nome'].".",
            'icone' => 'mdi-pencil-outline',
            'url' => route('grupos.editar', $id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('grupos.lista'));
    }
}