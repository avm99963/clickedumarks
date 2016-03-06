<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

if (!isset($_GET["id"]) && !isset($_GET["id_cgap"])) {
	header("Location: materias.php");
	exit();
}

$id_cgap = (int)$_GET["id_cgap"];
$id = (int)$_GET["item_id"];
$agrupacio = (int)$_GET["agrupacio"];

if (!array_key_exists($id_cgap, $conf["materias"])) {
	$materia = $id_cgap;
} else {
	$materia = $conf["materias"][$id_cgap];
}

$json = ws_query("/teacher/items_materia", "id_cgap=".urlencode($id_cgap));

$avaluacio = key($json["items"]);

if (!isset($json["agrupacions"])) {
	header("Location: materias.php");
	exit();
}
if (isset($json["items"][$avaluacio][$agrupacio])) {
	foreach ($json["items"][$avaluacio][$agrupacio] as $item) {
		if ($item["id"] == $id) {
			$theitem = $item;
			break;
		}
	}
}

if (!isset($theitem)) {
	header("Location: materias.php");
	exit();
}

$id_tipus = $theitem["id_tipus"];
$tipus = $theitem["tipus"];
$ind_text_associat = $theitem["ind_text_associat"];

$json2 = ws_query("/teacher/item_materia", "id_cgap=".urlencode($id_cgap)."&item[id]=".urlencode($id)."&item[tipus]=".urlencode($tipus)."&item[id_tipus]=".urlencode($id_tipus)."&ind_text_associat=".urlencode($ind_text_associat)."");

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="materias.php">Materias</a> > <a href="materia.php?id='.$id_cgap.'">'.$materia.'</a> > '.$theitem["nom"];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?=$theitem["nom"]?> – <?=$materia?> – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1><?=$theitem["nom"]?> – <?=$materia?></h1>
		<?php
		if (!isset($json2["alumnes"])) {
			?>
			<p>No hay notas que mostrar.</p>
			<?php
		} else {
			$nota = array_search($_SESSION["id_usuari"], array_column($json2["alumnes"], 'id'));
			if ($nota === false) {
				?>
				<p>No estás entre los alumnos de esta clase.</p>
				<?php
			} else {
				if (count($json2["alumnes"][$nota]["notes"]) == 0) {
					?>
					<p>Todavía no se ha introducido tu nota en este ítem.</p>
					<?php
				}
				elseif (empty($json2["alumnes"][$nota]["notes"][1])) {
					?>
					<p>Todavía no se ha introducido tu nota en este ítem (pero hay un identificador definido: <?=$json2["alumnes"][$nota]["notes"][0]?>).</p>
					<?php
				} else {
					?>
					<table class="wikitable">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Nota</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?=$json2["alumnes"][$nota]["id"]?></td>
								<td><?=$json2["alumnes"][$nota]["nom"]?></td>
								<td><?=$json2["alumnes"][$nota]["notes"][1]?></td>
							</tr>
						</tbody>
					</table>
					<?php
					$notas = array_column($json2["alumnes"], "notes");

					$notas = array_map(function($var) {
						return $var[1];
					}, $notas);
					$notas = array_filter($notas);
					rsort($notas);

					$rank = array_search($json2["alumnes"][$nota]["notes"][1], $notas) + 1;
					?>
					<p>Nota media de toda la clase: <?=round(array_sum($notas)/count($notas), 2)?></p>
					<p>Posición: <?=$rank?> de <?=count($notas)?></p>
					<?php
				}
			}
			if (count($json2["alumnes"])) {
				if (iswhitelisted()) {
					?>
					<h3>Toda las notas</h3>
					<table class="wikitable">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Nota</th>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ($json2["alumnes"] as $alumne) {
							?>
							<tr>
								<td><?=$alumne["id"]?></td>
								<td><?=$alumne["nom"]?></td>
								<td><?=$alumne["notes"][1]?></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
					<?php
					if (issuperwhitelisted()) {
						?>
						<ul>
							<li><a href="edititem.php?id_cgap=<?=$id_cgap?>&item_id=<?=$id?>&agrupacio=<?=$agrupacio?>">Editar ítem</a></li>
						</ul>
						<?php
					}
				} else {
					?>
					<h3>Toda las notas</h3>
					<table class="wikitable">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nota</th>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ($notas as $i => $nota) {
							?>
							<tr>
								<td><?=$i+1?></td>
								<td><?=$nota?></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
					<?php
				}
			}
		}
		?>
	</body>
</html>