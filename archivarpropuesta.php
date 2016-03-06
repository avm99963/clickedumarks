<?php
require_once("core.php");

if (!admincaixapropostes()) {
	header("Location: index.php");
	exit();
}

if (!isset($_GET["id"])) {
	header("Location: veurecaixapropostes.php");
	exit();
}

if (!isset($_GET["desarchivar"]) || $_GET["desarchivar"] == 0) {
	$archive = 1;
} else {
	$archive = 0;
}

if (mysqli_query($con, "UPDATE propuestas SET archived = ".$archive." WHERE id = ".(int)$_GET["id"]." LIMIT 1")) {
	header("Location: veurecaixapropostes.php".(!$archive ? "?archived=1" : ""));
	exit();
} else {
	echo "Ha habido un error al archivar la propuesta.".mysqli_error($con);
}