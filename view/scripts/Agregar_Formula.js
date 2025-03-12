$(document).ready(function () {
    $("#tipo_Solicitud").change(function () {
        clearForm();
        getInfoAPI();
        getFormulas();
    });
  });


  $(document).ready(function () {
    $("#old_Formula").change(function () {
        getInfoOldFormulas();
    });
  });


  function getInfoOldFormulas(){
    formula = document.getElementById("old_Formula");
    opt = formula.options[formula.selectedIndex].text;
    especial = 0;
    if(opt.includes("ESPECIAL")){
      especial = 1;
    }
    type = document.getElementById("tipo_Solicitud").value;
    renovate = 0;
    if (type == "renovateFormula"){
        renovate = 3;
    }

    typeRequest = "getInfo";
    oldFormula = document.getElementById("old_Formula").value;
    episode = document.getElementById("episodioInput").value;
    $.ajax({
        url: "../logica/Agregar_Formula_Opciones.php/",
        method : "POST",
        data: {"oldFormula" : oldFormula, "episode" : episode, "renovate" : renovate, "type" : type, "typeRequest" : typeRequest, "especial" : especial},
        success: function(data){
            var quickScript = new Function($(data).text());
            quickScript();
            
        },
        error: function() {
            alert('Not Okay');
        } 
    });
}


function getFormulas(){
    type = document.getElementById("tipo_Solicitud").value;
    episode = document.getElementById("episodioInput").value;
    $.ajax({
        url: "../logica/Agregar_Formula_Opciones.php/",
        method : "POST",
        data: {"typeRequest" : type, "episode" : episode},
        success: function(data){
            var quickScript = new Function($(data).text());
            quickScript();
            
        },
        error: function() {
            alert('Not Okay');
        } 
    });
}

function clearForm(){
    //document.getElementById('episodioInput').value='';
    var fields = document.getElementsByTagName('input'),
        length = fields.length;
    while (length--) {

        //Clears all text fields excluding 'fechaActual'
        if (fields[length].type === 'text' && fields[length].name != 'fechaActual') { fields[length].value = ''; }

        //Clears all numeric fields excluding 'episodio'
        if (fields[length].type === 'number' && fields[length].name != 'episodio') { fields[length].value = ''; }
    }
    //document.getElementById('observaciones').value='';
    document.getElementById('fecha_nacimiento').value='';
    document.getElementById("tipo_formula").value = document.getElementById("tipo_formula").options["placeholder"].value;
    document.getElementById("chupo").value = document.getElementById("chupo").options["placeholder"].value;
    document.getElementById("renovar_formula").checked = false;
    document.getElementById("observaciones").value = '';

}

function getInfoAPI(){    
    var episode = document.getElementById("episodioInput").value;
    $.ajax({
        url: "../logica/ApiAgregar_Formula.php/",
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


function  getBiberonesInfo(){
    var episode = document.getElementById("episodioInput").value;
    $.ajax({
        url: "../logica/BiberonesSQL.php/",
        method : "POST",
        data: {"episodeValue" : episode},
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