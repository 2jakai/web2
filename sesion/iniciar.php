<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  $mensaje = '';

  if (!empty($_POST)) {
    $sql = 'select * from usuario where usuario = binary :usuario';
    $conexion = abrir_conexion();
    $registro = buscar_registro($conexion, $sql, [':usuario' => $_POST['usuario']]);
    cerrar_conexion($conexion);

    if (!empty($registro)) {
      if ($registro['clave'] == $_POST['clave'] && $registro['estado'] == 'ACTIVO') {
        if (substr($registro['clave'],0,1) == '#') {
          iniciar_session(['usuario' => $registro['usuario']]);
          echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].'/sesion/primer-ingreso.php"</script>';
        } else {
          iniciar_session([
            'codigo' => $registro['cod_usuario'],
            'usuario' => $registro['usuario'],
            'tipo' => $registro['tipo'],
          ]);
          echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].'"</script>';
        }
      } else {
        $mensaje = 'Nombre de usuario o contraseña incorrecta.';
      }
    } else {
      $mensaje = 'Nombre de usuario o contraseña incorrecta.';
    }

    if (!empty($mensaje)) {
      echo '<script>alert("'.$mensaje.'")</script>';
    }
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Climasys</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="//<?php echo $_SERVER['HTTP_HOST'].'/css/main.css'; ?>">
</head>
<body>
  <main id="main" class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col col-md-6">
          <div class="card shadow">
            <div class="card-body">
              <h2 class="card-title">LOGIN</h2>
              <form method="post">
                <div class="form-group mt-2">
                  <label>Usuario</label>
                  <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Ingrese un usuario" maxlength="25">
                </div>
                <div class="form-group mt-2">
                  <label>Clave</label>
                  <input type="password" name="clave" id="clave" class="form-control" placeholder="Ingrese una clave" maxlength="50">
                </div>
                <div class="form-group mt-4">
                  <input type="submit" name="ingresar" id="ingresar" class="btn w-100" value="Ingresar">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>