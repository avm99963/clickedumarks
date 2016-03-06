<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

if (!isset($_GET["id"])) {
	header("Location: materias.php");
	exit();
}

$id_cgap = (int)$_GET["id"];

if (!array_key_exists($id_cgap, $conf["materias"])) {
	$materia = $id_cgap;
} else {
	$materia = $conf["materias"][$id_cgap];
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="materias.php">Materias</a> > '.$materia;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?=$materia?> – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1><?=$materia?></h1>
		<?php
		$json = ws_query("/teacher/items_materia", "id_cgap=".urlencode($id_cgap));

		if (isset($json["error"])) {
			?>
			<p>Ha habido un error: <?=$json["msg"]?></p>
			<?php
			exit();
		}

		$items_key = key($json["items"]);
		?>
		<ul>
			<li>Evaluación: <?=htmlspecialchars($json["items"][$items_key]["nom"])?> (<?=($json["items"][$items_key]["tancada"] ? "cerrada" : "abierta")?>)</li>
		</ul>
		<?php
		if (!isset($json["agrupacions"])) {
			?>
			<p>No hay ningún elemento que mostrar para esta materia.</p>
			<?php
		} else {
			foreach ($json["agrupacions"] as $id => $agrupacio) {
				?>
				<h3><?=$agrupacio?></h3>
				<?php
				if (!isset($json["items"][$items_key][$id])) {
					echo "<p>No hay elementos en esta agrupación.</p>";
				} else {
					?>
					<ul>
					<?php
					foreach ($json["items"][$items_key][$id] as $item) {
						?>
						<li><a href="item.php?id_cgap=<?=$id_cgap?>&item_id=<?=$item["id"]?>&agrupacio=<?=$id?>"><?=$item["nom"]?></a></li>
						<?php
					}
					?>
					</ul>
					<?php
				}
			}
		}
		?>
	</body>
</html>