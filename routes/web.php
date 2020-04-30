<?php

// Funções internas
Route::group(['prefix' => ''], function(){
    // Sem autenticação
    Route::get('', 'UsuariosCtrl@Login')->name('login');
    Route::post('redirect', 'UsuariosCtrl@Redirecionar')->name('redirect');
    Route::post('forwading', 'UsuariosCtrl@Forwarding')->name('encaminhar.password');
    Route::get('newpassword/{token}', 'UsuariosCtrl@NewPassword')->name('new.password');
    Route::post('alterando', 'UsuariosCtrl@Alterar')->name('alterando.password');
    
    // Autenticado
    Route::get('403', 'UsuariosCtrl@Acesso')->name('permission')->middleware('auth');
    Route::post('novo', 'UsuariosCtrl@PrimeiroAcesso')->name('novo')->middleware('auth');
    Route::get('logout', 'UsuariosCtrl@Sair')->name('logout')->middleware('auth');
    Route::get('perfil', 'UsuariosCtrl@Perfil')->name('perfil')->middleware('auth');
    Route::post('salvarPerfil', 'UsuariosCtrl@SalvarPerfil')->name('salvar.perfil')->middleware('auth');
    Route::get('activities', 'UsuariosCtrl@Atividades')->name('atividades')->middleware('auth');
    
    // Checkout
    Route::group(['prefix' => 'checkout'], function (){
        Route::get('{link}', 'CheckoutCtrl@Create')->name('checkout.create');
        Route::post('form1/{id}', 'CheckoutCtrl@Form1')->name('checkout.form1');
        Route::post('form2/{id}', 'CheckoutCtrl@Form2')->name('checkout.form2');
        Route::any('form3/{id}/', 'CheckoutCtrl@Form3')->name('checkout.form3');
        Route::any('form4/{id}', 'CheckoutCtrl@Form4')->name('checkout.form4');
        Route::get('detalhes/{documento}', 'CheckoutCtrl@DetalhesCliente')->name('checkout.clientes.detalhes');
        Route::post('endereco/{id}', 'CheckoutCtrl@UpdateEndereco')->name('checkout.endereco');
        Route::get('endereco/detalhes/{id}', 'CheckoutCtrl@DetalhesEndereco')->name('checkout.endereco.detalhes');
        Route::get('frete/{id}', 'CheckoutCtrl@CalculoFrete')->name('checkout.frete');
        Route::get('quantidade/{id}/{quantidade}', 'CheckoutCtrl@UpdateQuantidade')->name('checkout.quantidade');
        Route::get('parcelas/{valor}', 'CheckoutCtrl@ParcelasQuantidade')->name('checkout.parcelas');
        Route::get('descontos/{id}/{valor}', 'CheckoutCtrl@DescontosCheckout')->name('checkout.descontos');
    });
});

// Módulo 1
Route::group(['prefix' => 'home'], function (){
   Route::get('', 'UsuariosCtrl@Home')->name('home')->middleware('auth');
});

// Módulo 2
Route::group(['prefix' => 'dashboard'], function (){
    Route::get('', 'DashboardCtrl@Lista')->name('dashboard');
});

