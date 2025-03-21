<?php

include('../config/Conexion.php');

// Devuelve el tamaño de la cuchara
$valor = $_POST['valor']; // Recibe el nombre de la formula
$sql = "SELECT tamanio_cuchara FROM tipo_formula WHERE id=$valor";
$cuchara = mysqli_query($conexion, $sql); // Ejecuta la sentencia

if ($cuchara) { // Si el valor de $cuchara es un mysqli_result, entonces la conexion funcionó
  $row = $cuchara->fetch_assoc(); // Array asociativo --> ["id" => 1, "tamanio_cuchara" => 4.5]
  $llenarInput = $row['tamanio_cuchara'];
  echo $llenarInput;
} else { // Si el $cuchara es falso, la conexion fallo
  $llenarInput = 10;
  echo $llenarInput;
}
?>