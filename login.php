<?
$ic_login = isset($_GET['ic_login']) ? $_GET['ic_login'] : (isset($_POST['ic_login']) ? $_POST['ic_login'] : '');

$co_pessoa = isset($_GET['co_pessoa']) ? $_GET['co_pessoa'] : (isset($_POST['co_pessoa']) ? $_POST['co_pessoa'] : '');

$co_pessoa_login = isset($_GET['co_pessoa_login']) ? $_GET['co_pessoa_login'] : (isset($_POST['co_pessoa_login']) ? $_POST['co_pessoa_login'] : '');

if (($co_pessoa_login != '') && ($ic_login == '')) {
	$ic_login = 'sim';
}

$co_visita = isset($_GET['co_visita']) ? $_GET['co_visita'] : (isset($_POST['co_visita']) ? $_POST['co_visita'] : '');

if ($ic_login == 'logon') {
	$login = isset($_POST['no_login']) ? strtolower($_POST['no_login']) : '';
	$senha = isset($_POST['no_senha']) ? strtolower($_POST['no_senha']) : '';

	$sql = "SELECT P.* ";
	$sql = $sql."FROM pessoas P ";
	$sql = $sql."LEFT JOIN pessoas_emails PE ON (P.co_pessoa = PE.co_pessoa) AND (PE.ic_email_principal = 'SIM') ";
	$sql = $sql."LEFT JOIN pessoas_telefones PT ON (P.co_pessoa = PT.co_pessoa) AND (PT.ic_telefone_principal = 'SIM') ";
	$sql = $sql."WHERE ((P.nu_cpf_cnpj = '".$login."') OR (PE.no_email = '".$login."') OR (PT.nu_telefone = '".$login."'));";
	$rs = mysql_query($sql);
	if ($rs) {
		$co_visita = 1;
		$sql2 = "SELECT MAX(co_visita) AS maximo FROM visitas;";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			if (mysql_num_rows($rs2) > 0) {
				$campo2 = mysql_fetch_array($rs2);
				$co_visita = $campo2["maximo"] + 1;
			}
		}
		
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$nu_senha = strtolower($campo["nu_senha"]);
			if ($senha == $nu_senha) {
				$ic_login = 'sim';
				$co_pessoa_login = $campo["co_pessoa"];
				$no_pessoa_login = $campo["no_pessoa"];
				$co_perfil_login = $campo["co_perfil"];
				$co_pessoa = $co_pessoa_login;
				
				$sql2 = "INSERT INTO visitas (co_visita, co_pessoa, no_login, no_senha, dt_entrada, hr_entrada, ic_logon, de_mensagem) ";
				$sql2 = $sql2."VALUES (".$co_visita.",".$co_pessoa_login.",'".$login."','".$senha."',CURRENT_DATE,CURRENT_TIME,'SIM','Logon efetuado com sucesso!');";
				$rs2 = mysql_query($sql2);
			} else {
				$ic_login = '';
				
				$sql2 = "INSERT INTO visitas (co_visita, co_pessoa, no_login, no_senha, dt_entrada, hr_entrada, dt_saida, hr_saida, ic_logon, de_mensagem) ";
				$sql2 = $sql2."VALUES (".$co_visita.",".$campo["co_pessoa"].",'".$login."','".$senha."',CURRENT_DATE,CURRENT_TIME,CURRENT_DATE,CURRENT_TIME,'NAO','Login existe, mas a senha não confere!');";
				$rs2 = mysql_query($sql2);
				
				?><script>alert('Login existe, mas a senha não confere!');</script><?
			}
		} else {
			$ic_login = '';
			
			$sql2 = "INSERT INTO visitas (co_visita, no_login, no_senha, dt_entrada, hr_entrada, dt_saida, hr_saida, ic_logon, de_mensagem) ";
			$sql2 = $sql2."VALUES (".$co_visita.",'".$login."','".$senha."',CURRENT_DATE,CURRENT_TIME,CURRENT_DATE,CURRENT_TIME,'NAO','Login não existe! Cadastre-se!');";
			$rs2 = mysql_query($sql2);
				
			?><script>alert('Login não existe! Cadastre-se!');</script><?
		}
	}
		
} elseif ($ic_login == 'logoff') {
	if ($co_visita != '') {
		$sql = "UPDATE visitas SET dt_saida = CURRENT_DATE, hr_saida = CURRENT_TIME WHERE (co_visita = ".$co_visita."); ";
		$rs = mysql_query($sql);
	}
	
	$ic_login = '';
	$co_pessoa = '';
	$co_pessoa_login = '';
	$no_pessoa_login = '';
	$co_perfil_login = '';
	$co_visita = '';
	
} elseif (($ic_login == 'sim') && ($co_pessoa_login != '') && (is_numeric($co_pessoa_login))) {
	$sql = "SELECT P.no_pessoa, P.co_perfil ";
	$sql = $sql."FROM pessoas P ";
	$sql = $sql."WHERE (P.co_pessoa = ".$co_pessoa_login.");";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$no_pessoa_login = $campo["no_pessoa"];
			$co_perfil_login = $campo["co_perfil"];
		}
	}
	
} elseif (($ic_login == '') && ($co_pessoa_login == '') && ($co_pessoa == '')) {
	$telefone = isset($_POST['nu_telefone0']) ? $_POST['nu_telefone0'] : '';
	$email = strtolower(isset($_POST['no_email0']) ? $_POST['no_email0'] : '');
	$cpf_cnpj = isset($_POST['nu_cpf_cnpj']) ? $_POST['nu_cpf_cnpj'] : '';

	if (($telefone != '') || ($email != '') || ($cpf_cnpj != '')) {
		$sql = "SELECT P.* ";
		$sql = $sql."FROM pessoas P ";
		$sql = $sql."LEFT JOIN pessoas_emails PE ON (P.co_pessoa = PE.co_pessoa) AND (PE.ic_email_principal = 'SIM') ";
		$sql = $sql."LEFT JOIN pessoas_telefones PT ON (P.co_pessoa = PT.co_pessoa) AND (PT.ic_telefone_principal = 'SIM') ";
		$sql = $sql."WHERE ";
		if ($telefone != '') {
			$sql = $sql."(PT.nu_telefone = '".$telefone."')";
			if ($email != '') {
				$sql = $sql." OR (PE.no_email = '".$email."')";
			}
			if ($cpf_cnpj != '') {
				$sql = $sql." OR (P.nu_cpf_cnpj = '".$cpf_cnpj."')";
			}
		} else {
			if ($email != '') {
				$sql = $sql."(PE.no_email = '".$email."')";
				if ($cpf_cnpj != '') {
					$sql = $sql." OR (P.nu_cpf_cnpj = '".$cpf_cnpj."')";
				}
			} else {
				if ($cpf_cnpj != '') {
					$sql = $sql."(P.nu_cpf_cnpj = '".$cpf_cnpj."')";
				}
			}
		}
		$sql = $sql.";";
		
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$ic_login = 'sim';
				$co_pessoa_login = $campo["co_pessoa"];
				$no_pessoa_login = $campo["no_pessoa"];
				$co_perfil_login = $campo["co_perfil"];
				$co_pessoa = $co_pessoa_login;
				
				$co_visita = 1;
				$sql2 = "SELECT MAX(co_visita) AS maximo FROM visitas;";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					if (mysql_num_rows($rs2) > 0) {
						$campo2 = mysql_fetch_array($rs2);
						$co_visita = $campo2["maximo"] + 1;
					}
				}
				$sql2 = "INSERT INTO visitas (co_visita, co_pessoa, dt_entrada, hr_entrada, ic_logon, de_mensagem) ";
				$sql2 = $sql2."VALUES (".$co_visita.",".$co_pessoa_login.",CURRENT_DATE,CURRENT_TIME,'SIM','Logon efetuado por atualização de cadastro!');";
				$rs2 = mysql_query($sql2);
			}
		}
	}
}

