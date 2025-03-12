var relojInput = document.getElementById("reloj");
var btnSubmit = document.getElementById("agregar");
var alertContainer = document.getElementById("alertContainer");

var alertShown = false;
// Función para obtener la hora actual y mostrarla
function mostrarHoraActual() {
  var fechaActual = new Date();
  var hora = fechaActual.getHours();
  var minutos = fechaActual.getMinutes();
  var segundos = fechaActual.getSeconds();
  
  // Obtener el valor seleccionado del elemento <select>
  var tipo_solicitudOpcion= document.getElementById("tipo_solicitud").value;
  // var obtenerSala = document.getElementById("sala").value;

   if (((hora >= 7 && hora < 18) && tipo_solicitudOpcion == "1") || ((hora >= 7 && hora < 14) && tipo_solicitudOpcion == "3")) {
    btnSubmit.disabled = false;
    alertShown = false;
  } else {
    if(!alertShown){
      // alertContainer.textContent = "¡Alerta! La hora para diligenciar el formulario es de 7:00am a 14:00pm";
      alertShown = true;  
      Swal.fire({
        heightAuto: false,
        html: '<label style="color: #ffffff">Recuerde que el horario para diligenciar el formulario de adiciones es de 7:00 a 17:45 y para las cancelaciones debe '+
               'diligenciarse de 7:00 a 14:00</label>',
        showCancelButton: false,
        iconHtml: '<i class="fa-solid fa-circle-info"></i>',
        confirmButtonText: 'OK',
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            confirmButton: 'btn btn-custom', // Clase personalizada para el botón de confirmación
            title: 'custom-swal', // Clase personalizada para el título
            popup: 'custom-swal' // Clase personalizada para el popup
        }
    }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "escritorio.php";
        }
    });
    }
    btnSubmit.disabled = true;
  }   
 // if((hora >= 6 && hora <= 11)&& tipo_solicitudOpcion=="3"){
    //   btnSubmit.disabled = false;
    //   alertContainer.classList.remove("alert", "alert-danger");
    //   alertContainer.textContent = "";
    // }else{
    //   alertContainer.classList.add("alert", "alert-danger");
    //   alertContainer.textContent = "¡Alerta! La hora para diligenciar las cancelaciones son de 6:00am a 14:00pm";
    //   btnSubmit.disabled = true;
    // }

    // if((hora >= 6 && hora <= 10) && tipo_solicitudOpcion=="1"){
    //   btnSubmit.disabled = false;
    //   alertContainer.classList.remove("alert", "alert-danger");
    //   alertContainer.textContent = "";
    // }else{
    //   alertContainer.classList.add("alert", "alert-danger");
    //   alertContainer.textContent = "¡Alerta! La hora para diligenciar el formulario es de 6:00 a 18:00";
    //   btnSubmit.disabled = true;
    // }



  if (hora < 10) {
    hora = "0" + hora;
  }
  if (minutos < 10) {
    minutos = "0" + minutos;
  }
  if (segundos < 10) {
    segundos = "0" + segundos;
  }

  var horaActual = hora+":"+minutos+":"+segundos;

  relojInput.value = horaActual;
}

function actualizarHora() {
  setInterval(mostrarHoraActual, 1000);
}

actualizarHora();