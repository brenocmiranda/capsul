<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\Request;

use App\Atividades;
use App\ConfigCarrinhos;
use App\ConfigCheckout;
use App\ConfigEmails;
use App\ConfigGeral;
use App\ConfigIntegracoes;
use App\ConfigLogistica;
use App\ConfigSeguranca;
use App\Status;
use App\UsuariosGrupos;
use App\Usuarios;
use App\Imagens;
use Mail;

class ConfiguracoesCtrl extends Controller
{
    public function __construct(){
        $this->emails = ConfigEmails::first();
        $this->middleware('auth');
    }
    
    // Configurações
    public function Configuracoes(){
        return view('configuracoes.configuracoes');
    }

    // Carrinhos Abandonados
    public function Carrinhos(){
        if(Auth::user()->RelationGrupo->visualizar_checkout == 1 || Auth::user()->RelationGrupo->gerenciar_checkout == 1){
            $carrinhos = ConfigCarrinhos::first();
        	return view('configuracoes.carrinhos')->with('carrinhos', $carrinhos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function CarrinhosAtualizar(Request $request){
        $carrinhos = ConfigCarrinhos::find(1)->update([
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'enviar_cupom' => (isset($request->enviar_cupom) ? 's' : 'n'), 
            'assunto' => $request->assunto, 
            'sms' => $request->sms
        ]);

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você atualizou as configurações de carrinhos abandonados.',
            'icone' => 'mdi-cart-outline',
            'url' => route('configuracoes.carrinhos'),
            'id_usuario' => Auth::id()
        ]);

        \Session::flash('confirm', array(
                'class' => 'success',
                'mensagem' => 'Suas informações foram alteradas com sucesso.'
            ));
        return redirect()->route('configuracoes.carrinhos');
    }

    // Checkout
    public function Checkout(){
        if(Auth::user()->RelationGrupo->visualizar_checkout == 1 || Auth::user()->RelationGrupo->gerenciar_checkout == 1){
        	$checkout = ConfigCheckout::first();
            return view('configuracoes.checkout')->with('checkout', $checkout);
        }else{
            return redirect(route('permission'));
        }
    }
    public function CheckoutAtualizar(Request $request){
        $checkout = ConfigCheckout::find(1)->update([
            'api_key' => $request->api_key, 
            'api_criptografada' => $request->api_criptografada, 
            'text_topo_mostrar' => (isset($request->text_topo_mostrar) ? 1 : 0), 
            'prazo_entrega' => (isset($request->prazo_entrega) ? 1 : 0), 
            'cupom_desconto' => (isset($request->cupom_desconto) ? 1 : 0), 
            'data_nascimento' => (isset($request->data_nascimento) ? 1 : 0), 
            'data_previsao' => (isset($request->data_previsao) ? 1 : 0), 
            'maior_parcela' => (isset($request->maior_parcela) ? 1 : 0),
            'quantidade_itens' => (isset($request->quantidade_itens) ? 1 : 0), 
            'compras_pessoa' => $request->compras_pessoa,
            'pagamento_preferencial' => $request->pagamento_preferencial, 
            'pedidos_ip' => $request->pedidos_ip, 
            'tempo_cronometro' => $request->tempo_cronometro, 
            'texto_topo' => $request->texto_topo, 
            'texto_entrega' => $request->texto_entrega, 
            'texto_boleto' => $request->texto_boleto, 
            'desconto_boleto' => $request->desconto_boleto, 
            'desconto_cartao' => $request->desconto_cartao,            
            'url_boleto' => $request->url_boleto, 
            'url_cartao'=> $request->url_cartao
        ]);

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você atualizou as configurações de checkout.',
            'icone' => 'mdi-credit-card-settings-outline',
            'url' => route('configuracoes.checkout'),
            'id_usuario' => Auth::id()
        ]);