$nivel[0][0] = 'Principal';
$nivel[0][1] = '';
$nivel[0][2] = '0';
if (substr($menu, 0, 1) == '1') {
	$nivel[1][0] = 'Cadastros';
	$nivel[1][1] = 'cadastros';
	$nivel[1][2] = '1';
	if (($pg == '') || ($pg == 'inicial.php')) {
		$pg = 'cadastro.php';
	}
} elseif (substr($menu, 0, 1) == '2') {
	$nivel[1][0] = 'Relatórios';
	$nivel[1][1] = 'relatorios';
	$nivel[1][2] = '2';
	if (($pg == '') || ($pg == 'inicial.php')) {
		$pg = 'relatorios.php';
	}
} elseif (substr($menu, 0, 1) == '3') {
	$nivel[1][0] = 'Boletos';
	$nivel[1][1] = '../boletos';
	$nivel[1][2] = '3';
	if (($pg == '') || ($pg == 'inicial.php')) {
		$pg = 'boletos.php';
	}
} elseif ($menu == '') {
	$pg = '';
}
?>
<input type="hidden" id="ic_login" name="ic_login" value="<?=$ic_login?>">
<input type="hidden" id="co_pessoa" name="co_pessoa" value="<?=$co_pessoa?>">
<input type="hidden" id="co_pessoa_login" name="co_pessoa_login" value="<?=$co_pessoa_login?>">
<input type="hidden" id="no_pessoa_login" name="no_pessoa_login" value="<?=$no_pessoa_login?>">
<input type="hidden" id="co_perfil_login" name="co_perfil_login" value="<?=$co_perfil_login?>">
<input type="hidden" id="co_visita" name="co_visita" value="<?=$co_visita?>">
