<?php
require_once("core.php");

if (!iswhitelisted("labs")) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > Labs';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Labs – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Labs</h1>
		<p>Hay los siguientes experimentos:</p>
		<ul>
			<li><a href="query.php">Query</a></li>
			<li><a href="retrasostats.php">Retrasostats</a></li>
			<li><a href="https://stpauls.clickedu.eu/ws/app_clickedu_query.php?cons_key=<?=$conf["cons_key"]?>&cons_secret=<?=$conf["cons_secret"]?>&auth_token=<?=$_SESSION["auth_token"]?>&auth_secret=<?=$_SESSION["auth_secret"]?>&query=/versio_web">Versión web</a></li>
		</ul>
	</body>
</html>