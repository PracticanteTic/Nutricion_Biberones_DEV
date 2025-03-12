<?php
include('../config/Conexion.php');

$id = $_POST['id'];
$currentSesion = $_POST['sesion'];
$estado = $_POST['idEstado'];
$estadoString = '';


    // Actualizar el estado en la tabla 'tabla_biberones'
    $sql1 = "UPDATE solicitudes_stock SET id_estado = $estado WHERE id = $id";
    if (!mysqli_query($conexion, $sql1)) {
        echo "Error al actualizar el estado en la tabla 'tabla_biberones': " . mysqli_error($conexion);
        exit();
    }
    
    // Obtener el estado como una cadena de texto
    
    
    // Insertar el registro en la tabla 'estados_solicitudes'
    $sql2 = "INSERT INTO estados_solicitudes (episodio, id_estado, usuario, fecha_ingreso) VALUES (1, '$estado', '$currentSesion', NOW())";
    if (!mysqli_query($conexion, $sql2)) {
        echo "Error al insertar el registro en la tabla 'estados_solicitudes': " . mysqli_error($conexion);
        exit();
    }

echo $sql1;
echo $sql2;
echo true;

mysqli_close($conexion);
?>