// Módulo 3
Route::group(['prefix' => 'pedidos'], function (){
    // Pedidos
    Route::group(['prefix' => ''], function (){
        Route::get('/', 'PedidosCtrl@Exibir')->name('pedidos.lista');
        Route::get('lista', 'PedidosCtrl@Lista')->name('pedidos.data');
        Route::get('detalhes/{id}', 'PedidosCtrl@Detalhe')->name('pedidos.detalhes');
        Route::post('status/{id}', 'PedidosCtrl@AtualizarStatus')->name('atualizar.status'); // Atualizar informações
        Route::post('notaFiscal/{id}', 'PedidosCtrl@AtualizarNota')->name('atualizar.nota');  // Atualizar informações
        Route::post('endereco/{id}', 'PedidosCtrl@AtualizarEndereco')->name('atualizar.endereco'); // Atualizar informações
        Route::post('rastreamento/{id}', 'PedidosCtrl@AtualizarRastreamento')->name('atualizar.rastreamento'); // Atualizar informações
    });

    // Carrinhos abandonados
    Route::group(['prefix' => 'carrinhos'], function (){
        Route::get('', 'CarrinhosCtrl@Exibir')->name('carrinhos.lista');
        Route::get('lista', 'CarrinhosCtrl@Lista')->name('carrinhos.data');
    });
    
    Route::post('filtros', 'PedidosCtrl@ListaFiltro')->name('pedidos.dataFiltro'); // Filtros
    Route::get('cancelar/{id}', 'PedidosCtrl@CancelarTransacao')->name('cancelar.transacao'); // Pagar Me
    Route::get('dadosCorreios/{id}', 'PedidosCtrl@DadosCorreios')->name('dados.correios'); // Correios 
});

// Módulo 4
Route::group(['prefix' => 'produtos'], function (){
    // Produtos
    Route::group(['prefix' => ''], function (){
        Route::get('/', 'ProdutosCtrl@Exibir')->name('produtos.lista');
        Route::get('lista', 'ProdutosCtrl@Lista')->name('produtos.data');
        Route::get('adicionar', 'ProdutosCtrl@Adicionar')->name('produtos.adicionar');
        Route::post('salvar', 'ProdutosCtrl@SalvarAdicionar')->name('produtos.salvar');
        Route::get('editar/{id}', 'ProdutosCtrl@Editar')->name('produtos.editar');
        Route::post('editando/{id}', 'ProdutosCtrl@SalvarEditar')->name('produtos.editando');
        Route::any('imagens', 'ProdutosCtrl@Imagens')->name('imagens.produtos');
        Route::any('removeImagem/{id}', 'ProdutosCtrl@RemoveImagens')->name('removeImagens.produtos');
    });
    // Categorias
    Route::group(['prefix' => 'categorias'], function (){
        Route::get('/', 'CategoriasCtrl@Exibir')->name('categorias.lista');
        Route::get('lista', 'CategoriasCtrl@Lista')->name('categorias.data');
        Route::get('adicionar', 'CategoriasCtrl@Adicionar')->name('categorias.adicionar');
        Route::post('salvar', 'CategoriasCtrl@SalvarAdicionar')->name('categorias.salvar');
        Route::get('editar/{id}', 'CategoriasCtrl@Editar')->name('categorias.editar');
        Route::post('editando/{id}', 'CategoriasCtrl@SalvarEditar')->name('categorias.editando');
        Route::get('detalhes/{id}', 'CategoriasCtrl@Detalhes')->name('detalhes.categorias');
    });
    // Marcas
    Route::group(['prefix' => 'marcas'], function (){
        Route::get('/', 'MarcasCtrl@Exibir')->name('marcas.lista');
        Route::get('lista', 'MarcasCtrl@Lista')->name('marcas.data');
        Route::get('adicionar', 'MarcasCtrl@Adicionar')->name('marcas.adicionar');
        Route::post('salvar', 'MarcasCtrl@SalvarAdicionar')->name('marcas.salvar');
        Route::get('editar/{id}', 'MarcasCtrl@Editar')->name('marcas.editar');
        Route::post('editando/{id}', 'MarcasCtrl@SalvarEditar')->name('marcas.editando');
    });
    // Variacões
    Route::group(['prefix' => 'variacoes'], function (){
        Route::get('/', 'VariacoesCtrl@Exibir')->name('variacoes.lista');
        Route::get('lista', 'VariacoesCtrl@Lista')->name('variacoes.data');
        Route::get('adicionar', 'VariacoesCtrl@Adicionar')->name('variacoes.adicionar');
        Route::post('salvar', 'VariacoesCtrl@SalvarAdicionar')->name('variacoes.salvar');
        Route::get('editar/{id}', 'VariacoesCtrl@Editar')->name('variacoes.editar');
        Route::post('editando/{id}', 'VariacoesCtrl@SalvarEditar')->name('variacoes.editando');
        Route::post('salvar/opcao', 'VariacoesCtrl@SalvarOpcao')->name('variacoes.opcao');
        Route::get('detalhes/{id}', 'VariacoesCtrl@Detalhes')->name('detalhes.variacoes');
    });
});

