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
	</body>
</html>