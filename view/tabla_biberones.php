<?php
// $cambioEstado=2;
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
$pageTitle = "Consolidado de solicitud de biberones";
require 'template/header.php';

if ($_SESSION['FormulasPreparadas']==1)
{

  
  //SE USA PARA QUE EL ROL DESIGNADO SEA QUIEN PUEDA MODIFICARLO Y NADIE MÃS
  if ($_SESSION['modificar_estado']!=1)
  {
    $onlyRead = true;
  }else{
    $onlyRead = false;
  }

  if ($_SESSION['NutricionistaEstado']==1)
  {
    $BlockEstado = true;
  }else{
    $BlockEstado = false;
  }
  


?>


<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper mt-4">     
      <!-- <div id="alertContainer" class="alert" role="alert"></div> -->


<!--INICIO MODAL ESTADO-->
<!-- Button trigger modal -->
<!-- Modal -->
<!-- Fin Modal ESTADO -->

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
                    $consultar="SELECT * FROM estado WHERE activo=1";
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
                    $consultar="SELECT * FROM estado WHERE activo_nutricionista=1";
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

    <!-- DataTales Example -->
    <div class="shadow p-3 mb-5 bg-body rounded">    
      <div class="col-md-12">
        <div class="row">
          <h1 class="text-success">Informacion de biberones</h1>
        </div>  
      <br>

<div id="div-fondo" class="fondo-opaco" style="display: none;"></div>

      <dialog id="modal-cancelacion" style="box-sizing: border-box;">
        <form action="POST" id="form-cancelacion">
        <div id="div_cerrarmodal">
            <i id="cerrar-modal" class="fas fa-times" style="padding: 5px;"></i>
        </div>
        <div class="contenido-modal">
            <div id="div-inputs" class="col-md-6">
                <label for="episodio" >Episodio</label>
                <input class="input-modal" name="episodio" id="episodio" type="text" >
            </div>
            <div id="div-inputs" class="col-md-6">
                <label for="fecha-solicitud" >Fecha de solicitud</label>
                <input class="input-modal input-readonly" name="fecha" id="fecha-solicitud" type="text" readonly required>
            </div>
            <div id="div-nombre" class="campo-nombre col-md-6">
                <label for="nombre" id="lb-nombre" >Nombre del Paciente</label>
                <input class="input-modal input-readonly" name="nombre" id="nombre" type="text" readonly required >
            </div>
            <div id="div-nombre" class="campo-nombre col-md-6">
                <label for="formula" id="lb-formula" >Formula</label>
                <input class="input-modal input-readonly" name="formula" id="formula" type="text" readonly required >
            </div>
            <div id="div-nombre" class="campo-nombre col-md-6" style="display: none;">
                <input class="input-modal input-readonly" name="id_formula" id="id_formula" type="text" style="display:none;" readonly required >
            </div>
            <div id="div-inputs" class="col-md-6">
                <label for="cantidad-solicitada" >Cantidad de biberones solicitados</label>
                <input class="input-modal input-readonly" name="cantidad1" id="cantidad-solicitada" type="text" readonly required>
            </div>
            <div id="div-inputs" class="col-md-6">
                <label for="cantidad-cancelar" >Cantidad de biberones a cancelar</label>
                <input class="input-modal " name="cantidad1" id="cantidad-cancelar" type="number" readonly >
            </div>
            <div hidden id="div-inputs" class="col-md-6">
                <input class="input-modal " name="cantidad1" id="idBiberon" type="number" readonly >
            </div>
            <!-- <div class="campo-modal div-boton col-md-5">
                <button class="btn-modal" id="btn-consultar" hidden></button>
            </div> -->
            <div class="campo-modal div-boton col-md-5">
                <center><button class="btn-modal" id="btn-agregar" disabled>Registrar Cancelacion</button></center>
            </div>
        </div>
        </form>
      </dialog>

             <div class="row">
                      
                      
                <div class="col-md-4">
                  <!-- <a href="imprimirTablaSolicitudes.php" style="background-color: #198754;  color: white;padding: 14px 25px; text-align: center; text-decoration: none; display: inline-block;" target="_blank">Imprimir Registros</a> -->
                <br>
                   <?php 
                   //verificamos si tiene acceso al permiso de cancelar biberones
                  if (isset($_SESSION['cancelarBiberones']) && $_SESSION['cancelarBiberones'] ==1) {
                    ?>
                    <button class="btn-modal" id="cancelar-biberones" type="submit">Registrar Biberones Cancelados</button>
                    <?php
                }
                ?>
	    </div>
                <div class="col-md-3"></div>
                <div class="col-md-1"></div>
                <div class="col-md-2">
                  <label for="" class="form-label">Hora de ingreso</label>
                  <input type="text" id="reloj" name="reloj" class="form-control" readonly value required>
                </div>
                  
                        
                    
                  <div class="col-md-2">
                    <label for="" class="form-label">Fecha de ingreso</label>
                    <input type="text" id="fechaActual" name="fechaActual" class="form-control" readonly required>
                  </div>
                  
              
          </div>

                  
      </div>

            <br>
            <iframe name="myframe" id="frame1" src="imprimir.php" style="display:none"></iframe>
            <form id="tablaForm" action="./imprimir.php" method="post" >
              
            
              <div class="tabla" id="tabla">
              <table id="table" class="display nowrap table-responsive" style="width:100%; font-family: Helvetica, sans-serif; ">

                  <thead class="text-center">
                    <tr>          
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Ubicacion del paciente</th>
                      <th id="print" style="width: 30px;" class="text-center justify-content-center align-middle bg-success" scope="col">Episodio</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Identificacion</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Nombres y apellidos</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Fecha de nacimiento</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Nombre de formula</th>                   
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Nro. CC</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Nro. Biberones</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Chupo</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Hora Ingreso</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Fecha Ingreso</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Ultima hora de modificacion</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Comentarios</th>
                      <?php if($BlockEstado != true){?>
                        <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Estado</th>
                      <?php } ?>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">AM</th>
                      <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">PM</th>
                      
                        <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">
                          <?php if($onlyRead != true){?>
                          <div class="col-md-2">
                            <button id="printBtn" type="submit" style="background-color:#198754; border-color:#198754; width:40px; height:40px" name="selectedIds[]" aria-label="Imprimir" title="Imprimir"><i class="fa-solid fa-print fa-2xl" style="color: #ffffff;"></i></button>
                          </div>
                          <?php } ?>
                        </th>
                        <th id="cabecera" class="text-center justify-content-center align-middle bg-success" scope="col">Impresiones</th>
                      
                      
                    </tr>
                  </thead>              
                <tbody id="table_body">
                          
                          
                <?php
                  // Procedimiento Almacenado En Bases de datos
                    $query = "call sp_ConsultarTabla_Preparaciones_v2";
                    // $query->bind_param($id_tipo_formula);
                    $result_biberones = mysqli_query($conexion, $query);
                    // condiciona el cambio de color en los estados
                    
                    $NumRow = 0;
                    while($row = mysqli_fetch_assoc($result_biberones)) { ?>
                      <?php 
                      $NumRow ++;
                      $letraColor = '#ffffff';
                    if ($row['id_estado'] == 5) {

                      // Ingresado
                      $Color = '#0a0a0a';
                    } elseif ($row['id_estado'] == 1) {
                   
                      // Recibido
                      $Color = '#0bd400';
                    } elseif ($row['id_estado'] == 2) {
                   
                      // En Proceso A.M.
                      $letraColor = '#0a0a0a';
                      $Color = '#fbff87';
                    } elseif ($row['id_estado'] == 3) {
                    
                      // En distribuciÃ³n A.M.
                      $letraColor = '#0a0a0a';
                      $Color = '#f0f720';
                    } elseif ($row['id_estado'] == 6) {
                    
                      // Entregado A.M.
                      $Color = '#ffbb00';
                    } elseif ($row['id_estado'] == 7) {
                    
                      // En Proceso P.M.
                      $Color = '#8d8df7';
                    } elseif ($row['id_estado'] == 8) {
                    
                      // En distribuciÃ³n P.M.
                      $Color = '#1d1df0';
                    } elseif ($row['id_estado'] == 9) {
                    
                      // Entregado P.M.
                      $Color = '#a53dff';
                    } elseif ($row['id_estado'] == 11) {
                    
                      // Incompleto A.M
                      $Color = '#01ADF0';
                    } elseif ($row['id_estado'] == 12) {
                    
                      // Incompleto P.M
                      $Color = '#F15222';
                    }
                    else {
                      // 	Cancelado
                        $Color = '#ff4040';

                    }



                  ?>


                      
        
    <tr class="no-print" > <!--name="print[]"-->
    <td><?php echo $row['sala'] ?></td>
    <td id='episodio' style="width: 30px;" ><?php echo $row['episodio'] ?></td>
    <td class="print"><?php echo $row['identificacion'] ?></td>
    <td><?php echo $row['nombre_apellido'] ?></td>
    <td><?php echo $row['fecha_nacimiento'] ?></td>
    <td><?php 
        if($row['Especial'] == 1 && $row['Adicional'] == 1){
          echo "ADICIONAL - ESPECIAL -".$row['nombre_formula'];
        }
        else if($row['Especial'] == 1){
          echo "ESPECIAL ".$row['nombre_formula'];
        }
        else if ($row['Adicional'] == 1){
          echo "ADICIONAL ".$row['nombre_formula'];
        }
        else{
          echo $row['nombre_formula'];
        }
         
      ?></td>
      <td><?php echo $row['numero_cc'] ?></td>
      <td id="Tanda_<?php echo $row["Id_biberon"];?>Total"><?php echo $row['numero_biberones'] ?></td>
      <td><?php echo $row['chupo'] ?></td>
      <td><?php echo $row['hora_ingreso'] ?></td>
      <td><?php echo $row['fecha_ingreso'] ?></td>
      <td><?php echo $row['fecha_modificacion'] ?></td>
      <td><?php echo $row['observaciones'] ?></td>
      
      <?php if($BlockEstado != true){?>
        <td>
    <button id="estadoButton<?php echo $NumRow ?>" name="estadoButton" type="button" class="btn" style="color: <?php echo $letraColor?>; background-color:<?php echo $Color?>; font-size: 12px; font-weight: 700; white-space: nowrap;" data-bs-toggle="modal" data-bs-target="#modal_estado" value="<?php echo $row['id_estado']?>" <?php if($row['id_estado'] == 4 || $row['id_estado'] == 9){ ?> disabled <?php } ?> onclick="cambiarEstadoPreparaciones(<?php echo $row['Id_biberon']?>,<?php echo $row['episodio']?>,'<?php echo $_SESSION['nombre']?>',<?php echo $row['id_estado']?>);">
        <?php echo $row['estado']?> 
    </button>
</td>
      <?php
            }
      ?>
      
      <td>
        <input type="number" <?php if($onlyRead == true)
      {?> readonly <?php } 
      ?> 
      id="Tanda_am<?php echo $row["Id_biberon"];?>" name="tanda_Etiquetas[]" min="0" max="<?php echo $row['numero_biberones'] ?>" <?php if($row['id_estado'] == 4 || $row['id_estado'] == 9){ ?> disabled <?php } ?> onkeyup="if(value<0) value=0; 
      if(value><?php echo $row['numero_biberones']?>) 
        value = <?php echo $row['numero_biberones']?>" value = 0 style="width: 40px">
      </td> <!-- También se modificó ese mismo día -->


      <td> <input type="number" id="Tanda_pm<?php echo $row["Id_biberon"]?>" name="tanda_Etiquetas[]"" style="width: 40px" value = 0  min="0" max="<?php echo $row['numero_biberones']?>" <?php if($row['id_estado'] == 4 || $row['id_estado'] == 9){ ?> disabled <?php } ?>></td> <!-- Nueva modificación el día 25 de Junio del 2024 -->

      

      <td>
    <div class="form-check">
        <input style="height: 20px; width: 20px; border: 2px solid #000" class="form-check-input SelectedBiberones" type="checkbox" id="flexSwitchCheckDefault<?php echo $NumRow ?>" name="selectedIds[]"<?php if($row['id_estado'] == 4 || $row['id_estado'] == 9){ ?> disabled <?php } ?> value="<?php echo $row["Id_biberon"]; ?>">
    </div>
</td> 

<td><?php echo $row['NumImpresiones'] ?></td>
          
    </tr>
<?php } ?>


                <!--CREACION DE PAGINACION 2/3-->

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


<script>
  
  $("#cancelar-biberones").on("click", function() {
    // Abrir el modal
    $("#modal-cancelacion").attr("open", true);

    // Ocultar el fondo
    $("#div-fondo").show();

});

$("#cerrar-modal").on("click", function() {
    // Abrir el modal
    $("#modal-cancelacion").removeAttr("open");

    // Ocultar el fondo
    $("#div-fondo").hide();

});
</script>

<script type="text/javascript">
    var nombreUsuario = "<?php echo $_SESSION['nombre']; ?>";
</script>

<script src="../view/scripts/tablaBiberones.js"></script>
<!-- modifica el modal del estado actual con la funcion onclick -->
<script src="./scripts/TablaBiberonesEstado.js">

</script>

<script src="./scripts/TablaBiberonesImprimirCheckbox.js">

</script>





<script src="./scripts/DeshabilitarRetroceso.js">
//Evita Retroceder <!-- evita que al enviar formulario al dar regresar en el navegador, no se cargue la informaciÃ³n enviada -->
</script>

<script src="./scripts/imprimirDatatable.js"></script>

<script src="./scripts/Datatable.js"></script>

</script>

<script src="../view/scripts/TablaBiberonesHoraActual.js">
// HORA ACTUAL
</script>

<script src="../view/scripts/TablaBiberonesFechaActual.js">
// FECHA ACTUAL
</script>

<script>

</script>
<!-- <script src="../view/scripts/TablaBiberones_SelectEstado.js"> </script> -->