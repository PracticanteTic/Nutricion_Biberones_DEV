<?php

include('../config/Conexion.php');

$valor = $_POST['valor'];
$sql = "SELECT tamanio_cuchara FROM tipo_formula WHERE id=$valor";
$cuchara = mysqli_query($conexion, $sql);

if ($cuchara) {
  $row = $cuchara->fetch_assoc();
  $llenarInput = $row['tamanio_cuchara'];
  echo $llenarInput;
} else {
  $llenarInput = 10;
  echo $llenarInput;
}

?>