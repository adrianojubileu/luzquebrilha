<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$contribuicao = isset($_GET['contribuicao']) ? $_GET['contribuicao'] : (isset($_POST['contribuicao']) ? $_POST['contribuicao'] : '');

$contribuicao_de = isset($_GET['contribuicao_de']) ? $_GET['contribuicao_de'] : (isset($_POST['contribuicao_de']) ? $_POST['contribuicao_de'] : '');
if ($contribuicao_de == '') {
	$contribuicao_de = 'fidelidade';
}

$contribuicao_para = isset($_GET['contribuicao_para']) ? $_GET['contribuicao_para'] : (isset($_POST['contribuicao_para']) ? $_POST['contribuicao_para'] : '');
if ($contribuicao_para == '') {
	$contribuicao_para = 'fidelidade';
}

if ($contribuicao != '') {
	if ($comando == 'excluir') {
		$sql = "DELETE FROM contribuicoes WHERE (co_contribuicao = ".$contribuicao.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('Contribuição excluída com sucesso!');</script><?
		}
		$contribuicao = '';
		$comando = '';
		
		$co_contribuinte = isset($_POST['co_contribuinte']) ? $_POST['co_contribuinte'] : '';
		$no_contribuinte = isset($_POST['no_contribuinte']) ? $_POST['no_contribuinte'] : '';
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
				$co_contribuinte_para = $campo["co_pessoa"];
				$contribuicao_para = 'fidelidade';
				if ($co_contribuinte_para == '') {
					$no_contribuinte_para = strtoupper(sem_acento($campo["no_contribuinte"]));
					$contribuicao_para = 'outros';
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
		$co_contribuinte_para = isset($_POST['co_contribuinte_para']) ? $_POST['co_contribuinte_para'] : '';
		$no_contribuinte_para = isset($_POST['no_contribuinte_para']) ? $_POST['no_contribuinte_para'] : '';
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
		if ($co_contribuinte_para != '') {
			$sql = $sql."co_pessoa = ".$co_contribuinte_para.", no_contribuinte = NULL, ";
		} else if ($no_contribuinte_para != '') {
			$sql = $sql."no_contribuinte = '".$no_contribuinte_para."', co_pessoa = NULL, ";
		}
		$sql = $sql."mm_referencia = '".$mes."', aa_referencia = '".$ano."' ";
		$sql = $sql."WHERE (co_contribuicao = ".$contribuicao.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert(<?=utf8_encode('Contribuição atualizada com sucesso!')?>);</script><?
		}
		
		$contribuicao = '';
		$comando = '';
		$co_contribuinte_para = '';
		$no_contribuinte_para = '';
		$vr_contribuicao = '';
		$dt_contribuicao = '';
		$co_pessoa_registrou = '';
		$co_tipo_oferta = '';
		$de_observacao = '';
		$ano = '';
		$mes = '';
		
		if (is_numeric($co_contribuinte_para)) {
			$sql = "SELECT P.*, COALESCE(P.no_pessoa_completo, P.no_pessoa) AS nome_pessoa_completo ";
			$sql = $sql."FROM pessoas P ";
			$sql = $sql."WHERE (P.co_pessoa = ".$co_contribuinte_para.");";
			$rs = mysql_query($sql);
			if ($rs) {
				if (mysql_num_rows($rs) > 0) {
					$campo = mysql_fetch_array($rs);
					$co_contribuinte_para = $campo["co_pessoa"];
					$contribuicao_para = 'fidelidade';
					$no_contribuinte_para = '';
					$vr_contribuicao = $campo["vr_oferta"];
					if ($vr_contribuicao != '') {
						$vr_contribuicao = number_format($vr_contribuicao, 2, ',', '.');
					}
					$co_tipo_oferta = $campo["co_tipo_oferta"];
				}
			}
		} else {
			$contribuicao_de = $contribuicao_para;
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

	$co_contribuinte_para = isset($_POST['co_contribuinte_para']) ? $_POST['co_contribuinte_para'] : (isset($_GET['co_contribuinte_para']) ? $_GET['co_contribuinte_para'] : '');
	$no_contribuinte_para = isset($_POST['no_contribuinte_para']) ? strtoupper(sem_acento($_POST['no_contribuinte_para'])) : (isset($_GET['no_contribuinte_para']) ? strtoupper(sem_acento($_GET['no_contribuinte_para'])) : '');
	$vr_contribuicao = isset($_POST['vr_contribuicao']) ? $_POST['vr_contribuicao'] : (isset($_GET['vr_contribuicao']) ? $_GET['vr_contribuicao'] : '');
	$vr_contribuicao = str_replace(".","",$vr_contribuicao);
	$vr_contribuicao = str_replace(",",".",$vr_contribuicao);
	$dt_contribuicao = isset($_POST['dt_contribuicao']) ? $_POST['dt_contribuicao'] : (isset($_GET['dt_contribuicao']) ? $_GET['dt_contribuicao'] : '');
	if ($dt_contribuicao != '') {
		$dt_contribuicao = substr($dt_contribuicao, 6, 4).'-'.substr($dt_contribuicao, 3, 2).'-'.substr($dt_contribuicao, 0, 2);
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
	if ($co_contribuinte_para != '') {
		$sql = $sql."co_pessoa, ";
	} else if ($no_contribuinte_para != '') {
		$sql = $sql."no_contribuinte, ";
	}
	if ($dt_contribuicao != '') {
		$sql = $sql."dt_contribuicao, ";
	}
	$sql = $sql."mm_referencia, aa_referencia) ";
	$sql = $sql."VALUES (".$co_contribuicao.",".$vr_contribuicao.",CURRENT_DATE,".$co_pessoa_registrou.",";
	$sql = $sql."".$co_tipo_oferta.",'".$de_observacao."',";
	if ($co_contribuinte_para != '') {
		$sql = $sql."".$co_contribuinte_para.",";
	} else if ($no_contribuinte_para != '') {
		$sql = $sql."'".$no_contribuinte_para."',";
	}
	if ($dt_contribuicao != '') {
		$sql = $sql."'".$dt_contribuicao."',";
	}
	$sql = $sql."'".$mes_referencia."','".$ano."');";
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert(<?=utf8_encode('Contribuição cadastrada com sucesso!')?>);</script><?
	}
	$contribuicao = '';
	$co_contribuinte_para = '';
	$no_contribuinte_para = '';
	$comando = '';
	$vr_contribuicao = '';
	$dt_contribuicao = '';
	$co_pessoa_registrou = '';
	$co_tipo_oferta = '';
	$de_observacao = '';
	$ano = '';
	$mes = '';
	
	if (is_numeric($co_contribuinte_para)) {
		$sql = "SELECT P.*, COALESCE(P.no_pessoa_completo, P.no_pessoa) AS nome_pessoa_completo ";
		$sql = $sql."FROM pessoas P ";
		$sql = $sql."WHERE (P.co_pessoa = ".$co_contribuinte_para.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$co_contribuinte_para = $campo["co_pessoa"];
				$no_contribuinte_para = '';
				$vr_contribuicao = $campo["vr_oferta"];
				if ($vr_contribuicao != '') {
					$vr_contribuicao = number_format($vr_contribuicao, 2, ',', '.');
				}
				$co_tipo_oferta = $campo["co_tipo_oferta"];
			}
		}
	} else {
		$contribuicao_de = $contribuicao_para;
	}
	
} else {
	$co_contribuinte = isset($_GET['co_contribuinte']) ? $_GET['co_contribuinte'] : (isset($_POST['co_contribuinte']) ? $_POST['co_contribuinte'] : '');
	$no_contribuinte = isset($_GET['no_contribuinte']) ? $_GET['no_contribuinte'] : (isset($_POST['no_contribuinte']) ? $_POST['no_contribuinte'] : '');
	$co_contribuinte_para = isset($_GET['co_contribuinte_para']) ? $_GET['co_contribuinte_para'] : (isset($_POST['co_contribuinte_para']) ? $_POST['co_contribuinte_para'] : '');
	$no_contribuinte_para = isset($_GET['no_contribuinte_para']) ? $_GET['no_contribuinte_para'] : (isset($_POST['no_contribuinte_para']) ? $_POST['no_contribuinte_para'] : '');
	echo $co_pessoa.' - '.$co_contribuinte.' - '.$no_contribuinte.' - '.$co_contribuinte_para.' - '.$no_contribuinte_para.'<br>';
	if ($co_contribuinte == '') {
		$co_contribuinte = $co_pessoa;
	}
	if (($co_contribuinte_para == '') || ($co_contribuinte_para != $co_contribuinte)) {
		$co_contribuinte_para = $co_contribuinte;
	}
	if ($co_contribuinte_para != '') {
		if (is_numeric($co_contribuinte_para)) {
			$sql = "SELECT P.* ";
			$sql = $sql."FROM pessoas P ";
			$sql = $sql."WHERE (P.co_pessoa = ".$co_contribuinte_para.");";
			$rs = mysql_query($sql);
			if ($rs) {
				if (mysql_num_rows($rs) > 0) {
					$campo = mysql_fetch_array($rs);
					$no_contribuinte_para = '';
					$vr_contribuicao = $campo["vr_oferta"];
					if ($vr_contribuicao != '') {
						$vr_contribuicao = number_format($vr_contribuicao, 2, ',', '.');
					}
					$co_tipo_oferta = $campo["co_tipo_oferta"];
				}
			}
		}
	}
	$comando = '';
}
?>

