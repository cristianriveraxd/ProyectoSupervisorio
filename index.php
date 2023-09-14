<!DOCTYPE html>
<!-- Autor: Cristian Rivera. 13/03/23
Proyecto supervisorio sistema de paletizado. 
INDEX-->

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="autor" content="Cristian Rivera">
  <!-- anclaje a bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css" class="rel">
  <!-- anclaje a hoja de estilos propia -->
  <link rel="stylesheet" type="text/css" href="css\styles.css" class="rel">
  <link rel="icon" href="img/logo.png">
  <title>Supervisorio Sistema de Paletizado - Doria</title>
  <!-- refrescar pagina -->
  <!-- <meta http-equiv="refresh" content="10"> -->
</head>

<body>
  <div class="container">
    <header class="d-flex flex-wrap justify-content-center p-0 m-0 border-bottom">
      <img class="d-flex align-items-center mx-auto" src="img/bambinodoria.png" alt="bambino doria" width="290" height="260">
      <div class="d-flex justify-content-center align-items-center flex-column">
        <h1 class="text-center fw-bold">ASIGNACIÓN DE LINEAS EN SISTEMA <br> DE PALETIZADO DORIA</br></h1>
        <!-- <div class="text-center mt-4">
          <ul class="nav">
            <li class="nav-item lead"><a href="#" class="nav-link">FAQs</a></li>
            <li class="nav-item lead"><a href="#" class="nav-link">About</a></li>
          </ul>
        </div> -->
      </div>
    </header>
    <div class="container">
      <?php
      include_once("conexion.php");
      include_once("configuracionLineas.php");
      Conexion::conexionBD();
      Datos::obtencionCodigos();
      ?>
    </div>
  </div>



  <div class="container">
    <footer class="py-3 my-3">
      <p class="text-center text-muted mb-0">&copy;<span id="currentYear"></span> Productos Alimenticios Doria</p>
      <p class="text-center text-muted mb-0">Pastas 4.0</p>
      <script>
        window.addEventListener("load", () => {
          const currentDate = new Date();
          document.getElementById("currentYear").innerText = currentDate.getFullYear();
        })
      </script>
    </footer>
  </div>


  <!--relación con javaScript /ficheros-->
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="css/styles.css"></script>
</body>

</html>