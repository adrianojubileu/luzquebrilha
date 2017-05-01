<?
require("../includes/conexao.php");

$conexao_obralume_lumen = Conexao_obralume_lumen::getConexao();

function cleanData(&$str) {
    // escape tab characters
    $str = preg_replace("/\t/", "\\t", $str);

    // escape new lines
    $str = preg_replace("/\r?\n/", "\\n", $str);

    // convert 't' and 'f' to boolean values
    if ($str == 't') {
		$str = 'TRUE';
	}
    if ($str == 'f') {
		$str = 'FALSE';
	}
}

// filename for download
$filename = "luzquebrilha_excel_" . date('Ymd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
$sql = "SELECT P.no_pessoa_completo AS nome, PT.nu_telefone AS telefone, PE1.no_email AS email, PE2.no_endereco AS endereco ";
$sql = $sql."FROM pessoas P LEFT JOIN pessoas_telefones PT ON (P.co_pessoa = PT.co_pessoa) AND (PT.ic_telefone_principal = 'SIM') ";
$sql = $sql."LEFT JOIN pessoas_emails PE1 ON (P.co_pessoa = PE1.co_pessoa) AND (PE1.ic_email_principal = 'SIM') ";
$sql = $sql."LEFT JOIN pessoas_enderecos PE2 ON (P.co_pessoa = PE2.co_pessoa) AND (PE2.ic_endereco_principal = 'SIM') ";
$sql = $sql."ORDER BY P.no_pessoa_completo";
$result = mysql_query($sql) or die('Query failed!');
while( false !== ($row = mysql_fetch_assoc($result))) {
	if(!$flag) {
		// display field/column names as first row
		echo implode("\t", array_keys($row)) . "\r\n";
		$flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
}

exit;

Conexao_obralume_lumen::closeConexao($conexao_obralume_lumen);
?>