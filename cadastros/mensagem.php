<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_mensagem = isset($_GET['co_mensagem']) ? $_GET['co_mensagem'] : '';

//echo $comando." - ".$co_mensagem."<br>";

$email_remetente = 'luzquebrilha@obralumen.org.br';

$no_titulo = isset($_POST['no_titulo']) ? $_POST['no_titulo'] : '';
$ic_modelo = isset($_POST['ic_modelo']) ? $_POST['ic_modelo'] : 'N';
$de_mensagem = isset($_POST['de_mensagem']) ? $_POST['de_mensagem'] : '';
$de_observacoes = isset($_POST['de_observacoes']) ? $_POST['de_observacoes'] : '';
$ic_situacao = isset($_POST['ic_situacao']) ? $_POST['ic_situacao'] : 'R';

/*	$mensagemHTML = '<html>';
	$mensagemHTML .= '<body style="font-family: Verdana; font-size: 12px; font-color: black;">';
	$mensagemHTML .= '<img src="http://www.obralumen.org.br/sistemas/imagens/lumen/imposto_renda_2017_2016.jpg" height="480" width="480">';
	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= 'Mais informações de como doar o imposto devido, para a Ação Social Lumen, em:';
	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= '<a href="http://www.obralumen.org.br/web/como-ajudar/doacao-do-imposto-de-renda/" target="_blank"><b>http://www.obralumen.org.br/web/como-ajudar/doacao-do-imposto-de-renda/</b></a>';
	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= 'Telefones: <b>(85) 9-9924-5999</b> / <b>(85) 9-9974-6106</b>';
	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= 'Emails: <a href="mailto:projetoluzquebrilha@gmail.com"><b>projetoluzquebrilha@gmail.com</b></a> / <a href="mailto:luzquebrilha@obralumen.org.br"><b>luzquebrilha@obralumen.org.br</b></a>';
	$mensagemHTML .= '</body>';
	$mensagemHTML .= '</html>';
$de_mensagem = $mensagemHTML;*/
	
//echo $ic_modelo." - ".$ic_situacao." - ".$no_titulo." - ".$de_mensagem." - ".$de_observacoes."<br>";

$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: $email_remetente\r\n";
$headers .= "Return-Path: $email_remetente\r\n";

