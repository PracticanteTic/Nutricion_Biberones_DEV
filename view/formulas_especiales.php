<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
include('../config/Conexion.php');
include_once('../logica/ApiFormula_Especial.php');

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  $pageTitle = "Formulario de fórmulas especiales";
  require 'template/header.php';

  if ($_SESSION['AgregarFormulasEspeciales'] == 1) {

?>

    <script>
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


            //episodioInput.form.submit();

          }
        });
      });
    </script>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mt-4">
      <div id="alertContainer" class="alert" role="alert"></div>
      <form id="formEspecial" method="post">
        <div class="container">
          <div class="card shadow p-3 mb-8">
            <h2 class="text-center  text-success">Fórmula láctea especial</h2>

            <div class="card-header  bg-white">
              <div class="form-group">
                <div class="row ">
                  <div class="col-4">
                    <label class="control-label" for="episodioInput">Episodio</label>
                    <input type="number" class="form-control border border-dark" id="episodioInput" name="episodioInput" placeholder="Introduce el episodio" required onfocusout="clearForm();getInfoAPI();" autofocus min=0 />
                  </div>
                  <div class="col-4"></div>
                  <div class="col-4">
                    <button type="button" id="CancelarEspeciales" class="btn btn-danger" style="margin-top:10%;" onclick="AnularEspeciales();" hidden>Anular Formulas Especiales</button>
                  </div>


                </div>
              </div>
            </div>

            <div class="card-body bg-light">

              <div class="row titles">
                <div class="col">
                  <div class="well">
                    <h4 class="form-label text-divider"><span class="left-span"></span><span>Información del Paciente</span></h4>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-6">
                  <div class="form-group">
                    <label class="control-label" for="nombre_apellido">Nombre y apellido</label>
                    <input type="text" class="form-control bg-white" id="nombre_apellido" name="nombre_apellido" placeholder="---" value="" readonly required autofocus />
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="control-label" for="identificacion">Identificación del Paciente</label>
                    <input type="text" class="form-control bg-white" id="identificacion" name="identificacion" placeholder="---" value="" readonly required autofocus />
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="servicios">Servicios de Hospitalización</label>
                    <input type="text" class="form-control bg-white" id="servicios_hospitalizacion" name="servicios_hospitalizacion" placeholder="---" value="" readonly required autofocus />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="cama">Cama</label>
                    <input type="text" class="form-control bg-white" id="cama" name="cama" placeholder="---" value="" readonly required autofocus>
                  </div>
                </div>
                <div class="col-md-3" hidden>
                  <input type="text" class="form-control  bg-white" id="Unidad_Organizativa" name="Unidad_Organizativa" placeholder="---" value="" readonly required autofocus>
                </div>
                <div class="col-md-3">
                  <label for="fecha_nacimiento" class="control-label">Fecha de Nacimiento</label>
                  <input name='fecha_nacimiento' type="date" class="form-control bg-white" id="fecha_nacimiento" value="" readonly required>
                </div>
              </div>
              <div class="row mb-3">

                <div class="row titles">
                  <div class="col">
                    <div class="well">
                      <h4 class="form-label text-divider"><span class="left-span"></span><span>Información de la formula</span></h4>
                    </div>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="" class="form-label">Nombre de fórmula</label>
                    <select id="select_tipoFormula" class="form-select" name="tipo_formula" onchange="llenarinputcuchara();">
                      <option selected disabled hidden value>Seleccione Nombre de Fórmula</option>
                      <?php
                      $consultarformula = "SELECT * FROM `tipo_formula` WHERE nombre_formula <> 'FORMULA ESPECIAL' AND Id_especialidad IN (1,2)";
                      $ejecutar = mysqli_query($conexion, $consultarformula) or die(mysqli_error($conexion));
                      ?>

                      <?php
                      foreach ($ejecutar as $opciones):
                      ?>

                        <option value="<?php echo $opciones['id'] ?>"> <!--El value de cada OPTION sera el id sacado de la tabla tipo_formula de la bd-->
                          <?php
                          echo $opciones['nombre_formula']
                          ?>
                        </option>

                      <?php
                      endforeach
                      ?>
                    </select>

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label" for="cuchara">Tamaño cuchara medidora (g)</label>
                    <input type="number" class="form-control bg-white" id="cuchara" name="cuchara" placeholder="Tamaño (g)" min=0 required readonly autofocus />
                  </div>
                </div>
              </div>
              <div class="row mb-3">

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label" for="num_teteros">Total de biberones al día</label>
                    <input type="number" class="form-control" id="numero_biberones" name="numero_biberones" placeholder="Introduzca número de Biberones" min=0 required autofocus />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label" for="volumen_biberon">Volumen de cada biberón (cc)</label>
                    <input type="number" class="form-control" id="volumen_biberon" name="volumen_biberon" placeholder="Introduzca número de cc" min=0 required autofocus />
                  </div>
                </div>

                <div class="col-md-4">
                  <center><label for="" class="form-label">Chupo</label></center>
                  <select class="form-select" required name="chupo" id="chupo">
                    <option id='placeholder' selected disabled hidden value="">Necesita chupo</option>
                    <?php
                    $consultarchupo = "SELECT id,chupo FROM chupo";
                    $ejecutar = mysqli_query($conexion, $consultarchupo) or die(mysqli_error($conexion));
                    ?>
                    <?php
                    foreach ($ejecutar as $opciones):
                    ?>
                      <option value="<?php echo $opciones['id'] ?>">
                        <?php $opciones['id'];
                        echo $opciones['chupo'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>

              </div>
              <div class="row mb-3">

                <div class="col-md-2"></div>

                <div class="col-md-3">
                  <label for="" class="form-label">Fecha de ingreso</label>
                  <input type="text" id="fechaActual" name="fechaActual" class="form-control bg-white" readonly required>
                </div>

                <div class="col-md-2"></div>

                <div class="col-md-3">
                  <label for="" class="form-label">Hora de ingreso</label>
                  <input type="text" id="reloj" name="reloj" class="form-control bg-white" min="9:00" max="18:00" readonly value required>
                </div>

                <div class="col-md-2"></div>
              </div>
              <br>
              <div class="row ">
                <div class="col-12  bg-white d-flex justify-content-center align-items-center">
                  <div class="input-group-append ">
                    <span class=" text-success " id="basic-addon1"><br>
                      <h2 style="margin: 0 auto;">Cantidad de ingredientes por un biberón</h2><br>
                    </span>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-3">
                  <h6>Ingredientes</h6>
                </div>
                <div class="col-5">
                  <h6>Cantidad</h6>
                </div>
                <div class="col">
                  <h6>Observaciones</h6>
                </div>
                <hr>
              </div>

              <div class="row mb-3">
                <div class="col-2">
                  <label for="cereal1" class="form-label">Cereal (g)</label>
                </div>
                <div class="col-4">
                  <input type="number" class="form-control" id="cereal" name="cereal" placeholder="Gramos" value="" min=0 onkeyup="if(value<0 || value>99) value='';" step="0.1">
                  <!-- Se agrega el atributo step para permitir el uso de n�meros deciamles y en el onkeyup se realiza que mantenga un rango si es menor a cero y mayor a 99 y
                por �ltimo en la Base de datos se le cambia el tipo de dato a decimal, para que al enviar la formula automaticamente no redondee o 
                aproxime, sino que tome que esa cantidad es la real ingresada y no debe ser redondeada.  -->
                </div>
                <div class="col-6">
                  <input type="text" class="form-control" id="cereal_observaciones" name="cereal_observaciones" placeholder="Observaciones">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-2">
                  <label for="aceite1" class="form-label">Aceite (ml)</label>
                </div>
                <div class="col-4">
                  <input type="number" class="form-control" id="aceite" name="aceite" placeholder="Mililitros" value="" min=0 onkeyup="if(value<0 || value>99) value='';" step="0.1">
                  <!-- Se agrega el atributo step para permitir el uso de n�meros deciamles y en el onkeyup se realiza que mantenga un rango si es menor a cero y mayor a 99 y
                por �ltimo en la Base de datos se le cambia el tipo de dato a decimal, para que al enviar la formula automaticamente no redondee o 
                aproxime, sino que tome que esa cantidad es la real ingresada y no debe ser redondeada.  -->
                </div>
                <div class="col-6">
                  <input type="text" class="form-control" id="aceite_observaciones" name="aceite_observaciones" placeholder="observaciones">
                </div>
              </div>


              <div class="row mb-3">
                <div class="col-2">
                  <label for="procrill" class="form-label">Procrill (g)</label>
                </div>
                <div class="col-sm-4">
                  <input type="number" class="form-control" id="procrill" name="procrill" placeholder="Gramos" value="" min=0 onkeyup="if(value<0 || value>99) value='';" step="0.1">
                  <!-- Se agrega el atributo step para permitir el uso de n�meros deciamles y en el onkeyup se realiza que mantenga un rango si es menor a cero y mayor a 99 y
                por �ltimo en la Base de datos se le cambia el tipo de dato a decimal, para que al enviar la formula automaticamente no redondee o 
                aproxime, sino que tome que esa cantidad es la real ingresada y no debe ser redondeada.  -->
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="procrill_observaciones" name="procrill_observaciones" placeholder="Observaciones">
                </div>
              </div>


              <div class="row mb-3">
                <div class="col-2">
                  <label for="nessugar1" class="form-label">Nessucar (g)</label>
                </div>
                <div class="col-sm-4">
                  <input type="number" class="form-control" id="nessugar" name="nessugar" placeholder="Gramos" value="" min=0 onkeyup="if(value<0 || value>99) value='';" step="0.1">
                  <!-- Se agrega el atributo step para permitir el uso de n�meros deciamles y en el onkeyup se realiza que mantenga un rango si es menor a cero y mayor a 99 y
                por �ltimo en la Base de datos se le cambia el tipo de dato a decimal, para que al enviar la formula automaticamente no redondee o 
                aproxime, sino que tome que esa cantidad es la real ingresada y no debe ser redondeada.  -->
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="nessugar_observaciones" name="nessugar_observaciones" placeholder="Observaciones">
                </div>
              </div>


              <div class="row mb-3">
                <div class="col-2">
                  <label for="sal1" class="form-label">Sal (g)</label>
                </div>
                <div class="col-sm-4">
                  <input type="number" class="form-control" id="sal" name="sal" placeholder="Gramos" value="" min=0 onkeyup="if(value<0 || value>99) value='';" step="0.1">
                  <!-- Se agrega el atributo step para permitir el uso de n�meros deciamles y en el onkeyup se realiza que mantenga un rango si es menor a cero y mayor a 99 y
                por �ltimo en la Base de datos se le cambia el tipo de dato a decimal, para que al enviar la formula automaticamente no redondee o 
                aproxime, sino que tome que esa cantidad es la real ingresada y no debe ser redondeada.  -->
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="sal_observaciones" name="sal_observaciones" placeholder="Observaciones">
                </div>
              </div>


              <div class="row mb-3">
                <div class="col-2">
                  <label for="formula1" class="form-label">F�rmula (g)</label>
                </div>
                <div class="col-sm-4">
                  <input type="number" class="form-control" id="formula" name="formula" placeholder="Gramos" value="" min=0 onkeyup="if(value<0 || value>99) value='';" step="0.1">
                  <!-- Se agrega el atributo step para permitir el uso de n�meros deciamles y en el onkeyup se realiza que mantenga un rango si es menor a cero y mayor a 99 y
                por �ltimo en la Base de datos se le cambia el tipo de dato a decimal, para que al enviar la formula automaticamente no redondee o 
                aproxime, sino que tome que esa cantidad es la real ingresada y no debe ser redondeada.  -->
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="formula_observaciones" name="formula_observaciones" placeholder="Observaciones">
                </div>
              </div>


              <div class="row mb-3">
                <div class="col-2">
                  <label for="otros1" class="form-label">Otros</label>
                </div>
                <div class="col-sm-4">
                  <input type="number" class="form-control" id="otros" name="otros" placeholder="Otros" value="" min=0 onkeyup="if(value<0 || value>99) value='';" step="0.1">
                  <!-- Se agrega el atributo step para permitir el uso de n�meros deciamles y en el onkeyup se realiza que mantenga un rango si es menor a cero y mayor a 99 y
                por �ltimo en la Base de datos se le cambia el tipo de dato a decimal, para que al enviar la formula automaticamente no redondee o 
                aproxime, sino que tome que esa cantidad es la real ingresada y no debe ser redondeada.-->
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="otros_observaciones" name="otros_observaciones" placeholder="Observaciones">
                </div>
              </div>


              <hr>
              <div class="row mb-3">
                <div class="col-12">
                  <label class="control-label" for="observaciones">Observaciones</label>
                  <textarea rows="2" cols="30" class="form-control" id="observaciones" name="observaciones" placeholder="Introduzca una Observación" maxlength="30"></textarea>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-6">
                  <div class="form-group">
                    <label for="" class="form-label">Nutricionista que prescribe</label>
                    <select class="form-select" name="select_nutricionista" id="select_nutricionista" onchange="mostrarID();">
                      <option selected disabled hidden value>Seleccione la persona que prescribe</option>
                      <?php
                      $consultarformula = "SELECT * FROM nutricionistas";
                      $ejecutar = mysqli_query($conexion, $consultarformula) or die(mysqli_error($conexion));
                      $valorSeleccionado = '';
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>
                        <option value="<?php echo $opciones['codigo_empleado'] ?>">
                          <?php echo $opciones['nombre_completo'] ?>
                        </option>
                      <?php endforeach; ?>

                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="control-label" for="registro">Registro Nutricionista</label>
                    <input type="text" class="form-control" id="registro" name="registro" placeholder="Registro Nutricionista" value="" required autofocus />
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="form-group">
                  <input type="hidden" class="form-control" id="user_registro" name="user_registro" value="<?php echo ($_SESSION["nombre"]) ?>">
                </div>
              </div>


              <hr>
              <div class="row">
                <div class="form-group">
                  <input type="submit" id="agregar" name="agregar" class="btn" style="background-color: #428E3F; color:white" value="Enviar">
                </div>
                <div id="respuesta" style="display: none;"></div>
              </div>
            </div>
          </div>

        </div>
    </div>
    </form>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" id="miAlerta"></div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>


    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'template/footer.php';
  ?>

<?php
}
ob_end_flush();
?>


