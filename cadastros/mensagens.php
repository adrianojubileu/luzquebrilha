<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';

if (($comando == 'excluir') && ($co_pessoa != '')) {
	$sql = "UPDATE pessoas SET ic_cadastro = 'I', ic_fidelidade = 'NAO' WHERE (co_pessoa = ".$co_pessoa.");";
	$rs = mysql_query($sql);
	if ($rs) {
		$co_pessoa = $co_pessoa_login;
		?>
		<script>window.alert('Cadastro inativado com sucesso!');</script>
		<input type="hidden" id="co_pessoa" name="co_pessoa" value="<?=$co_pessoa?>">
		<?		
	}
}

$botao = isset($_GET['botao']) ? $_GET['botao'] : (isset($_POST['botao']) ? $_POST['botao'] : '');

if (($botao != 'todos') && ($botao != 'fidelidades') && ($botao != 'nao_fidelidades')) {
	$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : (isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '');
	if ($pesquisa == '') {
		$dt_cadastro_inicio = isset($_POST['dt_cadastro_inicio']) ? $_POST['dt_cadastro_inicio'] : '';
		$dt_cadastro_fim = isset($_POST['dt_cadastro_fim']) ? $_POST['dt_cadastro_fim'] : '';
		$vr_oferta_menor = isset($_POST['vr_oferta_menor']) ? $_POST['vr_oferta_menor'] : '';
		$vr_oferta_maior = isset($_POST['vr_oferta_maior']) ? $_POST['vr_oferta_maior'] : '';
		$tipo_oferta = isset($_POST['tipo_oferta']) ? $_POST['tipo_oferta'] : '';
		$tipo_envio_boleto = isset($_POST['tipo_envio_boleto']) ? $_POST['tipo_envio_boleto'] : '';
		$tipo_lembranca = isset($_POST['tipo_lembranca']) ? $_POST['tipo_lembranca'] : '';
		$dia_oferta = isset($_POST['dia_oferta']) ? $_POST['dia_oferta'] : '';
		$mes_ultima_contribuicao = isset($_POST['mes_ultima_contribuicao']) ? $_POST['mes_ultima_contribuicao'] : '';
		$mes_aniversario = isset($_POST['mes_aniversario']) ? $_POST['mes_aniversario'] : '';
		$tipo_perfil = isset($_POST['tipo_perfil']) ? $_POST['tipo_perfil'] : '';
		$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';
		$funcao = isset($_POST['funcao']) ? $_POST['funcao'] : '';
		$participa_lumen = isset($_POST['participa_lumen']) ? $_POST['participa_lumen'] : '';
		$fidelidade = isset($_POST['fidelidade']) ? $_POST['fidelidade'] : '';
		$cadastro = isset($_POST['cadastro']) ? $_POST['cadastro'] : 'A';
		$retiro_lumen = isset($_POST['retiro_lumen']) ? $_POST['retiro_lumen'] : '';
		$co_uf = isset($_POST['co_uf']) ? $_POST['co_uf'] : '';
		$no_cidade = isset($_POST['no_cidade']) ? $_POST['no_cidade'] : '';
		$no_bairro = isset($_POST['no_bairro']) ? $_POST['no_bairro'] : '';
		$no_profissao = isset($_POST['no_profissao']) ? $_POST['no_profissao'] : '';
		$co_sexo = isset($_POST['co_sexo']) ? $_POST['co_sexo'] : '';
		$tipo_estado_civil = isset($_POST['tipo_estado_civil']) ? $_POST['tipo_estado_civil'] : '';
		$tipo_religiao = isset($_POST['tipo_religiao']) ? $_POST['tipo_religiao'] : '';
	} else {
		$botao = 'procurar';
	}
} elseif ($botao == 'fidelidades') {
	$botao = 'procurar';
	$fidelidade = 'SIM';
} elseif ($botao == 'nao_fidelidades') {
	$botao = 'procurar';
	$fidelidade = 'NAO';
} else {
	$botao = 'procurar';
}

$ordenador = isset($_POST['ordenador']) ? $_POST['ordenador'] : '';
if ($ordenador == '') { $ordenador = 'no_pessoa_completo'; }
$ordem = isset($_POST['ordem']) ? $_POST['ordem'] : '';
if ($ordem == '') { $ordem = 'ASC'; }

