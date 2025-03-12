<script>
<?php
include('../config/Conexion.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $episodio = $_POST['episodeInput'];
    switch($_POST['type']){

        case "add":
            ?>
            container = document.getElementById("div_Old_Formula");
            container.setAttribute("hidden", true);
            document.getElementById("old_Formula").removeAttribute("required");
            <?php
        break;

        case "cancel":
            if($episodio != 0 && $episodio != ''){
    

                //$query = "SELECT `numero_cc`, `numero_biberones`, `id_chupo`, `id_chupo` FROM `tabla_biberones` WHERE `episodio` = ".$episodio;
                //SELECT `sala` FROM `sala` WHERE `id` IN (SELECT `id_sala` FROM `tabla_biberones` WHERE `episodio` = 39)
        
                //First ROW - Oldest Date
                $completeQuery = "SELECT `id_tipo_formula`, `nombre_formula`, `Adicional` FROM `tabla_biberones` INNER JOIN tipo_formula WHERE id_tipo_formula = id AND `episodio` = '$episodio' AND `id_estado` <> 4 AND DATE(fecha_ingreso) = CURDATE()";
                
                //Last ROW - Most Recent Date 
                //$completeQuery = "SELECT * FROM `tabla_biberones` WHERE `episodio` = '$episodio' AND `fecha_ingreso` = (SELECT MAX(`fecha_ingreso`) FROM `tabla_biberones`)";
                
                $SQLInfo = mysqli_query($conexion, $completeQuery);
                $SQLarray = mysqli_fetch_assoc($SQLInfo);
        
                //findKeysArray($SQLInfo);
        
        
                if(!is_null($SQLInfo) && isset($SQLarray['id_tipo_formula'])){
                    ?>

                    document.getElementById("div_Old_Formula").removeAttribute("hidden");
                    oldFormula = document.getElementById("old_Formula");
                    oldFormula.setAttribute("required", "");

                    var i, L = oldFormula.options.length - 1;
                    for(i = L; i >= 0; i--) {
                        oldFormula.remove(i);
                    }

                    var placeH = document.createElement('option');
                    placeH.value = "";
                    placeH.innerHTML = "Seleccione la formula a cancelar";
                    placeH.selected = true;
                    placeH.hidden = true;
                    oldFormula.appendChild(placeH);

                    <?php  foreach($SQLInfo as $opciones): ?>
                    var opt = document.createElement('option');
                    opt.value = "<?php echo $opciones['id_tipo_formula']?>";
                    <?php
                    $txt = "";
                    if($opciones['Adicional'] == 1){
                        $txt = "ADICION - ";
                    }
                    ?>
                    opt.innerHTML = "<?php echo $txt.$opciones['nombre_formula']?>";
                    
                    oldFormula.appendChild(opt);
                    <?php endforeach?>
                
                    <?php
                    
                }else{
                    ?>
                    Swal.fire({
                        icon: 'warning',
                        title: "El paciente no cuenta con formulas para cancelar",
                        showConfirmButton: false,
                        timer: 1500 
                    });

		
                    document.getElementById("tipo_solicitud").value = 1;
                    <?php
                }
            
            }

        break;

        case "info":
            if($episodio != 0 && $episodio != ''){
                $oldFormula = $_POST['oldFormula'];

                //$query = "SELECT `numero_cc`, `numero_biberones`, `id_chupo`, `id_chupo` FROM `tabla_biberones` WHERE `episodio` = ".$episodio;
                //SELECT `sala` FROM `sala` WHERE `id` IN (SELECT `id_sala` FROM `tabla_biberones` WHERE `episodio` = 39)
        
                //First ROW - Oldest Date
                $completeQuery = "SELECT `id_tipo_formula`, `numero_cc`, `numero_biberones`, `id_chupo`, `observaciones` FROM `tabla_biberones` WHERE `episodio` = '$episodio' AND `id_estado` <> 4 AND id_tipo_formula = $oldFormula AND DATE(fecha_ingreso) = CURDATE()";
                
                //Last ROW - Most Recent Date 
                //$completeQuery = "SELECT * FROM `tabla_biberones` WHERE `episodio` = '$episodio' AND `fecha_ingreso` = (SELECT MAX(`fecha_ingreso`) FROM `tabla_biberones`)";
                
                $result = mysqli_query($conexion, $completeQuery);
                $SQLInfo= mysqli_fetch_assoc($result);
        
                //findKeysArray($SQLInfo);
        
        
                if(!is_null($SQLInfo)){
                    
                    if(array_key_exists('id_tipo_formula', $SQLInfo) && !is_null($SQLInfo['id_tipo_formula'])){
                        ?>
                        document.getElementById("tipo_formula").value = '<?php echo $SQLInfo["id_tipo_formula"] ?>'; 
                        document.getElementById("numero_cc").value = '<?php echo $SQLInfo["numero_cc"] ?>';   
                        document.getElementById("numero_biberones").value = '<?php echo $SQLInfo["numero_biberones"]?>'; 
                        document.getElementById("chupo").value = '<?php echo $SQLInfo["id_chupo"]?>';
                        document.getElementById("observaciones").value = '<?php echo $SQLInfo["observaciones"]?>';
                        
                
                        <?php
                    }else{
                        ?>
                            Swal.fire({
                                icon: 'warning',
                                title: 'EMPTY',
                                showConfirmButton: false,
                                timer: 1500 
                            });
                            
                        <?php
                    }
        
                }
            
            }


        break;

        default:
        break;
    }
    

} 

?>
</script>