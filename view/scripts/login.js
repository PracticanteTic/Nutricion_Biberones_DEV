var sw = 0;
let logina = "";
let clavea = "";
$("#frmAcceso").on('submit', function (e) {
    e.preventDefault();
    
    logina = $("#logina").val();
    clavea = $("#clavea").val();
    
    
    $.post("../controller/usuario.php?op=directorioactivo",
        { "logina": logina, "clavea": clavea },
        function (realData) {
            arrayData = realData.split(/\r?\n/g);
            data = arrayData[1];

            //var quickScript = new Function($(data).text());
            //quickScript();
            //console.log(realData);
            //console.log(data);
            
            if (data == 1) {
                $(location).attr("href", "escritorio.php");        

            }
            else if(data == 3){
                Swal.fire("ACCESO RESTRINGIDO", "No tiene permitido usar este aplicativo", "info"); 

            }   
            else if(data == 4){
                Swal.fire("ROL NO ENCONTRADO", "Usted no tiene un rol asignado", "info");
            }
            else{
                $.post("../controller/usuario.php?op=verificar",
                { "logina": logina, "clavea": clavea },
                function (data) {

                if (data == 2) {
                    Swal.fire("Credenciales Incorrectas", "Por favor, verifique", "warning");
                    //$(location).attr("href", "login.php");
                
                }else {
                    $(location).attr("href", "escritorio.php");
                }
            }); 
            }
            
        });

             
}) 
