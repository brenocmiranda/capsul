<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriasRqt;

use App\Atividades;
use App\Categorias;
use App\CategoriasPai;
use App\Imagens;

class CategoriasCtrl extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
    }
    
    // Lista categorias
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_categorias == 1 || Auth::user()->RelationGrupo->gerenciar_categorias == 1){
            $categorias = Categorias::all()->count();
            return view('categorias.lista')->with('categorias', $categorias);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
        return datatables()->of(Categorias::all())
                    ->editColumn('categoria', function(Categorias $dados){ 
                        return '<a href="'.route('categorias.editar', $dados->id).'" class="text-decoration-none"><p class="nome">'.$dados->nome.'</p></a>';
                    })
                    ->editColumn('home', function(Categorias $dados){
                        return '<div class="badge badge-'.($dados->mostrar_na_home=='s' ? 'primary' : 'danger').'">'.($dados->mostrar_na_home=='s' ? 'Sim' : 'Não').'</div>';
                    })
                    ->editColumn('status', function(Categorias $dados){ 
                        return '<div class="text-'.($dados->ativo=='s' ? 'success' : 'danger').'"><i class="fas fa-circle"></i></div>';
                    })->rawColumns(['categoria', 'home', 'status'])->make(true);
    }
    
    // Adicionando categorias
    public function Adicionar(){
        if(Auth::user()->RelationGrupo->gerenciar_categorias == 1){
    		$categorias = Categorias::all();
        	return view('categorias.adicionar')->with('categorias', $categorias);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarAdicionar(CategoriasRqt $request){
        $dados = $request->except(['_token', 'acao']);
        $imagens = (isset($dados['id_imagem_categoria']) ? $dados['id_imagem_categoria'] : null);

        if(!empty($imagens)){
            $nameFile = null;
            if ($request->hasFile('id_imagem_categoria') && $request->file('id_imagem_categoria')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension = $request->id_imagem_categoria->extension();
                $nameFile = "{$name}.{$extension}";
                $upload = $request->id_imagem_categoria->storeAs('categorias', $nameFile);
                $imagem = Imagens::create(['caminho' => $upload, 'tipo' => 'categorias']);
                $dados['id_imagem_categoria'] = $imagem->id; 
            }          
        }else
            $dados['id_imagem_categoria'] = null;

        $categoria = Categorias::create([  
            'nome' => $dados['nome'],
            'ativo' => (isset($dados['ativo']) ? 's' : 'n'), 
            'mostrar_na_home' => (isset($dados['mostrar_na_home']) ? 's' : 'n'), 
            'sub_categoria' => (isset($dados['sub_categoria']) ? 's' : 'n'), 
            'ordenar_produtos' => $dados['ordenar_produtos'],
            'descricao' => $dados['descricao'],
            'id_imagem' => $dados['id_imagem_categoria'],  
            'titulo_pagina' => $dados['titulo_pagina'],
            'link_pagina' => $dados['link_pagina'],
            'descricao_pagina' => $dados['link_pagina'],
            'url_cronica' => $dados['url_cronica'], 
        ]);

        if(isset($dados['sub_categoria'])){
           CategoriasPai::create(['id_categoria' => $categoria->id, 'id_categoria_pai' => $dados['sub_categoria']]);
        }

        Atividades::create([
            'nome' => 'Inserção de nova categoria',
            'descricao' => 'Você cadastrou uma nova categoria, '.$dados['nome'].".",
            'icone' => 'mdi-plus-thick',
            'url' => route('categorias.editar', $categoria->id),
            'id_usuario' => Auth::id()
        ]);

        if($request->acao == "modal"){
            return $categoria;
        }else{
            return redirect(route('categorias.lista'));
        }	 
    }

    // Editando categorias
    public function Editar($id){
        if(Auth::user()->RelationGrupo->gerenciar_categorias == 1){
            $categoria = Categorias::find($id);
            $categoriapai = CategoriasPai::where('id_categoria', $id)->first();
            $allcategorias = Categorias::where('ativo', 's')->where('id', '!=', $id)->get();
            return view('categorias.editar')->with('categoria', $categoria)->with('allcategorias', $allcategorias)->with('categoriapai', $categoriapai);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarEditar(Request $request, $id){
        $dados = $request->except('_token');
        $imagens = (isset($dados['id_imagem_categoria']) ? $dados['id_imagem_categoria'] : null);

        if(!empty($imagens)){
            $nameFile = null;
            if ($request->hasFile('id_imagem_categoria') && $request->file('id_imagem_categoria')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension = $request->id_imagem_categoria->extension();
                $nameFile = "{$name}.{$extension}";
                $upload = $request->id_imagem_categoria->storeAs('categorias', $nameFile);
                $imagem = Imagens::create(['caminho' => $upload, 'tipo' => 'categorias']);
                $dados['id_imagem_categoria'] = $imagem->id;   
            }   
        }else
            $dados['id_imagem_categoria'] = null;

        Categorias::where('id', $id)->update([
                            'nome' => $dados['nome'],
                            'ativo' => (isset($dados['ativo']) ? 's' : 'n'), 
                            'mostrar_na_home' => (isset($dados['mostrar_na_home']) ? 's' : 'n'), 
                            'sub_categoria' => ($dados['sub_categoria'] != 0 ? 's' : 'n'), 
                            'ordenar_produtos' => $dados['ordenar_produtos'],
                            'descricao' => $dados['descricao'],
                            'id_imagem' => $dados['id_imagem_categoria'],  
                            'titulo_pagina' => $dados['titulo_pagina'],
                            'link_pagina' => $dados['link_pagina'],
                            'descricao_pagina' => $dados['link_pagina'],
                            'url_cronica' => $dados['url_cronica'],                        
                        ]);

        if($dados['sub_categoria'] != 0){
            if(CategoriasPai::where('id_categoria', $id)->first()){
                CategoriasPai::where('id_categoria', $id)->update(['id_categoria_pai' => $dados['sub_categoria']]);
            }else{
                CategoriasPai::create(['id_categoria' => $id, 'id_categoria_pai' => $dados['sub_categoria']]);
            }
        }
        
        Atividades::create([
            'nome' => 'Edição de uma categoria',
            'descricao' => 'Você alterou algumas informações da categoria '.$dados['nome'].".",
            'icone' => 'mdi-pencil-outline',
            'url' => route('categorias.editar', $id),
            'id_usuario' => Auth::id()
        ]);
        
        return redirect(route('categorias.lista'));
    }

    // Detalhes da categoria
    public function Detalhes($id){
        $categoria = Categorias::find($id);
        return response()->json($categoria);
    }
}