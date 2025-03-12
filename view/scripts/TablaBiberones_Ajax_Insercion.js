$(document).ready(function() {
  $('#agregarFormula').submit(function(e) {
    e.preventDefault();

    // Aquí asumimos que tienes un campo de entrada para la cantidad de biberones con el id 'cantidad_biberones'
    var cantidadBiberones = $('#biberones').val();


    /* Al dar click en "enviar" primero mostrará una alerta que indicará si la cantidad de biberones es la correcta, y no hará el proceso de guardar la solicitud
    hasta que de click en el botón "Si, es correcta". */
    if(cantidadBiberones >= 13){ //La cantidad de biberones sea mayor o igual que 13, de lo contrario el va a ejecutar normalmente.
    Swal.fire({
      heightAuto: false,
      html: '<label style="color: #ffffff">OJO, ingresaste ' + cantidadBiberones + ' biberones, esta seguro que la cantidad de biberones solicitada es correcta</label>',
      iconHtml: '<i class="fa-solid fa-circle-info"></i>',
      showCancelButton: true,
      confirmButtonText: 'Si, es correcta',
      cancelButtonText: 'Cancelar',
      customClass: {
        title: 'custom-swal', // Clase personalizada para el título
        popup: 'custom-swal', // Clase personalizada para el popup
        confirmButton: 'btn btn-custom',
        cancelButton: 'btn btn-custom'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        // Si el usuario confirma, continuar con el proceso

        var formula = document.getElementById("tipo_formula");
        var opt = formula.options[formula.selectedIndex].text;
        var especial = 0;
        if (opt.includes("ESPECIAL")) {
          especial = 1;
        }
        var formData = new FormData($('#agregarFormula')[0]);
        formData.append("especial", especial);

        $.ajax({
          type: "POST",
          url: '../logica/crud.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response){
            var quickScript = new Function($(response).text());
            quickScript();
            var txt = "SUCCESS";
            console.log(txt);
            console.log(response);
          },
          error: function(response) {
            var txt = "ERROR";
            console.log(txt);
            console.log(response);
          }
        });
      } else {
        // Si el usuario cancela, no hacer nada
        console.log('Operación cancelada por el usuario');
      }
    });
    }else{
      var formula = document.getElementById("tipo_formula");
      var opt = formula.options[formula.selectedIndex].text;
      var especial = 0;
      if (opt.includes("ESPECIAL")) {
        especial = 1;
      }
      var formData = new FormData($('#agregarFormula')[0]);
      formData.append("especial", especial);

      $.ajax({
        type: "POST",
        url: '../logica/crud.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response){
          var quickScript = new Function($(response).text());
          quickScript();
          var txt = "SUCCESS";
          console.log(txt);
          console.log(response);
        },
        error: function(response) {
          var txt = "ERROR";
          console.log(txt);
          console.log(response);
        }
      });
   }
  });
});