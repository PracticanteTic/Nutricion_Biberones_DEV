<?php
if(isset($_POST['consultar'])){
    echo 2;
        $episodio = $_POST['episodio'];
        $query = "SELECT * FROM solicitudes_especiales where episodio = $episodio";


        $result_biberones = mysqli_query($conn, $query);
  
  
        while($row = mysqli_fetch_array($result_biberones)) { 
            $identificacion = $row['identificacion'];
            $nombre_apellido = $row['nombre_apellido'];
            $sala = $row['sala'];
            $cama = $row['cama'];
            $fecha_nacimiento = $row['fecha_nacimiento'];
            $cereal = $row['cereal'];
            $cereal_obsvc = $row['cereal_obsvc'];
            $aceite = $row['aceite'];
            $aceite_obsvc = $row['aceite_obsvc'];
            $procrill = $row['procrill'];
            $procrill_obsvc = $row['procrill_obsvc'];
            $nessugar = $row['nessugar'];
            $nessugar_obsvc = $row['nessugar_obsvc'];
            $sal = $row['sal'];
            $sal_obsvc = $row['sal_obsvc'];
            $formula = $row['formula'];
            $formula_obsvc = $row['formula_obsvc'];
            $otros = $row['otros'];
            $otros_obsvc = $row['otros_obsvc'];
  }
}
?> 