$dados[1][0] = isset($_POST['no_pessoa_completo_on']) ? $_POST['no_pessoa_completo_on'] : false;
$dados[1][1] = 'no_pessoa_completo';
$dados[1][2] = 'NOME COMPLETO';
$dados[1][3] = 'left';
$dados[1][4] = 30;
$dados[2][0] = isset($_POST['no_pessoa_on']) ? $_POST['no_pessoa_on'] : false;
$dados[2][1] = 'no_pessoa';
$dados[2][2] = 'CONHECIDO(A) POR';
$dados[2][3] = 'left';
$dados[2][4] = 15;
$dados[3][0] = isset($_POST['nu_telefone_on']) ? $_POST['nu_telefone_on'] : false;
$dados[3][1] = 'nu_telefone';
$dados[3][2] = 'TELEFONES';
$dados[3][3] = 'center';
$dados[3][4] = 10;
$dados[4][0] = isset($_POST['no_email_on']) ? $_POST['no_email_on'] : false;
$dados[4][1] = 'no_email';
$dados[4][2] = 'E-MAILS';
$dados[4][3] = 'left';
$dados[4][4] = 20;
$dados[5][0] = isset($_POST['dt_aniversario_on']) ? $_POST['dt_aniversario_on'] : false;
$dados[5][1] = 'dt_aniversario';
$dados[5][2] = 'DATA DE NASCIMENTO';
$dados[5][3] = 'center';
$dados[5][4] = 10;
$dados[6][0] = isset($_POST['dt_cadastro_on']) ? $_POST['dt_cadastro_on'] : false;
$dados[6][1] = 'dt_cadastro';
$dados[6][2] = 'DATA DO CADASTRO';
$dados[6][3] = 'center';
$dados[6][4] = 10;
$dados[7][0] = isset($_POST['nu_cpf_cnpj_on']) ? $_POST['nu_cpf_cnpj_on'] : false;
$dados[7][1] = 'nu_cpf_cnpj';
$dados[7][2] = 'CPF/CNPJ';
$dados[7][3] = 'center';
$dados[7][4] = 10;
$dados[8][0] = isset($_POST['vr_oferta_on']) ? $_POST['vr_oferta_on'] : false;
$dados[8][1] = 'vr_oferta';
$dados[8][2] = 'VALOR DA OFERTA';
$dados[8][3] = 'right';
$dados[8][4] = 10;
$dados[9][0] = isset($_POST['dd_oferta_on']) ? $_POST['dd_oferta_on'] : false;
$dados[9][1] = 'dd_oferta';
$dados[9][2] = 'DIA DA OFERTA';
$dados[9][3] = 'center';
$dados[9][4] = 10;
$dados[10][0] = isset($_POST['no_tipo_oferta_on']) ? $_POST['no_tipo_oferta_on'] : false;
$dados[10][1] = 'no_tipo_oferta';
$dados[10][2] = 'FORMA DA OFERTA';
$dados[10][3] = 'center';
$dados[10][4] = 20;
$dados[11][0] = isset($_POST['no_tipo_envio_boleto_on']) ? $_POST['no_tipo_envio_boleto_on'] : false;
$dados[11][1] = 'no_tipo_envio_boleto';
$dados[11][2] = 'FORMA DO ENVIO DO BOLETO';
$dados[11][3] = 'center';
$dados[11][4] = 10;
$dados[12][0] = isset($_POST['no_perfil_on']) ? $_POST['no_perfil_on'] : false;
$dados[12][1] = 'no_perfil';
$dados[12][2] = 'PERFIL NO SISTEMA';
$dados[12][3] = 'center';
$dados[12][4] = 15;
$dados[13][0] = isset($_POST['no_tipo_pessoa_on']) ? $_POST['no_tipo_pessoa_on'] : false;
$dados[13][1] = 'no_tipo_pessoa';
$dados[13][2] = 'TIPO DA PESSOA';
$dados[13][3] = 'center';
$dados[13][4] = 10;
$dados[14][0] = isset($_POST['no_endereco_on']) ? $_POST['no_endereco_on'] : false;
$dados[14][1] = 'no_endereco';
$dados[14][2] = 'ENDEREÇO';
$dados[14][3] = 'left';
$dados[14][4] = 30;
$dados[15][0] = isset($_POST['no_bairro_on']) ? $_POST['no_bairro_on'] : false;
$dados[15][1] = 'no_bairro';
$dados[15][2] = 'BAIRRO';
$dados[15][3] = 'left';
$dados[15][4] = 20;
$dados[16][0] = isset($_POST['no_cidade_on']) ? $_POST['no_cidade_on'] : false;
$dados[16][1] = 'no_cidade';
$dados[16][2] = 'CIDADE';
$dados[16][3] = 'left';
$dados[16][4] = 20;
$dados[17][0] = isset($_POST['co_uf_on']) ? $_POST['co_uf_on'] : false;
$dados[17][1] = 'co_uf';
$dados[17][2] = 'UF';
$dados[17][3] = 'center';
$dados[17][4] = 5;
$dados[18][0] = isset($_POST['nu_cep_on']) ? $_POST['nu_cep_on'] : false;
$dados[18][1] = 'nu_cep';
$dados[18][2] = 'CEP';
$dados[18][3] = 'center';
$dados[18][4] = 10;
$dados[19][0] = isset($_POST['ic_membro_ativo_on']) ? $_POST['ic_membro_ativo_on'] : false;
$dados[19][1] = 'ic_membro_ativo';
$dados[19][2] = 'PARTICIPA DO LUMEN?';
$dados[19][3] = 'center';
$dados[19][4] = 10;
$dados[20][0] = isset($_POST['no_grupo_on']) ? $_POST['no_grupo_on'] : false;
$dados[20][1] = 'no_grupo';
$dados[20][2] = 'GRUPOS/SERVIÇOS';
$dados[20][3] = 'left';
$dados[20][4] = 20;
$dados[21][0] = isset($_POST['no_retiro_on']) ? $_POST['no_retiro_on'] : false;
$dados[21][1] = 'no_retiro';
$dados[21][2] = 'RETIROS';
$dados[21][3] = 'left';
$dados[21][4] = 20;
$dados[22][0] = isset($_POST['dt_boleto_on']) ? $_POST['dt_boleto_on'] : false;
$dados[22][1] = 'dt_boleto';
$dados[22][2] = 'ÚLTIMO BOLETO GERADO';
$dados[22][3] = 'center';
$dados[22][4] = 10;
$dados[23][0] = isset($_POST['dt_contribuicao_on']) ? $_POST['dt_contribuicao_on'] : false;
$dados[23][1] = 'dt_contribuicao';
$dados[23][2] = 'ÚLTIMA CONTRIBUIÇÃO';
$dados[23][3] = 'right';
$dados[23][4] = 10;
$dados[24][0] = isset($_POST['dt_visita_on']) ? $_POST['dt_visita_on'] : false;
$dados[24][1] = 'dt_visita';
$dados[24][2] = 'ÚLTIMA VISITA AO SITE';
$dados[24][3] = 'center';
$dados[24][4] = 10;
$dados[25][0] = isset($_POST['no_facebook_on']) ? $_POST['no_facebook_on'] : false;
$dados[25][1] = 'no_facebook';
$dados[25][2] = 'FACEBOOK';
$dados[25][3] = 'left';
$dados[25][4] = 15;
$dados[26][0] = isset($_POST['no_profissao_on']) ? $_POST['no_profissao_on'] : false;
$dados[26][1] = 'no_profissao';
$dados[26][2] = 'PROFISSÃO';
$dados[26][3] = 'left';
$dados[26][4] = 15;
$dados[27][0] = isset($_POST['co_sexo_on']) ? $_POST['co_sexo_on'] : false;
$dados[27][1] = 'co_sexo';
$dados[27][2] = 'SEXO';
$dados[27][3] = 'center';
$dados[27][4] = 5;
$dados[28][0] = isset($_POST['co_estado_civil_on']) ? $_POST['co_estado_civil_on'] : false;
$dados[28][1] = 'co_estado_civil';
$dados[28][2] = 'ESTADO CIVIL';
$dados[28][3] = 'center';
$dados[28][4] = 10;
$dados[29][0] = isset($_POST['co_religiao_on']) ? $_POST['co_religiao_on'] : false;
$dados[29][1] = 'co_religiao';
$dados[29][2] = 'RELIGIÃO';
$dados[29][3] = 'center';
$dados[29][4] = 10;
$dados[30][0] = isset($_POST['no_funcao_on']) ? $_POST['no_funcao_on'] : false;
$dados[30][1] = 'no_funcao';
$dados[30][2] = 'FUNÇÃO';
$dados[30][3] = 'left';
$dados[30][4] = 20;

$mostra_campos = false;
for ($c = 1; $c <= 30; $c++) {
	if ($dados[$c][0] == true) {
		$mostra_campos = true;
	}
}
if ($mostra_campos == false) {
	$dados[1][0] = true;
	$dados[3][0] = true;
	$dados[8][0] = true;
	$dados[20][0] = true;
	$dados[23][0] = true;
}

$sql = "SELECT COUNT(*) AS cadastrados FROM pessoas;";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$cadastrados = $campo["cadastrados"];
	}
}

$sql = "SELECT COUNT(*) AS contribuintes, SUM(vr_oferta) AS meta FROM pessoas WHERE (NOT (vr_oferta IS NULL));";
$rs = mysql_query($sql);
if ($rs) {
	if (mysql_num_rows($rs) > 0) {
		$campo = mysql_fetch_array($rs);
		$contribuintes = $campo["contribuintes"];
		$meta = $campo["meta"];
	}
}

//echo $ic_login.' - '.$co_pessoa.' - '.$co_pessoa_login.'<br>';
?>

<script language="javascript">
	function gerar_boleto (co_pessoa) {
		abrir(form,3,'boletos_gerais.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=' + co_pessoa);
	}
	function atualizar_pessoa (co_pessoa) {
		abrir(form,1,'cadastro.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=' + co_pessoa);
	}
	function cadastrar_contribuicao (co_pessoa) {
		abrir(form,1,'contribuicoes_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=' + co_pessoa);
	}
	function excluir_pessoa (co_pessoa, no_pessoa) {
		if (confirm('Tem certeza que deseja inativar o cadastro do(a) ' + no_pessoa + '?')) {
			abrir(form,1,'cadastro_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=' + co_pessoa + '&comando=excluir');
		}
	}
	function procurar_pessoa (botao) {
		if (document.forms["form"]["pesquisa"].value == '') {
			window.alert('Favor preencher o campo de busca!');
		} else if ((document.forms["form"]["dt_cadastro_inicio"].value != '') && ((document.forms["form"]["dt_cadastro_inicio"].value.substring(2,3) != '/') || (document.forms["form"]["dt_cadastro_inicio"].value.substring(5,6) != '/') || (document.forms["form"]["dt_cadastro_inicio"].value.length != 10))) {
			window.alert('Favor preencher o campo DATA DE INÍCIO DE CADASTRO neste formato com as barras: DD/MM/AAAA');
		} else if ((document.forms["form"]["dt_cadastro_fim"].value != '') && ((document.forms["form"]["dt_cadastro_fim"].value.substring(2,3) != '/') || (document.forms["form"]["dt_cadastro_fim"].value.substring(5,6) != '/') || (document.forms["form"]["dt_cadastro_fim"].value.length != 10))) {
			window.alert('Favor preencher o campo DATA DE FIM DE CADASTRO neste formato com as barras: DD/MM/AAAA');
		} else if ((document.forms["form"]["dt_cadastro_inicio"].value != '') && ((parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(0,2)) <= 0) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) <= 0) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(6,10)) < 1900) || ((parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 2) && (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(0,2)) > 28)) || (((parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 4) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 6) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 9) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 11)) && (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(0,2)) > 30)) || (((parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 1) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 3) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 5) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 7) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 8) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 10) || (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(3,5)) == 12)) && (parseInt(document.forms["form"]["dt_cadastro_inicio"].value.substring(0,2)) > 31)))) {
			window.alert('Favor preencher o campo DATA DE INÍCIO DE CADASTRO com uma data correta!');
		} else if ((document.forms["form"]["dt_cadastro_fim"].value != '') && ((parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(0,2)) <= 0) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) <= 0) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(6,10)) < 1900) || ((parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 2) && (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(0,2)) > 28)) || (((parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 4) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 6) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 9) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 11)) && (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(0,2)) > 30)) || (((parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 1) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 3) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 5) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 7) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 8) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 10) || (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(3,5)) == 12)) && (parseInt(document.forms["form"]["dt_cadastro_fim"].value.substring(0,2)) > 31)))) {
			window.alert('Favor preencher o campo DATA DE FIM DE CADASTRO com uma data correta!');
		} else {
			abrir(form,1,'cadastro_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=&botao=' + botao);
		}
	}
	function como_ofertara() {
		if ((document.getElementById("tipo_oferta").value != 1) && (document.getElementById("tipo_envio_boleto").value != '')) {
			document.getElementById("tipo_envio_boleto").value = '';
		}
	}
