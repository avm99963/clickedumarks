<?php
require_once("core.php");

echo "¿Deseas instalar ClickEdu Marks? (y/n): ";
if (strtolower(fgets(STDIN)) == "y\n") {
  $sql = array();

  $sql["propuestas"] = "CREATE TABLE propuestas
  (
  id INT(13) NOT NULL AUTO_INCREMENT, 
  PRIMARY KEY(id),
  titulo VARCHAR(150),
  description TEXT,
  origen VARCHAR(150),
  time INT(13),
  archived INT(1)
  )";

  $sql["acciones"] = "CREATE TABLE acciones
  (
  id INT(13) NOT NULL AUTO_INCREMENT, 
  PRIMARY KEY(id),
  query VARCHAR(50),
  fields TEXT,
  method VARCHAR(10),
  time INT(13),
  user INT(5)
  )";

  foreach ($sql as $key => $query) {
    if (mysqli_query($con, $query)) {
      echo "Tabla '".$key."' creada satisfactoriamente\n";
    } else {
      die ("Error al crear tabla '".$key."': " . mysqli_error($con) . "\n");
    }
  }

  echo "ClickEdu Marks se ha instalado correctamente. Por favor, borre el archivo install.php.\n";
}