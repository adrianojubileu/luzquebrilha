<?
$email_remetente = 'luzquebrilha@obralumen.org.br';

$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: $email_remetente\r\n";
$headers .= "Return-Path: $email_remetente\r\n";

$qtd_emails_maximo = 350;
$sql = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
$rs = mysql_query($sql);
//$rs = false;
if ($rs) {
	$campo = mysql_fetch_array($rs);
	$qtd_emails = $campo["qtd_emails"];
	//echo $qtd_emails."<br>";
	if ($qtd_emails < $qtd_emails_maximo) {
		$primeiro_email = 0;
		$limite = $qtd_emails_maximo - $qtd_emails;
		$sql2 = "SELECT ME.co_email, ME.no_email, ME.co_pessoa, M.no_titulo, M.de_mensagem ";
		$sql2 = $sql2."FROM mensagens_emails ME LEFT JOIN mensagens M ON (ME.co_mensagem = M.co_mensagem) ";
		$sql2 = $sql2."WHERE (ME.ic_situacao = 'P') ";
		$sql2 = $sql2."ORDER BY M.co_mensagem, ME.no_email ASC LIMIT ".$limite." OFFSET ".$primeiro_email."; ";
		//echo $sql2."<br>";
		$rs2 = mysql_query($sql2);
		//$rs2 = false;
		if ($rs2) {
			if (mysql_num_rows($rs2) > 0) {
				$msg = 1;
				//echo $msg." - ".$qtd_emails." - ".$qtd_emails_maximo."<br>";
				while (($msg <= mysql_num_rows($rs2)) && ($qtd_emails <= $qtd_emails_maximo)) {
					$campo2 = mysql_fetch_array($rs2);
					$co_email = $campo2["co_email"];
					$no_email = $campo2["no_email"];
					$pessoa_email = $campo2["co_pessoa"];
					$titulo_email = $campo2["no_titulo"];
					$mensagem_email = $campo2["de_mensagem"];
					$mensagemHTML = $mensagem_email;
/*					if ($mensagem_email != '') {
						$mensagemHTML = '<html>';
						$mensagemHTML .= '<body style="font: Verdana black 10px;">';
						$mensagemHTML .= '<p><font size="3" color="blue"><b>'.$assunto.'</b></font></p>';
						//$mensagemHTML .= '<img src="http://www.obralumen.org.br/sistemas/imagens/lumen/imposto_renda_2017_2016.jpg" height="480" width="480">';
						//$mensagemHTML .= '<br><br>';
						$mensagemHTML .= 'Caríssimo (a), ';
						$mensagemHTML .= '<br><br>';
						$mensagemHTML .= $mensagem_email;
						$mensagemHTML .= '<br><br>';
						$mensagemHTML .= '<p><font size="3" color="blue"><b>Luz e Paz!</b></font></p>';
						$mensagemHTML .= '<p><font size="3" color="blue"><b>Obra Lumen de Evangelização - Projeto Luz que Brilha</b></font></p>';
						$mensagemHTML .= '<br><br>';
						$mensagemHTML .= '</body>';
						$mensagemHTML .= '</html>';
					}*/
					if ($no_email != '') {
						//echo $msg." - ".$qtd_emails." - ".$co_email.' - '.$no_email.' - '.$pessoa_email.' - '.$titulo_email.'<br>';
						//echo $mensagemHTML.'<br>';
						$sql3 = "SELECT MAX(co_email) AS maximo FROM emails;";
						$rs3 = mysql_query($sql3);
						if ($rs3) {
							if (mysql_num_rows($rs3) > 0) {
								$campo3 = mysql_fetch_array($rs3);
								$co_mensagem_maximo = $campo3["maximo"] + 1;
							}
							//echo $msg."<br>".$qtd_emails."<br>".$no_email.'<br>'.utf8_encode($titulo_email).'<br>'.utf8_encode($mensagemHTML).'<br>'.$headers.'<br>';
							$envio = mail($no_email, utf8_encode($titulo_email), utf8_encode($mensagemHTML), $headers);
							//echo $envio."<br>";
							//$envio = true;
							if ($envio) {
								$sql4 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email, co_pessoa, ic_situacao) ";
								$sql4 = $sql4."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email."','".$titulo_email."','".$mensagemHTML."','email_marketing',".$pessoa_email.",1); ";
								//echo $sql4."<br>";
								$rs4 = mysql_query($sql4);
								$sql5 = "UPDATE mensagens_emails ";
								$sql5 = $sql5."SET ic_situacao = 'E', ";
								$sql5 = $sql5."    dt_email = CURRENT_DATE, ";
								$sql5 = $sql5."    hr_email = CURRENT_TIME ";
								$sql5 = $sql5."WHERE (co_email = ".$co_email."); ";
								//echo $sql5."<br>";
								$rs5 = mysql_query($sql5);
								$msg = $msg + 1;
								$qtd_emails = $qtd_emails + 1;
							} else {
								$sql5 = "UPDATE mensagens_emails ";
								$sql5 = $sql5."SET ic_situacao = 'N', ";
								$sql5 = $sql5."    dt_email = CURRENT_DATE, ";
								$sql5 = $sql5."    hr_email = CURRENT_TIME ";
								$sql5 = $sql5."WHERE (co_email = ".$co_email."); ";
								//echo $sql5."<br>";
								$rs5 = mysql_query($sql5);
							}
						}
					}
				}
			}
		}
	}
}
?>