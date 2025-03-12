let currentBiberonId = 0;
let currentEstado = 0;
let currentEpisodio = 0;
let currentSesion = '';
let currentEstadoActual = '';

function cambiarEstadoPreparaciones(idBiberon, episodio, sesion, estadoActual) {
  currentBiberonId = idBiberon;
  currentEpisodio = episodio;
  currentSesion = sesion;
  currentEstadoActual = estadoActual;

  // Obtener los IDs seleccionados
  var selectedIds = [];
  $('.SelectedBiberones:checked').each(function() {
      selectedIds.push($(this).val());

      //selectedEpisodio.push($(this).data('episodio'));
  });
  //console.log('IDs seleccionados:', selectedIds);

  // Agregar los IDs seleccionados como JSON a un campo oculto
  $('#selectedIds').val(JSON.stringify(selectedIds));

  bloquearOpciones(currentEstadoActual);
}

$(document).ready(function () {
    $("#seleccionar_estado").change(function () {
        document.getElementById("actualizar").disabled = false; 
    });
});

$(document).ready(function() {
    $('#actualizarEstado').submit(function(e) {
        e.preventDefault();

        var formData = new FormData($('#tablaForm')[0]);

        let EstadoProximo = $('#seleccionar_estado').val();
        Estado = parseInt(EstadoProximo);

        formData.append("idBiber", currentBiberonId);
        formData.append("EstadoProximo", Estado);
        formData.append("episodio", currentEpisodio);
        formData.append("EstadoActual", currentEstadoActual);
        formData.append("sesion", currentSesion);

        $.ajax({
            type: "POST",
            url: '../logica/update.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Cambio de estado exitoso',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function() { location.reload(); }, 2000);
                
            }
        }); 
    });
});

function bloquearOpciones(currentEstadoActual) {
    var selectedValue = $('#seleccionar_estado').val();

    if (currentEstadoActual == 5) {
        $('#seleccionar_estado option[value="1"]').prop('disabled', false);
        $('#seleccionar_estado option[value="2"], #seleccionar_estado option[value="3"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="7"], #seleccionar_estado option[value="8"], #seleccionar_estado option[value="6"], #seleccionar_estado option[value="9"]').prop('disabled', true);
    } else if (currentEstadoActual == 1) {
        $('#seleccionar_estado option[value="2"]').prop('disabled', false);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="3"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="7"], #seleccionar_estado option[value="8"], #seleccionar_estado option[value="6"], #seleccionar_estado option[value="9"]').prop('disabled', true);
    } else if (currentEstadoActual == 2) {
        $('#seleccionar_estado option[value="3"]').prop('disabled', false);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="7"], #seleccionar_estado option[value="8"], #seleccionar_estado option[value="6"], #seleccionar_estado option[value="9"]').prop('disabled', true);
    } else if (currentEstadoActual == 3) {
        $('#seleccionar_estado option[value="6"]').prop('disabled', false);
        $('#seleccionar_estado option[value="3"]').prop('disabled', true);
        $('#seleccionar_estado option[value="11"]').prop('disabled', false);
        $('#seleccionar_estado option[value="12"]').prop('disabled', true);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"], #seleccionar_estado option[value="3"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="7"], #seleccionar_estado option[value="8"], #seleccionar_estado option[value="9"]').prop('disabled', true);
    } else if (currentEstadoActual == 6) {
        $('#seleccionar_estado option[value="7"]').prop('disabled', false); 
        $('#seleccionar_estado option[value="9"]').prop('disabled', true); 
        $('#seleccionar_estado option[value="3"]').prop('disabled', true);
        $('#seleccionar_estado option[value="6"]').prop('disabled', true);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="8"]').prop('disabled', true);
    } else if (currentEstadoActual == 11) {
        $('#seleccionar_estado option[value="7"]').prop('disabled', false); 
        $('#seleccionar_estado option[value="9"]').prop('disabled', true); 
        $('#seleccionar_estado option[value="3"]').prop('disabled', true);
        $('#seleccionar_estado option[value="6"]').prop('disabled', true);
        $('#seleccionar_estado option[value="11"]').prop('disabled', true);
        $('#seleccionar_estado option[value="12"]').prop('disabled', true);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="8"]').prop('disabled', true);
    } else if (currentEstadoActual == 7) {
        $('#seleccionar_estado option[value="8"]').prop('disabled', false);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"], #seleccionar_estado option[value="3"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="7"], #seleccionar_estado option[value="6"], #seleccionar_estado option[value="9"]').prop('disabled', true);
        return;
    } else if (currentEstadoActual == 8) {
        $('#seleccionar_estado option[value="9"]').prop('disabled', false);
        $('#seleccionar_estado option[value="8"]').prop('disabled', true);
        $('#seleccionar_estado option[value="11"]').prop('disabled', true);
        $('#seleccionar_estado option[value="12"]').prop('disabled', false);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"], #seleccionar_estado option[value="3"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="7"], #seleccionar_estado option[value="6"]').prop('disabled', true);
        return;
    } else if (currentEstadoActual == 9) {
        $('#seleccionar_estado option[value="9"]').prop('disabled', true);
        $('#seleccionar_estado option[value="6"]').prop('disabled', true);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"], #seleccionar_estado option[value="3"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="7"], #seleccionar_estado option[value="8"]').prop('disabled', true);
    } else if (currentEstadoActual == 12) {
        $('#seleccionar_estado option[value="7"]').prop('disabled', true); 
        $('#seleccionar_estado option[value="9"]').prop('disabled', true); 
        $('#seleccionar_estado option[value="3"]').prop('disabled', true);
        $('#seleccionar_estado option[value="6"]').prop('disabled', true);
        $('#seleccionar_estado option[value="11"]').prop('disabled', true);
        $('#seleccionar_estado option[value="12"]').prop('disabled', true);
        $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"], #seleccionar_estado option[value="5"], #seleccionar_estado option[value="8"]').prop('disabled', true);
    }
}
