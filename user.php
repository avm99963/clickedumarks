<?php
require_once("core.php");

if (!iswhitelisted("search")) {
	header("Location: index.php");
	exit();
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
	header("Location: search.php");
	exit();
}

$id = (int)$_GET["id"];

$user = ws_query("/student/init_comunicacio", "id_alumne=".urlencode($id));

if (!count($user["usuari"])) {
	header("Location: search.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="search.php">Buscar usuarios</a> > '.$user["usuari"]["Nombre"].' '.$user["usuari"]["Primer apellido"];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?=$user["usuari"]["Nombre"].' '.$user["usuari"]["Primer apellido"]?> – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
		<style>
			.user th {
				text-align: left!important;
			}
		</style>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1><?=$user["usuari"]["Nombre"]." ".$user["usuari"]["Primer apellido"]." ".$user["usuari"]["Segundo apellido"]?></h1>
		<h3>Usuario</h3>
		<table class="wikitable user">
			<tbody>
				<?php if (isset($user["usuari"]["Nombre"]) && !empty($user["usuari"]["Nombre"])) { ?><tr><th>Nombre</th><td><?=$user["usuari"]["Nombre"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Primer apellido"]) && !empty($user["usuari"]["Primer apellido"])) { ?><tr><th>Primer apellido</th><td><?=$user["usuari"]["Primer apellido"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Segundo apellido"]) && !empty($user["usuari"]["Segundo apellido"])) { ?><tr><th>Segundo apellido</th><td><?=$user["usuari"]["Segundo apellido"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Situación familiar"]) && !empty($user["usuari"]["Situación familiar"])) { ?><tr><th>Situación familiar</th><td><?=$user["usuari"]["Situación familiar"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Enviar información por duplicado"])) { ?><tr><th>Enviar información por duplicado</th><td><?=($user["usuari"]["Enviar información por duplicado"] == "1") ? "<img src='img/yes.png'>" : "<img src='img/no.png'>"?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Familia numerosa"])) { ?><tr><th>Familia numerosa</th><td><?=($user["usuari"]["Familia numerosa"] == "1") ? "<img src='img/yes.png'>" : "<img src='img/no.png'>"?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Número familia numerosa"]) && !empty($user["usuari"]["Número familia numerosa"])) { ?><tr><th>Número familia numerosa</th><td><?=$user["usuari"]["Número familia numerosa"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Sexo"]) && !empty($user["usuari"]["Sexo"])) { ?><tr><th>Sexo</th><td><?=$user["usuari"]["Sexo"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["DNI"]) && !empty($user["usuari"]["DNI"])) { ?><tr><th>DNI</th><td><?=$user["usuari"]["DNI"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Pasaporte"]) && !empty($user["usuari"]["Pasaporte"])) { ?><tr><th>Pasaporte</th><td><?=$user["usuari"]["Pasaporte"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Fecha de nacimiento"]) && !empty($user["usuari"]["Fecha de nacimiento"])) { ?><tr><th>Fecha de nacimiento</th><td><?=$user["usuari"]["Fecha de nacimiento"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Nacionalidad"]) && !empty($user["usuari"]["Nacionalidad"])) { ?><tr><th>Nacionalidad</th><td><?=$user["usuari"]["Nacionalidad"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Lugar de nacimiento"]) && !empty($user["usuari"]["Lugar de nacimiento"])) { ?><tr><th>Lugar de nacimiento</th><td><?=$user["usuari"]["Lugar de nacimiento"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Foto"]) && !empty($user["usuari"]["Foto"])) { ?><tr><th>Foto</th><td><?=$user["usuari"]["Foto"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["No mostrar la fotografía"])) { ?><tr><th>No mostrar la fotografía</th><td><?=($user["usuari"]["No mostrar la fotografía"] == "1") ? "<img src='img/yes.png'>" : "<img src='img/no.png'>"?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Número Seguridad Social"]) && !empty($user["usuari"]["Número Seguridad Social"])) { ?><tr><th>Número Seguridad Social</th><td><?=$user["usuari"]["Número Seguridad Social"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["E-mail"]) && !empty($user["usuari"]["E-mail"])) { ?><tr><th>E-mail</th><td><?=$user["usuari"]["E-mail"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Teléfono 1"]) && !empty($user["usuari"]["Teléfono 1"])) { ?><tr><th>Teléfono 1</th><td><?=$user["usuari"]["Teléfono 1"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Teléfono 2"]) && !empty($user["usuari"]["Teléfono 2"])) { ?><tr><th>Teléfono 2</th><td><?=$user["usuari"]["Teléfono 2"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Teléfono 3"]) && !empty($user["usuari"]["Teléfono 3"])) { ?><tr><th>Teléfono 3</th><td><?=$user["usuari"]["Teléfono 3"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Teléfono 4"]) && !empty($user["usuari"]["Teléfono 4"])) { ?><tr><th>Teléfono 4</th><td><?=$user["usuari"]["Teléfono 4"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["No quiere recibir SMS"])) { ?><tr><th>No quiere recibir SMS</th><td><?=($user["usuari"]["No quiere recibir SMS"] == "1") ? "<img src='img/yes.png'>" : "<img src='img/no.png'>"?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Generales"]) && !empty($user["usuari"]["Generales"])) { ?><tr><th>Generales</th><td><?=$user["usuari"]["Generales"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Médicas"]) && !empty($user["usuari"]["Médicas"])) { ?><tr><th>Médicas</th><td><?=$user["usuari"]["Médicas"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Fecha de alta"]) && !empty($user["usuari"]["Fecha de alta"])) { ?><tr><th>Fecha de alta</th><td><?=$user["usuari"]["Fecha de alta"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Fecha de modificación"]) && !empty($user["usuari"]["Fecha de modificación"])) { ?><tr><th>Fecha de modificación</th><td><?=$user["usuari"]["Fecha de modificación"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Fecha de baja"]) && !empty($user["usuari"]["Fecha de baja"])) { ?><tr><th>Fecha de baja</th><td><?=$user["usuari"]["Fecha de baja"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Motivo de baja"]) && !empty($user["usuari"]["Motivo de baja"])) { ?><tr><th>Motivo de baja</th><td><?=$user["usuari"]["Motivo de baja"]?></td></tr><?php } ?>
				<?php if (isset($user["usuari"]["Descripción de baja"]) && !empty($user["usuari"]["Descripción de baja"])) { ?><tr><th>Descripción de baja</th><td><?=$user["usuari"]["Descripción de baja"]?></td></tr><?php } ?>
			</tbody>
		</table>
		<?php
		$json2 = ws_query("/student/init_params", "id_alumne=".(int)$_GET["id"]);

		if (isset($json2["avaluacions"])) {
			?>
			<h3>Parámetros</h3>
			<?php
			foreach ($json2["avaluacions"] as $avaluacio) {
				?>
				<h4><?=$avaluacio["nom_avaluacio"]?></h4>
				<?php
				$json3 = ws_query("/student/get_param", "id_avaluacio=".$avaluacio["id_avaluacio"]."&id_alumne=".(int)$_GET["id"]);

				if (count($json3["detall"])) {
					?>
					<table class="wikitable trimestre_detall">
						<thead style="text-align: center;">
							<tr>
								<th>Data</th><th>Hora</th><th>Matèria</th><th>Resultat</th><th>Observacions</th>
							</tr>
						</thead>
						<tbody>
					<?php
				} else {
					echo "<p>No hay ningún parámetro.</p>";
				}

				foreach ($json3["detall"] as $day => $params) {
					foreach ($params as $paramsbyparam) {
						foreach ($paramsbyparam as $item) {
							if (isset($item["hora_final"])) {
								$valor = str_replace($dict["trans"]["color_es"], $dict["trans"]["color_ca"], $item["valor"]);
								?>
								<tr>
									<td><?=$day?></td>
									<td><?=$item["hora_inici"]?> - <?=$item["hora_final"]?></td>
									<td><?=$item["assignatura"]?></td>
									<td style="text-align: center; background-color: <?=$dict["assistencia_colors"][$valor]?>;"><?=$valor?></td>
									<td style="text-align: center;"><?=($item["anotacio"] == "" ? "-" : $item["anotacio"])?></td>
									<td class="dump"><?php var_dump($item); ?></td>
								</tr>
								<?php
							}
						}
					}
				}

				if (count($json3["detall"])) {
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