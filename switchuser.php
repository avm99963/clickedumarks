<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

$usuaris = ws_query("/mail/usuaris");

$morenav = '<a href="home.php">ClickEdu Marks</a> > Cambiar usuario';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Cambiar usuario – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<script src="jquery/jquery.min.js"></script>
		<script src="selectize/selectize.min.js"></script>
		<link rel="stylesheet" type="text/css" href="selectize/selectize.default.css" />
		<script src="js/switchuser.js"></script>
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Cambiar usuario</h1>
		<p>Elige el usuario con el cual quieres iniciar sesión:</p>
		<form action="doswitchuser.php" method="POST">
			<p><select name="id" id="userid">
				<?php
				foreach ($usuaris["usuaris"]["u"] as $id => $usuari) {
					?>
					<option value="<?=$id?>"><?=$usuari?></option>
					<?php
				}
				?>
			</select></p>
			<p>Introduce de nuevo tu usuario y contraseña para poder identificarte antes de suplantar otra identidad:</p>
			<p><label for="username">Usuario:</label> <input type="text" id="username" name="username" required></p>
			<p><label for="password">Contraseña:</label> <input type="password" id="password" name="password" required></p>
			<p><input type="submit" value="Cambiar usuario"></p>
		</form>
	</body>
</html>