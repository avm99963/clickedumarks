<?php
require_once("core.php");

if (!isset($_POST["id"]) || !isset($_POST["username"]) || !isset($_POST["password"])) {
	header("Location: switchuser.php");
	exit();
}

$id = (int)$_POST["id"];

unset($_SESSION["cookie"]);

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

$login3 = json_decode(curl("/ws/app_clickedu_permissions.php", "acceptar=1&es_webapp=true&id_usr=".$id."&oauth_token=".urlencode($login["token"])."&resource=%5B0%2C1%5D", "POST"), true);

if (isset($login3["error"])) {
	echo "Ha habido un error inesperado en app_clickedu_permissions.php: ".$login3["error"]." - ".$login3["msg"];
	exit();
}

$login4 = json_decode(curl("/ws/app_clickedu_validated.php", "auth_secret=".urlencode($login["secret"])."&auth_token=".urlencode($login["token"])."&cons_key=".urlencode($conf["cons_key"])."&id_usuari=".$id."&ind_pm=0", "POST", "ClickEdu/org.clickedu.Clickedu (21; OS Version 9.3 (Build 13E5233a))"), true);

if (isset($login4["error"])) {
	echo "Ha habido un error inesperado en app_clickedu_validated.php: ".$login4["error"]." - ".$login4["msg"];
	exit();
}

if (!isset($login4["validat"]) || $login4["validat"] != 1) {
	echo "Ha ocurrido un error, y no se ha podido validar el inicio de sesión. Por favor, vuélvelo a intentar.";
	exit();
}

$login5 = json_decode(curl("/ws/app_clickedu_check_token.php", "id=00000000-0000-0000-0000-000000000000&installationId=00000000-0000-0000-0000-000000000000&nom=&platform=iOS&token=".urlencode($login["token"])."&secret=".urlencode($login["secret"])."&version=2", "GET", "ClickEdu/org.clickedu.Clickedu (21; OS Version 9.3 (Build 13E5233a))"), true);

$ws = ws_query("/init");

$_SESSION["id_usuari_2"] = $id;
$_SESSION["tipus"] = $ws["tipus_usuari"];

/*echo "app_clickedu_init.php<br>";
print_r($login);

echo "<br><br>authorization.php<br>";
print_r($login2);

echo "<br><br>app_clickedu_permissions.php<br>";
print_r($login3);

echo "<br><br>app_clickedu_validated.php<br>";
print_r($login4);

echo "<br><br>app_clickedu_check_token.php<br>";
print_r($login5);

echo "<br><br>/init<br>";
print_r($ws);

exit();*/ // Debug code when login doesn't seem to work

header("Location: home.php");