<?php
require_once("core.php");

$morenav = '<a href="home.php">ClickEdu Marks</a> > Caja de propuestas';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Añadir comentario – Caja de propuestas – ClickEdu Marks</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="mdl/material.css">
		<script defer src="mdl/material.min.js"></script>
		<link rel="stylesheet" href="styles.css">
		<script defer src="mdl/getmdl-select.min.js"></script>
		<link rel="stylesheet" href="mdl/getmdl-select.min.css">
		<style>
		body {
			-webkit-tap-highlight-color: rgba(0,0,0,0);
		}
		.card {
			display: block;
			background: white;
			padding: 16px;
			margin: auto;
			max-width: 300px;
		}
		</style>
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Añadir comentario – Caja de propuestas</h1>
		<?php
		if (isset($_GET["msg"])) {
			switch($_GET["msg"]) {
				case "incompleto":
					$msg = "<p style='color: red;'>Por favor, rellena todos los campos.</p>";
					break;
				case "ue":
					$msg = "<p style='color: green;'>Tu mensaje se ha añadido a la caja de propuestas correctamente.</p>";
					break;
			}
			echo $msg;
		}
		?>
		<form action="grabarcomentario.php" method="POST" class="mdl-shadow--2dp card">
			<div class="mdl-selectfield mdl-js-selectfield">
			  <select id="origen" name="origen" class="mdl-selectfield__select">
			   <?php include("comentarnames.php"); ?> 
			  </select>
			  <label class="mdl-selectfield__label" for="origen">Nombre</label>
			</div>
			<br>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" name="asunto" id="asunto" maxlength="150">
				<label class="mdl-textfield__label" for="asunto">Asunto</label>
			</div>
			<br>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<textarea class="mdl-textfield__input" type="text" rows="6" name="mensaje" id="mensaje"></textarea>
				<label class="mdl-textfield__label" for="mensaje">Mensaje</label>
			</div>
			<p><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Enviar</button></p>
		</form>
	</body>
</html>
