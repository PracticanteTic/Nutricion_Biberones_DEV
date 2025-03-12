<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $pageTitle ?></title>
  <link rel="shortcut icon" href="..\favicon.ico" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="css/fonts.css">
  <!-- Estilos Personalizados -->
  <link rel="stylesheet" href="css/estilosExtra.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plantilla/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plantilla/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../plantilla/dist/css/adminlte.min.css">
  <link rel="stylesheet" type="text/css" href="css/cssAdicionales/jquery.dataTables.min.css">
  <link rel="stylesheet" href="css/cssAdicionales/responsive.dataTables.min.css">
  <link rel="stylesheet" href="css/cssAdicionales/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../plantilla/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../plantilla/dist/css/datatable.css">
  <link rel="stylesheet" href="css/cssAdicionales/select2-bootstrap.min.css" />
  <link href="css/cssAdicionales/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/cssAdicionales/mdb.lite.min.css" />
  <link rel="stylesheet" href="css/cssAdicionales/mdb.min.css" />
  <link rel="stylesheet" href="css/cssAdicionales/choices.min.css">
  <link rel="stylesheet" href="css/cssAdicionales/bootstrap-select.css" />
  <link rel="stylesheet" href="css/cssAdicionales/tablaBiberones.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

  <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>-->






  </style>
  <style>
    #spinner {
      width: 122px;
      height: 122px;
      border-radius: 50%;
      display: inline-block;
      position: relative;
      border: 7px solid;
      border-color: #FFF #FFF transparent transparent;
      box-sizing: border-box;
      animation: rotation 1s linear infinite;
    }

    #spinner {
      width: 112px;
      height: 112px;
      border-radius: 53%;
      display: inline-block;
      position: relative;
      border: 10px solid;
      border-color: #FFF #FFF transparent transparent;
      box-sizing: border-box;
      animation: rotation 1s linear infinite;
    }

    #spinner::after,
    #spinner::before {
      content: '';
      box-sizing: border-box;
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      margin: auto;
      border: 8px solid;
      border-color: transparent transparent #77cc77 #77cc77;
      width: 82px;
      height: 82px;
      border-radius: 50%;
      box-sizing: border-box;
      animation: rotationBack 0.5s linear infinite;
      transform-origin: center center;
    }

    #spinner::before {
      width: 52px;
      height: 52px;
      border-color: #3F8755 #3F8755 transparent transparent;
      animation: rotation 1.5s linear infinite;
    }

    @keyframes rotation {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes rotationBack {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(-360deg);
      }
    }

    #loading_container {
      position: fixed;
      z-index: 9999;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(rgba(8, 8, 8, 1), rgba(63, 135, 85, 0.4));
      animation: 3s slide-right;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: all 2s;

    }

    .swal2-popup {
      font-size: 1.6rem !important;
    }

    .page-item {
      color: green;
      border: 2px solid;
      padding: 11px;
      margin: 6px;
      border-radius: 20px;
    }

    .page-item:hover {
      background-color: rgb(119, 222, 119);
    }

    .select2-container .select2-choice,
    .select2-result-label {
      font-size: 1.5em;
      height: 41px;
      overflow: auto;
    }

    .select2-selection {
      min-height: 10px !important;
    }

    .select2-container .select2-selection--single {
      height: 35px !important;
    }

    .select2-selection__arrow {
      height: 34px !important;
    }

    table {
      border: none;
      width: auto;
      border-collapse: collapse;
    }

    td {
      padding: 5px 10px;
      text-align: center;
      border: 1px solid #999;
    }

    th {
      padding: 5px 10px;
      text-align: center;
      border: 1px solid #999;
    }

    tr:nth-child(1) {
      background: #dedede;
    }

    .floating-button {
      position: fixed;
      top: 80%;
      right: 1300px;
      transform: translateY(-50%);
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      z-index: 1000;
      /* Asegúrate de que el botón esté siempre en la parte superior */
    }

    #soporte {
      background-color: #007BFF;
      color: #000;
      border-radius: 50%;
      left: 80rem;
      padding: 15px;
      display: flex;
      box-shadow: 0 2px 10px rgba(40, 167, 69);
      transition: background-color 0.3s, box-shadow 0.3s;
      border: none;
    }

    #soporte i {
      justify-content: center;
      /* Espacio entre el icono y el texto */
    }

    #soporte:hover {
      background-color: #0056b3;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
    }

    .custom-icon {
      color: #ffffff;
      /* Cambia este color al que desees */
    }

    .custom-swal {
      color: #ffffff;
      /* Font color */
      background-color: #3F8755;
      /* Background color */
      font-family: Arial, Helvetica, sans-serif;
      border: 5px solid #fff;
    }

    .btn-custom {
      background-color: #000 !important;
      color: #ffffff !important;
      border: 5px solid #ffffff !important;
      font-weight: 700;
      font-size: 25px;
    }

    .form-inline {
      margin-left: 10%;
      margin-bottom: 2%;
    }
  </style>
  <!-- <link rel="icon" href="../images/logo.jpg" type="image/jpg"> -->

