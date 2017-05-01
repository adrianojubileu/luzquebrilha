<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
if ($co_pessoa_login == $co_pessoa) {
	if ($co_pessoa_login == '') {
		$botao = 'salvar';
	} else {
		$botao = 'atualizar';
		if ($comando != '') {
			$comando = 'atualizar';
		}
	}
} else {
	if ($co_pessoa == '') {
		$botao = 'salvar';
	} else {
		$botao = 'atualizar';
	}
}

$no_pessoa_completo = strtoupper(sem_acento(isset($_POST['no_pessoa_completo']) ? $_POST['no_pessoa_completo'] : ''));
$no_pessoa = strtoupper(sem_acento(isset($_POST['no_pessoa']) ? $_POST['no_pessoa'] : ''));
if ($no_pessoa == '') {
	$no_pessoa = $no_pessoa_completo;
} else if ($no_pessoa_completo == '') {
	$no_pessoa_completo = $no_pessoa;
}
$ic_membro_ativo = isset($_POST['ic_membro_ativo']) ? $_POST['ic_membro_ativo'] : '';
if ($ic_membro_ativo == true) {
	$ic_membro_ativo = 'SIM';
} else {
	$ic_membro_ativo = 'NAO';
}
$ic_fidelidade = isset($_POST['ic_fidelidade']) ? $_POST['ic_fidelidade'] : '';
if ($ic_fidelidade == true) {
	$ic_fidelidade = 'SIM';
} else {
	$ic_fidelidade = 'NAO';
}
$dt_nascimento = isset($_POST['dt_nascimento']) ? $_POST['dt_nascimento'] : '';
if ($dt_nascimento != '') {
	$dt_nascimento = substr($dt_nascimento, 6, 4).'-'.substr($dt_nascimento, 3, 2).'-'.substr($dt_nascimento, 0, 2);
}

$fones = isset($_POST['fones']) ? $_POST['fones'] : 2;
$ind_telefone = 0;
for ($i = 0; $i < $fones; $i++) {
	$nu_telefone[$ind_telefone] = isset($_POST['nu_telefone'.$i]) ? $_POST['nu_telefone'.$i] : '';
	if ($nu_telefone[$ind_telefone] != '') {
		$co_telefone[$ind_telefone] = isset($_POST['co_telefone'.$i]) ? $_POST['co_telefone'.$i] : '';
		$nu_ddd_telefone[$ind_telefone] = isset($_POST['nu_ddd_telefone'.$i]) ? $_POST['nu_ddd_telefone'.$i] : '';
		$co_tipo_telefone[$ind_telefone] = isset($_POST['co_tipo_telefone'.$i]) ? $_POST['co_tipo_telefone'.$i] : '';
		if ($co_tipo_telefone[$ind_telefone] == '') {
			$co_tipo_telefone[$ind_telefone] = 'NULL';
		}
		if ($ind_telefone == 0) {
			$ic_telefone_principal[$ind_telefone] = 'SIM';
		} else {
			$ic_telefone_principal[$ind_telefone] = 'NAO';
		}
		$ind_telefone = $ind_telefone + 1;
	}
}
$fones = $ind_telefone;

$emails = isset($_POST['emails']) ? $_POST['emails'] : 2;
$ind_email = 0;
for ($i = 0; $i < $emails; $i++) {
	$no_email[$ind_email] = strtolower(sem_acento(isset($_POST['no_email'.$i]) ? $_POST['no_email'.$i] : ''));
	if ($no_email[$ind_email] != '') {
		$co_email[$ind_email] = isset($_POST['co_email'.$i]) ? $_POST['co_email'.$i] : '';
		if ($ind_email == 0) {
			$ic_email_principal[$ind_email] = 'SIM';
		} else {
			$ic_email_principal[$ind_email] = 'NAO';
		}
		$ind_email = $ind_email + 1;
	}
}
$emails = $ind_email;

$enderecos = isset($_POST['enderecos']) ? $_POST['enderecos'] : 2;
$ind_endereco = 0;
for ($i = 0; $i < $enderecos; $i++) {
	$no_endereco[$ind_endereco] = strtoupper(sem_acento(isset($_POST['no_endereco'.$i]) ? $_POST['no_endereco'.$i] : ''));
	if ($no_endereco[$ind_endereco] != '') {
		$co_endereco[$ind_endereco] = isset($_POST['co_endereco'.$i]) ? $_POST['co_endereco'.$i] : '';
		$no_bairro[$ind_endereco] = strtoupper(sem_acento(isset($_POST['no_bairro'.$i]) ? $_POST['no_bairro'.$i] : ''));
		$no_cidade[$ind_endereco] = strtoupper(sem_acento(isset($_POST['no_cidade'.$i]) ? $_POST['no_cidade'.$i] : ''));
		$co_uf[$ind_endereco] = strtoupper(isset($_POST['co_uf'.$i]) ? $_POST['co_uf'.$i] : '');
		$nu_cep[$ind_endereco] = isset($_POST['nu_cep'.$i]) ? $_POST['nu_cep'.$i] : '';
		$nu_cep[$ind_endereco] = str_replace('.','',$nu_cep[$ind_endereco]);
		$nu_cep[$ind_endereco] = str_replace('-','',$nu_cep[$ind_endereco]);
		if ($ind_endereco == 0) {
			$ic_endereco_principal[$ind_endereco] = 'SIM';
		} else {
			$ic_endereco_principal[$ind_endereco] = 'NAO';
		}
		$ind_endereco = $ind_endereco + 1;
	}
}
$enderecos = $ind_endereco;

$nu_senha = strtolower(sem_acento(isset($_POST['nu_senha1']) ? $_POST['nu_senha1'] : ''));
$co_perfil = isset($_POST['co_perfil']) ? $_POST['co_perfil'] : 5;
if ($co_perfil == '') {
	$co_perfil == 5;
}

$no_facebook = strtoupper(sem_acento(isset($_POST['no_facebook']) ? $_POST['no_facebook'] : ''));
$no_minha_profissao = strtoupper(sem_acento(isset($_POST['no_minha_profissao']) ? $_POST['no_minha_profissao'] : ''));

$co_meu_sexo = isset($_POST['co_meu_sexo']) ? $_POST['co_meu_sexo'] : '';
$ic_cadastro = isset($_POST['ic_cadastro']) ? $_POST['ic_cadastro'] : 'A';
$co_estado_civil = isset($_POST['co_estado_civil']) ? $_POST['co_estado_civil'] : 0;
$co_religiao = isset($_POST['co_religiao']) ? $_POST['co_religiao'] : 0;

$co_tipo_pessoa = isset($_POST['co_tipo_pessoa']) ? $_POST['co_tipo_pessoa'] : '';
$nu_cpf_cnpj = isset($_POST['nu_cpf_cnpj']) ? $_POST['nu_cpf_cnpj'] : '';
if (($co_tipo_pessoa != '') && ($nu_cpf_cnpj != '')) {
	if (($co_tipo_pessoa == 'PF') && (strlen($nu_cpf_cnpj) < 11)) {
		$qtd_zeros = 11 - strlen($nu_cpf_cnpj);
		for ($i = 1; $i <= $qtd_zeros; $i++) {
			$nu_cpf_cnpj = '0'.$nu_cpf_cnpj;
		}
	}
	if (($co_tipo_pessoa == 'PJ') && (strlen($nu_cpf_cnpj) < 14)) {
		$qtd_zeros = 14 - strlen($nu_cpf_cnpj);
		for ($i = 1; $i <= $qtd_zeros; $i++) {
			$nu_cpf_cnpj = '0'.$nu_cpf_cnpj;
		}
	}
}
$vr_oferta = isset($_POST['vr_oferta']) ? $_POST['vr_oferta'] : '';
if ($vr_oferta != '') {
	$vr_oferta = str_replace('.','',$vr_oferta);
	$vr_oferta = str_replace(',','.',$vr_oferta);
}
$dd_oferta = isset($_POST['dd_oferta']) ? $_POST['dd_oferta'] : '';
$co_tipo_oferta = isset($_POST['co_tipo_oferta']) ? $_POST['co_tipo_oferta'] : 0;
$co_tipo_envio_boleto = isset($_POST['co_tipo_envio_boleto']) ? $_POST['co_tipo_envio_boleto'] : 0;

$lembrancas = isset($_POST['lembrancas']) ? $_POST['lembrancas'] : 5;
for ($i = 1 ; $i <= $lembrancas; $i++) {
	$co_tipo_lembranca[$i] = $i;
	$ic_lembranca[$i] = isset($_POST['ic_lembranca'.$i]) ? $_POST['ic_lembranca'.$i] : '';
	if ($ic_lembranca[$i] == true) {
		$ic_lembranca[$i] = 'SIM';
	} else {
		$ic_lembranca[$i] = 'NAO';
	}
}

$grupos = isset($_POST['grupos']) ? $_POST['grupos'] : 2;
$ind_grupo = 0;
for ($i = 0 ; $i < $grupos; $i++) {
	$co_grupo[$ind_grupo] = isset($_POST['co_grupo'.$i]) ? $_POST['co_grupo'.$i] : '';
	if ($co_grupo[$ind_grupo] != '') {
		$co_grupo_anterior[$ind_grupo] = isset($_POST['co_grupo_anterior'.$i]) ? $_POST['co_grupo_anterior'.$i] : '';
		$co_funcao_grupo[$ind_grupo] = isset($_POST['co_funcao_grupo'.$i]) ? $_POST['co_funcao_grupo'.$i] : '';
		$ind_grupo = $ind_grupo + 1;
	}
}
$grupos = $ind_grupo;
		
$servicos = isset($_POST['servicos']) ? $_POST['servicos'] : 3;
$ind_servico = 0;
for ($i = 0 ; $i < $servicos; $i++) {
	$co_servico[$ind_servico] = isset($_POST['co_servico'.$i]) ? $_POST['co_servico'.$i] : '';
	if ($co_servico[$ind_servico] != '') {
		$co_servico_anterior[$ind_servico] = isset($_POST['co_servico_anterior'.$i]) ? $_POST['co_servico_anterior'.$i] : '';
		$co_funcao_servico[$ind_servico] = isset($_POST['co_funcao_servico'.$i]) ? $_POST['co_funcao_servico'.$i] : '';
		$ind_servico = $ind_servico + 1;
	}
}
$servicos = $ind_servico;

$retiros = isset($_POST['retiros']) ? $_POST['retiros'] : 4;
$ind_retiro = 0;
for ($i = 0 ; $i < $retiros; $i++) {
	$co_retiro[$ind_retiro] = isset($_POST['co_retiro'.$i]) ? $_POST['co_retiro'.$i] : '';
	if ($co_retiro[$ind_retiro] != '') {
		$co_retiro_anterior[$ind_retiro] = isset($_POST['co_retiro_anterior'.$i]) ? $_POST['co_retiro_anterior'.$i] : '';
		$ind_retiro = $ind_retiro + 1;
	}
}
$retiros = $ind_retiro;

$co_telefone_maximo = 1;
$sql = "SELECT MAX(co_telefone) AS maximo FROM pessoas_telefones;";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$co_telefone_maximo = $campo["maximo"];
	}
}

$co_email_maximo = 1;
$sql = "SELECT MAX(co_email) AS maximo FROM pessoas_emails;";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$co_email_maximo = $campo["maximo"];
	}
}

$co_endereco_maximo = 1;
$sql = "SELECT MAX(co_endereco) AS maximo FROM pessoas_enderecos;";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$co_endereco_maximo = $campo["maximo"];
	}
}

$co_mensagem_maximo = 1;
$sql = "SELECT MAX(co_email) AS maximo FROM emails;";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$co_mensagem_maximo = $campo["maximo"] + 1;
	}
}