</script>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	Cadastro Geral <br>
</font>

<table width="90%" cellpadding="2" cellspacing="5">
	<tr>
		<td align="left" valign="middle">
			<input type="text" id="pesquisa" name="pesquisa" value="<?=$pesquisa?>" placeholder="quem você procura?" size="50" maxlength="80">
			<input type="button" id="botao" name="botao" value="procurar" class="botao" onClick="procurar_pessoa('<?=$botao?>');">
			<input type="button" id="botao_todos" name="botao_todos" value="todos os <?=$cadastrados?> cadastros" class="botao" onClick="abrir(form,1,'cadastro_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=&botao=todos&pesquisa=');">
			<input type="button" id="botao_novo_cadastro" name="botao_novo_cadastro" value="novo cadastro" class="botao" onClick="abrir(form,1,'cadastro.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=&botao=salvar');">
			<input type="button" id="botao_filtrar" name="botao_filtrar" value="filtrar" class="botao" onClick="abrir(form,1,'cadastro_geral.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=&botao=procurar&pesquisa=');">
		</td>
	</tr>
</table>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">FILTROS DE PESQUISA</font></legend>

	<table width="100%" cellpadding="2" cellspacing="5">
		<tr>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Data do Cadastro:</font>
				<font class="font10azul">de</font>
				<input type="text" name="dt_cadastro_inicio" value="<?=$dt_cadastro_inicio?>" placeholder="___/___/______" size="15" maxlength="10" onkeypress="javascript: return validaData(document.form.dt_cadastro_inicio, window.event);">
				<font class="font10azul">a</font>
				<input type="text" name="dt_cadastro_fim" value="<?=$dt_cadastro_fim?>" placeholder="___/___/______" size="15" maxlength="10" onkeypress="javascript: return validaData(document.form.dt_cadastro_fim, window.event);">
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Valor:</font>
				<font class="font10azul">de</font>
				<input type="text" name="vr_oferta_menor" value="<?=$vr_oferta_menor?>" placeholder="valor em reais" size="12" maxlength="12">
				<font class="font10azul">a</font>
				<input type="text" name="vr_oferta_maior" value="<?=$vr_oferta_maior?>" placeholder="valor em reais" size="12" maxlength="12">
			</td>
		</tr>
	</table>
	
	<table width="100%" cellpadding="2" cellspacing="5">
		<tr>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Dia da Oferta:</font>
				<select name="dia_oferta">
					<option value="" selected>TODOS
<?
			for ($i = 5; $i <= 25; $i = $i + 5) {
				if ($dia_oferta == $i) {
?>
					<option value="<?=$i?>" selected><?=$i?>
<?
				} else {
?>
					<option value="<?=$i?>"><?=$i?>
<?
				}
			}
?>
				</select>
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
				<font class="font10azul">Forma do Envio do Boleto:</font>
				<select id="tipo_envio_boleto" name="tipo_envio_boleto" onChange="javascript: como_ofertara();">
					<option value="" selected>TODAS
<?
	$sql = "SELECT * FROM tipos_envios ORDER BY co_tipo_envio;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($tipo_envio_boleto == $campo["co_tipo_envio"]) {
