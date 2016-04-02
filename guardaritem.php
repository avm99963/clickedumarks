<?php
require_once("core.php");

if (!issuperwhitelisted()) {
	header("Location: index.php");
	exit();
}

if (!isset($_POST["item_id"]) || !isset($_POST["id_cgap"]) || !isset($_POST["agrupacio"]) || !isset($_POST["nota"]) || !isset($_POST["avaluacio"])) {
	header("Location: materias.php");
	exit();
}

$id_cgap = (int)$_POST["id_cgap"];
$id = (int)$_POST["item_id"];
$agrupacio = (int)$_POST["agrupacio"];
$avaluacio = (int)$_POST["avaluacio"]; // Esto es en realidad '''avaluacio'''!!!

$json = ws_query("/teacher/items_materia", "id_cgap=".urlencode($id_cgap));

if (isset($json["items"][$avaluacio][$agrupacio])) {
	foreach ($json["items"][$avaluacio][$agrupacio] as $pos => $item) {
		if ($item["id"] == $id) {
			$theitem = $item;
			$thepos = $pos;
			break;
		}
	}
} else {
	echo "Panic error.";
	exit();
}

if (!isset($theitem)) {
	header("Location: materias.php");
	exit();
}

$id_tipus = $theitem["id_tipus"];
$tipus = $theitem["tipus"];
$ind_text_associat = $theitem["ind_text_associat"];

$json2 = ws_query("/teacher/item_materia", "id_cgap=".urlencode($id_cgap)."&item[id]=".urlencode($id)."&item[tipus]=".urlencode($tipus)."&item[id_tipus]=".urlencode($id_tipus)."&ind_text_associat=".urlencode($ind_text_associat)."");

$query = array();
$query["id_cgap"] = (int)$_POST["id_cgap"];
$query["id_avaluacio"] = $avaluacio;
$query["id_agrupacio"] = $agrupacio;
$query["item"] = array(
	"id" => $theitem["id"],
	"tipus" => $theitem["tipus"],
	"id_tipus" => $theitem["id_tipus"],
	"ind_text_associat" => $theitem["ind_text_associat"],
	"contingut_digital" => ""
);

$query["post"] = array();
$query["post"]["id_criteri_".$avaluacio."_".$id] = $id;
foreach ($_POST["nota"] as $name => $nota) {
	$query["post"][$name] = $nota;
}

$http_query = http_build_query($query);

$query["alumnes"] = array();
foreach ($json2["alumnes"] as $i => $alumne) {
	$http_query .= "&".urlencode("alumnes[]")."=".$alumne["id"];
}

$response = ws_query("/teacher/guardar_item", $http_query, "post");

if (isset($response["guardat"]) && $response["guardat"] == 1) {
	header("Location: item.php?id_cgap=".$id_cgap."&item_id=".$id."&agrupacio=".$agrupacio);
	exit();
} else {
	echo "Ha habido un error al guardar las notas.";
}