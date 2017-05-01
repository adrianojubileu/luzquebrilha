<table width="95%" height="300" align="center" valign="middle" cellpadding="1" cellspacing="1" border="0">
	<tr rowspan="3" width="100%" height="300" align="center" valign="middle" bgcolor="#EDF2FC">
		<td width="30%" height="300" align="center" valign="middle">
			<img src="http://www.obralumen.org.br/sistemas/imagens/centro_social_lumen/conheca_csl.jpg" height="290" width="290">
		</td>
		<td width="1%" height="300" align="center" valign="middle"></td>
		<td width="45%" height="300" align="center" valign="middle">
			<table width="100%" height="300" align="center" valign="middle" cellpadding="2" cellspacing="2" border="0">
				<tr width="100%" height="145" align="center" valign="middle" bgcolor="#EDF2FC">
					<td width="100%" height="100%" align="center" valign="middle">
						<font style="font-family:Verdana; color:blue; font-size:18pt; font-weight:bold;">
							Faça a sua doação e contribua com os projetos sociais e a evangelização!
						</font>
						<br><br>
<?
					if ($co_pessoa_login == '') {
?>
						<font style="font-family:Verdana; color:blue; font-size:18pt; font-weight:bold;">
							<a href="http://luzquebrilha.obralumen.org.br/principal.php?menu=1&pg=cadastro.php&width=<?=$width?>&height=<?=$height?>"><b>CLIQUE AQUI E CADASTRE-SE</b></a>
						</font>
<?
					}
?>
					</td>
				</tr>
				<tr width="100%" height="145" align="center" valign="middle" bgcolor="#EDF2FC">
					<td width="100%" height="100%" align="center" valign="middle">				
<?
$ano = date('Y');
$mes = date('m');
$meta[2] = 40000;

$sql = "SELECT COUNT(*) AS contribuicoes, SUM(vr_contribuicao) AS arrecadacao FROM contribuicoes ";
$sql = $sql."WHERE (EXTRACT(year FROM dt_contribuicao) = '".$ano."') AND (EXTRACT(month FROM dt_contribuicao) = '".$mes."');";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$contribuicoes[2] = $campo["contribuicoes"];
		$arrecadacao[2] = $campo["arrecadacao"];
	}
}

$percentual_arrecadado[2] = ($arrecadacao[2] / $meta[2]) * 100;
$progresso[2] = number_format($percentual_arrecadado[2], 2, '.', '');
if ($percentual_arrecadado[2] > 100) {
	$percentual_arrecadado[2] = number_format(100, 0, '', '');
} else {
	$percentual_arrecadado[2] = number_format($percentual_arrecadado[2], 2, ',', '.');
}
$arrecadacao[2] = number_format($arrecadacao[2], 2, ',', '.');
$meta[2] = number_format($meta[2], 2, ',', '.');
$contribuicoes[2] = number_format($contribuicoes[2], 0, ',', '.');
?>
						<font style="font-family:Verdana; color:orange; font-size:12pt; font-weight:bold;">
							Vamos juntos alcançar nossa meta do mês!
						</font>
						<br><br>
						
						<font style="font-family:Verdana; color:blue; font-size:20pt; font-weight:bold;">
						<?=mes_por_extenso($mes).'/'.$ano?><br>
						<progress value="<?=$progresso[2]?>" max="100"></progress> <?=$percentual_arrecadado[2]?>%
<?
						if ($co_perfil_login == '1') {
?>
							<br>
							<font style="font-size:10pt;">
							R$ <?=$arrecadacao[2]?> de R$ <?=$meta[2]?> (<?=$contribuicoes[2]?> contribuições)<br>
							</font>
<?
						}
?>
						</font>
						<br><br>
<?
if ($mes == 1) {
	$mes = 12;
	$ano = $ano - 1;
} else {
	$mes = $mes - 1;
}
$meta[1] = 30000;

$sql = "SELECT COUNT(*) AS contribuicoes, SUM(vr_contribuicao) AS arrecadacao FROM contribuicoes ";
$sql = $sql."WHERE (EXTRACT(year FROM dt_contribuicao) = '".$ano."') AND (EXTRACT(month FROM dt_contribuicao) = '".$mes."');";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$contribuicoes[1] = $campo["contribuicoes"];
		$arrecadacao[1] = $campo["arrecadacao"];
	}
}

$percentual_arrecadado[1] = ($arrecadacao[1] / $meta[1]) * 100;
$progresso[1] = number_format($percentual_arrecadado[1], 2, '.', '');
if ($percentual_arrecadado[1] > 100) {
	$percentual_arrecadado[1] = number_format(100, 0, '', '');
} else {
	$percentual_arrecadado[1] = number_format($percentual_arrecadado[1], 2, ',', '.');
}
$arrecadacao[1] = number_format($arrecadacao[1], 2, ',', '.');
$meta[1] = number_format($meta[1], 2, ',', '.');
$contribuicoes[1] = number_format($contribuicoes[1], 0, ',', '.');
?>

						<font style="font-family:Verdana; color:orange; font-size:13pt; font-weight:bold;">
							<?=mes_por_extenso($mes).'/'.$ano?><br>
							<progress value="<?=$progresso[1]?>" max="100"></progress> <?=$percentual_arrecadado[1]?>%
<?
						if ($co_perfil_login == '1') {
?>
							<br>
							<font style="font-size:10pt;">
							R$ <?=$arrecadacao[1]?> de R$ <?=$meta[1]?> (<?=$contribuicoes[1]?> contribuições)<br>
							</font>
<?
						}
?>
						</font>
					</td>
				</tr>
			</table>
		</td>
		<td width="1%" height="300" align="center" valign="middle"></td>
		<td width="23%" height="300" align="center" valign="middle">
			<table width="98%" height="300" align="center" valign="middle" cellpadding="2" cellspacing="2" border="0">
				<tr width="100%" height="145" align="center" valign="middle" bgcolor="#EDF2FC">
					<td width="100%" height="100%" align="center" valign="middle" bgcolor="#EDF2FC">
						<fieldset style="border: 3px solid blue; background-color: orange;">
						<br>
						<font style="font-family:Verdana; color:white; font-size:10pt; font-weight:bold;">
							<u><font style="font-size: 11pt;">CAIXA ECONÔMICA</font></u> <br><br>
							Obra Lumen de Evangelização<br>
							19.614.384/0001-60<br><br>
							<font style="font-size:11pt;">
							Agência: 1559 <br>
							Operação: 003 <br>
							Conta: 6781-1
							</font>
						</font>
						<br>
						</fieldset>
					</td>
				</tr>
				<tr width="100%" height="145" align="center" valign="middle" bgcolor="#EDF2FC">
					<td width="100%" height="100%" align="center" valign="middle">
						<fieldset style="border: 3px solid blue; background-color: orange;">
						<br>
						<font style="font-family:Verdana; color:white; font-size:10pt; font-weight:bold;">
							<u><font style="font-size: 11pt;">BANCO DO BRASIL</font></u> <br><br>
							Obra Lumen de Evangelização<br>
							19.614.384/0001-60<br><br>
							<br>
							<font style="font-size:11pt;">
							Agência: 2917-3 <br>
							Conta: 40750-X
							</font>
						</font>
						<br>
						</fieldset>
					</td>		
				</tr>
			</table>
		</td>
	</tr>
</table>
