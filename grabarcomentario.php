<?php
require_once("core.php");

if (!isset($_POST["origen"]) || !isset($_POST["asunto"]) || !isset($_POST["mensaje"]) || empty($_POST["origen"]) || empty($_POST["asunto"]) || empty($_POST["mensaje"])) {
	header("Location: comentar.php?msg=incompleto");
	exit();
}

$origen = mysqli_real_escape_string($con, $_POST["origen"]);
$asunto = mysqli_real_escape_string($con, $_POST["asunto"]);
$mensaje = mysqli_real_escape_string($con, $_POST["mensaje"]);

if (mysqli_query($con, "INSERT INTO propuestas (titulo, description, origen, time, archived) VALUES ('".$asunto."', '".$mensaje."', '".$origen."', ".time().", 0)")) {
	header("Location: comentar.php?msg=ue");
	exit();
} else {
	echo "Ha habido un error al guardar tu comentario.";
}