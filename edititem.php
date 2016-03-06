<?php
require_once("core.php");

if (!issuperwhitelisted()) {
	header("Location: index.php");
	exit();
}

if (!isset($_GET["item_id"]) || !isset($_GET["id_cgap"]) || !isset($_GET["agrupacio"])) {
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

$avaluacio = key($json["items"]); // Esto es en realidad '''avaluacio'''!!!

if (!isset($json["agrupacions"])) {
	header("Location: materias.php");
	exit();
}
if (isset($json["items"][$avaluacio][$agrupacio])) {
	foreach ($json["items"][$avaluacio][$agrupacio] as $pos => $item) {
		if ($item["id"] == $id) {
			$theitem = $item;
			$thepos = $pos;
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

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="materias.php">Materias</a> > <a href="materia.php?id='.$id_cgap.'">'.$materia.'</a> > <a href="item.php?id_cgap='.$id_cgap.'&item_id='.$id.'&agrupacio='.$agrupacio.'">'.$theitem["nom"]."</a> > Editar";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Editar <?=$theitem["nom"]?> – <?=$materia?> – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Editar <?=$theitem["nom"]?> – <?=$materia?></h1>
		<?php
		if (!isset($json2["alumnes"])) {
			?>
			<p>No hay notas que mostrar.</p>
			<?php
		} else {
			if (count($json2["alumnes"])) {
				?>
				<form action="guardaritem.php" method="POST">
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
								<td><input type="number" name="nota[nota_<?=$id?>_<?=$id_tipus?>_<?=$alumne['id']?>]" style="width:50px;" min="0" max="10" step="0.1" value="<?=$alumne["notes"][1]?>"></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
					<!--<input type="hidden" name="id_criteri_text_<?=$avaluacio?>_<?=$id?>" value="<?=$id?>">
					<input type="hidden" name="id_avaluacio" value="<?=$avaluacio?>">
					<input type="hidden" name="id_agrupacio" value="<?=$agrupacio?>">
					<input type="hidden" name="pos_item" value="<?=$thepos?>">-->
					<input type="hidden" name="id_cgap" value="<?=$id_cgap?>">
					<input type="hidden" name="item_id" value="<?=$id?>">
					<input type="hidden" name="agrupacio" value="<?=$agrupacio?>">
					<p><input type="submit" value="Grabar"></p>
				</form>
				<?php
			}
		}
		?>
	</body>
</html>