<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\MarcasRqt;

use App\Atividades;
use App\Marcas;
use App\Imagens;

class MarcasCtrl extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
    }
    
    // Lista marcas
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_marcas == 1 || Auth::user()->RelationGrupo->gerenciar_marcas == 1){
            $marcas = Marcas::all()->count();
            return view('marcas.lista')->with('marcas', $marcas);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
        return datatables()->of(Marcas::all())
                    ->editColumn('marca', function(Marcas $dados){ 
                        return '<a href="'.route('marcas.editar', $dados->id).'" class="text-decoration-none"><p class="nome">'.$dados->nome.'</p></a>';
                    })->editColumn('home', function(Marcas $dados){
                        return '<div class="badge badge-'.($dados->mostrar_na_home=='s' ? 'primary' : 'danger').'">'.($dados->mostrar_na_home=='s' ? 'Sim' : 'Não').'</div>';
                    })->editColumn('status', function(Marcas $dados){
                        return '<div class="text-'.($dados->ativo=='s' ? 'success' : 'danger').'"><i class="fas fa-circle"></i></div>';
                    })->rawColumns(['marca', 'home', 'status'])->make(true);
    }

    // Adicionando marca
    public function Adicionar(){
        if(Auth::user()->RelationGrupo->gerenciar_marcas == 1){
        	return view('marcas.adicionar');
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarAdicionar(MarcasRqt $request){
        $dados = $request->except(['_token', 'acao']);
        $imagens = (isset($dados['id_imagem_marca']) ? $dados['id_imagem_marca'] : null);

        if(!empty($imagens)){
            $nameFile = null;
            if ($request->hasFile('id_imagem_marca') && $request->file('id_imagem_marca')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension = $request->id_imagem_marca->extension();
                $nameFile = "{$name}.{$extension}";
                $upload = $request->id_imagem_marca->storeAs('marcas', $nameFile);
                $imagem = Imagens::create(['caminho' => $upload, 'tipo' => 'marcas']);
                $dados['id_imagem_marca'] = $imagem->id; 
            }      
        }
        else
            $dados['id_imagem_marca'] = null;

        $marcas = Marcas::create([
            'nome' => $dados['nome'],
            'ativo' => (isset($dados['ativo']) ? 's' : 'n'), 
            'mostrar_na_home' => (isset($dados['mostrar_na_home']) ? 's' : 'n'), 
            'descricao' => $dados['descricao'],
            'id_imagem' => $dados['id_imagem_marca'],                         
        ]);

        Atividades::create([
            'nome' => 'Inserção de nova marca',
            'descricao' => 'Você cadastrou uma nova marca, '.$dados['nome'].".",
            'icone' => 'mdi-plus-thick',
            'url' => route('marcas.editar', $marcas->id),
            'id_usuario' => Auth::id()
        ]);

        if($request->acao == "modal"){
            return $marcas;
        }else{
            return redirect(route('marcas.lista'));
        }
    }

    // Editando marca
    public function Editar($id){
        if(Auth::user()->RelationGrupo->gerenciar_marcas == 1){
            $marca = Marcas::find($id);
            return view('marcas.editar')->with('marca', $marca);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarEditar(Request $request, $id){
        $dados = $request->except('_token');
        $imagens = (isset($dados['id_imagem_marca']) ? $dados['id_imagem_marca'] : null);

        if(!empty($imagens)){
            $nameFile = null;
            if ($request->hasFile('id_imagem_marca') && $request->file('id_imagem_marca')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension = $request->id_imagem_marca->extension();
                $nameFile = "{$name}.{$extension}";
                $upload = $request->id_imagem_marca->storeAs('marcas', $nameFile);
                $imagem = Imagens::create(['caminho' => $upload, 'tipo' => 'marcas']);
                $dados['id_imagem_marca'] = $imagem->id;       
            } 
        }else
            $dados['id_imagem_marca'] = null;

        Marcas::where('id', $id)->update([
                            'nome' => $dados['nome'],
                            'ativo' => (isset($dados['ativo']) ? 's' : 'n'), 
                            'mostrar_na_home' => (isset($dados['mostrar_na_home']) ? 's' : 'n'), 
                            'descricao' => $dados['descricao'],
                            'id_imagem' => $dados['id_imagem_marca'],                         
                        ]);

        Atividades::create([
            'nome' => 'Edição de uma marca',
            'descricao' => 'Você alterou algumas informações da marca '.$dados['nome'].".",
            'icone' => 'mdi-pencil-outline',
            'url' => route('marcas.editar', $id),
            'id_usuario' => Auth::id()
        ]);
        
        return redirect(route('marcas.lista'));
    }
}