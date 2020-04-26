<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\VariacoesRqt;
use App\Http\Requests\VariacoesOpcoesRqt;

use App\Atividades;
use App\Variacoes;
use App\Imagens;
use App\VariacoesOpcoes;

class VariacoesCtrl extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
    }
        
    // Lista variação
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_variacoes == 1 || Auth::user()->RelationGrupo->gerenciar_variacoes == 1){
            $variacoes = Variacoes::all()->count();
            return view('variacoes.lista')->with('variacoes', $variacoes);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
        return datatables()->of(Variacoes::all())
                    ->editColumn('variacao', function(Variacoes $dados){ 
                        return '<a href="'.route('variacoes.editar', $dados->id).'" class="text-decoration-none"><p class="nome">'.$dados->nome.'</p></a>';
                    })->rawColumns(['variacao'])->make(true);
    }
    
    // Adicionando variação
    public function Adicionar(){
        if(Auth::user()->RelationGrupo->gerenciar_variacoes == 1){
            $opcoes = VariacoesOpcoes::All();
        	return view('variacoes.adicionar')->with('opcoes', $opcoes);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarAdicionar(VariacoesRqt $request){
        $dados = $request->except('_token');
        $variacao = Variacoes::create([
                        'nome' => $dados['nome'], 
                        'id_opcao' => $dados['id_opcao'], 
                        'valor' => $dados['valor']
                    ]);

        Atividades::create([
            'nome' => 'Inserção de nova variação',
            'descricao' => 'Você cadastrou uma nova variação, '.$request->nome.".",
            'icone' => 'mdi-plus-thick',
            'url' => route('variacoes.editar', $variacao->id),
            'id_usuario' => Auth::id()
        ]);

        if($request->acao == "modal"){
            return $variacao;
        }else{
            return redirect(route('variacoes.lista'));
        }
         
    }

    // Editando variação
    public function Editar($id){
        if(Auth::user()->RelationGrupo->gerenciar_variacoes == 1){
            $variacao = Variacoes::find($id);
            $opcoes = VariacoesOpcoes::All();
            return view('variacoes.editar')->with('variacao', $variacao)->with('opcoes', $opcoes);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarEditar(Request $request, $id){
        $dados = $request->except('_token');
        Variacoes::where('id', $id)->update([
                                'nome' => $dados['nome'], 
                                'id_opcao' => $dados['id_opcao'], 
                                'valor' => $dados['valor']
                            ]);

        Atividades::create([
            'nome' => 'Edição de uma variação',
            'descricao' => 'Você alterou algumas informações da variação '.$request->nome.".",
            'icone' => 'mdi-pencil-outline',
            'url' => route('variacoes.editar', $id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('variacoes.lista'));
    }

    // Criando nova opcao
    public function SalvarOpcao(VariacoesOpcoesRqt $request){
        if(Auth::user()->RelationGrupo->gerenciar_variacoes == 1){
            $dados = $request->except('_token');
            VariacoesOpcoes::create(['nome' => $dados['nome']]);
            $variacoes = VariacoesOpcoes::all();

            Atividades::create([
                'nome' => 'Inserção de nova opção de variação',
                'descricao' => 'Você cadastrou uma nova opção de variação, '.$request->nome.".",
                'icone' => 'mdi-plus-thick',
                'url' => 'javascript:void(0)',
                'id_usuario' => Auth::id()
            ]);
            
            return $variacoes;
        }else{
            return redirect(route('permission'));
        }
    }

    // Detalhes da variação
    public function Detalhes($id){
        $variacao = Variacoes::find($id);
        return response()->json($variacao);
    }
}