<script type="text/javascript">
  $(document).ready(function() {
    $('#formEspecial').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: '../logica/guardar_formulaEspecial.php',
        data: $(this).serialize(),
        success: function(response) {
          console.log(response);
          if (response == 0) {

            Swal.fire({
              icon: 'success',
              title: 'Registro Exitoso',
              showConfirmButton: false,
              timer: 1500
            })
            setTimeout(function() {
              location.reload();
            }, 2000);
          } else if (response == 1) {
            Swal.fire({
              icon: 'error',
              title: 'Ya existe una solicitud especial para este episodio',
              showConfirmButton: false,
              timer: 1500
            })
            setTimeout(function() {
              location.reload();
            }, 2000);

          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error al insertar, revise que los datos esten correctos',
              showConfirmButton: false,
              timer: 1500
            })
          }

        }

      });
    });
  });
</script>
<script src="./scripts/AgregarEspecial_RegistroNutricionista.js"></script>

<script>
  function llenarinputcuchara() { // El metodo es llamado cuando se detecta un cambio en el select del nombre de la formula y es usado para devolver el valor que deberia ir en el campo de tamaño cuchara
    var select_formula = document.getElementById("select_tipoFormula").value; // Guarda el id del tipo_formula 
    var opcion = {
      valor: select_formula
    };

    $.ajax({
      type: "POST",
      url: '../logica/consultarValorCuchara.php', // URL a donde se enviara la petición
      data: opcion,
      success: function(response) {
        console.log(response); // Depuración 
        // Si la respuesta es success, asigna al campo cuchara el value recibido como respuesta
        $("#cuchara").val(Number(response)); // La respuesta la parseo a Number
      } ,
      error: function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response Text:", xhr.responseText); // Mostrar la respuesta completa para depuración
      }
    });
  }