</head>


<!-- onload="deshabilitaRetroceso()" -->

<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div id="loading_container">
      <span id="spinner" class="loader"></span>
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link"></a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
      <div class="dropdown">
        <button class="btn btn-white dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <strong><span class="hidden-xs" style="color: #3f8755;"><?php echo $_SESSION['nombre']; ?></span></strong>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li class="user-header">
            <div class="text-center">
              <strong><a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a></strong>
            </div>
          </li>
          <li class="user-footer">
            <a href="../controller/usuario.php?op=salir" class="dropdown-item">
              <i class="fas fa-arrow-left mr-2"></i> Salir
              <span class="float-right text-muted text-sm">ahora</span>
            </a>

          </li>
        </div>
      </div>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a class="brand-link">
        <img src="../plantilla/dist/img/logoColibri.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <h5 class="brand-text font-weight-light" style="color:white">Solicitud Biberones</h5>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">



            <?php




            // if ($_SESSION['modificar_estado'] == 1) {
            //   echo '<li class="nav-item">
            //         <a href="../view/Estados_solicitudes.php" class="nav-link active" style="background-color: #3f8755;">
            //         &nbsp;<i class="fa-solid fa-house fa-lg" style="color: #ffffff;"></i>
            //           <p>
            //           &nbsp;&nbsp;Inicio 
            //           </p>
            //         </a>
            //         </li>';
            // }
            if ($_SESSION['escritorio'] == 1) {
              echo '<li class="nav-item">
        <a href="../view/escritorio.php" class="nav-link active" style="background-color: #3f8755;">
        &nbsp;<i class="fa-solid fa-house fa-lg" style="color: #ffffff;"></i>
          <p>
          &nbsp;&nbsp;Inicio
          </p>
        </a>
        </li>';
            }

            ?>

            <?php
            if ($_SESSION['SolicitudesBiberones'] == 1) {
              echo '<li class="nav-item">
  <a href="#" class="nav-link active" style="background-color: #3f8755;">
  &nbsp;<i class="fa-brands fa-wpforms fa-flip-horizontal fa-lg" style="color: #ffffff;"></i>
    <p>
    &nbsp;&nbsp;Solicitudes de &nbsp;&nbsp
      <i class="fas fa-angle-left right"></i> 
      <br>&nbsp;&nbsp;Biberones
    </p>
  </a>
  ';
              echo '<ul class="nav nav-treeview" style="display: none;">';

              if (($_SESSION['AgregarPedidosAdicionales'] == 1)) {
                echo '<li class="nav-item">
      <a href="pedidosAdicionales.php" class="nav-link">
      <i class="far fa-check-circle nav-icon"></i>
      <p>Adiciones y Modificaciones</p>
      </a>
      </li>';
              }

              if (($_SESSION['AgregarFormulasEspeciales'] == 1)) {
                echo '<li class="nav-item">
      <a href="formulas_especiales.php" class="nav-link">
      <i class="far fa-check-circle nav-icon"></i>
        <p>Formulas especiales</p>
      </a>
    </li>';
              }

              if (($_SESSION['AgregarFormulasPreparadas'] == 1)) {  //Solicitud de Stock realmente
                echo '<li class="nav-item">
    <a href="stock.php" class="nav-link">
        <i class="far fa-check-circle nav-icon"></i>
        <p>Solicitar Stock</p>  
        </a>
    </li>';
              }

              if (($_SESSION['AgregarFormulaBiberones'] == 1)) {
                echo '<li class="nav-item">
    <a href="agregar_formula.php" class="nav-link">
    <i class="far fa-check-circle nav-icon"></i>
      <p>Agregar Formula</p>
    </a>
  </li>';
              }

              echo
              '</ul></li>';
            }

            ?>
            <?php
            if ($_SESSION['FormulasEspeciales'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/especiales.php" class="nav-link active" style="background-color: #3f8755;">
                    <i class="nav-icon fas fa-columns"></i>
                      <p>
                      &nbsp;Consolidado de 
                        <br>Formulas especiales
                      </p>
                    </a>
                    </li>';
            }
            ?>
            <?php
            if ($_SESSION['FormulasAdicionales'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/tabla_pedidosAdicionales.php" class="nav-link active" style="background-color: #3f8755;">
                    <i class="nav-icon fas fa-columns"></i>
                      <p>
                      &nbsp;Consolidado de 
                      <br>Formulas Adicionales
                      </p>
                    </a>
                    </li>';
            }
            ?>

            <?php
            if ($_SESSION['FormulasPreparadas'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/tabla_biberones.php" class="nav-link active" style="background-color: #3f8755;">
                    <i class="nav-icon fas fa-columns"></i>
                      <p>
                        &nbsp;Consolidado de 
                        <br>Solicitud de biberones
                      </p>
                    </a>
                    </li>';
            }
            ?>
      





            <?php
            if ($_SESSION['Stock'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/tabla_stock.php" class="nav-link active" style="background-color: #3f8755;">
                    <i class="nav-icon fas fa-columns"></i>
                      <p>
                      &nbsp;Consolidado de 
                      <br>Solicitudes Stock
                      </p>
                    </a>
                    </li>';
            }
            ?>


	<?php
            if ($_SESSION['reporteSolicitudes'] == 1) {
              echo '<li class="nav-item">
                  <a href="../view/reportesSolicitudes.php" class="nav-link active" style="background-color: #3f8755;">
                  <i class="nav-icon fas fa-columns"></i>
                    <p>
                      &nbsp;Reporte de 
                      <br>Solicitud de biberones
                    </p>
                  </a>
                  </li>';
          }
          ?>
            <?php
            if ($_SESSION['acceso'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active" style="background-color: #3f8755;">
              <i class="nav-icon fas fa-key">
              </i>
              <p>
                Acceso
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="usuarios.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="permisos.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Permisos</p>
                </a>
              </li>
            </ul>
          </li>';
            }
            ?>

            <?php
            if ($_SESSION['ayuda'] == 1) {
              echo '<li class="nav-item">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSdF68H9TPOZWFiENV6RSNb4FjHgcwObq4SaCz6_2GRNImD6NA/viewform?usp=sf_link" class="nav-link active" style="background-color: #3f8755"; target="_blank">
                    <i class="fa-solid fa-hand-holding-hand"></i>
                      <p>
                        Ayuda 
                      </p>
                    </a>
                    </li>';
            }
            ?>






          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <script>
      const loading_container = document.getElementById('loading_container');

      window.addEventListener("load", function() {
        loading_container.style.opacity = '0';
        setTimeout(() => {
          loading_container.style.display = 'none';
        }, 100);

      });
    </script>