<script language="javascript">
	function cadastrar_contribuicao () {
		if ((document.forms["form"]["co_contribuinte_para"].value == '') && (document.forms["form"]["no_contribuinte_para"].value == '')) {
			window.alert('Favor selecionar o contribuinte FIDELIDADE ou preencher o NOME DO(A) BENFEITOR(A) que não está cadastrado no Luz que Brilha como contribuinte FIDELIDADE!');
		} else if (document.forms["form"]["vr_contribuicao"].value == '') {
			window.alert('Favor preencher o campo VALOR!');
		} else if ((document.forms["form"]["dt_contribuicao"].value != '') && ((document.forms["form"]["dt_contribuicao"].value.substring(2,3) != '/') || (document.forms["form"]["dt_contribuicao"].value.substring(5,6) != '/'))) {
			window.alert('Favor preencher o campo DATA DA CONTRIBUIÇÃO no seguinte formato com as barras: DD/MM/AAAA');
		} else if ((document.forms["form"]["dt_contribuicao"].value != '') && (((parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 2) && (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(0,2)) > 28)) || (((parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 4) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 6) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 9) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 11)) && (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(0,2)) > 30)) || (((parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 1) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 3) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 5) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 7) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 8) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 10) || (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(3,5)) == 12)) && (parseInt(document.forms["form"]["dt_contribuicao"].value.substring(0,2)) > 31)))) {
			window.alert('Favor preencher o campo DATA DA CONTRIBUIÇÃO com uma data correta!');
		} else {
			abrir(form,1,'contribuicao.php','comando=cadastrar');
		}
	}
	function atualizar_contribuicao (co_contribuicao) {
		abrir(form,1,'contribuicao.php','contribuicao=' + co_contribuicao + '&comando=atualizar');
	}
	function excluir_contribuicao (co_contribuicao, no_pessoa) {
		if (confirm('Tem certeza que deseja excluir a contribuição do(a) ' + no_pessoa + '?')) {
			abrir(form,1,'contribuicao.php','contribuicao=' + co_contribuicao + '&comando=excluir');
		}
	}
	function seleciona_contribuicao_para () {
		abrir(form,1,'contribuicao.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>&co_contribuinte_para=&no_contribuinte_para=');
	}
	function seleciona_contribuicao () {
		abrir(form,1,'contribuicao.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>&co_contribuinte=&no_contribuinte=');
	}
	function seleciona_contribuinte () {
		abrir(form,1,'contribuicao.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>&contribuicao=');
	}
