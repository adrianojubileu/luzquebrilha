<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';

$email_remetente = 'luzquebrilha@obralumen.org.br';

$assunto = isset($_POST['assunto']) ? $_POST['assunto'] : '';
$mensagem = isset($_POST['mensagem']) ? $_POST['mensagem'] : '';

$assunto = 'Obra Lumen - Contribua por meio da sua Declaração de Imposto de Renda';

//if ($mensagem != '') {
	$mensagemHTML = '<html>';
	$mensagemHTML .= '<body style="font-family: Verdana; font-size: 12px; font-color: black;">';
//	$mensagemHTML .= '<p><font size="3" color="blue"><b>'.$assunto.'</b></font></p>';
	$mensagemHTML .= '<img src="http://www.obralumen.org.br/sistemas/imagens/lumen/imposto_renda_2017_2016.jpg" height="480" width="480">';
	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= 'Mais informações de como doar o imposto devido, para a Ação Social Lumen, em:';
	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= '<a href="http://www.obralumen.org.br/web/como-ajudar/doacao-do-imposto-de-renda/" target="_blank"><b>http://www.obralumen.org.br/web/como-ajudar/doacao-do-imposto-de-renda/</b></a>';
	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= 'Telefones: <b>(85) 9-9924-5999</b> / <b>(85) 9-9974-6106</b>';
	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= 'Emails: <a href="mailto:projetoluzquebrilha@gmail.com"><b>projetoluzquebrilha@gmail.com</b></a> / <a href="mailto:luzquebrilha@obralumen.org.br"><b>luzquebrilha@obralumen.org.br</b></a>';
//	$mensagemHTML .= $mensagem;
//	$mensagemHTML .= '<br><br>';
//	$mensagemHTML .= '<p><font size="3" color="blue"><b>Luz e Paz!</b></font></p>';
//	$mensagemHTML .= '<p><font size="3" color="blue"><b>Obra Lumen de Evangelização - Projeto Luz que Brilha</b></font></p>';
//	$mensagemHTML .= '<br><br>';
	$mensagemHTML .= '</body>';
	$mensagemHTML .= '</html>';
//}

$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: $email_remetente\r\n";
$headers .= "Return-Path: $email_remetente\r\n";

$qtd_emails_maximo = 350;
$sql = "SELECT COUNT(DISTINCT no_email) AS emails FROM pessoas_emails;";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$emails = $campo["emails"];
		echo number_format($emails, 0, ',', '.').' emails<br>';
	}
}

