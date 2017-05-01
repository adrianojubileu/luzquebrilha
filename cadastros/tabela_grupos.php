<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_tabela = isset($_POST['co_tabela']) ? $_POST['co_tabela'] : '';
$co_grupo = isset($_POST['co_grupo']) ? $_POST['co_grupo'] : '';
if ($co_grupo == '') {
	$co_grupo = isset($_GET['co_grupo']) ? $_GET['co_grupo'] : '';
}

if (($co_grupo == '') && ($comando == 'salvar')) {
	$no_grupo = strtoupper(sem_acento(isset($_POST['no_grupo']) ? $_POST['no_grupo'] : ''));
	$co_tipo_grupo = isset($_POST['co_tipo_grupo']) ? $_POST['co_tipo_grupo'] : '';
	
	$sql = "SELECT MAX(co_grupo) AS maximo FROM grupos;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_grupo = $campo["maximo"] + 1;
		}
	}

	$sql = "INSERT INTO grupos (co_grupo, no_grupo, co_tipo_grupo) VALUES (";
	$sql = $sql."".$co_grupo.",";
	$sql = $sql."'".$no_grupo."',";
	$sql = $sql."".$co_tipo_grupo.");";
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert('Grupo cadastrado com sucesso!');</script><?
	}
	$co_grupo = '';
	$no_grupo = '';
	$co_tipo_grupo = '';
	$comando = '';
}

if ($co_grupo != '') {
	if ($comando == 'excluir') {
		$sql = "DELETE FROM grupos WHERE (co_grupo = ".$co_grupo.");";
		$rs = @mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Grupo excluído com sucesso!")?>');</script><?
			$co_grupo = '';
		} else {
			?><script>window.alert('<?=utf8_encode("Não é possível excluir esse grupo porque existe cadastro vinculado a ele!")?>');</script><?
		}
		$comando = '';
	}
	
	if ($comando == 'atualizar') {
		$sql = "SELECT * FROM grupos WHERE (co_grupo = ".$co_grupo.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$no_grupo = utf8_decode($campo["no_grupo"]);
				$co_tipo_grupo = $campo["co_tipo_grupo"];
			}
		}
	}
	
	if ($comando == 'salvar') {
		$no_grupo = strtoupper(sem_acento(isset($_POST['no_grupo']) ? $_POST['no_grupo'] : ''));
		$co_tipo_grupo = isset($_POST['co_tipo_grupo']) ? $_POST['co_tipo_grupo'] : '';
		
		$sql = "UPDATE grupos ";
		$sql = $sql."SET no_grupo = '".$no_grupo."', ";
		$sql = $sql."    co_tipo_grupo = ".$co_tipo_grupo." ";
		$sql = $sql."WHERE (co_grupo = ".$co_grupo.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('Grupo atualizado com sucesso!');</script><?
		}
		$co_grupo = '';
		$no_grupo = '';
		$co_tipo_grupo = '';
		$comando = '';
	}
}
?>

<script language="javascript">
	function salvar (co_grupo) {
		if (document.forms["form"]["no_grupo"].value == '') {
			window.alert('Favor preencher o campo NOME!');
		} else if (document.forms["form"]["co_tipo_grupo"].value == '') {
			window.alert('Favor selecionar o TIPO de grupo!');
		} else {
			abrir(form,1,'tabelas.php','co_grupo=' + co_grupo + '&comando=salvar');
		}
	}
	function consultar() {
		abrir(form,1,'tabelas.php','width=<?=$width?>&height=<?=$height?>');
	}
	function atualizar (co_grupo) {
		abrir(form,1,'tabelas.php','co_grupo=' + co_grupo + '&comando=atualizar');
	}
	function excluir (co_grupo, no_grupo) {
		if (confirm('Tem certeza que deseja excluir o grupo ' + no_grupo + '?')) {
			abrir(form,1,'tabelas.php','co_grupo=' + co_grupo + '&comando=excluir');
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
			<font class="font10azul">NOME DO GRUPO:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_grupo" value="<?=$no_grupo?>" size="80" maxlength="100">
		</td>
	</tr>
	
	<tr>
		<td align="left" valign="middle">
			<font class="font10azul">TIPO DO GRUPO:</font>
		</td>
		<td align="left" valign="middle">
			<select name="co_tipo_grupo">
				<option value="" selected>
<?
	$sql = "SELECT co_tipo_grupo, no_tipo_grupo FROM tipos_grupos ORDER BY no_tipo_grupo;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_tipo_grupo == $campo["co_tipo_grupo"]) {
					$no_tipo_grupo = $campo["no_tipo_grupo"];
?>
					<option value="<?=$campo["co_tipo_grupo"]?>" selected><?=utf8_encode($campo["no_tipo_grupo"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_tipo_grupo"]?>"><?=utf8_encode($campo["no_tipo_grupo"])?>
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
			<input type="button" id="botao_salvar" name="botao_salvar" value="Salvar" class="botao" OnClick="salvar('<?=$co_grupo?>');">
		</td>
	</tr>
</table>

</fieldset>

<br>

<?
	$sql = "SELECT * FROM grupos G LEFT JOIN tipos_grupos TG ON (G.co_tipo_grupo = TG.co_tipo_grupo) ORDER BY TG.no_tipo_grupo, G.no_grupo;";
	$rs = mysql_query($sql);
	if ($rs) {
		$grupos = 0;
		if (mysql_num_rows($rs) > 0) {
			$grupos = mysql_num_rows($rs);
?>
<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><b><?=$grupos?></b> GRUPOS</font></legend>

	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
		<th width="69%" align="center" valign="middle">NOME DO GRUPO</th>
		<th width="25" align="center" valign="middle">TIPO DO GRUPO</th>

<?
			$cor_fundo = "trazul";
			$i = 0;
			while ($i < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$co_grupo = $campo["co_grupo"];
				$no_grupo = utf8_encode($campo["no_grupo"]);
				$co_tipo_grupo = $campo["co_tipo_grupo"];
				$no_tipo_grupo = utf8_encode($campo["no_tipo_grupo"]);
						
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
			<tr class="<?=$cor_fundo?>">
				<td align="center" valign="middle" title="Atualizar Grupo">
					<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar(<?=$co_grupo?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle" title="Excluir Grupo">
					<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir(<?=$co_grupo?>,'<?=$no_grupo?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="left" valign="middle"><?=$no_grupo?></td>
				<td align="left" valign="middle"><?=$no_tipo_grupo?></td>
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
			<td align="left" valign="middle">Nenhum grupo existente!</td>
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