</script>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	<?=utf8_encode('Contribuições Gerais')?>
</font>

<?
if ($co_perfil_login == '1') {
?>

<br><br>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><?=utf8_encode('DADOS DA CONTRIBUIÇÃO')?></font></legend>

<table width="100%" cellpadding="2" cellspacing="5">
	<tr align="left">
		<input type="hidden" id="contribuicao" name="contribuicao" value="<?=$contribuicao?>">
		<td align="left" valign="middle">
			<font class="font10azul"><?=utf8_encode('Contribuição de:')?></font>
		</td>
		<td align="left" valign="middle">
			<select id="contribuicao_para" name="contribuicao_para" onChange="seleciona_contribuicao_para();">
<?
			if ($contribuicao_para == 'fidelidade') {
?>
				<option value="fidelidade" selected>CADASTRO FIDELIDADE
				<option value="outros"><?=utf8_encode('BENFEITOR / OUTROS')?>
<?
			} else if ($contribuicao_para == 'outros') {
?>
				<option value="fidelidade">CADASTRO FIDELIDADE
				<option value="outros" selected><?=utf8_encode('BENFEITOR / OUTROS')?>
<?
			}
?>
			</select>
		</td>
<?
	if ($contribuicao_para == 'fidelidade') {
?>
		<td align="left" valign="middle">
			<font class="font10azul">Contribuinte:</font>
		</td>
		<td align="left" valign="middle">
			<select id="co_contribuinte_para" name="co_contribuinte_para">
<?
		$sql = "SELECT co_pessoa, no_pessoa_completo FROM pessoas ";
		$sql = $sql."ORDER BY no_pessoa_completo;";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0)  {
				$regs = 0;
				while ($regs < mysql_num_rows($rs)) {
					$campo = mysql_fetch_array($rs);
					if ($co_contribuinte_para == $campo["co_pessoa"]) {
?>
				<option value="<?=$campo["co_pessoa"]?>" selected><?=strtoupper(sem_acento($campo["no_pessoa_completo"]))?>
<?
					} else {
?>
				<option value="<?=$campo["co_pessoa"]?>"><?=strtoupper(sem_acento($campo["no_pessoa_completo"]))?>
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
	} else if ($contribuicao_para == 'outros') {
?>
		<td align="left" valign="middle">
			<font class="font10azul">Benfeitor / Outros:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" id="no_contribuinte_para" name="no_contribuinte_para" value="<?=$no_contribuinte_para?>" placeholder="<?=utf8_encode('não está no cadastro ou não identificado')?>" size="40" maxlength="30">
		</td>
<?
	}
?>
		<td align="left" valign="middle">
			<font class="font10azul"><?=utf8_encode('Observação')?>:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" id="de_observacao" name="de_observacao" value="<?=$de_observacao?>" placeholder="<?=utf8_encode('alguma informação importante')?>" size="30" maxlength="30">
		</td>
	</tr>
</table>

<table width="100%" cellpadding="2" cellspacing="5">
	<tr align="left">
		<td align="left" valign="middle">
			<font class="font10azul">Valor:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" id="vr_contribuicao" name="vr_contribuicao" value="<?=$vr_contribuicao?>" placeholder="valor em reais" size="12" maxlength="12">
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Data:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" id="dt_contribuicao" name="dt_contribuicao" value="<?=$dt_contribuicao?>" placeholder="___/___/______" size="15" maxlength="10" onkeypress="javascript: return validaData(document.form.dt_contribuicao, window.event);">
		</td>
		<td align="left" valign="middle">
			<font class="font10azul">Forma:</font>
		</td>
		<td align="left" valign="middle">
			<select id="co_tipo_oferta" name="co_tipo_oferta">
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
				<option value="<?=$campo["co_tipo_oferta"]?>" selected><?=$campo["no_tipo_oferta"]?>
<?
				} else {
?>
				<option value="<?=$campo["co_tipo_oferta"]?>"><?=$campo["no_tipo_oferta"]?>
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
			<font class="font10azul"><?=utf8_encode('Mês de Referência')?>:</font>
		</td>
		<td align="left" valign="middle">
			<select id="mes" name="mes">
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
			<font class="font10azul"><?=utf8_encode('Ano de Referência')?>:</font>
		</td>
		<td align="left" valign="middle">
			<select id="ano" name="ano">
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
			<input type="button" id="botao_cadastrar_contribuicao" name="botao_cadastrar_contribuicao" value="Salvar" class="botao" onClick="cadastrar_contribuicao();">
		</td>
	</tr>
</table>

</fieldset>

<?
}
?>

<?
if (($co_perfil_login == '1') || ((($co_contribuinte != '') && (is_numeric($co_contribuinte))) || ($no_contribuinte != ''))) {
?>

<br>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">DADOS DO CONTRIBUINTE</font></legend>

<?
	if ($co_perfil_login == '1') {
?>
	<table width="75%" cellpadding="2" cellspacing="5">
		<tr align="left">	
			<td align="left" valign="middle">
				<font class="font10azul"><?=utf8_encode('Contribuição de:')?></font>
			</td>
			<td align="left" valign="middle">
				<select id="contribuicao_de" name="contribuicao_de" onChange="seleciona_contribuicao();">
<?
				if ($contribuicao_de == 'fidelidade') {
?>
					<option value="fidelidade" selected>CADASTRO FIDELIDADE
					<option value="outros"><?=utf8_encode('BENFEITOR / OUTROS')?>
<?
				} else if ($contribuicao_de == 'outros') {
?>
					<option value="fidelidade">CADASTRO FIDELIDADE
					<option value="outros" selected><?=utf8_encode('BENFEITOR / OUTROS')?>
<?
				}
?>
				</select>
			</td>
<?
		if ($contribuicao_de == 'fidelidade') {
?>
			<td align="left" valign="middle">
				<font class="font10azul">Contribuinte:</font>
			</td>
			<td align="left" valign="middle">
				<select id="co_contribuinte" name="co_contribuinte" onChange="seleciona_contribuinte();">
<?
			$sql = "SELECT co_pessoa, no_pessoa_completo FROM pessoas ";
			$sql = $sql."ORDER BY no_pessoa_completo;";
			$rs = mysql_query($sql);
			if ($rs) {
				if (mysql_num_rows($rs) > 0)  {
					$regs = 0;
					while ($regs < mysql_num_rows($rs)) {
						$campo = mysql_fetch_array($rs);
						if ($co_contribuinte == $campo["co_pessoa"]) {
?>
					<option value="<?=$campo["co_pessoa"]?>" selected><?=strtoupper(sem_acento($campo["no_pessoa_completo"]))?>
<?
						} else {
?>
					<option value="<?=$campo["co_pessoa"]?>"><?=strtoupper(sem_acento($campo["no_pessoa_completo"]))?>
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
		} else if ($contribuicao_de == 'outros') {
?>
			<td align="left" valign="middle">
				<font class="font10azul">Benfeitor / Outros:</font>
			</td>
			<td align="left" valign="middle">
				<select id="no_contribuinte" name="no_contribuinte" onChange="seleciona_contribuinte();">
<?
			$sql = $sql."SELECT DISTINCT no_contribuinte AS nome_pessoa FROM contribuicoes WHERE (NOT (no_contribuinte IS NULL)) ";
			$sql = $sql."ORDER BY nome_pessoa;";
			$rs = mysql_query($sql);
			if ($rs) {
				if (mysql_num_rows($rs) > 0)  {
					$regs = 0;
					while ($regs < mysql_num_rows($rs)) {
						$campo = mysql_fetch_array($rs);
						if ($no_contribuinte == strtoupper(sem_acento($campo["nome_pessoa"]))) {
?>
					<option value="<?=strtoupper(sem_acento($campo["nome_pessoa"]))?>" selected><?=strtoupper(sem_acento($campo["nome_pessoa"]))?>
<?
						} else {
?>
					<option value="<?=strtoupper(sem_acento($campo["nome_pessoa"]))?>"><?=strtoupper(sem_acento($campo["nome_pessoa"]))?>
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
<?
	}

	if (($co_contribuinte != '') && (is_numeric($co_contribuinte))) {
?>
		<table width="100%" cellpadding="2" cellspacing="5">
			<th align="center" valign="middle">TELEFONES</th>
			<th align="center" valign="middle">E-MAILS</th>
			<th align="center" valign="middle"><?=utf8_encode('ENDEREÇOS')?></th>
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
<?
	}
?>

</fieldset>
	
<br>

<?
}

if ((($co_contribuinte != '') && (is_numeric($co_contribuinte))) || ($no_contribuinte != '')) {

	$sql = "SELECT DISTINCT C.*, P.*, COALESCE(C.no_contribuinte, P.no_pessoa_completo) AS nome_pessoa_contribuinte, ";
	$sql = $sql."C.co_pessoa AS co_contribuinte, P.no_pessoa_completo AS nome_pessoa_completo, C.no_contribuinte, ";
	$sql = $sql."PR.no_pessoa AS nome_registrou, TPOF.no_tipo_oferta ";
	$sql = $sql."FROM contribuicoes C ";
	$sql = $sql."LEFT JOIN pessoas P ON (P.co_pessoa = C.co_pessoa) ";
	$sql = $sql."LEFT JOIN pessoas PR ON (PR.co_pessoa = C.co_pessoa_registrou) ";
	$sql = $sql."LEFT JOIN tipos_ofertas TPOF ON (TPOF.co_tipo_oferta = C.co_tipo_oferta) ";
	if ($no_contribuinte != '') {
		$sql = $sql."WHERE (C.no_contribuinte = '".$no_contribuinte."') ";
	} else if (($co_contribuinte != '') && (is_numeric($co_contribuinte))) {
		$sql = $sql."WHERE (C.co_pessoa = ".$co_contribuinte.") ";
	}
	$sql = $sql."ORDER BY nome_pessoa_contribuinte, C.aa_referencia DESC, C.mm_referencia DESC;";
	//echo $sql.'<br>';
	$rs = mysql_query($sql);
	if ($rs) {
		$contribuicoes = mysql_num_rows($rs);
		if (mysql_num_rows($rs) > 0) {
?>	
	
	<fieldset style="border: 1px solid #0b3b9d;">
		<legend><font class="font10azul"><b><?=$contribuicoes?></b> <?=utf8_encode('CONTRIBUIÇÕES')?></font></legend>
	
		<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
			<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
			<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
			<th align="center" valign="middle">ANO</th>
			<th align="center" valign="middle"><?=utf8_encode('MÊS')?></th>
			<th align="center" valign="middle">VALOR</th>
			<th align="center" valign="middle">DATA</th>
			<th align="center" valign="middle">FORMA</th>
			<th align="center" valign="middle"><?=utf8_encode('OBSERVAÇÃO')?></th>
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
				$forma_oferta = $campo["no_tipo_oferta"];
				$observacao = strtoupper(sem_acento($campo["de_observacao"]));
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
		<legend><font class="font10azul"><?=utf8_encode('CONTRIBUIÇÕES')?></font></legend>
		<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
			<tr class="trazul">
				<td align="left" valign="middle"><?=utf8_encode('Nenhuma contribuição cadastrada!')?></td>
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