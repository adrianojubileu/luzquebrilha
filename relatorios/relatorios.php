<?
$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$comando = isset($_GET['comando']) ? $_GET['comando'] : '';
$co_relatorio = isset($_GET['co_relatorio']) ? $_GET['co_relatorio'] : (isset($_POST['co_relatorio']) ? $_POST['co_relatorio'] : '');
?>

<div style="width:90%; height:90%; float:center; text-align:left; margin-left:5%; margin-right:5%; padding:10;">

<font style="font-face:Verdana; color:orange; font-size:12pt; font-weight:bold;">
	Relatórios
</font>

<br><br>

	<table width="100%" cellpadding="2" cellspacing="5">
		<tr align="left">
			<td align="left" valign="middle">
				<font class="font10azul">Relatório:</font>
				<select name="co_relatorio" onChange="abrir(form,2,'relatorios.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=&botao=&comando=');">
					<option value="" selected>
<?
	$sql = "SELECT co_relatorio, no_relatorio, no_pagina FROM relatorios ORDER BY no_relatorio;";
	$rs = mysql_query($sql);
	if ($rs) {
		if (mysql_num_rows($rs) > 0)  {
			$regs = 0;
			while ($regs < mysql_num_rows($rs)) {
				$campo = mysql_fetch_array($rs);
				if ($co_relatorio == $campo["co_relatorio"]) {
					$no_pagina = $campo["no_pagina"];
?>
					<option value="<?=$campo["co_relatorio"]?>" selected><?=utf8_encode($campo["no_relatorio"])?>
<?
				} else {
?>
					<option value="<?=$campo["co_relatorio"]?>"><?=utf8_encode($campo["no_relatorio"])?>
<?
				}
				$regs = $regs + 1;
			}
		}
	}
?>
				</select>
<?
			if ($co_relatorio != '') {
?>
				<input type="button" id="botao_gerar_relatorio" name="botao_gerar_relatorio" value="gerar relatório" class="botao" onClick="abrir(form,2,'relatorios.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=&botao=gerar_relatorio&comando=pesquisar');">
<?
			}
?>
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