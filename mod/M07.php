<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();

  if (!empty($_GET['U']) && !empty($_GET['M'])) {
    switch ($_GET['A']) {
      case 'C':
        $sql = 'select * from acceso where cod_modulo=:cod_modulo and cod_usuario=:cod_usuario';
        $conexion = abrir_conexion();
        $registro = buscar_registro($conexion, $sql, [':cod_modulo' => $_GET['M'], ':cod_usuario' => $_GET['U']], 'Acceso asignado correctamente');
        cerrar_conexion($conexion);

        if (empty($registro)) {
          $sql = 'insert into acceso (cod_modulo, cod_usuario) values (:cod_modulo, :cod_usuario)';
          $conexion = abrir_conexion();
          ejecutar_sql($conexion, $sql, [':cod_modulo' => $_GET['M'], ':cod_usuario' => $_GET['U']], 'Acceso asignado correctamente');
          cerrar_conexion($conexion);

          $conexion = abrir_conexion();
          ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M07", :cod_usuario, now(), "Creacion de acceso")', [':cod_usuario' => $_SESSION['codigo']]);
          cerrar_conexion($conexion);
  
        }
        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?U='.$_GET['U'].'"</script>';
        break;

      case 'U':
        $sql = 'select * from acceso where cod_modulo=:cod_modulo and cod_usuario=:cod_usuario';
        $conexion = abrir_conexion();
        $registro = buscar_registro($conexion, $sql, [':cod_modulo' => $_GET['M'], ':cod_usuario' => $_GET['U']], 'Acceso asignado correctamente');
        cerrar_conexion($conexion);
        
        $acciones = '';

        if (($_GET['P'] == 'C' && strpos($registro['acciones'], 'C') === false) || ($_GET['P'] != 'C' && strpos($registro['acciones'], 'C') !== false)) {
          $acciones .= 'C' ;
        }

        if (($_GET['P'] == 'U' && strpos($registro['acciones'], 'U') === false) || ($_GET['P'] != 'U' && strpos($registro['acciones'], 'U') !== false)) {
          $acciones .= 'U' ;
        }

        if (($_GET['P'] == 'D' && strpos($registro['acciones'], 'D') === false) || ($_GET['P'] != 'D' && strpos($registro['acciones'], 'D') !== false)) {
          $acciones .= 'D' ;
        }

        if (($_GET['P'] == 'P' && strpos($registro['acciones'], 'P') === false) || ($_GET['P'] != 'P' && strpos($registro['acciones'], 'P') !== false)) {
          $acciones .= 'P' ;
        }

        $sql = 'update acceso set acciones=:acciones where cod_modulo=:cod_modulo and cod_usuario=:cod_usuario';
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, [':cod_modulo' => $_GET['M'], ':cod_usuario' => $_GET['U'], ':acciones' => $acciones]);
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M07", :cod_usuario, now(), "Edicion de acceso")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?U='.$_GET['U'].'"</script>';
        break;

      case 'D':
        $sql = 'delete from acceso where cod_modulo=:cod_modulo and cod_usuario=:cod_usuario';
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, [':cod_modulo' => $_GET['M'], ':cod_usuario' => $_GET['U']], 'Acceso eliminado correctamente');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M07", :cod_usuario, now(), "Eliminacion de acceso")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?U='.$_GET['U'].'"</script>';
        break;
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accesos - Climasys</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  <link rel="icon" type="image/x-icon" href="//<?php echo $_SERVER['HTTP_HOST'].'/favicon.ico'; ?>">
  <link rel="stylesheet" href="//<?php echo $_SERVER['HTTP_HOST'].'/css/main.css'; ?>">
