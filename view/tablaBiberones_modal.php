
<?php 

include '../config/Conexion.php';

 header('Content-Type: application/json'); // Especificamos que queremos retornar JSON
 $action = $_POST['action'];
 if(isset($_POST['Episodio']) && $action == 'consultar') { 
     $episodio = $_POST['Episodio']; // Recuperamos el valor del episodio que nos manda el AJAX

     $sql = "SELECT id_biberon ,episodio, nombre_apellido, fecha_modificacion, numero_biberones, tb.id_tipo_formula, tf.nombre_formula 
     FROM tabla_biberones tb INNER JOIN tipo_formula tf 
     ON tb.`id_tipo_formula` = tf.id 
     WHERE episodio = ? 
     AND id_estado = 4 
     AND DATE(fecha_ingreso) = CURDATE()"; // Guardamos la consulta SQL en una variable

     if ($stmt = $conexion->prepare($sql)) {
         // Vincula ambos par�metros
         $stmt->bind_param("s", $episodio); // Asignamos los parámetros (s es string, se pone una por cada par�metro)

         if ($stmt->execute()) {
             $result = $stmt->get_result(); // Obtenemos los resultados de la consulta

             $data = array();  // Creamos un array
             if ($result->num_rows > 0) {
                 while($fila = $result->fetch_assoc()) { // Convertimos el resultado en un array asociativo y lo guardamos en $fila
                     $data[] = $fila; 
                 }
             }

             // Aseg�rate de que la salida es JSON
             echo json_encode($data);
         } else {
             echo json_encode(array("error" => "Error en la ejecución de la consulta: " . $stmt->error));
         }

         $stmt->close();
     } else {
         echo json_encode(array("error" => "Error en la preparación de la consulta: " . $conexion->error));
     }
 } else {
    //comprobamos si existe el episodio que trae el POST y si la accion es insertar
     if ($action == 'insertar' && isset($_POST['Episodio']) && isset($_POST['Fecha_solicitud']) && isset($_POST['Cantidad_cancelar']) && isset($_POST['Cantidad_solicitados']) && isset($_POST['Nombre_paciente']) && isset($_POST['Fecha_cancelacion'])) { 
        //obtenemos los valores que nos manda el AJAX (mediante $_POST[])
        $episodio = $_POST['Episodio']; 
        $idBiberon = $_POST['id_biberon']; 
         $nombrePaciente = $_POST['Nombre_paciente']; 
         $fechaUltimaSolicitud = $_POST['Fecha_solicitud']; 
         $cantidadCancelar = $_POST['Cantidad_cancelar']; 
         $fechaCancelacion = $_POST['Fecha_cancelacion']; 
         $cantidadSolicitados = $_POST['Cantidad_solicitados']; 
         $usuario = $_POST['nombreUsuario'];
         $id_formula = $_POST['id_formula'];

         //hacemos una consulta a bd para verificar si el episodio tiene cancelaciones hechas en el dia actual 
         $sqlCheck = "SELECT COUNT(*) AS cancelaciones FROM tbl_cancelaciones_biberones 
         WHERE episodio = ? 
         AND DATE(fecha_ingre_cancelacion) = CURDATE()";
         
         //hacemos la consulta y mandamos el parametro
         if ($stmtCheck = $conexion->prepare($sqlCheck)) {
            $stmtCheck->bind_param("i", $episodio);

            //ejecutamos la consulta
            if ($stmtCheck->execute()) {
                $resultCheck = $stmtCheck->get_result();
                $row = $resultCheck->fetch_assoc();
                $cancelacionesHoy = $row['cancelaciones'];
                $stmtCheck->close();
                if ($cancelacionesHoy > 0) { //validamos si tiene cancelaciones hechas el dia de hoy (solo puede tener 1 cancelacion al dia)
                    // Ya hay una cancelaci�n hoy para el episodio
                    echo json_encode(['error' => "Ya se encuentran registrados los biberones cancelados para este paciente el dia de hoy."]);
                } else { //si no tiene cancelaciones hechas, realizamos la cancelacion
                    $sql = "INSERT INTO `tbl_cancelaciones_biberones` 
                    (`id_biberon`,`episodio`, `nombre_paciente`, `cantidad_solicitada`, `cantidad_cancelada`, `usuario_ingre_cancelacion`, `fecha_solicitud`, `fecha_ingre_cancelacion`, `id_formula`) 
                    VALUES 
                    (?, ?, ?, ?, ?, ?, ?,?,?)"; 
                    if ($stmt = $conexion->prepare($sql)) {
                        // Vinculamos los par�metros (s = string, i = integer)
                        $stmt->bind_param("sssssssss",$idBiberon, $episodio, $nombrePaciente, $cantidadSolicitados, $cantidadCancelar, $usuario,$fechaUltimaSolicitud, $fechaCancelacion, $id_formula);               
                        if ($stmt->execute()) {
                            $respuesta = "funciono";
                            // Enviamos respuesta en formato JSON
                            echo json_encode(['respuesta' => $respuesta]);
                        } else {
                            echo json_encode(['error' => "Error en la ejecuci�n de la consulta: " . $stmt->error]);
                        }
               
                        $stmt->close();
                    } else {
                        echo json_encode(['error' => "Error en la preparaci�n de la consulta: " . $conexion->error]);
                    }
                }
            }
         }
     } else {
         echo json_encode(['error' => "Faltan par�metros en la solicitud"]);
     }
 }




