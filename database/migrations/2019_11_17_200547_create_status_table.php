<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->boolean('enviar')->default('1');
            $table->string('nome');
            $table->longText('descricao')->nullable();
            $table->integer('posicao')->unique();
            $table->timestamps();
        });

        DB::table('status')->insert(
            array(
                [   
                'nome' => 'Pedido autorizado',
                'descricao' => 'Recebemos o seu pedido e estamos aguardando a confirmação do pagamento. Enviaremos um novo e-mail a cada mudança no andamento do seu pedido.',
                'posicao' => '1',
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s")
                ],[   
                'nome' => 'Aguardando pagamento',
                'descricao' => 'Recebemos seu pedido. Somente quando recebermos a confirmação, em até 48h após o pagamento, seguiremos com o envio das suas compras. O prazo de entrega passa a ser contado somente após a confirmação do pagamento.',
                'posicao' => '2',
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s")
                ],[
                'nome' => 'Pagamento aprovado',
                'descricao' => 'O pagamento do seu pedido foi aprovado. Agradecemos sua preferência por nossa loja. A partir de agora, você será notificado por e-mail sobre o andamento do seu pedido até a chegada no endereço escolhido',
                'posicao' => '3',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
                ],[
                'nome' => 'Pagamento não autorizado',
                'descricao' => 'O seu pagamento não foi autorizado pelo meio de pagamento, tente novamente.',
                'posicao' => '4',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
                ],[
                'nome' => 'Produtos em separação',
                'descricao' => 'Seu pedido está sendo separado e embalado com todo carinho e cuidado especialmente para você. Assim que esta etapa for concluída, você receberé um e-mail informando o envio do produto e o código para que possa acompanhar a entrega.',
                'posicao' => '5',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
                ],[
                'nome' => 'Faturado',
                'descricao' => 'O seu pedido foi faturado.',
                'posicao' => '6',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
                ],[
                'nome' => 'Em transporte',
                'descricao' => 'O seu pedido foi encaminhado com sucesso. Segue abaixo o código de rastreio para que você possa acompanhar a entrega: Lembrando que pode demorar até 5 dias para atualizar o código pela primeira vez.',
                'posicao' => '7',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
                ],[
                'nome' => 'Entregue',
                'descricao' => 'Informamos que recebemos a confirmação de entrega do seu pedido.',
                'posicao' => '8',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
                ],[
                'nome' => 'Cancelado',
                'descricao' => 'O seu pedido foi cancelado.',
                'posicao' => '9',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
