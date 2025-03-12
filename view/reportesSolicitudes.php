<?php
// Activamos el almacenamiento en el buffer
ob_start();
session_start();
include '../config/Conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
    exit();
}

$pageTitle = "Reportes de solicitudes de biberones";
require 'template/header.php';

// Verificar si el usuario tiene acceso
if ($_SESSION['reporteSolicitudes'] == 1) {
    $result_biberones = null;

    // Manejo de la solicitud POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $startDate = isset($_POST['startDate']) && !empty($_POST['startDate']) ? $_POST['startDate'] : null;
        $endDate = isset($_POST['endDate']) && !empty($_POST['endDate']) ? $_POST['endDate'] : null;
        $episodio = isset($_POST['episodioInput']) && !empty($_POST['episodioInput']) ? $_POST['episodioInput'] : null;

        // Guardar datos en la sesión
        $_SESSION['startDate'] = $startDate;
        $_SESSION['endDate'] = $endDate;
        $_SESSION['episodio'] = $episodio;

        // Redirigir a la misma página para evitar reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Recoger datos de la sesión
    if (isset($_SESSION['startDate']) || isset($_SESSION['endDate']) || isset($_SESSION['episodio'])) {
        $startDate = isset($_SESSION['startDate']) ? $_SESSION['startDate'] : null;
        $endDate = isset($_SESSION['endDate']) ? $_SESSION['endDate'] : null;
        $episodio = isset($_SESSION['episodio']) ? $_SESSION['episodio'] : null;

        // Llamada al procedimiento almacenado
        $query = "CALL sp_ConsultarBiberonesHistorico(?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sss', $startDate, $endDate, $episodio);
        $stmt->execute();
        $result_biberones = $stmt->get_result();

        // Limpiar datos de la sesión
        unset($_SESSION['startDate']);
        unset($_SESSION['endDate']);
        unset($_SESSION['episodio']);
    }
?>

<!-- Contenido -->
 <br><br>
<div class="content-wrapper mt-4">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="col-md-12">
            <div class="row">
                <h1 class="text-success">Reportes de solicitudes de biberones</h1>
            </div>
            <br>
            <div class="row">
                <div class="container">
                    <form id="filterForm" method="POST" action="">
                    <div class="form-inline" id="filter-container">
                            <label for="startDate">De:</label>
                            &nbsp;
                            <input type="date" class="form-control" id="startDate" name="startDate">
                            &nbsp;&nbsp;&nbsp;
                            <label for="endDate">Hasta:</label>
                            &nbsp;
                            <input type="date" class="form-control" id="endDate" name="endDate">
                            &nbsp;&nbsp;&nbsp;
                            <label for="episodio">Episodio:</label>
                            &nbsp;
                            <input type="search" class="form-control" id="episodioInput" name="episodioInput">
                            &nbsp;&nbsp;
                            <button id="filterButton" class="btn btn-success" type="submit">Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <iframe name="myframe" id="frame1" src="imprimir.php" style="display:none"></iframe>

        <form id="tablaForm" action="./imprimir.php" method="post">
            <div id="tabla" class="tabla">
                <table id="table" class="display nowrap table-responsive" style="width:99%; font-family: Helvetica, sans-serif; font-size: 8px;">
                    <thead class="thead-color">
                        <tr>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Episodio</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Sala</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombre Completo</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombre de fórmula</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Número de biberones</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Número CC</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Responsable ingreso</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Hora-Fecha Ingreso</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Responsable Estado</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Estado</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha-Hora Modificación</th>
                            <th class="text-center justify-content-center align-middle bg-success" scope="col">Tipo De Fórmula</th>
                     
                            
                        </tr>
                    </thead>
                    <tbody id="table_body">
                    <?php
                        // Renderizar resultados
                        if ($result_biberones && $result_biberones->num_rows > 0) {
                            while ($row = $result_biberones->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['Episodio']}</td>
                                        <td>{$row['sala']}</td>
                                        <td>{$row['NombresApellidos']}</td>
                                        <td>{$row['Nombre_formula']}</td>
                                        <td>{$row['Nro_Biberones']}</td>
                                        <td>{$row['Nro_CC']}</td>
                                        <td>{$row['ResponsableRegistro']}</td>
                                        <td>{$row['FechaHoraIngreso']}  {$row['Hora_Ingreso']}</td>
                                        <td>{$row['ResponsableEstado']}</td>
                                        <td>{$row['Estados']}</td>
                                        <td>{$row['FechaHoraCambioEstado']}  {$row['Hora_Estado']}</td>
                                        <td>{$row['TipoFormula']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12'>No exísten resultados</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="user_registro" name="user_registro" value="<?php echo htmlspecialchars($_SESSION["nombre"]); ?>">
            </div>
        </form>
    </div>
</div>

<?php
} else {
    require 'noacceso.php';
}

require 'template/footer.php';
ob_end_flush();
?>

<!-- modifica el modal del estado actual con la funcion onclick -->
<script src="./scripts/DeshabilitarRetroceso.js">
  //Evita Retroceder <!-- evita que al enviar formulario al dar regresar en el navegador, no se cargue la informaciÃ³n enviada -->
</script>

<script src="./scripts/imprimirDatatable.js"></script>

<!-- <script src="./scripts/DatatableReportes.js"> -->

</script>

<script>
document.getElementById('filterForm').addEventListener('submit', function(event) {
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;

    if ((startDate && !endDate) || (!startDate && endDate)) {
        Swal.fire({
          icon: 'warning',
          text: 'Por favor, complete las fechas',
          showConfirmButton: false,
          timer: 2000
        });       
      event.preventDefault(); // Evita que el formulario se envíe
    }
});

</script>