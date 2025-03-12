<script>
    <?php
    include('../config/Conexion.php');
    
    if (isset($_POST['episodioValue'])) {
        $episodio = $_POST['episodioValue'];
        $query = "SELECT nombre_formula, id_tipo_formula, fecha_modificacion 
                  FROM solicitudes_especiales 
                  INNER JOIN tipo_formula ON solicitudes_especiales.id_tipo_formula = tipo_formula.id 
                  WHERE episodio = $episodio 
                  AND DATE(fecha_modificacion) AND Vigente = 1";

        $result = mysqli_query($conexion, $query);
        if ($result) {
            ?>
            selectFormula = document.getElementById('search_Formula');
            while (selectFormula.firstChild) {
                selectFormula.removeChild(selectFormula.firstChild);
            }
            <?php foreach ($result as $opciones): ?>
                var opt = document.createElement('option');
                opt.value = "<?php echo $opciones['id_tipo_formula']; ?>";
                opt.innerHTML = "<?php echo $opciones['nombre_formula'] . ' - ' . $opciones['fecha_modificacion']; ?>";
                selectFormula.appendChild(opt);
            <?php endforeach; 
        }
    }
    ?>
</script>