<?php
/*
 * ClickEdu Marks
 * The ClickEdu Marks core file, adapted form Douglasbot
 * @Author: Adrià Vilanova Martínez (@Avm99963)
 *
 */

require_once("dict.php");
require_once("config.php");

date_default_timezone_set("UTC");
setlocale(LC_TIME, "es_ES");

session_set_cookie_params(0, $conf["path"]);
session_start();

$con = @mysqli_connect($conf["host_db"], $conf["usuario_db"], $conf["clave_db"], $conf["nombre_db"]) or die("<center>Check Mysqli settings in config.php</center>"); // Conectamos y seleccionamos BD

function ws_query($query, $fields="", $method="GET") {
	$json = json_decode(ws_curl($query, $fields, $method), true);

	return $json;
}

function curl($relativeurl, $fields, $method="GET", $useragent="") {
	global $conf;

	$ch = curl_init();

	if (strtolower($method) == "post") {
		curl_setopt($ch, CURLOPT_URL, $conf["apiurl"].$relativeurl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	} else {
		curl_setopt($ch, CURLOPT_URL, $conf["apiurl"].$relativeurl."?".$fields);
	}

	if (isset($_SESSON["cookie"])) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: ".$_SESSION["cookie"]));
	}

	if (!empty($useragent)) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: ".$useragent));
	}

	curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
	curl_setopt($ch, CURLOPT_HEADERFUNCTION, "curlResponseHeaderCallback");

	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close($ch);

	return $server_output;
}

function ws_curl($query, $fields, $method) {
	global $conf;

	$fields = "cons_key=".$conf["cons_key"]."&cons_secret=".$conf["cons_secret"]."&auth_token=".$_SESSION["auth_token"]."&auth_secret=".$_SESSION["auth_secret"]."&query=".urlencode($query).((!empty($fields)) ? "&".$fields : "");

	return curl("/ws/app_clickedu_query.php", $fields, $method);

	/*if (strtolower($method) == "post") {
		curl_setopt($ch, CURLOPT_URL, $conf["apiurl"]."/ws/app_clickedu_query.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	} else {
		curl_setopt($ch, CURLOPT_URL, $conf["apiurl"]."/ws/app_clickedu_query.php?".$fields);
	}

	if (isset($_SESSON["cookie"])) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: ".$_SESSION["cookie"]));
	}

	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close($ch);

	return $server_output;*/
}

function api_login($query) {
	global $conf;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $conf["apiurl"]."/m/ajax/login.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

	if (isset($_SESSION["cookie"])) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: ".$_SESSION["cookie"]));
	}

	// receive server response ...
	curl_setopt($ch, CURLOPT_HEADERFUNCTION, "curlResponseHeaderCallback");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close($ch);

	return $server_output;
}

function is_ws_logged() {
	global $conf;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $conf["apiurl"]."/m/ajax/login.php?action=estaLogat");

	if (isset($_SESSION["cookie"])) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: ".$_SESSION["cookie"]));
	}

	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close($ch);

	$json = json_decode($server_output, true);

	if ($json["logat"] == "true") {
		return true;
	} else {
		return false;
	}
}

function curlResponseHeaderCallback($ch, $headerLine) {
    if (preg_match('/^Set-Cookie:\s*([^;]*)/mi', $headerLine, $cookie) == 1)
        $_SESSION["cookie"] = $cookie[1];
    return strlen($headerLine); // Needed by curl
}

function isloggedin() {
	if (isset($_SESSION["id_usuari"])) {
		return true;
	} else {
		return false;
	}
}

function issuperwhitelisted() {
	global $conf;
	if (!isloggedin()) {
		return false;
	}
	if ($_SESSION["id_usuari"] === 0) {
		return true;
	}
	if (in_array($_SESSION["id_usuari"], $conf["superwhitelist"])) {
		return true;
	} else {
		return false;
	}
}

function admincaixapropostes() {
	global $conf;
	if (!isloggedin()) {
		return false;
	}
	if ($_SESSION["id_usuari"] === 0) {
		return true;
	}
	if (in_array($_SESSION["id_usuari"], $conf["caixaproposteswhitelist"])) {
		return true;
	} else {
		return false;
	}
}

function iswhitelisted($whitelistname="") {
	global $conf;

	if (!isset($conf[$whitelistname."whitelist"])) {
		return false;
	}
	if (!isloggedin()) {
		return false;
	}
	if ($_SESSION["id_usuari"] === 0) {
		return true;
	}
	if (in_array($_SESSION["id_usuari"], $conf[$whitelistname."whitelist"])) {
		return true;
	} else {
		return false;
	}
}

function get_materias() {
	$timetable = ws_query("/timetable");

	$materias = array();

	if (count($timetable["taula"])) {
		foreach ($timetable["taula"] as $day) {
			if (count($day)) {
				foreach ($day as $subject) {
					if (!isset($subject["id_cgap"])) {
						break 2;
					}
					if (!isset($materias[$subject["id_cgap"]])) {
						$materias[$subject["id_cgap"]] = $subject["nom_assignatura"];
					}
				}
			}
		}
	}

	if (count($materias)) {
		return $materias;
	} else {
		return false;
	}
}

//Signature: array array_column ( array $input , mixed $column_key [, mixed $index_key ] )
if( !function_exists( 'array_column' ) ) {
    function array_column( array $input, $column_key, $index_key = null ) {
    
        $result = array();
        foreach( $input as $k => $v )
            $result[ $index_key ? $v[ $index_key ] : $k ] = $v[ $column_key ];
        
        return $result;
    }
}