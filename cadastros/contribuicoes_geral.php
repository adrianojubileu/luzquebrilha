<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$contribuicao = isset($_GET['contribuicao']) ? $_GET['contribuicao'] : (isset($_POST['contribuicao']) ? $_POST['contribuicao'] : '');

if ($contribuicao != '') {
	if ($comando == 'excluir') {
		$sql2 = "SELECT * FROM lancamentos_contribuicoes WHERE (co_contribuicao = ".$contribuicao.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			if (mysql_num_rows($rs2) > 0) {
				$campo2 = mysql_fetch_array($rs2);
				$co_lancamento = $campo2["co_lancamento"];
				$sql3 = "DELETE FROM lancamentos WHERE (co_lancamento = ".$co_lancamento.");";
				$rs3 = mysql_query($sql3);
			}
		}
			
		$sql = "DELETE FROM contribuicoes WHERE (co_contribuicao = ".$contribuicao.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Contribuição excluída com sucesso!")?>');</script><?
		}			
		$contribuicao = '';
		$comando = '';
		
		$co_contribuinte = isset($_POST['co_contribuinte']) ? $_POST['co_contribuinte'] : '';
		$no_contribuinte = strtoupper(sem_acento(isset($_POST['no_contribuinte']) ? $_POST['no_contribuinte'] : ''));
		if (($no_contribuinte != '') || ($co_contribuinte != '')) {
			$sql = "SELECT * FROM contribuicoes ";
			if ($no_contribuinte != '') {
				$sql = $sql."WHERE (no_contribuinte = '".$no_contribuinte."');";
			} else if ($co_contribuinte != '') {
				$sql = $sql."WHERE (co_pessoa = ".$co_contribuinte.");";
			}
			$rs = mysql_query($sql);
			if ($rs) {
				if (mysql_num_rows($rs) == 0) {
					$co_contribuinte == '';
					$no_contribuinte == '';
				}
			}
		}
	}

	if ($comando == 'atualizar') {
		$sql = "SELECT C.*, COALESCE(P.no_pessoa_completo, P.no_pessoa) AS nome_pessoa_completo, C.no_contribuinte ";
		$sql = $sql."FROM contribuicoes C ";
		$sql = $sql."LEFT JOIN pessoas P ON (P.co_pessoa = C.co_pessoa) ";
		$sql = $sql."WHERE (C.co_contribuicao = ".$contribuicao.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$co_contribuinte = $campo["co_pessoa"];
				if ($co_contribuinte == '') {
					$no_contribuinte = strtoupper(sem_acento($campo["no_contribuinte"]));
				}
				$mes = $campo["mm_referencia"];
				$ano = $campo["aa_referencia"];
				$vr_contribuicao = $campo["vr_contribuicao"];
				if ($vr_contribuicao != '') {
					$vr_contribuicao = number_format($vr_contribuicao, 2, ',', '.');
				}
				$dt_contribuicao = $campo["dt_contribuicao"];
				if ($dt_contribuicao != '') {
					$dt_contribuicao = substr($dt_contribuicao, 8, 2).'/'.substr($dt_contribuicao, 5, 2).'/'.substr($dt_contribuicao, 0, 4);
				}
				$co_tipo_oferta = $campo["co_tipo_oferta"];
				$de_observacao = strtoupper(sem_acento($campo["de_observacao"]));
			}
		}
		$comando = '';
	}
	
	if ($comando == 'cadastrar') {
		$co_contribuinte = isset($_POST['co_contribuinte']) ? $_POST['co_contribuinte'] : '';
		$no_contribuinte = strtoupper(sem_acento(isset($_POST['no_contribuinte']) ? $_POST['no_contribuinte'] : ''));
		$vr_contribuicao = isset($_POST['vr_contribuicao']) ? $_POST['vr_contribuicao'] : '';
		$vr_contribuicao = str_replace(".","",$vr_contribuicao);
		$vr_contribuicao = str_replace(",",".",$vr_contribuicao);
		$dt_contribuicao = isset($_POST['dt_contribuicao']) ? $_POST['dt_contribuicao'] : '';
		if ($dt_contribuicao != '') {
			$dt_contribuicao = substr($dt_contribuicao, 6, 4).'-'.substr($dt_contribuicao, 3, 2).'-'.substr($dt_contribuicao, 0, 2);
		}
		$co_pessoa_registrou = isset($_POST['co_pessoa_login']) ? $_POST['co_pessoa_login'] : '';
		$co_tipo_oferta = isset($_POST['co_tipo_oferta']) ? $_POST['co_tipo_oferta'] : '';
		$de_observacao = strtoupper(sem_acento(isset($_POST['de_observacao']) ? $_POST['de_observacao'] : ''));
		$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
		$mes = isset($_POST['mes']) ? $_POST['mes'] : '';
	
		$sql = "UPDATE contribuicoes ";
		$sql = $sql."SET vr_contribuicao = ".$vr_contribuicao.", co_pessoa_registrou = ".$co_pessoa_registrou.", ";
		$sql = $sql."dt_registro = CURRENT_DATE, co_tipo_oferta = ".$co_tipo_oferta.", de_observacao = '".$de_observacao."', ";
		if ($dt_contribuicao != '') {
			$sql = $sql."dt_contribuicao = '".$dt_contribuicao."', ";
		} else {
			$sql = $sql."dt_contribuicao = NULL, ";
		}		
		if ($co_contribuinte != '') {
			$sql = $sql."co_pessoa = ".$co_contribuinte.", no_contribuinte = NULL, ";
		} else if ($no_contribuinte != '') {
			$sql = $sql."no_contribuinte = '".$no_contribuinte."', co_pessoa = NULL, ";
		}
		$sql = $sql."mm_referencia = '".$mes."', aa_referencia = '".$ano."' ";
		$sql = $sql."WHERE (co_contribuicao = ".$contribuicao.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Contribuição atualizada com sucesso!")?>');</script><?
		
			if ($co_tipo_oferta == 0) {
				$co_lancamento_modalidade = 9;
			} else if (($co_tipo_oferta == 1) || ($co_tipo_oferta == 2) || ($co_tipo_oferta == 3) || ($co_tipo_oferta == 6) || ($co_tipo_oferta == 7)) {
				$co_lancamento_modalidade = $co_tipo_oferta;
			} else if ($co_tipo_oferta == 5) {
				$co_lancamento_modalidade = 4;
			} else if (($co_tipo_oferta == 8) || ($co_tipo_oferta == 9)) {
				$co_lancamento_modalidade = 7;
			}
			$sql = "SELECT co_lancamento FROM lancamentos_contribuicoes WHERE (co_contribuicao = ".$contribuicao.");";
			$rs = mysql_query($sql);
			if ($rs) {
				if (mysql_num_rows($rs) > 0) {
					$campo = mysql_fetch_array($rs);
					$lancamento = $campo["co_lancamento"] + 1;
				}
			}
			$sql = "SELECT CASE WHEN (NOT (C.co_pessoa IS NULL)) THEN P.no_pessoa_completo ELSE C.no_contribuinte END AS nome_pessoa_completo ";
			$sql = $sql."FROM contribuicoes C LEFT JOIN pessoas P ON (C.co_pessoa = P.co_pessoa) ";
			$sql = $sql."WHERE (co_contribuicao = ".$contribuicao.");";
			$rs = mysql_query($sql);
			if ($rs) {
				if (mysql_num_rows($rs) > 0) {
					$campo = mysql_fetch_array($rs);
					$de_lancamento = strtoupper(substr($campo["nome_pessoa_completo"], 0, 15));
				}
			}
			
			$sql = "UPDATE lancamentos ";
			$sql = $sql."SET co_lancamento_modalidade = ".$co_lancamento_modalidade.", ";
			$sql = $sql."    vr_lancamento = ".$vr_contribuicao.", ";
			$sql = $sql."    dt_lancamento = '".$dt_contribuicao."', ";
			$sql = $sql."    de_lancamento = '".$de_lancamento."', ";
			$sql = $sql."    co_pessoa_atualizou = ".$co_pessoa_registrou.", ";
			$sql = $sql."    dt_atualizacao = CURRENT_DATE ";
			$sql = $sql."WHERE (co_lancamento = ".$lancamento.");";
			$rs = mysql_query($sql);
		}
		
		$contribuicao = '';
		$comando = '';
		$vr_contribuicao = '';
		$dt_contribuicao = '';
		$co_pessoa_registrou = '';
		$co_tipo_oferta = '';
		$de_observacao = '';
		$ano = '';
		$mes = '';
		
		if (is_numeric($co_contribuinte)) {
			$sql = "SELECT P.*, COALESCE(P.no_pessoa_completo, P.no_pessoa) AS nome_pessoa_completo ";
			$sql = $sql."FROM pessoas P ";
			$sql = $sql."WHERE (P.co_pessoa = ".$co_contribuinte.");";
			$rs = mysql_query($sql);
			if ($rs) {
				$contribuicoes = mysql_num_rows($rs);
				if (mysql_num_rows($rs) > 0) {
					$campo = mysql_fetch_array($rs);
					$co_contribuinte = $campo["co_pessoa"];
					$no_contribuinte = '';
					$vr_contribuicao = $campo["vr_oferta"];
					if ($vr_contribuicao != '') {
						$vr_contribuicao = number_format($vr_contribuicao, 2, ',', '.');
					}
					$co_tipo_oferta = $campo["co_tipo_oferta"];
				}
			}
		}
	}
} else if ($comando == 'cadastrar') {
	$sql = "SELECT MAX(co_contribuicao) AS maximo FROM contribuicoes;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_contribuicao = $campo["maximo"] + 1;
		}
	}

	$co_contribuinte = isset($_POST['co_contribuinte']) ? $_POST['co_contribuinte'] : (isset($_GET['co_contribuinte']) ? $_GET['co_contribuinte'] : '');
	$no_contribuinte = strtoupper(sem_acento(isset($_POST['no_contribuinte']) ? $_POST['no_contribuinte'] : (isset($_GET['no_contribuinte']) ? $_GET['no_contribuinte'] : '')));
	$vr_contribuicao = isset($_POST['vr_contribuicao']) ? $_POST['vr_contribuicao'] : (isset($_GET['vr_contribuicao']) ? $_GET['vr_contribuicao'] : '');
	$vr_contribuicao = str_replace(".","",$vr_contribuicao);
	$vr_contribuicao = str_replace(",",".",$vr_contribuicao);
	$dt_contribuicao = isset($_POST['dt_contribuicao']) ? $_POST['dt_contribuicao'] : (isset($_GET['dt_contribuicao']) ? $_GET['dt_contribuicao'] : '');
	if ($dt_contribuicao != '') {
		$dt_contribuicao = substr($dt_contribuicao, 6, 4).'-'.substr($dt_contribuicao, 3, 2).'-'.substr($dt_contribuicao, 0, 2);
	} else {
		$dt_contribuicao = date("Y-m-d");
	}
	$co_pessoa_registrou = isset($_POST['co_pessoa_login']) ? $_POST['co_pessoa_login'] : (isset($_GET['co_pessoa_registrou']) ? $_GET['co_pessoa_registrou'] : '');
	$co_tipo_oferta = isset($_POST['co_tipo_oferta']) ? $_POST['co_tipo_oferta'] : (isset($_GET['co_tipo_oferta']) ? $_GET['co_tipo_oferta'] : '');
	$de_observacao = strtoupper(sem_acento(isset($_POST['de_observacao']) ? $_POST['de_observacao'] : (isset($_GET['de_observacao']) ? $_GET['de_observacao'] : '')));
	$ano = isset($_POST['ano']) ? $_POST['ano'] : (isset($_GET['ano']) ? $_GET['ano'] : '');
	$mes = isset($_POST['mes']) ? $_POST['mes'] : (isset($_GET['mes']) ? $_GET['mes'] : '');
	$mes_referencia = $mes;
	$mes = mes_por_extenso($mes);

	$sql = "INSERT INTO contribuicoes (co_contribuicao, vr_contribuicao, dt_registro, co_pessoa_registrou, ";
	$sql = $sql."co_tipo_oferta, de_observacao, ";
	if ($no_contribuinte != '') {
		$sql = $sql."no_contribuinte, ";
	} else if ($co_contribuinte != '') {
		$sql = $sql."co_pessoa, ";
	}
	$sql = $sql."dt_contribuicao, mm_referencia, aa_referencia) ";
	$sql = $sql."VALUES (".$co_contribuicao.",".$vr_contribuicao.",CURRENT_DATE,".$co_pessoa_registrou.",";
	$sql = $sql."".$co_tipo_oferta.",'".$de_observacao."',";
	if ($no_contribuinte != '') {
		$sql = $sql."'".$no_contribuinte."',";
	} else if ($co_contribuinte != '') {
		$sql = $sql."".$co_contribuinte.",";
	}
	if ($dt_contribuicao != '') {
		$sql = $sql."'".$dt_contribuicao."',";
	}
	$sql = $sql."'".$mes_referencia."','".$ano."');";
	
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert('Contribuição cadastrada com sucesso!');</script><?
		
		$sql = "SELECT MAX(co_lancamento) AS maximo FROM lancamentos;";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$co_lancamento = $campo["maximo"] + 1;
			}
		}
		$sql = "SELECT CASE WHEN (NOT (C.co_pessoa IS NULL)) THEN P.no_pessoa_completo ELSE C.no_contribuinte END AS nome_pessoa_completo ";
		$sql = $sql."FROM contribuicoes C LEFT JOIN pessoas P ON (C.co_pessoa = P.co_pessoa) ";
		$sql = $sql."WHERE (co_contribuicao = ".$co_contribuicao.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$de_lancamento = strtoupper(substr($campo["nome_pessoa_completo"], 0, 15));
			}
		}
		if ($co_tipo_oferta == 0) {
			$co_lancamento_modalidade = 9;
		} else if (($co_tipo_oferta == 1) || ($co_tipo_oferta == 2) || ($co_tipo_oferta == 3) || ($co_tipo_oferta == 6) || ($co_tipo_oferta == 7)) {
			$co_lancamento_modalidade = $co_tipo_oferta;
		} else if ($co_tipo_oferta == 5) {
			$co_lancamento_modalidade = 4;
		} else if (($co_tipo_oferta == 8) || ($co_tipo_oferta == 9)) {
			$co_lancamento_modalidade = 7;
		}
		
		$sql2 = "SELECT * FROM lancamentos_contribuicoes WHERE (co_contribuicao = ".$co_contribuicao.");";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			if (mysql_num_rows($rs2) == 0) {
				$sql = "INSERT INTO lancamentos (co_lancamento, co_conta, vr_lancamento, dt_lancamento, co_pessoa_cadastrou, dt_cadastro, ";
				$sql = $sql."de_lancamento, ic_lancamento, co_lancamento_modalidade, co_lancamento_categoria, co_lancamento_situacao) VALUES (";
				$sql = $sql."".$co_lancamento.",19,".$vr_contribuicao.",'".$dt_contribuicao."',".$co_pessoa_registrou.",CURRENT_DATE,";
				$sql = $sql."'".$de_lancamento."','C',".$co_lancamento_modalidade.",2,1);";
				$rs = mysql_query($sql);
			
				$sql = "INSERT INTO lancamentos_contribuicoes (co_lancamento, co_contribuicao) ";
				$sql = $sql."VALUES (".$co_lancamento.",".$co_contribuicao.");";
				$rs = mysql_query($sql);
			} else {
				$campo2 = mysql_fetch_array($rs2);
				$co_lancamento = $campo2["co_lancamento"];
				$sql3 = "UPDATE lancamentos SET vr_lancamento = ".$vr_contribuicao.", dt_lancamento = '".$dt_contribuicao."' WHERE (co_lancamento = ".$co_lancamento.");";
				$rs3 = mysql_query($sql3);
			}
		}
	}
	
	$contribuicao = '';
	$comando = '';
	$vr_contribuicao = '';
	$dt_contribuicao = '';
	$co_pessoa_registrou = '';
	$co_tipo_oferta = '';
	$de_observacao = '';
	$ano = '';
	$mes = '';
	
	if (is_numeric($co_contribuinte)) {
		$sql = "SELECT P.*, COALESCE(P.no_pessoa_completo, P.no_pessoa) AS nome_pessoa_completo ";
		$sql = $sql."FROM pessoas P ";
		$sql = $sql."WHERE (P.co_pessoa = ".$co_contribuinte.");";
		$rs = mysql_query($sql);
		if ($rs) {
			$contribuicoes = mysql_num_rows($rs);
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$co_contribuinte = $campo["co_pessoa"];
				$no_contribuinte = '';
				$vr_contribuicao = $campo["vr_oferta"];
				if ($vr_contribuicao != '') {
					$vr_contribuicao = number_format($vr_contribuicao, 2, ',', '.');
				}
				$co_tipo_oferta = $campo["co_tipo_oferta"];
			}
		}
	}
	
} else {
	$co_contribuinte = isset($_GET['co_contribuinte']) ? $_GET['co_contribuinte'] : (isset($_POST['co_contribuinte']) ? $_POST['co_contribuinte'] : '');
	$no_contribuinte = strtoupper(sem_acento(isset($_GET['no_contribuinte']) ? $_GET['no_contribuinte'] : ''));
	if ($co_contribuinte != '') {
		if (is_numeric($co_contribuinte)) {
			$sql = "SELECT P.*, COALESCE(P.no_pessoa_completo, P.no_pessoa) AS nome_pessoa_completo ";
			$sql = $sql."FROM pessoas P ";
			$sql = $sql."WHERE (P.co_pessoa = ".$co_contribuinte.");";
			$rs = mysql_query($sql);
			if ($rs) {
				$contribuicoes = mysql_num_rows($rs);
				if (mysql_num_rows($rs) > 0) {
					$campo = mysql_fetch_array($rs);
					$co_contribuinte = $campo["co_pessoa"];
					$no_contribuinte = '';
					$vr_contribuicao = $campo["vr_oferta"];
					if ($vr_contribuicao != '') {
						$vr_contribuicao = number_format($vr_contribuicao, 2, ',', '.');
					}
					$co_tipo_oferta = $campo["co_tipo_oferta"];
				}
			}
		} else {
			$sql = "SELECT C.* ";
			$sql = $sql."FROM contribuicoes C ";
			$sql = $sql."WHERE (C.no_contribuinte = '".$co_contribuinte."');";
			$rs = mysql_query($sql);
			if ($rs) {
				$contribuicoes = mysql_num_rows($rs);
				if (mysql_num_rows($rs) > 0) {
					$campo = mysql_fetch_array($rs);
					$co_contribuinte = $campo["co_pessoa"];
					$no_contribuinte = strtoupper(sem_acento($campo["no_contribuinte"]));
				}
			}
		}
	} else {
		$no_contribuinte = '';
		$sql = "SELECT P.*, COALESCE(P.no_pessoa_completo, P.no_pessoa) AS nome_pessoa_completo ";
		$sql = $sql."FROM pessoas P ";
		$sql = $sql."WHERE (P.co_pessoa = ".$co_pessoa.");";
		$rs = mysql_query($sql);
		if ($rs) {
			$contribuicoes = mysql_num_rows($rs);
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$co_contribuinte = $campo["co_pessoa"];
				$no_contribuinte = '';
				$vr_contribuicao = $campo["vr_oferta"];
				if ($vr_contribuicao != '') {
					$vr_contribuicao = number_format($vr_contribuicao, 2, ',', '.');
				}
				$co_tipo_oferta = $campo["co_tipo_oferta"];
			}
		}
	}
	$comando = '';
}
?>

