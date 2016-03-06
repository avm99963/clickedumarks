<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

if (!isset($_GET["id_cgap"]) || !isset($_GET["datetime"]) || empty($_GET["id_cgap"]) || empty($_GET["datetime"])) {
	header("Location: asistencia.php");
	exit();
}

$id_cgap = (int)$_GET["id_cgap"];
$datetime = $_GET["datetime"];

list($date, $time) = explode("T", $datetime);
list($year, $month, $day) = explode("-", $date);
list($hours, $minutes) = explode(":", $time);
$seconds = "00";

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="retrasos.php">Ausencias y retrasos</a> > <a href="asistencia.php">Asistencia sesión</a> > Ver';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ver asistencia sesión – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Ver asistencia sesión</h1>
		<?php
		$sessioid = $year."/".$month."/".$day."_".$hours.$minutes.$seconds;
		$json = ws_query("/teacher/assistencia_sessio", "id_cgap=".urlencode($id_cgap)."&id_sessio=".urlencode($sessioid)."&data_sessio=".urlencode($year."/".$month."/".$day)."&hora_sessio=".urlencode($hours.$minutes.$seconds));

		if ($json["sessio"]["llista"]["revisada"] === false) {
			?>
			<p>Todavía no se ha pasado lista.</p>
			<?php
		} else {
			?>
			<p>Ya se ha pasado lista.</p>
			<?php
		}
		?>
		<ul>
			<li>ID sessio (desc): <?=$sessioid?></li>
			<li>ID sessio (int): <?=$json["id_sessio"]?></li>
		</ul>
		<table class="wikitable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nombre</th>
					<th style="width: 18px;">A</th>
					<th style="width: 18px;">R</th>
					<th style="width: 18px;">J</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($json["sessio"]["llista"]["alumnes"] as $alumne) {
				if (count($alumne["assistencia"])) {
					$a = $alumne["assistencia"][0]["absencia"];
					$r = $alumne["assistencia"][0]["retard"];
					$j = $alumne["assistencia"][0]["justificat"];
				} else {
					$a = false;
					$r = false;
					$j = false;
				}
				?>
				<tr>
					<td><?=$alumne["id"]?></td>
					<td><?=$alumne["nom"]?></td>
					<td style="text-align: center;"><?=($a ? "<img src='img/yes.png'>" : "")?></td>
					<td style="text-align: center;"><?=($r ? "<img src='img/yes.png'>" : "")?></td>
					<td style="text-align: center;"><?=($j ? "<img src='img/yes.png'>" : "")?></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php if (issuperwhitelisted()) { ?>
		<ul>
			<li><a href="pasarlista.php?id_cgap=<?=$id_cgap?>&datetime=<?=$datetime?>">Pasar lista</a></li>
		</ul>
		<?php } ?>
	</body>
</html>