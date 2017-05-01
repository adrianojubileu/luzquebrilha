<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_tabela = isset($_POST['co_tabela']) ? $_POST['co_tabela'] : '';
$co_estado_civil = isset($_POST['co_estado_civil']) ? $_POST['co_estado_civil'] : '';
if ($co_estado_civil == '') {
	$co_estado_civil = isset($_GET['co_estado_civil']) ? $_GET['co_estado_civil'] : '';
}

if (($co_estado_civil == '') && ($comando == 'salvar')) {
	$no_estado_civil = strtoupper(sem_acento(isset($_POST['no_estado_civil']) ? $_POST['no_estado_civil'] : ''));
	
	$sql = "SELECT MAX(co_estado_civil) AS maximo FROM tipos_estados_civil;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_estado_civil = $campo["maximo"] + 1;
		}
	}

	$sql = "INSERT INTO tipos_estados_civil (co_estado_civil, no_estado_civil) VALUES (";
	$sql = $sql."".$co_estado_civil.",";
	$sql = $sql."'".$no_estado_civil."');";
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert('<?=utf8_encode("Estado Civil cadastrado com sucesso!")?>');</script><?
	}
	$co_estado_civil = '';
	$no_estado_civil = '';
	$comando = '';
}

if ($co_estado_civil != '') {
	if ($comando == 'excluir') {
		$sql = "DELETE FROM tipos_estados_civil WHERE (co_estado_civil = ".$co_estado_civil.");";
		$rs = @mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Estado Civil excluído com sucesso!")?>');</script><?
			$co_estado_civil = '';
		} else {
			?><script>window.alert('<?=utf8_encode("Não é possível excluir esse Estado Civil porque existe cadastro vinculado a ele!")?>');</script><?
		}
		$comando = '';
	}
	
	if ($comando == 'atualizar') {
		$sql = "SELECT * FROM tipos_estados_civil WHERE (co_estado_civil = ".$co_estado_civil.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$no_estado_civil = utf8_decode($campo["no_estado_civil"]);
			}
		}
	}
	
	if ($comando == 'salvar') {
		$no_estado_civil = strtoupper(sem_acento(isset($_POST['no_estado_civil']) ? $_POST['no_estado_civil'] : ''));
		
		$sql = "UPDATE tipos_estados_civil ";
		$sql = $sql."SET no_estado_civil = '".$no_estado_civil."' ";
		$sql = $sql."WHERE (co_estado_civil = ".$co_estado_civil.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Estado Civil atualizado com sucesso!")?>');</script><?
		}
		$co_estado_civil = '';
		$no_estado_civil = '';
		$comando = '';
	}
}
?>

<script language="javascript">
	function salvar (co_estado_civil) {
		if (document.forms["form"]["no_estado_civil"].value == '') {
			window.alert('<?=utf8_encode("Favor preencher o NOME do Estado Civil!")?>');
		} else {
			abrir(form,1,'tabelas.php','co_estado_civil=' + co_estado_civil + '&comando=salvar');
		}
	}
	function consultar() {
		abrir(form,1,'tabelas.php','width=<?=$width?>&height=<?=$height?>');
	}
	function atualizar (co_estado_civil) {
		abrir(form,1,'tabelas.php','co_estado_civil=' + co_estado_civil + '&comando=atualizar');
	}
	function excluir (co_estado_civil, no_estado_civil) {
		if (confirm('Tem certeza que deseja excluir o <?=utf8_encode("Estado Civil")?> ' + no_estado_civil + '?')) {
			abrir(form,1,'tabelas.php','co_estado_civil=' + co_estado_civil + '&comando=excluir');
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
			<font class="font10azul"><?=utf8_encode('NOME DO ESTADO CIVIL')?>:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_estado_civil" value="<?=$no_estado_civil?>" size="80" maxlength="100">
		</td>
	</tr>
	
	<tr align="left">
		<td align="left" valign="middle">
			<input type="button" id="botao_salvar" name="botao_salvar" value="Salvar" class="botao" OnClick="salvar('<?=$co_estado_civil?>');">
		</td>
	</tr>
</table>

</fieldset>

<br>

<?
	$sql = "SELECT * FROM tipos_estados_civil ORDER BY no_estado_civil;";
	$rs = mysql_query($sql);
	if ($rs) {
		$tipos_estados_civil = 0;
		if (mysql_num_rows($rs) > 0) {
			$tipos_estados_civil = mysql_num_rows($rs);
?>
<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><b><?=$tipos_estados_civil?></b> <?=utf8_encode('TIPOS DE ESTADOS CIVIS')?></font></legend>

	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
		<th width="94%" align="center" valign="middle"><?=utf8_encode('NOME DO ESTADO CIVIL')?></th>

<?
			$cor_fundo = "trazul";
			$i = 0;
			while ($i < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$co_estado_civil = $campo["co_estado_civil"];
				$no_estado_civil = utf8_encode($campo["no_estado_civil"]);
						
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
			<tr class="<?=$cor_fundo?>">
				<td align="center" valign="middle" title="<?=utf8_encode('Atualizar Estado Civil')?>">
					<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar(<?=$co_estado_civil?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle" title="<?=utf8_encode('Excluir Estado Civil')?>">
					<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir(<?=$co_estado_civil?>,'<?=$no_estado_civil?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="left" valign="middle"><?=$no_estado_civil?></td>
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
			<td align="left" valign="middle"><?=utf8_encode('Nenhum Estado Civil existente!')?></td>
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