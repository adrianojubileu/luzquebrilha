<script language="javascript">
	function logon () {
		var login = document.getElementById('no_login');
		var senha = document.getElementById('no_senha');
		if (login.value == '') {
			if (senha.value == '') {
				alert('Preencha os campos LOGIN (E-mail ou Celular ou CPF ou CNPJ) e SENHA!');
			} else {
				alert('Preencha o campo LOGIN (E-mail ou Celular ou CPF ou CNPJ)!');
			}
		} else {
			if (senha.value == '') {
				alert('Preencha o campo SENHA!');
			} else {
				abrir(form,0,'','ic_login=logon');
			}
		}
	}
	function logoff () {
		abrir(form,0,'','ic_login=logoff&co_pessoa_login=&co_pessoa=');
	}
	function email_enviar_senha () {
		var login = document.getElementById('no_login');
		if (login.value == '') {
			alert('Preencha o campo LOGIN com o E-MAIL PRINCIPAL cadastrado para receber a SENHA!');
		} else {
			abrir(form,0,'email_enviar_senha.php','co_pessoa_login=&co_pessoa=');
		}
	}
</script>

<table width="100%" height="100%" cellpadding="0" cellspacing="0" margin="0">
	<tr width="100%" height="100%" bgcolor="#0b3b9d">
		<td align="center" valign="middle">
			<table width="95%" height="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" align="left" valign="middle">
						<font style="font-family:Verdana; color:#FFFFFF; font-size:10pt; font-weight:bold;">
							Obra Lumen de Evangelização
						</font>
					</td>
					<td width="75%" align="right" valign="middle">
						<font style="font-family:Verdana; color:#FFFFFF; font-size:10pt; font-weight:bold;">
<?
						if ($ic_login != 'sim') {
?>
							Login: <input type="text" id="no_login" name="no_login" placeholder="E-mail ou Celular ou CPF ou CNPJ" size="28">
							Senha: <input type="password" id="no_senha" name="no_senha" placeholder="Senha" size="12" maxlength="15">
							<input type="button" id="botao_entrar" name="botao_entrar" value="entrar" class="botao" onClick="logon();">
							<input type="button" id="botao_cadastre_se" name="botao_cadastre_se" value="cadastre-se" class="botao" onClick="abrir(form,1,'cadastro.php','co_pessoa_login=&co_pessoa=');">
							<input type="button" id="botao_esqueci_minha_senha" name="botao_esqueci_minha_senha" value="esqueci minha senha" class="botao" onClick="email_enviar_senha();">
<?
						} elseif ($ic_login == 'sim') {
?>
							Olá, <?=utf8_decode($no_pessoa_login)?>!
							<input type="button" id="botao_meu_cadastro" name="botao_meu_cadastro" value="meu cadastro" class="botao" onClick="abrir(form,1,'cadastro.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
							<input type="button" id="botao_sair" name="botao_sair" value="sair" class="botao" onClick="logoff();">
<?
						}
?>
						</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
