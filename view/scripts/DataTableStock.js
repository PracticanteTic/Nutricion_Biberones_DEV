$(document).ready(function() {
  $('#table').DataTable({
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
          doc.pageOrientation = 'landscape'; 
          var currentDateTime = new Date().toLocaleString();
            
          
          var content = '' + currentDateTime + '\n\n\n\n';
  
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