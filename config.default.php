<?php
/*
 * config.defualt.php
 * Renombrar este fichero a config.php
 *
 */

$conf = array();
$conf["path"] = "/clickedumarks/"; // Ruta hasta la página principal (para poder establecer bien la cookie)
$conf["apiurl"] = "https://stpauls.clickedu.eu"; // URL del domini de ClickEdu
$conf["allowed"] = []; // Lista de usuarios que tienen permisos para entrar a la intranet con los permisos mínimos (ids)
$conf["whitelist"] = []; // Lista de usuarios que tienen permisos para ver más (ids)
$conf["superwhitelist"] = []; // Lista de usuarios que tienen permisos para editar (ids)
$conf["caixaproposteswhitelist"] = []; // Lista de usuarios que tienen permisos para administrar caja de propuestas (ids)
$conf["switchwhitelist"] = []; // Lista de usuarios que pueden elegir con qué usuario iniciar sesión (ids)
$conf["searchwhitelist"] = []; // Lista de usuarios que pueden buscar usuarios (ids)
$conf["labswhitelist"] = []; // Lista de usuarios que pueden usar los experimentos de labs (ids)
$conf["materias"] = array(); // Lista de materias (llave es id_cgap, y valor es el nombre de la materia)

// Constantes OAuth de ClickEdu. Son las mismas para todos los colegios, así que no hace falta cambiar su valor a menos que las desautoricen.
$conf["cons_key"] = "81a8d89c3902d7b7177c3c0a974096";
$conf["cons_secret"] = "1b425b7d57";
$conf["ios_cons_key"] = "21f026bf5ac16d01225fb08064a6f1";
$conf["ios_cons_secret"] = "e371fc9ab2";

// Configuración de la base de datos:
$conf["host_db"] = "";
$conf["usuario_db"] = "";
$conf["clave_db"] = "";
$conf["nombre_db"] = "";