</script>

<!-- var respuestaNumero = Number(response); // La respuesta la parseo a Number
console.log(respuestaNumero); // Depuración 
// Si la respuesta es success, asigna al campo cuchara el value recibido como respuesta
$("#cuchara").val(respuestaNumero); -->

<!-- <script>
 $("#select_tipoFormula").change(function() {

$("#select_tipoFormula option:selected").each(function() {
    valor = $(this).val();
    console.log(valor);
    $.get("../logica/consultar_tipoFormulaData.php", { valor }, function(data) {
        $("#tamanio_cuchara").html(data);
        console.log(data);
    });
});

});

// function mostrarMedidaCuchara(){
//   const id_select=document.getElementById('tipo_formula').value;
//   if(id_select==1){
//     document.getElementById('cuchara').value = 4.5;
//   }
  
// }
</script> -->

<script src="./scripts/Formula_Especial.js"></script>

<script src="./scripts/DeshabilitarRetroceso.js"></script>



</script>

<script src="./scripts/AgregarEspecial_HoraActual.js"></script>




<script src="./scripts/AgregarEspecial_FechaActual.js"></script>
<script src="./scripts/AgregarEspecial_Llenar_Cuchara.js"></script>
<!--<script src="./scripts/AgregarEspecial_FechaActual.js"></script>-->

<!-- SEGUNDO SELECT AUTOCOMPLETADO CON EL PRIMERO  -->
<!-- <script>
  $(document).ready(function(){
    $('#tipo_formula').val(1);
    recargarLista();
    $('#tipo_formula').change(function(){
      recargarLista();
    })
  })
function recargarLista(){
  $.ajax({
    type:"POST",
    url:"../logica/nombre_formulas.php",
    data:"formula="+$('#tipo_formula').val(),
    success:function(r){
      $('#select2').html(r);
    }
  })
}
</script> -->