@extends('template.index')

@section('title')
Minhas atividades
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Minhas atividades</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('atividades') }}">Atividades</a></div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="d-flex">
                <div class="col-12 p-0">
                    <div class="card">
                        <div class="card-header py-0">
                            <h5 class="section-title">Últimas atualizações</h5>
                        </div>
                        <div class="card-body mx-4">
                            <div class="activities">
                                @if(!empty($dados->first() ))
                                    @foreach($dados as $atividade)
                                        <div class="activity">
                                            <div class="bg-primary text-white activity-icon teal shadow-light">
                                                <i class="mdi {{$atividade->icone}}"></i>
                                            </div>
                                            <div class="activity-detail border rounded">
                                                <div class="mb-2">
                                                    <span class="text-job teal-text">{{ $atividade->created_at->subMinutes(2)->diffForHumans() }}</span>
                                                    <span class="bullet"></span>
                                                    <a class="text-job mr-4" href="{{$atividade->url}}">{{$atividade->nome}}</a>
                                                </div>
                                              
                                              <label>{{$atividade->descricao}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div>
                                        <label> Você ainda não possui nenhuma atividade na plataforma.</label>
                                    </div>
                                @endif

                            </div>

                            <div class="pagination d-flex justify-content-end">
                                {{ $dados->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