<script language="javascript">
	function cadastrar_contribuicao () {
		if ((document.forms["form"]["co_contribuinte"].value == '') && (document.forms["form"]["no_contribuinte"].value == '')) {
			window.alert('<?=utf8_encode("Favor selecionar o contribuinte FIDELIDADE ou preencher o NOME DO(A) DOADOR(A) que não está cadastrado no Luz que Brilha como contribuinte FIDELIDADE!")?>');
		} else if (document.forms["form"]["vr_contribuicao"].value == '') {
			window.alert('<?=utf8_encode("Favor preencher o campo VALOR!")?>');
		} else if ((document.forms["form"]["dt_contribuicao"].value != '') && ((document.forms["form"]["dt_contribuicao"].value.substring(2,3) != '/') || (document.forms["form"]["dt_contribuicao"].value.substring(5,6) != '/'))) {
			window.alert('<?=utf8_encode("Favor preencher o campo DATA DA CONTRIBUIÇÃO no seguinte formato com as barras: DD/MM/AAAA")?>');
		} else if ((document.forms["form"]["dt_contribuicao"].value != '') && (((parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 2) && (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(0,2)) > 28)) || (((parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 4) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 6) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 9) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 11)) && (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(0,2)) > 30)) || (((parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 1) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 3) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 5) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 7) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 8) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 10) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 12)) && (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(0,2)) > 31)))) {
			window.alert('<?=utf8_encode("Favor preencher o campo DATA DA CONTRIBUIÇÃO com uma data correta!")?>');
		} else {
			abrir(form,1,'contribuicoes_geral.php','comando=cadastrar');
		}
	}
	function atualizar_contribuicao (co_contribuicao) {
		abrir(form,1,'contribuicoes_geral.php','contribuicao=' + co_contribuicao + '&comando=atualizar');
	}
	function excluir_contribuicao (co_contribuicao, no_pessoa) {
		if (confirm('Tem certeza que deseja excluir a contribuição do(a) ' + no_pessoa + '?')) {
			abrir(form,1,'contribuicoes_geral.php','contribuicao=' + co_contribuicao + '&comando=excluir');
		}
	}
	function seleciona_contribuinte () {
		abrir(form,1,'contribuicoes_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>&co_contribuinte=' + document.forms["form"]["co_contribuinte"].value + '&no_contribuinte=' + document.forms["form"]["no_contribuinte"].value + '&contribuicao=');
	}
