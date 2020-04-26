<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsParaEnvioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails_para_envio', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('identificador');
            $table->longText('descricao')->nullable();
            $table->longText('corpo')->nullable();

            $table->timestamps();
        });

        DB::table('emails_para_envio')->insert(
            array([   
                'nome' => 'E-mail de recuperação',
                'identificador' => 'recuperacao',
                'descricao' => 'E-mail de recuperação de senha.',
                'corpo' => '<div> <table width="660" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF" style="border-radius:5px;border:1px solid #dddddd"> <tbody> <tr bgcolor="#f4f4f4"> <td> <table> <tbody> <tr> <td style="padding:15px 15px 15px 30px"><img src="http://capsulbrasil.com.br/capsul/assets/img/logo.png" alt="" height="50px"> </td> </tr> </tbody> </table> </td> </tr> <tr> <td style="padding:30px 30px 20px 30px;border-radius:5px"> <table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF"> <tbody> <tr> <td align="left" id="m_42936987098664594m_1127568141554999x_content-5" style="font-size:15px;font-family:Helvetica,Arial,sans-serif;line-height:25px;color:#222222"> <div><span> <p style="margin-top:0px;margin-bottom:10px"> </p><p><b>Olá, {{$user->nome}}, você solicitou a redefinição de senha?</b></p> <p style="text-align:justify"> <label>Recebemos sua solicitação de recuperação de senha através da nossa plataforma, para prosseguir o processo siga as etapas a abaixo:</label> <br> <div style="padding:0px 30px 0px 30px;"> <label><b>1.</b> Acesse o link <a href="#"><b>Recuperar senha</b></a></label>. <br> <label><b>2.</b> Acessando o link acima irar te encaminhar para página de redefinição de senha na plataforma Capsul, onde você deverá cadastrar sua nova senha seguindo nossas regras de segurança.</label> <br> <label><b>3.</b> Após redefinida sua nova senha, acesse o nosso portal e entre com sua credenciais .</label> </div> </p> <p style="margin-top:10px;margin-bottom:10px"><span style="color:rgb(0,0,0)"><span></span></span></p> <p></p><p></p></span></div> </td> </tr> </tbody> </table> <div> <div> <div id="m_42936987098664594q_75" aria-label="Ocultar conteúdo expandido" aria-expanded="true"> <div></div> </div> </div> <div> <table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF"> <tbody> <tr> <td height="30" style="border-top:1px solid #dddddd"></td> </tr> </tbody> </table> <table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF"> <tbody> <tr> <td align="left"> <table cellpadding="0" border="0" cellspacing="0" align="left"> <tbody> <tr> <td align="left" id="m_42936987098664594m_1127568141554999x_content-9" style="font-size:14px;font-family:Helvetica,Arial,sans-serif;line-height:23px;color:#222222;width:100%"> <div> <p style="margin-top:0px;margin-bottom:10px"> <b>Um grande abraço da equipe Capsu!</b><br> <a href="http://grupocapsul.com.br/" target="_blank">grupocapsul.com.br</a><br> </p> </div> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#ffffff"> <tbody> <tr> <td height="20"></td> </tr> </tbody> </table> </div> </div> </td> </tr> </tbody> </table> </div>', ]
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
        Schema::dropIfExists('emails_para_envio');
    }
}
