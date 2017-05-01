<?
$ano_referencia = isset($_POST['ano_referencia']) ? $_POST['ano_referencia'] : 'TODOS';
$mes_referencia = isset($_POST['mes_referencia']) ? $_POST['mes_referencia'] : 'TODOS';

$ano_doacao = isset($_POST['ano_doacao']) ? $_POST['ano_doacao'] : date("Y");
$mes_doacao = isset($_POST['mes_doacao']) ? $_POST['mes_doacao'] : 'TODOS';

$vr_oferta_menor = isset($_POST['vr_oferta_menor']) ? $_POST['vr_oferta_menor'] : '';
$vr_oferta_maior = isset($_POST['vr_oferta_maior']) ? $_POST['vr_oferta_maior'] : '';
$tipo_oferta = isset($_POST['tipo_oferta']) ? $_POST['tipo_oferta'] : '';
$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';
$servico = isset($_POST['servico']) ? $_POST['servico'] : '';
$fidelidade = isset($_POST['fidelidade']) ? $_POST['fidelidade'] : '';
?>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">FILTROS DE PESQUISA</font></legend>

	<table width="100%" cellpadding="2" cellspacing="5">
		<tr>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul"><?=utf8_encode('Ano de Referência')?>:</font>
				<select name="ano_referencia">
