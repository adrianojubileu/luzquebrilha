<?
$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
$mes = isset($_POST['mes']) ? $_POST['mes'] : '';
$dia = isset($_POST['dia']) ? $_POST['dia'] : '';
?>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">FILTROS DE PESQUISA</font></legend>

	<table width="100%" cellpadding="2" cellspacing="5">
		<tr align="left">
			<td align="left" valign="middle">
				<font class="font10azul">Ano:</font>
				<select name="ano">
<?
		if ($ano == '') {
			$ano = date("Y");
		}
		for ($aa = 2014; $aa <= date("Y"); $aa++) {
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
				
				<font class="font10azul"><?=utf8_encode('Mês')?>:</font>
				<select name="mes">
					<option value="" selected>TODOS
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
				
				<font class="font10azul">Dia:</font>
				<select name="dia">
					<option value="" selected>TODOS
<?
		//if ($dia == '') {
		//	$dia = date("d");
		//}
		for ($dd = 1; $dd <= 31; $dd++) {
			if ($dd < 10) {
				$dd = '0'.$dd;
			} else {
				$dd = ''.$dd;
			}
			if ($dia == $dd) {
?>
					<option value="<?=$dd?>" selected><?=$dd?>
<?
			} else {
?>
					<option value="<?=$dd?>"><?=$dd?>
<?
			}
		}
?>
				</select>
			</td>
		</tr>
	</table>

</fieldset>

<br>

<?
if ($comando == 'pesquisar') {
	$sql = "SELECT COUNT(*) AS qtd FROM visitas";
	if ($ano != '') {
		$sql = $sql." WHERE (substring(dt_entrada, 1, 4) = '".$ano."')";
		if ($mes != '') {
			$sql = $sql." AND (substring(dt_entrada, 6, 2) = '".$mes."')";
		}
		if ($dia != '') {
			$sql = $sql." AND (substring(dt_entrada, 9, 2) = '".$dia."')";
		}
	} else {
		if ($mes != '') {
			$sql = $sql." WHERE (substring(dt_entrada, 6, 2) = '".$mes."')";
			if ($dia != '') {
				$sql = $sql." AND (substring(dt_entrada, 9, 2) = '".$dia."')";
			}
		} else {
			if ($dia != '') {
				$sql = $sql." WHERE (substring(dt_entrada, 9, 2) = '".$dia."')";
			}
		}
	}
	$sql = $sql.";";
	//echo $sql.'<br>';
	$rs = mysql_query($sql);
	if ($rs) {
		$campo = mysql_fetch_array($rs);
		$visitas = $campo["qtd"];
	}
		
	$sql = "SELECT V.*, COALESCE(P.no_pessoa_completo, V.no_login) AS nome_login ";
	$sql = $sql."FROM visitas V LEFT JOIN pessoas P ON (V.co_pessoa = P.co_pessoa) ";
	$sql = $sql."WHERE ((NOT (P.co_pessoa IS NULL)) OR (NOT (V.no_login IS NULL)))";
	if ($ano != '') {
		$sql = $sql." AND (substring(dt_entrada, 1, 4) = '".$ano."')";
	}
	if ($mes != '') {
		$sql = $sql." AND (substring(dt_entrada, 6, 2) = '".$mes."')";
	}
	if ($dia != '') {
		$sql = $sql." AND (substring(dt_entrada, 9, 2) = '".$dia."')";
	}
	$sql = $sql." ORDER BY V.dt_entrada DESC, V.hr_entrada DESC;";
	//echo $sql.'<br>';
	$rs = mysql_query($sql);
	if ($rs) {
		$registros = mysql_num_rows($rs);
		if ($registros > 0) {
?>

<fieldset style="width: 100%; border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><?=$visitas?> visitas</font></legend>
	
	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th align="center" valign="middle">NOME DO LOGIN</th>
		<th align="center" valign="middle">DATA E HORA DA TENTATIVA</th>
		<th align="center" valign="middle">LOGON EFETUADO?</th>
		<th align="center" valign="middle">MENSAGEM DO SISTEMA</th>
<?
		$cor_fundo = "trazul";
		$i = 0;
			while ($i < $registros) {
				$campo = mysql_fetch_array($rs);
				$nome_login = $campo["nome_login"];
				$data_entrada = $campo["dt_entrada"];
				if ($data_entrada != '') {
					$data_entrada = substr($data_entrada, 8, 2).'/'.substr($data_entrada, 5, 2).'/'.substr($data_entrada, 0, 4);
				}
				$hora_entrada = substr($campo["hr_entrada"], 0, 5);
				$logon = $campo["ic_logon"];
				$mensagem = $campo["de_mensagem"];

				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
		<tr class="<?=$cor_fundo?>">
			<td align="left" valign="middle"><?=utf8_decode($nome_login)?></td>
			<td align="center" valign="middle"><?=$data_entrada.' - '.$hora_entrada?></td>
			<td align="center" valign="middle"><?=$logon?></td>
			<td align="left" valign="middle"><?=$mensagem?></td>
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
	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<tr class="trazul">
			<td align="left" valign="middle">Nenhum registro encontrado para essa pesquisa!</td>
		</tr>
	</table>
</fieldset>

<?
		}
	}
}
?>

<br><br><br>