if ($comando == 'salvar') {

	if (($co_pessoa_login == '') || (($co_pessoa_login != '') && ($co_pessoa == ''))) {
		$sql = "SELECT MAX(co_pessoa) AS maximo FROM pessoas;";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$co_pessoa = $campo["maximo"] + 1;
			}
		}
		
		if ($co_pessoa_login == '') {
			$co_pessoa_login = $co_pessoa;
		}
		
		for ($i = 0 ; $i < $fones; $i++) {
			if ($nu_ddd_telefone[$i] != '') {
				$co_telefone_maximo = $co_telefone_maximo + 1;
				$co_telefone[$i] = $co_telefone_maximo;
			}
		}
	
		for ($i = 0 ; $i < $emails; $i++) {
			if ($no_email[$i] != '') {
				$co_email_maximo = $co_email_maximo + 1;
				$co_email[$i] = $co_email_maximo;
			}
		}
		
		for ($i = 0 ; $i < $enderecos; $i++) {
			if (($no_endereco[$i] != '') || ($no_bairro[$i] != '') || ($no_cidade[$i] != '')) {
				$co_endereco_maximo = $co_endereco_maximo + 1;
				$co_endereco[$i] = $co_endereco_maximo;
			}
		}
		
		if ($nu_senha == '') {
			if ($nu_telefone[0] != '') {
				$nu_senha = $nu_telefone[0];
			} else if ($nu_cpf_cnpj != '') {
				$nu_senha = $nu_cpf_cnpj;
			} else {
				$nu_senha = '12345';
			}
		}
		
		$sql = "INSERT INTO pessoas (co_pessoa, no_pessoa_completo, no_pessoa, ic_membro_ativo, ";
		$sql = $sql."co_tipo_pessoa, co_sexo, co_estado_civil, co_religiao, ";
		$sql = $sql."dt_nascimento, nu_cpf_cnpj, vr_oferta, co_tipo_oferta, co_tipo_envio_boleto, dd_oferta, no_facebook, no_profissao, ";
		$sql = $sql."nu_senha, co_pessoa_cadastrou, dt_cadastro, co_perfil, ic_cadastro, ic_fidelidade) ";
		$sql = $sql."VALUES (".$co_pessoa.",'".$no_pessoa_completo."','".$no_pessoa."','".$ic_membro_ativo."',";
		$sql = $sql."'".$co_tipo_pessoa."','".$co_meu_sexo."',".$co_estado_civil.",".$co_religiao.",";
		if ($dt_nascimento != '') {
			$sql = $sql."'".$dt_nascimento."',";
		} else {
			$sql = $sql."NULL,";
		}
		if ($nu_cpf_cnpj != '') {
			$sql = $sql."'".$nu_cpf_cnpj."',";
		} else {
			$sql = $sql."NULL,";
		}
		if ($vr_oferta != '') {
			$sql = $sql."".$vr_oferta.",";
			if ($co_tipo_oferta != '') {
				$sql = $sql."".$co_tipo_oferta.",";
			} else {
				$sql = $sql."0,";
			}
			if ($co_tipo_envio_boleto != '') {
				$sql = $sql."".$co_tipo_envio_boleto.",";
			} else {
				$sql = $sql."0,";
			}
			if ($dd_oferta != '') {
				$sql = $sql."".$dd_oferta.",";
			} else {
				$sql = $sql."15,";
			}
		} else {
			$sql = $sql."NULL,NULL,NULL,NULL,";
		}
		if ($no_facebook != '') {
			$sql = $sql."'".$no_facebook."',";
		} else {
			$sql = $sql."NULL,";
		}
		if ($no_minha_profissao != '') {
			$sql = $sql."'".$no_minha_profissao."',";
		} else {
			$sql = $sql."NULL,";
		}
		$sql = $sql."'".$nu_senha."',";
		$sql = $sql."".$co_pessoa_login.",CURRENT_DATE,".$co_perfil.",'".$ic_cadastro."','".$ic_fidelidade."'); ";
		
		$rs = mysql_query($sql);
		$sql = "";
		
		for ($i = 0 ; $i < $fones; $i++) {
			if ($nu_ddd_telefone[$i] != '') {
				$sql = $sql."INSERT INTO pessoas_telefones (co_telefone, co_pessoa, nu_ddd_telefone, nu_telefone, co_tipo_telefone, ic_telefone_principal) ";
				$sql = $sql."VALUES (".$co_telefone[$i].",".$co_pessoa.",'".$nu_ddd_telefone[$i]."','".$nu_telefone[$i]."',".$co_tipo_telefone[$i].",'".$ic_telefone_principal[$i]."'); ";
				mysql_query($sql);
				$sql = "";
			}
		}
		
		for ($i = 0 ; $i < $emails; $i++) {
			if ($no_email[$i] != '') {
				$sql = $sql."INSERT INTO pessoas_emails (co_email, co_pessoa, no_email, ic_email_principal) ";
				$sql = $sql."VALUES (".$co_email[$i].",".$co_pessoa.",'".$no_email[$i]."','".$ic_email_principal[$i]."'); ";
				mysql_query($sql);
				$sql = "";
			}
		}
		
		for ($i = 0 ; $i < $enderecos; $i++) {
			if (($no_endereco[$i] != '') || ($no_bairro[$i] != '') || ($no_cidade[$i] != '')) {
				$sql = $sql."INSERT INTO pessoas_enderecos (co_endereco, co_pessoa, no_endereco, no_bairro, no_cidade, co_uf, nu_cep, ic_endereco_principal) ";
				$sql = $sql."VALUES (".$co_endereco[$i].",".$co_pessoa.",'".$no_endereco[$i]."','".$no_bairro[$i]."','".$no_cidade[$i]."','".$co_uf[$i]."','".$nu_cep[$i]."','".$ic_endereco_principal[$i]."'); ";
				mysql_query($sql);
				$sql = "";
			}
		}
		
		for ($i = 1 ; $i <= $lembrancas; $i++) {
			$sql = $sql."INSERT INTO pessoas_lembrancas (co_pessoa, co_tipo_lembranca, ic_lembranca) ";
			$sql = $sql."VALUES (".$co_pessoa.",".$co_tipo_lembranca[$i].",'".$ic_lembranca[$i]."'); ";
			mysql_query($sql);
			$sql = "";
		}

		for ($i = 0 ; $i < $grupos; $i++) {
			if ($co_grupo[$i] != '') {
				$sql = $sql."INSERT INTO pessoas_grupos (co_pessoa, co_grupo, co_funcao) ";
				$sql = $sql."VALUES (".$co_pessoa.",".$co_grupo[$i].",'".$co_funcao_grupo[$i]."'); ";
				mysql_query($sql);
				$sql = "";
			}
		}

		for ($i = 0 ; $i < $servicos; $i++) {
			if ($co_servico[$i] != '') {
				$sql = $sql."INSERT INTO pessoas_servicos (co_pessoa, co_servico, co_funcao) ";
				$sql = $sql."VALUES (".$co_pessoa.",".$co_servico[$i].",'".$co_funcao_servico[$i]."'); ";
				mysql_query($sql);
				$sql = "";
			}
		}
		
		for ($i = 0 ; $i < $retiros; $i++) {
			if ($co_retiro[$i] != '') {
				$sql = $sql."INSERT INTO pessoas_retiros (co_pessoa, co_retiro) ";
				$sql = $sql."VALUES (".$co_pessoa.",".$co_retiro[$i]."); ";
				mysql_query($sql);
				$sql = "";
			}
		}

		if ($rs) {
			
			//echo "Cadastro realizado com sucesso!";
			
			$co_visita = 1;
			$sql2 = "SELECT MAX(co_visita) AS maximo FROM visitas;";
			$rs2 = mysql_query($sql2);
			if ($rs2) {
				if (mysql_num_rows($rs2) > 0) {
					$campo2 = mysql_fetch_array($rs2);
					$co_visita = $campo2["maximo"] + 1;
				}
			}
			if ($co_pessoa_login == $co_pessoa) {
				$sql2 = "INSERT INTO visitas (co_visita, co_pessoa, dt_entrada, hr_entrada, ic_logon, de_mensagem) ";
				$sql2 = $sql2."VALUES (".$co_visita.",".$co_pessoa_login.",CURRENT_DATE,CURRENT_TIME,'SIM','Logon efetuado por primeiro cadastro!');";
				$rs2 = mysql_query($sql2);
				?><input type="hidden" id="co_visita" name="co_visita" value="<?=$co_visita?>"><?

				if ($no_email[0] != '') {
					$email_remetente = 'luzquebrilha@obralumen.org.br';
					$assunto = 'Obra Lumen de Evangelização - Luz que Brilha - Cadastro realizado com sucesso!';
					
					$mensagemHTML = '<html>';
					$mensagemHTML .= '<body style="font: Verdana black 10px;">';
					$mensagemHTML .= '<p><font size="3" color="blue"><b>'.$assunto.'</b></font></p>';
					$mensagemHTML .= '<hr>';
					$mensagemHTML .= '<b>'.$no_pessoa_completo.'</b>';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Convidamos você a acessar o nosso site ';
					$mensagemHTML .= '<a href="http://luzquebrilha.obralumen.org.br/"><b>luzquebrilha.obralumen.org.br</b></a> para realizar ';
					$mensagemHTML .= 'a sua atualização cadastral online, acompanhar o registro das suas contribuições realizadas, ';
					$mensagemHTML .= 'gerar boletos da CAIXA para realizar as suas contribuições/doações. Em breve, colocaremos também as informações ';
					$mensagemHTML .= 'das prestações de contas mensais.';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Login: <b>'.$no_email[0].'</b>';
					$mensagemHTML .= '<br>';
					$mensagemHTML .= 'Senha: <b>'.$nu_senha.'</b>';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Quaisquer dúvidas e sugestões, sugerimos entrar em contato através dos e-mails ';
					$mensagemHTML .= '<a href="mailto://projetoluzquebrilha@gmail.com">projetoluzquebrilha@gmail.com</a> ou ';
					$mensagemHTML .= '<a href="mailto://luzquebrilha@obralumen.org.br">luzquebrilha@obralumen.org.br</a>, do Facebook, ou através ';
					$mensagemHTML .= 'dos telefones (85) 3277-1713 ou (85) 9924-5999';
					$mensagemHTML .= '<hr>';
					$mensagemHTML .= '<p><font size="3" color="blue"><b>Luz e Paz!</b></font></p>';
					$mensagemHTML .= '</body>';
					$mensagemHTML .= '</html>';

					$headers = "MIME-Version: 1.1\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
					$headers .= "From: $email_remetente\r\n";
					$headers .= "Return-Path: $email_remetente\r\n";

					$sql3 = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
					$rs3 = mysql_query($sql3);
					if ($rs3) {
						$campo3 = mysql_fetch_array($rs3);
						$qtd_emails = $campo3["qtd_emails"];
						if ($qtd_emails < 350) {
							$envio = mail($no_email[0], $assunto, $mensagemHTML, $headers);
							$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email) ";
							$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email[0]."','".$assunto."','".$mensagemHTML."','cadastro_salvo'); ";
							$rs3 = mysql_query($sql3);
							$qtd_emails = $qtd_emails + 1;
							$co_mensagem_maximo = $co_mensagem_maximo + 1;
							if ($no_email[1] != '') {
								if ($qtd_emails < 350) {
									$envio = mail($no_email[1], $assunto, $mensagemHTML, $headers);
									$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email) ";
									$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email[1]."','".$assunto."','".$mensagemHTML."','cadastro_salvo'); ";
									$rs3 = mysql_query($sql3);
									$co_mensagem_maximo = $co_mensagem_maximo + 1;
								} else {
									?><script>window.alert('Limite de emails automáticos enviados hoje já foi excedido!');</script><?
								}
							}
						} else {
							?><script>window.alert('Limite de emails automáticos enviados hoje já foi excedido!');</script><?
						}
					}
				}
				
				?><script>window.alert('Cadastro realizado com sucesso!');abrir(form,1,'cadastro.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa?>');</script><?
			} else {

				if ($no_email[0] != '') {
					$email_remetente = 'luzquebrilha@obralumen.org.br';
					$assunto = 'Obra Lumen de Evangelização - Luz que Brilha - Cadastro realizado com sucesso!';
					
					$mensagemHTML = '<html>';
					$mensagemHTML .= '<body style="font: Verdana black 10px;">';
					$mensagemHTML .= '<p><font size="3" color="blue"><b>'.$assunto.'</b></font></p>';
					$mensagemHTML .= '<hr>';
					$mensagemHTML .= '<b>'.$no_pessoa_completo.'</b>';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Convidamos você a acessar o nosso site ';
					$mensagemHTML .= '<a href="http://luzquebrilha.obralumen.org.br/"><b>luzquebrilha.obralumen.org.br</b></a> para realizar ';
					$mensagemHTML .= 'a sua atualização cadastral online, acompanhar o registro das suas contribuições realizadas, ';
					$mensagemHTML .= 'gerar boletos da CAIXA para realizar as suas contribuições/doações. Em breve, colocaremos também as informações ';
					$mensagemHTML .= 'das prestações de contas mensais.';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Login: <b>'.$no_email[0].'</b>';
					$mensagemHTML .= '<br>';
					$mensagemHTML .= 'Senha: <b>'.$nu_senha.'</b>';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Quaisquer dúvidas e sugestões, sugerimos entrar em contato através dos e-mails ';
					$mensagemHTML .= '<a href="mailto://projetoluzquebrilha@gmail.com">projetoluzquebrilha@gmail.com</a> ou ';
					$mensagemHTML .= '<a href="mailto://luzquebrilha@obralumen.org.br">luzquebrilha@obralumen.org.br</a>, do Facebook, ou através ';
					$mensagemHTML .= 'dos telefones (85) 3277-1713 ou (85) 9924-5999';
					$mensagemHTML .= '<hr>';
					$mensagemHTML .= '<p><font size="3" color="blue"><b>Luz e Paz!</b></font></p>';
					$mensagemHTML .= '</body>';
					$mensagemHTML .= '</html>';

					$headers = "MIME-Version: 1.1\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
					$headers .= "From: $email_remetente\r\n";
					$headers .= "Return-Path: $email_remetente\r\n";
					
					$sql3 = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
					$rs3 = mysql_query($sql3);
					if ($rs3) {
						$campo3 = mysql_fetch_array($rs3);
						$qtd_emails = $campo3["qtd_emails"];
						if ($qtd_emails < 350) {
							$envio = mail($no_email[0], $assunto, $mensagemHTML, $headers);
							$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email) ";
							$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email[0]."','".$assunto."','".$mensagemHTML."','cadastro_salvo'); ";
							$rs3 = mysql_query($sql3);
							$qtd_emails = $qtd_emails + 1;
							$co_mensagem_maximo = $co_mensagem_maximo + 1;
							if ($no_email[1] != '') {
								if ($qtd_emails < 350) {
									$envio = mail($no_email[1], $assunto, $mensagemHTML, $headers);
									$sql3 = "INSERT INTO emails (dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email) ";
									$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email[1]."','".$assunto."','".$mensagemHTML."','cadastro_salvo'); ";
									$rs3 = mysql_query($sql3);
									$co_mensagem_maximo = $co_mensagem_maximo + 1;
								} else {
									?><script>window.alert('Limite de emails automáticos enviados hoje já foi excedido!');</script><?
								}
							}
						} else {
							?><script>window.alert('Limite de emails automáticos enviados hoje já foi excedido!');</script><?
						}
					}
				}
			
				?><script>window.alert('Cadastro realizado com sucesso!');abrir(form,1,'cadastro_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=');</script><?
			}
		}
	}

} else if ($comando == 'atualizar') {
	
		$sql = "UPDATE pessoas ";
		$sql = $sql."SET no_pessoa_completo = '".$no_pessoa_completo."', no_pessoa = '".$no_pessoa."', ic_membro_ativo = '".$ic_membro_ativo."', ";
		$sql = $sql."co_tipo_pessoa = '".$co_tipo_pessoa."', co_sexo = '".$co_meu_sexo."', co_estado_civil = ".$co_estado_civil.", co_religiao = ".$co_religiao.", ";
		$sql = $sql."ic_cadastro = '".$ic_cadastro."', ic_fidelidade = '".$ic_fidelidade."', ";
		if ($dt_nascimento != '') {
			$sql = $sql."dt_nascimento = '".$dt_nascimento."', ";
		} else {
			$sql = $sql."dt_nascimento = NULL, ";
		}
		if ($nu_cpf_cnpj != '') {
			$sql = $sql."nu_cpf_cnpj = '".$nu_cpf_cnpj."', ";
		} else {
			$sql = $sql."nu_cpf_cnpj = NULL, ";
		}
		if ($vr_oferta != '') {
			$sql = $sql."vr_oferta = ".$vr_oferta.", ";
			if ($co_tipo_oferta != '') {
				$sql = $sql."co_tipo_oferta = ".$co_tipo_oferta.", ";
			} else {
				$sql = $sql."co_tipo_oferta = 0, ";
			}
			if ($co_tipo_envio_boleto != '') {
				$sql = $sql."co_tipo_envio_boleto = ".$co_tipo_envio_boleto.", ";
			} else {
				$sql = $sql."co_tipo_envio_boleto = 0, ";
			}
			if ($dd_oferta != '') {
				$sql = $sql."dd_oferta = ".$dd_oferta.", ";
			} else {
				$sql = $sql."dd_oferta = 15, ";
			}
		} else {
			$sql = $sql."vr_oferta = NULL, co_tipo_oferta = 0, co_tipo_envio_boleto = NULL, dd_oferta = NULL, ";
		}
		if ($no_facebook != '') {
			$sql = $sql."no_facebook = '".$no_facebook."', ";
		} else {
			$sql = $sql."no_facebook = NULL, ";
		}
		if ($no_minha_profissao != '') {
			$sql = $sql."no_profissao = '".$no_minha_profissao."', ";
		} else {
			$sql = $sql."no_profissao = NULL, ";
		}
		if ($co_pessoa_login == $co_pessoa) {
			$sql = $sql."nu_senha = '".$nu_senha."', ";
		}
		$sql = $sql."co_pessoa_atualizou = ".$co_pessoa_login.", ";
		$sql = $sql."dt_atualizacao = CURRENT_DATE, ";
		$sql = $sql."co_perfil = ".$co_perfil." ";
		$sql = $sql."WHERE (co_pessoa = ".$co_pessoa."); ";
		
		$rs = mysql_query($sql);
		$sql = "";

		$sql2 = "SELECT * FROM pessoas_telefones WHERE (co_pessoa = ".$co_pessoa.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$sql2 = "";
			if (mysql_num_rows($rs2) == 0) {
				for ($i = 0 ; $i < $fones; $i++) {
					if (($co_telefone[$i] == '') && ($nu_telefone[$i] != '')) {
						$co_telefone_maximo = $co_telefone_maximo + 1;
						$co_telefone[$i] = $co_telefone_maximo;
						$sql = $sql."INSERT INTO pessoas_telefones (co_telefone, co_pessoa, nu_ddd_telefone, nu_telefone, co_tipo_telefone, ic_telefone_principal) ";
						$sql = $sql."VALUES (".$co_telefone[$i].",".$co_pessoa.",'".$nu_ddd_telefone[$i]."','".$nu_telefone[$i]."',".$co_tipo_telefone[$i].",'".$ic_telefone_principal[$i]."'); ";
						mysql_query($sql);
						$sql = "";
					}
				}
			} else {
				if ($fones == 1) {
					if ($nu_telefone[0] != '') {
						if ($co_telefone[0] != '') {
							$sql = $sql."UPDATE pessoas_telefones ";
							$sql = $sql."SET nu_ddd_telefone = '".$nu_ddd_telefone[0]."', nu_telefone = '".$nu_telefone[0]."', co_tipo_telefone = ".$co_tipo_telefone[0].", ic_telefone_principal = 'SIM' ";
							$sql = $sql."WHERE (co_telefone = ".$co_telefone[0]."); ";
						} else {
							$co_telefone_maximo = $co_telefone_maximo + 1;
							$co_telefone[0] = $co_telefone_maximo;
							$sql = $sql."INSERT INTO pessoas_telefones (co_telefone, co_pessoa, nu_ddd_telefone, nu_telefone, co_tipo_telefone, ic_telefone_principal) ";
							$sql = $sql."VALUES (".$co_telefone[0].",".$co_pessoa.",'".$nu_ddd_telefone[0]."','".$nu_telefone[0]."',".$co_tipo_telefone[0].",'SIM'); ";
						}
						mysql_query($sql);
						$sql = "";
						$sql = $sql."DELETE FROM pessoas_telefones WHERE (co_pessoa = ".$co_pessoa.") AND (nu_telefone != '".$nu_telefone[0]."'); ";
						mysql_query($sql);
						$sql = "";
					}					
				} else {
					if ($fones > 0) {
						$sql2 = "DELETE FROM pessoas_telefones WHERE (co_pessoa = ".$co_pessoa.") AND (nu_telefone NOT IN (";
					}
					for ($i = 0 ; $i < $fones; $i++) {
						if ($nu_telefone[$i] != '') {
							if ($i == 0) {
								$ic_telefone_principal[$i] = 'SIM';
								$sql2 = $sql2."'".$nu_telefone[$i]."'";
							} else {
								$ic_telefone_principal[$i] = 'NAO';
								$sql2 = $sql2.",'".$nu_telefone[$i]."'";
							}
							if ($co_telefone[$i] != '') {
								$sql = $sql."UPDATE pessoas_telefones ";
								$sql = $sql."SET nu_ddd_telefone = '".$nu_ddd_telefone[$i]."', nu_telefone = '".$nu_telefone[$i]."', co_tipo_telefone = ".$co_tipo_telefone[$i].", ic_telefone_principal = '".$ic_telefone_principal[$i]."' ";
								$sql = $sql."WHERE (co_telefone = ".$co_telefone[$i]."); ";
							} else {
								$co_telefone_maximo = $co_telefone_maximo + 1;
								$co_telefone[$i] = $co_telefone_maximo;
								$sql = $sql."INSERT INTO pessoas_telefones (co_telefone, co_pessoa, nu_ddd_telefone, nu_telefone, co_tipo_telefone, ic_telefone_principal) ";
								$sql = $sql."VALUES (".$co_telefone[$i].",".$co_pessoa.",'".$nu_ddd_telefone[$i]."','".$nu_telefone[$i]."',".$co_tipo_telefone[$i].",'".$ic_telefone_principal[$i]."'); ";
							}
							mysql_query($sql);
							$sql = "";
						}
					}
					if ($sql2 != '') {
						$sql = $sql.$sql2.")); ";
						mysql_query($sql);
						$sql = "";
					}
				}
			}
		}
		
		$sql2 = "SELECT * FROM pessoas_emails PE WHERE (PE.co_pessoa = ".$co_pessoa.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$sql2 = "";
			if (mysql_num_rows($rs2) == 0) {
				for ($i = 0 ; $i < $emails; $i++) {
					if (($co_email[$i] == '') && ($no_email[$i] != '')) {
						$co_email_maximo = $co_email_maximo + 1;
						$co_email[$i] = $co_email_maximo;
						$sql = $sql."INSERT INTO pessoas_emails (co_email, co_pessoa, no_email, ic_email_principal) ";
						$sql = $sql."VALUES (".$co_email[$i].",".$co_pessoa.",'".$no_email[$i]."','".$ic_email_principal[$i]."'); ";
						mysql_query($sql);
						$sql = "";
					}
				}
			} else {
				if ($emails == 1) {
					if ($no_email[0] != '') {
						if ($co_email[0] != '') {
							$sql = $sql."UPDATE pessoas_emails ";
							$sql = $sql."SET no_email = '".$no_email[0]."' ";
							$sql = $sql."WHERE (co_email = ".$co_email[0]."); ";
						} else {
							$co_email_maximo = $co_email_maximo + 1;
							$co_email[0] = $co_email_maximo;
							$sql = $sql."INSERT INTO pessoas_emails (co_email, co_pessoa, no_email, ic_email_principal) ";
							$sql = $sql."VALUES (".$co_email[0].",".$co_pessoa.",'".$no_email[0]."','SIM'); ";
						}
						mysql_query($sql);
						$sql = "";
					}
					$sql = $sql."DELETE FROM pessoas_emails WHERE (co_pessoa = ".$co_pessoa.") AND (no_email != '".$no_email[0]."'); ";
					mysql_query($sql);
					$sql = "";
				} else {
					if ($emails > 0) {
						$sql2 = "DELETE FROM pessoas_emails WHERE (co_pessoa = ".$co_pessoa.") AND (no_email NOT IN (";
					}
					for ($i = 0 ; $i < $emails; $i++) {
						if ($no_email[$i] != '') {
							if ($i == 0) {
								$ic_email_principal[$i] = 'SIM';
								$sql2 = $sql2."'".$no_email[$i]."'";
							} else {
								$ic_email_principal[$i] = 'NAO';
								$sql2 = $sql2.",'".$no_email[$i]."'";
							}
							if ($co_email[$i] != '') {
								$sql = $sql."UPDATE pessoas_emails ";
								$sql = $sql."SET no_email = '".$no_email[$i]."', ic_email_principal = '".$ic_email_principal[$i]."' ";
								$sql = $sql."WHERE (co_email = ".$co_email[$i]."); ";
							} else {
								$co_email_maximo = $co_email_maximo + 1;
								$co_email[$i] = $co_email_maximo;
								$sql = $sql."INSERT INTO pessoas_emails (co_email, co_pessoa, no_email, ic_email_principal) ";
								$sql = $sql."VALUES (".$co_email[$i].",".$co_pessoa.",'".$no_email[$i]."','".$ic_email_principal[$i]."'); ";
							}
							mysql_query($sql);
							$sql = "";
						}
					}
					if ($sql2 != '') {
						$sql = $sql.$sql2.")); ";
						mysql_query($sql);
						$sql = "";
					}
				}
			}
		}

		$sql2 = "SELECT * FROM pessoas_enderecos WHERE (co_pessoa = ".$co_pessoa.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$sql2 = "";
			if (mysql_num_rows($rs2) == 0) {
				for ($i = 0 ; $i < $enderecos; $i++) {
					if (($co_endereco[$i] == '') && ($no_endereco[$i] != '')) {
						$co_endereco_maximo = $co_endereco_maximo + 1;
						$co_endereco[$i] = $co_endereco_maximo;
						$sql = $sql."INSERT INTO pessoas_enderecos (co_endereco, co_pessoa, no_endereco, no_bairro, no_cidade, co_uf, nu_cep, ic_endereco_principal) ";
						$sql = $sql."VALUES (".$co_endereco[$i].",".$co_pessoa.",'".$no_endereco[$i]."','".$no_bairro[$i]."','".$no_cidade[$i]."','".$co_uf[$i]."','".$nu_cep[$i]."','".$ic_endereco_principal[$i]."'); ";
						mysql_query($sql);
						$sql = "";
					}
				}
			} else {
				if ($enderecos == 1) {
					if ($no_endereco[0] != '') {
						if ($co_endereco[0] != '') {
							$sql = $sql."UPDATE pessoas_enderecos ";
							$sql = $sql."SET no_endereco = '".$no_endereco[0]."', no_bairro = '".$no_bairro[0]."', no_cidade = '".$no_cidade[0]."', co_uf = '".$co_uf[0]."', nu_cep = '".$nu_cep[0]."' ";
							$sql = $sql."WHERE (co_endereco = ".$co_endereco[0]."); ";
						} else {
							$co_endereco_maximo = $co_endereco_maximo + 1;
							$co_endereco[0] = $co_endereco_maximo;
							$sql = $sql."INSERT INTO pessoas_enderecos (co_endereco, co_pessoa, no_endereco, no_bairro, no_cidade, co_uf, nu_cep, ic_endereco_principal) ";
							$sql = $sql."VALUES (".$co_endereco[0].",".$co_pessoa.",'".$no_endereco[0]."','".$no_bairro[0]."','".$no_cidade[0]."','".$co_uf[0]."','".$nu_cep[0]."','SIM'); ";
						}
						mysql_query($sql);
						$sql = "";
						$sql = $sql."DELETE FROM pessoas_enderecos WHERE (co_pessoa = ".$co_pessoa.") AND (no_endereco != '".$no_endereco[0]."'); ";
						mysql_query($sql);
						$sql = "";
					}
				} else {
					if ($enderecos > 0) {
						$sql2 = "DELETE FROM pessoas_enderecos WHERE (co_pessoa = ".$co_pessoa.") AND (no_endereco NOT IN (";
					}
					for ($i = 0; $i < $enderecos; $i++) {
						if ($no_endereco[$i] != '') {
							if ($i == 0) {
								$ic_endereco_principal[$i] = 'SIM';
								$sql2 = $sql2."'".$no_endereco[$i]."'";
							} else {
								$ic_endereco_principal[$i] = 'NAO';
								$sql2 = $sql2.",'".$no_endereco[$i]."'";
							}
							if ($co_endereco[$i] != '') {
								$sql = $sql."UPDATE pessoas_enderecos ";
								$sql = $sql."SET no_endereco = '".$no_endereco[$i]."', no_bairro = '".$no_bairro[$i]."', no_cidade = '".$no_cidade[$i]."', co_uf = '".$co_uf[$i]."', nu_cep = '".$nu_cep[$i]."', ic_endereco_principal = '".$ic_endereco_principal[$i]."' ";
								$sql = $sql."WHERE (co_endereco = ".$co_endereco[$i]."); ";
							} else {
								$co_endereco_maximo = $co_endereco_maximo + 1;
								$co_endereco[$i] = $co_endereco_maximo;
								$sql = $sql."INSERT INTO pessoas_enderecos (co_endereco, co_pessoa, no_endereco, no_bairro, no_cidade, co_uf, nu_cep, ic_endereco_principal) ";
								$sql = $sql."VALUES (".$co_endereco[$i].",".$co_pessoa.",'".$no_endereco[$i]."','".$no_bairro[$i]."','".$no_cidade[$i]."','".$co_uf[$i]."','".$nu_cep[$i]."','".$ic_endereco_principal[$i]."'); ";
							}
							mysql_query($sql);
							$sql = "";
						}
					}
					if ($sql2 != '') {
						$sql = $sql.$sql2.")); ";
						mysql_query($sql);
						$sql = "";
					}
				}
			}
		}
		
		$sql2 = "SELECT PL.* FROM pessoas_lembrancas PL WHERE (PL.co_pessoa = ".$co_pessoa.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$sql2 = "";
			if (mysql_num_rows($rs2) == 0) {
				for ($i = 1 ; $i <= $lembrancas; $i++) {
					$sql = $sql."INSERT INTO pessoas_lembrancas (co_pessoa, co_tipo_lembranca, ic_lembranca) ";
					$sql = $sql."VALUES (".$co_pessoa.",'".$co_tipo_lembranca[$i]."','".$ic_lembranca[$i]."'); ";
					mysql_query($sql);
					$sql = "";
				}
			} else {
				for ($i = 1 ; $i <= $lembrancas; $i++) {
					$sql = $sql."UPDATE pessoas_lembrancas ";
					$sql = $sql."SET ic_lembranca = '".$ic_lembranca[$i]."' ";
					$sql = $sql."WHERE (co_tipo_lembranca = ".$co_tipo_lembranca[$i].") AND (co_pessoa = ".$co_pessoa."); ";
					mysql_query($sql);
					$sql = "";
				}
			}
		}
		
		$sql2 = "SELECT * FROM pessoas_grupos WHERE (co_pessoa = ".$co_pessoa.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$sql2 = "";
			if (mysql_num_rows($rs2) == 0) {
				for ($i = 0 ; $i < $grupos; $i++) {
					if ($co_grupo[$i] != '') {
						$sql3 = "SELECT * FROM pessoas_grupos WHERE (co_pessoa = ".$co_pessoa.") AND (co_grupo = ".$co_grupo[$i].");";
						$rs3 = mysql_query($sql3);
						if ($rs3) {
							if (mysql_num_rows($rs3) == 0) {
								$sql = $sql."INSERT INTO pessoas_grupos (co_pessoa, co_grupo, co_funcao) ";
								$sql = $sql."VALUES (".$co_pessoa.",".$co_grupo[$i].",'".$co_funcao_grupo[$i]."'); ";
								mysql_query($sql);
								$sql = "";
							}
						}
					}
				}
			} else {
				if ($grupos > 0) {
					$sql2 = "DELETE FROM pessoas_grupos WHERE (co_pessoa = ".$co_pessoa.") AND (co_grupo NOT IN (";
					for ($i = 0 ; $i < $grupos; $i++) {
						if ($co_grupo[$i] != '') {
							if ($i == 0) {
								$sql2 = $sql2."'".$co_grupo[$i]."'";
							} else {
								$sql2 = $sql2.",'".$co_grupo[$i]."'";
							}						
							if ($co_grupo_anterior[$i] != '') {
								$sql = $sql."UPDATE pessoas_grupos ";
								$sql = $sql."SET co_grupo = ".$co_grupo[$i].", co_funcao = '".$co_funcao_grupo[$i]."' ";
								$sql = $sql."WHERE (co_pessoa = ".$co_pessoa.") AND (co_grupo = ".$co_grupo_anterior[$i]."); ";
								mysql_query($sql);
								$sql = "";
							} else {
								$sql3 = "SELECT * FROM pessoas_grupos WHERE (co_pessoa = ".$co_pessoa.") AND (co_grupo = ".$co_grupo[$i].");";
								$rs3 = mysql_query($sql3);
								if ($rs3) {
									if (mysql_num_rows($rs3) == 0) {
										$sql = $sql."INSERT INTO pessoas_grupos (co_pessoa, co_grupo, co_funcao) ";
										$sql = $sql."VALUES (".$co_pessoa.",".$co_grupo[$i].",'".$co_funcao_grupo[$i]."'); ";
										mysql_query($sql);
										$sql = "";
									}
								}
							}
						}
					}
					$sql2 = $sql2.")); ";
				} else {
					$sql2 = "DELETE FROM pessoas_grupos WHERE (co_pessoa = ".$co_pessoa.");";
				}
				mysql_query($sql2);
				$sql2 = "";
			}
		}
				
		$sql2 = "SELECT * FROM pessoas_servicos WHERE (co_pessoa = ".$co_pessoa.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$sql2 = "";
			if (mysql_num_rows($rs2) == 0) {
				for ($i = 0 ; $i < $servicos; $i++) {
					if ($co_servico[$i] != '') {
						$sql3 = "SELECT * FROM pessoas_servicos WHERE (co_pessoa = ".$co_pessoa.") AND (co_servico = ".$co_servico[$i].");";
						$rs3 = mysql_query($sql3);
						if ($rs3) {
							if (mysql_num_rows($rs3) == 0) {
								$sql = $sql."INSERT INTO pessoas_servicos (co_pessoa, co_servico, co_funcao) ";
								$sql = $sql."VALUES (".$co_pessoa.",".$co_servico[$i].",'".$co_funcao_servico[$i]."'); ";
								mysql_query($sql);
								$sql = "";
							}
						}
					}
				}
			} else {
				if ($servicos > 0) {
					$sql2 = "DELETE FROM pessoas_servicos WHERE (co_pessoa = ".$co_pessoa.") AND (co_servico NOT IN (";
					for ($i = 0 ; $i < $servicos; $i++) {
						if ($co_servico[$i] != '') {
							if ($i == 0) {
								$sql2 = $sql2."'".$co_servico[$i]."'";
							} else {
								$sql2 = $sql2.",'".$co_servico[$i]."'";
							}						
							if ($co_servico_anterior[$i] != '') {
								$sql = $sql."UPDATE pessoas_servicos ";
								$sql = $sql."SET co_servico = ".$co_servico[$i].", co_funcao = '".$co_funcao_servico[$i]."' ";
								$sql = $sql."WHERE (co_pessoa = ".$co_pessoa.") AND (co_servico = ".$co_servico_anterior[$i]."); ";
								mysql_query($sql);
								$sql = "";
							} else {
								$sql3 = "SELECT * FROM pessoas_servicos WHERE (co_pessoa = ".$co_pessoa.") AND (co_servico = ".$co_servico[$i].");";
								$rs3 = mysql_query($sql3);
								if ($rs3) {
									if (mysql_num_rows($rs3) == 0) {
										$sql = $sql."INSERT INTO pessoas_servicos (co_pessoa, co_servico, co_funcao) ";
										$sql = $sql."VALUES (".$co_pessoa.",".$co_servico[$i].",'".$co_funcao_servico[$i]."'); ";
										mysql_query($sql);
										$sql = "";
									}
								}
							}
						}
					}
					$sql2 = $sql2.")); ";
				} else {
					$sql2 = "DELETE FROM pessoas_servicos WHERE (co_pessoa = ".$co_pessoa.");";
				}
				mysql_query($sql2);
				$sql2 = "";
			}
		}
		
		$sql2 = "SELECT * FROM pessoas_retiros WHERE (co_pessoa = ".$co_pessoa.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$sql2 = "";
			if (mysql_num_rows($rs2) == 0) {
				for ($i = 0; $i < $retiros; $i++) {
					if ($co_retiro[$i] != '') {
						$sql3 = "SELECT * FROM pessoas_retiros WHERE (co_pessoa = ".$co_pessoa.") AND (co_retiro = ".$co_retiro[$i].");";
						$rs3 = mysql_query($sql3);
						if ($rs3) {
							if (mysql_num_rows($rs3) == 0) {
								$sql = $sql."INSERT INTO pessoas_retiros (co_pessoa, co_retiro) ";
								$sql = $sql."VALUES (".$co_pessoa.",".$co_retiro[$i]."); ";
								mysql_query($sql);
								$sql = "";
							}
						}
					}
				}
			} else {
				for ($i = 0; $i < $retiros; $i++) {
					if ($co_retiro[$i] != '') {
						if ($co_retiro_anterior[$i] != '') {
							$sql = $sql."UPDATE pessoas_retiros ";
							$sql = $sql."SET co_retiro = ".$co_retiro[$i]." ";
							$sql = $sql."WHERE (co_pessoa = ".$co_pessoa.") AND (co_retiro = ".$co_retiro_anterior[$i]."); ";
							mysql_query($sql);
							$sql = "";
						} else {
							$sql3 = "SELECT * FROM pessoas_retiros WHERE (co_pessoa = ".$co_pessoa.") AND (co_retiro = ".$co_retiro[$i].");";
							$rs3 = mysql_query($sql3);
							if ($rs3) {
								if (mysql_num_rows($rs3) == 0) {
									$sql = $sql."INSERT INTO pessoas_retiros (co_pessoa, co_retiro) ";
									$sql = $sql."VALUES (".$co_pessoa.",".$co_retiro[$i]."); ";
									mysql_query($sql);
									$sql = "";
								}
							}
						}
					} else {					
						if ($co_retiro_anterior[$i] != '') {
							$sql = $sql."DELETE FROM pessoas_retiros ";
							$sql = $sql."WHERE (co_pessoa = ".$co_pessoa.") AND (co_retiro = ".$co_retiro_anterior[$i]."); ";
							mysql_query($sql);
							$sql = "";
						}
					}
				}
			}
		}

		if ($rs) {
			
			//echo "Cadastro atualizado com sucesso!";
			
			if ($co_pessoa_login == $co_pessoa) {
				if ($no_email[0] != '') {
					$email_remetente = 'luzquebrilha@obralumen.org.br';
					$assunto = 'Obra Lumen de Evangelização - Luz que Brilha - Cadastro atualizado com sucesso!';
					
					$mensagemHTML = '<html>';
					$mensagemHTML .= '<body style="font: Verdana black 10px;">';
					$mensagemHTML .= '<p><font size="3" color="blue"><b>'.$assunto.'</b></font></p>';
					$mensagemHTML .= '<hr>';
					$mensagemHTML .= '<b>'.$no_pessoa_completo.'</b>';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Convidamos você a acessar o nosso site ';
					$mensagemHTML .= '<a href="http://luzquebrilha.obralumen.org.br/"><b>luzquebrilha.obralumen.org.br</b></a> para realizar ';
					$mensagemHTML .= 'a sua atualização cadastral online, acompanhar o registro das suas contribuições realizadas, ';
					$mensagemHTML .= 'gerar boletos da CAIXA para realizar as suas contribuições/doações. Em breve, colocaremos também as informações ';
					$mensagemHTML .= 'das prestações de contas mensais.';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Login: <b>'.$no_email[0].'</b>';
					$mensagemHTML .= '<br>';
					$mensagemHTML .= 'Senha: <b>'.$nu_senha.'</b>';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Quaisquer dúvidas e sugestões, sugerimos entrar em contato através dos e-mails ';
					$mensagemHTML .= '<a href="mailto://projetoluzquebrilha@gmail.com">projetoluzquebrilha@gmail.com</a> ou ';
					$mensagemHTML .= '<a href="mailto://luzquebrilha@obralumen.org.br">luzquebrilha@obralumen.org.br</a>, do Facebook, ou através ';
					$mensagemHTML .= 'dos telefones (85) 3277-1713 ou (85) 9924-5999';
					$mensagemHTML .= '<hr>';
					$mensagemHTML .= '<p><font size="3" color="blue"><b>Luz e Paz!</b></font></p>';
					$mensagemHTML .= '</body>';
					$mensagemHTML .= '</html>';

					$headers = "MIME-Version: 1.1\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
					$headers .= "From: $email_remetente\r\n";
					$headers .= "Return-Path: $email_remetente\r\n";
					
					$sql3 = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
					$rs3 = mysql_query($sql3);
					if ($rs3) {
						$campo3 = mysql_fetch_array($rs3);
						$qtd_emails = $campo3["qtd_emails"];
						if ($qtd_emails < 350) {
							$envio = mail($no_email[0], $assunto, $mensagemHTML, $headers);
							$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email) ";
							$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email[0]."','".$assunto."','".$mensagemHTML."','cadastro_atualizado'); ";
							$rs3 = mysql_query($sql3);
							$qtd_emails = $qtd_emails + 1;
							$co_mensagem_maximo = $co_mensagem_maximo + 1;
							if ($no_email[1] != '') {
								if ($qtd_emails < 350) {
									$envio = mail($no_email[1], $assunto, $mensagemHTML, $headers);
									$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email) ";
									$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email[1]."','".$assunto."','".$mensagemHTML."','cadastro_atualizado'); ";
									$rs3 = mysql_query($sql3);
									$co_mensagem_maximo = $co_mensagem_maximo + 1;
								} else {
									?><script>window.alert('Limite de emails automáticos enviados hoje já foi excedido!');</script><?
								}
							}
						} else {
							?><script>window.alert('Limite de emails automáticos enviados hoje já foi excedido!');</script><?
						}
					}
				}
				
				?><script>window.alert('Cadastro atualizado com sucesso!');abrir(form,1,'cadastro.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa?>');</script><?
			} else {
				if ($no_email[0] != '') {
					$sql2 = "SELECT nu_senha FROM pessoas WHERE (co_pessoa = '".$co_pessoa."');";
					$rs2 = mysql_query($sql2);
					if ($rs2) {
						if (mysql_num_rows($rs2) > 0) {
							$campo2 = mysql_fetch_array($rs2);
							$nu_senha = $campo2["nu_senha"];
						}
					}

					$email_remetente = 'luzquebrilha@obralumen.org.br';
					$assunto = 'Obra Lumen de Evangelização - Luz que Brilha - Cadastro atualizado com sucesso!';
					
					$mensagemHTML = '<html>';
					$mensagemHTML .= '<body style="font: Verdana black 10px;">';
					$mensagemHTML .= '<p><font size="3" color="blue"><b>'.$assunto.'</b></font></p>';
					$mensagemHTML .= '<hr>';
					$mensagemHTML .= '<b>'.$no_pessoa_completo.'</b>';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Convidamos você a acessar o nosso site ';
					$mensagemHTML .= '<a href="http://luzquebrilha.obralumen.org.br/"><b>luzquebrilha.obralumen.org.br</b></a> para realizar ';
					$mensagemHTML .= 'a sua atualização cadastral online, acompanhar o registro das suas contribuições realizadas, ';
					$mensagemHTML .= 'gerar boletos da CAIXA para realizar as suas contribuições/doações. Em breve, colocaremos também as informações ';
					$mensagemHTML .= 'das prestações de contas mensais.';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Login: <b>'.$no_email[0].'</b>';
					$mensagemHTML .= '<br>';
					$mensagemHTML .= 'Senha: <b>'.$nu_senha.'</b>';
					$mensagemHTML .= '<br><br>';
					$mensagemHTML .= 'Quaisquer dúvidas e sugestões, sugerimos entrar em contato através dos e-mails ';
					$mensagemHTML .= '<a href="mailto://projetoluzquebrilha@gmail.com">projetoluzquebrilha@gmail.com</a> ou ';
					$mensagemHTML .= '<a href="mailto://luzquebrilha@obralumen.org.br">luzquebrilha@obralumen.org.br</a>, do Facebook, ou através ';
					$mensagemHTML .= 'dos telefones (85) 3277-1713 ou (85) 9924-5999';
					$mensagemHTML .= '<hr>';
					$mensagemHTML .= '<p><font size="3" color="blue"><b>Luz e Paz!</b></font></p>';
					$mensagemHTML .= '</body>';
					$mensagemHTML .= '</html>';

					$headers = "MIME-Version: 1.1\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
					$headers .= "From: $email_remetente\r\n";
					$headers .= "Return-Path: $email_remetente\r\n";
					
					$sql3 = "SELECT COUNT(*) AS qtd_emails FROM emails WHERE (dt_email = CURRENT_DATE) AND (TIMEDIFF(CURRENT_TIME, hr_email) < '01:00:00');";
					$rs3 = mysql_query($sql3);
					if ($rs3) {
						$campo3 = mysql_fetch_array($rs3);
						$qtd_emails = $campo3["qtd_emails"];
						if ($qtd_emails < 350) {
							$envio = mail($no_email[0], $assunto, $mensagemHTML, $headers);
							$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email) ";
							$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email[0]."','".$assunto."','".$mensagemHTML."','cadastro_atualizado'); ";
							$rs3 = mysql_query($sql3);
							$qtd_emails = $qtd_emails + 1;
							$co_mensagem_maximo = $co_mensagem_maximo + 1;
							if ($no_email[1] != '') {
								if ($qtd_emails < 350) {
									$envio = mail($no_email[1], $assunto, $mensagemHTML, $headers);
									$sql3 = "INSERT INTO emails (co_email, dt_email, hr_email, no_destinatario, de_assunto, de_mensagem, no_tipo_email) ";
									$sql3 = $sql3."VALUES (".$co_mensagem_maximo.", CURRENT_DATE, CURRENT_TIME,'".$no_email[1]."','".$assunto."','".$mensagemHTML."','cadastro_atualizado'); ";
									$rs3 = mysql_query($sql3);
									$co_mensagem_maximo = $co_mensagem_maximo + 1;
								} else {
									?><script>window.alert('Limite de emails automáticos enviados hoje já foi excedido!');</script><?
								}
							}
						} else {
							?><script>window.alert('Limite de emails automáticos enviados hoje já foi excedido!');</script><?
						}
					}
				}
				
				?><script>window.alert('Cadastro atualizado com sucesso!');abrir(form,1,'cadastro_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=');</script><?
			}
		}
}

