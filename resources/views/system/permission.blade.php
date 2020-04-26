@extends('template.index')

@section('title')
Sem autorização
@endsection

@section('content')
<div class="main-content vh-100">
  <section class="h-100 section">
    <div class="row h-100">
      <div class="m-auto text-center">
        <i class="mdi mdi-lock-alert mdi-48px mdi-dark"></i>
        <h6> Você não possui permissão para acessar esse conteúdo.</h6>
      </div>
    </div>
  </section>
</div>
@endsection