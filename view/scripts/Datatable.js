$(document).ready(function() {
  var table = $('#table').DataTable({
      autoWidth: true,
      language: {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningún dato disponible en esta tabla",
          "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix": "",
          "sSearch": "Buscar:",
          "sUrl": "",
          "sInfoThousands": ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
              "sFirst": "Primero",
              "sLast": "Último",
              "sNext": "Siguiente",
              "sPrevious": "Anterior"
          },
          "oAria": {
              "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          },
          "buttons": {
              "copy": "Copiar",
              "colvis": "Visibilidad"
          }
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
                  text: 'Fecha: ' + new Date().toLocaleDateString(),
                  columns: [0, 1, 3, 5, 6, 7, 8,12]
              },
              customize: function (doc) {
                  doc.pageOrientation = 'landscape'; 
                  var currentDateTime = new Date().toLocaleString();
                  var content = '' + currentDateTime + '\n\n\n\n';
                  doc.content.splice(0, 0, {
                      text: content,
                      style: 'header'
                  });
              }
          }
      ]
  });
});