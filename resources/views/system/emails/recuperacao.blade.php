<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<style>
		@media only screen and (max-width: 600px) {
			.inner-body {
				width: 100% !important;
			}

			.footer {
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 500px) {
			.button {
				width: 100% !important;
				margin-top: 20px; 
				margin-bottom: 20px;
			}
		}
		/* Base */
		body,
		body *:not(html):not(style):not(br):not(tr):not(code) {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
			'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
			box-sizing: border-box;
		}

		body {
			background-color: #f8fafc;
			color: #74787e;
			height: 100%;
			hyphens: auto;
			line-height: 1.4;
			margin: 0;
			-moz-hyphens: auto;
			-ms-word-break: break-all;
			width: 100% !important;
			-webkit-hyphens: auto;
			-webkit-text-size-adjust: none;
			word-break: break-all;
			word-break: break-word;
		}

		p,
		ul,
		ol,
		blockquote {
			line-height: 1.4;
			text-align: left;
		}

		a {
			color: #3869d4;
			text-decoration: none;
		}

		a img {
			border: none;
		}

		/* Typography */

		h1 {
			color: #3d4852;
			font-size: 19px;
			font-weight: bold;
			margin-top: 0;
			text-align: left;
		}

		h2 {
			color: #3d4852;
			font-size: 16px;
			font-weight: bold;
			margin-top: 0;
			text-align: left;
		}

		h3 {
			color: #3d4852;
			font-size: 14px;
			font-weight: bold;
			margin-top: 0;
			text-align: left;
		}

		p {
			color: #3d4852;
			font-size: 16px;
			line-height: 1.5em;
			margin-top: 0;
			text-align: left;
		}

		p.sub {
			font-size: 12px;
		}

		img {
			max-width: 100%;
		}

		/* Layout */

		.wrapper {
			background-color: #f8fafc;
			margin: 0;
			padding: 0;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.content {
			margin: 0;
			padding: 0;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		/* Header */

		.header {
			padding: 25px;
			text-align: center;
		}

		.header a {
			color: #bbbfc3;
			font-size: 19px;
			font-weight: bold;
			text-decoration: none;
			text-shadow: 0 1px 0 white;
		}

		/* Body */

		.body {
			background-color: #ffffff;
			border-bottom: 1px solid #edeff2;
			border-top: 1px solid #edeff2;
			margin: 0;
			padding: 0;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.inner-body {
			background-color: #ffffff;
			margin: 0 auto;
			padding: 0;
			width: 570px;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 570px;
		}

		/* Subcopy */

		.subcopy {
			border-top: 1px solid #edeff2;
			margin-top: 25px;
			padding-top: 25px;
		}

		.subcopy p {
			font-size: 12px;
		}

		/* Footer */

		.footer {
			margin: 0 auto;
			padding: 0;
			text-align: center;
			width: 570px;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 570px;
		}

		.footer p {
			color: #aeaeae;
			font-size: 12px;
			text-align: center;
		}

		/* Tables */

		.table table {
			margin: 30px auto;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.table th {
			border-bottom: 1px solid #edeff2;
			padding-bottom: 8px;
			margin: 0;
		}

		.table td {
			color: #74787e;
			font-size: 15px;
			line-height: 18px;
			padding: 10px 0;
			margin: 0;
		}

		.content-cell {
			padding: 35px;
		}

		/* Buttons */

		.action {
			margin: 30px auto;
			padding: 0;
			text-align: center;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.button {
			border-radius: 5px;
			box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
			color: #fff;
			display: inline-block;
			text-decoration: none;
			-webkit-text-size-adjust: none;
			margin-top: 20px; 
			margin-bottom: 20px;
		}

		.button-blue,
		.button-primary {
			background-color: #3490dc;
			border-top: 10px solid #3490dc;
			border-right: 18px solid #3490dc;
			border-bottom: 10px solid #3490dc;
			border-left: 18px solid #3490dc;
		}

		.button-green,
		.button-success {
			background-color: #38c172;
			border-top: 10px solid #38c172;
			border-right: 18px solid #38c172;
			border-bottom: 10px solid #38c172;
			border-left: 18px solid #38c172;
		}

		.button-red,
		.button-error {
			background-color: #e3342f;
			border-top: 10px solid #e3342f;
			border-right: 18px solid #e3342f;
			border-bottom: 10px solid #e3342f;
			border-left: 18px solid #e3342f;
		}

		/* Panels */

		.panel {
			margin: 0 0 21px;
		}

		.panel-content {
			background-color: #f1f5f8;
			padding: 16px;
		}

		.panel-item {
			padding: 0;
		}

		.panel-item p:last-of-type {
			margin-bottom: 0;
			padding-bottom: 0;
		}

		/* Promotions */

		.promotion {
			background-color: #ffffff;
			border: 2px dashed #9ba2ab;
			margin: 0;
			margin-bottom: 25px;
			margin-top: 25px;
			padding: 24px;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.promotion h1 {
			text-align: center;
		}

		.promotion p {
			font-size: 15px;
			text-align: center;
		}

		/* Utilities */

		.break-all {
			word-break: break-all;
		}

		.lin_resume{
			padding: 25px;
			padding-top: 10px;
			text-align: center!important;
		}
	</style>

	<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border: 1px solid #eaeef2;border-radius: 10px;">
		<tr>
			<td align="center">
				<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
					<tr>
						<td class="header">
							<a href="{{ config('app.url') }}">
								<img src="http://capsulbrasil.com.br/capsul/assets/img/logo.png" alt="Imagem logo" height="50">
							</a>
						</td>
					</tr>

					<!-- Email Body -->
					<tr>
						<td class="body" width="100%" cellpadding="0" cellspacing="0">
							<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
								<!-- Body content -->
								<tr>
									<td class="content-cell">
										<h1> Olá, {{ ucwords(strtolower(explode(" ", $usuario->nome)[0])) }}!</h1>
										<p>Você solicitou a redefinição de senha?</p>

										<p style="text-align:justify">
											<p>Recebemos sua solicitação de recuperação de senha através da nossa plataforma, para prosseguir o processo siga as etapas abaixo:</p>
											<div style="padding:0px 30px 0px 30px;">
												<p>
													<b>1.</b> Acesse  
													<a href="{{route('new.password', $usuario->_token)}}" target="_blank"><b>recuperar senha</b></a>.
												</p>
												<p>
													<b>2.</b> 
													Acessando o endereço acima, você será redirecionado a uma página de redefinição de senha, dentro da plataforma, onde você deverá cadastrar sua nova senha seguindo nossas regras de segurança.
												</p>
												<p>
													<b>3.</b> 
													Após redefinida sua nova senha, acesse o nosso portal e entre com suas credenciais.
												</p>
											</div>
										</p>

										<p><b>Caso não tenha solicitado a redefinição de senha pela plataforma, desconsidere este e-mail e tenha sigilo com suas credênciais.</b></p>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td>
							<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
								<tr>
									<td class="content-cell" align="center">
										<b>Equipe de suporte do {{ $geral->nome_loja }}!</b><br>
										<label>{{ $geral->email }}</label><br>
										<a href="{{ config('app.url') }}" target="_blank">{{ config('app.url') }}</a><br>
									</td>
								</tr>
							</table>
						</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
</body>
</html>
