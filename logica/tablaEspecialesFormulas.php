<script>
    <?php
    include('../config/Conexion.php');

    if (isset($_POST['episodioValue'])) { // Valida que si se le haya enviado un "episodioValue" por medio de la petición 
        $episodio = $_POST['episodioValue']; // Guarda el episodio recibido de la petición en una variable
        $query = "SELECT nombre_formula, id_tipo_formula, fecha_modificacion 
                  FROM solicitudes_especiales 
                  INNER JOIN tipo_formula ON solicitudes_especiales.id_tipo_formula = tipo_formula.id 
                  WHERE episodio = $episodio 
                  AND DATE(fecha_modificacion) AND Vigente = 1";

        $result = mysqli_query($conexion, $query); // Ejecuta el query recibiendo la conexion y el query a ejecutar
        if ($result) { // Valida que $result contenga datos
            ?>

            // #search_Formula es el select, allí el usuario selecciona la formula a trabajar.
            selectFormula = document.getElementById('search_Formula'); // Obtiene el elemento select de "search_formula" 

            // Se recorren todas las opciones del select 
            while (selectFormula.firstChild) { // Mientras el select tenga opcion
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