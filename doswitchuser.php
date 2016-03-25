<?php
require_once("core.php");

if (!isset($_POST["id"]) || !isset($_POST["username"]) || !isset($_POST["password"])) {
	header("Location: switchuser.php");
	exit();
}

$id = (int)$_POST["id"];

unset($_SESSION["cookie"]);

$login = json_decode(curl("/ws/app_clickedu_init.php", "cons_key=".urlencode($conf["ios_cons_key"])."&cons_secret=".urlencode($conf["ios_cons_secret"]), "POST"), true);

$_SESSION["auth_token"] = $login["token"];
$_SESSION["auth_secret"] = $login["secret"];

$login2 = json_decode(curl("/authorization.php", "access_token=".urlencode($login["token"])."&pass=".urlencode($_POST["password"])."&user=".urlencode($_POST["username"])), true);

$login3 = json_decode(curl("/ws/app_clickedu_permissions.php", "acceptar=1&es_webapp=true&id_usr=".$id."&oauth_token=".urlencode($login["token"])."&resource=%5B0%2C1%5D", "POST"), true);

$login4 = json_decode(curl("/ws/app_clickedu_validated.php", "auth_secret=".urlencode($login["secret"])."&auth_token=".urlencode($login["token"])."&cons_key=".urlencode($conf["ios_cons_key"])."&id_usuari=".$id."&ind_pm=0", "POST", "ClickEdu/org.clickedu.Clickedu (21; OS Version 9.3 (Build 13E5233a))"), true);

$login5 = json_decode(curl("/ws/app_clickedu_check_token.php", "id=00000000-0000-0000-0000-000000000000&installationId=00000000-0000-0000-0000-000000000000&nom=&platform=iOS&token=".urlencode($login["token"])."&secret=".urlencode($login["secret"])."&version=2", "GET", "ClickEdu/org.clickedu.Clickedu (21; OS Version 9.3 (Build 13E5233a))"), true);

$ws = ws_query("/init");

$_SESSION["id_usuari_2"] = $id;

header("Location: home.php");