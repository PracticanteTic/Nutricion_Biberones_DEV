<script>
<?php
include('../config/Conexion.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $episodio = $_POST['episodeInput'];
    if($episodio != 0 && $episodio != ''){
    

        //$query = "SELECT `numero_cc`, `numero_biberones`, `id_chupo`, `id_chupo` FROM `tabla_biberones` WHERE `episodio` = ".$episodio;
        //SELECT `sala` FROM `sala` WHERE `id` IN (SELECT `id_sala` FROM `tabla_biberones` WHERE `episodio` = 39)

        //First ROW - Oldest Date
        $completeQuery = "SELECT `id_tipo_formula`, `numero_cc`, `numero_biberones`, `id_chupo`, `observaciones` FROM `tabla_biberones` WHERE `episodio` = '$episodio'";
        
        //Last ROW - Most Recent Date
        //$completeQuery = "SELECT * FROM `tabla_biberones` WHERE `episodio` = '$episodio' AND `fecha_ingreso` = (SELECT MAX(`fecha_ingreso`) FROM `tabla_biberones`)";
        
        $result = mysqli_query($conexion, $completeQuery);
        $SQLInfo= mysqli_fetch_assoc($result);

        //findKeysArray($SQLInfo);


        if(!is_null($SQLInfo)){
            
            if(array_key_exists('id_tipo_formula', $SQLInfo) && !is_null($SQLInfo['id_tipo_formula'])){
                ?>
                document.getElementById("tipo_formula").value = '<?php echo $SQLInfo["id_tipo_formula"] ?>'; 
                document.getElementById("centimetrosCubicos").value = '<?php echo $SQLInfo["numero_cc"] ?>';   
                document.getElementById("biberones").value = '<?php echo $SQLInfo["numero_biberones"]?>'; 
                document.getElementById("chupo").value = '<?php echo $SQLInfo["id_chupo"]?>';
                document.getElementById("observaciones").value = '<?php echo $SQLInfo["observaciones"]?>';
        
                <?php
            }

        }else{
            ?>
                document.getElementById("renovar_formula").checked = false;
                Swal.fire({
                    icon: 'warning',
                    title: 'No existe formula para renovar',
                    showConfirmButton: false,
                    timer: 1500 
                });
                
            <?php
        }
    
    }

} 

?>
</script>