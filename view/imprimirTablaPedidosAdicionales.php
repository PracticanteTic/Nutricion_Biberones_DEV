<?php
include('../config/Conexion.php');
ob_start();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Solicitudes de biberones información</title>

  <style>
    table {
      width: 100%;
      font: 15px Calibri;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid black;
      padding: 2px 3px;
      text-align: center;
    }
  </style>
  
</head>
<body>
  

<div class="tabla" id="tabla" >
    <table id="table" class="table rounded text-center table-responsive">
        <thead class="text-center">
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
        <tbody id="table_body">
                <!--MOSTRAR DATOS EN TABLA DE BASES DE DATOS-->
              <?php
        $query = "call sp_ConsultarTabla_SolicitudesAdicionales";
          $result_biberones = mysqli_query($conexion, $query);
          while($row = mysqli_fetch_assoc($result_biberones)) { ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<?php
$html=ob_get_clean();
// echo $html;

require_once('../dompdf/autoload.inc.php');
use Dompdf\Dompdf;
$dompdf=new Dompdf();

$options=$dompdf->getOptions();
$options->set(array('isRemoteEnabled'=> true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'landscape');

$dompdf-> render();
$dompdf->stream("Pedidos_Adicionales.pdf", array("Attachment"=>false));
?>
<!-- 
<script>
    window.print();
</script> -->