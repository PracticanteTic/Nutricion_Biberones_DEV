  // Obtener el elemento input de la hora
  var relojInput = document.getElementById("reloj");
  var btnSubmit = document.getElementById("agregar");
  var alertContainer = document.getElementById("alertContainer");
  
  // Función para obtener la hora actual y mostrarla
  function mostrarHoraActual() {
    var fechaActual = new Date();
    var hora = fechaActual.getHours();
    var minutos = fechaActual.getMinutes();
    var segundos = fechaActual.getSeconds();

    var horaActual = new Date().getHours();

    var obtenerEstado = document.getElementById("seleccionar_estado").value;

    /*if (hora > 6 && hora < 24 && obtenerEstado=="4") {
      alertContainer.classList.add("alert", "alert-danger");      
      btnSubmit.disabled = false;
      alertContainer.classList.remove("alert", "alert-danger"); // Remover la clase "alert-danger" del contenedor de alerta si no se cumple la condición
      alertContainer.textContent = ""; // Borrar el texto de la alerta si no se cumple la condición
      btnSubmit.disabled = true;

      } else {
      // Agregar la clase "alert-danger" al contenedor de alerta
      alertContainer.classList.remove("alert", "alert-danger");
      alertContainer.textContent = "";

      alertContainer.classList.add("alert", "alert-danger");
      alertContainer.textContent = "¡Alerta! La hora está fuera del rango permitido."; // Establecer el texto de la alerta
      }*/





    // Formatear los valores de hora, minutos y segundos agregando ceros iniciales si son 
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

  // Función para actualizar la hora cada segundo
  function actualizarHora() {
    setInterval(mostrarHoraActual, 1000); // Actualizar cada 1000 milisegundos (1 segundo)
  }

  // Llamar a la función de inicialización al cargar la página
  actualizarHora();