<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
include('../config/Conexion.php');

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
} else {
  $pageTitle = "Formulario para solicitud Stock";
  require 'template/header.php';


    if ($_SESSION['AgregarFormulasPreparadas'] == 1) {
?>
        <br>
<!--Contenido-->
     
<div class="content-wrapper" >
  <div class="container">
    <div class="col-md-12 ">

      
      <div class="card shadow p-3 mb-8"> 
      <form id="agregarLinea" method="POST" action="stock.php">
        <div class="card-header" style="margin-bottom:5%">
          <div class="row mb-12" style="margin-top: 20px;">

            <div class="col-md-4" style="margin:0 auto">
              <center><label for="" class="form-label">Fecha de ingreso</label></center>
              <input type="text" id="fechaActual" name="fechaActual" style=" width: 120px; margin-left: auto; margin-right: auto" class="form-control bg-white" readonly required>
            </div>

            <div class="row-4 text-center top: -5px;" style="width: 33%; margin:0 auto; "> 
              <h2 class="text-success " >Solicitar Stock</h2>
            </div>  

            <div class="col-md-4" style="margin:0 auto">
              <center><label for="" class="form-label">Hora de ingreso</label></center>
              <input type="text" id="reloj" name="reloj" style=" width: 90px; margin-left: auto; margin-right: auto" class="form-control bg-white" readonly value required>
            </div>

          </div>
        </div>
      
        
          <div class="row mb-12" style="margin: auto; width: 100%">
          

            <div class="col-md-3" style="margin: auto;">
              <center><label for="sala" class="form-label" style="margin: 0 auto; margin-bottom: 20px">Sala</label></center>
              <select class="form-select" name="sala" id="sala" required>
                <option id='placeholder' selected disabled hidden value="">Seleccione la Sala</option>
                <?php
                  $consultarsala="SELECT id,sala FROM sala_stock  ORDER BY sala";
                  $ejecutar=mysqli_query($conexion, $consultarsala) or die(mysqli_error($conexion));

                  foreach($ejecutar as $opciones): ?>
                    <option value="<?php echo $opciones['sala']?>">
                      <?php $opciones['id'];echo $opciones['sala']?>
                    </option>
                  <?php endforeach?>
                  
              </select>
            </div>

            <div class="col-md-3" style="margin: auto;">
              <center><label for="nombre_stock" class="form-label" style="margin: 0 auto; margin-bottom: 20px">Tipo de stock</label></center>
              <select class="form-select" name="nombre_stock" id="nombre_stock" required>
                <option id='placeholder' selected disabled hidden value="">Seleccione Stock</option>
                <option value="pointer1" disabled Style="color: #000000; background: #3f8755">--FORMULAS--</option>
                <option value="semestre1">Primer Semestre</option>
                <option value="semestre2">Segundo Semestre</option>
                <option value="pre24">Prematuros 24 calorias</option>
                <option value="noLactosa">Sin Lactosa</option>
                <option value="intregra">Intregra</option>
                <option value="pointer2" disabled Style="color: #000000; background: #3f8755">--MATERIAL--</option>
                <option value="biberones">biberones esteriles</option>
                <option value="biberones">chupos con flujo</option>
                <option value="recolectores">recolectores de leche materna</option>
              </select>
            </div>

            <div class="col-md-2" style="margin: auto;">
              <center><label for="cantidad_stock" class="form-label" style="margin: 0 auto; margin-bottom: 20px">Numero cc</label></center>          
              <input type="number" name="cantidad_stock" id="cantidad_stock" placeholder="---" style=" width:140px;" class="form-control" aria-describedby="helpId" min=1 required>
            </div>

            <div class="col-md-2" style="margin: auto;">
              <center><label for="cantidad_biberon" class="form-label" style="margin: 0 auto; margin-bottom: 20px;">Cantidad</label></center>
              <input type="number" name="cantidad_biberon" id="cantidad_biberon" placeholder="---" style=" width:140px;" class="form-control" aria-describedby="helpId" min=1 required>
            </div>

            <div class="col-md-1" style="margin: auto; margin-left: -35px; margin-bottom: -6px">
              <input type="submit" class="btn" style="background-color: #428E3F; color:white;" value="Agregar"></button>
            </div>

          </div>

          <div class="row-md-4" style="width: 100%; margin: auto; margin-top: 40px" >
            <div class="col-md-12" style="width: 100%; margin: auto;" >
              <label for="observaciones" class="form-label" style="margin-left: 45%;">Observaciones</label>
              <textarea style="width: 70%; margin: 0 auto" type="textarea" name="observaciones" id="observaciones" class="form-control" rows="5" cols="30" aria-describedby="helpId" maxlength="35"></textarea>
            </div>
          </div> 
        </form>
        
        <form method="POST" id="solicitarStock"  action="stock.php" style="margin: auto;"> 
          <div class="row mb-12" style="margin: auto; margin-top: 50px;">
      
            <table hidden id="table" style="margin: 0 auto;" class="table rounded table-responsive table-striped text-center table-bordered-dark">
              <thead class="thead-color">
                <tr>            
                  <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha de solicitud</th>
                  <th class="text-center justify-content-center align-middle bg-success" scope="col">Sala</th>
                  <th class="text-center justify-content-center align-middle bg-success" scope="col">Tipo de Stock</th>
                  <th class="text-center justify-content-center align-middle bg-success" scope="col">Nro. CC</th>
                  <th class="text-center justify-content-center align-middle bg-success" scope="col">Cantidad</th>
                  <th class="text-center justify-content-center align-middle bg-success" scope="col">Observaciones </th>
                  <th class="text-center justify-content-center align-middle bg-success" scope="col"> </th>
                </tr>
              </thead>          
              <nav aria-label="...">

              <tbody id="table_body">
                <!-- Se llena al presionar Añadir, /scripts/stock,js-->       
              </tbody>
            </table>   
                  
          </div>

          <div class="form-group">
            <input type="hidden" class="form-control" id="user_registro" name="user_registro" value="<?php echo ($_SESSION["nombre"])?>">
          </div>

          <div class="row mb-2" style="margin: auto">
        <div class="col-md-5" style="margin: auto; width: 20%">
            <input type="submit" id="agregar" name="agregar" class="btn" style="background-color: #428E3F; color: white; margin: 0 auto;" value="Enviar">
        </div>
    </div>
        </form>
          </div>
        </div>
      </div>  
    </div>       
  </div> 
</div>   
<div id="alertContainer" class="alert" role="alert" hidden></div>


  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'template/footer.php';
 
}
ob_end_flush();
?>
<script>
  function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
}
</script>

<!--
<script>
  document.addEventListener("DOMContentLoaded", function() {
      const checkbox = document.getElementById("checkBiberones");
      const formBiberones = document.getElementById("formBiberones");
      const tipo_biberon = document.getElementById("tipo_biberon");
      const cantidad_biberon = document.getElementById("cantidad_biberon");

      checkbox.addEventListener("change", function() {
          if (checkbox.checked) {
            formBiberones.hidden = false;
            tipo_biberon.required = true;
            cantidad_biberon.required = true;
          } 
          else {
            formBiberones.hidden = true;
            tipo_biberon.required = false;
            cantidad_biberon.required = false;
          }
      });
  });
  
</script>
-->
<script src="./scripts/stock.js"></script>

<!-- Muestra la fecha actual en el formulario -->
<script src="./scripts/TablaBiberones_AgregarNueva_fechaActual.js"></script>

<!-- Muestra la hora actual en el formulario -->
<script src="./scripts/stock_Hora_Actual.js"></script>
