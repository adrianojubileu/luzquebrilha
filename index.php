<?
require("config.php");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$titulo_topo?></title>
<script>
	function MM_Principal() {
		window.location.href = "principal.php?width=" + window.screen.width + "&height=" + window.screen.height;
	}
</script>
</head>

<body onLoad="MM_Principal();"></body>

</html>