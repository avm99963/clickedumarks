<?php
require_once("core.php");

if (!isset($_POST["username"]) || !isset($_POST["password"])) {
	header("Location: index.php?msg=empty");
	exit();
}

unset($_SESSION["cookie"]);

$login = json_decode(api_login("action=doLogin&usr=".urlencode($_POST["username"])."&pwd=".urlencode($_POST["password"]), true), true);

if (isset($login["error"])) {
	if ($login["error"] == "Usuario o Contraseña INCORRECTA.") {
		header("Location: index.php?msg=incorrect");
		exit();
	} else {
		header("Location: index.php?msg=unexpected&error=0xcem001");
		exit();
	}
}

if (!isset($login["id_usuari"])) {
	header("Location: index.php?msg=unexpected&error=0xcem002");
	exit();
}

if (!in_array($login["id_usuari"], $conf["allowed"])) {
	header("Location: index.php?msg=notallowed");
	exit();
}

$_SESSION["id_usuari"] = $login["id_usuari"];
$_SESSION["es_pm"] = (($login["es_pm"] == 1) ? true : false);
$_SESSION["es_alu"] = (($login["es_alu"] == 1) ? true : false);
$_SESSION["es_altres"] = (($login["es_altres"] == 1) ? true : false);

$login2 = json_decode(api_login("action=existsToken&cons_key=".urlencode($conf["cons_key"])), true);

$_SESSION["auth_token"] = $login2["info"]["t"];
$_SESSION["auth_secret"] = $login2["info"]["s"];

$ws = ws_query("/init");

if (in_array($login["id_usuari"], $conf["switchwhitelist"]) && isset($_POST["switchuser"])) {
	header("Location: switchuser.php");
} else {
	header("Location: home.php");
}