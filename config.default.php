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
$conf["cons_key"] = ""; // Constante llave (hay que verlo en la configuración de ClickEdu)
$conf["cons_secret"] = ""; // Constante secreta (hay que verlo en la configuración de ClickEdu)
$conf["materias"] = array(); // Lista de materias (llave es id_cgap, y valor es el nombre de la materia)

// Configuración de la base de datos:
$conf["host_db"] = "";
$conf["usuario_db"] = "";
$conf["clave_db"] = "";
$conf["nombre_db"] = "";