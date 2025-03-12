<?php
include('../config/Conexion.php');

$id = $_POST['idBiber'];
$currentSesion = $_POST['sesion'];
$currentEpisodio = $_POST['episodio'];
$estado = $_POST['EstadoProximo'];
$estadoActual = $_POST['EstadoActual'];
$selectedIds = isset($_POST['selectedIds']) ? $_POST['selectedIds'] : array();


// Verificar si $selectedIds es una cadena JSON y decodificar si es necesario
if (is_string($selectedIds)) {
    $selectedIds = json_decode($selectedIds, true);

    // Manejar posibles errores en la decodificación JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Error al decodificar JSON: " . json_last_error_msg();
        exit();
    }
} elseif (!is_array($selectedIds)) {
    $selectedIds = array();
}

// Depuración: Verificar los datos recibidos
echo '<pre>';
print_r($selectedIds); // Verifica que los IDs seleccionados se estén recibiendo
echo '</pre>';

if (empty($selectedIds)) {
    $sql1 = "UPDATE tabla_biberones SET id_estado = $estado WHERE Id_biberon = $id";
    if (!mysqli_query($conexion, $sql1)) {
        echo "Error al actualizar el estado en la tabla 'tabla_biberones': " . mysqli_error($conexion);
        exit();
    }

    $sql2 = "INSERT INTO estados_solicitudes (episodio, id_estado, usuario, fecha_ingreso) VALUES ($currentEpisodio, '$estado', '$currentSesion', NOW())";
    if (!mysqli_query($conexion, $sql2)) {
        echo "Error al insertar el registro en la tabla 'estados_solicitudes': " . mysqli_error($conexion);
        exit();
    }
} else {
    foreach ($selectedIds as $idBiberon) {
        $sql1 = "UPDATE tabla_biberones SET id_estado = $estado WHERE Id_biberon = '$idBiberon' AND id_estado = '$estadoActual'";
        if (!mysqli_query($conexion, $sql1)) {
            echo "Error al actualizar el estado en la tabla 'tabla_biberones': " . mysqli_error($conexion);
            exit();
        }

        if (mysqli_affected_rows($conexion) > 0) {
            $sql3 = "SELECT episodio FROM tabla_biberones WHERE id_biberon = $idBiberon";
            if (!mysqli_query($conexion, $sql3)) {
                echo "Error al insertar el registro en la tabla 'estados_solicitudes': " . mysqli_error($conexion);
                exit();
            }
            $fila = mysqli_fetch_assoc(mysqli_query($conexion, $sql3));
            if ($fila) {
                $episodioResult = $fila['episodio'];
                $sql2 = "INSERT INTO estados_solicitudes (episodio, id_estado, usuario, fecha_ingreso) VALUES ('$episodioResult', '$estado', '$currentSesion', NOW())";
            if (!mysqli_query($conexion, $sql2)) {
                echo "Error al insertar el registro en la tabla 'estados_solicitudes': " . mysqli_error($conexion);
                exit();
            }
            } else {
                echo "No se encontraron resultados.";
            }
        }
    }
}
mysqli_close($conexion);
?>