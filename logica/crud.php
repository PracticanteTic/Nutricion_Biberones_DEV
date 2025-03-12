<?php
include('../config/Conexion.php');

$fechaUltimaSolicitud = "";


  date_default_timezone_set('America/Bogota');
  $fecha_actual = date("dmY");
  $episodio = $_POST['episodio'];
  $identificacion = $_POST['identificacion'];
  $Sala=$_POST['sala'].' - '.$_POST['cama'];
  //$Sala=$_POST['sala'];
  $tipo_formula= $_POST['tipo_formula'];
  $centimetrosCubicos = $_POST['centimetrosCubicos'];
  $biberones = $_POST['biberones'];
  $fecha_ingreso=$_POST['fechaActual'];
  $hora_ingreso=$_POST['reloj'];
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $chupo = $_POST['chupo'];
  $nombre_apellido = $_POST['nombre_apellido'];
  $observaciones = $_POST['observaciones'];
  $user_registro=$_POST['user_registro'];
  $typeRequest = $_POST['tipo_Solicitud'];
  $especial = $_POST['especial'];
  $Unidad_Organizativa = $_POST['Unidad_Organizativa'];

  switch($typeRequest){
      case "addFormula":
          //Obtener la ultima fecha de solucitud de biberones.
          $query1 = "SELECT COUNT(*) as `result` FROM `tabla_biberones` WHERE `episodio`= $episodio AND `id_estado` <> 4 AND `fecha_ingreso` = CURRENT_DATE() AND `id_tipo_formula` = $tipo_formula AND `Especial` = $especial";
          //Se obtiene la variable de la ultima fecha de la solitud.
          $result = mysqli_query($conexion,$query1);
          //Se realiza la condiciÃ³n para validar la ultima fecha de solicitud y la fecha actual.
          $fila = mysqli_fetch_assoc($result);
            //echo $fechaUltimaSolicitud;

	  if(!isset($fila['result'])){
            $fila['result'] = 0;
          }
            
          if ($fila['result'] == 3){// Si percibe dos fórmulas iguales a ese mismo paciente, a la tercera que se le realice no va a dejar ya que el paciente cumple con el máximo de fórmulas ingresadas.
                                    // Cabe aclarar que esto es dependiendo de la fecha actual.
            ?><script> 
            
            Swal.fire({
                      icon: 'warning',
                      title: 'El paciente ya cuenta con una solicitud de biberones de esta formula el dia de hoy',
                      showConfirmButton: false,
                      timer: 5000  
                  });
              setTimeout(function(){location.reload();}, 2000);
            
            </script><?php

          }else{ // si no es iigual que deje realizar el insert.


            $query = "INSERT INTO `tabla_biberones`(`episodio`, `identificacion`, `numero_cc`, `numero_biberones`, `fecha_nacimiento`, `nombre_apellido`, `fecha_ingreso`, `hora_ingreso`, `fecha_modificacion`, `observaciones`, `sala`, `id_chupo`, `id_estado`, `id_tipo_formula`, `user_registro`, `Especial`,`Unidad_Organizativa`) VALUES($episodio,'$identificacion', '$centimetrosCubicos', '$biberones', '$fecha_nacimiento','$nombre_apellido', '$fecha_ingreso', '$hora_ingreso', NOW(), '$observaciones', '$Sala', '$chupo',5,'$tipo_formula','$user_registro', $especial, '$Unidad_Organizativa')";
            $result = $conexion->query($query);
            ?>
            <script>
              Swal.fire({
                icon: 'success',
                title: 'Registro Exitoso',
                showConfirmButton: false,
                timer: 1500  
              });
              setTimeout(function(){location.reload();}, 2000);
            </script>
            <?php
            //echo $query;
          }


      break;

      case "editFormula":

        $old_Formula = $_POST['old_Formula'];

        $query = "UPDATE `tabla_biberones` SET `numero_cc` = '$centimetrosCubicos', `numero_biberones` = '$biberones', `fecha_modificacion` = CURDATE(), `observaciones` = '$observaciones', `id_chupo` = '$chupo', `id_estado` = 5, `id_tipo_formula` = '$tipo_formula', `user_registro` = '$user_registro' WHERE `episodio`= $episodio AND `id_estado` <> 4 AND `fecha_ingreso` = CURRENT_DATE() AND `id_tipo_formula` = $old_Formula AND `Especial` = $especial";
          $result = $conexion->query($query);
        ?>
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Cambio realizado con exito',
            showConfirmButton: false,
            timer: 1500  
          });
          setTimeout(function(){location.reload();}, 2000);
        </script>
        <?php

      break;
      
      case "renovateFormula":

        $old_Formula = $_POST['old_Formula'];
        //Obtener la ultima fecha de solucitud de biberones.
        $query1 = "SELECT 1 as `result` FROM `tabla_biberones` WHERE `episodio`= $episodio AND `id_estado` <> 4 AND `fecha_ingreso` = CURRENT_DATE() AND `id_tipo_formula` = $old_Formula AND `Especial` = $especial";
        //Se obtiene la variable de la ultima fecha de la solitud.
        $result = mysqli_query($conexion,$query1);
        //Se realiza la condiciÃ³n para validar la ultima fecha de solicitud y la fecha actual.
        $fila = mysqli_fetch_assoc($result);
          //echo $fechaUltimaSolicitud;
          
	if(!isset($fila['result'])){
            $fila['result'] = 0;
        }

        if ($fila['result'] == 1){
          ?><script> 
          
          Swal.fire({
                    icon: 'warning',
                    title: 'El paciente ya renovo esta formula',
                    showConfirmButton: false,
                    timer: 5000  
                });
            setTimeout(function(){location.reload();}, 2000);
          
          </script><?php

        }else{ // si no es iigual que deje realizar el insert.


                    $query = "INSERT INTO `tabla_biberones`(`episodio`, `identificacion`, `numero_cc`, `numero_biberones`, `fecha_nacimiento`, `nombre_apellido`, `fecha_ingreso`, `hora_ingreso`, `fecha_modificacion`, `observaciones`, `sala`, `id_chupo`, `id_estado`, `id_tipo_formula`, `user_registro`, `Especial`, `Unidad_Organizativa`) VALUES($episodio,'$identificacion', '$centimetrosCubicos', '$biberones', '$fecha_nacimiento','$nombre_apellido', '$fecha_ingreso', '$hora_ingreso', NOW(), '$observaciones', '$Sala', '$chupo',5,'$tipo_formula','$user_registro', '$especial','$Unidad_Organizativa')";
          $result = $conexion->query($query);

          if($especial == 1){
            $query2 = "INSERT INTO `solicitudes_especiales`(`episodio`, `nombre_apellido`, `identificacion`, `servicio`, `cama`, `fecha_nacimiento`, `cuchara`, `numero_biberones`, `volumen_biberon`, `cereal`, `cereal_obsvc`, `aceite`, `aceite_obsvc`, `procrill`, `procrill_obsvc`, `nessugar`, `nessugar_obsvc`, `sal`, `sal_obsvc`, `formula`, `formula_obsvc`, `otros`, `otros_obsvc`, `observaciones`, `codigo_nutricionista`, `registro`, `id_tipo_formula`,`fecha_modificacion`, `hora_modificacion`,`user_registro`,`Unidad_Organizativa`) SELECT `episodio`, `nombre_apellido`, `identificacion`, `servicio`, `cama`, `fecha_nacimiento`, `cuchara`, `numero_biberones`, `volumen_biberon`, `cereal`, `cereal_obsvc`, `aceite`, `aceite_obsvc`, `procrill`, `procrill_obsvc`, `nessugar`, `nessugar_obsvc`, `sal`, `sal_obsvc`, `formula`, `formula_obsvc`, `otros`, `otros_obsvc`, `observaciones`, `codigo_nutricionista`, `registro`, `id_tipo_formula`, CURDATE(), `hora_modificacion`,`user_registro` FROM solicitudes_especiales WHERE episodio = $episodio AND fecha_modificacion = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND id_tipo_formula = $tipo_formula";
            $result2 = $conexion->query($query2);
          }

          ?>
          <script>
            Swal.fire({
              icon: 'success',
              title: 'Registro Exitoso',
              showConfirmButton: false,
              timer: 1500  
            });
            setTimeout(function(){location.reload();}, 2000);
          </script>
          <?php
          //echo $query;
        }
        
      break;

      case "cancelFormula":
        
        $old_Formula = $_POST['old_Formula'];

        $query = "UPDATE `tabla_biberones` SET `id_estado` = 4 WHERE `episodio`= $episodio AND `id_estado` <> 4 AND `fecha_ingreso` = CURRENT_DATE() AND `id_tipo_formula` = $old_Formula AND `Especial` = $especial";
          $result = $conexion->query($query);
        ?>
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Solicitud de biberones cancelada exitosamente',
            showConfirmButton: false,
            timer: 1500  
          });
          setTimeout(function(){location.reload();}, 2000);
        </script>
        <?php
      break;



  }
  

          
          


    
    

    
            
  // header('location: ../view/tabla_bib     erones.php');


?>