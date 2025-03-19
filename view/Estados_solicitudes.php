<?php
//Activamos el almacenamiento en el buffer
include('../config/Conexion.php');
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'template/header.php';

  if ($_SESSION['modificar_estado'] == 1) {


?>
    <br>
    <br>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <div class="tabla" id="tabla">
        <table id="table" class="table rounded text-center table-responsive">
          <thead class="text-center">
            <tr>
              <th class="text-center justify-content-center align-middle bg-success" scope="col">Episodio</th>
              <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha y hora</th>

              <th class="text-center justify-content-center align-middle bg-success" scope="col">Estado</th>
              <th class="text-center justify-content-center align-middle bg-success" scope="col">Nutricionista</th>

            </tr>
          </thead>
          <tbody id="table_body">
            <!--MOSTRAR DATOS EN TABLA DE BASES DE DATOS-->
            <?php
            $query = "call sp_ConsultarTabla_SolicitudesAdicionales";
            $result_biberones = mysqli_query($conexion, $query);
            while ($row = mysqli_fetch_assoc($result_biberones)) { ?>
              <tr class="tr">
                <td><?php echo $row['episodio'] ?></td>
                <td><?php echo $row['id_estado'] ?></td>
                <td><?php echo $row['Fecha_actual'] ?></td>
                <td><?php echo $row['user_registro'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
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

<script>
  function deshabilitaRetroceso() {
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button" //chrome
    window.onhashchange = function() {
      window.location.hash = "";
    }
  }
</script>