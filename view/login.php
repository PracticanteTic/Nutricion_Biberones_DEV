<?php

include ('../googleConfig.php');

//if(isset($_GET['code']))
$login_button = '';


if (!isset($_SESSION['access_token'])) {
	//SHOW THE WHOLE FORM WITH THIS BUTTON
	$login_button = '<a href="' . $client->createAuthUrl() . '" id="googleLogin" style="margin: 0 auto; border-radius: 5px; color: white; display: block; font-weight: bold; padding: 20px; text-align: center; text-decoration: none; width: 100%;">
	<svg xmlns="http://www.w3.org/2000/svg" style="margin-bottom: -2px; margin-right: 15px;" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
  <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
</svg>
	Iniciar sesion con Google</a>';
}

else {
	//Just ENTER TO THE APP
	$_GET["op"] = 'googleLogin';
	require_once ("../controller/usuario.php");

}





?>

<!DOCTYPE html>
<html lang="es">

<head>
	
	<title>Inicio | Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
    <link rel="shortcut icon" href="..\favicon.ico" type="image/x-icon">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
	<!--===============================================================================================-->
	
	<style>
		.swal2-popup {
			font-size: 1.6rem !important;
		}
	</style>
</head>

<body>
	
<?php
	

?>

	<div class="wrapper fadeInDown">
  			<div id="formContent">
				<!-- Tabs Titles -->
				<!-- Icon -->
				<div class="fadeIn first">
				<img src="../view/login/images/LogoPrincipal.png" id="icon" alt="User Icon" />
				</div>
				
			
				<!-- Login Form -->
    <!-- Remind Passowrd -->
	<div class="container";>
		<p>
			<strong>Solicitudes de Biberones</strong>
		</p>
		<hr>

		<form method="post" id="frmAcceso">
			<div class="wrap-login100">
				<div class="login100-form validate-form">
					<span class="login100-form-title p-b-37">
						<strong>Iniciar sesión</strong>
					</span><br>
				
						<br>
					<div class="wrap-input100 validate-input" data-validate="Enter username or email">
						<input class="fadeIn fourth" type="text" id="logina" name="logina" placeholder="Ingrese su usuario" autocomplete="new-password">
						<span class="focus-input100"></span>
					</div>
	
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="fadeIn fourth" type="password" id="clavea" name="clavea" placeholder="Ingrese su contraseña">
						<span class="focus-input100"></span>
					</div>
					<div class="">
						<a href="#" onclick="abrirModalRestablecerContra()">
							Olvidaste tu contraseña?
						</a>
					</div>	

					<div class="container-login100-form-btn">
						<button type="submit" class="fadeIn fourth">Iniciar sesión</button>
						<!--<a href="filter_var("-->
					</div>

					<div class="" style="width: 100%">
						
					
					
					
						
						<div class="card" style="border: hidden; margin-bottom: 30px">
							<?php 
							if ($login_button != '') {
								
								echo '<div  align="center" style=" margin: 0 auto ;border: hidden">' . $login_button . '</div>';
							} else {
								echo '<div class="card-body"><p><b>Email :</b> ' . $_SESSION['user_email_address'] . '</p></div>';
								echo '<div class="card-header" style="margin-bottom: 30px"">Usuario no registrado</div>';
								echo '<div  align="center" style=" margin: 0 auto ;border: hidden"><a href="../logout.php" style="margin: 0 auto; border-radius: 5px; color: white; display: block; font-weight: bold; padding: 20px; text-align: center; text-decoration: none; width: 100%; background-color: rgb(67, 134, 194)">Salir de Google</a></div>';
							}
							
							
							?>
						</div>

					</div>

				</div>
			</div>
		</form>
		<div id="formFooter">
			<a class="underlineHover" href="https://www.sanvicentefundacion.com/">San Vicente Fundación</a>
		  </div>
	</div>
</div>
</div>

	<div id="dropDownSelect1"></div>

<!-- Restablecer contraseña modal -->
<div class="modal fade" id="modal_restablecer_contra" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Restablecer contraseña</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <label for=""><b>Ingrese el correo registrado para enviarle una contraseña que le asignara el sistema</b></label>
                        <input type="email" class="form-control" id="txt_email" placeholder="Ingrese Email">
                        <br>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="restablecerContra()">Enviar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<!--fin de restrablecer contraseña -->


<script>
function abrirModalRestablecerContra1() {
	  $('#modal_restablecer_contra').modal('show');
	}

	
function restablecerContra() {
  var email = $('#txt_email').val();

  // Aquí debes realizar una petición AJAX al servidor para enviar el correo electrónico y manejar el restablecimiento de contraseña.

  // Ejemplo de petición AJAX utilizando jQuery:
  $.ajax({
    url: 'ruta_del_script_php_para_restablecer_contrasena.php',
    method: 'POST',
    data: { email: email },
    success: function(response) {
      // Aquí puedes mostrar un mensaje de éxito o cualquier otra acción necesaria después de enviar la solicitud de restablecimiento de contraseña.
    },
    error: function(xhr, status, error) {
      // Aquí puedes manejar errores o mostrar mensajes de error al usuario en caso de que la solicitud de restablecimiento de contraseña falle.
    }
  });
}
	</script>

	<!--===============================================================================================-->
	<script src="lib/jquery19.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/daterangepicker/moment.min.js"></script>
	<script src="login/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="login/js/main.js"></script>
	<!--=======================================ALERTAS JAVASCRIOT==========================================-->
	<script src="scripts/librerias/sweetalert2@9.js"></script>
	<!--=======================================JS USUARIO==========================================-->
	<script type="text/javascript" src="scripts/login.js"></script>

</body>

</html>