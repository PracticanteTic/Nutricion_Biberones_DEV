<?php
//Activamos el almacenamiento en el buffer
include('../config/Conexion.php');
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.php");
}
else
{
  $pageTitle = "Pagina Principal";
require 'template/header.php';

if ($_SESSION['escritorio']==1)
{

?>
<br>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        
      <!-- <div class="row justify-content-center align-items-center vh-100"> -->
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
          <!-- <h1>¡HOLA!&nbsp;<?php echo $_SESSION['nombre']?>&nbsp;BIENVENID@</h1> -->
              <h2 class="text-success"><strong>Central de mezclas enterales</strong></h2>
              <br>
              <img class="par img-fluid img-size-grande" src="../view/login/images/lactancia.jpg">
              <br></br>
              <h2 class="text-success"><strong>Lactancia materna siempre como primera opcion</strong></h2>
              <br>

              <p>La Organizacion Mundial de la Salud -OMS- recomienda que los bebes deben ser amamantados exclusivamente durante los primeros 
                seis meses de vida y despues de introducir alimentos complementarios nutricionalmente adecuados y seguros, mientras se
                continua con la lactancia materna hasta los dos anos de edad o mas. Sin embargo, 
                tambien establece unas razones medicas aceptables para el uso de formulas infantiles. 
              </p>
              

              <h2 class="text-success"><strong>Generalidades de la central de mezclas enterales</strong></h2>
              

              <p style="color:rgb(151,191,14)"><strong>Cual es su funcion</strong></p>

              <p>Entregar de manera oportuna un producto nutricional que responda a las necesidades clinicas y nutricionales 
                (calculadas a partir de los requerimientos propios  de la poblacion infantil) del paciente asegurando la calidad microbiologica y 
                nutricional. 
              </p>
              

              <p>En esta area se realizan dos actividades grandes relacionadas con la alimentacion de los bebes:</p>
              <div>
                <ul>
                  <li>Se dosifica y/o fortifica la leche materna que algunas madres se extraen para proporcionar a sus bebes.</li>
                  <li>Se realiza la preparacion de sucedaneos de leche materna y/o formulas infantiles especializadas.</li>
                </ul>
            </div>

            <p style="color:rgb(151,191,14)"><strong>Cual es la produccion diaria</strong></p>

            <p>Diariamente se producen aproximadamente 400 biberones para la atencion de 60 ninos en promedio.</p>

            <p style="color:rgb(151,191,14)"><strong>Quien se encuentra detras del servicio</strong></p>
            <div>
                <ul>
                  <li>1 jefe lactario.</li>
                  <li>4 auxiliares de enfermeria.</li>
                  <li>1 auxiliar de servicios generales.</li>
                </ul>
            </div>

            <p style="color:rgb(151,191,14)"><strong>Como funciona</strong></p>

            <p>Este servicio funciona de manera central, esto quiere decir que toda la produccion 
              se realiza en una sola area (primer piso del bloque 11 Hospital Infantil). 
            </p>

            <p>Cuenta con los servicios de tres terceros: Diamante que se encarga del lavado / desinfeccion de los biberones, aseo general del area y distribucion de los biberones a salas de hospitalizacion por fuera del Infantil, Corpaul realiza la esterilizacion 
                de los  biberones y Compass Group, se encarga de la distribucion a las diferentes salas del Hospital Infantil.
            </p>

            <p>
            Diariamente las listas de solicitud de biberones de cada servicio deben ser enviadas 
            por la mensajeria interna del Hospital al area de produccion entre 6:00 a 6:30. 
            </p>

            <p>
            Los auxiliares de la central de mezclas realizan 
            la programacion de la produccion (estimando las onzas a preparar por tipo de formula) 
            en dos tandas: manana y tarde. 
            </p>

            <p>La distribucion de los biberones se realiza en dos momentos del dia asi:</p>
            <div>
                <ul>
                  <li>Auxiliares de distribucion del servicio de alimentacion (Compass): salas del Hospital Infantil.</li>
                  <li>Mensajeria interna del Hospital (DIAMANTE): salas de hospitalizacion por fuera del Hospital Infantil.</li>
                </ul>
            </div>

            <p><strong>Horario de funcionamiento:  lunes a domingo de 6:00 a 18:00.</strong></p>

            <p style="color:rgb(151,191,14)"><strong>Condiciones de seguridad</strong></p>
            <div>
                <ul>
                  <li>Por seguridad del paciente no se realizara la produccion de ninguna solicitud que tenga informacion incompleta. Es responsabilidad 
                    de enfermeria el correcto diligenciamiento de la lista de solicitud y su entrega de manera oportuna a la central de mezclas.</li>
                  <li>No esta autorizado el reingreso de biberones para realizar ajustes sobre los mismos a la zona de produccion de la central de mezclas.</li>
                </ul>
            </div>

            <h2 class="text-success"><strong>Horarios para solicitudes a la central de mezclas enterales</strong></h2>
            </br>
            

            <p><strong>Horarios para solicitudes a la central de mezclas enterales.</strong></p>
            <p style="color:rgb(151,191,14)"><strong>Tanda de produccion:</strong></p>
            <p>Corresponde al periodo de tiempo en el cual los auxiliares de la central de
              mezclas realizan la marcacion, preparacion y ensamble de los biberones
              solicitados por lista.  </p>

            <p style="color:rgb(151,191,14)"><strong>Horario estandar de la toma:</strong></p>

            <p>Es el horario que se tiene programado para el suministro del biberon al
              paciente. Por tanto, el horario de entrega en los servicios se hace con la
              anticipacion necesaria.</p>
            
            <p style="color:rgb(151,191,14)"><strong>Horario de cancelacion y cambios:</strong></p>

            <p>Es el intervalo de tiempo durante el cual se puede realizar la cancelacion
              de los biberones solicitados por lista. Estas cancelaciones se deben
              hacer cuando el paciente: es dado de alta, se suspende la via oral o se
              cambia el tipo de formula.</p>

              <p>Se debe tener en cuenta que todos los cambios solicitados antes de las
              10:30 am, se hacen efectivos en la tanda de produccion 2. Los cambios
              solicitados en horas de la tarde, quedan para la tanda de produccion 1 del
              siguiente dia, teniendo en cuenta que el servicio de neonatos tiene plazo
              hasta las 14:00 horas para realizar cambios que se efectuaran en la
              tanda 2 del dia de solicitud.</p>
              <p>Es importante aclarar que cuando por orden medica o de nutricion se
              realice transicion de formula estandar a formula especializada o a
              formula sin lactosa, el cambio se hara de manera inmediata.</p>
              <p>Es importante aclarar que cuando por orden medica o de nutricion se
              realice transicion de formula estandar a formula especializada o a
              formula sin lactosa, el cambio se hara de manera inmediata.</p>
             

              <p style="color:rgb(151,191,14)"><strong>Horario de adicion:</strong></p>

              <p> Es el intervalo de tiempo durante el cual se pueden solicitar
              biberones para que sean distribuidos en los horarios de entrega
              estandar.</p> 
              <div class="table-responsive">
                <table>
                  <thead>
                    <tr style="background-color: RGB(0 105 65);">
                      <th scope="col" style="color:#ffff"><strong>Tandas de produccion</strong></th>
                      <th scope="col" style="color:#ffff"><strong>Horario estandar de las tomas</strong></th>
                      <th scope="col" style="color:#ffff"><strong>Hora maxima de la solicitud</strong></th>
                      <th scope="col" style="color:#ffff"><strong>Hora de entrega en servicio</strong></th>
                      <th scope="col" style="color:#ffff"><strong>Hora maxima cancelacion y cambios</strong></th>
                      <th scope="col" style="color:#ffff"><strong>Hora de adicion</strong></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    </tr>
                    <tr>
                      <td>Tanda 1: manana</td>
                      <td>12:00 a 15:00</td>
                      <td>6:00</td>
                      <td>10:00 a 10:30</td>
                      <td>8:00</td>
                      <td>A partir de las 7:00 - 9:15</td>
                    </tr>
                    <tr>
                      <td>Tanda 2: Tarde</td>
                      <td>18:00</br>21:00</br>00:00</br>03:00</br>06:00</br>09:00</br>10:00</td>
                      <td>6:00</td>
                      <td>15:00 a 16:30</td>
                      <td>13:00</td>
                      <td>A partir de las 11:00 - 14:15</td>
                    </tr>
                  </tbody>
                </table>
                <br>

                <table>
                  <thead>
                    <tr style="background-color: RGB(0 105 65);">
                      <th scope="col" style="color:#ffff"><strong>Numero Biberones Ordenados</strong></th>
                      <th scope="col" style="color:#ffff"><strong>Numero Biberones AM</strong></th>
                      <th scope="col" style="color:#ffff"><strong>Numero Biberones PM</strong></th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    </tr>
                    <tr>
                      <td>8</td>
                      <td>2</td>
                      <td>6</td>
                    </tr>
                    <tr>
                      <td>7</td>
                      <td>2</td>
                      <td>5</td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>1</td>
                      <td>5</td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>1</td>
                      <td>4</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>1</td>
                      <td>3</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td></td>
                      <td>3</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td></td>
                      <td>2</td>
                    </tr>
                  </tbody>
                </table>

                <br/>
                <p style="color:rgb(151,191,14)"><strong>Nota:</strong></p>

                <p>Si se requieren en un horario especifico se debe colocar en observaciones los horarios de los turnos para programar la produccion.

                </p>

                <p>Los servicios de UCI/UCE neonatos, Urgencias
                Infantil cuentan con un stock de formulas lacteas listas (frasco de 59 ml)
                para usar para el paciente prematuro (24 Kcal/30 ml) y paciente a
                termino (19 Kcal/30 ml). Cada sala debe mantener el stock maximo definido para lo cual es necesario solicitar por lista la reposicion de las
                unidades para reponerlo.</p>
              </div>
        
          </div>
        </div>
      </div>

    <!-- </div> -->

      </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'template/footer.php';
?>

<?php 
}
ob_end_flush();
?>

<script>
  function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
}
</script>
