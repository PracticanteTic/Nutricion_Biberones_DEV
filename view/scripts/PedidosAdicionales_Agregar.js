$(document).ready(function () {
  let especial = 0 
  // Evento para habilitar campos al hacer clic en el bot n "agregar"
  $("#agregar").click(function () {
    var formula = $("#tipo_formula option:selected").text();
    var chupo = document.getElementById("chupo");
    console.log(formula)
    
    if (formula.trim().includes("ESPECIAL")) {
      especial = 1
      console.log(especial)
    }
    else{
      especial = 0
      console.log(especial)
    }
  });

  // Evento para manejar el envío del formulario "agregarPedidoAdicional"

  /* Esta lógica permite controlar la cantidad de biberones que se ingresan a cada solicitud que se realiza minimizando los posibles errores que puedan cometer
  los enfermeros a la hora de diligenciar las fórmulas, la notificación únicamente aparecerá si el tipo de solicitud es Adicion id =1; de lo contrario al dar click
  en "enviar" seguirá su proceso.*/
  $('#agregarPedidoAdicional').submit(function (e) {
    e.preventDefault();
    console.log(especial)
    var cantidadBiberones = $('#numero_biberones').val();
    var tipo_solicitud = $('#tipo_solicitud').val();

    if (tipo_solicitud == '1' && cantidadBiberones >= 13) { //Únicamente se cumple siempre y cuando la solicitud sea Adicion "1" y la cantidad de biberones sea mayor o igual que 13, de lo contrario el va a ejecutar normalmente.
      Swal.fire({
        heightAuto: false,
        html: '<label style="color: #ffffff">OJO, ingresaste ' + cantidadBiberones + ' biberones, estas seguro que la cantidad de biberones solicitada es correcta</label>',
        iconHtml: '<i class="fa-solid fa-circle-info"></i>',
        showCancelButton: true,
        confirmButtonText: 'Si, es correcta',
        cancelButtonText: 'Cancelar',
        customClass: {
          title: 'custom-swal', 
          popup: 'custom-swal', 
          confirmButton: 'btn btn-custom',
          cancelButton: 'btn btn-custom'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: '../logica/agregarPedidos_Adicionales.php',
            data: $('#agregarPedidoAdicional').serialize()+ '&especial='+ especial,
            success: function (response) {
              console.log(response);
              var quickScript = new Function($(response).text());
              quickScript();
            },
            error: function (response) {
              console.log('Error:', response);
            }
          });
        } else {
          console.log('Operación cancelada por el usuario');
        }
      });
    } else {
      $.ajax({
        type: "POST",
        url: '../logica/agregarPedidos_Adicionales.php',
        data: $('#agregarPedidoAdicional').serialize()+ '&especial='+ especial,
        success: function (response) {
          console.log(response);
          var quickScript = new Function($(response).text());
          quickScript();
        },
        error: function (response) {
          console.log('Error:', response);
        }
      });
    }
  });
});