  // Obtener el elemento input de la hora
  var relojInput = document.getElementById("reloj");
  var btnSubmit = document.getElementById("agregar");
  var alertContainer = document.getElementById("alertContainer");
  
  var alertShown = false;
  // Funci贸n para obtener la hora actual y mostrarla
  function mostrarHoraActual() {
    var fechaActual = new Date();
    var hora = fechaActual.getHours();
    var minutos = fechaActual.getMinutes();
    var segundos = fechaActual.getSeconds();

    var horaActual = new Date().getHours();

    //if (hora >= 0 && hora < 6) {//Cuando se modifique la hora del if, se debe recargar pagina borrando cache.
    //if (hora >=23 && hora < 23) {//Cuando se modifique la hora del if, se debe recargar pagina borrando cache.
    //   (hora >= 0 && hora < 6)

    if ((hora >= 23 && hora < 24) || (hora >=0 && hora < 6)) {
      btnSubmit.disabled = false;
      alertShown = false;
      } else {
        if(!alertShown){
        alertShown = true;  
        Swal.fire({
          heightAuto: false,
          html: '<label style="color: #ffffff">La hora esta por fuera del rango permitido. Recuerde que el horario esta entre las 00:00 y las 6:00.</label>',
          showCancelButton: false,
          confirmButtonText: 'OK',
          allowOutsideClick: false,
          allowEscapeKey: false,
          iconHtml: '<i class="fa-solid fa-circle-info"></i>',
          customClass: {
              confirmButton: 'btn btn-custom', // Clase personalizada para el bot髇 de confirmaci髇
              title: 'custom-swal', // Clase personalizada para el t韙ulo
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
// Formatear los valores de hora, minutos y segundos agregando ceros iniciales si son menores a 10

    if (hora < 10) {
      hora = "0" + hora;
    }
    if (minutos < 10) {
      minutos = "0" + minutos;
    }
    if (segundos < 10) {
      segundos = "0" + segundos;
    }

    // Construir la cadena de la hora en formato HH:mm:ss
    var horaActual = hora + ":" + minutos + ":" + segundos;
    

    // Establecer el valor del input con la hora actual
    relojInput.value = horaActual;
  }

  // Funci贸n para actualizar la hora cada segundo
  function actualizarHora() {
    setInterval(mostrarHoraActual, 1000); // Actualizar cada 1000 milisegundos (1 segundo)
  }

  // Llamar a la funci贸n de inicializaci贸n al cargar la p谩gina
  actualizarHora();