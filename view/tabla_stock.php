<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

include '../config/Conexion.php';
if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
$pageTitle = "Consolidado de solicitudes Stock";
require 'template/header.php';

if ($_SESSION['Stock']==1)
{

  if ($_SESSION['modificar_estado']!=1)
  {
    $onlyRead = true;
  }else{
    $onlyRead = false;
  }


?>
<br>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
  <form id="actualizarEstado" method="POST">
    <div class="modal fade" id="modal_estado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_estadoLabel">Estado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  
          </div>

          <div class="modal-body">
            <div class="container">
            <?php 
            if ($_SESSION['modificar_estadoNutricionista']==0){
            ?>
              <select class="form-select" name="seleccionar_estado" id="seleccionar_estado">
                <?php
                
                //Traer Desplegable de bases de datos para selecionar estado
                  $consultar="SELECT * FROM `estado_stock` WHERE activo = 1";
                  $ejecutar=mysqli_query($conexion, $consultar) or die(mysqli_error($conexion));
                  foreach($ejecutar as $opciones):
                
                ?>
                <option selected disabled hidden>Seleccione estado</option>
                <option value='<?php echo $opciones['id']?>'>
                <?php
            

            ?>
                  <?php 
                  echo $opciones['estado']
                  ?>
                </option>
            
                <?php
                  endforeach
                  ?>
              </select>

            </div>
            <?php } else{ ?>

              <select class="form-select" name="seleccionar_estado" id="seleccionar_estado">
                <?php
                //Traer Desplegable de bases de datos para selecionar estado
                  $consultar="SELECT * FROM `estado_stock` WHERE activo_nutricionista=1";
                  $ejecutar=mysqli_query($conexion, $consultar) or die(mysqli_error($conexion));
                  foreach($ejecutar as $opciones):


                
                ?>
                <option selected disabled hidden>Seleccione estado</option>
                <option value='<?php echo $opciones['id']?>'>
                <?php


              ?>
                  <?php 
                  echo $opciones['estado']
                  ?>
                </option>

                <?php
                endforeach
                ?>
              </select>

              </div>

              <?php } ?>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <input type="submit" disabled id="actualizar" name="actualizar" class="btn btn-success" value="Actualizar"> 
          </div>

        </div>
      </div>
    </div>
  </form>

<div class="card shadow p-3 mb-8">
<h1 class="text-success">Informacion de solicitudes Stock</h1>       
    <br>

  <!-- <div class="row">     
    <div class="col-md-4">
      <a href="imprimirTablaPedidosAdicionales.php" style="background-color: #198754;  color: white;padding: 14px 25px; text-align: center; text-decoration: none; display: inline-block;" target="_blank">Imprimir Registros</a>
    </div>
  </div> -->
    <br>
    <iframe name="myframe" id="frame1" src="imprimir.php" style="display:none"></iframe>
<div class="row" >
  <div class="col-8" style="margin: auto;  min-width: 90%;">
    <table id="table" style="margin: 0 auto;  width: 100%" class="table rounded table-responsive table-striped text-center table-bordered-dark">
      <thead class="thead-color">
        <tr>            
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha de solicitud</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Sala</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Tipo de Stock</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Nro. CC</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Cantidad</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Observaciones </th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Estado </th>

        </tr>
      </thead>          
      <nav aria-label="...">

      <tbody id="table_body">

      <!--MOSTRAR DATOS EN TABLA DE BASES DE DATOS-->
        <?php
        $query = "SELECT ss.id, ss.Fecha, ss.Sala, ss.Nombre_Stock, ss.Cm_Cubicos, ss.Cantidad, ss.id_estado, ss.Observacion, estado_stock.estado FROM solicitudes_stock as ss INNER JOIN estado_stock ON ss.id_estado = estado_stock.id WHERE DATE(Fecha) = CURDATE()";
        //$query = "SELECT * FROM solicitudes_stock";   Not limited to only today
        $result_biberones = mysqli_query($conexion, $query);
        while($row = mysqli_fetch_array($result_biberones)) { 
        ?>
        <tr class="tr">     
          <td ><?php echo $row['Fecha'] ?></td>
          <td><?php echo $row['Sala'] ?></td>
          <td><?php echo $row['Nombre_Stock'] ?></td>
          <?php
          if($row['Cm_Cubicos'] == 0){
            $row['Cm_Cubicos'] = "N/A";
          }
          ?>
          <td><?php  echo $row['Cm_Cubicos'] ?></td>
          <td><?php echo $row['Cantidad'] ?></td>
          <td style='word-break: break-word'><?php echo $row['Observacion'] ?></td>
          
          <?php
            //SE USA PARA QUE EL ROL DESIGNADO SEA QUIEN PUEDA MODIFICARLO Y NADIE MÃS
            if ($_SESSION['modificar_estado']!=1)
            {
              $disabled = 'disabled';
            }

            $letraColor = '#040404';
            if ($row['id_estado'] == 1) {
            
              // Recibido
              $Color = '#5555ff';
            } elseif ($row['id_estado'] == 2) {
            
              // En Proceso
              $Color = '#00ffff';
            } elseif ($row['id_estado'] == 3) {
            
              // Entregado
              
              $Color = '#0bd400';
            } 



            ?>


            <td>
              <button id="estadoButton" type="button" class="btn" style="color: <?php echo $letraColor?>; border: 2px solid <?php echo $letraColor?>; background-color:<?php echo $Color?>"  data-bs-toggle="modal" data-bs-target="#modal_estado" value="<?php echo $row['id_estado']?>" <?php if($row['id_estado'] == 3 || $onlyRead == true){ ?> disabled <?php
              } ?> onclick="cambiarEstadoPreparaciones(<?php echo $row['id']?>,'<?php echo $_SESSION['nombre']?>',<?php echo $row['id_estado']?>);">
              <?php echo $row['estado']?> </button></td>

              </tr>
          <?php 
        } 
        ?>         
      </tbody>
    </table>  
  </div>
</div> 


              
</div>
</div>
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

<script src="./scripts/TablaStockEstado.js"></script>
<script src="./scripts/DeshabilitarRetroceso.js">
// Evita retroceder PÃ¡gina
</script>

<!-- <script>
$(document).ready(function(){
  $('#campo').on("keyup", function(){
    var value=$(this).val().toLowerCase();
    $('#table_body tr').filter(function(){
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script> -->

<script src="./scripts/DataTableStock.js">

</script>