</script>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	Contribuições Gerais
</font>

<?
if ($co_perfil_login == '1') {
?>

<br><br>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">DADOS DA CONTRIBUIÇÃO</font></legend>

<table width="100%" cellpadding="2" cellspacing="5">
	<tr align="left">
		<input type="hidden" id="contribuicao" name="contribuicao" value="<?=$contribuicao?>">
		<td align="left" valign="middle">
			<font class="font10azul">Contribuinte:</font>
		</td>
		<td align="left" valign="middle">
			<select name="co_contribuinte" onChange="seleciona_contribuinte();">
				<option value="" selected>
<?
	$sql = "SELECT co_pessoa, COALESCE(no_pessoa_completo, no_pessoa) AS nome_pessoa FROM pessoas ";
	$sql = $sql."UNION ";
	$sql = $sql."SELECT 0 AS co_pessoa, no_contribuinte AS nome_pessoa FROM contribuicoes WHERE (NOT (no_contribuinte IS NULL)) ";
	$sql = $sql."ORDER BY nome_pessoa;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($campo["co_pessoa"] != 0) {
					if ($co_contribuinte == $campo["co_pessoa"]) {
?>
					<option value="<?=$campo["co_pessoa"]?>" selected><?=strtoupper(sem_acento($campo["nome_pessoa"]))?>
<?
					} else {
?>
					<option value="<?=$campo["co_pessoa"]?>"><?=strtoupper(sem_acento($campo["nome_pessoa"]))?>
<?
					}
				} else {
					if ($co_contribuinte == strtoupper(sem_acento($campo["nome_pessoa"]))) {
						$no_contribuinte = strtoupper(sem_acento($campo["nome_pessoa"]));
?>
					<option value="<?=strtoupper(sem_acento($campo["nome_pessoa"]))?>" selected><?=strtoupper(sem_acento($campo["nome_pessoa"]))?>
<?
					} else {
?>
					<option value="<?=strtoupper(sem_acento($campo["nome_pessoa"]))?>"><?=strtoupper(sem_acento($campo["nome_pessoa"]))?>
<?
					}
				}
				$regs = $regs + 1;
			}
		}
	}
