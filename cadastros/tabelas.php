<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_tabela = isset($_GET['co_tabela']) ? $_GET['co_tabela'] : '';
if ($co_tabela == '') {
	$co_tabela = isset($_POST['co_tabela']) ? $_POST['co_tabela'] : '';
}
?>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	Tabelas
</font>

<br><br>

	<table width="100%" cellpadding="2" cellspacing="5">
		<tr align="left">
			<td align="left" valign="middle">
				<font class="font10azul">Tabela:</font>
				<select name="co_tabela" onChange="abrir(form,1,'tabelas.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=&botao=&comando=');">
					<option value="" selected>
<?
	$sql = "SELECT co_tabela, no_tabela, no_tabela_bd FROM tabelas WHERE (ic_sistema = 'LQB') AND (ic_editar = 'S') ORDER BY no_tabela;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_tabela == $campo["co_tabela"]) {
					$no_tabela = $campo["no_tabela"];
					$no_tabela_bd = $campo["no_tabela_bd"];
					$no_pagina = 'tabela_'.$no_tabela_bd.'.php';
?>
					<option value="<?=$campo["co_tabela"]?>" selected><?=utf8_encode($campo["no_tabela"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_tabela"]?>"><?=utf8_encode($campo["no_tabela"])?>
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

<br>

<?
if ($no_pagina != '') {
	include $no_pagina;
}
?>

<br><br><br>

</div>