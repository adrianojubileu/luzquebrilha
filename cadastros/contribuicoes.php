<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$co_pessoa = isset($_GET['co_pessoa']) ? $_GET['co_pessoa'] : (isset($_POST['co_pessoa']) ? $_POST['co_pessoa'] : '');
?>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	Minhas Contribuições
</font>

<br><br>

<?
$sql = "SELECT C.*, P.*, PR.no_pessoa AS nome_registrou, TPOF.*, ";
$sql = $sql."CASE WHEN ((NOT (PT.nu_telefone IS NULL)) AND (PT.nu_telefone != '')) ";
$sql = $sql."     THEN (concat('(',PT.nu_ddd_telefone,')',substring(PT.nu_telefone, 1, 4),'-',substring(PT.nu_telefone, 5))) ";
$sql = $sql."     ELSE '' ";
$sql = $sql."END AS telefone, ";
$sql = $sql."PE.no_email ";
$sql = $sql."FROM contribuicoes C ";
$sql = $sql."LEFT JOIN pessoas P ON (P.co_pessoa = C.co_pessoa) ";
$sql = $sql."LEFT JOIN pessoas PR ON (PR.co_pessoa = C.co_pessoa_registrou) ";
$sql = $sql."LEFT JOIN pessoas_telefones PT ON (P.co_pessoa = PT.co_pessoa) AND (PT.ic_telefone_principal = 'SIM') ";
$sql = $sql."LEFT JOIN pessoas_emails PE ON (P.co_pessoa = PE.co_pessoa) AND (PE.ic_email_principal = 'SIM') ";
$sql = $sql."LEFT JOIN tipos_ofertas TPOF ON (TPOF.co_tipo_oferta = C.co_tipo_oferta) ";
$sql = $sql."WHERE (C.co_pessoa = ".$co_pessoa.") ";
$sql = $sql."ORDER BY C.aa_referencia DESC, C.mm_referencia DESC;";
//echo $sql.'<br>';
$rs = mysql_query($sql);
if ($rs) {
	$contribuicoes = mysql_num_rows($rs);
	if (mysql_num_rows($rs) > 0) {
?>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul"><b><?=$contribuicoes?></b> CONTRIBUIÇÕES</font></legend>
	
	<table width="100%" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th align="center" valign="middle">ANO</th>
		<th align="center" valign="middle">MÊS</th>
		<th align="center" valign="middle">VALOR</th>
		<th align="center" valign="middle">DATA DA OFERTA</th>
		<th align="center" valign="middle">FORMA DA OFERTA</th>
		<th align="center" valign="middle">OBSERVAÇÃO</th>
		<th align="center" valign="middle">ATUALIZAÇÃO</th>
		<th align="center" valign="middle">QUEM REGISTROU?</th>
<?
		$cor_fundo = "trazul";
		$i = 0;
		while ($i < mysql_num_rows($rs)) {
			$campo = mysql_fetch_array($rs);
			$codigo_contribuicao = $campo["co_contribuicao"];
			$codigo_pessoa = $campo["co_pessoa"];
			$codigo_pessoa_registrou = $campo["co_pessoa_registrou"];
			$nome_pessoa_completo = strtoupper(sem_acento($campo["no_pessoa_completo"]));
			$telefone = $campo["telefone"];
			$email = $campo["no_email"];
			$cpf_cnpj = $campo["nu_cpf_cnpj"];
			$tipo_pessoa = isset($_POST['co_tipo_pessoa']) ? $_POST['co_tipo_pessoa'] : '';
			if (($co_tipo_pessoa != '') && ($nu_cpf_cnpj != '')) {
				if ($co_tipo_pessoa == 'PF') {
					$cpf_cnpj = substr($cpf_cnpj,0,3).'.'.substr($cpf_cnpj,3,3).'.'.substr($cpf_cnpj,6,3).'-'.substr($cpf_cnpj,9,2);
				}
				if ($co_tipo_pessoa == 'PJ') {
					$cpf_cnpj = substr($cpf_cnpj,0,2).'.'.substr($cpf_cnpj,2,3).'.'.substr($cpf_cnpj,5,3).'/'.substr($cpf_cnpj,8,4).'-'.substr($cpf_cnpj,12,2);
				}
			}
			$valor_contribuicao = $campo["vr_contribuicao"];
			if ($valor_contribuicao != '') {
				$valor_contribuicao = number_format($valor_contribuicao, 2, ',', '.');
				$valor_contribuicao = 'R$ '.$valor_contribuicao;
			}
			$data_contribuicao = $campo["dt_contribuicao"];
			if ($data_contribuicao != '') {
				$data_contribuicao = substr($data_contribuicao, 8, 2).'/'.substr($data_contribuicao, 5, 2).'/'.substr($data_contribuicao, 0, 4);
			}
			$data_registro = $campo["dt_registro"];
			if ($data_registro != '') {
				$data_registro = substr($data_registro, 8, 2).'/'.substr($data_registro, 5, 2).'/'.substr($data_registro, 0, 4);
			}
			$mes_referencia = $campo["mm_referencia"];
			$mes_referencia = mes_por_extenso($mes_referencia);
			$ano_referencia = $campo["aa_referencia"];
			$forma_oferta = utf8_encode($campo["no_tipo_oferta"]);
			$observacao = strtoupper(sem_acento($campo["de_observacao"]));
			$nome_registrou = $campo["nome_registrou"];
						
			$i = $i + 1;
			if ($cor_fundo == "trazul") {
				$cor_fundo = "trbranco";
			} else {
				$cor_fundo = "trazul";
			}
?>	
		<tr class="<?=$cor_fundo?>">
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
			<td align="left" valign="middle">Nenhuma contribuição cadastrada ou realizada!</td>
		</tr>
	</table>
</fieldset>
<?
	}
}
?>

<br><br><br>

</div>