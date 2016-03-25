<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

$morenav = 'ClickEdu Marks';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Home – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1 style="margin-bottom: 5px;"><span style="vertical-align: middle;">ClickEdu Marks</span> <span class="nyancat"></span></h1>
		<p style="margin-top:0;"><i>'Cause ClickEdu marks you... forever.</i></p>
		<p>Puedes ingresar a las siguientes secciones de esta intranet alternativa:</p>
		<ul>
			<li><a href="materias.php">Ver las notas de las diferentes materias</a></li>
			<li><a href="retrasos.php">Ver asistencia<?php if (iswhitelisted()) { ?> y pasar lista<?php } ?></a></li>
			<?php if (admincaixapropostes()) { ?><li><a href="caixapropostes.php">Ir a la caja de propuestas</a></li><?php } ?>
			<?php if (iswhitelisted("switch")) { ?><li><a href="switchuser.php">Cambiar usuario</a></li><?php } ?>
		</ul>
	</body>
</html>