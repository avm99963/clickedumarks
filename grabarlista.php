<?php
require_once("core.php");

if (!issuperwhitelisted()) {
	header("Location: index.php");
	exit();
}

if (!isset($_POST["id_cgap"]) || !isset($_POST["datetime"])) {
	header("Location: index.php");
	exit();
}

$id_cgap = (int)$_POST["id_cgap"];
$datetime = $_POST["datetime"];

list($date, $time) = explode("T", $datetime);
list($year, $month, $day) = explode("-", $date);
list($hours, $minutes) = explode(":", $time);
$seconds = "00";

//$query = http_build_query($_POST)."&tipus_sessio=sessio";
$query = "id_cgap=".urlencode((int)$_POST["id_cgap"])."tipus_sessio=sessio&data_sessio=".urlencode($_POST["data_sessio"])."&hora_sessio=".urlencode($_POST["hora_sessio"])."&id_sessio=".urlencode((int)$_POST["id_sessio"]);

$sessioid = $year."/".$month."/".$day."_".$hours.$minutes.$seconds;
$json = ws_query("/teacher/assistencia_sessio", "id_cgap=".urlencode($id_cgap)."&id_sessio=".urlencode($sessioid)."&data_sessio=".urlencode($year."/".$month."/".$day)."&hora_sessio=".urlencode($hours.$minutes.$seconds));

if ($json["sessio"]["llista"]["activitat"] === false) {
	echo "Actividad no existe.<br>";
}

foreach ($json["sessio"]["llista"]["alumnes"] as $alumne) {
	$id_assistencia = (count($alumne["assistencia"]) ? $alumne["assistencia"][0]["id_assistencia"] : "noid");
	if (count($alumne["assistencia"])) {
		$query .= "&assistencia[hid_del_".$id_assistencia."_".$alumne["id"]."]=";
		if (!isset($_POST["assistencia"]["rbtn_ar_".$id_assistencia."_".$alumne["id"]])) {
			$query .= "1";
		} else {
			$query .= "0";
		}
	} else {
		$query .= "&assistencia[hid_del_".$id_assistencia."_".$alumne["id"]."]=0";
	}

	if (isset($_POST["assistencia"]["rbtn_ar_".$id_assistencia."_".$alumne["id"]])) {
		$query .= "&assistencia[rbtn_ar_".$id_assistencia."_".$alumne["id"]."]=".$_POST["assistencia"]["rbtn_ar_".$id_assistencia."_".$alumne["id"]];
	}
	if (isset($_POST["assistencia"]["cbtn_just_".$id_assistencia."_".$alumne["id"]])) {
		$query .= "&assistencia[cbtn_just_".$id_assistencia."_".$alumne["id"]."]=".$_POST["assistencia"]["cbtn_just_".$id_assistencia."_".$alumne["id"]];
	}
}

print(str_replace("&", "<br>", $query));

$json2 = ws_query("/teacher/guardar_assistencia", $query, "post");

if (isset($json2["sessio"])) {
	header("Location: verasistencia.php?id_cgap=".$id_cgap."&datetime=".$datetime);
	exit();
} else {
	echo "Ha habido un error al guardar la lista de asistencia. Véase la respuesta del servidor aquí abajo:<br><br>";
	print_r($json2);
}