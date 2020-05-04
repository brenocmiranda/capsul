@extends('template.index')

@section('title')
Página inicial
@endsection

@section('content')
<div class="main-content vh-100">
    <section class="section h-100">
        <div class="col-12 h-100 row">
        	<div class="col-8 m-auto">
        		<div class="mb-5 d-flex">
        			<div>
			        	<h1 class="mb-3 text-dark">Olá, {{explode(" ", Auth::user()->nome)[0]}}!</h1>
			        	<h6 class="font-weight-normal">Seja bem-vindo a plataforma do <b>{{$geral->nome_loja}}</b>.</h6>
			        	<h6 class="font-weight-normal"><b>Últim acesso:</b> {{(isset(Auth::user()->RelationAtividades) ? date_format(Auth::user()->RelationAtividades->created_at, "d/m/Y H:i:s") : '')}} - {{(isset(Auth::user()->RelationAtividades) ? @Auth::user()->RelationAtividades->created_at->subMinutes(2)->diffForHumans() : '')}}</h6>
			        </div>
		        	<div class="ml-auto">
		        		<img class="rounded-circle" id="PreviewImage" src="{{ (isset(Auth::user()->RelationImagens) ? asset('storage/app/'.Auth::user()->RelationImagens->caminho.'?'.rand()) : asset('public/img/user.png').'?'.rand()) }}" style="height: 120px;width: 120px;">
		        	</div>
		        </div>
	        	<hr>
	        </div>
        </div>
    </section>
</div>
@endsection
