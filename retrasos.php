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
		<h1>Ausencias y retrasos</h1>
		<?php
		if ($_SESSION["tipus"] == 1) {
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
			<?php
			$json2 = ws_query("/student/init_params");

			foreach ($json2["avaluacions"] as $avaluacio) {
				?>
				<h3><?=$avaluacio["nom_avaluacio"]?></h3>
				<?php
				$json3 = ws_query("/student/get_param", "id_avaluacio=".$avaluacio["id_avaluacio"]);

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
				}

				foreach ($json3["detall"] as $day => $params) {
					foreach ($params as $paramsbyparam) {
						foreach ($paramsbyparam as $item) {
							$valor = str_replace($dict["trans"]["color_es"], $dict["trans"]["color_ca"], $item["valor"]);
							?>
							<tr>
								<td><?=$day?></td>
								<td><?=$item["hora_inici"]?> - <?=$item["hora_final"]?></td>
								<td><?=$item["assignatura"]?></td>
								<td style="text-align: center; background-color: <?=$dict["assistencia_colors"][$valor]?>;"><?=$valor?></td>
								<td style="text-align: center;"><?=($item["anotacio"] == "" ? "-" : $item["anotacio"])?></td>
							</tr>
							<?php
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
		<ul>
			<li><a href="asistencia.php">Ver la asistencia a una sesión</a></li>
		</ul>
	</body>
</html>