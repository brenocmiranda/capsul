@section('title')
Login
@endsection

@include('template.header')
@include('template.carregar')

<div id="app" class="min-vh-100">
  <section class="section h-100">
    <div class="d-flex flex-wrap align-items-stretch h-100 m-0">
      <div class="col-lg-4 col-md-6 col-12 order-lg-2 min-vh-100 order-2 bg-white mx-sm-auto border border-top-0">
        <div class="p-4 m-3">
          <img src="{{ asset('storage/app/system/capsul.png') }}" alt="logo" width="200" class="mb-5 mt-2">
          <h4 class="text-dark font-weight-normal">Seja bem-vindo ao <span class="font-weight-bold">Portal do {{$geral->nome_loja}}</span></h4>
          <p class="text-muted">Entre como suas credênciais de acesso a plataforma.</p>

          @if(Session::has('login'))
          <p class="p-0 alert text-{{ Session::get('login')['class'] }}">
            {{ Session::get('login')['mensagem'] }}
          </p>
          @endif

          <form method="POST" action="{{ route('redirect') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
              <label for="email">E-mail</label>
              <input id="email" type="email" class="form-control" name="email" tabindex="1" placeholder="Entre com seu e-mail" required autofocus>
              @if(Session::has('email'))
              <p class="pt-1 text-danger">{{ Session::get('email')['mensagem'] }}</p>
              @endif
            </div>

            <div class="form-group">
              <div class="d-block">
                <label for="password" class="control-label">Senha</label>
              </div>
              <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="Entre com sua senha" required>
              @if(Session::has('password'))
              <p class="pt-1 text-danger">{{ Session::get('password')['mensagem'] }}</p>
              @endif
            </div>

            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                <label class="custom-control-label" for="remember-me">Relembrar</label>
              </div>
            </div>

            <div class="form-group text-right">
              <a href="#" class="recuperar float-left mt-3" data-toggle="modal" data-target="#modal-recuperar">
                Esqueceu sua senha?
              </a>
              <button type="submit" class="btn btn-success btn-lg shadow-none" tabindex="4">
                <span> Entrar </span>
                <i class="mdi mdi-arrow-right px-2"></i>
              </button>
            </div>
          </form>

          <div class="text-center mt-5 text-small pt-4">
            Copyright &copy; {{$geral->nome_loja}}.
            <div class="mt-2">
              <a href="#">Políticas de Privacidade</a>
              <div class="bullet"></div>
              <a href="#">Termos de serviço</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-8 col-12 order-lg-2 order-2 min-vh-100 position-relative d-none d-lg-block" data-background="{{ asset('public/img/login1.png') }}" style="background-size: contain; background-repeat: no-repeat;">
        <div class="absolute-bottom-left index-2">
          <div class="text-light p-5">
            <!--<div class="mb-4 pb-3">
              <h1 class="mb-2 display-4 font-weight-bold text-dark">Capsul</h1>
              <h5 class="font-weight-normal text-dark-transparent text-dark">Ontem fui na farmácia e pedi um relógio, mas o atendente disse que era uma farmácia.<br>Eu disse que o tempo é o melhor remédio e fui embora.</h5>
            </div>-->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal de recuperação de password -->
<div class="modal fade" id="modal-recuperar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="card mb-0">
        <div class="card-header py-0">
          <h5 class="my-auto">Recuperar senha</h5>
          <button type="button" class="ml-auto close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card-body" >
          <div id="err"></div>
          <div class="carregamento"></div>
          <form id="formRecuperar" enctype="multipart/form-data">
            @csrf
            <label class="my-2 mx-3">Para recuperar a sua senha,  serão enviadas por e-mail algumas etapas para serem seguidas. Preencha abaixo os dados solicitados para recuperação de senha.</label>
            
            <div class="form-group col-10 m-2">
              <label>E-mail:</label>
              <input type="email" class="form-control" name="email" placeholder="suporte@capsul.com.br">
            </div>
            <div class="col-12 m-4 ml-auto">
              <button class="btn btn-success col-3 shadow-none mx-1 d-flex align-items-center justify-content-center ml-auto">
                <span>Enviar</span> 
                <i class="mdi mdi-arrow-right px-1"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@include('template.footer')

<script type="text/javascript">
    $(window).load(function() {
          //Após a leitura da pagina o evento fadeOut do loader é acionado, esta com delay para ser perceptivo em ambiente fora do servidor.
          $("#modal-processamento").delay(2000).fadeOut("slow");
      });

    $(document).ready(function (){

        $('.recuperar').on('click', function(e){
          $('#err').html('');
          $('.carregamento').html('');
          $('#modal-recuperar #formRecuperar').removeClass('d-none');
        });

         // Enviando email de recuperação
         $('#modal-recuperar #formRecuperar').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("encaminhar.password") }}',
                type: 'POST',
                data: $('#modal-recuperar #formRecuperar').serialize(),
                beforeSend: function(){
                    $('input[name="email"]').removeClass('border border-danger');
                    $('#err').html('');
                    $('.card-body #formRecuperar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Enviando e-mail de recuperação...</label></div>');
                },
                success: function(data){
                    $('.carregamento').html('<div class="mx-auto text-center my-5 mt-3"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3 text-sucess" style="font-size:62px;"></i></div><h5>E-mail enviado com sucesso!</h5><label class="mx-4">Verifique o recebimento da mensagem na sua <b>caixa de entrada ou na área de spam</b>. Caso não esteja recebendo o e-mail de redefinição, entre em contato com o administrador.</label><div class="col-12 mt-5 text-center"><button type="button" class="btn btn-danger btn-lg shadow-none col-4" data-dismiss="modal" aria-label="Close">Fechar</button></div></div> ');
                }, error: function (data) {
                    setTimeout(function(){
                        $('#modal-recuperar #formRecuperar').removeClass('d-none');
                        $('.carregamento').html('');
                        $('#modal-recuperar #err').html('<div class="alert alert-danger mx-2">E-mail não cadastrado na plataforma, entre em contato com o administrador.</div>');
                        $('#modal-recuperar input[name="email"]').addClass('border border-danger');
                    }, 800);
                }
            });
        });
     });
 </script>