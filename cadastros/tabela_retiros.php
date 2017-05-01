<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_tabela = isset($_POST['co_tabela']) ? $_POST['co_tabela'] : '';
$co_retiro = isset($_POST['co_retiro']) ? $_POST['co_retiro'] : '';
if ($co_retiro == '') {
	$co_retiro = isset($_GET['co_retiro']) ? $_GET['co_retiro'] : '';
}

if (($co_retiro == '') && ($comando == 'salvar')) {
	$no_retiro = strtoupper(sem_acento(isset($_POST['no_retiro']) ? $_POST['no_retiro'] : ''));
	$co_tipo_retiro = isset($_POST['co_tipo_retiro']) ? $_POST['co_tipo_retiro'] : '';
	
	$sql = "SELECT MAX(co_retiro) AS maximo FROM retiros;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_retiro = $campo["maximo"] + 1;
		}
	}

	$sql = "INSERT INTO retiros (co_retiro, no_retiro, co_tipo_retiro) VALUES (";
	$sql = $sql."".$co_retiro.",";
	$sql = $sql."'".$no_retiro."',";
	$sql = $sql."".$co_tipo_retiro.");";
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert('Retiro cadastrado com sucesso!');</script><?
	}
	$co_retiro = '';
	$no_retiro = '';
	$co_tipo_retiro = '';
	$comando = '';
}

if ($co_retiro != '') {
	if ($comando == 'excluir') {
		$sql = "DELETE FROM retiros WHERE (co_retiro = ".$co_retiro.");";
		$rs = @mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Retiro excluído com sucesso!")?>');</script><?
			$co_retiro = '';
		} else {
			?><script>window.alert('<?=utf8_encode("Não é possível excluir esse Retiro porque existe cadastro vinculado a ele!")?>');</script><?
		}
		$comando = '';
	}
	
	if ($comando == 'atualizar') {
		$sql = "SELECT * FROM retiros WHERE (co_retiro = ".$co_retiro.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$no_retiro = utf8_decode($campo["no_retiro"]);
				$co_tipo_retiro = $campo["co_tipo_retiro"];
			}
		}
	}
	
	if ($comando == 'salvar') {
		$no_retiro = strtoupper(sem_acento(isset($_POST['no_retiro']) ? $_POST['no_retiro'] : ''));
		$co_tipo_retiro = isset($_POST['co_tipo_retiro']) ? $_POST['co_tipo_retiro'] : '';
		
		$sql = "UPDATE retiros ";
		$sql = $sql."SET no_retiro = '".$no_retiro."', ";
		$sql = $sql."    co_tipo_retiro = ".$co_tipo_retiro." ";
		$sql = $sql."WHERE (co_retiro = ".$co_retiro.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('Retiro atualizado com sucesso!');</script><?
		}
		$co_retiro = '';
		$no_retiro = '';
		$co_tipo_retiro = '';
		$comando = '';
	}
}
?>

<script language="javascript">
	function salvar (co_retiro) {
		if (document.forms["form"]["no_retiro"].value == '') {
			window.alert('Favor preencher o NOME do retiro!');
		} else if (document.forms["form"]["co_tipo_retiro"].value == '') {
			window.alert('Favor selecionar o TIPO de retiro!');
		} else {
			abrir(form,1,'tabelas.php','co_retiro=' + co_retiro + '&comando=salvar');
		}
	}
	function consultar() {
		abrir(form,1,'tabelas.php','width=<?=$width?>&height=<?=$height?>');
	}
	function atualizar (co_retiro) {
		abrir(form,1,'tabelas.php','co_retiro=' + co_retiro + '&comando=atualizar');
	}
	function excluir (co_retiro, no_retiro) {
		if (confirm('Tem certeza que deseja excluir o retiro ' + no_retiro + '?')) {
			abrir(form,1,'tabelas.php','co_retiro=' + co_retiro + '&comando=excluir');
		}
	}
</script>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<br>

<?
if ($co_tabela != '') {
?>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><?=utf8_encode('CONFIGURAÇÕES')?></font></legend>

<table cellpadding="2" cellspacing="5">
	<tr align="left">
		<td align="left" valign="middle">
			<font class="font10azul">NOME DO RETIRO:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_retiro" value="<?=$no_retiro?>" size="80" maxlength="100">
		</td>
	</tr>
	
	<tr>
		<td align="left" valign="middle">
			<font class="font10azul">TIPO DO RETIRO:</font>
		</td>
		<td align="left" valign="middle">
			<select name="co_tipo_retiro">
				<option value="" selected>
<?
	$sql = "SELECT co_tipo_retiro, no_tipo_retiro FROM tipos_retiros ORDER BY no_tipo_retiro;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_tipo_retiro == $campo["co_tipo_retiro"]) {
					$no_tipo_retiro = $campo["no_tipo_retiro"];
?>
					<option value="<?=$campo["co_tipo_retiro"]?>" selected><?=utf8_encode($campo["no_tipo_retiro"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_tipo_retiro"]?>"><?=utf8_encode($campo["no_tipo_retiro"])?>
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

	<tr align="left">
		<td align="left" valign="middle">
			<input type="button" id="botao_salvar" name="botao_salvar" value="Salvar" class="botao" OnClick="salvar('<?=$co_retiro?>');">
		</td>
	</tr>
</table>

</fieldset>

<br>

<?
	$sql = "SELECT * FROM retiros R LEFT JOIN tipos_retiros TR ON (R.co_tipo_retiro = TR.co_tipo_retiro) ORDER BY TR.no_tipo_retiro, R.no_retiro;";
	$rs = mysql_query($sql);
	if ($rs) {
		$retiros = 0;
		if (mysql_num_rows($rs) > 0) {
			$retiros = mysql_num_rows($rs);
?>
<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><b><?=$retiros?></b> RETIROS</font></legend>

	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
		<th width="69%" align="center" valign="middle">NOME DO RETIRO</th>
		<th width="25" align="center" valign="middle">TIPO DO RETIRO</th>

<?
			$cor_fundo = "trazul";
			$i = 0;
			while ($i < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$co_retiro = $campo["co_retiro"];
				$no_retiro = utf8_encode($campo["no_retiro"]);
				$co_tipo_retiro = $campo["co_tipo_retiro"];
				$no_tipo_retiro = utf8_encode($campo["no_tipo_retiro"]);
						
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
			<tr class="<?=$cor_fundo?>">
				<td align="center" valign="middle" title="Atualizar retiro">
					<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar(<?=$co_retiro?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle" title="Excluir retiro">
					<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir(<?=$co_retiro?>,'<?=$no_retiro?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="left" valign="middle"><?=$no_retiro?></td>
				<td align="left" valign="middle"><?=$no_tipo_retiro?></td>
			</tr>
<?
			}
?>
		</table>

</fieldset>

<br>
<?
		} else {
?>
<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">CONFIGURAÇÕES</font></legend>
	
	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<tr class="trazul">
			<td align="left" valign="middle">Nenhum Retiro existente!</td>
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