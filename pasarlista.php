<?php
require_once("core.php");

if (!issuperwhitelisted()) {
	header("Location: index.php");
	exit();
}

if (!isset($_GET["id_cgap"]) || !isset($_GET["datetime"])) {
	header("Location: index.php");
	exit();
}

$id_cgap = (int)$_GET["id_cgap"];
$datetime = $_GET["datetime"];

list($date, $time) = explode("T", $datetime);
list($year, $month, $day) = explode("-", $date);
list($hours, $minutes) = explode(":", $time);
$seconds = "00";

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="retrasos.php">Ausencias y retrasos</a> > <a href="asistencia.php">Asistencia sesión</a> > <a href="verasistencia.php?id_cgap='.$id_cgap.'&datetime='.$datetime.'">Ver</a> > Pasar lista';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Pasar lista – ClickEdu Marks</title>
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
		<form action="grabarlista.php" method="POST">
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
						$assistencia = true;
						$id_assistencia = $alumne["assistencia"][0]["id_assistencia"];
					} else {
						$a = false;
						$r = false;
						$j = false;
						$assistencia = false;
						$id_assistencia = "noid";
					}
					?>
					<tr>
						<td><?=$alumne["id"]?></td>
						<td><?=$alumne["nom"]?></td>
						<td style="text-align: center;"><input type="checkbox" name="assistencia[rbtn_ar_<?=$id_assistencia?>_<?=$alumne["id"]?>]" value="1"<?=($a ? " checked" : '')?>></td>
						<td style="text-align: center;"><input type="checkbox" name="assistencia[rbtn_ar_<?=$id_assistencia?>_<?=$alumne["id"]?>]" value="2"<?=($r ? " checked" : "")?>></td>
						<td style="text-align: center;"><input type="checkbox" name="assistencia[cbtn_just_<?=$id_assistencia?>_<?=$alumne["id"]?>]" value="1"<?=($j ? " checked" : "")?>></td>
					</tr>
					<?php
				}
				?>
				</tbody>
				<input type="hidden" name="data_sessio" value="<?=$year."/".$month."/".$day?>">
				<input type="hidden" name="hora_sessio" value="<?=$hours.$minutes.$seconds?>">
				<input type="hidden" name="id_sessio" value="<?=$json["id_sessio"]?>">
				<input type="hidden" name="id_cgap" value="<?=$id_cgap?>">
				<input type="hidden" name="datetime" value="<?=$datetime?>">
			</table>
			<p><input type="submit" value="Pasar lista"></p>
		</form>
	</body>
</html>