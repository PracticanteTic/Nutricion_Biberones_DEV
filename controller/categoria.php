<?php 
require_once "../model/Categoria.php";

$categoria=new Categoria();

$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcategoria)){
			$rspta=$categoria->insertar($nombre,$descripcion);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$categoria->editar($idcategoria,$nombre,$descripcion);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$categoria->desactivar($idcategoria);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'activar':
		$rspta=$categoria->activar($idcategoria);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
	break;

	case 'mostrar':
		$rspta=$categoria->mostrar($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$categoria->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fas fa-edit"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->idcategoria.')"><i class="far fa-times-circle"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fas fa-edit"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->descripcion,
 				"3"=>($reg->condicion)?'<span class="label bg-blue">ACTIVADO</span>':
 				'<span class="label bg-red">DESACTIVADO</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>