?>
			</select>
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Benfeitor:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_contribuinte" value="<?=$no_contribuinte?>" placeholder="não está no cadastro ou não identificado" size="40" maxlength="30">
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Valor:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="vr_contribuicao" value="<?=$vr_contribuicao?>" placeholder="valor em reais" size="12" maxlength="12">
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Data:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="dt_contribuicao" value="<?=$dt_contribuicao?>" placeholder="___/___/______" size="15" maxlength="10" onkeypress="javascript: return validaData(document.form.dt_contribuicao, window.event);">
		</td>
	</tr>
</table>

<table width="100%" cellpadding="2" cellspacing="5">
	<tr align="left">
		<td align="left" valign="middle">
			<font class="font10azul">Mês de Referência:</font>
		</td>
		<td align="left" valign="middle">
			<select name="mes">
<?
		if ($mes == '') {
			$mes = date("m");
		}
		for ($mm = 1; $mm <= 12; $mm++) {
			if ($mm < 10) {
				$mm = '0'.$mm;
			} else {
				$mm = ''.$mm;
			}
			if ($mes == $mm) {
?>
				<option value="<?=$mm?>" selected><?=mes_por_extenso($mm)?>
<?
			} else {
?>
				<option value="<?=$mm?>"><?=mes_por_extenso($mm)?>
<?
			}
		}
