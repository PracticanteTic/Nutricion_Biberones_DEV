<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION["nombre"])) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
} else {
  if ($_SESSION['ventas'] == 1) {
?>
    <html>

    <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <link href="ticket.css" rel="stylesheet" type="text/css">
    </head>

    <body onload="window.print();">
      <?php

      //Incluímos la clase Venta
      require_once "../model/Venta.php";
      //Instanaciamos a la clase con el objeto venta
      $venta = new Venta();
      //En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
      $rspta = $venta->ventacabecera($_GET["id"]);
      //Recorremos todos los valores obtenidos
      $reg = $rspta->fetch_object();

      //Establecemos los datos de la empresa
      $alerta = "Esto no es una Factura";
      $empresa = "BYTE SEVEN";
     

      $mensaje = "Brilla contigo en el trabajo y estudio";
      //$documento = "20477157772";
      $direccion = "Bo. Camelias San Carlos Alzatate, Jalapa";
      $telefono = "5193-1260  -  4070-2201";


      ?>
      <div class="zona_impresion">
        <!-- codigo imprimir -->
        <br>
        <table border="0" align="center" width="300px">
        
          <tr>
            <td align="center">
              <!-- Mostramos los datos de la empresa en el documento HTML -->

              <?php echo $alerta; ?><br>
              .::<strong> <?php echo $empresa; ?></strong>::.<br>
              <!--  <?php //echo $documento; 
                    ?><br> -->
              <?php echo $mensaje; ?><br>
            </td>
          </tr>
          <tr>
            <td align="center"><?php echo $direccion; ?></td>
          </tr>
          <tr>
            <td align="center"><?php echo $telefono; ?></td>
          </tr>
          <tr>
            <td align="center"><?php echo $reg->fecha; ?></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr>
          <tr>
            <!-- Mostramos los datos del cliente en el documento HTML -->
            <td>Cliente: <?php echo $reg->cliente; ?></td>
          </tr>

        </table>
        <br>
        <!-- Mostramos los detalles de la venta en el documento HTML -->
        <table border="0" align="center" width="300px">
          <tr>
            <td>CANT.</td>
            <td>DESCRIPCIÓN</td>
            <td align="right">IMPORTE</td>
          </tr>
          <tr>
            <td colspan="3">==========================================</td>
          </tr>
          <?php
          $rsptad = $venta->ventadetalle($_GET["id"]);
          $cantidad = 0;
          while ($regd = $rsptad->fetch_object()) {
            echo "<tr>";
            echo "<td>" . $regd->cantidad . "</td>";
            echo "<td>" . $regd->articulo;
            echo "<td align='right'>Q. " . $regd->subtotal . "</td>";
            echo "</tr>";
            $cantidad += $regd->cantidad;
          }
          ?>
          <!-- Mostramos los totales de la venta en el documento HTML -->
          <tr>
            <td>&nbsp;</td>
            <td align="right"><b>TOTAL:</b></td>
            <td align="right"><b>Q. <?php echo $reg->total_venta;  ?></b></td>
          </tr>

          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center">¡Gracias por su compra!</td>
          </tr>
          <tr>
            <td colspan="3" align="center">San Carlos Alzatate, Jalapa</td>
          </tr>



        </table>
        <br>
      </div>
      <p>&nbsp;</p>

    </body>

    </html>
<?php
  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>