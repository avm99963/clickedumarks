<?php
require_once("core.php");

if (!isset($_POST["id"]) || !isset($_POST["auth_token"]) || !isset($_POST["auth_secret"])) {
	header("Location: tokenlogin.php?msg=empty");
	exit();
}

if ($_POST["id"] <= 0) {
	header("Location: tokenlogin.php?msg=empty&errcode=0x0mc1");
}

if (!$_SESSION["id_usuari"]) {
	$_SESSION["id_usuari"] = 0;
}
$_SESSION["id_usuari_2"] = (int)$_POST["id"];
$_SESSION["auth_token"] = $_POST["auth_token"];
$_SESSION["auth_secret"] = $_POST["auth_secret"];

$ws = ws_query("/init");

$_SESSION["tipus"] = $ws["tipus_usuari"];

header("Location: home.php");