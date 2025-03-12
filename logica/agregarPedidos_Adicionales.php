<?php
include('../config/Conexion.php');
 
     //   $fechaUltimaSolicitud = "";


date_default_timezone_set('America/Bogota');
$fecha_actual = date("dmY");
if (isset($_POST['especial'])) {
        $especial = $_POST['especial'];
    } else {
        $especial = 0; // O maneja el caso de valor no definido
    }
$episodio = $_POST['episodioInput'];
$identificacion = $_POST['identificacion'];
$nombre_apellido = $_POST['nombre_apellido'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$hora_inicio=$_POST['reloj'];
$biberones = $_POST['numero_biberones'];
$numero_cc = $_POST['numero_cc'];
$sala=$_POST['sala'];
$Unidad_Organizativa=$_POST['Unidad_Organizativa'];
$todayTime = date("H");

$tipo_formula = -1;
if(isset($_POST['tipo_formula']) && $_POST['tipo_formula'] != ""){
        $tipo_formula = $_POST['tipo_formula'];
}

$old_Formula = -1;
if(isset($_POST['old_Formula']) && $_POST['old_Formula'] != ""){
        $old_Formula = $_POST['old_Formula'];
}

$tipo_solicitud=$_POST['tipo_solicitud'];

$chupo = -1;
if(isset($_POST['chupo']) && $_POST['chupo'] != ""){
        $chupo = $_POST['chupo'];
}

$fecha_hoy = date("dmY");
$observaciones = $_POST['observaciones'];
$cama = $_POST['cama'];
$user_registro= $_POST['user_registro'];
$fecha_actualForm = $_POST['fechaActual'];
$query = "SELECT DATE_FORMAT(MAX(`fecha_actual`), '%d%m%Y') as `fechaUltimaSolicitud` FROM `solicitudes_adicionales` WHERE `episodio`= $episodio";
$result = mysqli_query($conexion,$query);
$fila = mysqli_fetch_assoc($result);
$fechaUltimaSolicitud = $fila['fechaUltimaSolicitud'];
strval($fechaUltimaSolicitud);


//SELECT IFNULL(1 , 0) as `result` FROM `solicitudes_adicionales` WHERE `episodio`= 56 AND `id_tipo_solicitud` = 1

        switch ($tipo_solicitud){
                case 1:
                        $query1 = "SELECT 1 as `result` FROM  `tabla_biberones` WHERE `episodio`= $episodio AND id_tipo_formula = $tipo_formula AND Adicional = 1 AND id_estado <> 4 AND DATE(fecha_ingreso) = CURDATE()"; //Adicion

                        $result = mysqli_query($conexion,$query1);
                        $fila = mysqli_fetch_assoc($result);

                        $Adicion = 0;
                        if(isset($fila['result'])){
                                $Adicion = $fila['result'];
                        }

                        if($Adicion == 0){ 

                                save();
                                $I = 'success';
                                $m = 'Formula adicionada exitosamente';
                                notify($I, $m);
                        }
                        else{
                                $I = 'warning';
                                $m = 'Este episodio ya cuenta con una adicion de esta formula el dia de hoy';
                                notify($I, $m);
                        }
                break;
                case 2:  // INNACTIVE currently, since it makes no real sense to change adicional
                        $query2 = "SELECT 1 as `result` FROM `solicitudes_adicionales` WHERE `episodio`= $episodio AND `id_tipo_solicitud` = 2 AND DATE(fecha_actual) = CURDATE()"; //Cambio

                        
                        $result2 = mysqli_query($conexion,$query2);

                        
                        $fila2 = mysqli_fetch_assoc($result2);

                        
                        $Cambio = 0;
                        if(isset($fila2['result'])){
                                $Cambio = $fila2['result'];
                        }

                        if($Cambio == 0){
                                save();
                                $I = 'success';
                                $m = 'Formula cambiada exitosamente';
                                notify($I, $m);
                        }
                        else{
                                $I = 'warning';
                                $m = 'Este episodio ya cuenta con un cambio el dia de hoy';
                                notify($I, $m);
                        }
                        
                break;
                case 3:
                        if($tipo_formula==-1 || $chupo == -1){  //THIS IF THE FORMULA DOESN'T EXIST OR ISN'T ACTIVE ON BIBERONES TABLE
                                $I = 'warning';
                                $m = 'El paciente no cuenta con formula que cancelar';
                                notify($I, $m);
                        }else{
                                save();
                                $I = 'success';
                                $m = 'Formula cancelada exitosamente';
                                notify($I, $m);

                        }
                break;
                default:
                        $I = 'danger';
                        $m = 'HOW DID YOU GOT HERE';
                        notify($I, $m);
                break;
        }
        

function notify($Icon, $Message){
        ?><script> 
                        
        Swal.fire({
                icon: '<?php echo $Icon?>',
                title: '<?php echo $Message?>',
                showConfirmButton: false,
                timer: 5000  
        });
        setTimeout(function(){location.reload();}, 2000);
        
        </script><?php
}

function save(){
       
        global $conexion,$episodio,$identificacion,$nombre_apellido,$fecha_nacimiento,$hora_inicio,$biberones,$numero_cc,$sala,$tipo_formula,$tipo_solicitud,$chupo,$observaciones,$cama,$fecha_actualForm,$user_registro, $old_Formula,$todayTime,$estadoSolicitud,$Unidad_Organizativa,$especial;

        $query = "CALL sp_InsertarSolicitudAdicional($episodio,'$identificacion','$nombre_apellido','$fecha_nacimiento','$hora_inicio',$biberones,$numero_cc,'$sala',$tipo_formula,$tipo_solicitud,$chupo,'$observaciones','$cama','$fecha_actualForm','$user_registro', '$old_Formula', '$Unidad_Organizativa')";

        $result = $conexion->query($query); 

        

        if($todayTime >= 7 && $todayTime <= 12 && $tipo_solicitud == 1)
        {
                 $estadoSolicitud = 5;
        
        }else if ($todayTime >= 13 && $todayTime <= 18 && $tipo_solicitud == 1)
        {
                 $estadoSolicitud = 7;
        }
        
        /*$query2 = "INSERT INTO `tabla_biberones`(`episodio`, `identificacion`, `numero_cc`, `numero_biberones`, `fecha_nacimiento`, `nombre_apellido`, `fecha_ingreso`, `hora_ingreso`, `fecha_modificacion`, `observaciones`, `sala`, `id_chupo`, `id_estado`, `id_tipo_formula`, `user_registro`, `Especial`, `Adicional`) VALUES ($episodio,'$identificacion',$numero_cc,$biberones,'$fecha_nacimiento', '$nombre_apellido','$fecha_actualForm','$hora_inicio','$fecha_actualForm','$observaciones','$sala',$chupo, $estadoSolicitud,$tipo_formula,'$user_registro', 0, 1)";
        $result2 = $conexion->query($query2);*/

        $query2 = "INSERT INTO `tabla_biberones`(`episodio`, `identificacion`, `numero_cc`, `numero_biberones`, `fecha_nacimiento`, `nombre_apellido`, `fecha_ingreso`, `hora_ingreso`, `fecha_modificacion`, `observaciones`, `sala`, `id_chupo`, `id_estado`, `id_tipo_formula`, `user_registro`, `Especial`, `Adicional`,  `Unidad_Organizativa`)VALUES ($episodio, '$identificacion', $numero_cc, $biberones, '$fecha_nacimiento', '$nombre_apellido', '$fecha_actualForm', '$hora_inicio', '$fecha_actualForm', '$observaciones', CONCAT('$sala', ' - ', '$cama'), $chupo, $estadoSolicitud, $tipo_formula, '$user_registro', $especial, 1,'$Unidad_Organizativa')";
        $result2 = $conexion->query($query2);  

}       

?>