?>
					<option value="<?=$campo["co_tipo_envio"]?>" selected><?=utf8_encode($campo["no_tipo_envio"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_tipo_envio"]?>"><?=utf8_encode($campo["no_tipo_envio"])?>
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
				<font class="font10azul">Forma de Lembrança:</font>
				<select id="tipo_lembranca" name="tipo_lembranca">
					<option value="" selected>TODAS
<?
	$sql = "SELECT * FROM tipos_lembrancas ORDER BY no_tipo_lembranca;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($tipo_lembranca == $campo["co_tipo_lembranca"]) {
?>
					<option value="<?=$campo["co_tipo_lembranca"]?>" selected><?=utf8_encode($campo["no_tipo_lembranca"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_tipo_lembranca"]?>"><?=utf8_encode($campo["no_tipo_lembranca"])?>
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
				<font class="font10azul">Participa do Lumen como:</font>
				<select name="participa_lumen">
					<option value="" selected>TODOS
<?
				if ($participa_lumen == 'SIM') {
?>
					<option value="SIM" selected>MEMBRO ATIVO
					<option value="NAO">BENFEITOR (A)
<?
				} else if ($participa_lumen == 'NAO') {
?>
					<option value="SIM">MEMBRO ATIVO
					<option value="NAO" selected>BENFEITOR (A)
<?
				} else {
?>
					<option value="SIM">MEMBRO ATIVO
					<option value="NAO">BENFEITOR (A)
<?
				}
?>
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Grupo/Serviço:</font>
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
		</tr>
	</table>
	
	<table width="100%" cellpadding="2" cellspacing="5">
		<tr>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Retiro:</font>
				<select name="retiro_lumen">
					<option value="" selected>TODOS
<?
	$sql = "SELECT * FROM retiros ORDER BY no_retiro;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($retiro_lumen == $campo["co_retiro"]) {
?>
					<option value="<?=$campo["co_retiro"]?>" selected><?=utf8_encode($campo["no_retiro"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_retiro"]?>"><?=utf8_encode($campo["no_retiro"])?>
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
				<font class="font10azul">Função no Grupo/Serviço:</font>
				<select name="funcao">
					<option value="" selected>TODAS
<?
	$sql = "SELECT * FROM tipos_funcoes ORDER BY no_funcao;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($funcao == $campo["co_funcao"]) {
?>
					<option value="<?=$campo["co_funcao"]?>" selected><?=utf8_encode($campo["no_funcao"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_funcao"]?>"><?=utf8_encode($campo["no_funcao"])?>
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
				<font class="font10azul">Contribuintes Fiéis:</font>
				<select name="fidelidade">
					<option value="" selected>TODOS
<?
				if ($fidelidade == 'SIM') {
?>
					<option value="SIM" selected>SIM
					<option value="NAO">NÃO
<?
				} else if ($fidelidade == 'NAO') {
?>
					<option value="SIM">SIM
					<option value="NAO" selected>NÃO
<?
				} else {
?>
					<option value="SIM">SIM
					<option value="NAO">NÃO
<?
				}
?>
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Última Contribuição:</font>
				<select name="mes_ultima_contribuicao">
					<option value="" selected>TODOS OS MESES
<?
			if ($mes_ultima_contribuicao == '00') {
?>
				<option value="00" selected>INADIMPLENTES
<?
			} else {
?>
				<option value="00">INADIMPLENTES
<?			
			}
			$mm_atual = date('m');
			$aa_atual = date('Y');
			for ($mm = 1; $mm <= 12; $mm++) {
				if ($mm < 10) {
					$mm = '0'.$mm;
				} else {
					$mm = ''.$mm;
				}
				if ($mm <= $mm_atual) {
					$mm_option = mes_por_extenso($mm).'/'.$aa_atual;
				} else {
					$mm_option = mes_por_extenso($mm).'/'.($aa_atual - 1);
				}
				if ($mes_ultima_contribuicao == $mm) {
?>
					<option value="<?=$mm?>" selected><?=$mm_option?>
<?
				} else {
?>
					<option value="<?=$mm?>"><?=$mm_option?>
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
				<font class="font10azul">Aniversariantes:</font>
				<select name="mes_aniversario">
					<option value="" selected>TODOS OS MESES
<?
			for ($mm = 1; $mm <= 12; $mm++) {
				if ($mm < 10) {
					$mm = '0'.$mm;
				} else {
					$mm = ''.$mm;
				}
				if ($mes_aniversario == $mm) {
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
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Cadastros:</font>
				<select name="cadastro">
<!--					<option value="" selected>TODOS -->
<?
			$cad[0][0] = 'A';
			$cad[0][1] = 'ATIVOS';
			$cad[1][0] = 'I';
			$cad[1][1] = 'INATIVOS';
			$cadastros = 2;
			for ($i = 0; $i < $cadastros; $i++) {
				if ($cadastro == $cad[$i][0]) {
?>
					<option value="<?=$cad[$i][0]?>" selected><?=$cad[$i][1]?>
<?
				} else {
?>
					<option value="<?=$cad[$i][0]?>"><?=$cad[$i][1]?>
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
				<font class="font10azul">Estado:</font>
				<select name="co_uf">
					<option value="" selected>TODAS
<?
	$sql = "SELECT DISTINCT co_uf FROM pessoas_enderecos WHERE (NOT (co_uf IS NULL)) AND (co_uf != '') ORDER BY co_uf;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_uf == $campo["co_uf"]) {
?>
					<option value="<?=$campo["co_uf"]?>" selected><?=$campo["co_uf"]?>
<?
				} else {
?>
					<option value="<?=$campo["co_uf"]?>"><?=$campo["co_uf"]?>
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
				<font class="font10azul">Cidade:</font>
				<select name="no_cidade">
					<option value="" selected>TODAS
<?
	$sql = "SELECT DISTINCT no_cidade FROM pessoas_enderecos ";
	$sql = $sql."WHERE (TRUE) AND (NOT (no_cidade IS NULL)) AND (no_cidade != '') ";
	if ($co_uf != '') {
		$sql = $sql."AND (co_uf = '".$co_uf."') ";
	}
	$sql = $sql."ORDER BY no_cidade;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($no_cidade == $campo["no_cidade"]) {
?>
					<option value="<?=$campo["no_cidade"]?>" selected><?=$campo["no_cidade"]?>
<?
				} else {
?>
					<option value="<?=$campo["no_cidade"]?>"><?=$campo["no_cidade"]?>
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
				<font class="font10azul">Bairro:</font>
				<select name="no_bairro">
					<option value="" selected>TODOS
<?
	$sql = "SELECT DISTINCT no_bairro FROM pessoas_enderecos ";
	$sql = $sql."WHERE (TRUE) AND (NOT (no_bairro IS NULL)) AND (no_bairro != '') ";
	if ($co_uf != '') {
		$sql = $sql."AND (co_uf = '".$co_uf."') ";
	}
	if ($no_cidade != '') {
		$sql = $sql."AND (no_cidade = '".$no_cidade."') ";
	}
	$sql = $sql."ORDER BY no_bairro;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($no_bairro == $campo["no_bairro"]) {
?>
					<option value="<?=$campo["no_bairro"]?>" selected><?=$campo["no_bairro"]?>
<?
				} else {
?>
					<option value="<?=$campo["no_bairro"]?>"><?=$campo["no_bairro"]?>
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
				<font class="font10azul">Profissão:</font>
				<select name="no_profissao">
					<option value="" selected>TODAS
<?
	$sql = "SELECT DISTINCT no_profissao FROM pessoas WHERE (NOT (no_profissao IS NULL)) AND (no_profissao != '') ORDER BY no_profissao;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($no_profissao == $campo["no_profissao"]) {
?>
					<option value="<?=$campo["no_profissao"]?>" selected><?=$campo["no_profissao"]?>
<?
				} else {
?>
					<option value="<?=$campo["no_profissao"]?>"><?=$campo["no_profissao"]?>
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
				<font class="font10azul">Sexo:</font>
				<select name="co_sexo">
					<option value="" selected>TODOS
<?
			$sexo[0][0] = 'M';
			$sexo[0][1] = 'MASCULINO';
			$sexo[1][0] = 'F';
			$sexo[1][1] = 'FEMININO';
			$sexos = 2;
			for ($i = 0; $i < $sexos; $i++) {
				if ($co_sexo == $sexo[$i][0]) {
?>
					<option value="<?=$sexo[$i][0]?>" selected><?=$sexo[$i][1]?>
<?
				} else {
?>
					<option value="<?=$sexo[$i][0]?>"><?=$sexo[$i][1]?>
<?
				}
			}
?>
				</select>
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Estado Civil:</font>
				<select id="tipo_estado_civil" name="tipo_estado_civil">
					<option value="" selected>TODOS
<?
	$sql = "SELECT * FROM tipos_estados_civil WHERE (NOT (no_estado_civil IS NULL)) AND (no_estado_civil != '') ORDER BY co_estado_civil;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($tipo_estado_civil == $campo["co_estado_civil"]) {
?>
					<option value="<?=$campo["co_estado_civil"]?>" selected><?=utf8_encode($campo["no_estado_civil"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_estado_civil"]?>"><?=utf8_encode($campo["no_estado_civil"])?>
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
				<font class="font10azul">Religião:</font>
				<select id="tipo_religiao" name="tipo_religiao">
					<option value="" selected>TODAS
<?
	$sql = "SELECT * FROM tipos_religiao WHERE (NOT (no_religiao IS NULL)) AND (no_religiao != '') ORDER BY co_religiao;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($tipo_religiao == $campo["co_religiao"]) {
?>
					<option value="<?=$campo["co_religiao"]?>" selected><?=utf8_encode($campo["no_religiao"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_religiao"]?>"><?=utf8_encode($campo["no_religiao"])?>
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
				<font class="font10azul">Perfil:</font>
				<select name="tipo_perfil">
					<option value="" selected>TODOS
<?
	$sql = "SELECT * FROM perfis ORDER BY co_perfil;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($tipo_perfil == $campo["co_perfil"]) {
?>
					<option value="<?=$campo["co_perfil"]?>" selected><?=utf8_encode($campo["no_perfil"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_perfil"]?>"><?=utf8_encode($campo["no_perfil"])?>
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
				<font class="font10azul">Ordenar por:</font>
				<select name="ordenador">
<?
			$ord[0][0] = 'no_pessoa_completo';
			$ord[0][1] = 'Nome Completo';
			$ord[1][0] = 'no_pessoa';
			$ord[1][1] = 'Conhecido (a) por';
			$ord[2][0] = 'dt_cadastro';
			$ord[2][1] = 'Data de Cadastro';
			$ord[3][0] = 'dt_nascimento';
			$ord[3][1] = 'Data de Nascimento';
			$ord[4][0] = 'dd_oferta';
			$ord[4][1] = 'Dia da Oferta';
			$ord[5][0] = 'vr_oferta';
			$ord[5][1] = 'Valor da Oferta';
			$ords = 6;
			for ($i = 0; $i < $ords; $i++) {
				if ($ordenador == $ord[$i][0]) {
?>
					<option value="<?=$ord[$i][0]?>" selected><?=$ord[$i][1]?>
<?
				} else {
?>
					<option value="<?=$ord[$i][0]?>"><?=$ord[$i][1]?>
<?
				}
			}
?>
				</select>
			</td>
			<td width="50%" align="left" valign="middle">
				<font class="font10azul">Ordem:</font>
				<select name="ordem">
<?
			$orde[0][0] = 'DESC';
			$orde[0][1] = 'Decrescente';
			$orde[1][0] = 'ASC';
			$orde[1][1] = 'Ascendente';
			$ordes = 2;
			for ($i = 0; $i < $ordes; $i++) {
				if ($ordem == $orde[$i][0]) {
?>
					<option value="<?=$orde[$i][0]?>" selected><?=$orde[$i][1]?>
<?
				} else {
?>
					<option value="<?=$orde[$i][0]?>"><?=$orde[$i][1]?>
<?
				}
			}
?>
				</select>
			</td>
		</tr>
	</table>
	
</fieldset>

<br>

<fieldset style="border: 1px solid #0b3b9d;">
	<legend><font class="font10azul">DADOS A SEREM EXIBIDOS</font></legend>
	
<table width="100%" cellpadding="2" cellspacing="5">
	<tr>
<?
	$percentual_largura = 25;
	for ($c = 1; $c <= 4; $c++) {
?>
		<td align="left" valign="middle">
<?
		if ($dados[$c][0] == true) {
			$percentual_largura = $percentual_largura + $dados[$c][4];
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on" checked><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		} else {
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on"><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		}
?>
		</td>
<?
	}
?>
	</tr>
	<tr>
<?
	for ($c = 5; $c <= 8; $c++) {
?>
		<td align="left" valign="middle">
<?
		if ($dados[$c][0] == true) {
			$percentual_largura = $percentual_largura + $dados[$c][4];
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on" checked><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		} else {
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on"><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		}
?>
		</td>
<?
	}
?>
	</tr>
	<tr>
<?
	for ($c = 9; $c <= 12; $c++) {
?>
		<td align="left" valign="middle">
<?
		if ($dados[$c][0] == true) {
			$percentual_largura = $percentual_largura + $dados[$c][4];
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on" checked><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		} else {
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on"><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		}
?>
		</td>
<?
	}
?>
	</tr>
	<tr>
<?
	for ($c = 13; $c <= 16; $c++) {
?>
		<td align="left" valign="middle">
<?
		if ($dados[$c][0] == true) {
			$percentual_largura = $percentual_largura + $dados[$c][4];
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on" checked><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		} else {
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on"><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		}
?>
		</td>
<?
	}
?>
	</tr>
	<tr>
<?
	for ($c = 17; $c <= 20; $c++) {
?>
		<td align="left" valign="middle">
<?
		if ($dados[$c][0] == true) {
			$percentual_largura = $percentual_largura + $dados[$c][4];
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on" checked><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		} else {
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on"><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		}
?>
		</td>
<?
	}
?>
	</tr>
	<tr>
<?
	for ($c = 21; $c <= 24; $c++) {
?>
		<td align="left" valign="middle">
<?
		if ($dados[$c][0] == true) {
			$percentual_largura = $percentual_largura + $dados[$c][4];
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on" checked><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		} else {
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on"><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		}
?>
		</td>
<?
	}
?>
	</tr>
	<tr>
<?
	for ($c = 25; $c <= 28; $c++) {
?>
		<td align="left" valign="middle">
<?
		if ($dados[$c][0] == true) {
			$percentual_largura = $percentual_largura + $dados[$c][4];
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on" checked><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		} else {
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on"><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		}
?>
		</td>
<?
	}
?>
	</tr>
	<tr>
<?
	for ($c = 29; $c <= 30; $c++) {
?>
		<td align="left" valign="middle">
<?
		if ($dados[$c][0] == true) {
			$percentual_largura = $percentual_largura + $dados[$c][4];
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on" checked><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		} else {
?>
			<input type="checkbox" name="<?=$dados[$c][1]?>_on"><font class="font10azul"><?=$dados[$c][2]?></font>
<?
		}
?>
		</td>
<?
	}
?>
	</tr>
</table>

</fieldset>

<br>

<?
if (($pesquisa != '') || ($botao == 'procurar')) {
	if ($dt_cadastro_inicio != '') {
		$dt_cadastro_inicio = substr($dt_cadastro_inicio, 6, 4).'-'.substr($dt_cadastro_inicio, 3, 2).'-'.substr($dt_cadastro_inicio, 0, 2);
	}
	if ($dt_cadastro_fim != '') {
		$dt_cadastro_fim = substr($dt_cadastro_fim, 6, 4).'-'.substr($dt_cadastro_fim, 3, 2).'-'.substr($dt_cadastro_fim, 0, 2);
	}
	if ($vr_oferta_menor != '') {
		$vr_oferta_menor = str_replace('.','',$vr_oferta_menor);
		$vr_oferta_menor = str_replace(',','.',$vr_oferta_menor);
	}
	if ($vr_oferta_maior != '') {
		$vr_oferta_maior = str_replace('.','',$vr_oferta_maior);
		$vr_oferta_maior = str_replace(',','.',$vr_oferta_maior);
	}
	
	$sql = "SELECT DISTINCT P.co_pessoa, P.vr_oferta ";
	$sql = $sql." FROM pessoas P ";
	$sql = $sql."LEFT JOIN perfis PER ON (P.co_perfil = PER.co_perfil) ";
	$sql = $sql."LEFT JOIN pessoas_telefones PT ON (P.co_pessoa = PT.co_pessoa) ";
	$sql = $sql."LEFT JOIN pessoas_emails PE ON (P.co_pessoa = PE.co_pessoa) ";
	$sql = $sql."LEFT JOIN pessoas_enderecos PED ON (P.co_pessoa = PED.co_pessoa) ";
	$sql = $sql."LEFT JOIN pessoas_grupos PP ON (P.co_pessoa = PP.co_pessoa) ";
	$sql = $sql."LEFT JOIN pessoas_retiros PR ON (P.co_pessoa = PR.co_pessoa) ";
	$sql = $sql."LEFT JOIN grupos PAR ON (PP.co_grupo = PAR.co_grupo) ";
	$sql = $sql."LEFT JOIN tipos_funcoes TF ON (PP.co_funcao = TF.co_funcao) ";
	$sql = $sql."LEFT JOIN retiros RET ON (PR.co_retiro = RET.co_retiro) ";
	$sql = $sql."LEFT JOIN tipos_ofertas TPO ON (P.co_tipo_oferta = TPO.co_tipo_oferta) ";
	$sql = $sql."LEFT JOIN pessoas_lembrancas PL ON (P.co_pessoa = PL.co_pessoa) ";
	$sql = $sql."WHERE (NOT (P.vr_oferta IS NULL)) ";
	if ($pesquisa != '') {
		$sql = $sql."AND ((upper(sem_acento(P.no_pessoa)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (upper(sem_acento(P.no_pessoa_completo)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (P.nu_cpf_cnpj LIKE '%".$pesquisa."%') ";
		$sql = $sql."   OR (lower(sem_acento(PE.no_email)) LIKE '%".strtolower(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (PT.nu_telefone LIKE '%".$pesquisa."%') ";
		$sql = $sql."   OR (upper(sem_acento(PED.no_endereco)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (upper(sem_acento(PED.no_bairro)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (upper(sem_acento(PED.no_cidade)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (PED.nu_cep LIKE '%".$pesquisa."%') ";
		$sql = $sql."   OR (upper(sem_acento(TPO.no_tipo_oferta)) LIKE '%".strtoupper(sem_acento($pesquisa))."%')) ";
	}
	if ($dt_cadastro_inicio != '') {
		$sql = $sql."AND (P.dt_cadastro >= '".$dt_cadastro_inicio."') ";
	}
	if ($dt_cadastro_fim != '') {
		$sql = $sql."AND (P.dt_cadastro <= '".$dt_cadastro_fim."') ";
	}
	if ($mes_aniversario != '') {
		$sql = $sql."AND (substring(P.dt_nascimento, 6, 2) = '".$mes_aniversario."') ";
	}
	if ($vr_oferta_menor != '') {
		$sql = $sql."AND (P.vr_oferta >= '".$vr_oferta_menor."') ";
	}
	if ($vr_oferta_maior != '') {
		$sql = $sql."AND (P.vr_oferta <= '".$vr_oferta_maior."') ";
	}
	if ($tipo_oferta != '') {
		$sql = $sql."AND (P.co_tipo_oferta = ".$tipo_oferta.") ";
	}
	if ($tipo_envio_boleto != '') {
		$sql = $sql."AND (P.co_tipo_envio_boleto = ".$tipo_envio_boleto.") ";
	}
	if ($tipo_lembranca != '') {
		$sql = $sql."AND (PL.co_tipo_lembranca = ".$tipo_lembranca.") AND (PL.ic_lembranca = 'SIM') ";
	}
	if ($dia_oferta != '') {
		$sql = $sql."AND (P.dd_oferta = ".$dia_oferta.") ";
	}
	if ($tipo_perfil != '') {
		$sql = $sql."AND (P.co_perfil = ".$tipo_perfil.") ";
	}
	if ($participa_lumen != '') {
		$sql = $sql."AND (P.ic_membro_ativo = '".$participa_lumen."') ";
	}
	if ($fidelidade != '') {
		$sql = $sql."AND (P.ic_fidelidade = '".$fidelidade."') ";
	}
	if ($cadastro != '') {
		$sql = $sql."AND (P.ic_cadastro = '".$cadastro."') ";
	}
	if ($grupo != '') {
		$sql = $sql."AND (PP.co_grupo = ".$grupo.") ";
	}
	if ($funcao != '') {
		$sql = $sql."AND (PP.co_funcao = ".$funcao.") ";
	}
	if ($retiro_lumen != '') {
		$sql = $sql."AND (RET.co_retiro = ".$retiro_lumen.") ";
	}
	$rs = mysql_query($sql);
	if ($rs) {
		$fidelidades = 0;
		while ($fidelidades < mysql_num_rows($rs)) {
			$campo = mysql_fetch_array($rs);
			$arrecadacao = $arrecadacao + $campo["vr_oferta"];
			$fidelidades = $fidelidades + 1;
		}
	}
	
	$sql = "SELECT DISTINCT P.*, PER.no_perfil, TPO.no_tipo_oferta, TPEC.no_estado_civil, TPR.no_religiao, TPENV.no_tipo_envio ";
	if ($ordenador == 'dt_nascimento') {
		$sql = $sql.", substring(P.dt_nascimento, 6, 5) AS data_aniversario ";
	}
	$sql = $sql."FROM pessoas P ";
	$sql = $sql."LEFT JOIN perfis PER ON (P.co_perfil = PER.co_perfil) ";
	$sql = $sql."LEFT JOIN pessoas_telefones PT ON (P.co_pessoa = PT.co_pessoa) AND (PT.ic_telefone_principal = 'SIM') ";
	$sql = $sql."LEFT JOIN pessoas_emails PE ON (P.co_pessoa = PE.co_pessoa) AND (PE.ic_email_principal = 'SIM') ";
	$sql = $sql."LEFT JOIN pessoas_enderecos PED ON (P.co_pessoa = PED.co_pessoa) AND (PED.ic_endereco_principal = 'SIM') ";
	$sql = $sql."LEFT JOIN pessoas_grupos PP ON (P.co_pessoa = PP.co_pessoa) ";
	$sql = $sql."LEFT JOIN pessoas_retiros PR ON (P.co_pessoa = PR.co_pessoa) ";
	$sql = $sql."LEFT JOIN grupos PAR ON (PP.co_grupo = PAR.co_grupo) ";
	$sql = $sql."LEFT JOIN tipos_funcoes TF ON (PP.co_funcao = TF.co_funcao) ";
	$sql = $sql."LEFT JOIN contribuicoes CON ON (P.co_pessoa = CON.co_pessoa) ";
	$sql = $sql."LEFT JOIN retiros RET ON (PR.co_retiro = RET.co_retiro) ";
	$sql = $sql."LEFT JOIN tipos_ofertas TPO ON (P.co_tipo_oferta = TPO.co_tipo_oferta) ";
	$sql = $sql."LEFT JOIN tipos_estados_civil TPEC ON (P.co_estado_civil = TPEC.co_estado_civil) ";
	$sql = $sql."LEFT JOIN tipos_religiao TPR ON (P.co_religiao = TPR.co_religiao) ";
	$sql = $sql."LEFT JOIN tipos_envios TPENV ON (P.co_tipo_envio_boleto = TPENV.co_tipo_envio) ";
	$sql = $sql."WHERE (TRUE) ";
	if ($pesquisa != '') {
		$sql = $sql."AND ((upper(sem_acento(P.no_pessoa)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (upper(sem_acento(P.no_pessoa_completo)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (P.nu_cpf_cnpj LIKE '%".$pesquisa."%') ";
		$sql = $sql."   OR (lower(sem_acento(PE.no_email)) LIKE '%".strtolower(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (PT.nu_telefone LIKE '%".$pesquisa."%') ";
		$sql = $sql."   OR (upper(sem_acento(PED.no_endereco)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (upper(sem_acento(PED.no_bairro)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (upper(sem_acento(PED.no_cidade)) LIKE '%".strtoupper(sem_acento($pesquisa))."%') ";
		$sql = $sql."   OR (PED.nu_cep LIKE '%".$pesquisa."%') ";
		$sql = $sql."   OR (upper(sem_acento(TPO.no_tipo_oferta)) LIKE '%".strtoupper(sem_acento($pesquisa))."%')) ";
	}
	if ($dt_cadastro_inicio != '') {
		$sql = $sql."AND (P.dt_cadastro >= '".$dt_cadastro_inicio."') ";
	}
	if ($dt_cadastro_fim != '') {
		$sql = $sql."AND (P.dt_cadastro <= '".$dt_cadastro_fim."') ";
	}
	if ($mes_ultima_contribuicao != '') {
		if ($mes_ultima_contribuicao == '00') {
			$mes_ultima_contribuicao = $mm_atual;
			$ano_ultima_contribuicao = ($aa_atual - 1);
			$sql = $sql."AND ((0 = (SELECT COUNT(*) FROM contribuicoes CON2 WHERE (CON2.co_pessoa = P.co_pessoa))) OR (";
			$sql = $sql."(('".$ano_ultima_contribuicao."') >= (SELECT MAX(CON3.aa_referencia) FROM contribuicoes CON3 WHERE (CON3.co_pessoa = P.co_pessoa))) ";
			$sql = $sql."AND (('".$mes_ultima_contribuicao."') >= (SELECT MAX(CON4.mm_referencia) FROM contribuicoes CON4 WHERE (CON4.co_pessoa = P.co_pessoa) AND (CON4.aa_referencia = '".$ano_ultima_contribuicao."')))";
			$sql = $sql.")) ";
		} else {
			if ($mes_ultima_contribuicao <= $mm_atual) {
				$ano_ultima_contribuicao = $aa_atual;
			} else {
				$ano_ultima_contribuicao = ($aa_atual - 1);
			}
			$sql = $sql."AND (('".$ano_ultima_contribuicao."') = (SELECT MAX(CON5.aa_referencia) FROM contribuicoes CON5 WHERE (CON5.co_pessoa = P.co_pessoa))) ";
			$sql = $sql."AND (('".$mes_ultima_contribuicao."') = (SELECT MAX(CON6.mm_referencia) FROM contribuicoes CON6 WHERE (CON6.co_pessoa = P.co_pessoa) AND (CON6.aa_referencia = '".$ano_ultima_contribuicao."'))) ";
		}
	}
	if ($mes_aniversario != '') {
		$sql = $sql."AND (substring(P.dt_nascimento, 6, 2) = '".$mes_aniversario."') ";
	}
	if ($vr_oferta_menor != '') {
		$sql = $sql."AND (P.vr_oferta >= '".$vr_oferta_menor."') ";
	}
	if ($vr_oferta_maior != '') {
		$sql = $sql."AND (P.vr_oferta <= '".$vr_oferta_maior."') ";
	}	
	if ($tipo_oferta != '') {
		$sql = $sql."AND (P.co_tipo_oferta = ".$tipo_oferta.") ";
	}
	if ($tipo_envio_boleto != '') {
		$sql = $sql."AND (P.co_tipo_envio_boleto = ".$tipo_envio_boleto.") ";
	}
	if ($co_uf != '') {
		$sql = $sql."AND (PED.co_uf = '".$co_uf."') ";
	}
	if ($no_cidade != '') {
		$sql = $sql."AND (PED.no_cidade = '".$no_cidade."') ";
	}
	if ($no_bairro != '') {
		$sql = $sql."AND (PED.no_bairro = '".$no_bairro."') ";
	}
	if ($no_profissao != '') {
		$sql = $sql."AND (P.no_profissao = '".$no_profissao."') ";
	}
	if ($co_sexo != '') {
		$sql = $sql."AND (P.co_sexo = '".$co_sexo."') ";
	}
	if ($tipo_estado_civil != '') {
		$sql = $sql."AND (P.co_estado_civil = '".$tipo_estado_civil."') ";
	}
	if ($tipo_religiao != '') {
		$sql = $sql."AND (P.co_religiao = '".$tipo_religiao."') ";
	}
	if ($dia_oferta != '') {
		$sql = $sql."AND (P.dd_oferta = ".$dia_oferta.") ";
	}
	if ($tipo_perfil != '') {
		$sql = $sql."AND (P.co_perfil = ".$tipo_perfil.") ";
	}
	if ($participa_lumen != '') {
		$sql = $sql."AND (P.ic_membro_ativo = '".$participa_lumen."') ";
	}
	if ($fidelidade != '') {
		$sql = $sql."AND (P.ic_fidelidade = '".$fidelidade."') ";
	}
	if ($cadastro != '') {
		$sql = $sql."AND (P.ic_cadastro = '".$cadastro."') ";
	}
	if ($grupo != '') {
		$sql = $sql."AND (PP.co_grupo = ".$grupo.") ";
	}
	if ($funcao != '') {
		$sql = $sql."AND (PP.co_funcao = ".$funcao.") ";
	}
	if ($retiro_lumen != '') {
		$sql = $sql."AND (RET.co_retiro = ".$retiro_lumen.") ";
	}
	if ($ordenador == 'dt_nascimento') {
		$sql = $sql."ORDER BY data_aniversario ".$ordem.";";
	} else {
		$sql = $sql."ORDER BY ".$ordenador." ".$ordem.";";
	}
	//echo $sql.'<br>';
	$rs = mysql_query($sql);
	if ($rs) {
		$listados = mysql_num_rows($rs);
		if ($listados > 0) {
			$percentual_cadastros = ($listados / $cadastrados) * 100;
			$percentual_cadastros = number_format($percentual_cadastros, 2, ',', '.');
			$percentual_fidelidades = ($fidelidades / $contribuintes) * 100;
			$percentual_fidelidades = number_format($percentual_fidelidades, 2, ',', '.');
			$percentual_arrecadacao = ($arrecadacao / $meta) * 100;
			$percentual_arrecadacao = number_format($percentual_arrecadacao, 2, ',', '.');
			$arrecadacao = number_format($arrecadacao, 2, ',', '.');
			$meta = number_format($meta, 2, ',', '.');
?>

<fieldset style="width: <?=$percentual_largura?>%; border: 1px solid #0b3b9d;">
	<legend>
		<font class="font10azul"><?=$listados?> cadastros = <?=$percentual_cadastros?>% do total</font> ...
		<font class="font10azul">R$ <?=$arrecadacao?> previstos = <?=$percentual_arrecadacao?>% do total - R$ <?=$meta?></font>
	</legend>
	
	<table width="100%" cellpadding="1" cellspacing="1" style="border: 1px solid #0b3b9d">
<?
	if ($co_perfil_login == '1') {
?>
		<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/contribuicao.jpg" style="width:15px; height:15px;"></th>
		<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/boleto.jpg" style="width:15px; height:15px;"></th>
		<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>
		<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;"></th>
<?
	} else {
?>
		<th align="center" valign="middle"><img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;"></th>	
<?
	}
	for ($c = 1; $c <= 30; $c++) {
		if ($dados[$c][0] == true) {
?>
		<th align="center" valign="middle"><?=$dados[$c][2]?></th>
<?
		}
	}
		$cor_fundo = "trazul";
		$i = 0;
			while ($i < $listados) {
				$campo = mysql_fetch_array($rs);
				$codigo_pessoa = $campo["co_pessoa"];
				$colunas[0] = $codigo_pessoa;
				$colunas[1] = utf8_decode(strtoupper(sem_acento($campo["no_pessoa_completo"])));
				$colunas[2] = utf8_decode(strtoupper(sem_acento($campo["no_pessoa"])));
				if ($campo["dt_nascimento"] != '') {
					$colunas[5] = substr($campo["dt_nascimento"], 8, 2).'/'.mes_por_extenso(substr($campo["dt_nascimento"], 5, 2));
				}
				if ($campo["dt_cadastro"] != '') {
					$colunas[6] = substr($campo["dt_cadastro"], 8, 2).'/'.substr($campo["dt_cadastro"], 5, 2).'/'.substr($campo["dt_cadastro"], 0, 4);
				}
				$colunas[7] = trim($campo["nu_cpf_cnpj"]);
				$tipo_pessoa = $campo["co_tipo_pessoa"];
				if ($colunas[7] != '') {
					if ($tipo_pessoa == 'PF') {
						$colunas[7] = substr($colunas[7],0,3).'.'.substr($colunas[7],3,3).'.'.substr($colunas[7],6,3).'-'.substr($colunas[7],9,2);
					}
					if ($tipo_pessoa == 'PJ') {
						$colunas[7] = substr($colunas[7],0,2).'.'.substr($colunas[7],2,3).'.'.substr($colunas[7],5,3).'/'.substr($colunas[7],8,4).'-'.substr($colunas[7],12,2);
					}
				}
				$colunas[8] = $campo["vr_oferta"];
				if ($colunas[8] != '') {
					$colunas[8] = 'R$ '.number_format($colunas[8], 2, ',', '.');
				}
				$colunas[9] = $campo["dd_oferta"];
				$colunas[10] = utf8_encode($campo["no_tipo_oferta"]);
				$colunas[11] = utf8_encode($campo["no_tipo_envio"]);
				$colunas[12] = utf8_encode($campo["no_perfil"]);
				$colunas[13] = $campo["co_tipo_pessoa"];
				$colunas[19] = $campo["ic_membro_ativo"];
				$colunas[25] = utf8_encode($campo["no_facebook"]);
				$colunas[26] = utf8_encode($campo["no_profissao"]);
				$colunas[27] = $campo["co_sexo"];
				$colunas[28] = utf8_encode($campo["no_estado_civil"]);
				$colunas[29] = utf8_encode($campo["no_religiao"]);
				
				$sql2 = "SELECT nu_ddd_telefone, nu_telefone FROM pessoas_telefones WHERE (co_pessoa = ".$codigo_pessoa.") AND (NOT (nu_telefone IS NULL)) AND (nu_telefone != '') ORDER BY co_telefone;";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$regs2 = 0;
					while ($regs2 < mysql_num_rows($rs2)) {
						$campo2 = mysql_fetch_array($rs2);
						if (($campo2["nu_ddd_telefone"] != '') && ($campo2["nu_telefone"] != '')) {
							if ($colunas[3] == '') {
								$colunas[3] = '('.$campo2["nu_ddd_telefone"].')';
								if (strlen($campo2["nu_telefone"]) == 9) {
									$colunas[3] = $colunas[3].substr($campo2["nu_telefone"], 0, 5).'-'.substr($campo2["nu_telefone"], 5);
								} else {
									$colunas[3] = $colunas[3].substr($campo2["nu_telefone"], 0, 4).'-'.substr($campo2["nu_telefone"], 4);
								}
							} else {
								$colunas[3] = $colunas[3].'<br>'.'('.$campo2["nu_ddd_telefone"].')';
								if (strlen($campo2["nu_telefone"]) == 9) {
									$colunas[3] = $colunas[3].substr($campo2["nu_telefone"], 0, 5).'-'.substr($campo2["nu_telefone"], 5);
								} else {
									$colunas[3] = $colunas[3].substr($campo2["nu_telefone"], 0, 4).'-'.substr($campo2["nu_telefone"], 4);
								}
							}
						}
						$regs2 = $regs2 + 1;
					}
				}
				
				$sql2 = "SELECT no_email FROM pessoas_emails WHERE (co_pessoa = ".$codigo_pessoa.") AND (NOT (no_email IS NULL)) AND (no_email != '') ORDER BY co_email;";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$regs2 = 0;
					while ($regs2 < mysql_num_rows($rs2)) {
						$campo2 = mysql_fetch_array($rs2);
						if ($campo2["no_email"] != '') {
							if ($colunas[4] == '') {
								$colunas[4] = $campo2["no_email"];
							} else {
								$colunas[4] = $colunas[4].'<br>'.$campo2["no_email"];
							}
						}
						$regs2 = $regs2 + 1;
					}
				}

				$sql2 = "SELECT PAR.no_grupo, TF.no_funcao ";
				$sql2 = $sql2."FROM pessoas_grupos PP LEFT JOIN grupos PAR ON (PP.co_grupo = PAR.co_grupo) ";
				$sql2 = $sql2."LEFT JOIN tipos_funcoes TF ON (PP.co_funcao = TF.co_funcao) ";
				$sql2 = $sql2."WHERE (PP.co_pessoa = ".$codigo_pessoa.") ORDER BY PAR.no_grupo, TF.no_funcao;";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$regs2 = 0;
					while ($regs2 < mysql_num_rows($rs2)) {
						$campo2 = mysql_fetch_array($rs2);
						if ($campo2["no_grupo"] != '') {
							if ($colunas[20] == '') {
								$colunas[20] = utf8_encode($campo2["no_grupo"]);
								if ($campo2["no_funcao"] != '') {
									$colunas[20] = $colunas[20].' - '.utf8_encode($campo2["no_funcao"]);
								}
							} else {
								$colunas[20] = $colunas[20].'<br>'.utf8_encode($campo2["no_grupo"]);
								if ($campo2["no_funcao"] != '') {
									$colunas[20] = $colunas[20].' - '.utf8_encode($campo2["no_funcao"]);
								}
							}
						}
						$regs2 = $regs2 + 1;
					}
				}

				$sql2 = "SELECT RET.no_retiro ";
				$sql2 = $sql2."FROM pessoas_retiros PR LEFT JOIN retiros RET ON (PR.co_retiro = RET.co_retiro) ";
				$sql2 = $sql2."WHERE (PR.co_pessoa = ".$codigo_pessoa.") ORDER BY RET.no_retiro;";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$regs2 = 0;
					while ($regs2 < mysql_num_rows($rs2)) {
						$campo2 = mysql_fetch_array($rs2);
						if ($campo2["no_retiro"] != '') {
							if ($colunas[21] == '') {
								$colunas[21] = utf8_encode($campo2["no_retiro"]);
							} else {
								$colunas[21] = $colunas[21].'<br>'.utf8_encode($campo2["no_retiro"]);
							}
						}
						$regs2 = $regs2 + 1;
					}
				}

				$sql2 = "SELECT * FROM pessoas_enderecos WHERE (co_pessoa = ".$codigo_pessoa.") ORDER BY co_endereco;";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$regs2 = 0;
					while ($regs2 < mysql_num_rows($rs2)) {
						$campo2 = mysql_fetch_array($rs2);
						if ($campo2["no_endereco"] != '') {
							if ($colunas[14] == '') {
								$colunas[14] = utf8_encode(strtoupper(sem_acento($campo2["no_endereco"])));
								$colunas[15] = utf8_encode(strtoupper(sem_acento($campo2["no_bairro"])));
								$colunas[16] = utf8_encode(strtoupper(sem_acento($campo2["no_cidade"])));
								$colunas[17] = $campo2["co_uf"];
								if ($campo2["nu_cep"] != '') {
									$colunas[18] = substr($campo2["nu_cep"], 0 ,2).'.'.substr($campo2["nu_cep"],2,3).'-'.substr($campo2["nu_cep"],5,3);
								}
							} else {
								$colunas[14] = $colunas[14].'<br>'.utf8_encode(strtoupper(sem_acento($campo2["no_endereco"])));
								$colunas[15] = $colunas[15].'<br>'.utf8_encode(strtoupper(sem_acento($campo2["no_bairro"])));
								$colunas[16] = $colunas[16].'<br>'.utf8_encode(strtoupper(sem_acento($campo2["no_cidade"])));
								$colunas[17] = $colunas[17].'<br>'.$campo2["co_uf"];
								if ($campo2["nu_cep"] != '') {
									$colunas[18] = $colunas[18].'<br>'.substr($campo2["nu_cep"], 0 ,2).'.'.substr($campo2["nu_cep"],2,3).'-'.substr($campo2["nu_cep"],5,3);
								} else {
									$colunas[18] = $colunas[18].'<br>';
								}
							}
						}
						$regs2 = $regs2 + 1;
					}
				}
				
				$sql2 = "SELECT MAX(dt_geracao) AS ultimo_boleto FROM boletos WHERE (co_pessoa_sacado = ".$codigo_pessoa.");";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$regs2 = 0;
					while ($regs2 < mysql_num_rows($rs2)) {
						$campo2 = mysql_fetch_array($rs2);
						if ($campo2["ultimo_boleto"] != '') {
							$colunas[22] = substr($campo2["ultimo_boleto"], 8, 2).'/'.substr($campo2["ultimo_boleto"], 5, 2).'/'.substr($campo2["ultimo_boleto"], 0, 4);
						}
						$regs2 = $regs2 + 1;
					}
				}
				
				$sql2 = "SELECT MAX(aa_referencia) AS ultimo_ano FROM contribuicoes WHERE (co_pessoa = ".$codigo_pessoa.");";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$regs2 = 0;
					while ($regs2 < mysql_num_rows($rs2)) {
						$campo2 = mysql_fetch_array($rs2);
						if ($campo2["ultimo_ano"] != '') {
							$sql3 = "SELECT MAX(mm_referencia) AS ultimo_mes FROM contribuicoes WHERE (co_pessoa = ".$codigo_pessoa.") AND (aa_referencia = '".$campo2["ultimo_ano"]."');";
							$rs3 = mysql_query($sql3);
							if ($rs3) {
								$regs3 = 0;
								while ($regs3 < mysql_num_rows($rs3)) {
									$campo3 = mysql_fetch_array($rs3);
									if ($campo3["ultimo_mes"] != '') {
										$colunas[23] = mes_por_extenso($campo3["ultimo_mes"]).'/'.$campo2["ultimo_ano"];
										$sql4 = "SELECT SUM(vr_contribuicao) AS soma_contribuicoes FROM contribuicoes WHERE (co_pessoa = ".$codigo_pessoa.") AND (aa_referencia = '".$campo2["ultimo_ano"]."') AND (mm_referencia = '".$campo3["ultimo_mes"]."');";
										$rs4 = mysql_query($sql4);
										if ($rs4) {
											$regs4 = 0;
											while ($regs4 < mysql_num_rows($rs4)) {
												$campo4 = mysql_fetch_array($rs4);
												if ($campo4["soma_contribuicoes"] != '') {
													$colunas[23] = 'R$ '.number_format($campo4["soma_contribuicoes"], 2, ',', '.').' - '.$colunas[23];
												}
												$regs4 = $regs4 + 1;
											}
										}
									}
									$regs3 = $regs3 + 1;
								}
							}
						}
						$regs2 = $regs2 + 1;
					}
				}
				
				$sql2 = "SELECT MAX(dt_entrada) AS ultima_visita FROM visitas WHERE (co_pessoa = ".$codigo_pessoa.");";
				$rs2 = mysql_query($sql2);
				if ($rs2) {
					$regs2 = 0;
					while ($regs2 < mysql_num_rows($rs2)) {
						$campo2 = mysql_fetch_array($rs2);
						if ($campo2["ultima_visita"] != '') {
							$colunas[24] = substr($campo2["ultima_visita"], 8, 2).'/'.substr($campo2["ultima_visita"], 5, 2).'/'.substr($campo2["ultima_visita"], 0, 4);
						}
						$regs2 = $regs2 + 1;
					}
				}
				
				$i = $i + 1;
				if ($cor_fundo == "trazul") {
					$cor_fundo = "trbranco";
				} else {
					$cor_fundo = "trazul";
				}
?>	
		<tr class ="<?=$cor_fundo?>">
<?
	if ($co_perfil_login == '1') {
?>
			<td align="center" valign="middle" title="Contribuições">
				<img src="<?=$url_base?>../imagens/contribuicao.jpg" style="width:15px; height:15px;" OnClick="cadastrar_contribuicao(<?=$codigo_pessoa?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
			</td>
			<td align="center" valign="middle" title="Boletos">
				<img src="<?=$url_base?>../imagens/boleto.jpg" style="width:15px; height:15px;" OnClick="gerar_boleto(<?=$codigo_pessoa?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
			</td>
			<td align="center" valign="middle" title="Ver e/ou Atualizar Cadastro">
				<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar_pessoa(<?=$codigo_pessoa?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
			</td>
			<td align="center" valign="middle" title="Inativar Cadastro">
				<img src="<?=$url_base?>../imagens/excluir.jpg" style="width:15px; height:15px;" OnClick="excluir_pessoa(<?=$codigo_pessoa?>,'<?=utf8_decode($nome_pessoa)?>');" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
			</td>
<?
	} else {
?>
			<td align="center" valign="middle" title="Ver e/ou Atualizar Cadastro">
				<img src="<?=$url_base?>../imagens/atualizar.jpg" style="width:15px; height:15px;" OnClick="atualizar_pessoa(<?=$codigo_pessoa?>);" OnMouseOver="this.style.cursor='pointer';" OnMouseOut="this.style.cursor='default';">
			</td>
<?
	}
	for ($c = 1; $c <= 29; $c++) {
		if ($dados[$c][0] == true) {
?>
			<td align="<?=$dados[$c][3]?>" valign="middle"><?=$colunas[$c]?></td>
<?
		}
		$colunas[$c] = '';
		$codigo_pessoa = '';
		$nome_pessoa = '';
	}
?>			
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
			<td align="left" valign="middle">Nenhuma cadastro encontrado para essa pesquisa!</td>
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