// var myApp = new function () {
//     this.printTable = function () {
//         var tab = document.getElementById('table'); 
//         var boton_imprimir=document.getElementById("printBtn");
//         boton_imprimir.style.visibility="hidden";

//         var style = "<style>";
//         style = style + "table {width: 100%; font: 17px Calibri;}";
//         style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
//         style = style + "padding: 2px 3px; text-align: center;}";
//         style = style + "</style>";
//         var win = window.open();
//         win.document.write(style);
//         win.document.write(tab.outerHTML);
//         win.document.close();
//         win.print();
//     }
//     setTimeout(function() {
//           boton_imprimir.style.visibility = "visible";
//         }, 1000); // Aquí puedes ajustar el tiempo de espera en milisegundos (1 segundo en este caso)

// }