?>
			</select>
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Ano de Referência:</font>
		</td>
		<td align="left" valign="middle">
			<select name="ano">
<?
		if ($ano == '') {
			$ano = date("Y");
		}
		for ($aa = date("Y")-1; $aa <= date("Y")+1; $aa++) {
			if ($ano == $aa) {
?>
				<option value="<?=$aa?>" selected><?=$aa?>
<?
			} else {
?>
				<option value="<?=$aa?>"><?=$aa?>
<?
			}
		}
?>
			</select>
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Forma:</font>
		</td>
		<td align="left" valign="middle">
			<select name="co_tipo_oferta">
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
		<td align="left" valign="middle">
			<font class="font10azul">Observação:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="de_observacao" value="<?=$de_observacao?>" placeholder="alguma informação importante" size="40" maxlength="30">
		</td>
		<td align="left" valign="middle">
			<input type="button" id="botao_cadastrar_contribuicao" name="botao_cadastrar_contribuicao" value="Salvar" class="botao" onClick="cadastrar_contribuicao();">
		</td>
	</tr>
</table>

</fieldset>

<?
}

if ((($co_contribuinte != '') && (is_numeric($co_contribuinte))) || ($no_contribuinte != '')) {
?>

<br>

<?
	if (($co_contribuinte != '') && (is_numeric($co_contribuinte))) {
?>
	<fieldset style="border: 1px solid #0b3b9d;">
		<legend><font class="font10azul">DADOS DO CONTRIBUINTE</font></legend>

		<table width="100%" cellpadding="2" cellspacing="5">
			<th align="center" valign="middle">TELEFONES</th>
			<th align="center" valign="middle">E-MAILS</th>
			<th align="center" valign="middle">ENDEREÇOS</th>
<?
		$telefones = '';
		$sql2 = "SELECT nu_ddd_telefone, nu_telefone FROM pessoas_telefones WHERE (co_pessoa = ".$co_contribuinte.") AND (NOT (nu_telefone IS NULL)) AND (nu_telefone != '') ORDER BY co_telefone;";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$regs2 = 0;
			while ($regs2 < mysql_num_rows($rs2)) {
				$campo2 = mysql_fetch_array($rs2);
				if (($campo2["nu_ddd_telefone"] != '') && ($campo2["nu_telefone"] != '')) {
					if ($telefones == '') {
						$telefones = '('.$campo2["nu_ddd_telefone"].')'.substr($campo2["nu_telefone"], 0, 4).'-'.substr($campo2["nu_telefone"], 4);
					} else {
						$telefones = $telefones.'<br>'.'('.$campo2["nu_ddd_telefone"].')'.substr($campo2["nu_telefone"], 0, 4).'-'.substr($campo2["nu_telefone"], 4);
					}
				}
				$regs2 = $regs2 + 1;
			}
		}
		$emails = '';
		$sql2 = "SELECT no_email FROM pessoas_emails WHERE (co_pessoa = ".$co_contribuinte.") AND (NOT (no_email IS NULL)) AND (no_email != '') ORDER BY co_email;";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$regs2 = 0;
			while ($regs2 < mysql_num_rows($rs2)) {
				$campo2 = mysql_fetch_array($rs2);
				if ($campo2["no_email"] != '') {
					if ($emails == '') {
						$emails = $campo2["no_email"];
					} else {
						$emails = $emails.'<br>'.$campo2["no_email"];
					}
				}
				$regs2 = $regs2 + 1;
			}
		}
		$enderecos = '';
		$sql2 = "SELECT * FROM pessoas_enderecos WHERE (co_pessoa = ".$co_contribuinte.") AND (NOT (no_endereco IS NULL)) AND (no_endereco != '') ORDER BY co_endereco;";
		$rs2 = mysql_query($sql2);
		if ($rs2) {
			$regs2 = 0;
			while ($regs2 < mysql_num_rows($rs2)) {
				$campo2 = mysql_fetch_array($rs2);
				if ($campo2["no_endereco"] != '') {
					if ($enderecos == '') {
						$enderecos = $campo2["no_endereco"];
					} else {
						$enderecos = $enderecos.'<br>'.$campo2["no_endereco"];
					}
					if ($campo2["no_bairro"] != '') {
						$enderecos = $enderecos.', '.$campo2["no_bairro"];
					}
					if ($campo2["no_cidade"] != '') {
						$enderecos = $enderecos.', '.$campo2["no_cidade"];
					}
					if ($campo2["co_uf"] != '') {
						$enderecos = $enderecos.'/'.$campo2["co_uf"];
					}
					if ($campo2["nu_cep"] != '') {
						$enderecos = $enderecos.' - '.substr($campo2["nu_cep"],0,2).'.'.substr($campo2["nu_cep"],2,3).'-'.substr($campo2["nu_cep"],5,3);
					}
				}
				$regs2 = $regs2 + 1;
			}
		}