        \Session::flash('confirm', array(
                'class' => 'success',
                'mensagem' => 'Suas informações foram alteradas com sucesso.'
            ));
        return redirect()->route('configuracoes.checkout');
    }

   // E-mails transacionais
    public function Emails(){
        if(Auth::user()->RelationGrupo->visualizar_geral == 1 || Auth::user()->RelationGrupo->gerenciar_geral == 1){
            $emails = ConfigEmails::first();
            return view('configuracoes.emails')->with('emails', $emails);
        }else{
            return redirect(route('permission'));
        }
    }
    public function EmailsAtualizar(Request $request){
        $checkout = ConfigEmails::find(1)->update([
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'email_remetente' => $request->email_remetente, 
            'nome_remetente' => $request->nome_remetente, 
            'avaliar_produto' => $request->avaliar_produto
        ]);

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você atualizou as configurações de checkout.',
            'icone' => 'mdi-email-outline',
            'url' => route('configuracoes.emails'),
            'id_usuario' => Auth::id()
        ]);

        \Session::flash('confirm', array(
                'class' => 'success',
                'mensagem' => 'Suas informações foram alteradas com sucesso.'
            ));
        return redirect()->route('configuracoes.emails');
    }

    // Status
    public function Status(){
        if(Auth::user()->RelationGrupo->visualizar_geral == 1 || Auth::user()->RelationGrupo->gerenciar_geral == 1){
            $status = Status::all();
            return view('configuracoes.status')->with('status', $status);
        }else{
            return redirect(route('permission'));
        }
    }
    public function StatusListar(){
        return datatables()->of(Status::all())
                    ->editColumn('nome1', function(Status $dados){ 
                        return '<div class="mx-2 my-auto nome">'.$dados->nome.'</div>';
                    })->editColumn('status', function(Status $dados){ 
                        return ($dados->enviar == 1 ? '<div class="text-success"><i class="fas fa-circle"></i></div>' : '<div class="text-danger"><i class="fas fa-circle"></i></div>');
                    })->editColumn('acoes', function(Status $dados){ 
                        return '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar</a></div>'; 
                    })->rawColumns(['status', 'nome1', 'acoes'])->make(true);
    }
    public function StatusAtualizar(Request $request, $id){
        $dados = Status::find($id)->update([
            'enviar' => (isset($request->enviar) ? 1 : 0), 
            'nome' => $request->nome, 
            'descricao' => $request->descricao]);

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você atualizou as configurações do status '.$request->nome.'.',
            'icone' => 'mdi-state-machine',
            'url' => route('configuracoes.status'),
            'id_usuario' => Auth::id()
        ]);

        $dados = Status::where('id', $id)->first();
        $dados->nome1 = '<div class="mx-2 my-auto"><a href="javascript:void(0)" class="nome mx-3 my-auto" id="editar">'.$dados->nome.'</a></div>';
        $dados->status = ($dados->enviar == 1 ? '<div class="text-success"><i class="fas fa-circle"></i></div>' : '<div class="text-danger"><i class="fas fa-circle"></i></div>');
        $dados->acoes = '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar</a></div>';
        return response()->json($dados);
    }

    // Geral
    public function Geral(){
        if(Auth::user()->RelationGrupo->visualizar_geral == 1 || Auth::user()->RelationGrupo->gerenciar_geral == 1){
            $geral = ConfigGeral::first();
        	return view('configuracoes.geral')->with('geral', $geral);
        }else{
            return redirect(route('permission'));
        }
    }
    public function GeralAtualizar(Request $request){
        // Upload ícone
        $icone = $request->icone;
        if(!empty($icone)){
            if ($request->hasFile('icone') && $request->file('icone')->isValid()) {
                $nameFile = 'icon.png';
                $upload =  $request->icone->storeAs('system', $nameFile);
            }
        }
        // Upload logotipo
        $logotipo = $request->logotipo;
        if(!empty($logotipo)){
            if ($request->hasFile('logotipo') && $request->file('logotipo')->isValid()) {
                $nameFile = 'capsul.png';
                $upload =  $request->logotipo->storeAs('system', $nameFile);
            }
        }
        $checkout = ConfigGeral::find(1)->update([
            'email_pedidos' => $request->email_pedidos, 
            'nome_loja' => $request->nome_loja, 
            'descricao_loja' => $request->descricao_loja, 
            'cep' => str_replace("-", "", $request->cep),
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'complemento' => (isset($request->complemento) ? $request->complemento : null),
            'bairro' => (isset($request->bairro) ? $request->bairro : $request->bairro1),
            'cidade' => (isset($request->cidade) ? $request->cidade : $request->cidade1),
            'estado' => (isset($request->estado) ? $request->estado : $request->estado1),
            'razao_social' => $request->razao_social, 
            'cnpj' => $request->cnpj, 
            'email' => $request->email, 
            'telefone' => $request->telefone, 
            'whatsapp'=> $request->whatsapp
        ]);

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você atualizou as configurações de geral.',
            'icone' => 'mdi-home-edit-outline',
            'url' => route('configuracoes.geral'),
            'id_usuario' => Auth::id()
        ]);

        \Session::flash('confirm', array(
                'class' => 'success',
                'mensagem' => 'Suas informações foram alteradas com sucesso.'
            ));
        return redirect()->route('configuracoes.geral');
    }

    // Integrações
    public function Integracoes(){
        if(Auth::user()->RelationGrupo->visualizar_logistica == 1 || Auth::user()->RelationGrupo->gerenciar_logistica == 1){
    	   return view('configuracoes.integracoes');
        }else{
            return redirect(route('permission'));
        }
    }

    // Logistica
   	public function Logistica(){
        if(Auth::user()->RelationGrupo->visualizar_logistica == 1 || Auth::user()->RelationGrupo->gerenciar_logistica == 1){
    	   return view('configuracoes.logistica');
        }else{
            return redirect(route('permission'));
        }
    }
    public function LogisticaListar(){
        return datatables()->of(ConfigLogistica::orderBy('nome')->get())
                    ->editColumn('cep_inicial1', function(ConfigLogistica $dados){ 
                        return substr($dados->cep_inicial, 0, 5).'-'.substr($dados->cep_inicial, 5, 8);
                    })->editColumn('cep_final1', function(ConfigLogistica $dados){ 
                        return substr($dados->cep_final, 0, 5).'-'.substr($dados->cep_final, 5, 8);
                    })->editColumn('status', function(ConfigLogistica $dados){ 
                        return ($dados->ativo == 1 ? '<div class="text-success"><i class="fas fa-circle"></i></div>' : '<div class="text-danger"><i class="fas fa-circle"></i></div>');
                    })->editColumn('acoes', function(ConfigLogistica $dados){ 
                        return '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 
                    })->rawColumns(['status', 'acoes', 'cep_inicial1', 'cep_final1'])->make(true);
    }
    public function LogisticaAdicionar(Request $request){
        $dados = ConfigLogistica::create([
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'nome' => $request->nome, 
            'cep_inicial' => str_replace("-", "", $request->cep_inicial), 
            'cep_final' => str_replace("-", "", $request->cep_final), 
            'porcetagem_adicional' => $request->porcetagem_adicional, 
            'valor' => ($request->valor != null ? str_replace(",", ".", str_replace(".", "", $request->valor)) : '0'),
            'prazo_entrega' => $request->prazo_entrega
        ]);
        $dados->cep_inicial1 = substr($dados->cep_inicial, 0, 5).'-'.substr($dados->cep_inicial, 5, 8);
        $dados->cep_final1 = substr($dados->cep_final1, 0, 5).'-'.substr($dados->cep_final1, 5, 8);
        $dados->status = ($dados->ativo == 1 ? '<div class="text-success"><i class="fas fa-circle"></i></div>' : '<div class="text-danger"><i class="fas fa-circle"></i></div>');
        $dados->acoes = '<div class="mx-2 my-auto d-flex"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você adicionou um nova configuração de logística, '.$request->nome.'.',
            'icone' => 'mdi-truck-outline',
            'url' => route('configuracoes.logistica'),
            'id_usuario' => Auth::id()
        ]);

        return response()->json($dados);
    }
    public function LogisticaEditar(Request $request, $id){
        $dados = ConfigLogistica::find($id)->update([
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'nome' => $request->nome, 
            'cep_inicial' => str_replace("-", "", $request->cep_inicial), 
            'cep_final' => str_replace("-", "", $request->cep_final), 
            'porcetagem_adicional' => $request->porcetagem_adicional, 
            'valor' => ($request->valor != null ? str_replace(",", ".", str_replace(".", "", $request->valor)) : '0'),
            'prazo_entrega' => $request->prazo_entrega
        ]);
        $dados = ConfigLogistica::find($id)->first();
        $dados->cep_inicial1 = substr($dados->cep_inicial, 0, 5).'-'.substr($dados->cep_inicial, 5, 8);
        $dados->cep_final1 = substr($dados->cep_final1, 0, 5).'-'.substr($dados->cep_final1, 5, 8);
        $dados->status = ($dados->ativo == 1 ? '<div class="text-success"><i class="fas fa-circle"></i></div>' : '<div class="text-danger"><i class="fas fa-circle"></i></div>');
        $dados->acoes = '<div class="mx-2 my-auto d-flex"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>';

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você editou uma configuração de logística, '.$request->nome.'.',
            'icone' => 'mdi-truck-outline',
            'url' => route('configuracoes.logistica'),
            'id_usuario' => Auth::id()
        ]);

        return response()->json($dados); 
    }
    public function LogisticaExcluir($id){
        ConfigLogistica::find($id)->delete();

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você removeu uma configuração de logística.',
            'icone' => 'mdi-truck-outline',
            'url' => route('configuracoes.logistica'),
            'id_usuario' => Auth::id()
        ]);

        return response()->json(['success' => 'true']); 
    }

    // Segurança
    public function Seguranca(){
        if(Auth::user()->RelationGrupo->visualizar_usuarios == 1 || Auth::user()->RelationGrupo->gerenciar_usuarios == 1){
    	   return view('configuracoes.seguranca');
        }else{
            return redirect(route('permission'));
        }
    }
    public function SegurancaListar(){
        return datatables()->of(ConfigSeguranca::orderBy('nome')->get())
                    ->editColumn('acoes', function(ConfigSeguranca $dados){ 
                        return '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 
                    })->rawColumns(['acoes'])->make(true);
    }
    public function SegurancaAdicionar(Request $request){
        $dados = ConfigSeguranca::create([
            'nome' => $request->nome, 
            'ip_bloqueado' => $request->ip_bloqueado
        ]);
        $dados->acoes = '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você adicionou uma nova  configuração de segurança, '.$request->nome.'.',
            'icone' => 'mdi-lock-outline',
            'url' => route('configuracoes.seguranca'),
            'id_usuario' => Auth::id()
        ]);
        return response()->json($dados);
    }
    public function SegurancaEditar(Request $request, $id){
        $dados = ConfigSeguranca::find($id)->update([
            'nome' => $request->nome, 
            'ip_bloqueado' => $request->ip_bloqueado
        ]);

        $dados = ConfigSeguranca::find($id)->first();
        $dados->acoes = '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>';

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você editou uma configuração de segurança, '.$request->nome.'.',
            'icone' => 'mdi-lock-outline',
            'url' => route('configuracoes.seguranca'),
            'id_usuario' => Auth::id()
        ]);
        return response()->json($dados); 
    }
    public function SegurancaExcluir($id){
        ConfigSeguranca::find($id)->delete();

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você removeu uma configuração de segurança.',
            'icone' => 'mdi-lock-outline',
            'url' => route('configuracoes.seguranca'),
            'id_usuario' => Auth::id()
        ]);

        return response()->json(['success' => 'true']); 
    }
    

    // Usuários
    public function Usuarios(){
        if(Auth::user()->RelationGrupo->visualizar_usuarios == 1 || Auth::user()->RelationGrupo->gerenciar_usuarios == 1){
            $grupos = UsuariosGrupos::all();
            return view('configuracoes.usuarios')->with('grupos', $grupos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function UsuariosListar(){
        return datatables()->of(Usuarios::where('id', '!=', Auth::user()->id)->orderBy('nome')->get())
                    ->editColumn('status', function(Usuarios $dados){ 
                        return ($dados->ativo == 1 ? '<div class="text-success text-center"><i class="fas fa-circle"></i></div>' : '<div class="text-danger"><i class="fas fa-circle"></i></div>');
                    })->editColumn('acoes', function(Usuarios $dados){ 
                        return '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 
                    })->rawColumns(['status', 'acoes'])->make(true);
    }
    public function UsuariosAdicionar(Request $request){
        try {
            $usuario = Usuarios::create([
                'nome' => $request->nome, 
                'email' => $request->email,  
                'password' => Hash::make("capsul123"), 
                'ativo' => (isset($request->ativo) ? 1 : 0), 
                '_token' => $request['_token'], 
                'id_grupo' => $request->id_grupo
            ]);

            if(is_dir(getcwd().'/storage/app/usuarios')){
                $name = uniqid(date('HisYmd')).'.png';
                copy(getcwd().'/public/img/user.png', getcwd().'/storage/app/usuarios/'.$name);
                $caminho = 'usuarios/'.$name;
                $imagem = Imagens::create(['caminho' =>  $caminho, 'tipo' => 'usuarios']);
                Usuarios::find($usuario->id)->update(['id_imagem' => $imagem->id]);
            }else{
                mkdir(getcwd().'/storage/app/usuarios', 0755);
                $name = uniqid(date('HisYmd')).'.png';
                copy(getcwd().'/public/img/user.png', getcwd().'/storage/app/usuarios/'.$name);
                $caminho = 'usuarios/'.$name;
                $imagem = Imagens::create(['caminho' =>  $caminho, 'tipo' => 'usuarios']);
                Usuarios::find($usuario->id)->update(['id_imagem' => $imagem->id]);
            }  

            // Enviando e-mail de cadastro
            $dados = Usuarios::find($usuario->id);
            if(!empty($dados->email)){
                Mail::send('system.emails.cadastro', ['user' => $dados, 'emails' => $this->emails], function ($m) use ($dados) {
                    $m->from($this->emails->email_remetente, $this->emails->nome_remetente);
                    $m->to($dados->email, $dados->nome)->subject('Cadastro no '.$this->emails->nome_remetente);
                });               
            }else{
                 return false;
            }

            $dados->status = ($dados->ativo == 1 ? '<div class="text-success text-center"><i class="fas fa-circle"></i></div>' : '<div class="text-danger"><i class="fas fa-circle"></i></div>');
            $dados->acoes = '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 

            Atividades::create([
                'nome' => 'Atuailização de configurações',
                'descricao' => 'Você adicionou um novo usuário, '.$request->nome.'.',
                'icone' => 'mdi-account-cog-outline',
                'url' => route('configuracoes.usuarios'),
                'id_usuario' => Auth::id()
            ]);

            return response()->json($dados);      
        }catch (Exception $e) {
            $usuario = Usuarios::delete($usuario->id);
            $imagem = Imagens::delete($imagem->id);
            return false;
        }
    }
    public function UsuariosEditar(Request $request, $id){
        $dados = Usuarios::find($id)->update([
            'nome' => $request->nome, 
            'email' => $request->email, 
            'ativo' => (isset($request->ativo) ? 1 : 0), 
            'id_grupo' => $request->id_grupo
        ]);

        $dados = Usuarios::find($id)->first();
        $dados->status = ($dados->ativo == 1 ? '<div class="text-success text-center"><i class="fas fa-circle"></i></div>' : '<div class="text-danger"><i class="fas fa-circle"></i></div>');
        $dados->acoes = '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você editou as informações do usuário, '.$request->nome.'.',
            'icone' => 'mdi-account-cog-outline',
            'url' => route('configuracoes.usuarios'),
            'id_usuario' => Auth::id()
        ]);

        return response()->json($dados); 
    }
    public function UsuariosExcluir($id){
        Atividades::where('id_usuario', $id)->delete();
        Usuarios::find($id)->delete();

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você removeu um usuário.',
            'icone' => 'mdi-account-cog-outline',
            'url' => route('configuracoes.usuarios'),
            'id_usuario' => Auth::id()
        ]);

        return response()->json(['success' => 'true']); 
    }
    
    // Grupos de usuários
    public function Grupos(){
        if(Auth::user()->RelationGrupo->visualizar_usuarios == 1 || Auth::user()->RelationGrupo->gerenciar_usuarios == 1){
            return view('configuracoes.grupos');
        }else{
            return redirect(route('permission'));
        }
    }
    public function GruposListar(){
        return datatables()->of(UsuariosGrupos::orderBy('nome')->get())
                    ->editColumn('acoes', function(UsuariosGrupos $dados){ 
                        return '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 
                    })->rawColumns(['status', 'acoes'])->make(true);
    }
    public function GruposAdicionar(Request $request){
        if(isset($request->permissao_total)){
            $dados = UsuariosGrupos::create([
                'nome' => $request->nome, 
                'visualizar_produtos' => 1, 
                'visualizar_marcas' => 1, 
                'visualizar_categorias' => 1, 
                'visualizar_variacoes' => 1, 
                'visualizar_clientes' => 1, 
                'visualizar_pedidos' => 1, 
                'visualizar_leads' => 1, 
                'visualizar_checkout' => 1, 
                'visualizar_usuarios' => 1, 
                'visualizar_logistica' => 1, 
                'visualizar_geral' => 1, 
                'visualizar_dashboard' => 1, 
                'gerenciar_produtos' => 1, 
                'gerenciar_marcas' => 1, 
                'gerenciar_categorias' => 1, 
                'gerenciar_variacoes' => 1, 
                'gerenciar_clientes' => 1, 
                'gerenciar_pedidos' => 1, 
                'gerenciar_leads' => 1, 
                'gerenciar_checkout' => 1, 
                'gerenciar_usuarios' => 1, 
                'gerenciar_logistica' => 1, 
                'gerenciar_geral' => 1
            ]);
        }else{
            $dados = UsuariosGrupos::create([
                'nome' => $request->nome, 
                'visualizar_produtos' => (isset($request->visualizar_produtos) ? 1 : 0 ), 
                'visualizar_marcas' => (isset($request->visualizar_marcas) ? 1 : 0 ), 
                'visualizar_categorias' => (isset($request->visualizar_categorias) ? 1 : 0 ), 
                'visualizar_variacoes' => (isset($request->visualizar_variacoes) ? 1 : 0 ), 
                'visualizar_clientes' => (isset($request->visualizar_clientes) ? 1 : 0 ), 
                'visualizar_pedidos' => (isset($request->visualizar_pedidos) ? 1 : 0 ), 
                'visualizar_leads' => (isset($request->visualizar_leads) ? 1 : 0 ), 
                'visualizar_checkout' => (isset($request->visualizar_checkout) ? 1 : 0 ), 
                'visualizar_usuarios' => (isset($request->visualizar_usuarios) ? 1 : 0 ), 
                'visualizar_logistica' => (isset($request->visualizar_logistica) ? 1 : 0 ), 
                'visualizar_geral' => (isset($request->visualizar_geral) ? 1 : 0 ), 
                'visualizar_dashboard' => (isset($request->visualizar_dashboard) ? 1 : 0 ), 
                'gerenciar_produtos' => (isset($request->gerenciar_produtos) ? 1 : 0 ), 
                'gerenciar_marcas' => (isset($request->gerenciar_marcas) ? 1 : 0 ), 
                'gerenciar_categorias' => (isset($request->gerenciar_categorias) ? 1 : 0 ), 
                'gerenciar_variacoes' => (isset($request->gerenciar_variacoes) ? 1 : 0 ), 
                'gerenciar_clientes' => (isset($request->gerenciar_clientes) ? 1 : 0 ), 
                'gerenciar_pedidos' => (isset($request->gerenciar_pedidos) ? 1 : 0 ), 
                'gerenciar_leads' => (isset($request->gerenciar_leads) ? 1 : 0 ), 
                'gerenciar_checkout' => (isset($request->gerenciar_checkout) ? 1 : 0 ), 
                'gerenciar_usuarios' => (isset($request->gerenciar_usuarios) ? 1 : 0 ), 
                'gerenciar_logistica' => (isset($request->gerenciar_logistica) ? 1 : 0 ), 
                'gerenciar_geral' => (isset($request->gerenciar_geral) ? 1 : 0 )
            ]); 
        }
        $dados->acoes = '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>'; 

        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você adicionou um grupo de permissões, '.$request->nome.'.',
            'icone' => 'mdi-account-group-outline',
            'url' => route('configuracoes.grupos'),
            'id_usuario' => Auth::id()
        ]);

        return response()->json($dados);
    }
    public function GruposEditar(Request $request, $id){
        if(isset($request->permissao_total)){
            $dados = UsuariosGrupos::find($id)->update([
                'nome' => $request->nome, 
                'visualizar_produtos' => 1, 
                'visualizar_marcas' => 1, 
                'visualizar_categorias' => 1, 
                'visualizar_variacoes' => 1, 
                'visualizar_clientes' => 1, 
                'visualizar_pedidos' => 1, 
                'visualizar_leads' => 1, 
                'visualizar_checkout' => 1, 
                'visualizar_usuarios' => 1, 
                'visualizar_logistica' => 1, 
                'visualizar_geral' => 1, 
                'visualizar_dashboard' => 1, 
                'gerenciar_produtos' => 1, 
                'gerenciar_marcas' => 1, 
                'gerenciar_categorias' => 1, 
                'gerenciar_variacoes' => 1, 
                'gerenciar_clientes' => 1, 
                'gerenciar_pedidos' => 1, 
                'gerenciar_leads' => 1, 
                'gerenciar_checkout' => 1, 
                'gerenciar_usuarios' => 1, 
                'gerenciar_logistica' => 1, 
                'gerenciar_geral' => 1
            ]);
        }else{
            $dados = UsuariosGrupos::find($id)->update([
                'nome' => $request->nome, 
                'visualizar_produtos' => (isset($request->visualizar_produtos) ? 1 : 0 ), 
                'visualizar_marcas' => (isset($request->visualizar_marcas) ? 1 : 0 ), 
                'visualizar_categorias' => (isset($request->visualizar_categorias) ? 1 : 0 ), 
                'visualizar_variacoes' => (isset($request->visualizar_variacoes) ? 1 : 0 ), 
                'visualizar_clientes' => (isset($request->visualizar_clientes) ? 1 : 0 ), 
                'visualizar_pedidos' => (isset($request->visualizar_pedidos) ? 1 : 0 ), 
                'visualizar_leads' => (isset($request->visualizar_leads) ? 1 : 0 ), 
                'visualizar_checkout' => (isset($request->visualizar_checkout) ? 1 : 0 ), 
                'visualizar_usuarios' => (isset($request->visualizar_usuarios) ? 1 : 0 ), 
                'visualizar_logistica' => (isset($request->visualizar_logistica) ? 1 : 0 ), 
                'visualizar_geral' => (isset($request->visualizar_geral) ? 1 : 0 ), 
                'visualizar_dashboard' => (isset($request->visualizar_dashboard) ? 1 : 0 ), 
                'gerenciar_produtos' => (isset($request->gerenciar_produtos) ? 1 : 0 ), 
                'gerenciar_marcas' => (isset($request->gerenciar_marcas) ? 1 : 0 ), 
                'gerenciar_categorias' => (isset($request->gerenciar_categorias) ? 1 : 0 ), 
                'gerenciar_variacoes' => (isset($request->gerenciar_variacoes) ? 1 : 0 ), 
                'gerenciar_clientes' => (isset($request->gerenciar_clientes) ? 1 : 0 ), 
                'gerenciar_pedidos' => (isset($request->gerenciar_pedidos) ? 1 : 0 ), 
                'gerenciar_leads' => (isset($request->gerenciar_leads) ? 1 : 0 ), 
                'gerenciar_checkout' => (isset($request->gerenciar_checkout) ? 1 : 0 ), 
                'gerenciar_usuarios' => (isset($request->gerenciar_usuarios) ? 1 : 0 ), 
                'gerenciar_logistica' => (isset($request->gerenciar_logistica) ? 1 : 0 ), 
                'gerenciar_geral' => (isset($request->gerenciar_geral) ? 1 : 0 )
            ]);
        }
        $dados = UsuariosGrupos::find($id)->first();
        $dados->acoes = '<div class="mx-2 my-auto"> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-primary shadow-none" id="editar"> Editar </a> <a href="javascript: void(0)" class="mx-1 my-auto badge badge-danger shadow-none" id="excluir"> Excluir </a> </div>';
        Atividades::create([
            'nome' => 'Atuailização de configurações',
            'descricao' => 'Você editou informações do grupo de permissão, '.$request->nome.'.',
            'icone' => 'mdi-account-group-outline',
            'url' => route('configuracoes.grupos'),
            'id_usuario' => Auth::id()
        ]);
        return response()->json($dados); 
    }
    public function GruposExcluir($id){
        if($id == 1){
            return false; 
        }else{
            $usuarios = Usuarios::where('id_grupo', $id)->update(['id_grupo' => 1]);
            UsuariosGrupos::find($id)->delete();

            Atividades::create([
                'nome' => 'Atuailização de configurações',
                'descricao' => 'Você removeu um grupo de permissão.',
                'icone' => 'mdi-account-group-outline',
                'url' => route('configuracoes.grupos'),
                'id_usuario' => Auth::id()
            ]);

            return response()->json(['success' => 'true']);
        }
    }


    
    
}
