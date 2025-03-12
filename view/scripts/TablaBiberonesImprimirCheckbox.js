/*$('#printBtn').on('click', function() {
    var checkedRows = $('input[name="print[]"]:checked');
    var data = [];
    checkedRows.each(function() {
        var row = $(this).closest('tr');
        var episodio = row.find('td:eq(0)').text();
        var identificacion = row.find('td:eq(1)').text();
        var sala = row.find('td:eq(2)').text();
        data.push({episodio: episodio, identificacion:identificacion, sala:sala});
    });
    // Enviar datos al servidor con AJAX para generar el nuevo PDF
    $.ajax({
        type: 'POST',
        url: '../view/imprimir.php/',
        data: {data: data},
        success: function(response) {
            console.log("TO BIEN al generar el PDF: " + response);
        },
        error: function(xhr, status, error) {
            console.log("Error al generar el PDF: " + error);
        }
    });
});*/

$('#tablaForm').on('submit', function(e){
    e.preventDefault();
    Swal.fire({
        icon: 'info',
        title: 'Imprimiendo...' ,
        showConfirmButton: false,
        allowOutsideClick: false
    });
    var table = $('#table').DataTable();
    table.destroy();
    TandaByID = new Object();
    Tandas = document.getElementsByName("tanda_Etiquetas[]");
    for(ii=0;ii < Tandas.length; ii++){
        item = Tandas[ii];
        key = item.id;
        value = item.value;
        TandaByID[key] = value;
    }
    jsonTanda = JSON.stringify(TandaByID);
    var formData = new FormData($('#tablaForm')[0]);
    formData.append("TandaByID", jsonTanda);
    $.ajax({
        type: 'POST',
        url: '../view/imprimir.php/',
        data: formData,
        processData: false,
            contentType: false,
        success: function(response) {
            console.log("TO BIEN al generar el PDF: " + response);
            var quickScript2 = new Function($(response).text());
            quickScript2();
            setTimeout(() => { window.location="tabla_biberones.php";}, 1700);
            
        },
        error: function(xhr, status, error) {
            console.log("Error al generar el PDF: " + error);
        }
    });





});