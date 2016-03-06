<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > Ausencias y retrasos';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ausencias y retrasos – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Ausencias y retrasos</h1>
		<?php
		$json = ws_query("/student/init_parametres");
		?>
		<table class="wikitable" style="text-align: center;">
			<thead>
				<tr>
					<th></th><th>1ª evaluación</th><th>2ª evaluación</th><th>3ª evaluación</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>Ausencias no justificadas</th>
					<td><?=$json["resum"]["A"][0]["absencies"]?></td>
					<td><?=$json["resum"]["A"][1]["absencies"]?></td>
					<td><?=$json["resum"]["A"][2]["absencies"]?></td>
				</tr>
				<tr>
					<th>Ausencias justificadas</th>
					<td><?=$json["resum"]["A"][0]["justificades"]?></td>
					<td><?=$json["resum"]["A"][1]["justificades"]?></td>
					<td><?=$json["resum"]["A"][2]["justificades"]?></td>
				</tr>
				<tr>
					<th>Retrasos no justificados</th>
					<td><?=$json["resum"]["R"][0]["retards"]?></td>
					<td><?=$json["resum"]["R"][1]["retards"]?></td>
					<td><?=$json["resum"]["R"][2]["retards"]?></td>
				</tr>
				<tr>
					<th>Retrasos justificados</th>
					<td><?=$json["resum"]["R"][0]["justificats"]?></td>
					<td><?=$json["resum"]["R"][1]["justificats"]?></td>
					<td><?=$json["resum"]["R"][2]["justificats"]?></td>
				</tr>
			</tbody>
		</table>
		<ul>
			<li><a href="asistencia.php">Ver la asistencia a una sesión</a></li>
		</ul>
	</body>
</html>