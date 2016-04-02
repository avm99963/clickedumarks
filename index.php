<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<h1>ClickEdu Marks</h1>
		<p>Introduce los datos de inicio de sesión de la Intranet aquí debajo para poder acceder a la intranet alternativa ClickEdu Marks:</p>
		<?php
		if (isset($_GET["msg"])) {
			switch($_GET["msg"]) {
				case "empty":
					$msg = "<p style='color: red;'>Por favor, rellena todos los campos.</p>";
					break;
				case "incorrect":
					$msg = "<p style='color: red;'>Usuario o contraseña incorrecta.</p>";
					break;
				case "notallowed":
					$msg = "<p style='color: red;'>Este usuario no está en la lista blanca.</p>";
					break;
				case "logoutsuccess":
					$msg = "<p style='color: green;'>Has cerrado la sesión correctamente.</p>";
					break;
				case "unexpected":
				default:
					$msg = "<p style='color: red;'>Ha habido un error inesperado.</p>";
			}
			echo $msg;
		}
		?>
		<form action="login.php" method="POST">
			<p><label for="username">Usuario:</label> <input type="text" id="username" name="username" required></p>
			<p><label for="password">Contraseña:</label> <input type="password" id="password" name="password" required></p>
			<p><input type="checkbox" name="switchuser" id="switchuser" value="yes"><label for="switchuser">Iniciar sesión como otro usuario</label></p>
			<p><input type="submit" value="Iniciar sesión"></p>
		</form>
		<hr>
		<p><a href="tokenlogin.php">Acceder con token</a></p>
	</body>
</html>