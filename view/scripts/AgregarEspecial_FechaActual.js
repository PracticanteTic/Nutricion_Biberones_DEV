var fechaInput = document.getElementById("fechaActual");

// Obtener la fecha actual del servidor
var fechaServidor = new Date();

// Formatear la fecha en formato deseado (por ejemplo, "dd/mm/yyyy")
var dia = fechaServidor.getDate();
var mes = fechaServidor.getMonth() + 1; // Los meses son indexados desde 0
var anio = fechaServidor.getFullYear();

// Agregar un cero inicial si el día o el mes son menores a 10
if (dia < 10) {
  dia = "0" + dia;
}
if (mes < 10) {
  mes = "0" + mes;
}

// Establecer el valor del input con la fecha formateada
fechaInput.value = anio + "/" + mes + "/" + dia;