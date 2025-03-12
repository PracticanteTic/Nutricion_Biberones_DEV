<script>

    //function startApi(){   
        
        <?php
        include('ApiSap.php');
        include '../config/Conexion.php';
        // $episodios = {2703221, 2703222, 2703220, 2703219}

        
        $episodio = '';
        //$episodio = $_POST['episodeInput'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $episodio = $_POST['episodeInput'];
        } 

        $query = "SELECT * FROM `solicitudes_especiales` WHERE `Vigente` = 1 AND `episodio` = '$episodio'";

        $result = $conexion -> query($query);

        $exist = false;

        if ($result && $result ->num_rows > 0) {
            $exist = true;
        }

        if($exist){
            ?>
            BotonCancelar =document.getElementById("CancelarEspeciales");
            BotonCancelar.removeAttribute("hidden");
            BotonCancelar.removeAttribute("disabled");

            <?php
        }
        else{
            ?>
            BotonCancelar =document.getElementById("CancelarEspeciales");
            BotonCancelar.setAttribute("hidden", true);
            BotonCancelar.disabled = true;

            <?php
        }
        

        $dataR = getApi(1, $episodio);
        if($dataR === null){

        }else{
            if(array_key_exists('DatosPaciente', $dataR) && !is_null($dataR['DatosPaciente'])){
            
                $DatosPaciente = $dataR["DatosPaciente"];

                ?>
                document.getElementById("episodioInput").value = '<?php echo $episodio ?>'; 
                document.getElementById("identificacion").value = '<?php echo $DatosPaciente["Numero_documento"] ?>';   
                document.getElementById("nombre_apellido").value = '<?php echo $DatosPaciente["Nombre_completo"] ?>'; 
                document.getElementById("fecha_nacimiento").value = '<?php echo $DatosPaciente["Fecha_nacimiento"] ?>';

                
                //document.getElementById("episodioInput").readOnly = true;
                //document.getElementById("identificacion").readOnly = true;
                //document.getElementById("nombre_apellido").readOnly = true;
                //document.getElementById("fecha_nacimiento").readOnly = true;

                <?php

                if(array_key_exists('DatosEpisodio', $dataR)){
                    if(array_key_exists('Ubicacion', $dataR['DatosEpisodio'])){

                        $UbicacionPaciente = $dataR["DatosEpisodio"]["Ubicacion"];

                        ?>
                        document.getElementById("servicios_hospitalizacion").value = '<?php echo $UbicacionPaciente["UbicacionEdificio"] ?>';
                        document.getElementById("cama").value = '<?php echo $UbicacionPaciente["Ubicacion_cama"] ?>';
                        document.getElementById("Unidad_Organizativa").value = '<?php echo $UbicacionPaciente["Unidad_Organizativa"]; ?>';

                        //document.getElementById("sala").readOnly = true;

                        <?php

                    }
                }

                
            }else{  

                ?>
                //document.getElementById("episodioInput").readOnly = false;
                //document.getElementById("identificacion").readOnly = false;
                //document.getElementById("nombre_apellido").readOnly = false;
                //document.getElementById("fecha_nacimiento").readOnly = false;
                //document.getElementById("sala").readOnly = false;
                <?php

            }
        }           
               
        ?>
        
    //}</script>