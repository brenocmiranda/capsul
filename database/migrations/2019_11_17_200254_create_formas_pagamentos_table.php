<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormasPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formas_pagamentos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('cod')->nullable();

            $table->timestamps();
        });

        DB::table('formas_pagamentos')->insert(
            array([ 
                'nome' => 'Cartão de crédito',
                'cod' => 'credit_card',
                'created_at' => '2019-12-04 00:00:00',
                'updated_at' => '2019-12-04 22:18:40'
            ],[ 
                'nome' => 'Boleto',
                'cod' => 'boleto',
                'created_at' => '2019-12-04 00:00:00',
                'updated_at' => '2019-12-04 22:18:40'
            ])
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formas_pagamentos');
    }
}
