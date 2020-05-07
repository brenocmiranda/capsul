<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ProdutosRqt;

use App\Atividades;
use App\Marcas;
use App\Imagens;
use App\Categorias;
use App\Variacoes;
use App\VariacoesOpcoes;
use App\Produtos;
use App\ProdutosImagens;
use App\ProdutosCategorias;
use App\ProdutosVariacoes;

class ProdutosCtrl extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    // Listando produtos
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_produtos == 1 || Auth::user()->RelationGrupo->gerenciar_produtos == 1){
            $produtos = Produtos::all()->count();
            return view('produtos.lista')->with('produtos', $produtos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
        return datatables()->of(Produtos::all())
                    ->editColumn('produto', function(Produtos $dados){ 
                        return '<div class="d-flex my-2"><div class="my-auto col"><img src="'. (isset($dados->RelationImagensPrincipal) ? asset('storage/app/'.$dados->RelationImagensPrincipal->first()->caminho) : asset('public/img/product.png')).'" alt="Imagem atual" style="height: 55px; width: 60px;" class="rounded" ></div><div class="col-9 text-left my-auto"><a href="'.route('produtos.editar', $dados->id).'" class="text-decoration-none"><p class="nome m-0 text-weight-bold">'.(strlen($dados->nome) <= 40 ? $dados->nome : substr($dados->nome, 0, 41)."...").'</p></a><label class="mb-0">'.$dados->cod_sku.'</label></div></div>';
                    })->editColumn('valor', function(Produtos $dados){
                        return 'R$ '. ($dados->preco_promocional != 0 ? '<del class="text-secondary">'.number_format($dados->preco_venda, 2, ',', '.').'</del><br> R$ '.number_format($dados->preco_promocional, 2, ',', '.')  : number_format($dados->preco_venda, 2, ',', '.'));
                    })->editColumn('link', function(Produtos $dados){
                        return '<a href="'.route('checkout.create', $dados->link_produto).'" target="_blank" class="action-link holder-tooltip" title="Checkout"><i class="fas fa-share-alt"></i></a>';
                    })->editColumn('status', function(Produtos $dados){
                        return '<div class="text-'.($dados->ativo=='s' ? 'success' : 'danger').'"><i class="fas fa-circle"></i></div>';
                    })->rawColumns(['produto', 'valor', 'link', 'status'])->make(true);
    }

    // Adicionando produto
    public function Adicionar(){
        if(Auth::user()->RelationGrupo->gerenciar_produtos == 1){
            $marcas = Marcas::where('ativo', 's')->get();
            $categorias = Categorias::where('ativo', 's')->get();
            $variacoes = Variacoes::all();
            $opcoes = VariacoesOpcoes::all();
        	return view('produtos.adicionar')->with('categorias', $categorias)->with('marcas', $marcas)->with('variacoes', $variacoes)->with('opcoes', $opcoes);
        }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarAdicionar(Request $request){
        $dados = $request->except('_token');

        $produto = Produtos::create([
            'ativo' => (isset($dados['ativo']) ? 's' : 'n'), 
            'variante' => ($dados['variante'] == 'true' ? 's' : 'n'), 
            'tipo' => $dados['tipo'],
            'nome' => $dados['nome'],
            'link_produto' => $dados['link_produto'],
            'id_marca' => $dados['id_marca'],
            'pixels_facebook' => $dados['pixels_facebook'],    
            'disponivel_venda' => (isset($dados['disponivel_venda']) ? 's' : 'n'), 
            'cod_sku' => $dados['cod_sku'],
            'cod_ean' => $dados['cod_ean'],
            'quantidade' => $dados['quantidade'],
            'quantidade_minima' => $dados['quantidade_minima'],
            'preco_custo' => (isset($dados['preco_custo']) ? str_replace(",", ".", str_replace(".", "",$dados['preco_custo'])) : 0),
            'preco_venda' => str_replace(",", ".", str_replace(".", "",$dados['preco_venda'])),
            'preco_promocional' =>  (isset($dados['preco_promocional']) ? str_replace(",", ".", str_replace(".", "",$dados['preco_promocional'])) : 0),
            'peso' => $dados['peso'],
            'largura' => $dados['largura'],
            'altura' => $dados['altura'],
            'comprimento' => $dados['comprimento'],
            'detalhes_produto' => $dados['detalhes_produto'],                    
        ]);

        // Cadastramento da imagem principal
        if(isset($request->imagem_principal)){
            $nameFile = null;
            if ($request->hasFile('imagem_principal') && $request->file('imagem_principal')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->imagem_principal->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->imagem_principal->storeAs('produtos', $nameFile);
            }
                    
            $imagem = Imagens::create(['caminho' => $upload, 'tipo' => 'produtos_principal']);
            $imagem_produto = ProdutosImagens::create([
                    'id_imagem' => $imagem->id, 
                    'id_produto' => $produto->id
                ]);
        }

        // Cadastramento de várias imagens do mesmo produto
        if ($request->imagens) {
            foreach($request->imagens as $img){
                $imagem_produto = ProdutosImagens::create([
                    'id_imagem' => $img, 
                    'id_produto' => $produto->id
                ]);
            }
        }

        // Cadastramento das categorias
        if($request->categorias){
            foreach($request->categorias as $categorias){                
                ProdutosCategorias::create([
                    'id_categoria' => $categorias, 
                    'id_produto' => $produto->id
                ]);
            }
        }

        // Cadastramento das variacões
        if($request->variacoes){
            foreach($request->variacoes as $variacoes){                
                ProdutosVariacoes::create([
                    'id_variacao' => $variacoes, 
                    'id_produto' => $produto->id
                ]);
            }
        }

        Atividades::create([
            'nome' => 'Inserção de novo produto',
            'descricao' => 'Você cadastrou uma novo produto, '.$dados['nome'].".",
            'icone' => 'mdi-plus-thick',
            'url' => route('produtos.editar', $produto->id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('produtos.lista'));
    }


    // Editando produto
    public function Editar($id){
        if(Auth::user()->RelationGrupo->gerenciar_produtos == 1){
    		$produto = Produtos::find($id);
            $marcas = Marcas::where('ativo', 's')->get();
            $opcoes = VariacoesOpcoes::all();
            // Retirando categorias que já estão relacionadas
            $categorias = Categorias::where('ativo', 's')->get();
            $categorias1 = ProdutosCategorias::where('id_produto', $id)->get();        
            foreach ($categorias as $key => $categoria) {
                foreach ($categorias1 as $key1 => $categoria1) {
                    if($categoria1->id_categoria == $categoria->id){
                        unset($categorias[$key]);
                    }
                }
            }
            // Retirando variações que já estão relacionadas
            $variacoes = Variacoes::all();
            $variacoes1 = ProdutosVariacoes::where('id_produto', $id)->get(); 
            foreach ($variacoes as $key => $variacao) {
                foreach ($variacoes1 as $key1 => $variacao1) {
                    if($variacao1->id_variacao == $variacao->id){
                        unset($variacoes[$key]);
                    }
                }
            } 
        	return view('produtos.editar')->with('produto', $produto)->with('categorias', $categorias)->with('marcas', $marcas)->with('variacoes', $variacoes)->with('opcoes', $opcoes);
         }else{
            return redirect(route('permission'));
        }
    }
    public function SalvarEditar(Request $request, $id){
        $dados = $request->except('_token');
        Produtos::where('id', $id)->update([
                            'ativo' => (isset($dados['ativo']) ? 's' : 'n'), 
                            'variante' => ($dados['variante'] == 'true' ? 's' : 'n'), 
                            'tipo' => $dados['tipo'],
                            'nome' => $dados['nome'],
                            'link_produto' => $dados['link_produto'],
                            'id_marca' => $dados['id_marca'],
                            'pixels_facebook' => $dados['pixels_facebook'],    
                            'disponivel_venda' => (isset($dados['disponivel_venda']) ? 's' : 'n'), 
                            'cod_sku' => $dados['cod_sku'],
                            'cod_ean' => $dados['cod_ean'],
                            'quantidade' => $dados['quantidade'],
                            'quantidade_minima' => $dados['quantidade_minima'],
                            'preco_custo' => str_replace(",", ".", str_replace(".", "",$dados['preco_custo'])),
                            'preco_venda' => str_replace(",", ".", str_replace(".", "",$dados['preco_venda'])),
                            'preco_promocional' => str_replace(",", ".", str_replace(".", "",$dados['preco_promocional'])),
                            'peso' => $dados['peso'],
                            'largura' => $dados['largura'],
                            'altura' => $dados['altura'],
                            'comprimento' => $dados['comprimento'],
                            'detalhes_produto' => $dados['detalhes_produto'],                    
                        ]);

         // Cadastramento da imagem principal
        if(isset($request->imagem_principal)){
            if($request->imagem_principal_id){
                $imagem = Imagens::find($request->imagem_principal_id);
                unlink(getcwd().'/storage/app/'.$imagem->caminho);
                ProdutosImagens::join('imagens', 'imagens.id', 'id_imagem')->where('id_produto', $id)->where('tipo', 'produtos_principal')->delete();
                Imagens::find($imagem->id)->delete(); 
            } 

            $nameFile = null;
            if ($request->hasFile('imagem_principal') && $request->file('imagem_principal')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->imagem_principal->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->imagem_principal->storeAs('produtos', $nameFile);
            } 

            $image = Imagens::create(['caminho' => $upload, 'tipo' => 'produtos_principal']);
            $imagem_produto = ProdutosImagens::create([
                    'id_imagem' => $image->id, 
                    'id_produto' => $id
                ]);
        }

        // Cadastramento de várias imagens do mesmo produto
        if ($request->imagens) {
            ProdutosImagens::join('imagens', 'imagens.id', 'id_imagem')->where('id_produto', $id)->where('tipo', '<>', 'produtos_principal')->delete();
            foreach($request->imagens as $img){
                $imagem_produto = ProdutosImagens::create([
                    'id_imagem' => $img, 
                    'id_produto' => $id
                ]);
            }
        }else{
            ProdutosImagens::join('imagens', 'imagens.id', 'id_imagem')->where('id_produto', $id)->where('tipo', '<>', 'produtos_principal')->delete();
        }

        // Cadastramento das categorias
        if($request->categorias){
            ProdutosCategorias::where('id_produto', $id)->delete();
            foreach($request->categorias as $categorias){                
                ProdutosCategorias::create([
                    'id_categoria' => $categorias, 
                    'id_produto' => $id
                ]);
            }
        }else{
            ProdutosCategorias::where('id_produto', $id)->delete();
        }

        // Cadastramento das variacões
        if($request->variacoes){
            ProdutosVariacoes::where('id_produto', $id)->delete();
            foreach($request->variacoes as $variacoes){                
                ProdutosVariacoes::create([
                    'id_variacao' => $variacoes, 
                    'id_produto' => $id
                ]);
            }
        }else{
            ProdutosVariacoes::where('id_produto', $id)->delete();
        }

        Atividades::create([
            'nome' => 'Edição de um produto',
            'descricao' => 'Você alterou algumas informações do produto '.$dados['nome'].".",
            'icone' => 'mdi-pencil-outline',
            'url' => route('produtos.editar', $id),
            'id_usuario' => Auth::id()
        ]);
        
        return redirect(route('produtos.lista'));
    }

    // Importando fotos do produtos
    public function Imagens(Request $request){
        // Cadastramento de várias imagens do mesmo produto
        if ($request->hasFile('imagens')) {
            foreach($request->file('imagens') as $imagem){
                if ($imagem->isValid()){
                    $name = uniqid(date('HisYmd'));
                    $extension =  $imagem->extension();
                    $nameFile = "{$name}.{$extension}";
                    $upload =  $imagem->storeAs('produtos', $nameFile);
                }
                
                $imagens[] = Imagens::create(['caminho' => $upload, 'tipo' => 'produtos']);
            }
        }
        return response()->json($imagens);
    }

    // Importando fotos do produtos
    public function RemoveImagens($id){
        $imagem = Imagens::find($id);
        unlink(getcwd().'/storage/app/'.$imagem->caminho);
        ProdutosImagens::where('id_imagem', $id)->delete();
        Imagens::where('id', $id)->delete();
        return response()->json(['success' => true]);
    }
}
