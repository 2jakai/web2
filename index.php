<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenida</title>
  <link rel="icon" type="image/x-icon" href="//<?php echo $_SERVER['HTTP_HOST'].'/favicon.ico'; ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="//<?php echo $_SERVER['HTTP_HOST'].'/css/main.css'; ?>">
</head>
<body>
  <?php require_once $_SERVER['DOCUMENT_ROOT'].'/componentes/navbar.php' ?>

  <div id="body">
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/componentes/sidebar.php' ?>

    <main id="main" class="p-2">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-10 col-md-7 col-lg-5">
            <div class="card shadow">
              <?php
                $sql = 'select * from empresa where cod_empresa=1';
                $conexion = abrir_conexion();
                $registro = buscar_registro($conexion, $sql, []);
                cerrar_conexion($conexion);
              ?>
              <img class="card-img-top" src="//<?php echo $_SERVER['HTTP_HOST'].'/src/clinica-logo.png'; ?>" alt="LOGO">
              <div class="card-body">
                <h1 class="card-title"><?php echo $registro['nombre'] ?></h1>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">RTN: <?php echo $registro['rtn'] ?></li>
                <li class="list-group-item">TELEFONO: <?php echo $registro['telefono'] ?></li>
                <li class="list-group-item">EMAIL: <?php echo $registro['email'] ?></li>
                <li class="list-group-item">DIRECCIÓN: <?php echo $registro['direccion'] ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="https://kit.fontawesome.com/ba09b7bcf6.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="//<?php echo $_SERVER['HTTP_HOST'].'/js/jquery-3.6.0.min.js'; ?>"></script>
  <script src="//<?php echo $_SERVER['HTTP_HOST'].'/js/funciones.js'; ?>"></script>
  <script>
    $(document).ready(function() {
      sidebarExpandir()
    })
  </script>
</body>
</html>