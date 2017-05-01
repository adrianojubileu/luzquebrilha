<table width="100%" height="55" cellpadding="0" cellspacing="0">
	<tr width="100%" height="100%" bgcolor="#0b3b9d">
		<td align="center" valign="middle">
			<table width="95%" height="100%" cellpadding="1" cellspacing="1">
<?
			if ($co_perfil_login == '5') {
?>
				<tr width="100%" height="100%">
<?
			} else {
?>
				<tr>
<?
			}
?>
					<td align="left" valign="middle">
<?
					if ($co_perfil_login != '') {
?>
						<input type="button" class="botao" value="principal" onClick="abrir(form,'','','');">
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="meu cadastro" onClick="abrir(form,1,'cadastro.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="<?=utf8_encode('minhas contribuições')?>" onClick="abrir(form,1,'contribuicoes.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="meus boletos" onClick="abrir(form,3,'boletos.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
<?
					} else {
?>
						<input type="button" class="botao" value="<?=utf8_encode('boleto online')?>" onClick="abrir(form,3,'boletos_simples.php','co_pessoa_login=&co_pessoa=');">
<?
					}
?>
					</td>
<?
				if ($co_perfil_login == '5') {
?>
					<td align="left" valign="middle">
<?
				} else {
?>
					<td align="left" valign="middle" rowspan="2">
<?
				}
?>
                        &nbsp&nbsp&nbsp&nbsp&nbsp
                        <input type="hidden" name="currency" value="BRL" />
                        <input type="hidden" name="receiverEmail" value="projetoluzquebrilha@gmail.com" />
                        <input type="hidden" name="iot" value="button" />
                        <input type="image" class="botao" src="https://stc.pagseguro.uol.com.br/public/img/botoes/doacoes/160x20-doar.gif" name="submit" alt="Pague com PagSeguro!" onClick="abrir(form,1,'pagseguro','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');" />
					</td>
				</tr>
<?
			if (($co_perfil_login != '') && ($co_perfil_login != '5')) {
?>
				<tr>
					<td align="left" valign="middle">
						<input type="button" class="botao" value="cadastros" onClick="abrir(form,1,'cadastro_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>&pesquisa=');">
<?
						if (($co_perfil_login == '1') || ($co_perfil_login == '2')) {
?>
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="<?=utf8_encode('contribuições')?>" onClick="abrir(form,1,'contribuicoes_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="boletos" onClick="abrir(form,3,'boletos_gerais.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="<?=utf8_encode('relatórios')?>" onClick="abrir(form,2,'relatorios.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
<?
						}
						if ($co_perfil_login == '1') {
?>
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="tabelas" onClick="abrir(form,1,'tabelas.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="nova mensagem" onClick="abrir(form,1,'mensagem.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="listar mensagens" onClick="abrir(form,1,'mensagem.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">
<?
						}
?>						
<!--
						&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="button" class="botao" value="FINANCEIRO" onClick="location.href='http://financeiro.obralumen.org.br/principal.php?co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>';">
-->
					</td>
				</tr>
<?
			}
?>
			</table>
		</td>
	</tr>
</table>