</head>
<body>
  <?php require_once $_SERVER['DOCUMENT_ROOT'].'/componentes/navbar.php' ?>

  <div id="body">
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/componentes/sidebar.php' ?>

    <main id="main" class="py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col">
            <div class="card shadow">
              <div class="card-body">
                <h2 class="card-title">GESTION DE ACCESOS</h2>
                <form method="get" id="formulario">
                  <div class="form-group">
                    <label>Usuario</label>
                    <select name="U" id="U" class="form-control campo">
                      <option value="">[SELECCIONE UN USUARIO]</option>
                      <?php
                        $sql = 'select * from usuario where estado="ACTIVO"';
                        $conexion = abrir_conexion();
                        $registros = buscar_registros($conexion, $sql, []);
                        cerrar_conexion($conexion);
                        foreach ($registros as $item) {
                          echo '<option value="'.$item['cod_usuario'].'" '.( ($item['cod_usuario']==$_GET['U']) ? 'selected' : '' ).'>'.$item['usuario'].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php if (!empty($_GET['U'])): ?>
          <div class="row justify-content-center mt-2">
            <div class="col">
              <div class="card shadow">
                <div class="card-body">
                  <div class="d-flex gap-2">
                    <div class="card flex-grow-1 modulo-lista">
                      <p class="card-header">Modulos no permitidos</p>
                      <div class="list-group-flush">
                        <?php
                          $sql = 'select * from modulo where cod_modulo not in (select a.cod_modulo from acceso a where a.cod_usuario=:cod_usuario)';
                          $conexion = abrir_conexion();
                          $registros = buscar_registros($conexion, $sql, [':cod_usuario' => $_GET['U']]);
                          cerrar_conexion($conexion);
                          $registros;
    
                          foreach ($registros as $item) {
                            echo '<div class="list-group-item d-flex gap-2 justify-content-between">'.$item['nombre'].'<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C&M='.$item['cod_modulo'].'&U='.$_GET['U'].'" class="icono"><i class="fa-solid fa-square-plus"></i></a></div>';
                          }
                        ?>
                      </div>
                    </div>
                    <div class="card flex-grow-1 modulo-lista">
                      <p class="card-header">Modulos permitidos</p>
                      <div class="list-group-flush">
                        <?php
                          $sql = 'select * from modulo where cod_modulo in (select a.cod_modulo from acceso a where a.cod_usuario=:cod_usuario)';
                          $conexion = abrir_conexion();
                          $registros = buscar_registros($conexion, $sql, [':cod_usuario' => $_GET['U']]);
                          cerrar_conexion($conexion);
                          $registros;
    
                          foreach ($registros as $item) {
                            echo '<div class="list-group-item d-flex gap-2 justify-content-between">'.$item['nombre'].'<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=D&M='.$item['cod_modulo'].'&U='.$_GET['U'].'" class="icono"><i class="fa-solid fa-square-minus"></i></a></div>';
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                  <?php 
                    $sql = 'select m.cod_modulo, m.nombre, a.acciones from acceso a inner join modulo m on a.cod_modulo=m.cod_modulo where a.cod_usuario=:cod_usuario';
                    $conexion = abrir_conexion();
                    $registros = buscar_registros($conexion, $sql, ['cod_usuario' => $_GET['U']]);
                    cerrar_conexion($conexion);
                  ?>
                  <?php foreach ($registros as $item): ?>
                      <div class="card mt-2 flex-grow-1">
                        <p class="card-header">Permisos para modulo <?php echo $item['nombre']?></p>
                        <div class="list-group list-group-horizontal text-center">
                          <a href="//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&M='.$item['cod_modulo'].'&U='.$_GET['U'].'&P=C" class="list-group-item list-group-item-action '.( (strpos($item['acciones'],'C') !== false) ? 'active' : '' )?>">Crear</a>
                          <a href="//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&M='.$item['cod_modulo'].'&U='.$_GET['U'].'&P=U" class="list-group-item list-group-item-action '.( (strpos($item['acciones'],'U') !== false) ? 'active' : '' )?>">Editar</a>
                          <a href="//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&M='.$item['cod_modulo'].'&U='.$_GET['U'].'&P=D" class="list-group-item list-group-item-action '.( (strpos($item['acciones'],'D') !== false) ? 'active' : '' )?>">Deshabilitar</a> 
                          <?php if ($item['cod_modulo']=='M05' || $item['cod_modulo']=='M11'): ?>
                            <a href="//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&M='.$item['cod_modulo'].'&U='.$_GET['U'].'&P=P" class="list-group-item list-group-item-action '.( (strpos($item['acciones'],'P') !== false) ? 'active' : '' )?>">Imprimir</a> 
                          <?php endif; ?>
                        </div>
                      </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
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
      $('#U').on('change', function() {
        $('#formulario').submit()
      })
    })
  </script>
</body>
</html>