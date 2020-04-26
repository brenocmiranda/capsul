<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Atividades;
use App\Leads;

class LeadsCtrl extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}
	
	// Lista dos leads
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_leads == 1 || Auth::user()->RelationGrupo->gerenciar_leads == 1){
            $leads = Leads::all()->count();
            return view('leads.lista')->with('leads', $leads);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
         return datatables()->of(Leads::all())
                    ->editColumn('nome1', function(Leads $dados){ 
                        return '<a href="'.route('leads.editar', $dados->id).'" class="leads text-decoration-none"><p class="nome">'.$dados->nome.'</p></a>';
                    })->rawColumns(['nome1'])->make(true);
    }

    // Adicionando dos leads
    public function Adicionar(){
        if(Auth::user()->RelationGrupo->gerenciar_leads == 1){
           return view('leads.adicionar');
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarAdicionar(Request $request){
        $leads = Leads::create(['nome' => $request->nome, 'email' => $request->email]);

        Atividades::create([
            'nome' => 'Inserção de novo lead',
            'descricao' => 'Você cadastrou um novo lead, '.$leads['nome'].".",
            'icone' => 'mdi-plus-thick',
            'url' => route('leads.editar', $leads->id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('leads.lista'));
    }

    // Editando dos leads
    public function Editar(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_leads == 1){
            $leads = Leads::find($id);
            return view('leads.editar')->with('leads', $leads);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarEditar(Request $request, $id){
        $leads = Leads::where('id', $id)->update(['nome' => $request->nome, 'email' => $request->email]);

        Atividades::create([
            'nome' => 'Edição de um lead',
            'descricao' => 'Você alterou algumas informações do lead '.$leads['nome'].".",
            'icone' => 'mdi-pencil-outline',
            'url' => route('leads.editar', $id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('leads.lista'));
    }
}
