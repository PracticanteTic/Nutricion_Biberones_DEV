<script>

    //function startApi(){   
        
        <?php

        // $episodios = {2703221, 2703222, 2703220, 2703219}

        
        $episodio = '';
        //$episodio = $_POST['episodeInput'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $episodio = $_POST['episodeInput'];
        } 
        if($episodio != 0 && $episodio != ''){

            $username = "po_divergent";
            $password = "QgXz18YcMqg4iu";
            $data = [];
            $dataR = [];
            $DatosPaciente = [];
            $url= 'http://aspod.hospital.com:50000/RESTAdapter/dev/get_datosdemograficospaciente?Centro_Sanitario=HSVM&Episodio=' . $episodio . '&Ubicacion_episodio=X';

            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

            //This line ignores the SSL verification (Very insecure workaround)
            //curl_setopt ($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

            $response = curl_exec($ch);
            if(curl_errno($ch)){
                $error_msg= curl_error($ch);
                die('Error al realizar la solicitud a la API'.$error_msg);
            }
            else{
                //echo "Funciona (Parcially):".$response;
                $dataR = json_decode($response, true);

                // Decodificar la respuesta JSON (asumiendo que la respuesta es JSON) 
                // Verificar si la decodificación fue exitosa
                if ($dataR === null) {
                    die('Error al decodificar la respuesta JSON');
                }
                else{
                    
                    if(!is_null($dataR)){
                        if(array_key_exists('DatosPaciente', $dataR) && !is_null($dataR['DatosPaciente'])){
                        
                            $DatosPaciente = $dataR["DatosPaciente"];

                            ?>
                            document.getElementById("episodioInput").value = '<?php echo $episodio ?>'; 
                            document.getElementById("identificacion").value = '<?php echo $DatosPaciente["Numero_documento"] ?>';   
                            document.getElementById("nombre_apellido").value = '<?php echo $DatosPaciente["Nombre_completo"] ?>'; 
                            document.getElementById("fecha_nacimiento").value = '<?php echo $DatosPaciente["Fecha_nacimiento"] ?>';

                            
                            //document.getElementById("episodioInput").readOnly = true;
                            document.getElementById("identificacion").readOnly = true;
                            document.getElementById("nombre_apellido").readOnly = true;
                            document.getElementById("fecha_nacimiento").readOnly = true;

                            <?php


                            if(array_key_exists('DatosUbicacionEpisodio', $dataR)){
                                $UbicacionPaciente = $dataR["DatosUbicacionEpisodio"];

                                ?>
                                document.getElementById("sala").value = '<?php echo $UbicacionPaciente["UbicacionEdificio"] ?>';

                                document.getElementById("sala").readOnly = true;

                                <?php

                            }

                            
                        }else{  

                            ?>
                            document.getElementById("episodioInput").readOnly = false;
                            document.getElementById("identificacion").readOnly = false;
                            document.getElementById("nombre_apellido").readOnly = false;
                            document.getElementById("fecha_nacimiento").readOnly = false;
                            document.getElementById("sala").readOnly = false;
                            <?php

                        }
                    }
                }
                
            }
        }        
        ?>
        
    //}</script>