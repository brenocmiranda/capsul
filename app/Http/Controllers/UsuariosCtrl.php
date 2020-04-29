<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRqt;
use App\Http\Requests\PerfilRqt;

use Mail;
use App\Atividades;
use App\Usuarios;
use App\Produtos;
use App\Pedidos;
use App\Clientes;
use App\Imagens;
use App\Emails;
use App\Notificacoes;
use App\ConfigCheckout;
use App\ConfigGeral;
use App\ConfigEmails;

class UsuariosCtrl extends Controller
{

	public function __construct(){
      $this->geral = ConfigGeral::first();
      $this->emails = ConfigEmails::first();
  	}

	#-------------------------------------------------------------------
	# Informações sistema
	#-------------------------------------------------------------------

	// Página inicial
	public function Home(){
		return view('system.home');
	}

    // Login
	public function Login(){
		if (Auth::check()) {
			return redirect(route('home'));
		}else{
			return view('system.login')->with('geral', $this->geral);
		}
	}

	// Autenticação de usuário
	public function Redirecionar(LoginRqt $FormLogin){
		Auth::logoutOtherDevices($FormLogin->password);
		if (Auth::attempt(['email' => $FormLogin->email, 'password' => $FormLogin->password], $FormLogin->remember)){
			// Ativo
			if(Usuarios::where('email', $FormLogin->email)->where('ativo', 1)->first()){
				Atividades::create([
	                'nome' => 'Inicializou a sessão',
	                'descricao' => 'Você entrou na sua conta.',
	                'icone' => 'mdi-home-outline',
	                'url' => 'javascript:void(0)',
	                'id_usuario' => Auth::id()
	            ]);
				return redirect()->intended('home');
			// Não ativo
			}elseif (Usuarios::where('email', $FormLogin->email)->where('ativo', 0)->first()){
				\Session::flash('login', array(
					'class' => 'danger',
					'mensagem' => 'O usuário encontra-se desativado, contate o administrador.'
				));
				return redirect(route('login'));
			// Bloqueado
			}elseif(Usuarios::where('email', $FormLogin->email)->where('ativo', '1')->first()){
				\Session::flash('login', array(
					'class' => 'danger',
					'mensagem' => 'O usuário encontra-se bloqueado, contate o administrador.'
				));
				return redirect(route('login'));
			}
		}elseif(Usuarios::where('email', $FormLogin->email)->first()){
			\Session::flash('password', array(
				'class' => 'danger',
				'mensagem' => 'A senha inserida não confere.'
			));
			return redirect(route('login'));
		}else{
			\Session::flash('email', array(
				'class' => 'danger',
				'mensagem' => 'E-mail não cadastrado.'
			));
			return redirect(route('login'));
		}	
	}

	// Sair
	public function Sair(){
		Atividades::create([
	                'nome' => 'Finalizou a sessão',
	                'descricao' => 'Você saiu da sua conta.',
	                'icone' => 'mdi-logout',
	                'url' => 'javascript:void(0)',
	                'id_usuario' => Auth::id()
	            ]);

		Auth::logout();
		return redirect(route('login'));
	}

	// Erro de permissão para acesso
	public function Acesso(){
		return view('system.permission');
	}

    #-------------------------------------------------------------------
	# Template usuários
	#-------------------------------------------------------------------

    // Perfil do usuário
	public function Perfil(){
		$usuarios = Usuarios::select('nome', 'email', 'id_grupo', 'id_imagem')->find(Auth::id());
		return view('system.perfil')->with('usuarios', $usuarios);
	}
    public function SalvarPerfil(PerfilRqt $request){
        $dados = $request->all();

        $imagens = (isset($dados['id_imagem']) ? $dados['id_imagem'] : null);
        if(!empty($imagens)){
            $nameFile = null;
            if ($request->hasFile('id_imagem') && $request->file('id_imagem')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension = $request->id_imagem->extension();
                $nameFile = "{$name}.{$extension}";
                $upload = $request->id_imagem->storeAs('usuarios', $nameFile);
                $imagem = Imagens::create(['caminho' => $upload, 'tipo' => 'usuarios']);
            	$dados['id_imagem'] = $imagem->id;  
            }        
        }

        $usuario = Usuarios::find(Auth::id());
        Usuarios::find(Auth::id())->update([ 
                            'nome' => $dados['nome'],
                            'email' => $dados['email'],
                            'password' => (isset($dados['password_confirmation']) ? Hash::make($dados['password_confirmation']) : $usuario->password),
                            'id_imagem' => (isset($dados['id_imagem']) ? $dados['id_imagem'] : $usuario->id_imagem)
                        ]);

        \Session::flash('alteracao', array(
            'class' => 'success',
            'mensagem' => 'Informações alteradas com sucesso.'
        ));

        Atividades::create([
                'nome' => 'Alterações no perfil',
                'descricao' => 'Você alterou algumas informações no seu perfil.',
                'icone' => 'mdi-update',
                'url' => route('perfil', Auth::id()),
                'id_usuario' => Auth::id()
            ]);

        return redirect(route('perfil'));
    }

    // Alterando senha no primeiro acesso
    public function PrimeiroAcesso(Request $request){
		$dados = Usuarios::find(Auth::user()->id)->update([
            'password' => Hash::make($request->confirmpassword), 
            '_token' => md5(rand()),
            'email_verified_at' => date("Y-m-d H:i:s")    
        ]);

        Atividades::create([
                'nome' => 'Redefinição de senha',
                'descricao' => 'Você solicitou a redefinição de senha e a modificou.',
                'icone' => 'mdi-textbox-password',
                'url' => route('perfil', $request->id),
                'id_usuario' => $request->id
            ]);

        return redirect(route('home'));
	}


	// Todas as atividades do usuário
    public function Atividades(){
        $dados = Atividades::where('id_usuario', Auth::id())->where('status', 1)->orderBy('created_at', 'desc')->paginate(6);
        return view('system.atividades')->with('dados', $dados);
    }

	// Recuperação de senha
	public function Forwarding(Request $request){
		if(!empty($request->email)){
			$dados = Usuarios::where('email', $request->email)->first();
			if(!empty($dados->first())){
				Mail::send('system.emails.recuperacao', ['user' => $dados], function ($m) use ($dados) {
					$m->from($this->emails->email_remetente, $this->emails->nome_remetente);
					$m->to($dados->email, $dados->nome)->subject('Redefinição de senha');
				});
				return response()->json(['success' => true]);
			}else{
				return false;
			}
		}else{
				return false;
			}	
	}
	public function NewPassword($token){
		$user = Usuarios::where('_token', $token)->select('id', 'nome', 'id_imagem')->first();
		Auth::logout();
		if(isset($user)){
			return view('system.password')->with('user', $user);
		}else{
			\Session::flash('login', array(
				'class' => 'danger',
				'mensagem' => 'Senha já redefinida.'
			));
			return redirect(route('login'));
		}
	}
	public function Alterar(Request $request){
		$dados = Usuarios::where('id', $request->id)->update([
            'password' => Hash::make($request->confirmpassword), 
            '_token' => md5(rand())
        ]);

        Atividades::create([
                'nome' => 'Redefinição de senha',
                'descricao' => 'Você solicitou a redefinição de senha e a modificou.',
                'icone' => 'mdi-textbox-password',
                'url' => route('perfil', $request->id),
                'id_usuario' => $request->id
            ]);

		\Session::flash('login', array(
			'class' => 'success',
			'mensagem' => 'Senha alterada com sucesso, faça o login.'
		));
		return redirect(route('login'));
	}

}		