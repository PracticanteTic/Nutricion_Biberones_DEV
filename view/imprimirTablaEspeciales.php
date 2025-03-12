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


  
<table id="table" class="table rounded table-striped text-center table-bordered-dark">
  <thead class="thead-color">
    <tr>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">Ingredientes</th>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">1</th>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">2</th>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">3</th>                   
      <th class="text-center justify-content-center align-middle bg-success" scope="col">4</th>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">5</th>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">6</th>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">7</th>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">8</th>
      <th class="text-center justify-content-center align-middle bg-success" scope="col">Observaciones</th>
    </tr>
  </thead> 
  <tr>  
      <td>Cereal (g)</td>
      <td><?php echo $cereal;?></td>
      <td><?php echo $cereal*2;?></td>
      <td><?php echo $cereal*3;?></td>
      <td><?php echo $cereal*4;?></td>
      <td><?php echo $cereal*5;?></td>
      <td><?php echo $cereal*6;?></td>
      <td><?php echo $cereal*7;?></td>
      <td><?php echo $cereal*8;?></td>
      <td><?php echo $cereal_obsvc?></td>
  
  </tr>   
  <tr>  
      <td>Aceite (ml)</td>
      <td><?php echo $aceite;?></td>
      <td><?php echo $aceite*2;?></td>
      <td><?php echo $aceite*3;?></td>
      <td><?php echo $aceite*4;?></td>
      <td><?php echo $aceite*5;?></td>
      <td><?php echo $aceite*6;?></td>
      <td><?php echo $aceite*7;?></td>
      <td><?php echo $aceite*8;?></td>
      <td><?php echo $aceite_obsvc;?></td>
      
  </tr>  
  <tr>  
      <td>Procrill (g)</td>
      <td><?php echo $procrill;?></td>
      <td><?php echo $procrill*2;?></td>
      <td><?php echo $procrill*3;?></td>
      <td><?php echo $procrill*4;?></td>
      <td><?php echo $procrill*5;?></td>
      <td><?php echo $procrill*6;?></td>
      <td><?php echo $procrill*7;?></td>
      <td><?php echo $procrill*8;?></td>
      <td><?php echo $procrill_obsvc;?></td>
  </tr>  
  <tr>  
      <td>Nessucar (g)</td>
      <td><?php echo $nessugar;?></td>
      <td><?php echo $nessugar*2;?></td>
      <td><?php echo $nessugar*3;?></td>
      <td><?php echo $nessugar*4;?></td>
      <td><?php echo $nessugar*5;?></td>
      <td><?php echo $nessugar*6;?></td>
      <td><?php echo $nessugar*7;?></td>
      <td><?php echo $nessugar*8;?></td>
      <td><?php echo $nessugar_obsvc;?></td>
  </tr>  
  <tr>  
      <td>Sal (g)</td>
      <td><?php echo $sal;?></td>
      <td><?php echo $sal*2;?></td>
      <td><?php echo $sal*3;?></td>
      <td><?php echo $sal*4;?></td>
      <td><?php echo $sal*5;?></td>
      <td><?php echo $sal*6;?></td>
      <td><?php echo $sal*7;?></td>
      <td><?php echo $sal*8;?></td>
      <td><?php echo $sal_obsvc;?></td>
  </tr>  
  <tr>  
      <td>Fórmula (g)</td>
      <td><?php echo $formula;?></td>
      <td><?php echo $formula*2;?></td>
      <td><?php echo $formula*3;?></td>
      <td><?php echo $formula*4;?></td>
      <td><?php echo $formula*5;?></td>
      <td><?php echo $formula*6;?></td>
      <td><?php echo $formula*7;?></td>
      <td><?php echo $formula*8;?></td>
      <td><?php echo $formula_obsvc;?></td>
  </tr> 
  <tr>  
    <td>Otros</td>
    <td><?php echo $otros;?></td>
    <td><?php echo $otros*2;?></td>
    <td><?php echo $otros*3;?></td>
    <td><?php echo $otros*4;?></td>
    <td><?php echo $otros*5;?></td>
    <td><?php echo $otros*6;?></td>
    <td><?php echo $otros*7;?></td>
    <td><?php echo $otros*8;?></td>
    <td><?php echo $otros_obsvc;?></td>
  </tr> 
<tbody>
       
  
</tbody>
</table>  
            
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
$dompdf->stream("Solicitudes_Especiales.pdf", array("Attachment"=>false));
?>
<!-- 
<script>
    window.print();
</script> -->