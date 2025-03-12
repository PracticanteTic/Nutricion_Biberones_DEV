var relojInput = document.getElementById("reloj");
var btnSubmit = document.getElementById("agregar");
var alertContainer = document.getElementById("alertContainer");
// Función para obtener la hora actual y mostrarla
function mostrarHoraActual() {
  var fechaActual = new Date();
  var hora = fechaActual.getHours();
  var minutos = fechaActual.getMinutes();
  var segundos = fechaActual.getSeconds();

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