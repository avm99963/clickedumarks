<?php
require_once("core.php");

if (!iswhitelisted("search")) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > Buscar usuarios';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Buscar usuarios – ClickEdu Marks</title>
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
		<?php
		if (isset($_GET["q"])) {
			$json = ws_query("/teacher/buscar_alumne", "cerca_alumne=".urlencode($_GET["q"]));

			if (isset($json["error"])) {
				echo "Error ".$json["error"].": ".$json["msg"];
			} else {
				?>
				<table class="wikitable">
					<thead>
						<th>ID</th><th>Nombre</th><th>Clase</th><th>Ver</th>
					</thead>
					<tbody>
				<?php
				foreach ($json as $user) {
					?>
						<tr>
							<td><?=$user["id"]?></td><td><?=$user["nom"]?></td><td><?=$user["classe"]?></td><td><a href="user.php?id=<?=urlencode($user["id"])?>">Ver</a></td>
						</tr>
					<?php
				}
				?>
					</tbody>
				</table>
				<?php
			}
			?>
			<hr>
			<?php
		}
		?>
		<h1>Buscar usuarios</h1>
		<form method="GET">
			<p><label for="q">Nombre</label>: <input type="text" name="q" id="q"></p>
			<p><input type="submit" value="Buscar"></p>
		</form>
		<hr></body>
		<ul>
			<li><a href="userlist.php">Lista de usuarios</a></li>
		</ul>
	</body>
</html>