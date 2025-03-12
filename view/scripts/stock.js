//var index = 1;



$(document).ready(function() {
  $('#solicitarStock').submit(function(e) {
    e.preventDefault();

    var myTableArray = [];
    $("table#table tr").each(function() { 
        var arrayOfThisRow = [];
        var tableData = $(this).find('td');
        if (tableData.length > 0) {
            tableData.each(function() { arrayOfThisRow.push($(this).text()); });
            myTableArray.push(arrayOfThisRow);
        }
        else{

        }
    });

    
    $.ajax({
      type: "POST",
      url: '../logica/saveStock.php',
      data: {"table" : myTableArray},
      success: function(response){
        if(response==""){
          Swal.fire({
            icon: 'warning',
            title: 'Agregue almenos 1 Stock a solicitar, por favor',
            showConfirmButton: false,
            timer: 1500  
          });
        }else{
          var quickScript = new Function($(response).text());
          quickScript();
        }
      },
      error: function(response) {
        var txt = "ERROR";
        console.log(txt);
        console.log(response);
      } 

    });
  });
});

$(document).ready(function () {
  $("#nombre_stock").change(function () {
    var stock = $(this).val();
    var cc = document.getElementById("cantidad_stock");
    if(stock == "biberones" || stock == "recolectores"){
      cc.disabled = true;
      cc.placeholder = "---";
      cc.value = "";
    }
    else{
      cc.placeholder = "0";
      cc.value = "";
      cc.disabled = false;

    }
  });
});


$(document).ready(function() {
  $('#agregarLinea').submit(function(e) {
    e.preventDefault();
  var table = document.getElementById("table");
  table.hidden = false;
  //table.setAttribute('hidden', false);
  var date = document.getElementById("fechaActual").value;
  var sala = document.getElementById("sala");
  sala.disabled = true;
  var ii = sala.selectedIndex;
  sala = sala.options[ii].text;
  var tipoStock = document.getElementById("nombre_stock");
  var index = tipoStock.selectedIndex;
  var option = tipoStock.options[index];
  tipoStock = option.text;
  option.disabled = true;
 // tipoStock = tipoStock.options[i].text;
  var cc = document.getElementById("cantidad_stock").value;
  if(cc == ""){
    cc= "N/A";
  } 
  cc= cc.replace(/^0+/, '');
  var cantidad = document.getElementById("cantidad_biberon").value;
  cantidad = cantidad.replace(/^0+/, '');
  var observacion = document.getElementById("observaciones").value;


  var html = "<tr >";
      html += "<td name='date[]'>"+date+"</td>";
      html += "<td name='sala[]'>"+sala+"</td>";
      html += "<td name='stock[]'>"+tipoStock+"</td>";
      html += "<td name='cc[]'>"+cc+"</td>";
      html += "<td name='cantidad[]'>"+cantidad+"</td>";
      html += "<td name='observacion[]' style='word-break: break-word'>"+observacion+"</td>";
      html += "<td><button type='button' id='"+index+"' class='btn' style='background-color: #CF142B; color:white; font-weight: 900; margin: 0 auto' onclick='deleteRow(this);'>X</button></td>"
  html += "</tr>";

  var row = document.getElementById("table_body").insertRow();
  row.innerHTML = html;
  cleanForm();
})});


function cleanForm(){

  document.getElementById("nombre_stock").value = document.getElementById("nombre_stock").options["placeholder"].value;
  document.getElementById("cantidad_stock").value = "";
  document.getElementById("cantidad_biberon").value = "";
  document.getElementById("observaciones").value = "";
  document.getElementById("cantidad_stock").disabled = false;
}

function deleteRow(button) {
  var i = button.id;
  var tipoStock = document.getElementById("nombre_stock");
  var option = tipoStock.options[i];
  option.disabled = false;

  button.parentElement.parentElement.remove();
  if(document.getElementById("table").rows.length == 1){
    document.getElementById("table").setAttribute('hidden', true);
    var sala = document.getElementById("sala");
    sala.disabled = false;

  }
  // first parentElement will be td and second will be tr.
}