// Módulo 5
Route::group(['prefix' => 'clientes'], function (){
    // Clientes
    Route::group(['prefix' => ''], function (){
        Route::get('/', 'ClientesCtrl@Exibir')->name('clientes.lista');
        Route::get('lista', 'ClientesCtrl@Lista')->name('clientes.data');
        Route::get('adicionar', 'ClientesCtrl@Adicionar')->name('clientes.adicionar');
        Route::post('salvar', 'ClientesCtrl@SalvarAdicionar')->name('clientes.salvar');
        Route::get('editar/{id}', 'ClientesCtrl@Editar')->name('clientes.editar');
        Route::post('editando/{id}', 'ClientesCtrl@SalvarEditar')->name('clientes.editando');
    });
    // Grupos
    Route::group(['prefix' => 'grupos'], function (){
        Route::get('/', 'GruposCtrl@Exibir')->name('grupos.lista');
        Route::get('lista', 'GruposCtrl@Lista')->name('grupos.data');
        Route::get('adicionar', 'GruposCtrl@Adicionar')->name('grupos.adicionar');
        Route::post('salvar', 'GruposCtrl@SalvarAdicionar')->name('grupos.salvar');
        Route::get('editar/{id}', 'GruposCtrl@Editar')->name('grupos.editar');
        Route::post('editando/{id}', 'GruposCtrl@SalvarEditar')->name('grupos.editando');
    });
    // Leads
    Route::group(['prefix' => 'leads'], function (){
        Route::get('/', 'LeadsCtrl@Exibir')->name('leads.lista');
        Route::get('lista', 'LeadsCtrl@Lista')->name('leads.data');
        Route::get('adicionar', 'LeadsCtrl@Adicionar')->name('leads.adicionar');
        Route::post('salvar', 'LeadsCtrl@SalvarAdicionar')->name('leads.salvar');
        Route::get('editar/{id}', 'LeadsCtrl@Editar')->name('leads.editar');
        Route::post('editando/{id}', 'LeadsCtrl@SalvarEditar')->name('leads.editando');
    });
});

// Módulo 6

// Módulo 7

