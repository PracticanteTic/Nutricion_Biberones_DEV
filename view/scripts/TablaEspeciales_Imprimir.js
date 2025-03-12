var myApp = new function () {
    this.printTable = function () {
        var contenido = document.getElementById('todo'); 
        var boton_imprimir = document.getElementById("boton_imprimir");
        var input_nombre=document.getElementById("nombre_apellido");
        var input_identificacion=document.getElementById("identificacion");
        var input_fecha_nacimiento=document.getElementById("fecha_nacimiento");
        var input_cuchara=document.getElementById("cuchara");
        var input_episodioResult=document.getElementById("episodioResult");

        boton_imprimir.style.visibility = "hidden";
        input_nombre.style.border="0";
        input_identificacion.style.border="0";
        input_fecha_nacimiento.style.border="0";
        input_cuchara.style.border="0";
        input_episodioResult.style.border="0";
        var style = "<style>";
        style = style + "table {width: 100%; font: 17px Calibri;}";
        style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px; text-align: center;}";
        style = style + "h1 {font-family: 'Times New Roman', 'Courier New', monospace;}";
        style = style + "</style>";
        var win = window.open();
        win.document.write(style);
        win.document.write(contenido.outerHTML);
        win.document.close();
        win.print();
        
        // Vuelve a hacer visible el botón después de abrir la ventana emergente
        // setTimeout(function() {
        //   boton_imprimir.style.visibility = "visible";
        //   input_nombre.style.border="2px solid #e4e7ea";
        //   input_identificacion.style.border="2px solid #e4e7ea";
        //   input_fecha_nacimiento.style.border="2px solid #e4e7ea";
        //   input_cuchara.style.border="2px solid #e4e7ea";
        //   input_episodioResult.style.border="2px solid #e4e7ea";
        
        // }, 1000); // Aquí puedes ajustar el tiempo de espera en milisegundos (1 segundo en este caso)
    }
}