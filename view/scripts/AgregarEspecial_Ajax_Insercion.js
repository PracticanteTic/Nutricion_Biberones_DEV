

$(document).ready(function() {
  $('#formEspecial').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: '../logica/guardar_formulaEspecial.php',
        data: $(this).serialize(),
        success: function(response){
          console.log(response);
          
          if(response==0){

          Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Registro Exitoso',
            showConfirmButton: false,
            timer: 1500  
        })
        
      }
      /*else{
        Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: 'Error al insertar, revise que los datos esten correctos',
            showConfirmButton: false,
            timer: 1500  
        })
        
      }*/
      setTimeout(function(){location.reload();}, 2000);
    }

  });
});
});