if (($ic_login == 'sim') && ($co_pessoa != '')) {
	
		$sql = "SELECT P.* ";
		$sql = $sql."FROM pessoas P ";
		$sql = $sql."LEFT JOIN pessoas PC ON (P.co_pessoa = PC.co_pessoa) ";
		$sql = $sql."LEFT JOIN pessoas PA ON (P.co_pessoa = PA.co_pessoa) ";
		$sql = $sql."WHERE (P.co_pessoa = ".$co_pessoa.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$no_pessoa_completo = strtoupper(sem_acento($campo["no_pessoa_completo"]));
				$no_pessoa = strtoupper(sem_acento($campo["no_pessoa"]));
				$ic_membro_ativo = $campo["ic_membro_ativo"];
				if ($ic_membro_ativo == '') {
					$ic_membro_ativo = 'NAO';
				}
				$ic_fidelidade = $campo["ic_fidelidade"];
				if ($ic_fidelidade == '') {
					$ic_fidelidade = 'NAO';
				}
				$dt_nascimento = $campo["dt_nascimento"];
				if ($dt_nascimento != '') {
					$dt_nascimento = substr($dt_nascimento, 8, 2).'/'.substr($dt_nascimento, 5, 2).'/'.substr($dt_nascimento, 0, 4);
				}
				$dt_cadastro = $campo["dt_cadastro"];
				if ($dt_cadastro != '') {
					$dt_cadastro = substr($dt_cadastro, 8, 2).'/'.substr($dt_cadastro, 5, 2).'/'.substr($dt_cadastro, 0, 4);
				}
				$co_pessoa_cadastrou = $campo["co_pessoa_cadastrou"];
				$dt_atualizacao = $campo["dt_atualizacao"];
				if ($dt_atualizacao != '') {
					$dt_atualizacao = substr($dt_atualizacao, 8, 2).'/'.substr($dt_atualizacao, 5, 2).'/'.substr($dt_atualizacao, 0, 4);
				}
				$co_pessoa_atualizou = $campo["co_pessoa_atualizou"];

				$nu_senha = $campo["nu_senha"];
				$nu_senha1 = $nu_senha;
				$nu_senha2 = $nu_senha;
				$co_perfil = $campo["co_perfil"];
				
				$co_meu_sexo = $campo["co_sexo"];
				$ic_cadastro = $campo["ic_cadastro"];
				$co_estado_civil = $campo["co_estado_civil"];
				if ($co_estado_civil == '') {
					$co_estado_civil = 0;
				}
				$co_religiao = $campo["co_religiao"];
				if ($co_religiao == '') {
					$co_religiao = 0;
				}
				
				$co_tipo_pessoa = $campo["co_tipo_pessoa"];
				$nu_cpf_cnpj = $campo["nu_cpf_cnpj"];
				if (($co_tipo_pessoa != '') && ($nu_cpf_cnpj != '')) {
					if (($co_tipo_pessoa == 'PF') && (strlen($nu_cpf_cnpj) < 11)) {
						$qtd_zeros = 11 - strlen($nu_cpf_cnpj);
						for ($i = 1; $i <= $qtd_zeros; $i++) {
							$nu_cpf_cnpj = '0'.$nu_cpf_cnpj;
						}
	
					}
					if (($co_tipo_pessoa == 'PJ') && (strlen($nu_cpf_cnpj) < 14)) {
						$qtd_zeros = 14 - strlen($nu_cpf_cnpj);
						for ($i = 1; $i <= $qtd_zeros; $i++) {
							$nu_cpf_cnpj = '0'.$nu_cpf_cnpj;
						}
					}
				}
								
				$vr_oferta = $campo["vr_oferta"];
				if ($vr_oferta != '') {
					$vr_oferta = number_format($vr_oferta, 2, ',', '.');
				}
				$dd_oferta = $campo["dd_oferta"];
				$co_tipo_oferta = $campo["co_tipo_oferta"];
				$co_tipo_envio_boleto = $campo["co_tipo_envio_boleto"];
				
				$no_facebook = strtoupper(sem_acento($campo["no_facebook"]));
				$no_minha_profissao = strtoupper(sem_acento($campo["no_profissao"]));

				$sql2 = "SELECT PT.* FROM pessoas_telefones PT WHERE (PT.co_pessoa = ".$co_pessoa.") ORDER BY ic_telefone_principal DESC;";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$fones = 0;
					if (mysql_num_rows($rs2) > 0) {
						while ($fones < mysql_num_rows($rs2)) {
							$campo = mysql_fetch_array($rs2);
							$co_telefone[$fones] = $campo["co_telefone"];
							$nu_ddd_telefone[$fones] = $campo["nu_ddd_telefone"];
							$nu_telefone[$fones] = $campo["nu_telefone"];
							$co_tipo_telefone[$fones] = $campo["co_tipo_telefone"];
							$ic_telefone_principal[$fones] = $campo["ic_telefone_principal"];
							$fones = $fones + 1;
						}
					} else {
						$nu_ddd_telefone[$fones] = '';
						$nu_telefone[$fones] = '';
						$co_tipo_telefone[$fones] = '';
					}
				}
				
				$sql3 = "SELECT PEM.* FROM pessoas_emails PEM WHERE (PEM.co_pessoa = ".$co_pessoa.") ORDER BY ic_email_principal DESC;";
				$rs3 = mysql_query($sql3);
				if ($rs3) {
					$emails = 0;
					if (mysql_num_rows($rs3) > 0) {
						while ($emails < mysql_num_rows($rs3)) {
							$campo = mysql_fetch_array($rs3);
							$co_email[$emails] = $campo["co_email"];
							$no_email[$emails] = strtolower(sem_acento($campo["no_email"]));
							$ic_email_principal[$emails] = $campo["ic_email_principal"];
							$emails = $emails + 1;
						}
					} else {
						$no_email[$emails] = '';
					}
				}
				
				$sql4 = "SELECT PEN.* FROM pessoas_enderecos PEN WHERE (PEN.co_pessoa = ".$co_pessoa.") ORDER BY ic_endereco_principal DESC;";
				$rs4 = mysql_query($sql4);
				if ($rs4) {
					$enderecos = 0;
					if (mysql_num_rows($rs4) > 0) {
						while ($enderecos < mysql_num_rows($rs4)) {
							$campo = mysql_fetch_array($rs4);
							$co_endereco[$enderecos] = $campo["co_endereco"];
							$no_endereco[$enderecos] = strtoupper(sem_acento($campo["no_endereco"]));
							$no_bairro[$enderecos] = strtoupper(sem_acento($campo["no_bairro"]));
							$no_cidade[$enderecos] = strtoupper(sem_acento($campo["no_cidade"]));
							$co_uf[$enderecos] = $campo["co_uf"];
							if ($campo["nu_cep"] != '') {
								$nu_cep[$enderecos] = substr($campo["nu_cep"],0,2).'.'.substr($campo["nu_cep"],2,3).'-'.substr($campo["nu_cep"],5,3);
							}
							$ic_endereco_principal[$enderecos] = $campo["ic_endereco_principal"];
							$enderecos = $enderecos + 1;
						}
					} else {
						$no_endereco[$enderecos] = '';
						$no_bairro[$enderecos] = '';
						$no_cidade[$enderecos] = '';
						$co_uf[$enderecos] = '';
						$nu_cep[$enderecos] = '';
					}
				}
				
				$sql5 = "SELECT * FROM pessoas_lembrancas WHERE (co_pessoa = ".$co_pessoa.");";
				$rs5 = mysql_query($sql5);
				if ($rs5) {
					$lembrancas = 0;
					if (mysql_num_rows($rs5) > 0) {
						while ($lembrancas < mysql_num_rows($rs5)) {
							$campo = mysql_fetch_array($rs5);
							$lembrancas = $lembrancas + 1;
							$co_tipo_lembranca[$lembrancas] = $campo["co_tipo_lembranca"];
							$ic_lembranca[$lembrancas] = $campo["ic_lembranca"];
						}
					}
				}
				
				$sql6 = "SELECT * FROM pessoas_grupos WHERE (co_pessoa = ".$co_pessoa.");";
				$rs6 = mysql_query($sql6);
				if ($rs6) {
					$grupos = 0;
					if (mysql_num_rows($rs6) > 0) {
						while ($grupos < mysql_num_rows($rs6)) {
							$campo = mysql_fetch_array($rs6);
							$co_grupo[$grupos] = $campo["co_grupo"];
							$co_grupo_anterior[$grupos] = $co_grupo[$grupos];
							$co_funcao_grupo[$grupos] = $campo["co_funcao"];
							$grupos = $grupos + 1;
						}
					} else {
						$co_grupo[$grupos] = '';
					}
				}
				
				$sql6 = "SELECT * FROM pessoas_servicos WHERE (co_pessoa = ".$co_pessoa.");";
				$rs6 = mysql_query($sql6);
				if ($rs6) {
					$servicos = 0;
					if (mysql_num_rows($rs6) > 0) {
						while ($servicos < mysql_num_rows($rs6)) {
							$campo = mysql_fetch_array($rs6);
							$co_servico[$servicos] = $campo["co_servico"];
							$co_servico_anterior[$servicos] = $co_servico[$servicos];
							$co_funcao_servico[$servicos] = $campo["co_funcao"];
							$servicos = $servicos + 1;
						}
					} else {
						$co_servico[$servicos] = '';
					}
				}
				
				$sql7 = "SELECT * FROM pessoas_retiros PR LEFT JOIN retiros R ON (PR.co_retiro = R.co_retiro) ";
				$sql7 = $sql7."WHERE (PR.co_pessoa = ".$co_pessoa.") AND (R.co_tipo_retiro = 1);";
				$rs7 = mysql_query($sql7);
				if ($rs7) {
					$retiros = 0;
					if (mysql_num_rows($rs7) > 0) {
						$campo = mysql_fetch_array($rs7);
						$co_retiro[$retiros] = $campo["co_retiro"];
						$co_retiro_anterior[$retiros] = $co_retiro[$retiros];
					} else {
						$co_retiro[$retiros] = '';
					}
				}
				$sql7 = "SELECT * FROM pessoas_retiros PR LEFT JOIN retiros R ON (PR.co_retiro = R.co_retiro) ";
				$sql7 = $sql7."WHERE (PR.co_pessoa = ".$co_pessoa.") AND (R.co_tipo_retiro = 2);";
				$rs7 = mysql_query($sql7);
				if ($rs7) {
					$retiros = 1;
					if (mysql_num_rows($rs7) > 0) {
						$campo = mysql_fetch_array($rs7);
						$co_retiro[$retiros] = $campo["co_retiro"];
						$co_retiro_anterior[$retiros] = $co_retiro[$retiros];
					} else {
						$co_retiro[$retiros] = '';
					}
				}
				$sql7 = "SELECT * FROM pessoas_retiros PR LEFT JOIN retiros R ON (PR.co_retiro = R.co_retiro) ";
				$sql7 = $sql7."WHERE (PR.co_pessoa = ".$co_pessoa.") AND (R.co_tipo_retiro = 5);";
				$rs7 = mysql_query($sql7);
				if ($rs7) {
					$retiros = 2;
					if (mysql_num_rows($rs7) > 0) {
						$campo = mysql_fetch_array($rs7);
						$co_retiro[$retiros] = $campo["co_retiro"];
						$co_retiro_anterior[$retiros] = $co_retiro[$retiros];
					} else {
						$co_retiro[$retiros] = '';
					}
				}
				$sql7 = "SELECT * FROM pessoas_retiros PR LEFT JOIN retiros R ON (PR.co_retiro = R.co_retiro) ";
				$sql7 = $sql7."WHERE (PR.co_pessoa = ".$co_pessoa.") AND (R.co_tipo_retiro IN (3,4,6));";
				$rs7 = mysql_query($sql7);
				if ($rs7) {
					$retiros = 3;
					if (mysql_num_rows($rs7) > 0) {
						while (($retiros - 3) < mysql_num_rows($rs7)) {
							$campo = mysql_fetch_array($rs7);
							$co_retiro[$retiros] = $campo["co_retiro"];
							$co_retiro_anterior[$retiros] = $co_retiro[$retiros];
							$retiros = $retiros + 1;
						}
					} else {
						$co_retiro[$retiros] = '';
					}
				}
			}
		}
}
?>

