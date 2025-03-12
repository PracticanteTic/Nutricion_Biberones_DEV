<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
include '../config/Conexion.php';
if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  $pageTitle = "Consolidado de solicitudes de formulas especiales";
  require 'template/header.php';

  if ($_SESSION['FormulasEspeciales'] == 1) {

    ?>
    <br>
    <script>

      function findEspeciales() {

        button = document.getElementById("consultar");
        button.disabled = true;
        setTimeout(function () {
          button.removeAttribute("disabled");
        }, 200);

        episodioInput = document.getElementById('episodio');
        episodioValue = 0;
        if (episodioInput != null) {
          episodioValue = document.getElementById('episodio').value;
          $.ajax({
            url: "../logica/tablaEspecialesFormulas.php/",
            method: "POST",
            data: { "episodioValue": episodioValue },
            success: function (data) {
              var quickScript2 = new Function($(data).text());
              quickScript2();
            }
          });
        }


      }

      document.addEventListener("DOMContentLoaded", function () {
        episodioInput = document.getElementById('episodio');
        episodioInput.addEventListener('blur', function () {

          findEspeciales();

        });
      });


      document.addEventListener("DOMContentLoaded", function () {
        episodioInput = document.getElementById('episodio');
        episodioInput.addEventListener('keypress', function (event) {
          if (event.keyCode == 13) {
            findEspeciales();

          }
        });
      });



    </script>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="container">
        <form action="" Method="POST">
          <div class="card shadow p-3 mb-8">
            <h1 class="text-success">Informacion de formulas especiales</h1>
            <br>
            <div class="row">
              <div div class="form-group row">

                <div class="row">
                  <div class="col-md-1"></div>

                  <div class="col-4">
                    <label for="episodio" class="col-form-label">Episodio</label>
                    <input type="number" class="form-control" id="episodio" name="episodio"
                      placeholder="Introduce el episodio" required autofocus>
                  </div>

                  <div id="div_Old_Formula" class="col-md-4" style="margin-top: 6px">
                    <label id="oldFormulaLbl" for="" class="form-label">Formula a consultar</label>
                    <select class="form-select " name="search_Formula" id="search_Formula" required value="0">
                    </select>
                  </div>

                  <div class="col-md-1"></div>

                  <div class="col-md-2">
                    <div div class="form-group">
                      <input type="submit" id="consultar" name="consultar" class="btn"
                        style="background-color: #95BE27; margin-top:37px;  color:#ffffff" value="Consultar">
                    </div>
                  </div>

                </div>
              </div>

              <div class="col-4"></div>
            </div>

            <hr>
        </form>
        <?php
        if (isset($_POST['consultar'])) {

          $episodio = $_POST['episodio'];
          $buscarFormula = $_POST['search_Formula'];
          $query = "SELECT 
          solicitudes_especiales.id as id,
          episodio,
          nombre_apellido,
          identificacion,
          servicio,
          fecha_nacimiento,
          cuchara,
          numero_biberones,
          volumen_biberon,
          cereal,
          cereal_obsvc, 
          aceite,
          aceite_obsvc,
          procrill,
          procrill_obsvc,
          nessugar,
          nessugar_obsvc,
          sal, 
          sal_obsvc,
          formula,
          formula_obsvc,
          otros,
          otros_obsvc,
          observaciones,
          codigo_nutricionista,
          registro,
          nombre_formula,
          fecha_modificacion,
          hora_modificacion,
          user_registro
          FROM solicitudes_especiales 
          INNER JOIN tipo_formula ON solicitudes_especiales.id_tipo_formula = tipo_formula.id
          WHERE episodio = $episodio AND id_tipo_formula = $buscarFormula ORDER BY solicitudes_especiales.id DESC LIMIT 1";
          // echo "<script>console.log($query);</script>";
    
          $result_biberones = mysqli_query($conexion, $query);


          while ($row = mysqli_fetch_array($result_biberones)) {
            $fecha_modificacion = $row["fecha_modificacion"];
            $episodio = $row['episodio'];
            $identificacion = $row['identificacion'];
            $tipo_formula = $row['nombre_formula'];
            $nombre_apellido = $row['nombre_apellido'];
            $cuchara = $row['cuchara'];
            // $cama = $row['sala'];
            $observaciones = $row['observaciones'];
            $numero_biberones = $row['numero_biberones'];
            $name_nutricionista = $row['user_registro'];
            $registro = $row['registro'];
            $volumen_biberon = $row['volumen_biberon'];
            $fecha_nac = $row['fecha_nacimiento'];
            $cereal = $row['cereal'];
            $cereal_obsvc = $row['cereal_obsvc'];
            $aceite = $row['aceite'];
            $aceite_obsvc = $row['aceite_obsvc'];
            $procrill = $row['procrill'];
            $procrill_obsvc = $row['procrill_obsvc'];
            $nessugar = $row['nessugar'];
            $nessugar_obsvc = $row['nessugar_obsvc'];
            $sal = $row['sal'];
            $sal_obsvc = $row['sal_obsvc'];
            $formula = $row['formula'];
            $formula_obsvc = $row['formula_obsvc'];
            $otros = $row['otros'];
            $otros_obsvc = $row['otros_obsvc'];
            $id = $row['id'];
          }
        }
        ?>
        <div class="card-header " id="todo">

          <div class="row mb-3">

            <div class="col-md-1"></div>

            <div class="col-md-4">
              <div class="col-xs-12 col-sm-12">
                <label for="inputBirthday" class="control-label">Episodio: </label>
                <input type="text" style="background-color:#ffffff" class="form-control"
                  value="<?php if (isset($episodio)) {
                    echo $episodio;
                  } ?> " id="episodioResult" name='episodioResult' readonly
                  required>
              </div>
            </div>

            <div class="col-md-2">
            <input hidden type="text" style="background-color:#ffffff" class="form-control"
                  value="<?php if (isset($id)) {
                    echo $id;
                  } ?> " id="id">
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label" for="FechaCreacion">Fecha de realizacion: </label>
                <input type="text" style="background-color:#ffffff" class="form-control" id="FechaCreacion"
                  name="FechaCreacion" value="<?php if (isset($fecha_modificacion)) {
                    echo $fecha_modificacion;
                  } ?> "
                  readonly required autofocus />
              </div>
            </div>

            <div class="col-md-1"></div>


          </div>


          <div class="row titles">
            <div class="col">
              <div class="well">
                <h4 class="form-label text-divider"><span class="left-span"></span><span>Informacion del Paciente</span>
                </h4>
              </div>
            </div>
          </div>


          <div class="row mb-3">
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label" for="Nombre">Identificacion: </label>
                <input type="text" style="background-color:#ffffff" class="form-control" id="identificacion"
                  name="identificacion" value="<?php if (isset($identificacion)) {
                    echo $identificacion;
                  } ?> " readonly
                  required autofocus />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label" for="Nombre">Nombre y apellido: </label>
                <input type="text" style="background-color:#ffffff" class="form-control" id="nombre_apellido"
                  name="nombre_apellido" value="<?php if (isset($nombre_apellido)) {
                    echo $nombre_apellido;
                  } ?>" readonly
                  required autofocus />
              </div>
            </div>
            <div class="col-md-3">
              <div class="col-xs-12 col-sm-12">
                <label for="inputBirthday" class="control-label">Fecha de Nacimiento: </label>
                <input type="text" style=" background-color:#ffffff" class="form-control"
                  value="<?php if (isset($fecha_nac)) {
                    echo $fecha_nac;
                  } ?> " id="fecha_nacimiento" name='fecha_nacimiento'
                  readonly required>
              </div>
            </div>
          </div>


          <div class="row titles">
            <div class="col">
              <div class="well">
                <h4 class="form-label text-divider"><span class="left-span"></span><span>Informacion de la Formula
                    Especial</span></h4>
              </div>
            </div>
          </div>


          <div class="row ">

            <div class="col-md-5" style="margin: auto">
              <label for="tipo_formula" class="control-label">Nombre de la formula: </label>
              <input type="text" style=" background-color:#ffffff" class="form-control"
                value="<?php if (isset($tipo_formula)) {
                  echo $tipo_formula;
                } ?>" id="tipo_formula" name='tipo_formula' readonly
                required>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label class="control-label" for="cuchara">Cuchara medidora: </label>
                <input type="text" style="background-color:#ffffff" class="form-control" id="cuchara" name="cuchara"
                  value="<?php if (isset($cuchara)) {
                    echo $cuchara;
                  } ?>" readonly required autofocus />
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label class="control-label" for="volumen">Volumen biberon: </label>
                <input type="text" style="background-color:#ffffff" class="form-control" id="volumen" name="volumen"
                  value="<?php if (isset($volumen_biberon)) {
                    echo $volumen_biberon;
                  } ?>" readonly required autofocus />
              </div>
            </div>

            <div class="col-md-2">
              <label for="inputBirthday" class="control-label">Numero biberones: </label>
              <input type="text" style="background-color:#ffffff" class="form-control"
                value="<?php if (isset($numero_biberones)) {
                  echo $numero_biberones;
                } ?> " id="numero_biberon"
                name='numero_biberon' readonly required>
            </div>

            <div class="col-md-5" style="margin-left: 45px">
              <label for="tipo_formula" class="control-label">Nutricionista que prescribe: </label>
              <input type="text" style=" background-color:#ffffff" class="form-control"
                value="<?php if (isset($name_nutricionista)) {
                  echo $name_nutricionista;
                } ?>" id="name_nutricionista"
                name="name_nutricionista" readonly required>
            </div>

            <div class="col-md-2" style="margin: auto">
              <label for="inputBirthday" class="control-label">Registro: </label>
              <input type="text" style="background-color:#ffffff" class="form-control"
                value="<?php if (isset($registro)) {
                  echo $registro;
                } ?> " id="user_registro" name="user_registro" readonly
                required>
            </div>
          </div>
          <br>
          <div class="row-md-4">
            <div class="col-md-12">
              <label for="" class="form-label">Observaciones:</label>
              <textarea type="textarea" name="observaciones" id="observaciones" class="form-control bg-white" rows="5"
                cols="40" aria-describedby="helpId" value="<?php if (isset($observaciones)) {
                  echo $observaciones;
                } ?>" readonly
                required><?php if (isset($observaciones)) {
                  echo $observaciones;
                } ?></textarea>
            </div>
          </div>

          <br><br>



          <?php if (isset($cereal, $cereal_obsvc, $aceite, $aceite_obsvc, $procrill, $procrill_obsvc, $nessugar, $nessugar_obsvc, $sal, $sal_obsvc, $formula, $otros, $formula_obsvc)) { ?>
            <div class="card-header">
              <div class="input-group-append">
                <h3 id="titulo">Informacion de produccion segun numero de biberones a preparar</h3>
                <div>

                </div>
              </div>

            </div>

            <b class="card-body">
              <!-- <button class="btn" id="boton_imprimir" style="background-color:#198754; border-color:#198754; width:15%; height:40px" name="selectedIds[]" aria-label="Imprimir" title="Imprimir toda la tabla actual" onclick="myApp.printTable();"><i class="fa-sharp fa-solid fa-print fa-xl" style="color: #ffffff; border-color:#ffffff;"></i></button> -->
              <!-- <div class="col-md-4">
  <a href="imprimirTablaEspeciales.php" style="background-color: #198754;  color: white;padding: 14px 25px; text-align: center; text-decoration: none; display: inline-block;" target="_blank">Imprimir Registros</a>
</div> -->
              <table id="table" class="display nowrap" style="width:100%">
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
                  <td id="idCereal" class="col-editable"><?php echo $cereal; ?></td>
                  <td><?php echo $cereal * 2; ?></td>
                  <td><?php echo $cereal * 3; ?></td>
                  <td><?php echo $cereal * 4; ?></td>
                  <td><?php echo $cereal * 5; ?></td>
                  <td><?php echo $cereal * 6; ?></td>
                  <td><?php echo $cereal * 7; ?></td>
                  <td><?php echo $cereal * 8; ?></td>
                  <td id="idCerealObs" class="col-editable"><?php echo $cereal_obsvc; ?></td>
                </tr>
                <tr>
                  <td>Aceite (ml)</td>
                  <td id="idAceite" class="col-editable"><?php echo $aceite; ?></td>
                  <td><?php echo $aceite * 2; ?></td>
                  <td><?php echo $aceite * 3; ?></td>
                  <td><?php echo $aceite * 4; ?></td>
                  <td><?php echo $aceite * 5; ?></td>
                  <td><?php echo $aceite * 6; ?></td>
                  <td><?php echo $aceite * 7; ?></td>
                  <td><?php echo $aceite * 8; ?></td>
                  <td id="idAceiteObs" class="col-editable"><?php echo $aceite_obsvc; ?></td>

                </tr>
                <tr>
                  <td>Procrill (g)</td>
                  <td id="idProcrill" class="col-editable"><?php echo $procrill; ?></td>
                  <td><?php echo $procrill * 2; ?></td>
                  <td><?php echo $procrill * 3; ?></td>
                  <td><?php echo $procrill * 4; ?></td>
                  <td><?php echo $procrill * 5; ?></td>
                  <td><?php echo $procrill * 6; ?></td>
                  <td><?php echo $procrill * 7; ?></td>
                  <td><?php echo $procrill * 8; ?></td>
                  <td id="idProcrillObs" class="col-editable"><?php echo $procrill_obsvc; ?></td>
                </tr>
                <tr>
                  <td>Nessucar (g)</td>
                  <td id="idNessucar" class="col-editable"><?php echo $nessugar; ?></td>
                  <td><?php echo $nessugar * 2; ?></td>
                  <td><?php echo $nessugar * 3; ?></td>
                  <td><?php echo $nessugar * 4; ?></td>
                  <td><?php echo $nessugar * 5; ?></td>
                  <td><?php echo $nessugar * 6; ?></td>
                  <td><?php echo $nessugar * 7; ?></td>
                  <td><?php echo $nessugar * 8; ?></td>
                  <td id="idNessucarObs" class="col-editable"><?php echo $nessugar_obsvc; ?></td>
                </tr>
                <tr>
                  <td>Sal (g)</td>
                  <td id="idSal" class="col-editable"><?php echo $sal; ?></td>
                  <td><?php echo $sal * 2; ?></td>
                  <td><?php echo $sal * 3; ?></td>
                  <td><?php echo $sal * 4; ?></td>
                  <td><?php echo $sal * 5; ?></td>
                  <td><?php echo $sal * 6; ?></td>
                  <td><?php echo $sal * 7; ?></td>
                  <td><?php echo $sal * 8; ?></td>
                  <td id="idSalObs" class="col-editable"><?php echo $sal_obsvc; ?></td>
                </tr>
                <tr>
                  <td>Formula (g)</td>
                  <td id="idFormula" class="col-editable"><?php echo $formula; ?></td>
                  <td><?php echo $formula * 2; ?></td>
                  <td><?php echo $formula * 3; ?></td>
                  <td><?php echo $formula * 4; ?></td>
                  <td><?php echo $formula * 5; ?></td>
                  <td><?php echo $formula * 6; ?></td>
                  <td><?php echo $formula * 7; ?></td>
                  <td><?php echo $formula * 8; ?></td>
                  <td id="idFormulaObs" class="col-editable"><?php echo $formula_obsvc; ?></td>
                </tr>
                <tr>
                  <td>Otros</td>
                  <td id="idOtros" class="col-editable"><?php echo $otros; ?></td>
                  <td><?php echo $otros * 2; ?></td>
                  <td><?php echo $otros * 3; ?></td>
                  <td><?php echo $otros * 4; ?></td>
                  <td><?php echo $otros * 5; ?></td>
                  <td><?php echo $otros * 6; ?></td>
                  <td><?php echo $otros * 7; ?></td>
                  <td><?php echo $otros * 8; ?></td>
                  <td id="idOtrosObs" class="col-editable"><?php echo $otros_obsvc; ?></td>
                </tr>
              <?php } ?>
              <tbody>


              </tbody>
            </table>
            <button class="btn" style="background-color: #95BE27; margin-top:37px;  color:#ffffff" id="editar">EDITAR</buttonc>
            <button class="btn" style="background-color: #95BE27; margin-top:37px;  color:#ffffff" id="guardar">GUARDAR CAMBIOS</button>
          </div>
        </div>
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




