<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use App\Atividades;
use App\Clientes;
use App\Grupos;
use App\Leads;
use App\Telefones;
use App\Enderecos;
use App\Pedidos;

class ClientesCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
	
	// Lista clientes
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_clientes == 1 || Auth::user()->RelationGrupo->gerenciar_clientes == 1){
            $clientes = Clientes::all()->count();
            return view('clientes.lista')->with('clientes', $clientes);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
         return datatables()->of(Clientes::all())
                    ->editColumn('cliente', function(Clientes $dados){ 
                        return '<div class="text-center"><a href="'.route('clientes.editar', $dados->id).'" class="text-decoration-none"><p class="nome">'.strtoupper($dados->nome).'</p></a></div>';
                    })->editColumn('data', function(Clientes $dados){
                        return '<div><p class="my-0">'.date_format($dados->created_at, "d/m/Y H:i:s").'</p></div>';
                    })->rawColumns(['cliente', 'data'])->make(true);
    }

    // Adicionando clientes
    public function Adicionar(){
        if(Auth::user()->RelationGrupo->gerenciar_clientes == 1){
            $grupos = Grupos::all();
            return view('clientes.adicionar')->with('grupos', $grupos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarAdicionar(Request $request){
        $lead = Leads::create([
            'nome' => $request->nome, 
            'email' => $request->email
        ]);

        $clientes = Clientes::create([
            'tipo' => $request->tipo, 
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'nome' => $request->nome, 
            'email' => $request->email, 
            'documento' => preg_replace('/[^0-9]/', '', $request->documento), 
            'data_nascimento' => (isset($request->data_nascimento) ? $request->data_nascimento : null), 
            'observacoes' => (isset($request->observacoes) ? $request->observacoes : null), 
            'senha' => (isset($request->senha) ? Hash::make($request->senha) : null), 
            'id_grupo_cliente' => (isset($request->id_grupo_cliente) ? $request->id_grupo_cliente : null), 
            'id_lead' => $lead->id
        ]);

        $telefone = Telefones::create([
            'id_cliente' => $clientes->id, 
            'numero' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $request->telefone)))
        ]);

        if(isset($request->cep)){
            foreach($request->cep as $key => $enderecos){
                // Inserindo o clientes
                $enderecos = Enderecos::create([
                    'nome' => $request->nomeEndereco[$key],
                    'status' => ($key == 0 ? 1 : 0),
                    'destinatario' => $request->destinatario[$key],
                    'cep' => $request->cep[$key],
                    'endereco' => $request->endereco[$key],
                    'numero' => $request->numero[$key],
                    'complemento' => (isset($request->complemento[$key]) ? $request->complemento[$key] : null),
                    'referencia' => (isset($request->referencia[$key]) ? $request->referencia[$key] : null),
                    'bairro' => (isset($request->bairro[$key]) ? $request->bairro[$key] : $request->bairro1[$key]),
                    'cidade' => (isset($request->cidade[$key]) ? $request->cidade[$key] : $request->cidade1[$key]),
                    'estado' => (isset($request->estado[$key]) ? $request->estado[$key] : $request->estado1[$key]),
                    'id_cliente' => $clientes->id
                ]); 
            }
        }

        Atividades::create([
            'nome' => 'Inserção de novo cliente',
            'descricao' => 'Você cadastrou um novo cliente, '.$dados['nome'].".",
            'icone' => 'mdi-plus-thick',
            'url' => route('clientes.editar', $clientes->id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('clientes.lista'));
    }

    // Editando clientes
    public function Editar($id){
        if(Auth::user()->RelationGrupo->gerenciar_clientes == 1){
            $grupos = Grupos::all();
            $cliente = Clientes::find($id);
            $enderecos = Enderecos::where('id_cliente', $id)->where('status', 1)->get();
            $pedidos = Pedidos::where('id_cliente', $id)->WhereNotNull('transacao_pagarme')->get();
            $carrinhos = Pedidos::where('id_cliente', $id)->WhereNull('transacao_pagarme')->get();
            return view('clientes.editar')->with('cliente', $cliente)->with('grupos', $grupos)->with('pedidos', $pedidos)->with('carrinhos', $carrinhos)->with('enderecos', $enderecos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarEditar(Request $request, $id){
        $cliente = Clientes::where('id', $id)->first();

        $lead = Leads::where('id', $cliente->id_lead)->update([
            'nome' => $request->nome, 
            'email' => $request->email
        ]);

        $clientes = Clientes::where('id', $id)->update([
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'nome' => $request->nome, 
            'email' => $request->email, 
            'documento' => preg_replace('/[^0-9]/', '', $request->documento), 
            'data_nascimento' => (isset($request->data_nascimento) ? $request->data_nascimento : null), 
            'observacoes' => (isset($request->observacoes) ? $request->observacoes : null), 
            'senha' => (isset($request->senha) ? Hash::make($request->senha) : null), 
            'id_grupo_cliente' => (isset($request->id_grupo_cliente) ? $request->id_grupo_cliente : null)
        ]);

        $telefone = Telefones::where('id_cliente', $id)->update([
            'numero' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $request->telefone)))
        ]);

        Enderecos::where('id_cliente', $id)->update(['status' => 0]);
        if(isset($request->cep)){
            foreach($request->cep as $key => $enderecos){
                if($request->id_endereco[$key]){
                    Enderecos::find($request->id_endereco[$key])->update([
                        'nome' => $request->nomeEndereco[$key],
                        'status' => 1,
                        'destinatario' => $request->destinatario[$key],
                        'cep' => $request->cep[$key],
                        'endereco' => $request->endereco[$key],
                        'numero' => $request->numero[$key],
                        'complemento' => (isset($request->complemento[$key]) ? $request->complemento[$key] : null),
                        'referencia' => (isset($request->referencia[$key]) ? $request->referencia[$key] : null),
                        'bairro' => (isset($request->bairro[$key]) ? $request->bairro[$key] : $request->bairro1[$key]),
                        'cidade' => (isset($request->cidade[$key]) ? $request->cidade[$key] : $request->cidade1[$key]),
                        'estado' => (isset($request->estado[$key]) ? $request->estado[$key] : $request->estado1[$key]),
                        'id_cliente' => $id
                    ]); 
                }else{
                    Enderecos::create([
                        'nome' => $request->nomeEndereco[$key],
                        'status' => 1,
                        'destinatario' => $request->destinatario[$key],
                        'cep' => $request->cep[$key],
                        'endereco' => $request->endereco[$key],
                        'numero' => $request->numero[$key],
                        'complemento' => (isset($request->complemento[$key]) ? $request->complemento[$key] : null),
                        'referencia' => (isset($request->referencia[$key]) ? $request->referencia[$key] : null),
                        'bairro' => (isset($request->bairro[$key]) ? $request->bairro[$key] : $request->bairro1[$key]),
                        'cidade' => (isset($request->cidade[$key]) ? $request->cidade[$key] : $request->cidade1[$key]),
                        'estado' => (isset($request->estado[$key]) ? $request->estado[$key] : $request->estado1[$key]),
                        'id_cliente' => $id
                    ]); 
                    
                }
            }
        }

        Atividades::create([
            'nome' => 'Edição de um cliente',
            'descricao' => 'Você alterou algumas informações do cliente '.$clientes['nome'].".",
            'icone' => 'mdi-pencil-outline',
            'url' => route('clientes.editar', $id),
            'id_usuario' => Auth::id()
        ]);
        
        return redirect(route('clientes.lista'));
    }

}
