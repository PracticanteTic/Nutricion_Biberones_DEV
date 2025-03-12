var relojInput = document.getElementById("reloj");

function mostrarHoraActual(){
  var fechaActual = new Date();

  var hora = fechaActual.getHours();
  var minutos = fechaActual.getMinutes();
  var segundos = fechaActual.getSeconds();

  if(hora < 10){
    hora = "0" + hora;
  }
  if(minutos < 10 ){
    minutos = "0" + minutos;
  }

  if(segundos <10){
    segundos = "0"+ segundos;
  }

  var horaActual = hora +":"+ minutos +":"+ segundos;

  relojInput.value = horaActual;
}

function actualizarHora(){
    setInterval(mostrarHoraActual,1000);
}

actualizarHora();
