<?
require('config.php');
require('email.php');
include('../includes/funcoes.php');
?>

<!-- <!DOCTYPE HTML> -->
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; utf-8" />
<!--	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
	<title><?=$titulo_topo?></title>

	<link rel="stylesheet" type="text/css" href="<?=$url_base?>../includes/imagens.css"></link>
	<link rel="stylesheet" type="text/css" href="<?=$url_base?>../includes/estilos.css"></link>
<!--	<link rel="stylesheet" type="text/css" href="<?=$url_base?>../includes/bootstrap3.css"> -->

	<script type="text/javascript" src="<?=$url_base?>../includes/funcoes.js"></script>
	<script type="text/javascript" src="<?=$url_base?>../includes/jquery.js"></script>
<!--	<script type="text/javascript" src="<?=$url_base?>../includes/tether.js"></script>
		<script type="text/javascript" src="<?=$url_base?>../includes/bootstrap3.js"></script> -->
</head>

<script language="javascript">
	function abrir(form, menu, pg, atributos) {
		if (form == '') {
			if (atributos == '') {
				location.href = 'principal.php?menu=' + menu + '&pg=' + pg + '&width=' + window.screen.width + '&height=' + window.screen.height;
			} else {
				location.href = 'principal.php?menu=' + menu + '&pg=' + pg + '&' + atributos + '&width=' + window.screen.width + '&height=' + window.screen.height;
			}
		} else if (pg == 'pagseguro') {
			form.action = 'https://pagseguro.uol.com.br/checkout/v2/donation.html';
                        form.target = '_blank';
			form.submit();
		} else {
            form.target = '_self';
			if (atributos == '') {
				form.action = 'principal.php?menu=' + menu + '&pg=' + pg;
			} else {
				form.action = 'principal.php?menu=' + menu + '&pg=' + pg + '&' + atributos;
			}
			form.submit();
		}
	}
</script>

<body id="principal" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="overflow: auto; background-color:#EDF2FC;">

<form name="form" action="principal.php" method="POST">

<input type="hidden" id="width" name="width" value="<?=$width?>">
<input type="hidden" id="height" name="height" value="<?=$height?>">

<?
include 'login.php';
?>

<div id="topo" style="width:100%; height:40; top: 0px;">

<?
include 'topo.php';
?>

</div>

<div id="fachada" style="width:100%; height:115; top: 40px;">

<?
include 'fachada.php';
?>

</div>

<div id="opcoes" style="width:100%; height:55; top: 155px;">

<?
include 'menu.php';
?>

</div>

<div id="conteudo" style="width:100%; top: 210px;">

<?
$caminho = '';
if ($pg == '') {
	if ((substr($menu, 0, 1) == '0') || ($menu == '')) {
		$pg = 'inicial.php';
	}
} else {
	$n = 1;
	while ($nivel[$n][1] != '') {
		$caminho = $caminho.$nivel[$n][1].'/';
		$n = $n + 1;
	}
}
$caminho = $caminho.$pg;
if ($caminho != '') {
	include $caminho;
}

?>

</div>

<div id="rodape" style="position:fixed; width:100%; height:40; bottom: 0px;">

<?
include 'rodape.php';
?>

</div>

<input type="hidden" id="menu" name="menu" value="<?=$menu?>">
<input type="hidden" id="pg" name="pg" value="<?=$pg?>">

</form>

</body>
</html>

<?
Conexao_obralume_lumen::closeConexao($conexao_obralume_lumen);
?>