//if ($comando == 'enviar') {

	$no_email = '';
	$no_email = 'adrianojubileu@gmail.com';
	//$no_email = 'lilianandradeamaral@gmail.com';
	
	if ($no_email != '') {
		$co_mensagem_maximo = 1;
		$sql = "SELECT MAX(co_email) AS maximo FROM emails;";
		$rs = mysql_query($sql);

		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$co_mensagem_maximo = $campo["maximo"] + 1;
			}
			
			$sql2 = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
			$rs2 = mysql_query($sql2);
			if ($rs2) {
				
				$campo2 = mysql_fetch_array($rs2);
				$qtd_emails = $campo2["qtd_emails"];
				if ($qtd_emails < $qtd_emails_maximo) {
					
					$envio = mail($no_email, $assunto, $mensagemHTML, $headers);
					if ($envio) {
						
						$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email, co_pessoa, ic_situacao) ";
						$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email."','".$assunto."','".$mensagemHTML."','informativo_enviado',1,1); ";
						$rs3 = mysql_query($sql3);
						if ($rs3) {
							?><script>window.alert('Mensagem enviada para o e-mail "<?=$no_email?>" com sucesso!');</script><?
						} else {
							?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
						}
					} else {
						?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
					}
				} else {
					?><script>window.alert('O limite de emails enviados é de 350 e-mails por hora, e ele já foi excedido. Tente novamente daqui alguns minutos!');</script><?
				}
			} else {
				?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
			}
		} else {
			?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
		}
	}

	$sql = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
	$rs = mysql_query($sql);
	$rs = false;
	if ($rs) {
		$campo = mysql_fetch_array($rs);
		$qtd_emails = $campo["qtd_emails"];
		if ($qtd_emails < $qtd_emails_maximo) {
			$primeiro_email = 0;
			$limite = $qtd_emails_maximo - $qtd_emails;
			$sql2 = "SELECT DISTINCT no_email, co_pessoa FROM pessoas_emails ORDER BY no_email ASC LIMIT ".$limite." OFFSET ".$primeiro_email.";";
			$rs2 = mysql_query($sql2);
			if ($rs2) {
				if (mysql_num_rows($rs2) > 0) {
					$msg = 1;
					while (($msg <= mysql_num_rows($rs2)) && ($qtd_emails <= $qtd_emails_maximo)) {
						$campo2 = mysql_fetch_array($rs2);
						$no_email = $campo2["no_email"];
						$pessoa_email = $campo2["co_pessoa"];
						if ($no_email != '') {
							echo $msg.' - '.$no_email.'<br>';
							$sql3 = "SELECT MAX(co_email) AS maximo FROM emails;";
							$rs3 = mysql_query($sql3);
							if ($rs3) {
								if (mysql_num_rows($rs3) > 0) {
									$campo3 = mysql_fetch_array($rs3);
									$co_mensagem_maximo = $campo3["maximo"] + 1;
								}
								$envio = mail($no_email, $assunto, $mensagemHTML, $headers);
								if ($envio) {
									$sql4 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email, co_pessoa, ic_situacao) ";
									$sql4 = $sql4."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$email_destinatario."','".$assunto."','".$mensagemHTML."','esqueci_minha_senha',".$pessoa_email.",1); ";
									$rs4 = mysql_query($sql4);
									$msg = $msg + 1;
									$qtd_emails = $qtd_emails + 1;
								}
							}
						}
					}
					?><script>window.alert('<?=($msg - 1)?> mensagens enviadas para os e-mails com sucesso!');</script><?
				}
			} else {
				?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
			}
		} else {
			?><script>window.alert('O limite de emails enviados é de 350 e-mails por hora, e ele já foi excedido. Tente novamente daqui alguns minutos!');</script><?
		}
	}

	$no_email = '';
	//$no_email = 'marcos_malmeida@yahoo.com.br';
	if ($no_email != '') {
		$co_mensagem_maximo = 1;
		$sql = "SELECT MAX(co_email) AS maximo FROM emails;";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$co_mensagem_maximo = $campo["maximo"] + 1;
			}
			$sql2 = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
			$rs2 = mysql_query($sql2);
			if ($rs2) {
				$campo2 = mysql_fetch_array($rs2);
				$qtd_emails = $campo2["qtd_emails"];
				if ($qtd_emails < $qtd_emails_maximo) {
					$envio = mail($no_email, $assunto, $mensagemHTML, $headers);
					if ($envio) {
						$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email, co_pessoa, ic_situacao) ";
						$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email."','".$assunto."','".$mensagemHTML."','informativo_enviado',4,1); ";
						$rs3 = mysql_query($sql3);
						if ($rs3) {
							?><script>window.alert('Mensagem enviada para o e-mail "<?=$no_email?>" com sucesso!');</script><?
						} else {
							?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
						}
					} else {
						?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
					}
				} else {
					?><script>window.alert('O limite de emails enviados é de 350 e-mails por hora, e ele já foi excedido. Tente novamente daqui alguns minutos!');</script><?
				}
			} else {
				?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
			}
		} else {
			?><script>window.alert('A mensagem não pode ser enviada! Tente novamente!');</script><?
		}
	}

	$assunto = '';
	$mensagem = '';
//}
?>

<script language="javascript">
	function enviar_mensagem () {
		if (document.forms["form"]["assunto"].value == '') {
			window.alert('Favor preencher o campo ASSUNTO, que será o TÍTULO da mensagem!');
		} else if (document.forms["form"]["mensagem"].value == '') {
			window.alert('Favor preencher o campo MENSAGEM, que será o conteúdo da mensagem!');
		} else {
			abrir(form,1,'mensagem_email_lumen.php','comando=enviar');
		}
	}
</script>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	Mensagens por E-mail<br>
</font>

<br>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">CONTEÚDO</font></legend>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td align="left" valign="middle">
			<font class="font10azul">Assunto:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="assunto" value="<?=$assunto?>" placeholder="digite aqui o assunto título da mensagem" size="100" maxlength="100">
		</td>
	</tr>
	<tr>
		<td align="left" valign="middle">
			<font class="font10azul">Mensagem:</font>
		</td>
		<td align="left" valign="middle">
			<textarea id="mensagem" name="mensagem" rows="10" cols="80" placeholder="digite aqui a mensagem"><?=$mensagem?></textarea>
		</td>
	</tr>
	<tr>
		<td align="left" valign="middle">
			<input type="button" id="botao_enviar_mensagem" name="botao_enviar_mensagem" value="Enviar" class="botao" onClick="enviar_mensagem();">
		</td>
	</tr>
</table>

</fieldset>

</div>