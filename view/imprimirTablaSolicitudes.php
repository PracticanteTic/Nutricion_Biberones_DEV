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
                      <th id="print" class="text-center justify-content-center align-middle" scope="col">Episodio</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Identificación</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Sala</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Nombre de fórmula</th>                   
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Nro. CC</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Nro. Biberones</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Fecha de nacimiento</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Nombre y apellido</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Chupo</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Fecha</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Hora Ingreso</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Última hora de modificación</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Observaciones	</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle" scope="col">Estado</th>
                     
                    </tr>
                  </thead>              
                <tbody id="table_body">
                          
                          
                <?php
                  // Procedimiento Almacenado En Bases de datos
                    $query = "call sp_ConsultarTabla_Preparaciones";
                    // $query->bind_param($id_tipo_formula);
                    $result_biberones = mysqli_query($conexion, $query);
                    // condiciona el cambio de color en los estados
                    
                    while($row = mysqli_fetch_assoc($result_biberones)) { ?>
                      <?php 
                  if ($row['id_estado'] == 4) {
                    $Color = 'btn btn-danger';
                    $disabled = 'disabled';
                  } else {
                    if ($row['id_estado'] == 1) {
                        $Color = 'btn btn-primary';
                        $disabled = '';
                    } elseif ($row['id_estado'] == 2) {
                        $Color = 'btn btn-success';
                        $disabled = '';
                    } elseif ($row['id_estado'] == 3) {
                        $Color = 'btn btn-warning';
                        $disabled = '';
                    } else {
                        $Color = 'btn btn-dark';
                        $disabled = '';
                    }
                  }?>
                      
        
    <tr class="no-print">
      <td><?php echo $row['episodio'] ?></td>
      <td><?php echo $row['identificacion'] ?></td>
      <td><?php echo $row['sala'] ?></td>
      <td><?php echo $row['nombre_formula'] ?></td>
      <td><?php echo $row['numero_cc'] ?></td>
      <td><?php echo $row['numero_biberones'] ?></td>
      <td><?php echo $row['fecha_nacimiento'] ?></td>
      <td><?php echo $row['nombre_apellido'] ?></td>
      <td><?php echo $row['chupo'] ?></td>
      <td><?php echo $row['fecha_ingreso'] ?></td>
      <td><?php echo $row['hora_ingreso'] ?></td>
      <td><?php echo $row['fecha_modificacion'] ?></td>
      <td><?php echo $row['observaciones'] ?></td>
      <td><?php echo $row['estado']?></td>

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
$dompdf->stream("Solicitudes_Biberones.pdf", array("Attachment"=>false));
?>
<!-- 
<script>
    window.print();
</script> -->