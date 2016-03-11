<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > Materias';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Materias – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Materias</h1>
		<p>Selecciona la materia para ver tus notas:</p>
		<ul>
			<?php
			foreach ($conf["materias"] as $id => $materia) {
				?>
				<li><a href="materia.php?id=<?=$id?>"><?=$materia?></a></li>
				<?php
			}
			?>
		</ul>
		<p>Si quieres ver las notas de una materia que no está en la lista, introduce el código de materia en el cuadro de texto de debajo:</p>
		<form action="materia.php" method="GET">
			<p><label for="id_cgap">id_cgap:</label> <input type="number" name="id" id="id_cgap" required> <input type="submit" value="Entrar"></p>
		</form>
	</body>
</html>