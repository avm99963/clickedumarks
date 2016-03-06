<?php
require_once("core.php");

if (!admincaixapropostes()) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > <a href="caixapropostes.php">Caja de propuestas</a> > Ver';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ver caja de propuestas – ClickEdu Marks</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="mdl/material.css">
		<script defer src="mdl/material.min.js"></script>
		<link rel="stylesheet" href="styles.css">
		<script defer src="mdl/getmdl-select.min.js"></script>
		<link rel="stylesheet" href="mdl/getmdl-select.min.css">
		<style>
		body {
			-webkit-tap-highlight-color: rgba(0,0,0,0);
		}
		.card {
			position: relative;
			background: white;
		}
		h2 {
			padding: 16px 16px;
		}
		.time, .text {
			padding: 8px 16px 16px 16px;
		}
		.time {
			color: #555;
		}
		.archive {
			position: absolute;
			top: 16px;
			right: 16px;
		}
		</style>
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php
		include("header.php");
		if (isset($_GET["archived"]) && !empty($_GET["archived"])) {
			$archived = 1;
			?>
			<h1>Caja de propuestas archivadas</h1>
			<p><a href="veurecaixapropostes.php">Ver propuestas activas</a></p>
			<?php
		} else {
			$archived = 0;
			?>
			<h1>Caja de propuestas</h1>
			<p><a href="veurecaixapropostes.php?archived=1">Ver propuestas archivadas</a></p>
			<?php
		}
		$query = mysqli_query($con, "SELECT * FROM propuestas WHERE archived = ".$archived);
		if (mysqli_num_rows($query)) {
			?>
			<div class="mdl-grid">
			<?php
			while ($row = mysqli_fetch_assoc($query)) {
				?>
				<div class="mdl-cell mdl-cell--4-col mdl-shadow--2dp card">
					<h2 class="mdl-card__title-text"><?=$row["titulo"]?></h2>
					<div class="time"><?=htmlspecialchars($row["origen"])?>, <?=date("m/d/Y H:i (e)", $row["time"])?></div>
					<div class="text">
						<?=nl2br(htmlspecialchars($row["description"]))?>
					</div>
					<?php
					if ($row["archived"] == 0) {
						?>
						<a href="archivarpropuesta.php?id=<?=$row["id"]?>" class="archive mdl-button mdl-js-button mdl-button--icon">
							<i class="material-icons">archive</i>
						</a>
						<?php
					} else {
						?>
						<a href="archivarpropuesta.php?id=<?=$row["id"]?>&desarchivar=1" class="archive mdl-button mdl-js-button mdl-button--icon">
							<i class="material-icons">unarchive</i>
						</a>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
			</div>
			<?php
		} else {
			?>
			<p>No hay propuestas</p>
			<?php
		}
		?>
	</body>
</html>