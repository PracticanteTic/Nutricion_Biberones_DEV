<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
include('../config/Conexion.php');
//include_once('../logica/ApiSap.php');
include_once('../logica/ApiAgregar_Formula.php');

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
$pageTitle = "Formulario para nuevas fórmulas";
require 'template/header.php';

if ($_SESSION['AgregarFormulaBiberones']==1)
{
?>
<br>
<!-- Agrega este script en el encabezado de tu página HTML para habilitar la consola de depuración -->
<script>
    // Verificar si la consola está disponible (útil para navegadores que no la admiten)
    if (typeof console !== "undefined") {
        // Mensaje de depuración
        console.log('Inicio del script de depuración');
        
    }

    // Función para agregar el evento después de que la página se haya cargado
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener el campo de texto del número de episodio
        var episodioInput = document.getElementById('episodioInput');

        // Agregar un listener al campo de texto para detectar cuando se presiona el botón "Enter"
        episodioInput.addEventListener('keypress', function(event) {
            // Si se presionó el botón "Enter", enviar el formulario
            //Key 13 is Return-Enter
            if (event.keyCode === 13) {
                if (typeof console !== "undefined") {
                    console.log('Presionaste Enter'); // Mensaje de depuración
                    
                }
                clearForm();
                getInfoAPI();
                getFormulas();
                

                //episodioInput.form.submit();

            }
        });
    });

