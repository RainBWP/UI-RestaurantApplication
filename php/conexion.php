<?php
class Conexion {
  public function getConexion() {
    $host = "localhost"; // Cambia esto si tu base de datos no está en localhost
    $user = "root"; // Cambia esto por tu nombre de usuario de MySQL
    $pass = ""; // Cambia esto por tu contraseña de MySQL
    $db = "proyectofinal";

    try {
      $db = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
      return $db;
    }
    catch(PDOException $e) {
      echo "Error de conexión: " . $e->getMessage();
      die();
    }
  }
}
?>
