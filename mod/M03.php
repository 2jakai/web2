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
        $sql = 'select dni_paciente from paciente where dni_paciente=:dni_paciente';
    
        $conexion = abrir_conexion();
        $registro = buscar_registro($conexion, $sql, [':dni_paciente' => $_POST['dni-paciente']]);
        cerrar_conexion($conexion);
        
        if (empty($registro)) {
          $data = [
            'dni_paciente' => $_POST['dni-paciente'],
            'nombre' => $_POST['nombre'],
            'apellidos' => $_POST['apellidos'],
            'nacimiento' => $_POST['nacimiento'],
            'sexo' => $_POST['sexo'],
            'telefono' => $_POST['telefono'],
            'celular' => $_POST['celular'],
            'direccion' => $_POST['direccion'],
            'historial' => $_POST['historial'],
            'ingreso' => $_POST['ingreso'],
          ];
    
          $sql = 'insert into paciente
            (dni_paciente, nombre, apellidos, nacimiento, sexo, telefono, celular, direccion, historial, ingreso)
            values
            (:dni_paciente, :nombre, :apellidos, :nacimiento, :sexo, :telefono, :celular, :direccion, :historial, :ingreso)';
    
          $conexion = abrir_conexion();
          ejecutar_sql($conexion, $sql, $data, 'Paciente registrado correctamente.');
          cerrar_conexion($conexion);

          $conexion = abrir_conexion();
          ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M03", :cod_usuario, now(), "Creacion de paciente")', [':cod_usuario' => $_SESSION['codigo']]);
          cerrar_conexion($conexion);

          echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
        } else {
          echo '<script>alert("La identidad que desea guardar ya existe")</script>';
        }
      }
      break;
    case 'U':
      if (!empty($_GET['id'])) {
        $sql = 'select * from paciente where dni_paciente=:dni_paciente';
    
        $conexion = abrir_conexion();
        $valores = buscar_registro($conexion, $sql, [':dni_paciente' => $_GET['id']]);
        cerrar_conexion($conexion);
      }
    
      if (!empty($_POST)) {;
        $data = [
          'dni_paciente' => $_POST['dni-paciente'],
          'nombre' => $_POST['nombre'],
          'apellidos' => $_POST['apellidos'],
          'nacimiento' => $_POST['nacimiento'],
          'sexo' => $_POST['sexo'],
          'telefono' => $_POST['telefono'],
          'celular' => $_POST['celular'],
          'direccion' => $_POST['direccion'],
          'historial' => $_POST['historial'],
          'ingreso' => $_POST['ingreso'],
        ];
    
        $sql = 'update paciente set nombre=:nombre, apellidos=:apellidos, nacimiento=:nacimiento, sexo=:sexo, telefono=:telefono, celular=:celular, direccion=:direccion, historial=:historial, ingreso=:ingreso where dni_paciente=:dni_paciente';
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Paciente actualizado correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M03", :cod_usuario, now(), "Edicion de paciente")', [':cod_usuario' => $_SESSION['codigo']]);
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
                  PACIENTES
                </h2>
                <?php if (($_GET['A']=='C' and tiene_acceso_a('C')) || ($_GET['A']=='U' and tiene_acceso_a('U'))) : ?>
                  <form id="formulario" method="post">
                    <div class="form-group mt-2">
                      <label>Identidad</label>
                      <input type="text" name="dni-paciente" id="dni-paciente" class="form-control campo" value="<?php echo $valores['dni_paciente'] ?>" maxlength="50" required>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control campo" value="<?php echo $valores['nombre'] ?>" maxlength="50" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control campo" value="<?php echo $valores['apellidos'] ?>" maxlength="50" required>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Nacimiento</label>
                        <input type="date" name="nacimiento" id="nacimiento" class="form-control campo" value="<?php echo $valores['nacimiento'] ?>" required>
                      </div>                    
                      <div class="flex-grow-1">
                        <label>Sexo</label>
                        <select name="sexo" id="sexo" class="form-control campo" required>
                          <option value="">[SELECCIONE UN SEXO]</option>
                          <option value="F" <?php echo ($valores['sexo'] == 'F') ? 'selected' : '' ?> >Femenino</option>
                          <option value="M" <?php echo ($valores['sexo'] == 'M') ? 'selected' : '' ?> >Masculino</option>
                          <option value="O" <?php echo ($valores['sexo'] == 'O') ? 'selected' : '' ?> >Otro</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Telefono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control campo" value="<?php echo $valores['telefono'] ?>" maxlength="50" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Celular</label>
                        <input type="text" name="celular" id="celular" class="form-control campo" value="<?php echo $valores['celular'] ?>" maxlength="50" required>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Direccion</label>
                        <textarea name="direccion" id="direccion" class="form-control campo" maxlength="100" required><?php echo $valores['direccion'] ?></textarea>
                      </div>
                      <div class="flex-grow-1">
                        <label>Historial</label>
                        <textarea name="historial" id="historial" class="form-control campo" maxlength="100" required><?php echo $valores['historial'] ?></textarea>
                      </div>
                    </div>
                    <div class="form-group mt-2">
                      <label>Fecha de ingreso</label>
                      <input type="date" name="ingreso" id="ingreso" class="form-control campo" value="<?php echo $valores['ingreso'] ?>" required>
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
                      <th>Identiadd</th>
                      <th>Nombre</th>
                      <th>nacimiento</th>
                      <th>Sexo</th>
                      <th>Telefono</th>
                      <th>Celular</th>
                      <th>Direccion</th>
                      <th>historial</th>
                      <th>Ingreso</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = 'select * from paciente';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, []);
                      cerrar_conexion($conexion);

                      $acceso_editar = tiene_acceso_a('U');
                      $acceso_eliminar = tiene_acceso_a('D');
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['dni_paciente'].'</td>';
                        echo '<td>'.$item['nombre'].' '.$item['apellidos'].'</td>';
                        echo '<td>'.$item['nacimiento'].'</td>';
                        echo '<td>'.$item['sexo'].'</td>';
                        echo '<td>'.$item['telefono'].'</td>';
                        echo '<td>'.$item['celular'].'</td>';
                        echo '<td>'.$item['direccion'].'</td>';
                        echo '<td>'.$item['historial'].'</td>';
                        echo '<td>'.$item['ingreso'].'</td>';

                        echo '<td class="d-flex gap-2">';
                        if ($acceso_editar) {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&id='.$item['dni_paciente'].'" class="icono"><i class="fa-solid fa-square-pen"></i></a>';
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