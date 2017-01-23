<?php
require_once("core.php");

if (!iswhitelisted("labs")) {
	header("Location: index.php");
	exit();
}

if (isset($_GET["download"]) && $_GET["download"] == "1") {
	function pvalue($value) {
		return substr_replace(",", "\\,", $value);
	}

	header("Content-type: application/octet-stream");
    header("Content-Disposition: filename=\"retrasostats_".date("YmdHis").".csv\"");
    header("Cache-control: private"); //use this to open files directly

    $students = ws_query("/mail/usuaris");

    echo "id,usuari,a,aj,r,rj\n";

    foreach ($students["usuaris"]["u"] as $id => $usuari) {
    	if ($id < 2200) {
    		continue;
    	}

    	$params = ws_query("/student/init_params", "id_alumne=".$id);

    	if (isset($params["avaluacions"])) {
    		echo (int)$id.",".pvalue($usuari).",".(int)$params["resum"]["A"]["absencies"].",".(int)$params["resum"]["A"]["justificades"].",".(int)$params["resum"]["R"]["retards"].",".(int)$params["resum"]["R"]["justificats"]."\n";
    		flush();
    	}

    	if ($id > 2300) {
    		exit();
    	}
    }

    exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="labs.php">Labs</a> > Retrasostats';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Retrasostats – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<script src="jquery/jquery.min.js"></script>
		<script src="selectize/selectize.min.js"></script>
		<link rel="stylesheet" type="text/css" href="selectize/selectize.default.css" />
		<script src="js/query.js"></script>
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Retrasostats</h1>
		<form action="retrasostats.php" method="GET">
			<input type="hidden" name="download" value="1">
			<p>Las Retrasostats no son unas estadísticas cualquiera. Aunque pueda parecer que mida el retraso mental de los alumnos que tienen celebro, no es así. Mide la cantidad de retrasos y ausencias que tienen los alumnos en clase. Así pues, se genera un CSV que después se puede descargar con todas las ausencias y retrasos de todos los alumnos de la escuela.</p>
			<p>Solo un aviso: puede tardar un rato en ejecutarse y consumir muchos recursos, así que paciencia.</p>
			<p><input type="submit" value="Ejecutar y descargar CSV"></p>
		</form>
	</body>
</html>