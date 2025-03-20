<?php 
include('../config/Conexion.php');
if(isset($_POST['id']) && isset($_POST['valoresPrimeraColumna']) && isset($_POST['valoresSegundaColumna']) ){

    $id = $_POST['id'];
    $valoresPrimeraColumna = $_POST['valoresPrimeraColumna'];
    $valoresSegundaColumna = $_POST['valoresSegundaColumna'];
    
    $sql = "CALL SP_actualizarEspeciales( ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)";
    if ($stmt = $conexion->prepare($sql)) {
        // $valoresPrimeraColumna son los datos que se ingresaron en la columna "1" la cual contiene el dato de cada ingrediente (Los que podran ser modificados)
        // $valoresUltimaColumna son los datos que se ingresaron en la columna "observaciones" la cual es de tipo string

        // Pregunta: El orden de los parametros deberia de importar, porque en el query de la base de datos el primer parametro que recibe es el cereal, pero en la tabla es el aceite
        $stmt->bind_param('dddddddssssssss', $valoresPrimeraColumna[0],$valoresPrimeraColumna[1],$valoresPrimeraColumna[2],$valoresPrimeraColumna[3],$valoresPrimeraColumna[4],$valoresPrimeraColumna[5],$valoresPrimeraColumna[6],$valoresSegundaColumna[0],$valoresSegundaColumna[1],$valoresSegundaColumna[2],$valoresSegundaColumna[3],$valoresSegundaColumna[4],$valoresSegundaColumna[5],$valoresSegundaColumna[6],$id);

        if ($stmt->execute()) {
            header('Content-Type: application/json');
            $respuesta = array("message" => "Data saved successfully");
            echo json_encode($respuesta); // retorna un json confirmado un guardado exitoso
        } else {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }
    }else {
        $respuesta = array("error" => "Error en la preparación de la consulta: " . $conexion->error);
        echo json_encode( $respuesta);
    }
}else {
    $respuesta = array("error" => "Faltan parámetros en la solicitud: " . $conexion->error);
    echo json_encode($respuesta);
}

// ------------------------- ESTE ES EL BLOQUE ORIGINAL -------------------------------
// <?php 
// include('../config/Conexion.php');
// if(isset($_POST['id']) && isset($_POST['valoresPrimeraColumna']) && isset($_POST['valoresSegundaColumna']) ){

//     $id = $_POST['id'];
//     $valoresPrimeraColumna = $_POST['valoresPrimeraColumna'];
//     $valoresSegundaColumna = $_POST['valoresSegundaColumna'];
    
//     $sql = "CALL SP_actualizarEspeciales( ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)";
//     if ($stmt = $conexion->prepare($sql)) {
        # $valoresPrimeraColumna son los datos que se ingresaron en la columna "1" la cual contiene el dato de cada ingrediente (Los que podran ser modificados)
        # $valoresUltimaColumna son los datos que se ingresaron en la columna "observaciones" la cual es de tipo string

        # Pregunta: El orden de los parametros deberia de importar, porque en el query de la base de datos el primer parametro que recibe es el cereal, pero en la tabla es el aceite
        // $stmt->bind_param('dddddddssssssss', $valoresPrimeraColumna[0],$valoresPrimeraColumna[1],$valoresPrimeraColumna[2],$valoresPrimeraColumna[3],$valoresPrimeraColumna[4],$valoresPrimeraColumna[5],$valoresPrimeraColumna[6],$valoresSegundaColumna[0],$valoresSegundaColumna[1],$valoresSegundaColumna[2],$valoresSegundaColumna[3],$valoresSegundaColumna[4],$valoresSegundaColumna[5],$valoresSegundaColumna[6],$id);

        // if ($stmt->execute()) {
        //     header('Content-Type: application/json');
        //     $data_json = json_encode(["message" => "Data saved successfully"]);
        //     var_dump($data_json);
//            echo json_encode(["message" => "Data saved successfully"]); # retorna un json confirmado un guardado exitoso
//         } else {
//             throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
//         }
//     }else {
//         echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
//     }
// }else {
//     echo json_encode(['error' => "Faltan parámetros en la solicitud"]);
// }