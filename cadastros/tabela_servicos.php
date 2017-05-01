<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_tabela = isset($_POST['co_tabela']) ? $_POST['co_tabela'] : '';
$co_servico = isset($_POST['co_servico']) ? $_POST['co_servico'] : '';
if ($co_servico == '') {
	$co_servico = isset($_GET['co_servico']) ? $_GET['co_servico'] : '';
}

if (($co_servico == '') && ($comando == 'salvar')) {
	$no_servico = strtoupper(sem_acento(isset($_POST['no_servico']) ? $_POST['no_servico'] : ''));
	$co_tipo_servico = isset($_POST['co_tipo_servico']) ? $_POST['co_tipo_servico'] : '';
	
	$sql = "SELECT MAX(co_servico) AS maximo FROM servicos;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_servico = $campo["maximo"] + 1;
		}
	}

	$sql = "INSERT INTO servicos (co_servico, no_servico, co_tipo_servico) VALUES (";
	$sql = $sql."".$co_servico.",";
	$sql = $sql."'".$no_servico."',";
	$sql = $sql."".$co_tipo_servico.");";
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert('<?=utf8_encode("Serviço cadastrado com sucesso!")?>');</script><?
	}
	$co_servico = '';
	$no_servico = '';
	$co_tipo_servico = '';
	$comando = '';
}

if ($co_servico != '') {
	if ($comando == 'excluir') {
		$sql = "DELETE FROM servicos WHERE (co_servico = ".$co_servico.");";
		$rs = @mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Serviço excluído com sucesso!")?>');</script><?
			$co_servico = '';
		} else {
			?><script>window.alert('<?=utf8_encode("Não é possível excluir esse serviço porque existe cadastro vinculado a ele!")?>');</script><?
		}
		$comando = '';
	}
	
	if ($comando == 'atualizar') {
		$sql = "SELECT * FROM servicos WHERE (co_servico = ".$co_servico.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$no_servico = utf8_decode($campo["no_servico"]);
				$co_tipo_servico = $campo["co_tipo_servico"];
			}
		}
	}
	
	if ($comando == 'salvar') {
		$no_servico = strtoupper(sem_acento(isset($_POST['no_servico']) ? $_POST['no_servico'] : ''));
		$co_tipo_servico = isset($_POST['co_tipo_servico']) ? $_POST['co_tipo_servico'] : '';
		
		$sql = "UPDATE servicos ";
		$sql = $sql."SET no_servico = '".$no_servico."', ";
		$sql = $sql."    co_tipo_servico = ".$co_tipo_servico." ";
		$sql = $sql."WHERE (co_servico = ".$co_servico.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Serviço atualizado com sucesso!")?>');</script><?
		}
		$co_servico = '';
		$no_servico = '';
		$co_tipo_servico = '';
		$comando = '';
	}
}
?>

<script language="javascript">
	function salvar (co_servico) {
		if (document.forms["form"]["no_servico"].value == '') {
			window.alert('<?=utf8_encode("Favor preencher o NOME do serviço!")?>');
		} else if (document.forms["form"]["co_tipo_servico"].value == '') {
			window.alert('<?=utf8_encode("Favor selecionar o TIPO de serviço!")?>');
		} else {
			abrir(form,1,'tabelas.php','co_servico=' + co_servico + '&comando=salvar');
		}
	}
	function consultar() {
		abrir(form,1,'tabelas.php','width=<?=$width?>&height=<?=$height?>');
	}
	function atualizar (co_servico) {
		abrir(form,1,'tabelas.php','co_servico=' + co_servico + '&comando=atualizar');
	}
	function excluir (co_servico, no_servico) {
		if (confirm('Tem certeza que deseja excluir o <?=utf8_encode("serviço")?> ' + no_servico + '?')) {
			abrir(form,1,'tabelas.php','co_servico=' + co_servico + '&comando=excluir');
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
			<font class="font10azul"><?=utf8_encode('NOME DO SERVIÇO')?>:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_servico" value="<?=$no_servico?>" size="80" maxlength="100">
		</td>
	</tr>
	
	<tr>
		<td align="left" valign="middle">
			<font class="font10azul"><?=utf8_encode('TIPO DO SERVIÇO')?>:</font>
		</td>
		<td align="left" valign="middle">
			<select name="co_tipo_servico">
				<option value="" selected>
<?
	$sql = "SELECT co_tipo_servico, no_tipo_servico FROM tipos_servicos ORDER BY no_tipo_servico;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_tipo_servico == $campo["co_tipo_servico"]) {
					$no_tipo_servico = $campo["no_tipo_servico"];
?>
					<option value="<?=$campo["co_tipo_servico"]?>" selected><?=utf8_encode($campo["no_tipo_servico"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_tipo_servico"]?>"><?=utf8_encode($campo["no_tipo_servico"])?>
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
			<input type="button" id="botao_salvar" name="botao_salvar" value="Salvar" class="botao" OnClick="salvar('<?=$co_servico?>');">
		</td>
	</tr>
</table>

</fieldset>

<br>

<?
	$sql = "SELECT * FROM servicos S LEFT JOIN tipos_servicos TS ON (S.co_tipo_servico = TS.co_tipo_servico) ORDER BY TS.no_tipo_servico, S.no_servico;";
	$rs = mysql_query($sql);
	if ($rs) {
		$servicos = 0;
		if (mysql_num_rows($rs) > 0) {
			$servicos = mysql_num_rows($rs);
?>
<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><b><?=$servicos?></b> <?=utf8_encode('SERVIÇOS')?></font></legend>

	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
		<th width="69%" align="center" valign="middle"><?=utf8_encode('NOME DO SERVIÇO')?></th>
		<th width="25" align="center" valign="middle"><?=utf8_encode('TIPO DO SERVIÇO')?></th>

<?
			$cor_fundo = "trazul";
			$i = 0;
			while ($i < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$co_servico = $campo["co_servico"];
				$no_servico = utf8_encode($campo["no_servico"]);
				$co_tipo_servico = $campo["co_tipo_servico"];
				$no_tipo_servico = utf8_encode($campo["no_tipo_servico"]);
						
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
			<tr class="<?=$cor_fundo?>">
				<td align="center" valign="middle" title="<?=utf8_encode('Atualizar Serviço')?>">
					<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar(<?=$co_servico?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle" title="<?=utf8_encode('Excluir Serviço')?>">
					<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir(<?=$co_servico?>,'<?=$no_servico?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="left" valign="middle"><?=$no_servico?></td>
				<td align="left" valign="middle"><?=$no_tipo_servico?></td>
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
	<legend><font class="font10azul"><?=utf8_encode('CONFIGURAÇÕES')?></font></legend>
	
	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<tr class="trazul">
			<td align="left" valign="middle"><?=utf8_encode('Nenhum serviço existente!')?></td>
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