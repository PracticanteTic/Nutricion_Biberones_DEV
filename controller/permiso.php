<?php 
require_once "../model/Permiso.php"; // Usa el modelo de "Permiso" para instanciar un objeto del mismo

$permiso=new Permiso();

// En la URL de la solicitud se recibe un parametro nombrado "op" cuyo valor será la accion a realizar (listar, insertar, modificar...)
switch ($_GET["op"]){ // Evalua segun sea el caso
	
	case 'listar':
		$rspta=$permiso->listar();
 		//Vamos a declarar un array para almacenar los nombres de todos los "permisos" que se obtengan de la ejecucion sql
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array( // Array asociativo con clave "0" y su valor es el nombre del permiso
 				"0"=>$reg->nombre
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data); //enviamos los datos como tal
 		echo json_encode($results); // Convierte el array PHP en una cadena JSON

	break;
}
?>