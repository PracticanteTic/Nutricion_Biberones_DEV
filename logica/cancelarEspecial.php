<script>
<?php

include '../config/Conexion.php';

$Episodio = isset($_POST["episode"]) ? $_POST["episode"] : "";

$query = "UPDATE `solicitudes_especiales` SET `Vigente` = 0 WHERE `episodio` = '$Episodio'";

$result = $conexion -> query($query);

$deleted = false;

if ($result) {
    $deleted = true;
}

if($deleted){
    ?>
        Swal.fire({
            icon: 'success',
            title: 'Las formulas especiales han sido anuladas',
            showConfirmButton: false,
            timer: 1500 
        });
        
    <?php
}
else{
    ?>
        Swal.fire({
            icon: 'error',
            title: 'Las formulas especiales no se lograron anular',
            showConfirmButton: false,
            timer: 1500 
        });
        
    <?php
}


?>
</script>