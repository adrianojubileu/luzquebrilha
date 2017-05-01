<?
require('config.php');
include('../includes/funcoes.php');
include 'login.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="iso-8859-1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?=$titulo_topo?></title>
  	<link href="../includes/bootstrap3.css" rel="stylesheet">
  	<link href="../includes/style.css" rel="stylesheet">
</head>
<body>

<form class="form-inline">

	<nav class="navbar navbar-faded">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="#" class="navbar-brand">
					Obra Lumen de Evengelização
				</a>
			</div>
			<div id="login">
      			<div class="nav navbar-nav navbar-form navbar-right">
<?
				if ($ic_login != 'sim') {
?>
					Login: <input type="text" id="no_login" class="form-control" placeholder="E-mail ou Celular ou CPF ou CNPJ" size="28" />
					Senha: <input type="password" id="no_senha" class="form-control" placeholder="Senha" size="12" maxlength="15" />
					<button class="btn btn-outline-success" id="botao_entrar" onClick="logon();">entrar</button>
					<button class="btn btn-outline-success" id="botao_cadastre_se" onClick="abrir(form,1,'cadastro.php','co_pessoa_login=&co_pessoa=');">cadastre-se</button>
					<button class="btn btn-outline-success" id="botao_esqueci_minha_senha" onClick="email_enviar_senha();">esqueci minha senha</button>
<?
				} elseif ($ic_login == 'sim') {
?>
					Olá, <?=utf8_decode($no_pessoa_login)?>!
					<button id="botao_meu_cadastro" onClick="abrir(form,1,'cadastro.php','co_pessoa_login=<?=$co_pessoa_login?>&co_pessoa=<?=$co_pessoa_login?>');">meu cadastro</button>
					<button id="botao_sair" onClick="logoff();">sair</button>
<?
				}
?>
      			</div>
    		</div>
    		<div id="fachada">
				<div class="row">
					<div class="col-md-11 col-sm-11 col-xs-12">
						<img src="../imagens/lumen_home_2.png" style="height: 115px; width: 100%" class="d-inline-block align-center align-middle">
					</div>
					<div class="col-md-1 col-sm-1 col-xs-12">
						<img src="../imagens/luz_que_brilha_3.jpg" style="height: 115px; width: 100%" class="d-inline-block align-center align-middle">
					</div>
				</div>
			</div>
			<div id="menu">
      			<ul class="nav navbar-nav navbar-middle navbar-left">
        			<li><a href="#">Principal</a></li>
        			<li class="dropdown">
          				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Cadastros <span class="caret"></span></a>
          				<ul class="dropdown-menu">
            				<li><a href="#">Meu Cadastro</a></li>
            				<li><a href="#">Cadastro Geral</a></li>
          				</ul>
        			</li>
        			<li class="dropdown">
          				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Contribuições <span class="caret"></span></a>
          				<ul class="dropdown-menu">
            				<li><a href="#">Minhas Contribuições</a></li>
            				<li><a href="#">Contribuições Gerais</a></li>
            				<li><a href="#">Doar com PagSeguro</a></li>
          				</ul>
        			</li>
        			<li class="dropdown">
          				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Boletos <span class="caret"></span></a>
          				<ul class="dropdown-menu">
            				<li><a href="#">Meus Boletos</a></li>
            				<li><a href="#">Boletos Gerais</a></li>
            				<li><a href="#">Boleto Online</a></li>
          				</ul>
        			</li>
        			<li class="dropdown">
          				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Relatórios <span class="caret"></span></a>
          				<ul class="dropdown-menu">
            				<li><a href="#">Acessos ao Sistema</a></li>
            				<li><a href="#">Contribuições</a></li>
          				</ul>
        			</li>
        			<li class="dropdown">
          				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Tabelas <span class="caret"></span></a>
          				<ul class="dropdown-menu">
            				<li><a href="#">Grupos</a></li>
            				<li><a href="#">Retiros</a></li>
            				<li><a href="#">Serviços</a></li>
            				<li><a href="#">Tipos de Estado Civil</a></li>
            				<li><a href="#">Tipos de Funções</a></li>
            				<li><a href="#">Tipos de Ofertas</a></li>
            				<li><a href="#">Tipos dos Envios</a></li>
          				</ul>
        			</li>
        			<li><a href="#">Mensagens por E-mail</a></li>
      			</ul>
      		</div>
			<div id="conteudo">
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
		</div>
	</nav>

	<input type="hidden" id="menu" name="menu" value="<?=$menu?>">
	<input type="hidden" id="pg" name="pg" value="<?=$pg?>">

</form>
	
  	<script src="../includes/jquery.js"></script>
  	<script src="../includes/tether.js"></script>
  	<script src="../includes/bootstrap3.js"></script>

	<script language="javascript">
		function abrir(form, menu, pg, atributos) {
			if (form == '') {
				if (atributos == '') {
					location.href = 'principal_novo.php?menu=' + menu + '&pg=' + pg;
				} else {
					location.href = 'principal_novo.php?menu=' + menu + '&pg=' + pg + '&' + atributos;
				}
			} else if (pg == 'pagseguro') {
				form.action = 'https://pagseguro.uol.com.br/checkout/v2/donation.html';
				form.target = '_blank';
				form.submit();
			} else {
				form.target = '_self';
				if (atributos == '') {
					form.action = 'principal_novo.php?menu=' + menu + '&pg=' + pg;
				} else {
					form.action = 'principal_novo.php?menu=' + menu + '&pg=' + pg + '&' + atributos;
				}
				form.submit();
			}
		}
		function logon () {
			var login = document.getElementById('no_login');
			var senha = document.getElementById('no_senha');
			if (login.value == '') {
				if (senha.value == '') {
					alert('Preencha os campos LOGIN (E-mail ou Celular ou CPF ou CNPJ) e SENHA!');
				} else {
					alert('Preencha o campo LOGIN (E-mail ou Celular ou CPF ou CNPJ)!');
				}
			} else {
				if (senha.value == '') {
					alert('Preencha o campo SENHA!');
				} else {
					abrir(form,0,'','ic_login=logon');
				}
			}
		}
		function logoff () {
			abrir(form,0,'','ic_login=logoff&co_pessoa_login=&co_pessoa=');
		}
		function email_enviar_senha () {
			var login = document.getElementById('no_login');
			if (login.value == '') {
				alert('Preencha o campo LOGIN com o E-MAIL PRINCIPAL cadastrado para receber a SENHA!');
			} else {
				abrir(form,0,'email_enviar_senha.php','co_pessoa_login=&co_pessoa=');
			}
		}
	</script>

<?
Conexao_obralume_lumen::closeConexao($conexao_obralume_lumen);
?>