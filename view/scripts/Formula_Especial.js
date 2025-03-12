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
    //document.getElementById('observaciones').value='';
    document.getElementById('fecha_nacimiento').value='';
    document.getElementById("observaciones").value = '';

}

function getInfoAPI(){    
    var episode = document.getElementById("episodioInput").value;
    $.ajax({
        url: "../logica/ApiFormula_Especial.php/",
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
        url: "../logica/EspecialSQL.php/",
        method : "POST",
        data: {"episodeInput" : episode},
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


function AnularEspeciales(){
    var episode = document.getElementById("episodioInput").value;
    $.ajax({
        url: "../logica/cancelarEspecial.php/",
        method : "POST",
        data: {"episode" : episode},
        success: function(data){
            //alert('Yes: ' + $(data).text());
                var quickScript2 = new Function($(data).text());
                quickScript2();
                clearForm();                
                document.getElementById("episodioInput").value = "";
                document.getElementById("CancelarEspeciales").hidden = true;

        },
        error: function() {
            alert('Not Okay');
        } 
    });

}