<script src="./scripts//DeshabilitarRetroceso.js">
  // Evita volver atras en el navegador
</script>
<script>
$(document).ready(function() {
  $('#guardar').hide();
});

$('#editar').click(function(e) {
  e.preventDefault();
  
  // Habilitar la edición convirtiendo las celdas en inputs de texto
  $('.col-editable').each(function() {
    var currentValue = $(this).text();
    $(this).html('<input type="text" value="' + currentValue + '" />');
  });
  
  // Mostrar el botón de guardar y ocultar el de editar
  $('#editar').hide();
  $('#guardar').show();
});

$("#search_Formula").change(function() {
  var formula = $("#search_Formula option:selected").val();
  console.log(formula);
});


$('#guardar').click(function(e) {
  e.preventDefault();

  var valoresPrimeraColumna = [];
  var valoresSegundaColumna = [];

  $('#table tbody tr').each(function() {
    var inputElem = $(this).find('.col-editable').first().find('input');
    var nuevoValor = inputElem.val() || inputElem.attr('value');
    valoresPrimeraColumna.push(nuevoValor);

    if (nuevoValor) {
      $(this).find('.col-editable').first().html(nuevoValor);

      $(this).find('td').each(function(index) {
        if (index > 1 && index < 9) {
          var valorMultiplicado = nuevoValor * index;
          $(this).html(valorMultiplicado);
        }
      });
    }

    var inputObsElem = $(this).find('.col-editable').last().find('input');
    
    // Si el campo está vacío, asegurarse de guardarlo como una cadena vacía
    var nuevaObservacion = inputObsElem.val() !== undefined ? inputObsElem.val() : '';
    valoresSegundaColumna.push(nuevaObservacion);

    $(this).find('.col-editable').last().html(nuevaObservacion);
  });

  $('#editar').show();
  $('#guardar').hide(); 
  let episodio = $("#episodioResult").val();
  let id = $("#id").val();

  console.log('Valores de la primera columna:', valoresPrimeraColumna);
  console.log('Valores de la última columna:', valoresSegundaColumna);
  console.log('Valores del id:', id);

  $.ajax({
        type: "POST",
        url: 'http://vmsrv-web2.hospital.com/Nutricion/logica/actualizarEspeciales.php', //aca procesamos el CRUD
        data: {
          valoresPrimeraColumna: valoresPrimeraColumna,
          valoresSegundaColumna: valoresSegundaColumna,
          id: id
        },
        dataType: "json", // Especificamos que esperamos JSON como respuesta
        success: function(response) {
            console.log(response); // Para depuración
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Formula actualizada con exito',
                    showConfirmButton: false,
                    timer: 1500
                })
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response Text:", xhr.responseText); // Mostrar la respuesta completa para depuración
        }
    });
});
</script>

<script src="./scripts/TablaEspeciales_Imprimir.js">

</script>

<script src="./scripts/DataTableEspeciales.js">

</script>