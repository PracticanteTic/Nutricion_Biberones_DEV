<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
include('../config/Conexion.php');
if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
$pageTitle = "Formulario de pedidos adicionales";
require 'template/header.php';

//if ($_SESSION['SolicitudesBiberones']==1)
if ($_SESSION['AgregarPedidosAdicionales']==1)
{
?>
<script>

  // Verificar si la consola está disponible (útil para navegadores que no la admiten)
  if (typeof console !== "undefined") {
        // Mensaje de depuración
        console.log('Inicio del script de depuración');
        
    }

  document.addEventListener("DOMContentLoaded", function(event) {
   // Obtener el campo de texto del número de episodio
   var episodioInput = document.getElementById('episodioInput');

// //         // Agregar un listener al campo de texto para detectar cuando se presiona el botón "Enter"
   episodioInput.addEventListener('keypress', function(event) {
           // Si se presionó el botón "Enter", enviar el formulario
       //Key 13 is Return-Enter
       if (event.keyCode === 13) {
        if (typeof console !== "undefined") {
            console.log('Presionaste Enter'); // Mensaje de depuración
            
           }
            clearForm();
            getInfoAPI();
            getOptions();
         //episodioInput.form.submit();
       }       
     });
 }); 

// document.getElementById('tipo_formula').addEventListener('click', function(event) {
//   event.preventDefault();
// });
// document.addEventListener("keypress", function(event) {
//     if (event.key === "Enter") {
//         showAlert();
//     }
// });
</script>


<!--Contenido-->
<!-- Content Wra</div>pper. Contains page content -->
<div class="content-wrapper">
  <!-- <div id="alertContainer" class="alert" role="alert" style="margin-top: 10%;"></div> -->
  <!---Content Header (Page header)----->
  <form id="agregarPedidoAdicional" method="post">
    <div class="container" >
      <div class="col-md-12 ">
        <div class="card shadow p-3 mb-8">
        <div class="card-header p-3 ">
          <center><h2 class="text-success">Adiciones y Modificaciones de formulas lacteas nutricion y dietetica</h2></center>
          <br>
            


              <div class="row" style="justify-content: center;" >

                <div class="col-md-3">
                    <center><label for="episodio" class="form-label">Episodio</label></center>
                    <?php
                      date_default_timezone_set('America/Bogota');
                      $fecha_actual = date("dmY");
                    ?>
                  <div class="input-group">
                    <input type="number" name="episodioInput" id="episodioInput" class="form-control" placeholder="Digite el episodio" aria-describedby="helpId" required min="0" onfocusout="clearForm();getInfoAPI();getOptions();">
                  </div>
                </div>

                <div class="col-md-3 ">
                  <div class="form-group  mb-3 ml-3">
                    <label for="" class="form-label">Tipo De Solicitud</label>
                    <select class="form-select " name="tipo_solicitud" id="tipo_solicitud" onfocusout="" required>
                      <!-- <option value="" selected disabled hidden>Seleccione el tipo</option> -->
                        <?php
                        //$consultarsolicitud="SELECT id,tipo_solicitud FROM tipo_solicitud ORDER BY tipo_solicitud ASC";
                        $consultarsolicitud="SELECT id,tipo_solicitud FROM tipo_solicitud WHERE id <> 2 ORDER BY tipo_solicitud ASC";
                        $ejecutar=mysqli_query($conexion, $consultarsolicitud) or die(mysqli_error($conexion));
                          ?>
                        <?php  foreach($ejecutar as $opciones): ?>
                      <option value="<?php echo $opciones['id']?>">
                        <?php $opciones['id'];echo $opciones['tipo_solicitud']?>
                      </option>
                        <?php endforeach?>
                    </select>
                  </div>
                </div>
                <div id="div_Old_Formula" class="col-md-5" hidden>
                  <label id="oldFormulaLbl" for="" class="form-label">Formula a cancelar</label>
                  <div class="input-group">
                    <select class="form-select " name="old_Formula" id="old_Formula" style="width: 500px">
                    </select>
                  </div>
                </div>
                
              </div>
          
            <div class="card-body">

              <div class="row titles">
                <div class="col">
                  <div class="well">
                    <h4 class="form-label text-divider"><span class="left-span"></span><span>Informacion del Paciente</span></h4>
                  </div>
                </div>
              </div>

              <div class="row mb-3">  

                <div class="col-md-1"></div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="rc">RC - Identificacion </label>
                    <input type="text" class="form-control  bg-white" id="identificacion" name="identificacion" placeholder="---" value="" readonly required autofocus>
                  </div>  
                </div>  

                <div class="col-md-1"></div>

                <div class="col-6">
                  <div class="form-group">
                    <label class="form-label" for="nombre_apellido">Nombre y apellido</label>
                    <input type="text" class="form-control  bg-white" id="nombre_apellido" name="nombre_apellido" placeholder="---" value="" readonly required autofocus>
                  </div>  
                </div> 
                <div class="col-md-1"></div>                
                
              </div> 

              <div class="row mb-3">  

                <div class="col-md-3">
                  <label for="fecha_nacimiento" class="control-label">Fecha de Nacimiento</label>
                  <input name='fecha_nacimiento' type="date" class="form-control  bg-white" id="fecha_nacimiento" value=""  readonly required autofocus>
                </div>

                <div class="col-md-6">
                  <center><label for="" class="form-label">Sala</label></center>
                  <input type="text" name="sala" id="sala" class="form-control bg-white" placeholder="---" aria-describedby="helpId" readonly required>
                </div>

                <div class="col-3">
                  <div class="form-group">
                    <label class="control-label" for="cama">Cama</label>
                    <input type="text" class="form-control  bg-white" id="cama" name="cama" placeholder="---" value="" readonly required autofocus>
                  </div>  
                </div>

                <div class="col-md-3" hidden>
                    <input type="text" class="form-control  bg-white" id="Unidad_Organizativa" name="Unidad_Organizativa" placeholder="---" value="" readonly required autofocus>
                  </div>

              </div>

                <div class="row titles">
                  <div class="col">
                    <div class="well">
                      <h4 class="form-label text-divider"><span class="left-span"></span><span>Informacion de la solicitud</span></h4>
                    </div>
                  </div>
                </div>

              <div class="row">

                <div class="col-md-3">
                  <div class="form-group  mb-3 ml-1">
                    <label class="form-label"  for="fecha_actual">Fecha Actual</label>
                    <input type="text" class="form-control bg-white  " id="fechaActual" name="fechaActual" placeholder="" required readonly autofocus />
                  </div>  
                </div> 

                <div class="col-md-3">
                  <center><label for="" class="form-label">Hora de ingreso</label></center>
                  <input type="text" id="reloj" name="reloj" class="form-control  bg-white" readonly value required>
                </div>
                
                <div class="col-md-6">          
                  <div class="form-group">
                    <label for="" class="form-label">Nombre de formula</label>
                    <select class="form-select" name="tipo_formula" id="tipo_formula" required >
                    <option id="placeholder" value="" hidden selected>Seleccionar nombre de formula</option>
                    <?php 
                      $consultarformula="SELECT * FROM tipo_formula WHERE especial_normal='normal' AND nombre_formula <> 'FORMULA ESPECIAL' AND Id_especialidad = 2 ORDER BY nombre_formula";
                      $ejecutar=mysqli_query($conexion, $consultarformula) or die(mysqli_error($conexion));
                    ?>
                        <?php
                          foreach($ejecutar as $opciones):
                          ?>
                     <option value="<?php echo $opciones['id']?>">
                        <?php echo $opciones['nombre_formula']?>
                      </option>
                        <?php 
                          endforeach
                        ?>
                    </select>
                    <input type="hidden" name="Htipo_formula" id="Htipo_formula">
                  </div>  
                </div>

              </div>

              <div class="row mb-3"> 
                <div class="col-4">
                  <div class="form-group">
                    <label class="control-label" for="numero_biberones">Numero de biberones por dia</label>
                    <input type="number" class="form-control" id="numero_biberones" name="numero_biberones" placeholder="Introduzca numero de Biberones" min=0 required autofocus />
                  </div>  
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label class="control-label" for="Num_cc">Numero de cc por biberon</label>
                    <input type="number" class="form-control" id="numero_cc" name="numero_cc" placeholder="Introduzca numero de cc" min=0 required autofocus />
                  </div>  
                </div>
                <div class="col-md-4">
                  <label for="" class="form-label">Chupo</label>
                  <select class="form-select" name="chupo" id="chupo" required>
                    <option id="placeholder" value="" selected hidden>Seleccione el uso de chupo</option>
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
                  <input type="hidden" name="Hchupo" id="Hchupo">
                </div> 
              </div>  


              <div class="row mb-3"> 
                <div class="form-group">
                  <label class="control-label" for="observacion">Observaciones</label>
                  <textarea rows="5" cols="30" class="form-control" id="observaciones" name="observaciones" maxlength="30"></textarea>
                </div>
              </div>


              <div class="row mb-3"> 
                <div class="form-group">
                  <input type="hidden" class="form-control" id="user_registro" name="user_registro" value="<?php echo ($_SESSION["nombre"])?>">
                </div>
              </div>



              <div class="row"> 
                <div class="form-group">             
                  <input type="submit" id="agregar" name="agregar"  class="btn" style="background-color: #428E3F; color:white" value="Enviar">
                            
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </form>    
</div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  


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

<script src="./scripts/Pedidos_Adicionales.js"></script>

<script src="../view/scripts/PedidosAdicionales_Agregar.js">
//  AGREGA NUEVO REFISTRO
</script>

<script src="../view/scripts/DeshabilitarRetroceso.js">
// EVITA DEVOLVERSE ENTRE PAGINAS
</script>


<script src="../view/scripts/pedidosAdicionalesHora.js">
  // OBTENER LA HORA ACTUAL.
</script>


<script src="../view/scripts/PedidosAdicionalesFechaActual.js">
// OBTENER LA FECHA ACTUAL
</script>

<script>
  document.getElementById('observaciones').addEventListener('input', function (event) {
            const invalidChars = /[^a-zA-Z0-9,]/g;  // Expresión regular para caracteres especiales y espacios
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