</script>
<!--Contenido-->
<!-- Content Wra</div>pper. Contains page content -->
<div class="content-wrapper">
  <div id="alertContainer" class="alert" role="alert" style="margin-top: 10%;"></div>
  <!---Content Header (Page header)----->
  <div class="container">
      <div class="col-md-12 ">
        <div class="card shadow p-3 mb-8" >
          <div class="card-header">
              <div class="row">
                <div class="col-12 text-center top: -5px;">
                  <h2 class="text-success MainTittles" style="margin-top: 15px;">Agregar Nueva Fórmula</h2>
                </div>  
                  <div class="col-2"></div>
                  <div class="col-2"></div>
                      <div class="col-2">
                      <?php
                          // Inicialmente, no mostrar la alerta
                          $mostrarAlerta = false;

                          // Verificar si el formulario se ha enviado
                          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                              // Verificar si el checkbox "renovar_formula" está marcado
                              if (isset($_POST['renovar_formula'])) {
                                  // El checkbox está marcado, entonces mostrar la alerta
                                  $mostrarAlerta = true;
                              }
                          }
                          ?>
                          <div class="col-12 text-end">
                      <form method="post" hidden>
                          <div class="form-check form-switch" style="position: relative; margin-left: 400%;">
                            <!-- Si deseas renovar la formula, Selecciona el check. -->
                            <label class="" for="renovar_formula" style="position: relative; text-align:center; margin:0 auto;">Renovar formula</label>
                            <input class="form-check-input " type="checkbox" id="renovar_formula" style="transform: scale(1.5); position: relative; text-align:center;margin:0 auto; margin-left: 16px; margin-top: 15px">
                            
                          </div>
                        </form>
                      </div>
                    </div>
                <?php
                // Mostrar la alerta si se debe mostrar
                if ($mostrarAlerta) {
                    echo '<script>alert("El checkbox está marcado.");</script>';
                }
                ?>
                
              </div>
        <form name="form_reloj" id="agregarFormula" method="POST" >
          <div class="row mb-4 " style="justify-content: center;" >

              <div class="col-md-3">
                    <label for="episodio" id="episodio" class="form-label" name="episodio">Episodio</label>
                      <?php
                      date_default_timezone_set('America/Bogota');
                      $fecha_actual = date("dmY");
                      ?>
                  <div class="input-group">
                    <input type="number" name="episodio" id="episodioInput" value="" class="form-control" placeholder="Digite el episodio" aria-describedby="helpId" required min="0" onfocusout="clearForm();getInfoAPI();getFormulas();">
                    <script>
                        // Obtener el campo de texto del número de episodio
                        var episodioInput = document.getElementById('episodioInput');

                        // Agregar un listener al campo de texto para detectar cuando se presiona el botón "Enter"
                        episodioInput.addEventListener('keypress', function(event) {
                            // Si se presionó el botón "Enter", enviar el formulario
                            if (event.keyCode === 13) {
                                //episodioInput.form.submit();
                                
                            }
                        });
                    </script>       
                  </div>
                </div>

                  <div class="col-md-3" >

                  <center><label for="" class="form-label">Accion a realizar</label></center>
                
                
                <div class="input-group">
                    
                  <select class="form-select " name="tipo_Solicitud" id="tipo_Solicitud" onfocusout="" required>
                    <option value="addFormula" selected>Añadir Formula</option>
                    <option value="editFormula" >Editar Formula</option>
                    <option value="renovateFormula" >Renovar Formula</option>
                    <!-- <option value="cancelFormula" >Cancelar Formula</option> -->
                  </select>

                </div>
                </div>


                <div id="div_Old_Formula" class="col-md-5" hidden>
                  <label id="oldFormulaLbl" for="" class="form-label">Formula a </label>
                
                
                  <div class="input-group">
                    <select class="form-select " name="old_Formula" id="old_Formula" style="width: 500px">
                    </select>
                  </div>
                </div>
            </div>  

              <div class="row titles">
                <div class="col">
                  <div class="well">
                    <h4 class="form-label text-divider"><span class="left-span"></span><span>Información del Paciente</span></h4>
                  </div>
                </div>
              </div>
        
              <div class="row mb-4">
                  
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <center><label for="" class="form-label">Identificación</label></center>
                  <input type="text" name="identificacion" id="identificacion" class="form-control bg-white" placeholder="---" aria-describedby="helpId" value="" readonly required>
                </div>

                <div class="col-md-1"></div>
              
                <div class="col-md-6">
                  <center> <label for="" class="form-label">Nombres y Apellidos</label></center>
                  <input type="text" onkeydown="return /[a-z, ]/i.test(event.key)" name="nombre_apellido" id="nombre_apellido" placeholder="---" class="form-control bg-white" aria-describedby="helpId" readonly required>
                </div>

                <div class="col-md-1"></div>

                                
              </div>
        <div class="container" >
            
            <div class="col-md-12" >

              
                
                
              <br>
                <div class="row mb-4">

                  <div class="col-md-3">
                    <center><label for="" class="form-label">Fecha nacimiento</label></center>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control bg-white" aria-describedby="helpId" readonly required>
                  </div>

                  <div class="col-md-6">
                    <center><label for="" class="form-label">Sala</label></center>
                    <input type="text" name="sala" id="sala" class="form-control  bg-white" placeholder="---" aria-describedby="helpId" value="" readonly required>
                  </div>

                  
                  <div class="col-md-3">
                    <label class="control-label" for="cama">Cama</label>
                    <input type="text" class="form-control  bg-white" id="cama" name="cama" placeholder="---" value="" readonly required autofocus>
                  </div>
                  <div class="col-md-3" hidden>
                    <input type="text" class="form-control  bg-white" id="Unidad_Organizativa" name="Unidad_Organizativa" placeholder="---" value="" readonly required autofocus>
                  </div>

                  <div class="col-md-1"></div>

                </div>
                <div class="row titles">
                  <div class="col">
                    <div class="well">
                      <h4 class="form-label text-divider"><span class="left-span"></span><span>Información de la solicitud</span></h4>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">

                  <div class="col-md-3">
                    <center><label for="" class="form-label">Fecha de ingreso</label></center>
                    <input type="text" id="fechaActual" name="fechaActual" class="form-control bg-white" readonly required>
                  </div>

                  <div class="col-md-3">
                    <center><label for="" class="form-label">Hora de ingreso</label></center>
                    <input type="text" id="reloj" name="reloj" class="form-control bg-white" readonly value required>
                  </div>
                  
                
                  <div class="col-md-6">
                    <center><label for="" class="form-label">Nombre de fórmula</label></center>
                    <select class="form-select" name="tipo_formula" id="tipo_formula" required>
                      
                      <option id='placeholder' selected disabled hidden value="">Seleccione Nombre de Fórmula</option>                     
                      
                        <?php 
                          //Se condiciona el tipo de formula con la especialiad = 2 para traer solamente de enfermeras.
                          $consultarformula="SELECT * FROM tipo_formula WHERE especial_normal='normal' AND nombre_formula <> 'FORMULA ESPECIAL' AND Id_especialidad = 2 ORDER BY nombre_formula";
                          $ejecutar=mysqli_query($conexion, $consultarformula) or die(mysqli_error($conexion));
                        ?>

                          <?php  foreach($ejecutar as $opciones): ?>
                      <option value="<?php echo $opciones['id']?>">
                        <?php echo $opciones['nombre_formula']?>
                      </option>
                          
                            <?php endforeach?>
                    </select>
                  </div>
                  
                </div>
                  
                        
                    
                  
                  
                
                  
                </div>
                <br>
                <div class="row mb-4">
                            
                  <div class="col-md-4">
                    <center><label for="" class="form-label">Número de biberones</label></center>
                    <input type="number" name="biberones" id="biberones" placeholder="Ingrese cantidad biberones" class="form-control" aria-describedby="helpId" min=0 required>
                  </div>

                  <div class="col-md-4">
                    <center><label for="" class="form-label">Número cc</label></center>
                    <input type="number" name="centimetrosCubicos" id="centimetrosCubicos" placeholder="Ingrese cc" class="form-control" aria-describedby="helpId" min=0 required>
                  </div>
                  
                  <div class="col-md-4">
                    <center><label for="" class="form-label">Chupo</label></center>
                    <select class="form-select" required name="chupo" id="chupo" >
                       <option id='placeholder' selected disabled hidden value="">Necesita chupo</option>
                        <?php
                          $consultarchupo="SELECT id,chupo FROM chupo";
                          $ejecutar=mysqli_query($conexion, $consultarchupo) or die(mysqli_error($conexion));
                        ?>
                        <?php 
                         foreach($ejecutar as $opciones):
                        ?>
                      <option value="<?php echo $opciones['id']?>">
                        <?php $opciones['id'];echo $opciones['chupo']?>
                      </option>
                        <?php endforeach?>
                    </select>
                  </div>

                  
                </div>

                <div class="row-md-4">
                  <div class="col-md-12">
                    <label for="" class="form-label">Observaciones</label>
                    <textarea type="textarea" name="observaciones" id="observaciones" class="form-control" rows="5" cols="40" aria-describedby="helpId" maxlength="30" pattern=""></textarea>
                  </div>
                </div> 

                <div class="row mb-3"> 
                <div class="form-group">
                  <input type="hidden" class="form-control" id="user_registro" name="user_registro" value="<?php echo ($_SESSION["nombre"])?>">
                </div>
              </div>
              
                <div class="row">
                  <div>
                    <input type="submit" id="agregar" name="agregar"  class="btn" style="background-color: #428E3F; color:white" value="Enviar">
                    
                  </div>
                </div>
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body" id="miAlerta"></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
  </div>
        </form>
      </div
      ><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<script>
  document.addEventListener("DOMContentLoaded", function() {
      const checkbox = document.getElementById("renovar_formula");
      const form = document.getElementById("agregarFormula");
      const originalFormValues = {}; // Objeto para almacenar los valores originales de los campos

      // Guarda los valores originales cuando la página se carga
      /*Array.from(form.elements).forEach(function(field) {
          if (field.name) {
              originalFormValues[field.name] = field.value;
          }
      });*/


      checkbox.addEventListener("change", function() {
          if (checkbox.checked) {
              // El checkbox se ha marcado, limpia los campos

              
              getBiberonesInfo();

          } 
          else {
            
            clearForm();
            
          }
      });
  });
  
</script>

<?php
}
else
{
  require 'noacceso.php';
}

require 'template/footer.php';
?>

<?php 
}
ob_end_flush();
?>
<script>
document.getElementById('observaciones').addEventListener('input', function (event) {
        const invalidChars = /[^a-zA-Z0-9]/g;  // Expresión regular para caracteres especiales y espacios
        let value = event.target.value;

        if (invalidChars.test(value)) {
            event.target.value = value.replace(invalidChars, '');
        }
      });

        document.getElementById('observaciones').addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
      });
</script>

<script src="./scripts/Agregar_Formula.js"></script>
<script src="./scripts/TablaBiberones_Ajax_Insercion.js"></script>
<script src="./scripts/DeshabilitarRetroceso.js"></script>
<!--<script src="./scripts/TablaBiberonesHoraActual.js"></script>-->
<script src="./scripts/TablaBiberones_AgregarNueva_fechaActual.js"></script>


<script src="./scripts/TablaBiberones_AgregarNueva_HoraActual.js"></script>