?>
			<tr class="trbranco">
				<td align="center" valign="middle"><?=$telefones?></td>
				<td align="left" valign="middle"><?=$emails?></td>
				<td align="left" valign="middle"><?=$enderecos?></td>
			</tr>
		</table>
	</fieldset>
	
	<br>
<?
	}
	
	$sql = "SELECT DISTINCT C.*, P.*, COALESCE(C.no_contribuinte, P.no_pessoa_completo) AS nome_pessoa_contribuinte, ";
	$sql = $sql."C.co_pessoa AS co_contribuinte, P.no_pessoa_completo AS nome_pessoa_completo, C.no_contribuinte, ";
	$sql = $sql."PR.no_pessoa AS nome_registrou, TPOF.no_tipo_oferta ";
	$sql = $sql."FROM contribuicoes C ";
	$sql = $sql."LEFT JOIN pessoas P ON (P.co_pessoa = C.co_pessoa) ";
	$sql = $sql."LEFT JOIN pessoas PR ON (PR.co_pessoa = C.co_pessoa_registrou) ";
	$sql = $sql."LEFT JOIN tipos_ofertas TPOF ON (TPOF.co_tipo_oferta = C.co_tipo_oferta) ";
	if (($co_contribuinte != '') && (is_numeric($co_contribuinte))) {
		$sql = $sql."WHERE (C.co_pessoa = ".$co_contribuinte.") ";
	} else if ($no_contribuinte != '') {
		$sql = $sql."WHERE (C.no_contribuinte = '".$no_contribuinte."') ";
	}
	$sql = $sql."ORDER BY nome_pessoa_contribuinte, C.aa_referencia DESC, C.mm_referencia DESC;";
	//echo $sql.'<br>';
	$rs = mysql_query($sql);
	if ($rs) {
		$contribuicoes = mysql_num_rows($rs);
		if (mysql_num_rows($rs) > 0) {
?>	
	
	<fieldset style="border: 1px solid #0b3b9d;">
		<legend><font class="font10azul"><b><?=$contribuicoes?></b> CONTRIBUIÇÕES</font></legend>
	
		<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
			<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
			<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
			<th align="center" valign="middle">ANO</th>
			<th align="center" valign="middle">MÊS</th>
			<th align="center" valign="middle">VALOR</th>
			<th align="center" valign="middle">DATA</th>
			<th align="center" valign="middle">FORMA</th>
			<th align="center" valign="middle">OBSERVAÇÃO</th>
			<th align="center" valign="middle">ATUALIZADO</th>
			<th align="center" valign="middle">POR QUEM?</th>
<?
			$cor_fundo = "trazul";
			$i = 0;
			while ($i < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$co_contribuicao = $campo["co_contribuicao"];
				$co_contribuinte = $campo["co_contribuinte"];
				if ($co_contribuinte == '') {
					$nome_pessoa_completo = strtoupper(sem_acento($campo["no_contribuinte"]));
				}
				$mes_referencia = $campo["mm_referencia"];
				$mes_referencia = mes_por_extenso($mes_referencia);
				$ano_referencia = $campo["aa_referencia"];
				$valor_contribuicao = $campo["vr_contribuicao"];
				if ($valor_contribuicao != '') {
					$valor_contribuicao = number_format($valor_contribuicao, 2, ',', '.');
					$valor_contribuicao = 'R$ '.$valor_contribuicao;
				}
				$data_contribuicao = $campo["dt_contribuicao"];
				if ($data_contribuicao != '') {
					$data_contribuicao = substr($data_contribuicao, 8, 2).'/'.substr($data_contribuicao, 5, 2).'/'.substr($data_contribuicao, 0, 4);
				}
				$forma_oferta = utf8_encode($campo["no_tipo_oferta"]);
				$observacao = utf8_encode(strtoupper(sem_acento($campo["de_observacao"])));
				$data_registro = $campo["dt_registro"];
				if ($data_registro != '') {
					$data_registro = substr($data_registro, 8, 2).'/'.substr($data_registro, 5, 2).'/'.substr($data_registro, 0, 4);
				}
				$nome_registrou = $campo["nome_registrou"];
						
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
			<tr class="<?=$cor_fundo?>">
				<td align="center" valign="middle" title="Atualizar Contribuição">
					<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar_contribuicao(<?=$co_contribuicao?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle" title="Excluir Contribuição">
					<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir_contribuicao(<?=$co_contribuicao?>,'<?=$nome_pessoa_completo?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle"><?=$ano_referencia?></td>
				<td align="left" valign="middle"><?=$mes_referencia?></td>
				<td align="right" valign="middle"><?=$valor_contribuicao?></td>
				<td align="center" valign="middle"><?=$data_contribuicao?></td>
				<td align="center" valign="middle"><?=$forma_oferta?></td>
				<td align="left" valign="middle"><?=$observacao?></td>
				<td align="center" valign="middle"><?=$data_registro?></td>
				<td align="left" valign="middle"><?=$nome_registrou?></td>
			</tr>
<?
			}
?>
		</table>

	</fieldset>
<?
		} else {
?>
	<fieldset style="border: 1px solid #0b3b9d;">
		<legend><font class="font10azul">CONTRIBUIÇÕES</font></legend>
		<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
			<tr class="trazul">
				<td align="left" valign="middle">Nenhuma contribuição cadastrada!</td>
			</tr>
		</table>
	</fieldset>
<?
		}
	}
}
?>

<br><br><br>

</div>