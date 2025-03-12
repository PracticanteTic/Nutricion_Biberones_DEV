
  $(document).ready(function() {
     $('#episodio').keydown(function(e) { 
         if (e.key === 'Enter') {//al precionar enter se ejecuta 
             e.preventDefault(); //prevenimos la recarga de la pagina
             var episodio = $("#episodio").val(); //obtenemos el episodio
             if(episodio != 0){ //verificamos que el episodio sea diferente de 0
                 consultar(episodio); //llamamos a la funcion de consultar
             }
         }
      });
      $("#btn-agregar").click(function(e){
        e.preventDefault();//prevenimos la recarga de la pagina
        agregar();//llamamos a la funcion de agregar
      })    
  })

  function agregar() {
  //obtenemos los valores que queremos agregar
    var id_biberon = $("#idBiberon").val();
    var episodio = $("#episodio").val();
    var nombre_paciente = $("#nombre").val();
    var cantidad_cancelar =  parseInt($("#cantidad-cancelar").val(),10);
    var cantidad_solicitados =  parseInt($("#cantidad-solicitada").val(),10);
    var fecha_solicitud = $("#fecha-solicitud").val();
    var fecha_cancelacion = $("#fechaActual").val();
    var id_formula = $("#id_formula").val();
    //alert(nombreUsuario +" "+ episodio + " " + nombre_paciente + " " + cantidad_cancelar + " " + cantidad_solicitados + " " + fecha_cancelacion + " " + fecha_solicitud); // Para depuración

    // verificamos que existan todos
    if (!episodio || !nombre_paciente || !cantidad_cancelar || !cantidad_solicitados || !fecha_solicitud || !fecha_cancelacion) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Algo salio mal, intenta de nuevo!",
          });
        return;
    }
    // Enviar la solicitud AJAX
    if(cantidad_cancelar > cantidad_solicitados){ //verificamos que la cantidad que quieren cancelar sea menor a los que hay
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "La cantidad de biberones es superior a los solicitados!",
          });
          $("#cantidad-cancelar").val("");
          return;
    }
    $.ajax({
        type: "POST",
        url: '../view/tablaBiberones_modal.php', //aca procesamos el CRUD
        data: {
            action: 'insertar', //enviamos la accion y los parametros del insert
            Episodio: episodio,
            id_biberon: id_biberon,
            Nombre_paciente: nombre_paciente,
            Fecha_solicitud: fecha_solicitud,
            Cantidad_cancelar: cantidad_cancelar,
            Cantidad_solicitados: cantidad_solicitados,
            Fecha_cancelacion: fecha_cancelacion,
            nombreUsuario: nombreUsuario,
            id_formula: id_formula
        },
        dataType: "json", // Especificamos que esperamos JSON como respuesta
        success: function(response) {
            console.log(response); // Para depuración
            if (response.hasOwnProperty('respuesta') && response.respuesta === "funciono") {
                //alert("La operación fue exitosa");
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Biberones cancelados con exito',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function() { location.reload(); }, 2000);
            } else if (response.hasOwnProperty('error')) {
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: response.error,
                  });
                  limpiarCampos();
            } else {
                //alert("Respuesta inesperada del servidor");
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Algo salio mal, intenta de nuevo!",
                  });
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response Text:", xhr.responseText); // Mostrar la respuesta completa para depuración
        }
    });
}

  function consultar(episodio) {
     $.ajax({
          type: "POST",
          url: '../view/tablaBiberones_modal.php', //procesamos el crud
          data: {
            action: 'consultar', //enviamos la accion y el episodio que es el parametro de consulta
            Episodio: episodio 
        },
          dataType: "json",
          success: function(response) {
console.log(response);
              if (Array.isArray(response)) {
                  if (response.length > 0) {
                    //asignamos los valores que devolvio la consulta a la bd
                      $("#nombre").val(response[0].nombre_apellido);
                      $("#idBiberon").val(response[0].id_biberon);
                      $("#fecha-solicitud").val(response[0].fecha_modificacion);
                      $("#cantidad-solicitada").val(response[0].numero_biberones);
                      $("#formula").val(response[0].nombre_formula);
                      $("#id_formula").val(response[0].id_tipo_formula);
                      $("#cantidad-cancelar").removeAttr("readonly");    
                      $("#episodio").attr("readonly", true);
                      $("#btn-agregar").removeAttr("disabled");
                     }else{
                        Swal.fire({
                            icon: "warning",
                            title: "Oops...",
                            text: "Esta solicitud no esta estado cancelado!",
                          });
                     }
              } else {
                  console.error("Invalid response format:", response);
                  Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Algo salio mal, intenta de nuevo!",

                  });
              }
          },
          error: function(xhr, status, error) {
              console.error("AJAX Error:", status, error);
              console.log("Response Text:", xhr.responseText); // Mostrar la respuesta completa para depuración
          }
      });

      $("#cerrar-modal").click(function(){
        limpiarCampos();
    })
}

function limpiarCampos(){

    //limpiamos los campos
        $("#episodio").val("");
        $("#fecha-solicitud").val("");
        $("#nombre").val("");
        $("#cantidad-solicitada").val("");
        $("#cantidad-cancelar").val("");
        $("#cantidad-cancelar").attr("readonly", true);    
        $("#episodio").removeAttr("readonly");
        $("#formula").val("");
        $("#id_formula").val(""); 
	$("#idBiberon").val(""); 
  
}
