<?
$email_remetente = 'luzquebrilha@obralumen.org.br';
$email_destinatario = isset($_POST['no_login']) ? strtolower($_POST['no_login']) : '';
$assunto = 'Obra Lumen de Evangelização - Luz que Brilha - Login e Senha de acesso!';

if ($email_destinatario != '') {
	$sql = "SELECT P.nu_senha, P.co_pessoa ";
	$sql = $sql."FROM pessoas P ";
	$sql = $sql."INNER JOIN pessoas_emails PE ON (P.co_pessoa = PE.co_pessoa) AND (PE.ic_email_principal = 'SIM') ";
	$sql = $sql."WHERE (PE.no_email = '".$email_destinatario."');";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$senha = $campo["nu_senha"];
			$pessoa_email = $campo["co_pessoa"];
		
			$mensagemHTML = '<html>';
			$mensagemHTML .= '<body style="font: Verdana black 10px;">';
			$mensagemHTML .= '<p><font size="3" color="blue"><b>'.$assunto.'</b></font></p>';
			$mensagemHTML .= '<hr>';
			$mensagemHTML .= 'Convidamos você a acessar o nosso site ';
			$mensagemHTML .= '<a href="http://luzquebrilha.obralumen.org.br/"><b>luzquebrilha.obralumen.org.br</b></a> para realizar ';
			$mensagemHTML .= 'a sua atualização cadastral online, acompanhar o registro das suas contribuições realizadas, ';
			$mensagemHTML .= 'gerar boletos da CAIXA para realizar as contribuições/doações.';
			$mensagemHTML .= '<br><br>';
			$mensagemHTML .= 'Login: <b>'.$email_destinatario.'</b>';
			$mensagemHTML .= '<br>';
			$mensagemHTML .= 'Senha: <b>'.$senha.'</b>';
			$mensagemHTML .= '<br><br>';
			$mensagemHTML .= 'Quaisquer dúvidas e sugestões, sugerimos entrar em contato através dos e-mails ';
			$mensagemHTML .= '<a href="mailto://projetoluzquebrilha@gmail.com">projetoluzquebrilha@gmail.com</a> ou ';
			$mensagemHTML .= '<a href="mailto://luzquebrilha@obralumen.org.br">luzquebrilha@obralumen.org.br</a>, ';
			$mensagemHTML .= 'ou através da nossa página no Facebook - <a href="http://www.facebook.com/ObraLumen/">www.facebook.com/ObraLumen</a>, ';
			$mensagemHTML .= 'ou através da nossa página no Instagram - <a href="http://www.instagram.com/obralumen/">www.instagram.com/obralumen</a>, ';
			$mensagemHTML .= 'ou através dos telefones (85) 3277-1713 ou (85) 9924-5999';
			$mensagemHTML .= '<hr>';
			$mensagemHTML .= '<p><font size="3" color="blue"><b>Luz e Paz!</b></font></p>';
			$mensagemHTML .= '</body>';
			$mensagemHTML .= '</html>';

			$headers = "MIME-Version: 1.1\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: $email_remetente\r\n";
			$headers .= "Return-Path: $email_remetente\r\n";
			
			$co_mensagem_maximo = 1;
			$sql2 = "SELECT MAX(co_email) AS maximo FROM emails;";
			$rs2 = mysql_query($sql2);
			if ($rs2) {
				if (mysql_num_rows($rs2) > 0) {
					$campo2 = mysql_fetch_array($rs2);
					$co_mensagem_maximo = $campo2["maximo"] + 1;
				}
				$sql3 = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
				$rs3 = mysql_query($sql3);
				if ($rs3) {
					$campo3 = mysql_fetch_array($rs3);
					$qtd_emails = $campo3["qtd_emails"];
					if ($qtd_emails < 350) {
						$envio = mail($email_destinatario, $assunto, $mensagemHTML, $headers);
						if ($envio) {
							$sql4 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email, co_pessoa, ic_situacao) ";
							$sql4 = $sql4."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$email_destinatario."','".$assunto."','".$mensagemHTML."','esqueci_minha_senha',".$pessoa_email.",1); ";
							$rs4 = mysql_query($sql4);
							if ($rs4) {
								?><script>window.alert('A mensagem com a SENHA foi enviada para o e-mail <?=$email_destinatario?> com sucesso!');abrir(form,0,'','');</script><?
							} else {
								?><script>window.alert('A mensagem com a SENHA não pode ser enviada! Tente novamente!');abrir(form,0,'','');</script><?
							}
						} else {
							?><script>window.alert('A mensagem com a SENHA não pode ser enviada! Tente novamente!');abrir(form,0,'','');</script><?
						}
					} else {
						?><script>window.alert('O limite de emails enviados é de 350 e-mails por hora, e ele já foi excedido. Tente novamente daqui alguns minutos!');abrir(form,0,'','');</script><?
					}
				} else {
					?><script>window.alert('A mensagem com a SENHA não pode ser enviada! Tente novamente!');abrir(form,0,'','');</script><?
				}
			} else {
				?><script>window.alert('A mensagem com a SENHA não pode ser enviada! Tente novamente!');abrir(form,0,'','');</script><?
			}
		} else {
			?><script>window.alert('O e-mail <?=$email_destinatario?> não consta no cadastro como e-mail principal de algum usuário! Cadastre-se!');abrir(form,0,'','');</script><?
		}
	} else {
		?><script>window.alert('A mensagem com a SENHA não pode ser enviada! Tente novamente!');abrir(form,0,'','');</script><?
	}	
} else {
	?><script>window.alert('Preencha o campo LOGIN com o E-MAIL PRINCIPAL cadastrado para receber a SENHA!');abrir(form,0,'','');</script><?
}
?>