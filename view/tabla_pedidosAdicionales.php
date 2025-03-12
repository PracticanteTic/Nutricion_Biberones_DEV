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
$pageTitle = "Consolidado de solicitudes para fórmulas con pedidos adicionales";
require 'template/header.php';

if ($_SESSION['FormulasAdicionales']==1)
{




?>
<br>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
<div class="card shadow p-3 mb-8">
<h1 class="text-success">Información de pedidos adicionales</h1>       
    <br>

  <!-- <div class="row">     
    <div class="col-md-4">
      <a href="imprimirTablaPedidosAdicionales.php" style="background-color: #198754;  color: white;padding: 14px 25px; text-align: center; text-decoration: none; display: inline-block;" target="_blank">Imprimir Registros</a>
    </div>
  </div> -->
    <br>

    <iframe name="myframe" id="frame1" src="imprimir.php" style="display:none"></iframe>
    <form id="tablaForm" action="./imprimir.php" method="post" >


      <div id="tabla" class="tabla">
      <table id="table" class="display nowrap table-responsive" style="width:100%; font-family: Helvetica, sans-serif; ">
        <thead class="thead-color">
          <tr>            
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Episodio</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Identificación</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombre y apellido</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha de nacimiento</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Hora inicio</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Sala</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Cama</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombre de fórmula</th> 
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Nro. Biberones</th>                   
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Nro. CC</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Tipo de solicitud</th>
            <th class="text-center justify-content-center align-middle bg-success" scope="col">Observaciones </th>
          </tr>
        </thead>          
        <nav aria-label="...">

    <tbody id="table_body">
    <!--MOSTRAR DATOS EN TABLA DE BASES DE DATOS-->
      <?php
      $query = "call sp_ConsultarTabla_SolicitudesAdicionales";
      $result_biberones = mysqli_query($conexion, $query);
      while($row = mysqli_fetch_array($result_biberones)) { 
      ?>
      <tr class="tr">     
        <td><?php echo $row['episodio'] ?></td>
        <td ><?php echo $row['identificacion'] ?></td>
        <td><?php  echo $row['nombre_apellido'] ?></td>
        <td ><?php echo $row['fecha_nacimiento'] ?></td>
        <td><?php echo $row['hora_inicio'] ?></td>
        <td><?php echo $row['sala'] ?></td>
        <td><?php  echo $row['cama'] ?></td>
        <td><?php echo $row['nombre_formula'] ?></td>
        <td><?php echo $row['numero_biberones'] ?></td>
        <td><?php echo $row['numero_cc'] ?></td>
        <td><?php echo $row['tipo_solicitud'] ?></td>
        <td><?php echo $row['observaciones'] ?></td>
      </tr>
      <?php } ?>         
      </tbody>
    </table>   
  </div>
    <div class="form-group">
      <input type="hidden" class="form-control" id="user_registro" name="user_registro" value="<?php echo ($_SESSION["nombre"])?>">
    </div>
  </form>             
</div>
</div>

<!-- /.content-wrapper -->
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
<script src="./scripts/DeshabilitarRetroceso.js">
//Evita Retroceder <!-- evita que al enviar formulario al dar regresar en el navegador, no se cargue la informaciÃ³n enviada -->
</script>

<script src="./scripts/imprimirDatatable.js"></script>

<script src="./scripts/DataTableAdicionales.js"></script>

</script>

