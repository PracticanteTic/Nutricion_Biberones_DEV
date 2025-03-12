<?php
include ('../config/Conexion.php');
//libreria de conexion a la base
$tipo_formula_id=$_POST['formula'];

  $sql = "SELECT * from nombre_formula WHERE id_tipo_formula ='$tipo_formula_id'";  
  
  $ejecutar=mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

  $cadena="<label>select2 (nombresFormulas)</label>
        <select id='lista2' name='lista2'>";

        foreach($ejecutar as $opciones):
            $cadena=$cadena.'<option value='.$opciones['id'].'>'.($opciones['nombre_formula']).'</option>';
        endforeach;
        echo $cadena."</select>";

?>




