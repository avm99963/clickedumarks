<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Acceder con token – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<h1>Acceder con token – ClickEdu Marks</h1>
		<p>Introduce los tokens de ClickEdu y el id de usuario aquí debajo para poder acceder a la intranet alternativa ClickEdu Marks:</p>
		<?php
		if (isset($_GET["msg"])) {
			switch($_GET["msg"]) {
				case "empty":
					$msg = "<p style='color: red;'>Por favor, rellena todos los campos.</p>";
					break;
				case "unexpected":
				default:
					$msg = "<p style='color: red;'>Ha habido un error inesperado.</p>";
			}
			echo $msg;
		}
		?>
		<form action="dotokenlogin.php" method="POST">
			<p><label for="id">id:</label> <input type="number" id="id" name="id" required min="0"></p>
			<p><label for="auth_token">auth_token:</label> <input type="text" id="auth_token" name="auth_token" required></p>
			<p><label for="auth_secret">auth_secret:</label> <input type="text" id="auth_secret" name="auth_secret" required></p>
			<p><input type="submit" value="Iniciar sesión"></p>
		</form>
	</body>
</html>