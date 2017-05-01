<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_tabela = isset($_POST['co_tabela']) ? $_POST['co_tabela'] : '';
$co_funcao = isset($_POST['co_funcao']) ? $_POST['co_funcao'] : '';
if ($co_funcao == '') {
	$co_funcao = isset($_GET['co_funcao']) ? $_GET['co_funcao'] : '';
}

if (($co_funcao == '') && ($comando == 'salvar')) {
	$no_funcao = strtoupper(sem_acento(isset($_POST['no_funcao']) ? $_POST['no_funcao'] : ''));
	
	$sql = "SELECT MAX(co_funcao) AS maximo FROM tipos_funcoes;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
			$campo = mysql_fetch_array($rs);
			$co_funcao = $campo["maximo"] + 1;
		}
	}

	$sql = "INSERT INTO tipos_funcoes (co_funcao, no_funcao) VALUES (";
	$sql = $sql."".$co_funcao.",";
	$sql = $sql."'".$no_funcao."');";
	$rs = mysql_query($sql);
	if ($rs) {
		?><script>window.alert('<?=utf8_encode("Função cadastrada com sucesso!")?>');</script><?
	}
	$co_funcao = '';
	$no_funcao = '';
	$comando = '';
}

if ($co_funcao != '') {
	if ($comando == 'excluir') {
		$sql = "DELETE FROM tipos_funcoes WHERE (co_funcao = ".$co_funcao.");";
		$rs = @mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Função excluída com sucesso!")?>');</script><?
			$co_funcao = '';
		} else {
			?><script>window.alert('<?=utf8_encode("Não é possível excluir essa Função porque existe cadastro vinculado a ela!")?>');</script><?
		}
		$comando = '';
	}
	
	if ($comando == 'atualizar') {
		$sql = "SELECT * FROM tipos_funcoes WHERE (co_funcao = ".$co_funcao.");";
		$rs = mysql_query($sql);
		if ($rs) {
			if (mysql_num_rows($rs) > 0) {
				$campo = mysql_fetch_array($rs);
				$no_funcao = utf8_decode($campo["no_funcao"]);
			}
		}
	}
	
	if ($comando == 'salvar') {
		$no_funcao = strtoupper(sem_acento(isset($_POST['no_funcao']) ? $_POST['no_funcao'] : ''));
		
		$sql = "UPDATE tipos_funcoes ";
		$sql = $sql."SET no_funcao = '".$no_funcao."' ";
		$sql = $sql."WHERE (co_funcao = ".$co_funcao.");";
		$rs = mysql_query($sql);
		if ($rs) {
			?><script>window.alert('<?=utf8_encode("Função atualizada com sucesso!")?>');</script><?
		}
		$co_funcao = '';
		$no_funcao = '';
		$comando = '';
	}
}
?>

<script language="javascript">
	function salvar (co_funcao) {
		if (document.forms["form"]["no_funcao"].value == '') {
			window.alert('<?=utf8_encode("Favor preencher o NOME da Função!")?>');
		} else {
			abrir(form,1,'tabelas.php','co_funcao=' + co_funcao + '&comando=salvar');
		}
	}
	function consultar() {
		abrir(form,1,'tabelas.php','width=<?=$width?>&height=<?=$height?>');
	}
	function atualizar (co_funcao) {
		abrir(form,1,'tabelas.php','co_funcao=' + co_funcao + '&comando=atualizar');
	}
	function excluir (co_funcao, no_funcao) {
		if (confirm('Tem certeza que deseja excluir a <?=utf8_encode("Função")?> ' + no_funcao + '?')) {
			abrir(form,1,'tabelas.php','co_funcao=' + co_funcao + '&comando=excluir');
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
			<font class="font10azul"><?=utf8_encode('NOME DO FUNÇÃO')?>:</font>
		</td>
		<td align="left" valign="middle">
			<input type="text" name="no_funcao" value="<?=$no_funcao?>" size="80" maxlength="100">
		</td>
	</tr>
	
	<tr align="left">
		<td align="left" valign="middle">
			<input type="button" id="botao_salvar" name="botao_salvar" value="Salvar" class="botao" OnClick="salvar('<?=$co_funcao?>');">
		</td>
	</tr>
</table>

</fieldset>

<br>

<?
	$sql = "SELECT * FROM tipos_funcoes ORDER BY no_funcao;";
	$rs = mysql_query($sql);
	if ($rs) {
		$tipos_funcoes = 0;
		if (mysql_num_rows($rs) > 0) {
			$tipos_funcoes = mysql_num_rows($rs);
?>
<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><b><?=$tipos_funcoes?></b> <?=utf8_encode('FUNÇÕES')?></font></legend>

	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
		<th width="3%" align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
		<th width="94%" align="center" valign="middle"><?=utf8_encode('NOME DA FUNÇÃO')?></th>

<?
			$cor_fundo = "trazul";
			$i = 0;
			while ($i < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$co_funcao = $campo["co_funcao"];
				$no_funcao = utf8_encode($campo["no_funcao"]);
						
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
			<tr class="<?=$cor_fundo?>">
				<td align="center" valign="middle" title="<?=utf8_encode('Atualizar Função')?>">
					<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar(<?=$co_funcao?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="center" valign="middle" title="<?=utf8_encode('Excluir Função')?>">
					<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir(<?=$co_funcao?>,'<?=$no_funcao?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
				</td>
				<td align="left" valign="middle"><?=$no_funcao?></td>
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
			<td align="left" valign="middle"><?=utf8_encode('Nenhuma Função existente!')?></td>
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