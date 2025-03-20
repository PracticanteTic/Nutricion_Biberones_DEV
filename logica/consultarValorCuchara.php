<?php

include('../config/Conexion.php');

$valor = $_POST['valor'];
$sql = "SELECT tamanio_cuchara FROM tipo_formula WHERE id=$valor";
$cuchara = mysqli_query($conexion, $sql);

if ($cuchara) { // Si el valor de $cuchara es un mysqli_result, entonces la conexion funcionó
  $row = $cuchara->fetch_assoc();
  $llenarInput = $row['tamanio_cuchara'];
  echo $llenarInput;
} else { // Si el $cuchara es falso, la conexion fallo
  $llenarInput = 10;
  echo $llenarInput;
}

?>