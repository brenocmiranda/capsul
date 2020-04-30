<html>
<body>
	<div>
		<table width="400" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF" style="border-radius:5px;border:1px solid #dddddd">
			<tbody>
				<tr bgcolor="#f4f4f4">
					<td style="padding:15px 15px 15px 30px"><img src="http://capsulbrasil.com.br/capsul/assets/img/logo.png" alt="" height="40">
				</tr>
				<tr>
					<td style="padding:30px 30px 20px 30px;border-radius:5px">
						<table width="500" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
							<tbody>
								<tr>
									<td align="left" style="font-size:15px;font-family:Helvetica,Arial,sans-serif;line-height:25px;color:#222222">

										<div>
											<p style="margin-top:0px;margin-bottom:10px">
												<b>Olá, {{explode(" ", $user->nome)[0]}}, você solicitou a redefinição de senha?</b>
											</p>
											<p style="text-align:justify">
												<label>Recebemos sua solicitação de recuperação de senha através da nossa plataforma, para prosseguir o processo siga as etapas abaixo:</label>
												<br>
												<div style="padding:0px 30px 0px 30px;">
													<label>
														<b>1.</b> Acesse  
														<a href="{{route('new.password', $user->_token)}}"><b>recuperar senha</b></a>
													</label>.
													<br>
													<br>
													<label>
														<b>2.</b> 
														Acessando o link acima irar te encaminhar para uma página de redefinição de senha dentro da plataforma CompreCá, onde você deverá cadastrar sua nova senha seguindo nossas regras de segurança.
													</label>
													<br>
													<br>
													<label>
														<b>3.</b> 
														Após redefinida sua nova senha, acesse o nosso portal e entre com suas credenciais.
													</label>
												</div>
											</p>
										</div>											

									</td>
								</tr>
							</tbody>
						</table>

						<hr style="margin-top:30px;margin-bottom:20px" bgcolor="#dddddd">

						<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
							<tbody>
								<tr>
									<td align="left">
										<table cellpadding="0" border="0" cellspacing="0" align="left">
											<tbody>
												<tr>
													<td align="left" id="x_m_42936987098664594m_1127568141554999x_content-9" style="font-size:14px; font-family:Helvetica,Arial,sans-serif; line-height:23px; color:#222222; width:100%">
														<div>
															<p style="margin-top:0px; margin-bottom:10px"><b>Grupo Capsul</b><br>
																<label>{{$emails->email_remetente}}</label><br>
																<a href="http://grupocapsul.com.br/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable">grupocapsul.com.br</a><br>
															</p>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>

					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>