<script>
<?php
include('../config/Conexion.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(!isset($_POST['episode']) || !$_POST['episode']){
        ?>
        notFormulasResponse("Por favor ingrese el episodio que desea editar o renovar");
        <?php

    }else{
        $episodio = $_POST['episode'];
        $type = $_POST['typeRequest'];

        Switch($type){
    
            case "addFormula":
                ?>
                document.getElementById("tipo_formula").removeAttribute("disabled");
                document.getElementById("centimetrosCubicos").removeAttribute("readOnly");
                document.getElementById("biberones").removeAttribute("readOnly");
                document.getElementById("chupo").removeAttribute("disabled");
                
                container = document.getElementById("div_Old_Formula");
                container.setAttribute("hidden", true);
                document.getElementById("old_Formula").removeAttribute("required");
                <?php
            break;
    
            case "editFormula":
    
                $searchFormulasToday = "SELECT `id_tipo_formula`, `nombre_formula`, `numero_cc`, `numero_biberones`, `id_chupo`, `observaciones`, `Especial` FROM `tabla_biberones` INNER JOIN tipo_formula ON tabla_biberones.id_tipo_formula = tipo_formula.id WHERE `episodio` = '$episodio' AND `id_estado` <> 4 AND DATE(fecha_ingreso) = CURDATE() AND `Adicional` = 0";                
                
                $SQLInfo = mysqli_query($conexion, $searchFormulasToday);
                $SQLarray = mysqli_fetch_assoc($SQLInfo);

                ?>
                document.getElementById("tipo_formula").removeAttribute("disabled");
                document.getElementById("centimetrosCubicos").removeAttribute("readOnly");
                document.getElementById("biberones").removeAttribute("readOnly");
                document.getElementById("chupo").removeAttribute("disabled");
            
                <?php

                if(!is_null($SQLInfo) && isset($SQLarray['id_tipo_formula'])){
                    ?>
                    
                    
                    

                    document.getElementById("div_Old_Formula").removeAttribute("hidden");
                    document.getElementById("oldFormulaLbl").innerHTML = "Formula a editar";
                    oldFormula = document.getElementById("old_Formula");
                    oldFormula.setAttribute("required", "");

                    removeOptions(oldFormula);
                    var placeH = document.createElement('option');
                    placeH.value = "";
                    placeH.innerHTML = "Seleccione la formula a editar";
                    placeH.selected = true;
                    placeH.hidden = true;
                    oldFormula.appendChild(placeH);

                    <?php  foreach($SQLInfo as $opciones): ?>
                    <?php
                    $prefix = "";
                    if($opciones['Especial'] == 1){
                        $prefix = "ESPECIAL - ";
                    }
                    ?>
                    var opt = document.createElement('option');
                    opt.value = "<?php echo $opciones['id_tipo_formula']?>";
                    opt.innerHTML = "<?php echo $prefix.$opciones['nombre_formula']?>";
                    oldFormula.appendChild(opt);
                    <?php endforeach?>
                
                    <?php
                    
                }else{
                    ?>
                    notFormulasResponse("El paciente no cuenta con formulas para editar");
                    <?php
                }
            break;
    
            case "renovateFormula":

                $searchFormulasYesterday = "SELECT `id_tipo_formula`, `nombre_formula`, `numero_cc`, `numero_biberones`, `id_chupo`, `observaciones`, `Especial` FROM `tabla_biberones` INNER JOIN tipo_formula ON tabla_biberones.id_tipo_formula = tipo_formula.id WHERE `episodio` = '$episodio' AND `id_estado` <> 4 AND DATE(fecha_ingreso) = (SELECT DATE_SUB(CURDATE(), INTERVAL 1 DAY))  AND `Adicional` = 0 AND tabla_biberones.id_tipo_formula NOT IN (SELECT `id_tipo_formula` FROM `tabla_biberones` WHERE `episodio` = '$episodio' AND `id_estado` <> 4 AND DATE(fecha_ingreso) = CURDATE())";
                
                $SQLInfo = mysqli_query($conexion, $searchFormulasYesterday);
                $SQLarray = mysqli_fetch_assoc($SQLInfo);


                if(!is_null($SQLInfo) && isset($SQLarray['id_tipo_formula'])){
                    ?>
                    
 
                    document.getElementById("div_Old_Formula").removeAttribute("hidden");
                    document.getElementById("oldFormulaLbl").innerHTML = "Formula a renovar";
                    oldFormula = document.getElementById("old_Formula");
                    oldFormula.setAttribute("required", "");
                    

                    removeOptions(oldFormula);
                    var placeH = document.createElement('option');
                    placeH.value = "";
                    placeH.innerHTML = "Seleccione la formula a renovar";
                    placeH.selected = true;
                    placeH.hidden = true;
                    oldFormula.appendChild(placeH);

                    <?php  foreach($SQLInfo as $opciones): ?>
                    <?php
                    $prefix = "";
                    if($opciones['Especial'] == 1){
                        $prefix = "ESPECIAL - ";
                    }
                    ?>
                    var opt = document.createElement('option');
                    opt.value = "<?php echo $opciones['id_tipo_formula']?>";
                    opt.innerHTML = "<?php echo $prefix.$opciones['nombre_formula']?>";
                    oldFormula.appendChild(opt);
                    <?php endforeach?>
                    <?php
                    
                }else{
                    ?>
                    notFormulasResponse("El paciente no cuenta con formulas que renovar");
                    <?php
                }

            break;
    
            case "cancelFormula":
    
                $searchFormulasToday = "SELECT `id_tipo_formula`, `nombre_formula`, `numero_cc`, `numero_biberones`, `id_chupo`, `observaciones`, `Especial` FROM `tabla_biberones` INNER JOIN tipo_formula ON tabla_biberones.id_tipo_formula = tipo_formula.id WHERE `episodio` = '$episodio' AND `id_estado` <> 4 AND DATE(fecha_ingreso) = CURDATE() AND `Adicional` = 0";                
                
                $SQLInfo = mysqli_query($conexion, $searchFormulasToday);
                $SQLarray = mysqli_fetch_assoc($SQLInfo);


                ?>
                document.getElementById("tipo_formula").removeAttribute("disabled");
                document.getElementById("centimetrosCubicos").removeAttribute("readOnly");
                document.getElementById("biberones").removeAttribute("readOnly");
                document.getElementById("chupo").removeAttribute("disabled");
            
                <?php    


                if(!is_null($SQLInfo) && isset($SQLarray['id_tipo_formula'])){
                    ?>
                    
                    document.getElementById("div_Old_Formula").removeAttribute("hidden");
                    document.getElementById("oldFormulaLbl").innerHTML = "Formula a cancelar";
                    oldFormula = document.getElementById("old_Formula");
                    oldFormula.setAttribute("required", "");

                    removeOptions(oldFormula);
                    var placeH = document.createElement('option');
                    placeH.value = "";
                    placeH.innerHTML = "Seleccione la formula a cancelar";
                    placeH.selected = true;
                    placeH.hidden = true;
                    oldFormula.appendChild(placeH);

                    <?php  foreach($SQLInfo as $opciones): ?>
                    <?php
                    $prefix = "";
                    if($opciones['Especial'] == 1){
                        $prefix = "ESPECIAL - ";
                    }
                    ?>
                    var opt = document.createElement('option');
                    opt.value = "<?php echo $opciones['id_tipo_formula']?>";
                    opt.innerHTML = "<?php echo $prefix.$opciones['nombre_formula']?>";
                    oldFormula.appendChild(opt);
                    <?php endforeach?>
                
                    <?php
                    
                }else{
                    ?>
                    notFormulasResponse("El paciente no cuenta con formulas para cancelar");
                    <?php
                }
            break;

            
            case "getInfo":

                $formula = $_POST['oldFormula'];
                $renovate = $_POST['renovate'];
                $especial = $_POST['especial'];
                $searchFormulasToday = "";

                if($renovate == 3){

                    $searchFormulasToday = "SELECT `id_tipo_formula`, `numero_cc`, `numero_biberones`, `id_chupo`, `observaciones`, `Especial` FROM `tabla_biberones` WHERE `episodio`= $episodio AND `id_estado` <> 4 AND `fecha_ingreso` = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND `id_tipo_formula` = $formula AND `Especial` = '$especial'  AND `Adicional` = 0" ;  

                }else{

                    $searchFormulasToday = "SELECT `id_tipo_formula`, `numero_cc`, `numero_biberones`, `id_chupo`, `observaciones`, `Especial` FROM `tabla_biberones` WHERE `episodio`= $episodio AND `id_estado` <> 4 AND `fecha_ingreso` = CURRENT_DATE() AND `id_tipo_formula` = $formula AND `Especial` = '$especial' AND `Adicional` = 0" ;  

                }
    
                            
                
                $SQLInfo = mysqli_query($conexion, $searchFormulasToday);
                $SQLarray = mysqli_fetch_assoc($SQLInfo);

                if(!is_null($SQLInfo) && isset($SQLarray['id_tipo_formula'])){
                    ?>
                    document.getElementById("tipo_formula").value = '<?php echo $SQLarray["id_tipo_formula"] ?>'; 
                    document.getElementById("centimetrosCubicos").value = '<?php echo $SQLarray["numero_cc"] ?>';   
                    document.getElementById("biberones").value = '<?php echo $SQLarray["numero_biberones"]?>'; 
                    document.getElementById("chupo").value = '<?php echo $SQLarray["id_chupo"]?>';
                    document.getElementById("observaciones").value = '<?php echo $SQLarray["observaciones"]?>';
                
                    <?php
                    
                }

                
                
            break;

            default:
                
            break;


        }
    }
   

} 

?>

function removeOptions(selectElement) {
   var i, L = selectElement.options.length - 1;
   for(i = L; i >= 0; i--) {
      selectElement.remove(i);
   }
}

function notFormulasResponse(msg){
    document.getElementById("centimetrosCubicos").removeAttribute("readOnly");
    document.getElementById("biberones").removeAttribute("readOnly");
    document.getElementById("tipo_Solicitud").value= "addFormula";
    container = document.getElementById("div_Old_Formula");
    container.setAttribute("hidden", true);
    document.getElementById("old_Formula").removeAttribute("required");

    Swal.fire({
        icon: 'warning',
        title: msg,
        showConfirmButton: false,
        timer: 1500 
    });
}

</script>