//$comando = '';
if (($comando == '') && ($co_mensagem != '')) {
	$sql = "SELECT * FROM mensagens WHERE (co_mensagem = ".$co_mensagem."); ";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$campo = mysql_fetch_array($rs);
			$no_titulo = utf8_encode($campo["no_titulo"]);
			$ic_modelo = $campo["ic_modelo"];
			$de_mensagem = utf8_encode($campo["de_mensagem"]);
			$de_mensagem = substr($de_mensagem,5,strlen($de_mensagem)-11);
			$de_observacoes = utf8_encode($campo["de_observacoes"]);
			$ic_situacao = $campo["ic_situacao"];
		}
	}
	
	//echo $ic_modelo." - ".$ic_situacao." - ".$no_titulo." - ".$de_mensagem." - ".$de_observacoes."<br>";
} else if (($comando == 'salvar') || ($comando == 'enviar')) {
	$sql = "SELECT MAX(co_mensagem) AS maximo FROM mensagens;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_mensagem_maximo = $campo["maximo"] + 1;
		}
	}
	//echo $comando." - ".$co_mensagem_maximo."<br>";
	
	if (($comando == 'salvar') && ($co_mensagem != '')) {
		$comando = 'atualizar';
	}
	
	//echo $comando." - ".$co_mensagem."<br>";

	$de_mensagem = "<pre>".$de_mensagem."</pre>";
	//echo $de_mensagem."<br>";
	if ($comando == 'salvar') {
		$sql = "INSERT INTO mensagens (co_mensagem, no_titulo, ic_modelo, de_mensagem, de_observacoes, ic_situacao, dt_mensagem, hr_mensagem) ";
		$sql = $sql."VALUES (".$co_mensagem_maximo.",'".utf8_decode($no_titulo)."','".$ic_modelo."','".utf8_decode($de_mensagem)."','".utf8_decode($de_observacoes)."','".$ic_situacao."',CURRENT_DATE, CURRENT_TIME); ";
		$rs = mysql_query($sql);
		if (!$rs) {
		//	echo utf8_encode($sql)."<br>";
		}
		$sql2 = "INSERT INTO mensagens_emails (co_mensagem, co_pessoa, no_email, ic_situacao) ";
		$sql2 = $sql2."SELECT DISTINCT '".$co_mensagem_maximo."', co_pessoa, no_email, 'R' FROM pessoas_emails WHERE (co_pessoa = 1) ORDER BY co_pessoa, no_email; ";
		$rs2 = mysql_query($sql2);
		if (!$rs2) {
		//	echo utf8_encode($sql2)."<br>";
		}
		if (($rs) && ($rs2)) {
			?><script>window.alert('A mensagem foi salva com sucesso!');</script><?
		} else {
			?><script>window.alert('A mensagem não pode ser salva, por favor tente novamente!');</script><?
		}
	} else if ($comando == 'atualizar') {
		$sql = "UPDATE mensagens ";
		$sql = $sql."SET no_titulo = '".utf8_decode($no_titulo)."', ";
		$sql = $sql."    ic_modelo = '".$ic_modelo."', ";
		$sql = $sql."    de_mensagem = '".utf8_decode($de_mensagem)."', ";
		$sql = $sql."    de_observacoes = '".utf8_decode($de_observacoes)."', ";
		$sql = $sql."    dt_mensagem = CURRENT_DATE, ";
		$sql = $sql."    hr_mensagem = CURRENT_TIME ";
		$sql = $sql."WHERE (co_mensagem = ".$co_mensagem."); ";
		$rs = mysql_query($sql);
		if (!$rs) {
		//	echo utf8_encode($sql)."<br>";
		}
		$sql2 = "DELETE FROM mensagens_emails WHERE (co_mensagem = ".$co_mensagem."); ";
		$rs2 = mysql_query($sql2);
		if (!$rs2) {
		//	echo utf8_encode($sql2)."<br>";
		}
		$sql3 = "INSERT INTO mensagens_emails (co_mensagem, co_pessoa, no_email, ic_situacao) ";
		$sql3 = $sql3."SELECT DISTINCT '".$co_mensagem."', co_pessoa, no_email, 'R' FROM pessoas_emails WHERE (co_pessoa = 1) ORDER BY co_pessoa, no_email; ";
		$rs3 = mysql_query($sql3);
		if (!$rs3) {
		//	echo utf8_encode($sql3)."<br>";
		}
		if (($rs) && ($rs2) && ($rs3)) {
			?><script>window.alert('A mensagem foi atualizada com sucesso!');</script><?
		} else {
			?><script>window.alert('A mensagem não pode ser atualizada, por favor tente novamente!');</script><?
		}
	} else if ($comando == 'enviar') {
		if ($ic_modelo == 'S') {
			$sql = "INSERT INTO mensagens (co_mensagem, no_titulo, ic_modelo, de_mensagem, de_observacoes, ic_situacao, dt_mensagem, hr_mensagem) ";
			$sql = $sql."VALUES (".$co_mensagem_maximo.",'".utf8_decode($no_titulo)."','N','".utf8_decode($de_mensagem)."','".utf8_decode($de_observacoes)."','E',CURRENT_DATE, CURRENT_TIME); ";
			$rs = mysql_query($sql);
			if (!$rs) {
			//	echo utf8_encode($sql)."<br>";
			}
			$sql2 = "INSERT INTO mensagens_emails (co_mensagem, co_pessoa, no_email, ic_situacao) ";
			$sql2 = $sql2."SELECT DISTINCT '".$co_mensagem_maximo."', co_pessoa, no_email, 'P' FROM pessoas_emails WHERE (co_pessoa = 1) ORDER BY co_pessoa, no_email; ";
			$rs2 = mysql_query($sql2);
			if (!$rs2) {
			//	echo utf8_encode($sql2)."<br>";
			}
		} else if ($ic_situacao == 'R') {
			$sql = "UPDATE mensagens ";
			$sql = $sql."SET no_titulo = '".utf8_decode($no_titulo)."', ";
			$sql = $sql."    ic_modelo = '".$ic_modelo."', ";
			$sql = $sql."    de_mensagem = '".utf8_decode($de_mensagem)."', ";
			$sql = $sql."    de_observacoes = '".utf8_decode($de_observacoes)."', ";
			$sql = $sql."    ic_situacao = 'E', ";
			$sql = $sql."    dt_mensagem = CURRENT_DATE, ";
			$sql = $sql."    hr_mensagem = CURRENT_TIME ";
			$sql = $sql."WHERE (co_mensagem = ".$co_mensagem."); ";
			$rs = mysql_query($sql);
			if (!$rs) {
			//	echo utf8_encode($sql)."<br>";
			}
			$sql2 = "DELETE FROM mensagens_emails WHERE (co_mensagem = ".$co_mensagem."); ";
			$rs2 = mysql_query($sql2);
			if (!$rs2) {
			//	echo utf8_encode($sql2)."<br>";
			}
			$sql3 = "INSERT INTO mensagens_emails (co_mensagem, co_pessoa, no_email, ic_situacao) ";
			$sql3 = $sql3."SELECT DISTINCT '".$co_mensagem."', co_pessoa, no_email, 'P' FROM pessoas_emails WHERE (co_pessoa = 1) ORDER BY co_pessoa, no_email; ";
			$rs3 = mysql_query($sql3);
			if (!$rs3) {
			//	echo utf8_encode($sql3)."<br>";
			}
		}
		//echo $rs1." - ".$rs2." - ".$rs3."<br>";
		if (($rs) && ($rs2) && ($rs3)) {
			?><script>window.alert('A mensagem será enviada em instantes!');</script><?
		} else {
			?><script>window.alert('A mensagem não poderá ser enviada, por favor tente novamente!');</script><?
		}
	}

	$no_titulo = '';
	$ic_modelo = '';
	$de_mensagem = '';
	$de_observacoes = '';
	$ic_situacao = '';
}
?>