// Módulo 8
Route::group(['prefix' => 'configuracoes'], function (){
    // Configurações
    Route::group(['prefix' => ''], function (){
        Route::get('', 'ConfiguracoesCtrl@Configuracoes')->name('configuracoes');
    });
    // Carrinhos abandonados
    Route::group(['prefix' => 'carrinhos'], function (){
        Route::get('', 'ConfiguracoesCtrl@Carrinhos')->name('configuracoes.carrinhos');
        Route::post('salvar', 'ConfiguracoesCtrl@CarrinhosAtualizar')->name('configuracoes.carrinhos.salvar');
    });
    // Checkout
    Route::group(['prefix' => 'checkout'], function (){
        Route::get('', 'ConfiguracoesCtrl@Checkout')->name('configuracoes.checkout');
        Route::post('salvar', 'ConfiguracoesCtrl@CheckoutAtualizar')->name('configuracoes.checkout.salvar');
    });
    // E-mails transacionais
    Route::group(['prefix' => 'emails'], function (){
        Route::get('', 'ConfiguracoesCtrl@Emails')->name('configuracoes.emails');
        Route::post('salvar', 'ConfiguracoesCtrl@EmailsAtualizar')->name('configuracoes.emails.salvar');
    });
    // Status
    Route::group(['prefix' => 'status'], function (){
        Route::get('', 'ConfiguracoesCtrl@Status')->name('configuracoes.status');
        Route::get('listar', 'ConfiguracoesCtrl@StatusListar')->name('configuracoes.status.lista');
        Route::post('salvar/{id}', 'ConfiguracoesCtrl@StatusAtualizar')->name('configuracoes.status.salvar');
    });
    // Geral
    Route::group(['prefix' => 'geral'], function (){
        Route::get('', 'ConfiguracoesCtrl@Geral')->name('configuracoes.geral');
        Route::post('salvar', 'ConfiguracoesCtrl@GeralAtualizar')->name('configuracoes.geral.salvar');
    });
    // Integrações
    Route::group(['prefix' => 'integracoes'], function (){
        Route::get('', 'ConfiguracoesCtrl@Integracoes')->name('configuracoes.integracoes');
    });
    // Logística
    Route::group(['prefix' => 'logistica'], function (){
        Route::get('', 'ConfiguracoesCtrl@Logistica')->name('configuracoes.logistica');
        Route::any('listar', 'ConfiguracoesCtrl@LogisticaListar')->name('configuracoes.logistica.lista');
        Route::post('salvar', 'ConfiguracoesCtrl@LogisticaAdicionar')->name('configuracoes.logistica.adicionar');
        Route::post('editar/{id}', 'ConfiguracoesCtrl@LogisticaEditar')->name('configuracoes.logistica.editar');
        Route::get('remover/{id}', 'ConfiguracoesCtrl@LogisticaExcluir')->name('configuracoes.logistica.excluir');
    });
    // Segurança
    Route::group(['prefix' => 'seguranca'], function (){
        Route::get('', 'ConfiguracoesCtrl@Seguranca')->name('configuracoes.seguranca');
        Route::any('listar', 'ConfiguracoesCtrl@SegurancaListar')->name('configuracoes.seguranca.lista');
        Route::post('salvar', 'ConfiguracoesCtrl@SegurancaAdicionar')->name('configuracoes.seguranca.adicionar');
        Route::post('editar/{id}', 'ConfiguracoesCtrl@SegurancaEditar')->name('configuracoes.seguranca.editar');
        Route::get('remover/{id}', 'ConfiguracoesCtrl@SegurancaExcluir')->name('configuracoes.seguranca.excluir');
    });
    // Usuários
    Route::group(['prefix' => 'usuarios'], function (){
        Route::get('', 'ConfiguracoesCtrl@Usuarios')->name('configuracoes.usuarios');
        Route::any('listar', 'ConfiguracoesCtrl@UsuariosListar')->name('configuracoes.usuarios.lista');
        Route::post('adicionar', 'ConfiguracoesCtrl@UsuariosAdicionar')->name('configuracoes.usuarios.adicionar');
        Route::post('editar/{id}', 'ConfiguracoesCtrl@UsuariosEditar')->name('configuracoes.usuarios.editar');
        Route::get('remover/{id}', 'ConfiguracoesCtrl@UsuariosExcluir')->name('configuracoes.usuarios.excluir');
       
    });
    // Grupos de usuários
    Route::group(['prefix' => 'grupos'], function (){
        Route::get('', 'ConfiguracoesCtrl@Grupos')->name('configuracoes.grupos');
        Route::any('listar', 'ConfiguracoesCtrl@GruposListar')->name('configuracoes.grupos.lista');
        Route::post('adicionar', 'ConfiguracoesCtrl@GruposAdicionar')->name('configuracoes.grupos.adicionar');
        Route::post('editar/{id}', 'ConfiguracoesCtrl@GruposEditar')->name('configuracoes.grupos.editar');
        Route::get('remover/{id}', 'ConfiguracoesCtrl@GruposExcluir')->name('configuracoes.grupos.excluir');
    });
});




