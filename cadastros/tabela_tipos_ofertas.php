<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_tabela = isset($_POST['co_tabela']) ? $_POST['co_tabela'] : '';
$co_tipo_oferta = isset($_POST['co_tipo_oferta']) ? $_POST['co_tipo_oferta'] : '';
if ($co_tipo_oferta == '') {
	$co_tipo_oferta = isset($_GET['co_tipo_oferta']) ? $_GET['co_tipo_oferta'] : '';
}

if (($co_tipo_oferta == '') && ($comando == 'salvar')) {
	$no_tipo_oferta = strtoupper(sem_acento(isset($_POST['no_tipo_oferta']) ? $_POST['no_tipo_oferta'] : ''));
	
	$sql = "SELECT MAX(co_tipo_oferta) AS maximo FROM tipos_ofertas;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_tipo_oferta = $campo["maximo"] + 1;
		}
	}

	$sql = "INSERT INTO tipos_ofertas (co_tipo_oferta, no_tipo_oferta) VALUES (";
	$sql = $sql."".$co_tipo_oferta.",";
	$sql = $sql."'".$no_tipo_oferta."');";
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert('<?=utf8_encode("Tipo de Oferta cadastrado com sucesso!")?>');</script><?
	}
	$co_tipo_oferta = '';
	$no_tipo_oferta = '';
	$comando = '';
}

if ($co_tipo_oferta != '') {
	if ($comando == 'excluir') {
		$sql = "DELETE FROM tipos_ofertas WHERE (co_tipo_oferta = ".$co_tipo_oferta.");";
		$rs = @mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Tipo de Oferta excluído com sucesso!")?>');</script><?
			$co_tipo_oferta = '';
		} else {
			?><script>window.alert('<?=utf8_encode("Não é possível excluir esse Tipo de Oferta porque existe cadastro vinculado a ele!")?>');</script><?
		}
		$comando = '';
	}
	
	if ($comando == 'atualizar') {
		$sql = "SELECT * FROM tipos_ofertas WHERE (co_tipo_oferta = ".$co_tipo_oferta.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$no_tipo_oferta = utf8_decode($campo["no_tipo_oferta"]);
			}
		}
	}
	
	if ($comando == 'salvar') {
		$no_tipo_oferta = strtoupper(sem_acento(isset($_POST['no_tipo_oferta']) ? $_POST['no_tipo_oferta'] : ''));
		
		$sql = "UPDATE tipos_ofertas ";
		$sql = $sql."SET no_tipo_oferta = '".$no_tipo_oferta."' ";
		$sql = $sql."WHERE (co_tipo_oferta = ".$co_tipo_oferta.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Tipo de Oferta atualizado com sucesso!")?>');</script><?
		}
		$co_tipo_oferta = '';
		$no_tipo_oferta = '';
		$comando = '';
	}
}
?>

<script language="javascript">
	function salvar (co_tipo_oferta) {
		if (document.forms["form"]["no_tipo_oferta"].value == '') {
			window.alert('<?=utf8_encode("Favor preencher o NOME do Tipo de Oferta!")?>');
		} else {
			abrir(form,1,'tabelas.php','co_tipo_oferta=' + co_tipo_oferta + '&comando=salvar');
		}
	}
	function consultar() {
		abrir(form,1,'tabelas.php','width=<?=$width?>&height=<?=$height?>');
	}
	function atualizar (co_tipo_oferta) {
		abrir(form,1,'tabelas.php','co_tipo_oferta=' + co_tipo_oferta + '&comando=atualizar');
	}
	function excluir (co_tipo_oferta, no_tipo_oferta) {
		if (confirm('Tem certeza que deseja excluir o <?=utf8_encode("Tipo de Oferta")?> ' + no_tipo_oferta + '?')) {
			abrir(form,1,'tabelas.php','co_tipo_oferta=' + co_tipo_oferta + '&comando=excluir');
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
			<font class="font10azul"><?=utf8_encode('NOME DO TIPO DE OFERTA')?>:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_tipo_oferta" value="<?=$no_tipo_oferta?>" size="80" maxlength="100">
		</td>
	</tr>
	
	<tr align="left">
		<td align="left" valign="middle">
			<input type="button" id="botao_salvar" name="botao_salvar" value="Salvar" class="botao" OnClick="salvar('<?=$co_tipo_oferta?>');">
		</td>
	</tr>
</table>

</fieldset>

<br>

<?
	$sql = "SELECT * FROM tipos_ofertas ORDER BY no_tipo_oferta;";
	$rs = mysql_query($sql);
	if ($rs) {
		$tipos_ofertas = 0;
		if (mysql_num_rows($rs) > 0) {
			$tipos_ofertas = mysql_num_rows($rs);
?>
<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><b><?=$tipos_ofertas?></b> <?=utf8_encode('TIPOS DE OFERTAS')?></font></legend>

	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
		<th width="94%" align="center" valign="middle"><?=utf8_encode('NOME DO TIPO DE OFERTA')?></th>

<?
			$cor_fundo = "trazul";
			$i = 0;
			while ($i < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$co_tipo_oferta = $campo["co_tipo_oferta"];
				$no_tipo_oferta = utf8_encode($campo["no_tipo_oferta"]);
						
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
			<tr class="<?=$cor_fundo?>">
				<td align="center" valign="middle" title="<?=utf8_encode('Atualizar Tipo de Oferta')?>">
					<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar(<?=$co_tipo_oferta?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle" title="<?=utf8_encode('Excluir Tipo de Oferta')?>">
					<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir(<?=$co_tipo_oferta?>,'<?=$no_tipo_oferta?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="left" valign="middle"><?=$no_tipo_oferta?></td>
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
			<td align="left" valign="middle"><?=utf8_encode('Nenhum Tipo de Oferta existente!')?></td>
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