$(document).ready(function () {
    $("#tipo_solicitud").change(function () {
      var type = $(this).val();
      var formula = document.getElementById("tipo_formula");
      var cantidad = document.getElementById("numero_biberones");
      var cc = document.getElementById("numero_cc");
      var chupo = document.getElementById("chupo");
      clearForm();
      getInfoAPI();
      getOptions();

      switch (type){

        case "1":   //Cambio

            formula.value = formula.options["placeholder"].value;
            chupo.value = chupo.options["placeholder"].value

        break;

        case "2":   //Adición

            formula.value = formula.options["placeholder"].value;
            formula.disabled = false;
            cantidad.readOnly = false;
            cc.readOnly = false;
            chupo.value = chupo.options["placeholder"].value
            chupo.disabled = false;

        break;

        case "3":   //Cancelación

            formula.value = formula.options["placeholder"].value;
            chupo.value = chupo.options["placeholder"].value;
            
            getOptions();

        break;


      }
    });
  });

//   $(document).ready(function () {
//     $("#tipo_formula").change(function () {
//         saveHiddenValues();
//     });
//   });

//   $(document).ready(function () {
//     $("#chupo").change(function () {
//         saveHiddenValues();
      
//     });
//   });

  $(document).ready(function () {
    $("#old_Formula").change(function () {
        getOptionsInfo();
        //saveHiddenValues();

    });
  });

// function fillForm(){
//     document.getElementById("agregar").disabled = true;
//     setTimeout(function(){document.getElementById("agregar").disabled = false;},200);
//     clearForm();
//     getInfoAPI();
//     getOptions();
// }

function clearForm(){
    //document.getElementById('episodioInput').value='';
    var fields = document.getElementsByTagName('input'),
        length = fields.length;
    while (length--) {

        //Clears all text fields excluding 'fechaActual'
        if (fields[length].type === 'text' && fields[length].name != 'fechaActual') { fields[length].value = ''; }

        //Clears all numeric fields excluding 'episodio'
        if (fields[length].type === 'number' && fields[length].name != 'episodioInput') { fields[length].value = ''; }
    }
    document.getElementById('observaciones').value='';
    document.getElementById('fecha_nacimiento').value='';
    
}

function getInfoAPI(){    
    var episode = document.getElementById("episodioInput").value;
    $.ajax({
        url: "../logica/ApiFormula_Adicional.php/",
        method : "POST",
        data: {"episodeInput" : episode},
        success: function(data){
            //alert('Yes: ' + $(data).text());
            var quickScript = new Function($(data).text());
            quickScript();
            
        },
        error: function() {
            alert('Not Okay');
        } 
    });
}

function  getOptions(){
    var tipo = document.getElementById("tipo_solicitud").value;
    var type = "add";
    if(tipo == 3){
        type = "cancel";
    }
    var episode = document.getElementById("episodioInput").value;
    $.ajax({
        url: "../logica/AdicionalSQL.php/",
        method : "POST",
        data: {"episodeInput" : episode, "type" : type},
        success: function(data){
            //alert('Yes: ' + $(data).text());
                var quickScript2 = new Function($(data).text());
                quickScript2();

        },
        error: function() {
            alert('Not Okay');
        } 
    });
    
}

function  getOptionsInfo(){
    var tipo = document.getElementById("tipo_solicitud").value;
    var oldFormula = document.getElementById("old_Formula").value;
    if(tipo == 3){
        var episode = document.getElementById("episodioInput").value;
        $.ajax({
            url: "../logica/AdicionalSQL.php/",
            method : "POST",
            data: {"episodeInput" : episode, "type" : "info", "oldFormula" : oldFormula},
            success: function(data){
                //alert('Yes: ' + $(data).text());
                    var quickScript2 = new Function($(data).text());
                    quickScript2();

            },
            error: function() {
                alert('Not Okay');
            } 
        });
    }
    
    
}

function saveHiddenValues(){
    var formula = document.getElementById("tipo_formula");
    console.log("valor::::" + formula.value);
    var chupo = document.getElementById("chupo");
    var h_formula = document.getElementById("Htipo_formula");
    var h_chupo = document.getElementById("Hchupo");
    h_formula.setAttribute('value', formula.value);
    h_chupo.setAttribute('value', chupo.value); 
}