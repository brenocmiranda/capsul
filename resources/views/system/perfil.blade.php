@extends('template.index')

@section('title')
Meu perfil
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Meu perfil</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item active"><a href="{{route('perfil')}}">Perfil</a></div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="d-flex">
                <div class="col-12 p-0">
                    
                    @if(Session::has('alteracao'))
                    <p class="alert alert-{{ Session::get('alteracao')['class'] }} alert-dismissible">
                        {{ Session::get('alteracao')['mensagem'] }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </p>
                    @endif
                    
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('salvar.perfil') }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row mb-0">
                            <div class="col-8">                            
                                <div class="card" id="card-1">
                                    <div class="card-header py-0">
                                        <h5 class="section-title">Dados cadastrais</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group col-10">
                                            <label>Nome <i class="text-danger">*</i></label>
                                            <input type="text" name="nome" class="nome1 form-control" placeholder="Usuário 1" value="{{$usuarios->nome}}" required>
                                        </div>
                                        <div class="form-group col-8">
                                            <label>Grupos de permissões</label>
                                            <input type="text" class="form-control" value="{{(isset($usuarios->RelationGrupo) ? $usuarios->RelationGrupo->nome : 'Não atribuído')}}" disabled> 
                                        </div>
                                        <div class="form-group col-7">
                                            <label>E-mail <i class="text-danger">*</i></label>
                                            <input type="email" name="email" class="email form-control" placeholder="suporte@compreca.com.br" value="{{$usuarios->email}}" required autocomplete="new-password">
                                        </div>
                                        <div class="col-12">
                                            <h6>
                                                <a href="javascript:void(0)" id="alterarSenha">
                                                    Alterar senha
                                                    <i class="fa fa-caret-down"></i>
                                                </a>
                                            </h6>
                                        </div> 
                                        <div class="alterarSenha d-none">
                                            <div class="form-group col-5">
                                                <label>Nova senha</label>
                                                <input type="password" name="password" class="senha1 form-control" placeholder="**********" autocomplete="new-password">
                                            </div>
                                            <div class="form-group col-5">
                                                <label>Repita a nova senha</label>
                                                <input type="password" name="password_confirmation" class="senha2 form-control" placeholder="**********" autocomplete="new-password">
                                                <div class="coincidem"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 pl-0">
                                <div class="card" id="card-3">
                                    <div class="card-header py-0">
                                        <h5 class="section-title">Imagem de perfil</h5>
                                    </div>
                                    <div class="card-body mb-1">
                                        <div class="col-12 form-group text-center">
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="border p-2 col rounded-circle text-center mx-auto" style="height: 157px;width: 155px !important;">
                                                        <img class="w-100 rounded-circle" id="PreviewImage" src="{{ (isset($usuarios->RelationImagens) ? asset('storage/app/'.$usuarios->RelationImagens->caminho.'?'.rand()) : asset('public/img/user.png').'?'.rand()) }}" style="height: 140px;width: 140px;">
                                                        <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept="image/*" name="id_imagem" id="id_imagem" onchange="image(this);" title="Selecione sua imagem">
                                                    </div>
                                                </div>
                                            </div>  
                                            <h5 class="mt-3 d-block card-subtitletext-break" id="nome">{{ $usuarios->nome }}</h5>
                                            <label class="my-2 d-block text-break" id="email">{{ $usuarios->email }}</label>
                                            <label class="my-2 d-block text-break text-primary" id="email">Grupo Capsul</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="col-12 mb-5 text-right">
                            <a href="{{ route('home') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
                            <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('support')
<script type="text/javascript">
    $(document).ready(function (){
        $('.documento').mask('000.000.000-00', {reverse: true});
        
        $('.senha1, .senha2').blur(function(){
            $('.senha1').removeClass('border-danger');
            if ($('.senha1').val() == $('.senha2').val() && $('.senha1').val() != ""){
                $('.coincidem').html('<label class="text-success font-weight-bold">Suas senhas estão iguais. Corrija</label>');
             }else{
                $('.coincidem').html('<label class="text-danger font-weight-bold">As senhas não coincidem!</label>');
                $('.senha1').addClass('border-danger');
            }
        });

        $('#alterarSenha').click(function(){
            if ($('.alterarSenha').hasClass('d-none')){
                $('.alterarSenha').removeClass('d-none');
            }else{
                $('.alterarSenha').addClass('d-none');
            }
        });

        $('.nome1').keyup(function(){
            $('#nome').html(this.value);
        });
        $('.email').keyup(function(){
            $('#email').html(this.value);
        });
    });
</script>
@endsection
