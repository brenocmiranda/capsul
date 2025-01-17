@extends('template.index')

@section('title')
Editar produto
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Editar do informações</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('produtos.lista')}}">Produtos</a></div>
                    <div class="breadcrumb-item active">Editar</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('produtos.editando', $produto->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-3 mx-auto">
                            <div class="col-3 border rounded-lg mx-1 text-center bg-white{{ ($produto->variante == 'n' ? ' border-primary' : '') }}" id="variante1" style="cursor: pointer">
                                <div class="pt-3">
                                    <label class="colorinput mx-2">
                                        <input type="radio" name="variante" value="false" class="colorinput-input" {{ ($produto->variante == 'n' ? 'checked' : '') }}>
                                        <span class="colorinput-color bg-light border rounded-circle"></span>
                                    </label>
                                    <i class="fas fa-tag" style="font-size: 25px"></i>
                                </div>
                                <div class="py-2">
                                    <label class="font-weight-bold">Produto sem variante</label>
                                </div>
                            </div>
                            <div class="col-3 border rounded-lg mx-1 text-center bg-white {{ ($produto->variante == 's' ? ' border-primary' : '') }}" id="variante2" style="cursor: pointer">
                             <div class="pt-3">
                                <label class="colorinput mx-2">
                                    <input type="radio" name="variante" value="true" class="colorinput-input"{{ ($produto->variante == 's' ? 'checked' : '') }}>
                                    <span class="colorinput-color bg-light border rounded-circle"></span>
                                </label>
                                <i class="fas fa-tags" style="font-size: 25px"></i>
                            </div>
                            <div class="py-2">
                                <label class="font-weight-bold">Produto com variante</label>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="card-1">
                        <div class="card-header">
                            <label class="section-title my-0">Informações básicas</label>
                        </div>
                        <div class="card-body">
                            <div class="col-12 my-3">
                                <label class="custom-switch px-0">
                                    <input type="checkbox" name="ativo" class="custom-switch-input" {{ ($produto->ativo == "s" ? 'checked' : '') }}>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Ativo</span>
                                </label>
                            </div>
                            <div class="col-12 my-3">
                                <div class="form-group mb-0">
                                    <label>Tipo de produto <i class="text-danger">*</i></label>
                                </div>
                                <div class="selectgroup">
                                    <label class="selectgroup-item">
                                      <input type="radio" name="tipo" value="fisico" class="selectgroup-input" {{ ($produto->tipo == "fisico" ? 'checked' : '') }}>
                                      <span class="selectgroup-button px-4 py-1 h-100"><b>Produto Físico</b></span>
                                  </label>
                                  <label class="selectgroup-item">
                                      <input type="radio" name="tipo" value="digital" class="selectgroup-input" {{ ($produto->tipo == "digital" ? 'checked' : '') }}>
                                      <span class="selectgroup-button px-4 py-1 h-100"><b>Produto Digital</b></span>
                                  </label>
                              </div>
                          </div>
                          <div class="form-group col-8">
                            <label>Nome do produto <i class="text-danger">*</i></label>
                            <input type="text" name="nome" class="produto form-control" value="{{ $produto->nome }}" required >
                        </div>
                        <div class="form-group col-4">
                            <label>Marca <i class="text-danger">*</i></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                <select class="form-control id_marca h-100" name="id_marca" required>
                                    <option disabled="disabled">Selecione</option>
                                    @foreach($marcas as $marca)
                                    <option value="{{$marca->id}}" {{ $produto->id_marca == $marca->id ? 'selected' : '' }} >{{$marca->nome}}</option>
                                    @endforeach
                                </select>
                                <div class="mx-2 my-auto">
                                    <a href="javascript:void(0)" class="btn btn-success rounded px-2 py-0 shadow-none" title="Nova marca" data-toggle="modal" data-target="#produtos-marcas"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>     
                        </div>
                    </div>
                </div>

                <div class="card" id="card-2">
                    <div class="card-header">
                        <label class="section-title my-0">Checkout</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-6">
                            <label>Pixels Facebook</label>
                            <input type="text" class="form-control" name="pixels_facebook" value="{{ $produto->pixels_facebook }}">
                        </div>
                        <div class="form-group col-6">
                            <label>URL de redirecionamento para compra <i class="text-danger">*</i></label>
                            <input type="text" class="form-control link" name="link_produto" value="{{ $produto->link_produto }}" required>
                            <label class="font-weight-light py-1"> Não atribuir espaços ou caracteres especiais.</label>
                        </div>
                    </div>
                </div>

                <div class="card" id="card-3">
                    <div class="card-header">
                        <label class="section-title my-0">Categorias</label>
                        <div class="ml-auto">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#produtos-categorias">+ Cadastrar categoria</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-6 form-group">
                                <label>Selecione as categorias <i class="text-danger">*</i></label>
                                <div class="col-12 p-0">
                                    <select class="form-control h-100" id="listaCategorias">
                                        <option disabled="disabled">Selecione</option>
                                        @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                        @endforeach                                       
                                    </select>
                                </div>
                                <div class="col-12 p-0 mt-3 rounded">
                                    <button type="button" class="btn btn-outline-secondary shadow-none row m-0" title="Inserir na tabela" id="addCategoria">
                                        <i class="mdi mdi-table-column-plus-after"></i> 
                                        <b class="px-2">Inserir</b>
                                    </button>
                                </div>
                            </div>     

                            <div class="table-responsive col-6">
                                <table class="table" id="tableCategoria">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">Nome da categoria</th>
                                            <th class="text-center text-uppercase"> Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($produto->RelationProdutosCategorias->first()))
                                        @foreach($produto->RelationProdutosCategorias as $categoria)
                                        <tr> 
                                            <td class="name"> 
                                                {{ $categoria->nome }} 
                                                <input type="hidden" name="categorias[]" value="{{$categoria->id}}"> 
                                            </td> 
                                            <td> 
                                                <div class="text-center"> 
                                                    <a href="javascript:void(0)" onclick="removeCategoria(this)" class="btn btn-danger rounded-circle shadow-none">X</a> 
                                                </div> 
                                            </td> 
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr class="notCategorias"> 
                                            <td>Nenhuma categoria cadastrada</td>
                                            <td></td>
                                        </tr>
                                        @endif     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card{{ ($produto->variante == 's' ? '' : ' d-none') }}" id="card-4">
                    <div class="card-header">
                        <label class="section-title my-0">Variantes</label>
                        <div class="ml-auto">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#produtos-variantes">+ Cadastrar variação</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-6 form-group">
                                <label>Selecione as variações <i class="text-danger">*</i></label>
                                <div class="col-12 p-0">
                                    <select class="form-control h-100" id="listaVariacoes">
                                        <option disabled="disabled">Selecione</option>
                                        @foreach($variacoes as $variacao)
                                        <option value="{{$variacao->id}}">{{$variacao->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 p-0 mt-3 rounded">
                                    <button type="button" class="btn btn-outline-secondary shadow-none row m-0" title="Inserir na tabela" id="addVariacoes">
                                        <i class="mdi mdi-table-column-plus-after"></i> 
                                        <b class="px-2">Inserir</b>
                                    </button>
                                </div>
                            </div>     

                            <div class="table-responsive col-6">
                                <table class="table" id="tableVariacoes">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">Nome da variação</th>
                                            <th class="text-uppercase">Valor</th>
                                            <th class="text-center text-uppercase"> Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($produto->RelationProdutosVariacoes->first()))
                                        @foreach($produto->RelationProdutosVariacoes as $variacoes)
                                        <tr> 
                                            <td class="name"> 
                                                {{ $variacoes->nome }} 
                                                <input type="hidden" name="variacoes[]" value="{{$variacoes->id}}"> 
                                            </td> 
                                            <td>
                                                {{ $variacoes->valor }}
                                            </td>
                                            <td> 
                                                <div class="text-center"> 
                                                    <a href="javascript:void(0)" onclick="removeVariacao(this)" class="btn btn-danger rounded-circle shadow-none">X</a> 
                                                </div> 
                                            </td> 
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr class="notCategorias"> 
                                            <td>Nenhuma variação cadastrada</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @endif    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" id="card-5">
                    <div class="card-header">
                        <label class="section-title my-0">SKU</label>
                    </div>
                    <div class="card-body p-0 pt-3">
                        <div class="form-group col-12 px-5">
                            <label class="custom-switch px-0">
                                <input type="checkbox" name="disponivel_venda" class="custom-switch-input" {{ ($produto->disponivel_venda == "s" ? 'checked' : '') }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Disponível para vendaz</span>
                            </label>
                        </div>
                        <div class="my-3 px-5">
                            <div class="d-block">
                                <div class="form-group mb-0">
                                    <label>Código SKU 
                                        <i class="text-danger">*</i> 
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Código exclusivo para identificar este produto.">
                                            <div class="mx-2 px-2 border rounded-circle bg-light"><i class="fas fa-info"></i></div>
                                        </span>
                                    </label>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control cod_sku h-100 col-3" name="cod_sku" onkeyup="this.value = this.value.toUpperCase();" value="{{ $produto->cod_sku }}" required>
                                    <div class="input-group-append border rounded">
                                        <a class="btn btn-lg pb-0 text-uppercase gerar">Gerar</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-5 px-5">
                            <label>Código de Barras (EAN-13)</label>
                            <input type="text" class="cod_ean form-control" name="cod_ean" maxlength="13" value="{{ $produto->cod_ean }}">
                        </div>

                        <div class="row m-0">
                            <div class="form-group col-3 px-5">
                                <label>Quantidade <i class="text-danger">*</i></label>
                                <input type="number" class="form-control" name="quantidade" value="{{ $produto->quantidade }}" required>
                            </div>
                            <div class="col-3 form-group mb-5">
                                <label>Quantidade mínima <i class="text-danger">*</i></label>
                                <input type="number" class="form-control" name="quantidade_minima" value="{{ $produto->quantidade_minima }}" required>
                            </div>
                        </div>

                        <div class="row m-0 bg-light p-3">
                            <div class="form-group col-4">
                                <label>Preço de custo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>R$</b>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency h-100" name="preco_custo" value="{{ number_format($produto->preco_custo, 2, ',', '.') }}">
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label>Preço de venda <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>R$</b>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency h-100" name="preco_venda" value="{{ number_format($produto->preco_venda, 2, ',', '.') }}" required>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label>Preço promocional</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>R$</b>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency h-100" name="preco_promocional" value="{{ number_format($produto->preco_promocional, 2, ',', '.') }}">
                                </div>
                            </div>     
                        </div>
                    </div>
                </div>

                <div class="card{{ ($produto->variante == 's' ? ' d-none' : '') }}" id="card-6">
                    <div class="card-header">
                        <label class="section-title my-0">Peso e Dimensões</label>
                    </div>
                    <div class="card-body row">
                        <div class="row col-8">
                            <div class="form-group col-6">
                                <label>Peso <i class="text-danger">*</i></label>
                                <div class="input-group"> 
                                    <input type="text" class="form-control medida h-100" name="peso" value="{{ number_format($produto->peso, 2, ',', '') }}" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>Kg</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label>Largura <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" class="form-control medida h-100" name="largura" value="{{ number_format($produto->largura, 2, ',', '') }}" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>cm</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label>Altura <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" class="form-control medida h-100" name="altura" value="{{ number_format($produto->altura, 2, ',', '') }}" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>cm</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label>Comprimento <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" class="form-control medida h-100" name="comprimento" value="{{ number_format($produto->comprimento, 2, ',', '') }}" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>cm</b>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>
                        <div class="col-4 text-center">
                            <img src="{{ asset('public/img/product-dimensions.svg') }}">
                        </div>
                    </div>
                </div>

                <div class="card" id="card-7">
                    <div class="card-header">
                        <label class="section-title my-0">Imagens</label>
                    </div>
                    <div class="card-body">
                        <div class="col-12 form-group">
                            <h6 class="col-12 row">Selecione a imagem principal <i class="text-danger">*</i></h6>
                            <div class="row">
                                <div class="col-7">
                                    <div class="border p-3 col-6 rounded text-center">
                                        @if(!empty($produto->RelationImagensPrincipal->first()))
                                        <input type="hidden" name="imagem_principal_id" value="{{$produto->RelationImagensPrincipal->first()->id}}"> 
                                        <img class="w-100 rounded" id="PreviewImage" src="{{ asset('storage/app/'.$produto->RelationImagensPrincipal->first()->caminho).'?'.rand() }}" style="height: 16em;">
                                        @else
                                        <img class="w-100 rounded" id="PreviewImage" src="{{ asset('public/admin/img/system/product.png').'?'.rand() }}" style="height: 250px;">
                                        @endif
                                        <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept="image/*" name="imagem_principal" id="imagem_principal" onchange="image(this);" title="Selecione sua imagem">
                                    </div>
                                    <small class="my-2">Aceitamos .png, .jpg ou .svg</small>
                                </div>
                            </div>  
                        </div>
                        <div class="col-12 form-group">
                            <h6 class="col-12 row mb-0">Selecione as demais imagens</h6>
                            <small>Formatos de imagem aceitos: .png, .jpg ou .svg</small>
                            <div class="row col-12 mt-3 preview">
                                <div class="border m-2 rounded col-2 row m-0" style="height: 180px;">
                                    <i class="mdi mdi-plus mdi-36px m-auto"></i>
                                    <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept=".png, .jpg, .jpeg" id="addFotoGaleria" accept="image/*" title="Selecione mais imagens do produto" multiple>
                                </div>
                                @if(!empty($produto->RelationImagens->first()))
                                @foreach ($produto->RelationImagens as $imagens)
                                <div class="border m-2 rounded col-2 d-flex m-0" id="PreviewImage{{$imagens->id}}"> 
                                    <input type="hidden" name="imagens[]" value="{{$imagens->id}}"> 
                                    <img class="p-3 w-100" src="{{ asset('storage/app/'.$imagens->caminho).'?'.rand() }}" style="height: 180px;">
                                    <a href="javascript:void(0)" onclick="removeImagem('{{$imagens->id}}')" class="btn btn-light rounded-circle m-n2 border" style="height: 36px;">x</a> 
                                </div>
                                @endforeach
                                @endif
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="card" id="card-8">
                    <div class="card-header">
                        <label class="section-title my-0">Detalhes do produto</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-12">
                            <label>Descrição do produto</label>
                            <textarea class="summernote" name="detalhes_produto">{{ $produto->detalhes_produto }}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="col-12 mb-5 text-right">
                    <a href="{{ route('produtos.lista') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
                    <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
                </div>
            </div>
        </div>
    </form>
</div>
</section>
</div>
@endsection

@section('modal')
@include('produtos.extras.marcas')
@include('produtos.extras.variantes')
@include('produtos.extras.categorias')
@endsection

@section('support')
<script type="text/javascript">
    function removeCategoria(input){
        var id = $(input).parents('tr').find('input[type="hidden"]').val();
        var nome = $(input).parents('tr').find('.name').text();

        // Remove categoria
        if($("#tableCategoria tbody").find('tr').length <= 1){
            $("#tableCategoria tbody").html('<tr class="notCategorias"><td>Nenhuma categoria cadastrada</td> <td></td> </tr>'); 
        }else{
            $(input).closest('tr').remove();
        }

        // Insere novamente no select
        $('#listaCategorias').append('<option value="'+id+'">'+nome+'</option>');
        $('#addCategoria').removeAttr('disabled');
    }

    function removeVariacao(input){
        var id = $(input).parents('tr').find('input[type="hidden"]').val();
        var nome = $(input).parents('tr').find('.name').text();

        // Remove categoria
        if($("#tableVariacoes tbody").find('tr').length <= 1){
            $("#tableVariacoes tbody").html('<tr class="notVariacoes"> <td>Nenhuma variação cadastrada</td> <td></td> <td></td> </tr>'); 
        }else{
            $(input).closest('tr').remove();
        }

        // Insere novamente no select
        $('#listaVariacoes').append('<option value="'+id+'">'+nome+'</option>');
        $('#addVariacoes').removeAttr('disabled');
    }

    function removeImagem(id){
       $.ajax({
        url: "../removeImagem/"+id,
        type: 'GET',
        success: function(data){ 
         $('#PreviewImage'+id).remove();
     }
 });
   }

   $(document).ready(function (){
        // Pré-visualização de várias imagens no navegador
        $('#addFotoGaleria').on('change', function(event) {
            var formData = new FormData();
            formData.append('_token', '{{csrf_token()}}');

            if (this.files) {
                for (i = 0; i < this.files.length; i++) {
                    formData.append('imagens[]', this.files[i]);
                }
                
                $.ajax({
                    url: "{{ route('imagens.produtos') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data){ 
                        for (i = 0; i < data.length; i++) {
                            $('div.preview').append('<div class="border m-2 rounded col-2 d-flex m-0" id="PreviewImage'+data[i].id+'"> <input type="hidden" name="imagens[]" value="'+data[i].id+'"> <img class="p-3 w-100" src="{{asset("storage/app")}}/'+data[i].caminho+'" style="height: 12em"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn rounded-circle m-n2">x</a> </div>');
                        } 
                        $('#addFotoGaleria').val('');   
                    }
                });
            }
        });

        // Cadastrando as categorias
        $("#addCategoria").on('click', function(){
            $(this).attr('disabled', 'disabled');
            var data = $("#listaCategorias option:selected");

            if(data.val()){ 
                $.ajax({
                    url: '../categorias/detalhes/'+data.val(),
                    type: 'GET',
                    success: function(data){ 
                        // Removendo do select
                        $('#listaCategorias option:selected').remove();
                        $(".notCategorias").remove();
                        //// Inserindo dados na tabela
                        $("#tableCategoria tbody").append('<tr> <td class="name"> '+data.nome+' <input type="hidden" name="categorias[]" value="'+data.id+'"> </td> <td> <div class="text-center"> <a href="javascript:void(0)" onclick="removeCategoria(this)" class="btn btn-danger rounded-circle shadow-none">X</a> </div> </td> </tr>');
                        $('#addCategoria').removeAttr('disabled');
                    }
                });
            }
        });

        // Cadastrando as variações
        $("#addVariacoes").on('click', function(){
            $(this).attr('disabled', 'disabled');
            var data = $("#listaVariacoes option:selected");

            if(data.val()){ 
                $.ajax({
                    url: '../variacoes/detalhes/'+data.val(),
                    type: 'GET',
                    success: function(data){ 
                        // Removendo do select
                        $('#listaVariacoes option:selected').remove();
                        $(".notVariacoes").remove();
                        //// Inserindo dados na tabela
                        $("#tableVariacoes tbody").append('<tr> <td class="name"> '+data.nome+' <input type="hidden" name="variacoes[]" value="'+data.id+'"> </td> <td> '+data.valor+' </td> <td> <div class="text-center"> <a href="javascript:void(0)" onclick="removeVariacao(this)" class="btn btn-danger rounded-circle shadow-none">X</a> </div> </td> </tr>');
                        $('#addVariacoes').removeAttr('disabled');                        
                    }
                });
            }
        });
        
        // Mascaras
        $('.currency').mask('000.000.000.000.000,00', {reverse: true});
        $('.cod_ean').mask('0000000000000');
        $('.medida').mask('00000.00', {reverse: true});
        $('.cod_sku').mask('AAAAAAAAAA', {'translation': {
            A: {pattern: /[A-Za-z0-9]/},
        }});

        $('.link').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {
            A: {pattern: /[a-z0-9]/},
        }});

        $('.produto').on('keyup', function(){
         $('.link').val(this.value.toLowerCase().replace(/([^\w]+|\s+)/g, '').replace(" ", ""));
     });

        // Tipo de produto
        $('#variante1').on('click', function(){
            $('#variante2').removeClass('border-primary');
            $('#variante2 input').removeAttr('checked');
            $('#card-5').removeClass('d-none');
            $('#card-6').removeClass('d-none');
            $('#card-4').addClass('d-none');
            $(this).addClass('border-primary');
            $('#variante1 input').attr('checked', 'checked');
        });
        $('#variante2').on('click', function(){
            $('#variante1').removeClass('border-primary');
            $('#variante1 input').removeAttr('checked');
            $('#card-4').removeClass('d-none');
            $('#card-5').addClass('d-none');
            $('#card-6').addClass('d-none');
            $(this).addClass('border-primary');
            $('#variante2 input').attr('checked', 'checked');
        });

        // Gerando SKU
        $('.gerar').on('click', function(){
            $('.cod_sku').val(Math.random().toString(36).substring(3, 13).toUpperCase());
        });

         // Adicionando as categorias
         $('#produtos-categorias #formCategorias').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("categorias.salvar") }}',
                type: 'POST',
                data: $('#produtos-categorias #formCategorias').serialize(),
                beforeSend: function(){
                    $('#produtos-categorias #formCategorias').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                },
                success: function(data){
                    $('#produtos-categorias #formCategorias').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check" style="font-size:50px;"></i></div><h6 class="my-3">Categoria adicionada com sucesso!</h6></div>');
                    $('#listaCategorias').append('<option value="'+data.id+'">'+data.nome+'</option>');
                    setTimeout(function(){
                        $('#produtos-categorias #formCategorias').each (function(){
                            this.reset();
                        });
                        $('input').removeClass('border border-danger');
                        $('.carregamento').html('');
                        $('#produtos-categorias #formCategorias').removeClass('d-none');
                        $('#produtos-categorias').modal('hide');
                    }, 800);
                }, error: function (data) {
                    setTimeout(function(){
                        $('#produtos-categorias #formCategorias').removeClass('d-none');
                        $('.carregamento').html('');
                        if(!data.responseJSON){
                            console.log(data.responseText);
                            $('#produtos-categorias #err').html(data.responseText);
                        }else{
                            $('#produtos-categorias #err').html('');
                            $('input').removeClass('border border-danger');
                            $.each(data.responseJSON.errors, function(key, value){
                                $('#produtos-categorias #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                $('input[name="'+key+'"]').addClass('border border-danger');
                            });
                        }
                    }, 800);
                }
            });
        });

         // Adicionando as marcas
         $('#produtos-marcas #formMarcas').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("marcas.salvar") }}',
                type: 'POST',
                data: $('#produtos-marcas #formMarcas').serialize(),
                beforeSend: function(){
                    $('#produtos-marcas #formMarcas').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                },
                success: function(data){
                    $('#produtos-variantes #formVariantes').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check" style="font-size:50px;"></i></div><h6 class="my-3">Variação adicionada com sucesso!</h6></div>');
                    $('#listaVariacoes').append('<option value="'+data.id+'">'+data.nome+'</option>');
                    setTimeout(function(){
                        $('#produtos-variantes #formVariantes').each (function(){
                            this.reset();
                        });
                        $('input').removeClass('border border-danger');
                        $('.carregamento').html('');
                        $('#produtos-variantes #formVariantes').removeClass('d-none');
                        $('#produtos-variantes').modal('hide');
                    }, 800);
                }, error: function (data) {
                    setTimeout(function(){
                        $('#produtos-marcas #formMarcas').removeClass('d-none');
                        $('.carregamento').html('');
                        if(!data.responseJSON){
                            console.log(data.responseText);
                            $('#produtos-marca #err').html(data.responseText);
                        }else{
                            $('#produtos-marca #err').html('');
                            $('input').removeClass('border border-danger');
                            $.each(data.responseJSON.errors, function(key, value){
                                $('#produtos-marca #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                $('input[name="'+key+'"]').addClass('border border-danger');
                            });
                        }
                    }, 800);
                }
            });
        });

         // Adicionando as variantes
         $('#produtos-variantes #formVariantes').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("variacoes.salvar") }}',
                type: 'POST',
                data: $('#produtos-variantes #formVariantes').serialize(),
                beforeSend: function(){
                    $('.card-body #formAdicionar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                },
                success: function(data){
                    $('#produtos-variantes #formVariantes').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check" style="font-size:50px;"></i></div><h6 class="my-3">Variação adicionada com sucesso!</h6></div>');
                    setTimeout(function(){
                        $('#produtos-variantes #formVariantes').each (function(){
                            this.reset();
                        });
                        $('input').removeClass('border border-danger');
                        $('.carregamento').html('');
                        $('#produtos-variantes #formVariantes').removeClass('d-none');
                        $('#produtos-variantes').modal('hide');
                    }, 800);
                }, error: function (data) {
                    setTimeout(function(){
                        $('#produtos-variantes #formVariantes').removeClass('d-none');
                        $('.carregamento').html('');
                        if(!data.responseJSON){
                            console.log(data.responseText);
                            $('#produtos-variantes #err').html(data.responseText);
                        }else{
                            $('#produtos-variantes #err').html('');
                            $('input').removeClass('border border-danger');
                            $.each(data.responseJSON.errors, function(key, value){
                                $('#produtos-variantes #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                $('input[name="'+key+'"]').addClass('border border-danger');
                            });
                        }
                    }, 800);
                }
            });
        });

     });
 </script>
 @endsection
