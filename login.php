<?php
require_once("core.php");

if (!isset($_POST["username"]) || !isset($_POST["password"])) {
	header("Location: index.php?msg=empty");
	exit();
}

unset($_SESSION["cookie"]);
unset($_SESSION["id_usuari_2"]);

$login = json_decode(curl("/ws/app_clickedu_init.php", "cons_key=".urlencode($conf["cons_key"])."&cons_secret=".urlencode($conf["cons_secret"]), "POST"), true);

$_SESSION["auth_token"] = $login["token"];
$_SESSION["auth_secret"] = $login["secret"];

$login2 = json_decode(curl("/authorization.php", "access_token=".urlencode($login["token"])."&pass=".urlencode($_POST["password"])."&user=".urlencode($_POST["username"])), true);

if (isset($login2["error"])) {
	if ($login2["error"] == "Usuario o contraseña incorrectos") {
		header("Location: index.php?msg=incorrect");
		exit();
	} else {
		echo "Ha habido un error inesperado en authorization.php: ".$login2["error"]." - ".$login2["msg"];
		exit();
	}
}

if (!in_array($login2["id_usuari"], $conf["allowed"])) {
	header("Location: index.php?msg=notallowed");
	exit();
}

$_SESSION["id_usuari"] = $login2["id_usuari"];

$login3 = json_decode(curl("/ws/app_clickedu_permissions.php", "acceptar=1&es_webapp=true&id_usr=".$login2["id_usuari"]."&oauth_token=".urlencode($login["token"])."&resource=%5B0%2C1%5D", "POST"), true);

if (isset($login3["error"])) {
	echo "Ha habido un error inesperado en app_clickedu_permissions.php: ".$login3["error"]." - ".$login3["msg"];
	exit();
}

$login4 = json_decode(curl("/ws/app_clickedu_validated.php", "auth_secret=".urlencode($login["secret"])."&auth_token=".urlencode($login["token"])."&cons_key=".urlencode($conf["cons_key"])."&id_usuari=".$login2["id_usuari"]."&ind_pm=0", "POST", "ClickEdu/org.clickedu.Clickedu (21; OS Version 9.3 (Build 13E5233a))"), true);

if (isset($login4["error"])) {
	echo "Ha habido un error inesperado en app_clickedu_validated.php: ".$login4["error"]." - ".$login4["msg"];
	exit();
}

if (!isset($login4["validat"]) || $login4["validat"] != 1) {
	echo "Ha ocurrido un error, y no se ha podido validar el inicio de sesión. Por favor, vuélvelo a intentar.";
	exit();
}

$login5 = json_decode(curl("/ws/app_clickedu_check_token.php", "id=00000000-0000-0000-0000-000000000000&installationId=00000000-0000-0000-0000-000000000000&nom=&platform=web&token=".urlencode($login["token"])."&secret=".urlencode($login["secret"])."&version=2", "GET", "ClickEdu/org.clickedu.Clickedu (21; OS Version 9.3 (Build 13E5233a))"), true);

$_SESSION["es_pm"] = (($login5["es_pm"] == 1) ? true : false);

$ws = ws_query("/init");

$_SESSION["tipus"] = $ws["tipus_usuari"];

if (in_array($login2["id_usuari"], $conf["switchwhitelist"]) && isset($_POST["switchuser"])) {
	header("Location: switchuser.php");
} else {
	header("Location: home.php");
}