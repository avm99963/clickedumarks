<?php
require_once("core.php");

if (!iswhitelisted("search")) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="search.php">Buscar usarios</a> > Lista de usuarios';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Lista de usuarios – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
		<style>
			.trimestre_detall {
				font-size: 12px;
			}

			.trimestre_detall td, .trimestre_detall th {
				padding: 2px!important;
			}
		</style>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Lista de usuarios</h1>
		<?php
		$usuaris = ws_query("/mail/usuaris");

		if (!isset($usuaris["usuaris"]) || !isset($usuaris["usuaris"]["u"]) || !count($usuaris["usuaris"]["u"])) {
			echo "<p>No hay usuarios</p>";
			exit();
		}
		?>
		<table class="wikitable">
			<thead>
				<th>ID</th><th>Nombre</th><th>Ver</th>
			</thead>
			<tbody>
		<?php
		foreach ($usuaris["usuaris"]["u"] as $id => $usuari) {
			?>
				<tr>
					<td><?=$id?></td><td><?=$usuari?></td><td><a href="user.php?id=<?=urlencode($id)?>">Ver</a></td>
				</tr>
			<?php
		}
		?>
			</tbody>
		</table>
	</body>
</html>