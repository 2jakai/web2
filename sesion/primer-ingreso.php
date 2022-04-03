<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';

  session_start();
  if(empty($_SESSION['usuario'])) {
    echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].'/sesion/iniciar.php"</script>';
  }

  if (!empty($_POST)) {
    $sql = 'update usuario set clave=:clave where usuario = binary :usuario';
    $conexion = abrir_conexion();
    ejecutar_sql($conexion, $sql, [':usuario' => $_SESSION['usuario'], ':clave' => $_POST['nueva-clave-1']], 'Clave actualizada correctamente.');
    cerrar_conexion($conexion);
    echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].'/sesion/iniciar.php"</script>';
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambio de clave - Climasys</title>
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
              <h2 class="card-title">CAMBIO DE CLAVE</h2>
              <form id="formulario" method="post">
                <div class="form-group mt-2">
                  <label>Nueva clave</label>
                  <input type="password" name="nueva-clave-1" id="nueva-clave-1" class="form-control clave" placeholder="Ingrese una clave" maxlength="50" required>
                  <input type="password" name="nueva-clave-2" id="nueva-clave-2" class="form-control mt-2 clave" placeholder="Ingrese la clave nuevamente" maxlength="50" required>
                </div>
                <div class="form-group mt-4">
                  <input type="submit" name="guardar" id="guardar" class="btn w-100" value="Guardar">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="//<?php echo $_SERVER['HTTP_HOST'].'/js/jquery-3.6.0.min.js'; ?>"></script>
  <script>
    $(document).ready(function() {
      $('#formulario').on('submit', function(e) {
        let mensaje = ''

        $('.clave').each(function() {
          if (!$(this).val() && !mensaje) {
            mensaje = 'Datos faltantes, por favor revise.'
            $(this).focus()
          }
        })
        
        if ($('#nueva-clave-1').val().startsWith('#') && !mensaje) {
          mensaje = 'La clave no puede iniciar con #.'
        }
                  
        if ($('#nueva-clave-1').val() != $('#nueva-clave-2').val() && !mensaje) {
          mensaje = 'Las claves no coinciden.'
        }
                  
        if ($('#nueva-clave-1').val().length < 8 && !mensaje) {
          mensaje = 'La clave debe der mayor a 8 caracteres.'
        }

        if (mensaje) {
          alert(mensaje)
          e.preventDefault()
        }
      })
    })
  </script>
</body>
</html>