<script language="javascript">
	function mensagem (msg, acao) {
		if (document.forms["form"]["no_titulo"].value == '') {
			window.alert('Favor preencher o TÍTULO da mensagem!');
		} else if (document.forms["form"]["de_mensagem"].value == '') {
			window.alert('Favor preencher o conteúdo da MENSAGEM!');
		} else {
			abrir(form,1,'mensagem.php','co_mensagem=' + msg + '&comando=' + acao);
		}
	}
</script>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	Mensagem por E-mail<br>
</font>

<br>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td align="left" valign="middle">
			<input type="button" id="botao_salvar_mensagem" name="botao_salvar_mensagem" value="Salvar" class="botao" onClick="mensagem('<?=$co_mensagem?>','salvar');">
<?
		if ($co_mensagem != '') {
?>
			<input type="button" id="botao_enviar_mensagem" name="botao_enviar_mensagem" value="Enviar" class="botao" onClick="mensagem('<?=$co_mensagem?>','enviar');">
<?
		}
?>
		</td>
	</tr>
</table>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">CONTEÚDO</font></legend>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td align="right" valign="middle">
			<font class="font10azul">Título:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_titulo" value="<?=$no_titulo?>" placeholder="digite aqui o título da mensagem" size="117" maxlength="120">
		</td>
	</tr>
	<tr>
		<td align="right" valign="middle">
			<font class="font10azul">Mensagem Modelo?:</font>
		</td>
		<td align="left" valign="middle">
			<select name="ic_modelo">
<?
			if ($ic_modelo == 'S') {
?>					
				<option value="S" selected>SIM
				<option value="N">NÃO
<?
			} else {
?>
				<option value="S">SIM
				<option value="N" selected>NÃO
<?
			}
?>
		</td>
	</tr>
	<tr>
		<td align="right" valign="middle">
			<font class="font10azul">Mensagem:</font>
		</td>
		<td align="left" valign="middle">
			<textarea name="de_mensagem" rows="10" cols="100" placeholder="digite aqui a mensagem"><?=$de_mensagem?></textarea>
		</td>
	</tr>
	<tr>
		<td align="right" valign="middle">
			<font class="font10azul">Observações:</font>
		</td>
		<td align="left" valign="middle">
			<textarea name="de_observacoes" rows="3" cols="100" placeholder="digite aqui alguma observação para histórico, que não será enviada na mensagem"><?=$de_observacoes?></textarea>
		</td>
	</tr>
</table>

</fieldset>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td align="left" valign="middle">
			<input type="button" id="botao_salvar_mensagem" name="botao_salvar_mensagem" value="Salvar" class="botao" onClick="mensagem('<?=$co_mensagem?>','salvar');">
<?
		if ($co_mensagem != '') {
?>
			<input type="button" id="botao_enviar_mensagem" name="botao_enviar_mensagem" value="Enviar" class="botao" onClick="mensagem('<?=$co_mensagem?>','enviar');">
<?
		}
?>
		</td>
	</tr>
</table>

</div>