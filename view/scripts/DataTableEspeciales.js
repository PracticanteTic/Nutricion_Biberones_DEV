$(document).ready(function() {
    $('#table').DataTable({
      "ordering":false, // Evita que organice los datos 
      language: {
        // configuración del idioma
      },
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excel',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdf',
          exportOptions: {
            columns: ':visible'
          },
          customize: function(doc) {
            // Cambiar la orientación a horizontal
            doc.pageOrientation = 'landscape';
            
            // Obtener la fecha y hora actual
            var currentDateTime = new Date().toLocaleString();
            
            // Obtener los valores de los campos necesarios
            var nombre_apellido = $('#nombre_apellido').val();
            var identificacion = $('#identificacion').val();
            var fecha_nacimiento = $('#fecha_nacimiento').val();
            var cuchara = $('#cuchara').val();
            var episodio = $('#episodioResult').val();
            var tipo_formula = $('#tipo_formula').val();
            var volumen = $('#volumen').val();
            var numero_biberon = $('#numero_biberon').val();
            var observaciones = $('#observaciones').val();
    
            // Crear el contenido personalizado con la fecha y hora
            var content = '' + currentDateTime + '\n\n\n\n';
            content += 'Nombres y apellidos: ' + nombre_apellido + '\n\n';
            content += 'Identificación: ' + identificacion + '\n\n';
            content += 'Fecha de nacimiento: ' + fecha_nacimiento + '\n\n';
            content += 'Tamaño de la cuchara: ' + cuchara + '\n\n';
            content += 'Número de episodio: ' + episodio + '\n\n';
            content += 'Nombre de la fórmula: ' + tipo_formula + '\n\n';
            content += 'Volumen de biberón: ' + volumen + '\n\n';
            content += 'Número de biberones: ' + numero_biberon + '\n\n';
            content += 'Observaciones: ' + observaciones + '\n\n';
    
            // Agregar el contenido personalizado al documento
            doc.content.splice(0, 0, {
              text: content,
              style: 'header'
            });
          }
        },
      ]
    });
  });