<script language="javascript">
	function salvar_pessoa (comando) {
		if ((document.forms["form"]["no_pessoa"].value == '') && (document.forms["form"]["no_pessoa_completo"].value == '')) {
			window.alert('Favor preencher, pelo menos, 1 dos 2 campos: NOME COMPLETO e CONHECIDO POR!');
		} else if ((document.forms["form"]["dt_nascimento"].value != '') && ((document.forms["form"]["dt_nascimento"].value.substring(2,3) != '/') || (document.forms["form"]["dt_nascimento"].value.substring(5,6) != '/') || (document.forms["form"]["dt_nascimento"].value.length != 10))) {
			window.alert('Favor preencher o campo DATA DE NASCIMENTO neste formato com as barras: DD/MM/AAAA');
		} else if ((document.forms["form"]["dt_nascimento"].value != '') && ((parseInt(document.forms["form"]["dt_nascimento"].value.substring(0,2)) == 0) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 0) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(6,10)) == 0) || ((parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 2) && (parseInt(document.forms["form"]["dt_nascimento"].value.substring(0,2)) > 29)) || (((parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 4) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 6) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 9) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 11)) && (parseInt(document.forms["form"]["dt_nascimento"].value.substring(0,2)) > 30)) || (((parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 1) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 3) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 5) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 7) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 8) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 10) || (parseInt(document.forms["form"]["dt_nascimento"].value.substring(3,5)) == 12)) && (parseInt(document.forms["form"]["dt_nascimento"].value.substring(0,2)) > 31)))) {
			window.alert('Favor preencher o campo DATA DE NASCIMENTO com uma data correta!');
		} else if ((document.forms["form"]["nu_telefone0"].value == '') && (document.forms["form"]["no_email0"].value == '') && (document.forms["form"]["nu_cpf_cnpj"].value == '')) {
			window.alert('Favor preencher, pelo menos, 1 dos 3 campos: TELEFONE, EMAIL ou CPF/CNPJ');
		} else if (((document.forms["form"]["nu_telefone0"].value != '') && (document.forms["form"]["nu_ddd_telefone0"].value == '')) || ((document.forms["form"]["nu_telefone0"].value == '') && (document.forms["form"]["nu_ddd_telefone0"].value != ''))) {
			window.alert('Favor preencher os campos DDD e TELEFONE!');
		} else if ((document.forms["form"]["vr_oferta"].value != '') && (document.forms["form"]["co_tipo_oferta"].value == '1') && (document.forms["form"]["nu_cpf_cnpj"].value == '')) {
			window.alert('Favor preencher o campo CPF/CNPJ!');
		} else if ((document.forms["form"]["co_tipo_pessoa"].value == '') && (document.forms["form"]["nu_cpf_cnpj"].value != '')) {
			window.alert('Favor escolher o TIPO DE PESSOA!');
		} else if ((document.forms["form"]["dd_oferta"].value != '') && ((parseInt(document.forms["form"]["dd_oferta"].value) == 0) || (parseInt(document.forms["form"]["dd_oferta"].value) > 30))) {
			window.alert('Favor preencher o campo DIA DA OFERTA com um dia de 1 a 30!');
		} else if ((document.forms["form"]["nu_cpf_cnpj"].value != '') && (document.forms["form"]["co_tipo_pessoa"].value == 'PF') && (document.forms["form"]["nu_cpf_cnpj"].value.length > 11)) {
			window.alert('Favor preencher o campo CPF com somente e até 11 números!');
		} else if ((document.forms["form"]["vr_oferta"].value != '') && (document.forms["form"]["co_tipo_oferta"].value == '1') && (document.forms["form"]["co_tipo_envio_boleto"].value == '0')) {
			window.alert('Favor escolher como gostaria de receber o BOLETO BANCÁRIO!');
		} else if (document.forms["form"]["co_pessoa_login"].value == document.forms["form"]["co_pessoa"].value) {
			if ((document.forms["form"]["nu_senha1"].value == '') || (document.forms["form"]["nu_senha2"].value == '')) {
				window.alert('Favor preencher os campos de SENHA');
			} else if (document.forms["form"]["nu_senha1"].value != document.forms["form"]["nu_senha2"].value) {
				window.alert('Favor repetir a mesma senha nos 2 campos de SENHA!');
			} else {
				abrir(form,1,'cadastro.php','comando=' + comando);
			}
		} else {
			abrir(form,1,'cadastro.php','comando=' + comando);
		}
	}
	function como_ofertara() {
		if ((document.getElementById("co_tipo_oferta").value != 1) && (document.getElementById("co_tipo_envio_boleto").value != 0)) {
			document.getElementById("co_tipo_envio_boleto").value = 0;
		}
	}
	function contribuinte_fiel() {
		if (document.getElementById("ic_fidelidade").checked) {
			$("#luz_que_brilha").show();
		} else {
			$("#luz_que_brilha").hide();
		}
	}
	function participante_ativo() {
		if (document.getElementById("ic_membro_ativo").checked) {
			$("#grupos").show();
			$("#servicos").show();
			$("#retiros").show();
		} else {
			$("#grupos").hide();
			$("#servicos").hide();
			$("#retiros").hide();
		}
	}
