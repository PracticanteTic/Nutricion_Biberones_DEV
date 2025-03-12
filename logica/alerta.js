function mostrarAlerta(mensaje, estado){
    var toastLiveExample = document.getElementById('liveToast')
    var alerta = document.getElementById("miAlerta");

    alerta.innerHTML = mensaje;
    $('#liveToast').removeClass("bg-success");
    $('#liveToast').removeClass("bg-danger");

    if(estado == 'guardado'){
        $('#liveToast').addClass("bg-success");
    } else if(estado == 'no guardado'){
        $('#liveToast').addClass("bg-danger");
    }

    var toast = new bootstrap.Toast(toastLiveExample);
    toast.show();
}