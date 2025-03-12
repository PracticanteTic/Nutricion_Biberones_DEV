<?php
include('../config/Conexion.php');


$episodio = 0;
if(isset($_POST['episodioInput'])){
    $episodio = $_POST['episodioInput'];
}


/*
$query1 = "SELECT 1 as `result` FROM `solicitudes_especiales` WHERE `episodio`= $episodio AND DATE(`fecha_modificacion`) = CURDATE()";

$result = mysqli_query($conexion,$query1);
$fila = mysqli_fetch_assoc($result);

$exist = 0;
if(isset($fila['result'])){
    $exist = $fila['result'];
}*/

$exist = 0;
if($exist == 0){
    
       
    $nombre_apellido = $_POST['nombre_apellido'];
    $identificacion = $_POST['identificacion'];
    $servicio_hospitalizacion=$_POST['servicios_hospitalizacion'];
    $cama=$_POST['cama'];
    $fecha_nacimiento=$_POST['fecha_nacimiento'];
    $cuchara=$_POST['cuchara'];
    $numero_biberones=$_POST['numero_biberones'];
    $volumen_biberones=$_POST['volumen_biberon'];
    $cereal=$_POST['cereal']; 
    $cereal_observaciones=$_POST['cereal_observaciones'];
    $aceite=$_POST['aceite']; 
    $aceite_obervaciones=$_POST['aceite_observaciones'];
    $procrill=$_POST['procrill']; 
    $procrill_observaciones=$_POST['procrill_observaciones'];
    $nessugar=$_POST['nessugar']; 
    $nessugar_observaciones=$_POST['nessugar_observaciones'];
    $sal=$_POST['sal']; 
    $sal_observaciones=$_POST['sal_observaciones'];
    $formula=$_POST['formula'];
    $formula_observaciones=$_POST['formula_observaciones'];
    $otros=$_POST['otros']; 
    $otros_observaciones=$_POST['otros_observaciones'];
    $observaciones=$_POST['observaciones'];
    $select_nutricionista=$_POST['select_nutricionista'];
    $registro=$_POST['registro'];
    $tipo_formula=$_POST['tipo_formula'];
    $fecha_modificacion=$_POST['fechaActual'];
    $hora_modificacion=$_POST['reloj'];
    $user_registro=$_POST['user_registro'];
    $Unidad_Organizativa =$_POST['Unidad_Organizativa'];
    $chupo = $_POST['chupo'];

    $sala=2;

    if(empty($cereal)){$cereal = 0;}
    if(empty($aceite)){$aceite = 0;}
    if(empty($procrill)){$procrill = 0;}
    if(empty($nessugar)){$nessugar = 0;}
    if(empty($sal)){$sal = 0;}
    if(empty($formula)){$formula = 0;}
    if(empty($otros)){$otros = 0;}




    $query="INSERT INTO `solicitudes_especiales`(`episodio`, `nombre_apellido`, `identificacion`, `servicio`, `cama`, `fecha_nacimiento`, `cuchara`, `numero_biberones`, `volumen_biberon`, `cereal`, `cereal_obsvc`, `aceite`, `aceite_obsvc`, `procrill`, `procrill_obsvc`, `nessugar`, `nessugar_obsvc`, `sal`, `sal_obsvc`, `formula`, `formula_obsvc`, `otros`, `otros_obsvc`, `observaciones`, `codigo_nutricionista`, `registro`, `id_tipo_formula`,`fecha_modificacion`, `hora_modificacion`,`user_registro`,`Unidad_Organizativa`) VALUES
    ($episodio,
    '$nombre_apellido',
    '$identificacion',
    '$servicio_hospitalizacion',
    '$cama',
    '$fecha_nacimiento',
    $cuchara,
    $numero_biberones,
    $volumen_biberones,
    $cereal,
    '$cereal_observaciones',
    $aceite,
    '$aceite_obervaciones',
    $procrill,
    '$procrill_observaciones',
    $nessugar,
    '$nessugar_observaciones',
    $sal,
    '$sal_observaciones',
    $formula,
    '$formula_observaciones',
    $otros,
    '$otros_observaciones',
    '$observaciones',
    $select_nutricionista,
    $registro,
    $tipo_formula,
    '$fecha_modificacion',
    '$hora_modificacion',
    '$user_registro',
    '$Unidad_Organizativa')";


      
    $result = $conexion->query($query);

}
else{
    ?>1<?php
}

?>