</script>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	Meu Cadastro <br>
</font>

<table width="100%" cellpadding="2" cellspacing="5">
	<tr>
		<td align="right" valign="middle">
			<input type="button" id="botao" name="botao" value="<?=$botao?>" class="botao" onClick="salvar_pessoa('<?=$botao?>');">
		</td>
	</tr>
</table>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">DADOS PRINCIPAIS</font></legend>

<table width="90%" align="left" cellpadding="2" cellspacing="5">
	<tr>
<?
if ($co_perfil_login == '1') {
?>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Perfil de Acesso:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select name="co_perfil">
<?
	$sql = "SELECT * FROM perfis ";
	$sql = $sql."WHERE (co_perfil >= ".$co_perfil_login.") ";
	$sql = $sql."ORDER BY co_perfil DESC;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_perfil == $campo["co_perfil"]) {
?>
				<option value="<?=$campo["co_perfil"]?>" selected><?=$campo["co_perfil"]?> - <?=utf8_encode($campo["no_perfil"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_perfil"]?>"><?=$campo["co_perfil"]?> - <?=utf8_encode($campo["no_perfil"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Cadastro:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select name="ic_cadastro">
<?
			if ($ic_cadastro == '') {
?>
				<option value="" selected>
				<option value="A">ATIVO
				<option value="I">INATIVO
<?
			} else {
				if ($ic_cadastro == 'A') {
?>
				<option value="">
				<option value="A" selected>ATIVO
				<option value="I">INATIVO
<?
				} else if ($ic_cadastro == 'I') {
?>
				<option value="">
				<option value="A">ATIVO
				<option value="I" selected>INATIVO
<?
				} else {
?>
				<option value="">
				<option value="A">ATIVO
				<option value="I">INATIVO
<?
				}
			}
?>
			</select>
		</td>
<?
}
?>
	</tr>
</table>
	
<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Nome Completo:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="text" name="no_pessoa_completo" value="<?=$no_pessoa_completo?>" placeholder="nome completo" size="30" maxlength="80">
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Conhecido(a) por:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="text" name="no_pessoa" value="<?=$no_pessoa?>" placeholder="nome pelo qual é conhecido(a)" size="30" maxlength="40">
		</td>
	</tr>
</table>


<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
<?
	if (($dt_nascimento != '') && (substr($dt_nascimento, 4, 1) == '-')) {
		$dt_nascimento = substr($dt_nascimento, 8, 2).'/'.substr($dt_nascimento, 5, 2).'/'.substr($dt_nascimento, 0, 4);
	}
?>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Data de Nascimento:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="text" name="dt_nascimento" value="<?=$dt_nascimento?>" placeholder="___/___/______" size="15" maxlength="10" onkeypress="javascript: return validaData(document.form.dt_nascimento, window.event);">
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Facebook:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="text" name="no_facebook" value="<?=$no_facebook?>" placeholder="meu nome no Facebook" size="30" maxlength="30">
		</td>
	</tr>
</table>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Sexo:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select name="co_meu_sexo">
<?
			if ($co_meu_sexo == '') {
?>
				<option value="" selected>
				<option value="M">MASCULINO
				<option value="F">FEMININO
<?
			} else {
				if ($co_meu_sexo == 'M') {
?>
				<option value="">
				<option value="M" selected>MASCULINO
				<option value="F">FEMININO
<?
				} else if ($co_meu_sexo == 'F') {
?>
				<option value="">
				<option value="M">MASCULINO
				<option value="F" selected>FEMININO
<?
				} else {
?>
				<option value="">
				<option value="M">MASCULINO
				<option value="F">FEMININO
<?
				}
			}
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Estado Civil:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select name="co_estado_civil">
<?
	$sql = "SELECT * FROM tipos_estados_civil ORDER BY co_estado_civil;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_estado_civil == $campo["co_estado_civil"]) {
?>
				<option value="<?=$campo["co_estado_civil"]?>" selected><?=utf8_encode($campo["no_estado_civil"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_estado_civil"]?>"><?=utf8_encode($campo["no_estado_civil"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
	</tr>
</table>

<table width="90%" cellpadding="2" cellspacing="5">	
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Religião:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select name="co_religiao">
<?
	$sql = "SELECT * FROM tipos_religiao ORDER BY co_religiao;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_religiao == $campo["co_religiao"]) {
?>
				<option value="<?=$campo["co_religiao"]?>" selected><?=utf8_encode($campo["no_religiao"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_religiao"]?>"><?=utf8_encode($campo["no_religiao"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Profissão:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="text" name="no_minha_profissao" value="<?=$no_minha_profissao?>" placeholder="nome da minha profissão" size="30" maxlength="60">
		</td>
	</tr>
</table>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
<?
$fones = 2;
for ($i = 0; $i < $fones; $i++) {
	if ($i == 0) {
		$cabecalho = 'Telefone Principal';
	} else {
		$cabecalho = 'Telefone Opcional';
	}
?>
		<input type="hidden" id="co_telefone<?=$i?>" name="co_telefone<?=$i?>" value="<?=$co_telefone[$i]?>">
		<td width="15%" align="left" valign="middle">
			<font class="font10azul"><?=$cabecalho?>:</font>
		</td>
		<td width="35%" align="left" valign="middle">		
			<input type="text" name="nu_ddd_telefone<?=$i?>" placeholder="DDD" value="<?=$nu_ddd_telefone[$i]?>" size="2" maxlength="2" onkeypress="javascript: return validaSomenteNumeros(window.event);">
			<input type="text" name="nu_telefone<?=$i?>" value="<?=$nu_telefone[$i]?>" placeholder="<?=$cabecalho?>" size="10" maxlength="9" onkeypress="javascript: return validaSomenteNumeros(window.event);">
			<select name="co_tipo_telefone<?=$i?>">
<?
			if ($co_tipo_telefone[$i] == '') {
?>
				<option value="" selected>
<?
			} else {
?>
				<option value="">
<?
			}
	$sql = "SELECT * FROM tipos_telefones ORDER BY co_tipo_telefone;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_tipo_telefone[$i] == $campo["co_tipo_telefone"]) {
?>
				<option value="<?=$campo["co_tipo_telefone"]?>" selected><?=utf8_encode($campo["no_tipo_telefone"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_tipo_telefone"]?>"><?=utf8_encode($campo["no_tipo_telefone"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
<?
}
?>
	</tr>
</table>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
<?
$emails = 2;
for ($i = 0; $i < $emails; $i++) {
	if ($i == 0) {
		$cabecalho = 'E-mail Principal';
	} else {
		$cabecalho = 'E-mail Opcional';
	}
?>
		<input type="hidden" id="co_email<?=$i?>" name="co_email<?=$i?>" value="<?=$co_email[$i]?>">
		<td width="15%" align="left" valign="middle">
			<font class="font10azul"><?=$cabecalho?>:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="text" name="no_email<?=$i?>" value="<?=$no_email[$i]?>" placeholder="<?=$cabecalho?>" size="30" maxlength="60">
		</td>
<?
}
?>
	</tr>
</table>

<?
$enderecos = 2;
for ($i = 0; $i < $enderecos; $i++) {
	if ($i == 0) {
		$cabecalho = 'Endereço Principal';
	} else {
		$cabecalho = 'Endereço Opcional';
	}
?>
<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<input type="hidden" name="co_endereco<?=$i?>" value="<?=$co_endereco[$i]?>">
		<td align="left" valign="middle">
			<font class="font10azul"><?=$cabecalho?>:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_endereco<?=$i?>" value="<?=$no_endereco[$i]?>" placeholder="nome da rua/avenida, número e complemento" size="20" maxlength="60">
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Bairro:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_bairro<?=$i?>" value="<?=$no_bairro[$i]?>" placeholder="nome do bairro" size="10" maxlength="40">
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Cidade:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_cidade<?=$i?>" value="<?=$no_cidade[$i]?>" placeholder="nome da cidade" size="10" maxlength="40">
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">UF:</font>
		</td>
		<td align="left" valign="middle">
			<select name="co_uf<?=$i?>">
				<option value="" selected>
<?
		for ($j = 1; $j <= $estados; $j++) {
			if ($co_uf[$i] == $estado[$j]) {
?>
				<option value="<?=$estado[$j]?>" selected><?=$estado[$j]?>
<?
			} else {
?>
				<option value="<?=$estado[$j]?>"><?=$estado[$j]?>
<?
			}
		}
?>
			</select>
			
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">CEP:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" id="nu_cep<?=$i?>" name="nu_cep<?=$i?>" value="<?=$nu_cep[$i]?>" placeholder="só números" size="10" maxlength="10" onkeypress="javascript: return validaCEP(document.form.nu_cep<?=$i?>, window.event);">
		</td>
	</tr>
</table>
<?
}
?>

<?
if ($co_pessoa_login == $co_pessoa) {
?>
<table width="90%" align="left" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Senha:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="password" name="nu_senha1" value="<?=$nu_senha1?>" placeholder="máximo de 15 caracteres" size="25" maxlength="15">
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Repetir a Senha:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="password" name="nu_senha2" value="<?=$nu_senha2?>" placeholder="máximo de 15 caracteres" size="25" maxlength="15">
		</td>
	</tr>
</table>
<?
}
?>

<br>

<table width="90%" align="left" cellpadding="2" cellspacing="5">
	<tr>
		<td width="50%" align="left" valign="middle">
<?
		if ($ic_fidelidade == 'SIM') {
?>
			<input type="checkbox" id="ic_fidelidade" name="ic_fidelidade" onChange="javascript: contribuinte_fiel();" checked><font class="font10azul">Você é, ou deseja ser, um membro luz que brilha fidelidade?</font>
<?
		} else {
?>
			<input type="checkbox" id="ic_fidelidade" name="ic_fidelidade" onChange="javascript: contribuinte_fiel();"><font class="font10azul">Você é, ou deseja ser, um membro luz que brilha fidelidade?</font>
<?
		}
?>
		</td>
		<td width="50%" align="left" valign="middle">
<?
		if ($ic_membro_ativo == 'SIM') {
?>
			<input type="checkbox" id="ic_membro_ativo" name="ic_membro_ativo" onChange="javascript: participante_ativo();" checked><font class="font10azul">Você é participante do Lumen?</font>
<?
		} else {
?>
			<input type="checkbox" id="ic_membro_ativo" name="ic_membro_ativo" onChange="javascript: participante_ativo();"><font class="font10azul">Você é participante do Lumen?</font>
<?
		}
?>
		</td>
	</tr>
</table>

</fieldset>

<br>

<div id="luz_que_brilha" style="display:none">

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">LUZ QUE BRILHA</font></legend>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Tipo de Pessoa:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select name="co_tipo_pessoa">
<?
			if ($co_tipo_pessoa == '') {
?>
				<option value="" selected>
				<option value="PF">PESSOA FÍSICA
				<option value="PJ">PESSOA JURÍDICA
<?
			} else {
				if ($co_tipo_pessoa == 'PF') {
?>
				<option value="">
				<option value="PF" selected>PESSOA FÍSICA
				<option value="PJ">PESSOA JURÍDICA
<?
				} else if ($co_tipo_pessoa == 'PJ') {
?>
				<option value="">
				<option value="PF">PESSOA FÍSICA
				<option value="PJ" selected>PESSOA JURÍDICA
<?
				} else {
?>
				<option value="">
				<option value="PF">PESSOA FÍSICA
				<option value="PJ">PESSOA JURÍDICA
<?
				}
			}
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">CPF/CNPJ:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="text" name="nu_cpf_cnpj" value="<?=$nu_cpf_cnpj?>" placeholder="só números" size="17" maxlength="14" onkeypress="javascript: return validaSomenteNumeros(window.event);">
		</td>
	</tr>
</table>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Valor Mensal:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="text" name="vr_oferta" value="<?=$vr_oferta?>" placeholder="valor em reais" size="12" maxlength="12">
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Dia da Oferta:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select id="dd_oferta" name="dd_oferta">
<?
			for ($d = 5; $d <= 25; $d = $d + 5) {
				if ($dd_oferta == $d) {
?>
				<option value="<?=$d?>" selected><?=$d?>
<?
				} else {
?>
				<option value="<?=$d?>"><?=$d?>
<?
				}
			}
?>
			</select>
		</td>
	</tr>
</table>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Como ofertará?</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select id="co_tipo_oferta" name="co_tipo_oferta" onChange="javascript: como_ofertara();">
<?
	$sql = "SELECT * FROM tipos_ofertas ORDER BY co_tipo_oferta;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_tipo_oferta == $campo["co_tipo_oferta"]) {
?>
				<option value="<?=$campo["co_tipo_oferta"]?>" selected><?=utf8_encode($campo["no_tipo_oferta"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_tipo_oferta"]?>"><?=utf8_encode($campo["no_tipo_oferta"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Enviar BOLETO:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<select id="co_tipo_envio_boleto" name="co_tipo_envio_boleto" onChange="javascript: como_ofertara();">
<?
	$sql = "SELECT * FROM tipos_envios ORDER BY co_tipo_envio;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_tipo_envio_boleto == $campo["co_tipo_envio"]) {
?>
				<option value="<?=$campo["co_tipo_envio"]?>" selected><?=utf8_encode($campo["no_tipo_envio"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_tipo_envio"]?>"><?=utf8_encode($campo["no_tipo_envio"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
	</tr>
</table>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Lembrar-me por:</font>
		</td>
<?
	$sql = "SELECT * FROM tipos_lembrancas ORDER BY co_tipo_lembranca;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$i = 1;
			$lembrancas = mysql_num_rows($rs);
			while ($i <= $lembrancas) {
				$campo = mysql_fetch_array($rs);
				$cotipo_lembranca = $campo["co_tipo_lembranca"];
				$notipo_lembranca = $campo["no_tipo_lembranca"];
?>
		<td width="17%" align="left" valign="middle">
<?
				if ($ic_lembranca[$cotipo_lembranca] == 'SIM') {
?>
				<input type="checkbox" name="ic_lembranca<?=$cotipo_lembranca?>" checked><font class="font10azul"><?=utf8_encode($notipo_lembranca)?></font>
<?
				} else {
?>
				<input type="checkbox" name="ic_lembranca<?=$cotipo_lembranca?>"><font class="font10azul"><?=utf8_encode($notipo_lembranca)?></font>
<?
				}
?>
		</td>
<?
				$i = $i + 1;
			}
		}
	}
?>
	</tr>
</table>

</fieldset>

<br>

</div>

<div id="grupos" style="display:none">

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">GRUPOS</font></legend>
<?
$grupos = 2;
?>
<input type="hidden" name="grupos" value="<?=$grupos?>">

<?
for ($i = 0; $i < $grupos; $i++) {
?>
<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Participa do(a):</font>
		</td>
		<td width="35%" align="left" valign="middle">	
			<input type="hidden" name="co_grupo_anterior<?=$i?>" value="<?=$co_grupo[$i]?>">
			<select name="co_grupo<?=$i?>">
				<option value="">
<?
	$sql = "SELECT * FROM grupos ORDER BY no_grupo;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;

			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_grupo[$i] == $campo["co_grupo"]) {
?>
				<option value="<?=$campo["co_grupo"]?>" selected><?=utf8_encode($campo["no_grupo"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_grupo"]?>"><?=utf8_encode($campo["no_grupo"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Função:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="hidden" name="co_funcao_grupo_anterior<?=$i?>" value="<?=$co_funcao_grupo[$i]?>">
			<select name="co_funcao_grupo<?=$i?>">
				<option value="">
<?
	$sql = "SELECT * FROM tipos_funcoes ORDER BY no_funcao;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;

			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_funcao_grupo[$i] == $campo["co_funcao"]) {
?>
				<option value="<?=$campo["co_funcao"]?>" selected><?=utf8_encode($campo["no_funcao"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_funcao"]?>"><?=utf8_encode($campo["no_funcao"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
	</tr>
</table>
<?
}
?>

</fieldset>
	
<br>

</div>

<div id="servicos" style="display:none">

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">SERVIÇOS</font></legend>
<?
$servicos = 3;
?>
<input type="hidden" name="servicos" value="<?=$servicos?>">

<?
for ($i = 0; $i < $servicos; $i++) {
?>
<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Participa do(a):</font>
		</td>
		<td width="35%" align="left" valign="middle">	
			<input type="hidden" name="co_servico_anterior<?=$i?>" value="<?=$co_servico[$i]?>">
			<select name="co_servico<?=$i?>">
				<option value="">
<?
	$sql = "SELECT * FROM servicos ORDER BY no_servico;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;

			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_servico[$i] == $campo["co_servico"]) {
?>
				<option value="<?=$campo["co_servico"]?>" selected><?=utf8_encode($campo["no_servico"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_servico"]?>"><?=utf8_encode($campo["no_servico"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Função:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="hidden" name="co_funcao_servico_anterior<?=$i?>" value="<?=$co_funcao_servico[$i]?>">
			<select name="co_funcao_servico<?=$i?>">
				<option value="">
<?
	$sql = "SELECT * FROM tipos_funcoes ORDER BY no_funcao;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;

			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_funcao_servico[$i] == $campo["co_funcao"]) {
?>
				<option value="<?=$campo["co_funcao"]?>" selected><?=utf8_encode($campo["no_funcao"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_funcao"]?>"><?=utf8_encode($campo["no_funcao"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
	</tr>
</table>
<?
}
?>

</fieldset>

<br>

</div>

<div id="retiros" style="display:none">

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">RETIROS</font></legend>
<?
$retiros = 4;
$i = 0;
?>
<input type="hidden" name="retiros" value="<?=$retiros?>">

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Despertar:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="hidden" name="co_retiro_anterior<?=$i?>" value="<?=$co_retiro[$i]?>">
			<select name="co_retiro<?=$i?>">
				<option value="">
<?
	$sql = "SELECT * FROM retiros WHERE (co_tipo_retiro = 1) ORDER BY co_ordem;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_retiro[$i] == $campo["co_retiro"]) {
?>
				<option value="<?=$campo["co_retiro"]?>" selected><?=utf8_encode($campo["no_retiro"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_retiro"]?>"><?=utf8_encode($campo["no_retiro"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
	$i = 1;
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Discipulado:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="hidden" name="co_retiro_anterior<?=$i?>" value="<?=$co_retiro[$i]?>">
			<select name="co_retiro<?=$i?>">
				<option value="">
<?
	$sql = "SELECT * FROM retiros WHERE (co_tipo_retiro = 2) ORDER BY no_retiro;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_retiro[$i] == $campo["co_retiro"]) {
?>
				<option value="<?=$campo["co_retiro"]?>" selected><?=utf8_encode($campo["no_retiro"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_retiro"]?>"><?=utf8_encode($campo["no_retiro"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
	$i = 2;
?>
			</select>
		</td>
	</tr>
</table>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Vocacional:</font>
		</td>
		<td width="35%" align="left" valign="middle">
			<input type="hidden" name="co_retiro_anterior<?=$i?>" value="<?=$co_retiro[$i]?>">
			<select name="co_retiro<?=$i?>">
				<option value="">
<?
	$sql = "SELECT * FROM retiros WHERE (co_tipo_retiro = 5) ORDER BY no_retiro;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_retiro[$i] == $campo["co_retiro"]) {
?>
				<option value="<?=$campo["co_retiro"]?>" selected><?=utf8_encode($campo["no_retiro"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_retiro"]?>"><?=utf8_encode($campo["no_retiro"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
		<td width="15%" align="left" valign="middle">
			<font class="font10azul">Outros:</font>
		</td>
		<td width="35%" align="left" valign="middle">
<?
for ($i = 3; $i < $retiros; $i++) {
?>
			<input type="hidden" name="co_retiro_anterior<?=$i?>" value="<?=$co_retiro[$i]?>">
			<select name="co_retiro<?=$i?>">
				<option value="">
<?
	$sql = "SELECT * FROM retiros WHERE (co_tipo_retiro IN (3,4,6)) ORDER BY no_retiro;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_retiro[$i] == $campo["co_retiro"]) {
?>
				<option value="<?=$campo["co_retiro"]?>" selected><?=utf8_encode($campo["no_retiro"])?>
<?
				} else {
?>
				<option value="<?=$campo["co_retiro"]?>"><?=utf8_encode($campo["no_retiro"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
<?
}
?>
		</td>
	</tr>
</table>

</fieldset>

</div>
	
<table width="100%" cellpadding="2" cellspacing="5">
	<tr>
		<td align="right" valign="middle">
			<input type="button" id="botao" name="botao" value="<?=$botao?>" class="botao" onClick="salvar_pessoa('<?=$botao?>');">
		</td>
	</tr>
</table>

<br><br><br>

</div>

<script language="javascript">
	participante_ativo();
	contribuinte_fiel();
</script>