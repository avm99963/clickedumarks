<?php
require_once("core.php");

$_SESSION["auth_token"] = $_GET["auth_token"];
$_SESSION["auth_secret"] = $_GET["auth_secret"];