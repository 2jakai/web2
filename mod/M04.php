<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();

  $valores = [
    'cod_usuario' => '',
    'usuario' => '',
    'clave' => '',
    'tipo' => '',
    'estado' => '',
    'propietario' => [],
  ];

  switch ($_GET['A']) {
    case 'C':
      if (!empty($_POST)) {
        $sql = 'select cod_usuario from usuario where usuario=:usuario';
    
        $conexion = abrir_conexion();
        $registro = buscar_registro($conexion, $sql, [':usuario' => $_POST['usuario']]);
        cerrar_conexion($conexion);
        if (empty($registro)) {
          $sql = 'insert into usuario (usuario, clave, tipo, creador, fecha) values (:usuario, :clave, :tipo, '.$_SESSION['codigo'].', now())';
          $data = [
            ':usuario' => $_POST['usuario'],
            ':clave' => $_POST['clave'],
            ':tipo' => $_POST['tipo'],
          ];
          $conexion = abrir_conexion();
          ejecutar_sql($conexion, $sql, $data, 'Usuario creado correctamente.');
          cerrar_conexion($conexion);

          if ($_POST['tipo'] == 'MEDICO') {
            $sql = 'update medico set cod_usuario=(select cod_usuario from usuario where usuario=:usuario limit 1) where dni_medico=:propietario';
          } else if ($_POST['tipo'] == 'ENFERMERA') {
            $sql = 'update enfermera set cod_usuario=(select cod_usuario from usuario where usuario=:usuario limit 1) where dni_enfermera=:propietario';
          }
          $data = [
            ':usuario' => $_POST['usuario'],
            ':propietario' => $_POST['propietario'],
          ];
          $conexion = abrir_conexion();
          ejecutar_sql($conexion, $sql, $data, 'Usuario asignado correctamente.');
          cerrar_conexion($conexion);

          $conexion = abrir_conexion();
          ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M04", :cod_usuario, now(), "Creacion de usuario")', [':cod_usuario' => $_SESSION['codigo']]);
          cerrar_conexion($conexion);

          echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
        } else {
          echo '<script>alert("El usuario ya existe")</script>';
        }
      }
      break;
    case 'U':
      if (!empty($_GET['id'])) {
        $sql = 'select * from usuario where cod_usuario=:cod_usuario';
    
        $conexion = abrir_conexion();
        $valores = buscar_registro($conexion, $sql, [':cod_usuario' => $_GET['id']]);
        cerrar_conexion($conexion);

        if ($valores['tipo'] == 'MEDICO') {
          $sql = 'select dni_medico dni, nombre, apellidos from medico where cod_usuario=:cod_usuario';
        } else if ($valores['tipo'] == 'ENFERMERA') {
          $sql = 'select dni_enfermera dni, nombre, apellidos from enfermera where cod_usuario=:cod_usuario';
        }

        $conexion = abrir_conexion();
        $valores['propietario'] = buscar_registro($conexion, $sql, [':cod_usuario' => $_GET['id']]);
        cerrar_conexion($conexion);
      }

      if (!empty($_POST)) {
        $sql = 'select cod_usuario from usuario where usuario=:usuario';
    
        $conexion = abrir_conexion();
        $registro = buscar_registro($conexion, $sql, [':usuario' => $_POST['usuario']]);
        cerrar_conexion($conexion);
         
        if (empty($registro) || $registro['cod_usuario']==$_GET['id']) {
          $sql = 'update usuario set usuario=:usuario, clave=:clave where cod_usuario=:cod_usuario';
          $data = [
            ':cod_usuario' => $_GET['id'],
            ':usuario' => $_POST['usuario'],
            ':clave' => $_POST['clave'],
          ];
          $conexion = abrir_conexion();
          $registro = ejecutar_sql($conexion, $sql, $data, 'Usuario actualizado correctamente.');
          cerrar_conexion($conexion);

          $conexion = abrir_conexion();
          ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M04", :cod_usuario, now(), "Edicion de usuario")', [':cod_usuario' => $_SESSION['codigo']]);
          cerrar_conexion($conexion);

          echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
        } else {
          echo '<script>alert("EL usuario que ingresó ya existe.")</script>';
        }
      }
      break;
    case 'D':
      if (!empty($_GET['id'])) {
        $sql = 'select * from usuario where cod_usuario=:cod_usuario';
    
        $conexion = abrir_conexion();
        $usuario = buscar_registro($conexion, $sql, [':cod_usuario' => $_GET['id']]);
        cerrar_conexion($conexion);

        if ($usuario['estado']=='INACTIVO') {
          $sql = 'update usuario set estado="ACTIVO" where cod_usuario=:cod_usuario';
        } else {
          $sql = 'update usuario set estado="INACTIVO" where cod_usuario=:cod_usuario';
        }
    
        $mensaje = ($usuario['estado']=='ACTIVO') ? 'Usuario deshabilitado.' : 'Usuario habilitado.';
        $conexion = abrir_conexion();
        $usuario = ejecutar_sql($conexion, $sql, [':cod_usuario' => $_GET['id']], $mensaje);
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M04", :cod_usuario, now(), "Deshabilitacion de usuario")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      }
      break;
  }

  $valores['clave'] = '#'.rand(10000, 99999);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuarios - Climasys</title>
  
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
                  USUARIOS
                </h2>
                <?php if (($_GET['A']=='C' and tiene_acceso_a('C')) || ($_GET['A']=='U' and tiene_acceso_a('U'))) : ?>
                <form id="formulario" method="post">
                  <div class="form-group mt-2 d-flex gap-2">
                    <div class="flex-grow-1">
                      <label>Usuario</label>
                      <input type="text" name="usuario" id="usuario" class="form-control campo" value="<?php echo $valores['usuario'] ?>" maxlength="25" required>
                    </div>
                    <div>
                      <label>Clave</label>
                      <input type="text" name="clave" id="clave" class="form-control campo" value="<?php echo $valores['clave'] ?>" maxlength="50" required readonly>
                    </div>
                    <?php if ($_GET['A']=='C'): ?>
                      <div>
                        <label>Tipo</label>
                        <select name="tipo" id="tipo" class="form-control campo">
                          <option value="">[SELECCINE UN TIPO]</option>
                          <option value="MEDICO" <?php echo ($valores['tipo']=='MEDICO') ? 'selected' : '' ?> >Medico</option>
                          <option value="ENFERMERA" <?php echo ($valores['tipo']=='ENFERMERA') ? 'selected' : '' ?> >Enfermera</option>
                          <option value="ADMINISTRADOR" <?php echo ($valores['tipo']=='ADMINISTRADOR') ? 'selected' : '' ?> >Administrador</option>
                        </select>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mt-2">
                    <label>Propietario</label>
                    <input type="hidden" name="propietario" id="propietario" class="campo" value="<?php echo $valores['propietario']['dni'] ?>" required readonly>
                    <input type="text" name="propietario-nombre" id="propietario-nombre" class="form-control campo" value="<?php echo $valores['propietario']['nombre'].' '.$valores['propietario']['apellidos'] ?>" maxlength="100" required readonly>
                  </div>
                  
                  <?php if ($_GET['A']=='C'): ?>
                    <div class="input-group mt-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Buscar</span>
                      </div>
                      <input type="text" name="busqueda" id="busqueda" value="" class="form-control">
                    </div>
                    <div class="form-group mt-1">
                      <ul id="lista" class="list-group">
                      <?php
                        $sql = '
                          select "medico" tipo, dni_medico dni, nombre, apellidos from medico where cod_usuario is NULL
                          union
                          select "enfermera" tipo, dni_enfermera, nombre, apellidos from enfermera where cod_usuario is NULL';
  
                        $conexion = abrir_conexion();
                        $registros = buscar_registros($conexion, $sql, []);
                        cerrar_conexion($conexion);

                        foreach ($registros as $item) {
                          echo '<li class="list-group-item list-group-item-action d-none empleado" data-tipo="'.$item['tipo'].'" data-dni="'.$item['dni'].'">'.$item['nombre'].' '.$item['apellidos'].'</li>';
                        }
                      ?>
                      </ul>
                    </div>
                  <?php endif; ?>

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
                      <th>Propietario</th>
                      <th>Usuario</th>
                      <th>Clave</th>
                      <th>Tipo</th>
                      <th>Estado</th>
                      <th>Creador</th>
                      <th>Fecha de creacion</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = '
                        select u.*, m.dni_medico dni from usuario u inner join medico m on u.cod_usuario=m.cod_usuario
                        union
                        select u.*, e.dni_enfermera from usuario u inner join enfermera e on u.cod_usuario=e.cod_usuario';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, []);
                      cerrar_conexion($conexion);

                      $acceso_editar = tiene_acceso_a('U');
                      $acceso_eliminar = tiene_acceso_a('D');
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['cod_usuario'].'</td>';
                        echo '<td>'.$item['dni'].'</td>';
                        echo '<td>'.$item['usuario'].'</td>';
                        if (substr($item['clave'],0,1)=='#') {
                          echo '<td>'.$item['clave'].'</td>';
                        } else {
                          echo '<td>-----</td>';
                        }
                        echo '<td>'.$item['tipo'].'</td>';
                        echo '<td>'.$item['estado'].'</td>';
                        echo '<td>'.$item['creador'].'</td>';
                        echo '<td>'.$item['fecha'].'</td>';

                        echo '<td class="d-flex gap-2">';
                        if ($acceso_editar && $item['estado'] == 'ACTIVO') {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&id='.$item['cod_usuario'].'" class="icono"><i class="fa-solid fa-square-pen"></i></a>';
                        }
                        
                        if ($acceso_eliminar) {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=D&id='.$item['cod_usuario'].'" class="icono">'.(($item['estado'] == 'ACTIVO') ? '<i class="fa-solid fa-square-xmark"></i>' : '<i class="fa-solid fa-square-check"></i>').'</a>';
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

      $('.empleado').on('click',function() {
        propietarioEstablecer($(this).data('dni'), $(this).text());
      })

      $('#busqueda')?.on('keyup',function() {
        renderizarLista()
      })

      $('#tipo')?.on('change',function() {
        renderizarLista()
        propietarioEstablecer('', '');
      })

      $('#tabla').DataTable({
        dom: 'Bfrtip',
        buttons: [  
          {
            extend: 'excel',
            title: 'LISTADO DE USUARIOS',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }, 
          {
            extend: 'pdf',
            title: 'LISTADO DE USUARIOS',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }
        ],
      })
    })

    const propietarioEstablecer = (dni, nombre) => {
      $('#propietario').val(dni)
      $('#propietario-nombre').val(nombre)
    }

    const renderizarLista = () => {
      const tipo = $('#tipo').val().toUpperCase()
      const busqueda = $('#busqueda').val().toUpperCase()

      $('.empleado').each(function() {
        if ($(this).data('tipo').toUpperCase() == tipo && busqueda.trim() != '' && $(this).text().toUpperCase().includes(busqueda)) {
          $(this).removeClass('d-none')
        } else {
          $(this).addClass('d-none')
        }
      })
    }
  </script>
</body>
</html>