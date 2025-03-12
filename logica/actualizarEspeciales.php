<?php 
include('../config/Conexion.php');
if(isset($_POST['id']) && isset($_POST['valoresPrimeraColumna']) && isset($_POST['valoresSegundaColumna']) ){

    $id = $_POST['id'];
    $valoresPrimeraColumna = $_POST['valoresPrimeraColumna'];
    $valoresSegundaColumna = $_POST['valoresSegundaColumna'];
    
    $sql = "CALL SP_actualizarEspeciales( ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('dddddddssssssss', $valoresPrimeraColumna[0],$valoresPrimeraColumna[1],$valoresPrimeraColumna[2],$valoresPrimeraColumna[3],$valoresPrimeraColumna[4],$valoresPrimeraColumna[5],$valoresPrimeraColumna[6],$valoresSegundaColumna[0],$valoresSegundaColumna[1],$valoresSegundaColumna[2],$valoresSegundaColumna[3],$valoresSegundaColumna[4],$valoresSegundaColumna[5],$valoresSegundaColumna[6],$id);

        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(["message" => "Data saved successfully"]);
        } else {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }
    }else {
        echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
    }
}else {
    echo json_encode(['error' => "Faltan parámetros en la solicitud"]);
}