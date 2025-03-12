<?php
include('../config/Conexion.php');

$fechaUltimaSolicitud = "";

if(isset($_POST['table'])){
    $table = $_POST['table'];

    /*
  //Obtener la ultima fecha de solucitud de biberones.
  $query1 = "SELECT DATE_FORMAT(MAX(`fecha_ingreso`), '%d%m%Y') as `fechaUltimaSolicitud` FROM `tabla_biberones` WHERE `episodio`= $episodio";
  //Se obtiene la variable de la ultima fecha de la solitud.
  $result = mysqli_query($conexion,$query1);
  //Se realiza la condición para validar la ultima fecha de solicitud y la fecha actual.
  $fila = mysqli_fetch_assoc($result);
  $fechaUltimaSolicitud = $fila['fechaUltimaSolicitud'];
    strval($fechaUltimaSolicitud);
    //echo $fechaUltimaSolicitud;

    
  if ($fechaUltimaSolicitud == $fecha_actual){

    */
    $Sala = $table[0][1];
    $formula = "";
    //$query = "SELECT 1 as result FROM `solicitudes_stock` WHERE DATE(`Fecha`) = CURDATE() AND '$Sala' = Sala LIMIT 1";
    for($ii = 0; $ii < count($table[0]); $ii++){
      if(!isset($table[$ii][2])){break;}
      $formula = $table[$ii][2];
      if($formula == "biberones estériles" || $formula == "recolectores de leche materna"){
        $formula = "free";
      }
      
      $query = "SELECT 1 as result FROM `solicitudes_stock` WHERE DATE(`Fecha`) = CURDATE() AND '$Sala' = Sala AND Nombre_Stock = '$formula' LIMIT 1";
      $ans = mysqli_query($conexion, $query);
      $result = mysqli_fetch_array($ans);

      if(!isset($result['result'])){
      	$result['result'] = 0;
      }


      if($result['result']==1){
        break;
      }
    }
    if(!isset($result['result'])){
      $result['result'] = 0;
    }
    
    if(($result['result']==1)){
    ?><script> 
    
    Swal.fire({
              icon: 'warning',
              title: 'Esta sala ya realizo una solicitud de </script><?php echo $formula?><script>  el dia de hoy',
              showConfirmButton: false,
              timer: 5000  
          });
      setTimeout(function(){location.reload();}, 2000);
    
    </script><?php

  }else{ // si no es iigual que deje realizar el insert.

    for($ii = 0; $ii < count($table); $ii++){
      $Date = $table[$ii][0];
      $Sala = $table[$ii][1];
      $Stock = $table[$ii][2];
      $CC = $table[$ii][3];
      if($CC == "N/A"){
        $CC = 0;
      }
      $Amount = $table[$ii][4];
      $Comment = $table[$ii][5];
      $query = "INSERT INTO `solicitudes_stock`(`Fecha`, `Sala`, `Nombre_Stock`, `Cm_Cubicos`, `Cantidad`, `id_estado` , `Observacion`)
                VALUES ('$Date','$Sala','$Stock',$CC,$Amount,1,'$Comment')";

      $result = $conexion->query($query);
    }
    ?>
    <script>

      Swal.fire({
        icon: 'success',
        title: 'Se realizo la solicitud Stock',
        showConfirmButton: false,
        timer: 1500  
      });
      setTimeout(function(){location.reload();}, 2000);
    </script>
    <?php
    //echo $query;
  }

}       
          


    
    

    
            
  // header('location: ../view/tabla_biberones.php');


?>