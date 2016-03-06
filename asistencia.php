<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="retrasos.php">Ausencias y retrasos</a> > Asistencia sesión';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Asistencia sesión – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Asistencia sesión</h1>
		<?php
		$json = ws_query("/student/init_parametres");
		?>
		<p>Introduce los datos de la sesión:</p>
		<form action="verasistencia.php" method="GET">
			<p><label for="id_cgap">Materia:</label> <select id="id_cgap" name="id_cgap">
				<?php
				foreach ($conf["materias"] as $id => $materia) {
					?>
					<option value="<?=$id?>"><?=$materia?></option>
					<?php
				}
				?>
			</select></p>
			<p>Día y hora de la sesión: <label for="datetime"><input type="datetime-local" name="datetime" id="datetime"></label></p>
			<p><input type="submit" value="Ver"></p>
		</form>
	</body>
</html>