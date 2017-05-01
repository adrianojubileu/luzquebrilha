<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_tabela = isset($_POST['co_tabela']) ? $_POST['co_tabela'] : '';
$co_tipo_envio = isset($_POST['co_tipo_envio']) ? $_POST['co_tipo_envio'] : '';
if ($co_tipo_envio == '') {
	$co_tipo_envio = isset($_GET['co_tipo_envio']) ? $_GET['co_tipo_envio'] : '';
}

if (($co_tipo_envio == '') && ($comando == 'salvar')) {
	$no_tipo_envio = strtoupper(sem_acento(isset($_POST['no_tipo_envio']) ? $_POST['no_tipo_envio'] : ''));
	
	$sql = "SELECT MAX(co_tipo_envio) AS maximo FROM tipos_envios;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_tipo_envio = $campo["maximo"] + 1;
		}
	}

	$sql = "INSERT INTO tipos_envios (co_tipo_envio, no_tipo_envio) VALUES (";
	$sql = $sql."".$co_tipo_envio.",";
	$sql = $sql."'".$no_tipo_envio."');";
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert('<?=utf8_encode("Tipo de Envio cadastrado com sucesso!")?>');</script><?
	}
	$co_tipo_envio = '';
	$no_tipo_envio = '';
	$comando = '';
}

if ($co_tipo_envio != '') {
	if ($comando == 'excluir') {
		$sql = "DELETE FROM tipos_envios WHERE (co_tipo_envio = ".$co_tipo_envio.");";
		$rs = @mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Tipo de Envio excluído com sucesso!")?>');</script><?
			$co_tipo_envio = '';
		} else {
			?><script>window.alert('<?=utf8_encode("Não é possível excluir esse Tipo de Envio porque existe cadastro vinculado a ele!")?>');</script><?
		}
		$comando = '';
	}
	
	if ($comando == 'atualizar') {
		$sql = "SELECT * FROM tipos_envios WHERE (co_tipo_envio = ".$co_tipo_envio.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$no_tipo_envio = utf8_decode($campo["no_tipo_envio"]);
			}
		}
	}
	
	if ($comando == 'salvar') {
		$no_tipo_envio = strtoupper(sem_acento(isset($_POST['no_tipo_envio']) ? $_POST['no_tipo_envio'] : ''));
		
		$sql = "UPDATE tipos_envios ";
		$sql = $sql."SET no_tipo_envio = '".$no_tipo_envio."' ";
		$sql = $sql."WHERE (co_tipo_envio = ".$co_tipo_envio.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Tipo de Envio atualizado com sucesso!")?>');</script><?
		}
		$co_tipo_envio = '';
		$no_tipo_envio = '';
		$comando = '';
	}
}
?>

<script language="javascript">
	function salvar (co_tipo_envio) {
		if (document.forms["form"]["no_tipo_envio"].value == '') {
			window.alert('<?=utf8_encode("Favor preencher o NOME do Tipo de Envio!")?>');
		} else {
			abrir(form,1,'tabelas.php','co_tipo_envio=' + co_tipo_envio + '&comando=salvar');
		}
	}
	function consultar() {
		abrir(form,1,'tabelas.php','width=<?=$width?>&height=<?=$height?>');
	}
	function atualizar (co_tipo_envio) {
		abrir(form,1,'tabelas.php','co_tipo_envio=' + co_tipo_envio + '&comando=atualizar');
	}
	function excluir (co_tipo_envio, no_tipo_envio) {
		if (confirm('Tem certeza que deseja excluir o <?=utf8_encode("Tipo de Envio")?> ' + no_tipo_envio + '?')) {
			abrir(form,1,'tabelas.php','co_tipo_envio=' + co_tipo_envio + '&comando=excluir');
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
			<font class="font10azul"><?=utf8_encode('NOME DO TIPO DE ENVIO')?>:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_tipo_envio" value="<?=$no_tipo_envio?>" size="80" maxlength="100">
		</td>
	</tr>
	
	<tr align="left">
		<td align="left" valign="middle">
			<input type="button" id="botao_salvar" name="botao_salvar" value="Salvar" class="botao" OnClick="salvar('<?=$co_tipo_envio?>');">
		</td>
	</tr>
</table>

</fieldset>

<br>

<?
	$sql = "SELECT * FROM tipos_envios ORDER BY no_tipo_envio;";
	$rs = mysql_query($sql);
	if ($rs) {
		$tipos_envios = 0;
		if (mysql_num_rows($rs) > 0) {
			$tipos_envios = mysql_num_rows($rs);
?>
<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><b><?=$tipos_envios?></b> <?=utf8_encode('TIPOS DE ENVIOS')?></font></legend>

	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
		<th width="94%" align="center" valign="middle"><?=utf8_encode('NOME DO TIPO DE ENVIO')?></th>

<?
			$cor_fundo = "trazul";
			$i = 0;
			while ($i < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$co_tipo_envio = $campo["co_tipo_envio"];
				$no_tipo_envio = utf8_encode($campo["no_tipo_envio"]);
						
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
			<tr class="<?=$cor_fundo?>">
				<td align="center" valign="middle" title="<?=utf8_encode('Atualizar Tipo de Envio')?>">
					<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar(<?=$co_tipo_envio?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle" title="<?=utf8_encode('Excluir Tipo de Envio')?>">
					<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir(<?=$co_tipo_envio?>,'<?=$no_tipo_envio?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="left" valign="middle"><?=$no_tipo_envio?></td>
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
			<td align="left" valign="middle"><?=utf8_encode('Nenhum Tipo de Envio existente!')?></td>
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