<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();

  $valores = [
    'dni_paciente' => '',
    'nombre' => '',
    'apellidos' => '',
    'nacimiento' => '',
    'sexo' => '',
    'telefono' => '',
    'celular' => '',
    'direccion' => '',
    'historial' => '',
    'ingreso' => '',
  ];

  switch ($_GET['A']) {
    case 'C':
      if (!empty($_POST)) {
        $data = [
          'nombre' => $_POST['nombre'],
          'tipo' => $_POST['tipo'],
          'email' => $_POST['email'],
          'telefono' => $_POST['telefono'],
          'pais' => $_POST['pais'],
          'observaciones' => $_POST['observaciones'],
        ];
    
        $sql = 'insert into proveedor
          (nombre, tipo, email, telefono, pais, observaciones)
          values
          (:nombre, :tipo, :email, :telefono, :pais, :observaciones)';
    
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Proveedor registrado correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M09", :cod_usuario, now(), "Creacion de proveedor")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      }
      break;
    case 'U':
      if (!empty($_GET['id'])) {
        $sql = 'select * from proveedor where cod_proveedor=:cod_proveedor';
    
        $conexion = abrir_conexion();
        $valores = buscar_registro($conexion, $sql, [':cod_proveedor' => $_GET['id']]);
        cerrar_conexion($conexion);
      }
    
      if (!empty($_POST)) {;
        $data = [
          'cod_proveedor' => $_POST['cod-proveedor'],
          'nombre' => $_POST['nombre'],
          'tipo' => $_POST['tipo'],
          'email' => $_POST['email'],
          'telefono' => $_POST['telefono'],
          'pais' => $_POST['pais'],
          'observaciones' => $_POST['observaciones'],
        ];
    
        $sql = 'update proveedor set nombre=:nombre, tipo=:tipo, email=:email, telefono=:telefono, pais=:pais, observaciones=:observaciones where cod_proveedor=:cod_proveedor';
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Proveedor actualizado correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M09", :cod_usuario, now(), "Edicion de proveedor")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      }
      break;
    case 'D':
      if (!empty($_GET['id'])) {
        $sql = 'select * from proveedor where cod_proveedor=:cod_proveedor';
    
        $conexion = abrir_conexion();
        $proveedor = buscar_registro($conexion, $sql, [':cod_proveedor' => $_GET['id']]);
        cerrar_conexion($conexion);

        if ($proveedor['estado']=='INACTIVO') {
          $sql = 'update proveedor set estado="ACTIVO" where cod_proveedor=:cod_proveedor';
        } else {
          $sql = 'update proveedor set estado="INACTIVO" where cod_proveedor=:cod_proveedor';
        }
    
        $mensaje = ($proveedor['estado']=='ACTIVO') ? 'Proveedor deshabilitado.' : 'Proveedor habilitado.';
        $conexion = abrir_conexion();
        $proveedor = ejecutar_sql($conexion, $sql, [':cod_proveedor' => $_GET['id']], $mensaje);
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M09", :cod_usuario, now(), "Deshabilitacion de proveedor")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      }
      break;
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paciente - Climasys</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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
                <h2 class="card-title">
                  <?php 
                    if ($_GET['A']=='C') {
                      echo 'CREAR ';
                    } elseif ($_GET['A']=='U') {
                      echo 'EDITAR ';
                    }
                  ?> 
                  PROVEEDORES
                </h2>
                <?php if (($_GET['A']=='C' and tiene_acceso_a('C')) || ($_GET['A']=='U' and tiene_acceso_a('U'))) : ?>
                  <form id="formulario" method="post">
                    <?php if ($_GET['A']=='U'): ?>
                      <div class="form-group mt-2">
                        <label>Codigo</label>
                        <input type="text" name="cod_proveedor" id="cod_proveedor" class="form-control campo" value="<?php echo $valores['cod_proveedor'] ?>" maxlength="50" required readonly>
                      </div>
                    <?php endif; ?>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control campo" value="<?php echo $valores['nombre'] ?>" maxlength="50" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Tipo</label>
                        <input type="text" name="tipo" id="tipo" class="form-control campo" value="<?php echo $valores['tipo'] ?>" maxlength="50" required>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control campo" value="<?php echo $valores['email'] ?>" maxlength="50" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Telefono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control campo" value="<?php echo $valores['telefono'] ?>" maxlength="50" required>
                      </div>
                    </div>
                    <div class="form-group mt-2">
                      <label>Pais</label>
                      <input type="text" name="pais" id="pais" class="form-control campo" value="<?php echo $valores['pais'] ?>" maxlength="50" required>
                    </div>
                    <div class="form-group mt-2">
                      <label>Observaciones</label>
                      <textarea name="observaciones" id="observaciones" class="form-control campo" maxlength="100" required><?php echo $valores['observaciones'] ?></textarea>
                    </div>
                    <div class="form-group mt-4">
                      <input type="submit" value="Guardar" class="btn w-100">
                    </div>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center mt-3">
          <div class="col">
            <div class="card card-table shadow">
              <div class="card-body">
                <table id="tabla">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Tipo</th>
                      <th>Email</th>
                      <th>Telefono</th>
                      <th>Pais</th>
                      <th>Observaciones</th>
                      <th>estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = 'select * from proveedor';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, []);
                      cerrar_conexion($conexion);

                      $acceso_editar = tiene_acceso_a('U');
                      $acceso_eliminar = tiene_acceso_a('D');
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['cod_proveedor'].'</td>';
                        echo '<td>'.$item['nombre'].'</td>';
                        echo '<td>'.$item['tipo'].'</td>';
                        echo '<td>'.$item['email'].'</td>';
                        echo '<td>'.$item['telefono'].'</td>';
                        echo '<td>'.$item['pais'].'</td>';
                        echo '<td>'.$item['observaciones'].'</td>';
                        echo '<td>'.$item['estado'].'</td>';

                        echo '<td class="d-flex gap-2">';
                        if ($acceso_editar) {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&id='.$item['cod_proveedor'].'" class="icono"><i class="fa-solid fa-square-pen"></i></a>';
                        }
                        if ($acceso_eliminar) {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=D&id='.$item['cod_proveedor'].'" class="icono">'.(($item['estado'] == 'ACTIVO') ? '<i class="fa-solid fa-square-xmark"></i>' : '<i class="fa-solid fa-square-check"></i>').'</a>';
                        }
                        echo '</td>';
                        echo '</tr>';
                      }
                    ?>
                  </tbody>
                </table>
              </div>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/vfs_fonts.min.js"></script>

  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

  <script>
    $(document).ready(function() {
      sidebarExpandir()
      formularioValidar('#formulario')
      $('#tabla').DataTable({
        dom: 'Bfrtip',
        buttons: [  
          {
            extend: 'excel',
            title: 'LISTADO DE PACIENTES',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }, 
          {
            extend: 'pdf',
            title: 'LISTADO DE PACIENTES',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }
        ],
      })
    })
  </script>
</body>
</html>