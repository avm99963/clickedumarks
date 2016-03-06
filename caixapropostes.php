<?php
require_once("core.php");

if (!admincaixapropostes()) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > Caja de propuestas';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Caja de propuestas – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Caja de propuestas</h1>
		<p>Selecciona la acción que quieres realizar:</p>
		<ul>
			<li><a href="veurecaixapropostes.php">Ver la caja de propuestas</a></li>
			<li><a href="comentar.php">Añadir un mensaje a la caja de propuestas</a></li>
		</ul>
	</body>
</html>