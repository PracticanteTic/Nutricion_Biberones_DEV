let currentId = 0;
let currentEstado=0;
let currentSesion='';
// let currentUser='';

function cambiarEstadoPreparaciones(id,sesion,estadoActual){
  currentId = id;
  currentSesion=sesion;
  currentEstadoActual=estadoActual;
  console.log('EstadoActual'+currentEstadoActual);
  bloquearOpciones(currentEstadoActual);
  // cambiarActivo(BotonVal); 
}



$(document).ready(function () {
  $("#seleccionar_estado").change(function () {
      document.getElementById("actualizar").disabled = false; 
  });
});



$(document).ready(function() {
    $('#actualizarEstado').submit(function(e) {
        e.preventDefault();
        let currentEstado1=$(seleccionar_estado).val();
        currentEstado = parseInt(currentEstado1);
        
        // let currentEpisodio1=$(episodio).val();
        // currentEpisodio=parseInt(currentEpisodio1);
        
        let obj = {};
        obj['id'] = currentId;
        obj['idEstado'] = currentEstado;
        obj['sesion']=currentSesion;
        
        console.log(obj['idEstado'])
        $.ajax({
           
            type: "POST",
            url: '../logica/updateStockEstado.php',
            data: obj,
            success: function(response){
              console.log('Love'+ response);
              Swal.fire({
                  position: 'top-center',
                  icon: 'success',
                  title: 'Registro Exitoso',
                  showConfirmButton: false,
                  timer: 1500
                  
              })
              setTimeout(function(){location.reload();}, 2000);
              
              // var jsonData = JSON.parse(response);
              // location.reload();
              
            }
        });
      
    });
});

// 1 Recibido
// 2 En Proceso
// 3 Entregado

function bloquearOpciones(currentEstadoActual) {
  var selectedValue = $('#seleccionar_estado').val();

  console.log("id" + currentId);
  console.log("SELECTED" + selectedValue);

  if (currentEstadoActual == 1) {
    $('#seleccionar_estado option[value="2"]').prop('disabled', false);
    $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="3"]').prop('disabled', true);

  } 
  else if (currentEstadoActual == 2) {
    $('#seleccionar_estado option[value="3"]').prop('disabled', false);
    $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"]').prop('disabled', true);
  
  
  } 
  else if (currentEstadoActual == 3) {
    $('#seleccionar_estado option[value="1"], #seleccionar_estado option[value="2"]').prop('disabled', true);
  }

}