<?
			if ($ano_referencia == 'TODOS') {
?>
					<option value="TODOS" selected>TODOS
<?
			} else {
?>
					<option value="TODOS">TODOS
<?					
			}
			for ($aa = 2014; $aa <= date("Y")+1; $aa++) {
				if ($ano_referencia == $aa) {
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
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul"><?=utf8_encode('Mês de Referência')?>:</font>
				<select name="mes_referencia">
<?
			if ($mes_referencia == 'TODOS') {
?>
					<option value="TODOS" selected>TODOS
<?
			} else {
?>
					<option value="TODOS">TODOS
<?					
			}
			for ($mm = 1; $mm <= 12; $mm++) {
				if ($mm < 10) {
					$mm = '0'.$mm;
				} else {
					$mm = ''.$mm;
				}
				if ($mes_referencia == $mm) {
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
			</td>
		</tr>
	</table>
	
	<table width="100%" cellpadding="2" cellspacing="5">
		<tr>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul"><?=utf8_encode('Ano da Doação')?>:</font>
				<select name="ano_doacao">
<?
			if ($ano_doacao == 'TODOS') {
?>
					<option value="TODOS" selected>TODOS
<?
			} else {
?>
					<option value="TODOS">TODOS
<?					
			}
			if ($ano_doacao == '') {
				$ano_doacao = date("Y");
			}
			for ($aa = 2014; $aa <= date("Y"); $aa++) {
				if ($ano_doacao == $aa) {
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
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul"><?=utf8_encode('Mês da Doação')?>:</font>
				<select name="mes_doacao">
<?
			if ($mes_doacao == 'TODOS') {
?>
					<option value="TODOS" selected>TODOS
<?
			} else {
?>
					<option value="TODOS">TODOS
<?					
			}
			for ($mm = 1; $mm <= 12; $mm++) {
				if ($mm < 10) {
					$mm = '0'.$mm;
				} else {
					$mm = ''.$mm;
				}
				if ($mes_doacao == $mm) {
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
			</td>
		</tr>
	</table>
	
	<table width="100%" cellpadding="2" cellspacing="5">
		<tr>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul"><?=utf8_encode('Valor da Doação')?>:</font>
				<font class="font10azul">de</font>
				<input type="text" name="vr_oferta_menor" value="<?=$vr_oferta_menor?>" placeholder="valor em reais" size="12" maxlength="12">
				<font class="font10azul">a</font>
				<input type="text" name="vr_oferta_maior" value="<?=$vr_oferta_maior?>" placeholder="valor em reais" size="12" maxlength="12">
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Forma da Oferta:</font>
				<select id="tipo_oferta" name="tipo_oferta" onChange="javascript: como_ofertara();">
					<option value="" selected>TODAS
<?
	$sql = "SELECT * FROM tipos_ofertas ORDER BY co_tipo_oferta;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($tipo_oferta == $campo["co_tipo_oferta"]) {
?>
					<option value="<?=$campo["co_tipo_oferta"]?>" selected><?=utf8_encode($campo["no_tipo_oferta"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_tipo_oferta"]?>"><?=utf8_encode($campo["no_tipo_oferta"])?>
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
	</table>
	
	<table width="100%" cellpadding="2" cellspacing="5">
		<tr>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul"><?=utf8_encode('Grupo')?>:</font>
				<select name="grupo">
					<option value="" selected>TODOS
<?
	$sql = "SELECT * FROM grupos ORDER BY no_grupo;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($grupo == $campo["co_grupo"]) {
?>
					<option value="<?=$campo["co_grupo"]?>" selected><?=utf8_encode($campo["no_grupo"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_grupo"]?>"><?=utf8_encode($campo["no_grupo"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
				</select>
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul"><?=utf8_encode('Serviço')?>:</font>
				<select name="servico">
					<option value="" selected>TODOS
<?
	$sql = "SELECT * FROM servicos ORDER BY no_servico;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($servico == $campo["co_servico"]) {
?>
					<option value="<?=$campo["co_servico"]?>" selected><?=utf8_encode($campo["no_servico"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_servico"]?>"><?=utf8_encode($campo["no_servico"])?>
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
	</table>
	
	<table width="100%" cellpadding="2" cellspacing="5">
		<tr>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Contribuintes:</font>
				<select name="fidelidade">
					<option value="" selected>TODOS
<?
				if ($fidelidade == 'SIM') {
?>
					<option value="SIM" selected>FIDELIDADES (CADASTRADOS)
					<option value="NAO">BENFEITORES (<?=utf8_encode('NÃO')?> CADASTRADOS)
<?
				} else if ($fidelidade == 'NAO') {
?>
					<option value="SIM">FIDELIDADES (CADASTRADOS)
					<option value="NAO" selected>BENFEITORES (<?=utf8_encode('NÃO')?> CADASTRADOS)
<?
				} else {
?>
					<option value="SIM">FIDELIDADES (CADASTRADOS)
					<option value="NAO">BENFEITORES (<?=utf8_encode('NÃO')?> CADASTRADOS)
<?
				}
?>
			</td>
		</tr>
	</table>

</fieldset>

<br>

<?
if ($comando == 'pesquisar') {
	$mm_limite = 12;
	$sql = "SELECT COUNT(DISTINCT P.co_pessoa) AS qtd_cadastros ";
	$sql = $sql."FROM pessoas P ";
	if ($grupo != '') {
		$sql = $sql."LEFT JOIN pessoas_grupos PG ON (P.co_pessoa = PG.co_pessoa) ";
	}
	if ($servico != '') {
		$sql = $sql."LEFT JOIN pessoas_servicos PS ON (P.co_pessoa = PS.co_pessoa) ";
	}
	$sql = $sql."WHERE (TRUE)";
	if ($grupo != '') {
		$sql = $sql." AND (PG.co_grupo = ".$grupo.")";
	}
	if ($servico != '') {
		$sql = $sql." AND (PS.co_servico = ".$servico.")";
	}
	$sql = $sql.";";
	$rs = mysql_query($sql);
	if ($rs) {
		$campo = mysql_fetch_array($rs);
		$cadastros = $campo["qtd_cadastros"];
	}

	$sql = "SELECT COUNT(DISTINCT C.co_pessoa) AS qtd_fidelidades, ";
	$sql = $sql."COUNT(C.co_contribuicao) AS qtd_contribuicoes, SUM(C.vr_contribuicao) AS soma ";
	$sql = $sql."FROM contribuicoes C ";
	if ($grupo != '') {
		$sql = $sql."LEFT JOIN pessoas_grupos PG ON (C.co_pessoa = PG.co_pessoa) ";
	}
	if ($servico != '') {
		$sql = $sql."LEFT JOIN pessoas_servicos PS ON (C.co_pessoa = PS.co_pessoa) ";
	}
	$sql = $sql."WHERE (TRUE)";
	$sql = $sql."  AND (NOT (C.co_pessoa IS NULL)) AND (C.no_contribuinte IS NULL)";
	if ($ano_referencia != 'TODOS') {
		$sql = $sql." AND (C.aa_referencia = '".$ano_referencia."')";
	}
	if ($mes_referencia != 'TODOS') {
		$sql = $sql." AND (C.mm_referencia = '".$mes_referencia."')";
	}
	if ($ano_doacao != 'TODOS') {
		$sql = $sql." AND (EXTRACT(YEAR FROM C.dt_contribuicao) = '".$ano_doacao."')";
		if ($ano_doacao == date("Y")) {
			$mm_limite = date('m');
		}
	}
	if ($mes_doacao != 'TODOS') {
		$sql = $sql." AND (EXTRACT(MONTH FROM C.dt_contribuicao) = '".$mes_doacao."')";
	}
	if ($vr_oferta_menor != '') {
		$sql = $sql." AND (C.vr_contribuicao >= ".$vr_oferta_menor.")";
	}
	if ($vr_oferta_maior != '') {
		$sql = $sql." AND (C.vr_contribuicao <= ".$vr_oferta_maior.")";
	}
	if ($tipo_oferta != '') {
		$sql = $sql." AND (C.co_tipo_oferta = ".$tipo_oferta.")";
	}
	if ($grupo != '') {
		$sql = $sql." AND (PG.co_grupo = ".$grupo.")";
	}
	if ($servico != '') {
		$sql = $sql." AND (PS.co_servico = ".$servico.")";
	}
	$sql = $sql.";";
	$rs = mysql_query($sql);
	if ($rs) {
		$campo = mysql_fetch_array($rs);
		$fidelidades = $campo["qtd_fidelidades"];
		if ($cadastros > 0) {
			$percentual_fidelidades = number_format((($fidelidades / $cadastros) * 100), 2, ',', '.');
			$cadastros = number_format($cadastros, 0, ',', '.');
		}
		$contribuicoes_fidelidades = $campo["qtd_contribuicoes"];
		$soma_contribuicoes_fidelidades = $campo["soma"];
		if ($fidelidades > 0) {
			$media_contribuicoes_fidelidades = ($soma_contribuicoes_fidelidades / $fidelidades);
		}
	}
	
	$sql = "SELECT COUNT(DISTINCT C.no_contribuinte) AS qtd_nao_fidelidades, ";
	$sql = $sql."COUNT(C.co_contribuicao) AS qtd_contribuicoes, SUM(C.vr_contribuicao) AS soma ";
	$sql = $sql."FROM contribuicoes C ";
	if ($grupo != '') {
		$sql = $sql."LEFT JOIN pessoas_grupos PG ON (C.co_pessoa = PG.co_pessoa) ";
	}
	if ($servico != '') {
		$sql = $sql."LEFT JOIN pessoas_servicos PS ON (C.co_pessoa = PS.co_pessoa) ";
	}
	$sql = $sql."WHERE (TRUE)";
	$sql = $sql."  AND (C.co_pessoa IS NULL) AND (NOT (C.no_contribuinte IS NULL))";
	if ($ano_referencia != 'TODOS') {
		$sql = $sql." AND (C.aa_referencia = '".$ano_referencia."')";
	}
	if ($mes_referencia != 'TODOS') {
		$sql = $sql." AND (C.mm_referencia = '".$mes_referencia."')";
	}
	if ($ano_doacao != 'TODOS') {
		$sql = $sql." AND (EXTRACT(YEAR FROM C.dt_contribuicao) = '".$ano_doacao."')";
		if ($ano_doacao == date("Y")) {
			$mm_limite = date('m');
		}
	}
	if ($mes_doacao != 'TODOS') {
		$sql = $sql." AND (EXTRACT(MONTH FROM C.dt_contribuicao) = '".$mes_doacao."')";
	}
	if ($vr_oferta_menor != '') {
		$sql = $sql." AND (C.vr_contribuicao >= ".$vr_oferta_menor.")";
	}
	if ($vr_oferta_maior != '') {
		$sql = $sql." AND (C.vr_contribuicao <= ".$vr_oferta_maior.")";
	}
	if ($grupo != '') {
		$sql = $sql." AND (PG.co_grupo = ".$grupo.")";
	}
	if ($servico != '') {
		$sql = $sql." AND (PS.co_servico = ".$servico.")";
	}
	$sql = $sql.";";
	$rs = mysql_query($sql);
	if ($rs) {
		$campo = mysql_fetch_array($rs);
		$nao_fidelidades = $campo["qtd_nao_fidelidades"];
		$contribuicoes_nao_fidelidades = $campo["qtd_contribuicoes"];
		$soma_contribuicoes_nao_fidelidades = $campo["soma"];
		if ($contribuicoes_nao_fidelidades > 0) {
			$media_contribuicoes_nao_fidelidades = ($soma_contribuicoes_nao_fidelidades / $contribuicoes_nao_fidelidades);
		}
	}
	
	$contribuintes = $fidelidades + $nao_fidelidades;
	$contribuicoes = $contribuicoes_fidelidades + $contribuicoes_nao_fidelidades;
	$soma_contribuicoes = $soma_contribuicoes_fidelidades + $soma_contribuicoes_nao_fidelidades;
	if ($soma_contribuicoes > 0) {
		$percentual_soma_contribuicoes_fidelidades = number_format((($soma_contribuicoes_fidelidades / $soma_contribuicoes) * 100), 2, ',', '.');
		$percentual_soma_contribuicoes_nao_fidelidades = number_format((($soma_contribuicoes_nao_fidelidades / $soma_contribuicoes) * 100), 2, ',', '.');
	}
	if ($contribuicoes > 0) {
		$media_contribuicoes = ($soma_contribuicoes / $contribuicoes);
	}
	
	$fidelidades = number_format($fidelidades, 0, ',', '.');
	$contribuicoes_fidelidades = number_format($contribuicoes_fidelidades, 0, ',', '.');
	$soma_contribuicoes_fidelidades = 'R$ '.number_format($soma_contribuicoes_fidelidades, 2, ',', '.');
	$media_contribuicoes_fidelidades = 'R$ '.number_format($media_contribuicoes_fidelidades, 2, ',', '.');

	$nao_fidelidades = number_format($nao_fidelidades, 0, ',', '.');
	$contribuicoes_nao_fidelidades = number_format($contribuicoes_nao_fidelidades, 0, ',', '.');
	$soma_contribuicoes_nao_fidelidades = 'R$ '.number_format($soma_contribuicoes_nao_fidelidades, 2, ',', '.');
	$media_contribuicoes_nao_fidelidades = 'R$ '.number_format($media_contribuicoes_nao_fidelidades, 2, ',', '.');
		
	$contribuicoes = number_format($contribuicoes, 0, ',', '.');
	$soma_contribuicoes = 'R$ '.number_format($soma_contribuicoes, 2, ',', '.');
	$media_contribuicoes = 'R$ '.number_format($media_contribuicoes, 2, ',', '.');
	
	$sql = "SELECT nome_contribuinte, contribuinte_fidelidade, ultima_contribuicao, ultimo_registro FROM (";
	
	if (($fidelidade == '') || ($fidelidade == 'SIM')) {
		$sql = $sql."(SELECT DISTINCT P.no_pessoa_completo AS nome_contribuinte, 'SIM' AS contribuinte_fidelidade, ";
		$sql = $sql."MAX(C.dt_contribuicao) AS ultima_contribuicao, MAX(C.dt_registro) AS ultimo_registro ";
		$sql = $sql."FROM pessoas P ";
		$sql = $sql."LEFT JOIN contribuicoes C ON (P.co_pessoa = C.co_pessoa) ";
		if ($grupo != '') {
			$sql = $sql."LEFT JOIN pessoas_grupos PG ON (P.co_pessoa = PG.co_pessoa) ";
		}
		if ($servico != '') {
			$sql = $sql."LEFT JOIN pessoas_servicos PS ON (P.co_pessoa = PS.co_pessoa) ";
		}
		$sql = $sql."WHERE ((NOT (P.co_pessoa IS NULL)) AND (C.no_contribuinte IS NULL)) ";
		if ($grupo != '') {
			$sql = $sql."AND (PG.co_grupo = ".$grupo.") ";
		}
		if ($servico != '') {
			$sql = $sql."AND (PS.co_servico = ".$servico.") ";
		}
		$sql = $sql."GROUP BY nome_contribuinte) ";
	}	
	if ($fidelidade == '') {
		$sql = $sql." UNION ALL ";
	}	
	if (($fidelidade == '') || ($fidelidade == 'NAO')) {

	$sql = $sql."(SELECT DISTINCT C.no_contribuinte AS nome_contribuinte, 'NAO' AS contribuinte_fidelidade, ";
		$sql = $sql."MAX(C.dt_contribuicao) AS ultima_contribuicao, MAX(C.dt_registro) AS ultimo_registro ";
		$sql = $sql."FROM contribuicoes C ";
		$sql = $sql."WHERE (C.co_pessoa IS NULL) AND (NOT (C.no_contribuinte IS NULL)) ";
		$sql = $sql."GROUP BY nome_contribuinte) ";
	}
	
	$sql = $sql.") AS AUX ";
	$sql = $sql."GROUP BY nome_contribuinte ";
	if (($mes_referencia != 'TODOS') || ($mes_doacao != 'TODOS')) {
		$sql = $sql."ORDER BY ultima_contribuicao DESC, nome_contribuinte;";
	} else {
		$sql = $sql."ORDER BY nome_contribuinte;";
	}

	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0) {
?>
<fieldset style="width: 850; border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">RESUMO GERAL</font></legend>
	<table width="850" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="150" align="center" valign="middle">CONTRIBUINTES</th>
		<th width="100" align="center" valign="middle">CADASTROS</th>
		<th width="100" align="center" valign="middle">QTD DE CONTRIBUINTES</th>
		<th width="100" align="center" valign="middle">% DE CONTRIBUINTES</th>
		<th width="100" align="center" valign="middle"><?=utf8_encode('QTD DE CONTRIBUIÇÕES')?></th>
		<th width="100" align="center" valign="middle"><?=utf8_encode('SOMA DAS CONTRIBUIÇÕES')?></th>
		<th width="100" align="center" valign="middle"><?=utf8_encode('% DE CONTRIBUÇÕES')?></th>
		<th width="100" align="center" valign="middle"><?=utf8_encode('MÉDIA DAS CONTRIBUÇÕES')?></th>
		
		<tr width="850" class="trbranco">
			<td width="150" align="left" valign="middle">CADASTRADOS</td>
			<td width="100" align="center" valign="middle"><?=$cadastros?></td>
			<td width="100" align="center" valign="middle"><?=$fidelidades?></td>
			<td width="100" align="center" valign="middle"><?=$percentual_fidelidades?> %</td>
			<td width="100" align="center" valign="middle"><?=$contribuicoes_fidelidades?></td>
			<td width="100" align="right" valign="middle"><?=$soma_contribuicoes_fidelidades?></td>
			<td width="100" align="center" valign="middle"><?=$percentual_soma_contribuicoes_fidelidades?> %</td>
			<td width="100" align="right" valign="middle"><?=$media_contribuicoes_fidelidades?></td>
		</tr>
		
		<tr width="850" class="trazul">
			<td width="150" align="left" valign="middle">BENFEITORES</td>
			<td width="100" align="center" valign="middle">-</td>
			<td width="100" align="center" valign="middle"><?=$nao_fidelidades?></td>
			<td width="100" align="center" valign="middle">-</td>
			<td width="100" align="center" valign="middle"><?=$contribuicoes_nao_fidelidades?></td>
			<td width="100" align="right" valign="middle"><?=$soma_contribuicoes_nao_fidelidades?></td>
			<td width="100" align="center" valign="middle"><?=$percentual_soma_contribuicoes_nao_fidelidades?> %</td>
			<td width="100" align="right" valign="middle"><?=$media_contribuicoes_nao_fidelidades?></td>
		</tr>
		
		<tr width="850" class="trbranco">
			<td width="150" align="left" valign="middle">TOTAL</td>
			<td width="100" align="center" valign="middle">-</td>
			<td width="100" align="center" valign="middle"><?=$contribuintes?></td>
			<td width="100" align="center" valign="middle">-</td>
			<td width="100" align="center" valign="middle"><?=$contribuicoes?></td>
			<td width="100" align="right" valign="middle"><?=$soma_contribuicoes?></td>
			<td width="100" align="center" valign="middle">-</td>
			<td width="100" align="right" valign="middle"><?=$media_contribuicoes?></td>
		</tr>
		
	</table>
</fieldset>

<br>

<?
			if (($mes_referencia != 'TODOS') || ($mes_doacao != 'TODOS')) {
?>
<fieldset style="width: 950; border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">CONTRIBUINTES</font></legend>
	<table width="950" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="300" align="center" valign="middle">CONTRIBUINTE</th>
		<th width="100" align="center" valign="middle">FIDELIDADE</th>
		<th width="200" align="center" valign="middle"><?=utf8_encode('TOTAL DAS CONTRIBUIÇÕES')?></th>
		<th width="200" align="center" valign="middle"><?=utf8_encode('ÚLTIMA CONTRIBUIÇÃO')?></th>
		<th width="150" align="center" valign="middle"><?=utf8_encode('DATA DO REGISTRO')?></th>		
<?
			} else {
?>
<fieldset style="width: <?=(500+(75*$mm_limite))?>; border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">CONTRIBUINTES</font></legend>
	<table width="<?=(500+(75*$mm_limite))?>" cellpadding="2" cellspacing="2" style="border: 1px solid #0b3b9d">
		<th width="300" align="center" valign="middle">CONTRIBUINTE</th>
		<th width="100" align="center" valign="middle">FIDELIDADE</th>
<?
				$celula[0][0] = 0;
				$celula[$linhas][13] = 0;
				for ($mm = 1; $mm <= $mm_limite; $mm++) {
					$celula[0][$mm] = 0;
					if ($mm < 10) {
						$mm = '0'.$mm;
					} else {
						$mm = ''.$mm;
					}
?>
		<th width="75" align="center" valign="middle"><?=substr(mes_por_extenso($mm),0, 3)?></th>
<?
				}
?>
		<th width="100" align="center" valign="middle">TOTAL</th>
<?
			}

			$linhas = 1;
			while ($linhas <= mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				$celula[$linhas][0] = $campo["nome_contribuinte"];
				$celula[$linhas][16] = $campo["contribuinte_fidelidade"];
				if ($celula[$linhas][16] == 'SIM') {
					$cor_fidelidade = '#0b3b9d';
				} else {
					$cor_fidelidade = '#000000';
				}
				
				$sql2 = "SELECT SUM(C.vr_contribuicao) AS soma, MAX(dt_contribuicao) AS ultima_contribuicao, ";
				if (($ano_doacao != 'TODOS') || ($mes_doacao != 'TODOS')) {
					$sql2 = $sql2."EXTRACT(YEAR FROM C.dt_contribuicao) AS aa_doacao, EXTRACT(MONTH FROM C.dt_contribuicao) AS mm_doacao ";
				} else {
					$sql2 = $sql2."C.aa_referencia, C.mm_referencia ";
				}
				$sql2 = $sql2."FROM contribuicoes C ";
				$sql2 = $sql2."LEFT JOIN pessoas P ON (C.co_pessoa = P.co_pessoa) ";
				if ($grupo != '') {
					$sql2 = $sql2."LEFT JOIN pessoas_grupos PG ON (C.co_pessoa = PG.co_pessoa) ";
				}
				if ($servico != '') {
					$sql2 = $sql2."LEFT JOIN pessoas_servicos PS ON (C.co_pessoa = PS.co_pessoa) ";
				}
				$sql2 = $sql2."WHERE ((C.no_contribuinte = '".$celula[$linhas][0]."') OR (P.no_pessoa_completo = '".$celula[$linhas][0]."')) ";
				if ($ano_referencia != 'TODOS') {
					$sql2 = $sql2."AND (C.aa_referencia = '".$ano_referencia."') ";
				}
				if ($mes_referencia != 'TODOS') {
					$sql2 = $sql2."AND (C.mm_referencia = '".$mes_referencia."') ";
				}
				if ($ano_doacao != 'TODOS') {
					$sql2 = $sql2."AND (EXTRACT(YEAR FROM C.dt_contribuicao) = '".$ano_doacao."') ";
				}
				if ($mes_doacao != 'TODOS') {
					$sql2 = $sql2."AND (EXTRACT(MONTH FROM C.dt_contribuicao) = '".$mes_doacao."') ";
				}
				if ($vr_oferta_menor != '') {
					$sql2 = $sql2."AND (C.vr_contribuicao >= ".$vr_oferta_menor.") ";
				}
				if ($vr_oferta_maior != '') {
					$sql2 = $sql2."AND (C.vr_contribuicao <= ".$vr_oferta_maior.") ";
				}
				if ($tipo_oferta != '') {
					$sql2 = $sql2."AND (C.co_tipo_oferta = ".$tipo_oferta.") ";
				}
				if ($grupo != '') {
					$sql2 = $sql2."AND (PG.co_grupo = ".$grupo.") ";
				}
				if ($servico != '') {
					$sql2 = $sql2."AND (PS.co_servico = ".$servico.") ";
				}
				if (($ano_doacao != 'TODOS') || ($mes_doacao != 'TODOS')) {
					$sql2 = $sql2."GROUP BY aa_doacao, mm_doacao;";
				} else {
					$sql2 = $sql2."GROUP BY C.aa_referencia, C.mm_referencia;";
				}

				$rs2 = mysql_query($sql2);
				if ($rs2) {
					if (mysql_num_rows($rs2) > 0) {
						$j = 0;
						while ($j < mysql_num_rows($rs2)) {
							$campo2 = mysql_fetch_array($rs2);
							if (($ano_doacao != 'TODOS') || ($mes_doacao != 'TODOS')) {
								$celula[$linhas][intval($campo2["mm_doacao"])] = $celula[$linhas][intval($campo2["mm_doacao"])] + $campo2["soma"];
							} else {
								$celula[$linhas][intval($campo2["mm_referencia"])] = $celula[$linhas][intval($campo2["mm_referencia"])] + $campo2["soma"];
							}							
							$celula[$linhas][13] = $celula[$linhas][13] + $campo2["soma"];
							if (($ano_doacao != 'TODOS') || ($mes_doacao != 'TODOS')) {
								$celula[0][intval($campo2["mm_doacao"])] = $celula[0][intval($campo2["mm_doacao"])] + $campo2["soma"];
							} else {
								$celula[0][intval($campo2["mm_referencia"])] = $celula[0][intval($campo2["mm_referencia"])] + $campo2["soma"];
							}							
							$celula[0][0] = $celula[0][0] + $campo2["soma"];
							$celula[$linhas][14] = $campo["ultima_contribuicao"];
							if ($celula[$linhas][14] != '') {
								$celula[$linhas][14] = substr($celula[$linhas][14], 8, 2).'/'.substr($celula[$linhas][14], 5, 2).'/'.substr($celula[$linhas][14], 0, 4);
							}
							$celula[$linhas][15] = $campo["ultimo_registro"];
							if ($celula[$linhas][15] != '') {
								$celula[$linhas][15] = substr($celula[$linhas][15], 8, 2).'/'.substr($celula[$linhas][15], 5, 2).'/'.substr($celula[$linhas][15], 0, 4);
							}
							$j = $j + 1;
						}
					}
				}
				$linhas = $linhas + 1;
			}
			
			$cor_fundo = "trazul";
			for ($i = 1; $i <= $linhas; $i++) {
				if (($mes_referencia != 'TODOS') || ($mes_doacao != 'TODOS')) {
					if ($mes_doacao != 'TODOS') {
						$mes_referencia = $mes_doacao;
					}					
					if ($celula[$i][intval($mes_referencia)] != '') {
						if ($cor_fundo == "trazul") {
							$cor_fundo = "trbranco";
						} else {
							$cor_fundo = "trazul";
						}
						
						$celula[$i][intval($mes_referencia)] = number_format($celula[$i][intval($mes_referencia)], 2, ',', '.');
						$celula[$i][intval($mes_referencia)] = 'R$ '.$celula[$i][intval($mes_referencia)];
?>	
		<tr width="950" class="<?=$cor_fundo?>">
			<td width="300" align="left" valign="middle"><?=utf8_decode($celula[$i][0])?></td>
			<td width="100" align="center" valign="middle"><font color="<?=$cor_fidelidade?>"><?=$celula[$i][16]?></font></td>
			<td width="200" align="right" valign="middle"><?=$celula[$i][intval($mes_referencia)]?></td>
			<td width="200" align="center" valign="middle"><?=$celula[$i][14]?></td>
			<td width="150" align="center" valign="middle"><?=$celula[$i][15]?></td>
		</tr>
<?
					}
				} else if ($celula[$i][13] > 0) {
					if ($cor_fundo == "trazul") {
						$cor_fundo = "trbranco";
					} else {
						$cor_fundo = "trazul";
					}
?>
		<tr width="<?=(500+(75*$mm_limite))?>" class="<?=$cor_fundo?>">
			<td width="300" align="left" valign="middle"><?=utf8_decode($celula[$i][0])?></td>
			<td width="100" align="center" valign="middle"><font color="<?=$cor_fidelidade?>"><?=$celula[$i][16]?></font></td>
<?
					for ($mm = 1; $mm <= $mm_limite; $mm++) {
						if ($celula[$i][$mm] != '') {
							$celula[$i][$mm] = number_format($celula[$i][$mm], 2, ',', '.');
						}
?>
			<td width="75" align="right" valign="middle"><?=$celula[$i][$mm]?></td>
<?
					}
					if ($celula[$i][13] > 0) {
						$celula[$i][13] = number_format($celula[$i][13], 2, ',', '.');
						$celula[$i][13] = 'R$ '.$celula[$i][13];
					} else {
						$celula[$i][13] = '';
					}
?>
			<td width="100" align="right" valign="middle"><?=$celula[$i][13]?></td>
		</tr>
<?
				}
			}
			
			if (($mes_referencia == 'TODOS') && ($mes_doacao == 'TODOS')) {
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
		<tr width="<?=(500+(75*$mm_limite))?>" class="<?=$cor_fundo?>">
			<td width="400" colspan="2" align="center" valign="middle"><b>TOTAL GERAL</b></td>
<?
				for ($mm = 1; $mm <= $mm_limite; $mm++) {
					$celula[0][$mm] = number_format($celula[0][$mm], 2, ',', '.');
?>
			<td width="75" align="right" valign="middle"><b><?=$celula[0][$mm]?></b></td>
<?
				}
				$celula[0][0] = number_format($celula[0][0], 2, ',', '.');
				$celula[0][0] = 'R$ '.$celula[0][0];
?>
			<td width="100" align="right" valign="middle"><b><?=$celula[0][0]?></b></td>
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