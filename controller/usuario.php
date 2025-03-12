<?php
if(session_id() === "") session_start();
require_once "../model/Usuario.php";


$usuario=new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
// $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		// if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		// {
		// 	$imagen=$_POST["imagenactual"];
		// }
		// else 
		// {
		// 	$ext = explode(".", $_FILES["imagen"]["name"]);
		// 	if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
		// 	{
		// 		$imagen = round(microtime(true)) . '.' . end($ext);
		// 		move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
		// 	}
		// }
		//Hash SHA256 en la contrase帽a
		$clavehash=hash("SHA256",$clave);

		if (empty($idusuario)){
			$rspta=$usuario->insertar($nombre,'','','',$telefono,$email,$cargo,$login,$clavehash,$_POST['permiso']);
			echo $rspta ? 1 : 2;
		}
		else {
			
			$rspta=$usuario->editar($idusuario,$nombre,$telefono,$email,$cargo,$login,$clave,$_POST['permiso']);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
	break;

	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->telefono,
 				"3"=>$reg->email,
 				"4"=>$reg->login,
 				
 				"5"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Informaci贸n para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'permisos':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../model/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();

		//Obtener los permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores=array();

		//Almacenar los permisos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idpermiso);
			}

		//Mostramos la lista de permisos en la vista y si est谩n o no marcados
		while ($reg = $rspta->fetch_object())
				{
					$sw=in_array($reg->idpermiso,$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
				}
	break;

	case 'directorioactivo':

		require_once '../lib/Lib.php';

		$library = new Lib("lib");
		$library->ldap();

		$user = $_POST['logina'];

		$clave = $_POST['clavea'];

		
		try {
			$da = new adLDAP();
		} catch (Exception $ex) {
			
		}
		

		$validation = $da->authenticate($user, $clave);

		if ($validation) {

			$result = $da->user()->info($user);

			
			
			//VERIFICAR QUE SOLO PERSONAL ESPECIFICO DEL HOSPITAL PUEDA ENTRAR AL APLICATIVO
			//if($result[0]['department'][0] == 'GESTION TIC'){


				//VERIFICA EL ROL QUE TENDRA LA PERSONA SEGUN EL GRUPO AL QUE PERTENEZCA EN DIRECTORIO ACTIVO
				//PARA ESTE APLICATIVO EN PARTICULAR LOS NOMBRES DE GRUPO DEBEN EMPEZAR CON "biberones"
				$cod_directorio="";
				try{
					for($ii = 0; $ii < count($result[0]['memberof']); $ii++){
						if(!isset($result[0]['memberof'][$ii])){break;}
						$text = $result[0]['memberof'][$ii];
						$textArray = explode(",", $text);
						$nameArray = explode("=", $textArray[0]);
						if(!isset($nameArray[1])){break;}
						$cod = $nameArray[1];
						$cod = strtolower($cod);
	
						if (strpos($cod, 'biberones') !== false) {
							$cod_directorio = $cod;
							break;
						}
					}
				}catch(Exception $e){

				}
				
				if($cod_directorio != ""){
					//$user = 'holamundo';
					//

					$_SESSION['nombre']= $result[0]['displayname'][0];
					$_SESSION['login'] = $user;


					//$rspta=$usuario->directoryVerificar($user);
					$rspta=$usuario->directoryRoleVerificar($cod_directorio);


					$fetch=$rspta->fetch_object();


					//$marcados = $usuario->listarmarcados($fetch->idusuario);
					$marcados = $usuario->listarRolePermisos($fetch->idpermiso);
				
					$valores=array();
			
					while ($per = $marcados->fetch_object())
					{
						array_push($valores, $per->idpermiso);
					}
		
					//ESCRITORIO
					in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
					//ALL OPTIONS OF REQUEST
					in_array(2,$valores)?$_SESSION['SolicitudesBiberones']=1:$_SESSION['SolicitudesBiberones']=0;
					//CONSOLIDADO ESPECIALES
					in_array(3,$valores)?$_SESSION['FormulasEspeciales']=1:$_SESSION['FormulasEspeciales']=0;
					//CONSOLIDADO ADICIONALES
					in_array(4,$valores)?$_SESSION['FormulasAdicionales']=1:$_SESSION['FormulasAdicionales']=0;
					//USUARIOS - PERMISOS
					in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
					//
					in_array(6,$valores)?$_SESSION['ayuda']=1:$_SESSION['ayuda']=0;
					//CONSOLIDADO BIBERONES
					in_array(7,$valores)?$_SESSION['FormulasPreparadas']=1:$_SESSION['FormulasPreparadas']=0;
					//
					in_array(8,$valores)?$_SESSION['PedidosAdicionales']=1:$_SESSION['PedidosAdicionales']=0;
					//SOLICTUD BIBERONES
					in_array(9,$valores)?$_SESSION['AgregarFormulaBiberones']=1:$_SESSION['AgregarFormulaBiberones']=0;
					//SOLICITUD STOCK
					in_array(10,$valores)?$_SESSION['AgregarFormulasPreparadas']=1:$_SESSION['AgregarFormulasPreparadas']=0;
					//SOLICITUD ADICIONALES
					in_array(11,$valores)?$_SESSION['AgregarPedidosAdicionales']=1:$_SESSION['AgregarPedidosAdicionales']=0;
					//SOLICITUD ESPECIALES
					in_array(12,$valores)?$_SESSION['AgregarFormulasEspeciales']=1:$_SESSION['AgregarFormulasEspeciales']=0;
					//ON CONSOLIDADO BIBERONES, WHO CAN SEE OPTION 1 (RECIBIDO - PROCESO - DISTRIBUCION)
					in_array(13,$valores)?$_SESSION['modificar_estado']=1:$_SESSION['modificar_estado']=0;
					//ON CONSOLIDADO BIBERONES, WHO CAN SEE OPTION 2 (ENTREGADO AM - PM)
					in_array(14,$valores)?$_SESSION['modificar_estadoNutricionista']=1:$_SESSION['modificar_estadoNutricionista']=0;
					//CONSOLIDADO STOCK
					in_array(15,$valores)?$_SESSION['Stock']=1:$_SESSION['Stock']=0;
					// CAN SEE THE ESTADO AND PRINTING BUTTONS, WHICH IS PREPARADORES AND NUTRICIONISTA
					in_array(16,$valores)?$_SESSION['Enfermera_Visual']=1:$_SESSION['Enfermera_Visual']=0;
					//BLOQUEA NUTRICIONISTA DE PODER MODIFICAR ESTADO EN TABLA BIBERONES
					in_array(17,$valores)?$_SESSION['NutricionistaEstado']=1:$_SESSION['NutricionEstado']=0;
                                        //ACCESO PARA INFORME DE SOLICITUDES
                                        in_array(18,$valores)?$_SESSION['reporteSolicitudes']=1:$_SESSION['reporteSolicitudes']=0;
					//ACCESO 贜ICAMENTE PARA PREPARADORES
					in_array(19,$valores)?$_SESSION['cancelarBiberones']=1:$_SESSION['cancelarBiberones']=0;

					
					
					echo 1;
				}else{
					echo 4;
				}
			/*
			}
			else{
				
				echo 3;
			}*/

		} else{
			echo 5;
		}

	break;

	case 'verificar':
		$logina=$_POST['logina'];
	    $clavea=$_POST['clavea'];

	    // Hash SHA256 en la contrase帽a
		$clavehash=hash("SHA256",$clavea);

		

		$rspta=$usuario->verificar($logina, $clavehash);

		$fetch=$rspta->fetch_object();

		if (isset($fetch))
	    {
	        //Declaramos las variables de sesi贸n
	        $_SESSION['idusuario']=$fetch->idusuario;
	        $_SESSION['nombre']=$fetch->nombre;
	        // $_SESSION['imagen']=$fetch->imagen;
	        $_SESSION['login']=$fetch->login;
			$_SESSION['clave']=$fetch->clave;
			$_SESSION['idmedico']=$fetch->idmedico;

	        //Obtenemos los permisos del usuario
	    	$marcados = $usuario->listarmarcados($fetch->idusuario);

	    	//Declaramos el array para almacenar todos los permisos marcados
			$valores=array();

			//Almacenamos los permisos marrhhrcados en el array
			while ($per = $marcados->fetch_object())
				{
					array_push($valores, $per->idpermiso);
				}

			//Determinamos los accesos del usuario
					//Determinamos los accesos del usuario
				


					//Determinamos los accesos del usuario
					in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
					in_array(2,$valores)?$_SESSION['SolicitudesBiberones']=1:$_SESSION['SolicitudesBiberones']=0;
					in_array(3,$valores)?$_SESSION['FormulasEspeciales']=1:$_SESSION['FormulasEspeciales']=0;
					in_array(4,$valores)?$_SESSION['FormulasAdicionales']=1:$_SESSION['FormulasAdicionales']=0;
					in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
					in_array(6,$valores)?$_SESSION['ayuda']=1:$_SESSION['ayuda']=0;
					in_array(7,$valores)?$_SESSION['FormulasPreparadas']=1:$_SESSION['FormulasPreparadas']=0;
					in_array(8,$valores)?$_SESSION['PedidosAdicionales']=1:$_SESSION['PedidosAdicionales']=0;
					in_array(9,$valores)?$_SESSION['AgregarFormulaBiberones']=1:$_SESSION['AgregarFormulaBiberones']=0;
					in_array(10,$valores)?$_SESSION['AgregarFormulasPreparadas']=1:$_SESSION['AgregarFormulasPreparadas']=0;
					in_array(11,$valores)?$_SESSION['AgregarPedidosAdicionales']=1:$_SESSION['AgregarPedidosAdicionales']=0;
					in_array(12,$valores)?$_SESSION['AgregarFormulasEspeciales']=1:$_SESSION['AgregarFormulasEspeciales']=0;
					in_array(13,$valores)?$_SESSION['modificar_estado']=1:$_SESSION['modificar_estado']=0;
					in_array(14,$valores)?$_SESSION['modificar_estadoNutricionista']=1:$_SESSION['modificar_estadoNutricionista']=0;
					in_array(15,$valores)?$_SESSION['Stock']=1:$_SESSION['Stock']=0;
					in_array(16,$valores)?$_SESSION['Enfermera_Visual']=1:$_SESSION['Enfermera_Visual']=0;
					in_array(17,$valores)?$_SESSION['NutricionistaEstado']=1:$_SESSION['NutricionEstado']=0;
                                        in_array(18,$valores)?$_SESSION['reporteSolicitudes']=1:$_SESSION['reporteSolicitudes']=0;
					//ACCESO 贜ICAMENTE PARA PREPARADORES
					in_array(19,$valores)?$_SESSION['cancelarBiberones']=1:$_SESSION['cancelarBiberones']=0;
											

					
			// entre a la reunion en meet
			
	    }

	    $respuestajson = json_encode($fetch);

		if($respuestajson == "null"){
			echo 2;
		}else{
			echo 1;
		}


	break;

	case 'googleLogin':
		$email=$_SESSION['user_email_address'];
	
		$rspta=$usuario->googleVerificar($email);
	
		$fetch=$rspta->fetch_object();
	
		if (isset($fetch))
		{
			//Declaramos las variables de sesi贸n
			$_SESSION['nombre']= $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'];
			//Declaramos las variables de sesi贸n
			$_SESSION['idusuario']=$fetch->id_usuario_google;

			$rspta2=$usuario->GoogleRoleVerificar($fetch->id_rol);

			$fetch2=$rspta2->fetch_object();
	
			//Obtenemos los permisos del usuario
			$marcados = $usuario->listarRolePermisos($fetch2->idpermiso);
	
			//Declaramos el array para almacenar todos los permisos marcados
			$valores=array();
	
			//Almacenamos los permisos marrhhrcados en el array
			while ($per = $marcados->fetch_object())
				{
					array_push($valores, $per->idpermiso);
				}
	
			//Determinamos los accesos del usuario
					//Determinamos los accesos del usuario
				
	
	
					//Determinamos los accesos del usuario
					in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
					in_array(2,$valores)?$_SESSION['SolicitudesBiberones']=1:$_SESSION['SolicitudesBiberones']=0;
					in_array(3,$valores)?$_SESSION['FormulasEspeciales']=1:$_SESSION['FormulasEspeciales']=0;
					in_array(4,$valores)?$_SESSION['FormulasAdicionales']=1:$_SESSION['FormulasAdicionales']=0;
					in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
					in_array(6,$valores)?$_SESSION['ayuda']=1:$_SESSION['ayuda']=0;
					in_array(7,$valores)?$_SESSION['FormulasPreparadas']=1:$_SESSION['FormulasPreparadas']=0;
					in_array(8,$valores)?$_SESSION['PedidosAdicionales']=1:$_SESSION['PedidosAdicionales']=0;
					in_array(9,$valores)?$_SESSION['AgregarFormulaBiberones']=1:$_SESSION['AgregarFormulaBiberones']=0;
					in_array(10,$valores)?$_SESSION['AgregarFormulasPreparadas']=1:$_SESSION['AgregarFormulasPreparadas']=0;
					in_array(11,$valores)?$_SESSION['AgregarPedidosAdicionales']=1:$_SESSION['AgregarPedidosAdicionales']=0;
					in_array(12,$valores)?$_SESSION['AgregarFormulasEspeciales']=1:$_SESSION['AgregarFormulasEspeciales']=0;
					in_array(13,$valores)?$_SESSION['modificar_estado']=1:$_SESSION['modificar_estado']=0;
					in_array(14,$valores)?$_SESSION['modificar_estadoNutricionista']=1:$_SESSION['modificar_estadoNutricionista']=0;
					in_array(15,$valores)?$_SESSION['Stock']=1:$_SESSION['Stock']=0;
					in_array(16,$valores)?$_SESSION['Enfermera_Visual']=1:$_SESSION['Enfermera_Visual']=0;
					in_array(17,$valores)?$_SESSION['NutricionistaEstado']=1:$_SESSION['NutricionEstado']=0;
                                        in_array(18,$valores)?$_SESSION['reporteSolicitudes']=1:$_SESSION['reporteSolicitudes']=0;
					//ACCESO 贜ICAMENTE PARA PREPARADORES
					in_array(19,$valores)?$_SESSION['cancelarBiberones']=1:$_SESSION['cancelarBiberones']=0;
					
	
					
			// entre a la reunion en meet
			
		}
		$respuestajson = json_encode($fetch);
	
		if(!($respuestajson == "null")){
			header('location:escritorio.php');
		}
	
	
	break;

	case 'salir':

		if(isset($_SESSION['access_token'])){

			include('../googleConfig.php');

			//Reset OAuth access token
			$client->revokeToken();
		}

		//Limpiamos las variables de sesi贸n   
        session_unset();
        //Destru矛mos la sesi贸n
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");

	break;
}




?>

	

