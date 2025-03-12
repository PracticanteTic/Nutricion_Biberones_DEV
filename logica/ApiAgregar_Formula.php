<script>

    //function startApi(){   
        
        <?php
        include('ApiSap.php');
        include('../config/Conexion.php');
        // $episodios = {2703221, 2703222, 2703220, 2703219}

        $episodio = '';
        //$episodio = $_POST['episodeInput'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $episodio = $_POST['episodeInput'];
        } 
        ?>
        formula = document.getElementById("tipo_formula");

        removeEspecialOptions(formula);


        <?php
        $query = "SELECT 1 as nf FROM solicitudes_especiales WHERE episodio = '".$episodio."'";     

        $ans = mysqli_query($conexion, $query);
        $result = mysqli_fetch_array($ans);

        if(!isset($result['nf'])){
            $result['nf'] = 0;
        }

        if( $result['nf'] == 1){

            $query = "SELECT DISTINCT se.id, tipo_formula.nombre_formula, se.id_tipo_formula, se.numero_biberones, se.volumen_biberon, se.fecha_modificacion, se.hora_modificacion FROM solicitudes_especiales as se INNER JOIN tipo_formula ON se.id_tipo_formula = tipo_formula.id WHERE se.episodio = '$episodio' AND Vigente = 1 ORDER BY tipo_formula.nombre_formula DESC";            
            $info = mysqli_query($conexion, $query); 


            ?>
                Swal.fire({
                    heightAuto: false,
                    html: '<label style="color: #ffffff">Recuerde que este paciente tiene realizada una formula especial, si desea asignarla ' +
                        'aparecera como primera opcion en el desplegable de los tipos de formula</label>',
                    showCancelButton: false,
                    iconHtml: '<i class="fa-solid fa-circle-info"></i>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        title: 'custom-swal', // Clase personalizada para el título
                        popup: 'custom-swal' // Clase personalizada para el popup
                    },
                    timer: 3000, // Tiempo en milisegundos (3 segundos en este caso)
                    timerProgressBar: true,
                    didOpen: () => {
                        // Después de mostrar la alerta, agrega la opción especial
                        var formula = document.getElementById("tipo_formula");
                        <?php foreach($info as $opciones): ?>
                        var opt = document.createElement('option');
                        opt.value = "<?php echo $opciones['id_tipo_formula']; ?>";
                        opt.style.color = "#fff";
                        opt.style.background = "#3f8755";
                        opt.innerHTML = "ESPECIAL : <?php echo $opciones['nombre_formula'] . ' - ' .$opciones['fecha_modificacion']; ?>";
                        formula.prepend(opt);
                        <?php endforeach; ?>
                    }
                });
            

            //addOptionAndSort(formula);
        
            <?php
            
        }
        else{
            
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
                          document.getElementById("sala").value = '<?php echo $UbicacionPaciente["UbicacionEdificio"];?>';
                          document.getElementById("cama").value = '<?php echo $UbicacionPaciente["IdUbicacion_cama"]; ?>';
                          document.getElementById("Unidad_Organizativa").value = '<?php echo $UbicacionPaciente["Unidad_Organizativa"]; ?>';
                        //document.getElementById("sala").readOnly = true;

                        <?php

                    }
                }

                
            }else{  

                ?>  
                document.getElementById("episodioInput").value = "";
                Swal.fire({
                    heightAuto: false,
                    html: '<label style="color: #ffffff">No existe el episodio.</label>',
                    showCancelButton: false,
                    iconHtml: '<i class="fa-solid fa-circle-info"></i>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        title: 'custom-swal', // Clase personalizada para el título
                        popup: 'custom-swal' // Clase personalizada para el popup
                    },
                    timer: 1500  
                });
              
                <?php

                //document.getElementById("episodioInput").readOnly = false;
                //document.getElementById("identificacion").readOnly = false;
                //document.getElementById("nombre_apellido").readOnly = false;
                //document.getElementById("fecha_nacimiento").readOnly = false;
                //document.getElementById("sala").readOnly = false;


            }
        }           
               
        ?>

        
        

function removeEspecialOptions(selectElement) {
    if(!(selectElement == null)){
        var i, L = selectElement.options.length - 1;
        for(i = L; i >= 0; i--) {
        
            var opt = selectElement.options[i];
            var txt = opt.text;
            if(txt.includes("ESPECIAL")){
                selectElement.remove(i);
            }
            
        }
    }
    
}

function addOptionAndSort(selectElement) {
  // Sort options alphabetically
  var options = Array.from(selectElement.options);
  options.sort((a, b) => a.text.localeCompare(b.text));
  selectElement.innerHTML = "";
  options.forEach(option => selectElement.add(option));
}
    //}</script>