<?
require("../includes/conexao.php");

$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

$titulo_topo = "Sistema Luz que Brilha - Obra Lumen de Evangelização";

$url_base = "http://www.obralumen.org.br/sistemas/luzquebrilha/";

//header("Content-Type: text/html; charset=utf-8");

$width = isset($_GET['width']) ? $_GET['width'] : (isset($_POST['width']) ? $_POST['width'] : '');

$height = isset($_GET['height']) ? $_GET['height'] : (isset($_POST['height']) ? $_POST['height'] : '');

$menu = isset($_GET['menu']) ? $_GET['menu'] : (isset($_POST['menu']) ? $_POST['menu'] : '');
if ($menu == '') { $menu = 0; }

$pg = isset($_GET['pg']) ? $_GET['pg'] : (isset($_POST['pg']) ? $_POST['pg'] : '');
if ($pg == '') { $pg = 'inicial.php'; }
?>