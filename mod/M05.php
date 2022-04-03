<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();
  
  $valores = [
    'cod_cita' => '',
    'dni_paciente' => '',
    'cod_departamento' => '',
    'dni_medico' => '',
    'fecha' => '',
    'estado' => '',
  ];

  switch ($_GET['A']) {
    case 'C':
      if (!empty($_POST)) {
        $data = [
          ':dni_paciente' => $_POST['dni-paciente'],
          ':cod_departamento' => $_POST['cod-departamento'],
          ':dni_medico' => $_POST['dni-medico'],
          ':fecha' => $_POST['fecha'],
        ];
    
        $sql = 'insert into cita
          (dni_paciente, cod_departamento, dni_medico, fecha)
          values
          (:dni_paciente, :cod_departamento, :dni_medico, :fecha)';
    
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Cita creada correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M05", :cod_usuario, now(), "Creacion de cita")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      }
      break;
    case 'U':
      if (!empty($_GET['id'])) {
        $sql = 'select c.*, p.nombre nom_pac, p.apellidos apell_pac, d.nombre depto, m.nombre nom_med, m.apellidos apell_med from paciente p inner join cita c inner join medico m inner join departamento d on c.dni_medico=m.dni_medico and c.dni_paciente=p.dni_paciente and c.cod_departamento=d.cod_departamento where c.cod_cita=:cod_cita';
    
        $conexion = abrir_conexion();
        $valores = buscar_registro($conexion, $sql, [':cod_cita' => $_GET['id']]);
        cerrar_conexion($conexion);
      }

      if (!empty($_POST)) {
        $data = [
          ':cod_cita' => $_POST['cod-cita'],
          ':fecha' => $_POST['fecha'],
        ];
    
        $sql = 'update cita set fecha=:fecha where cod_cita=:cod_cita';
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Cita actualizado correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M05", :cod_usuario, now(), "Edicion de cita")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      }
      break;
    case 'D':
      if (!empty($_GET['id'])) {
        $sql = 'update cita set estado="CANCELADA" where cod_cita=:cod_cita';
    
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, [':cod_cita' => $_GET['id']], 'Cita cancelada correctamente');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M05", :cod_usuario, now(), "Deshabilitacion de cita")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

      }
      echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      break;
    case 'A':
      if (!empty($_GET['id'])) {
        $sql = 'update cita set estado="ATENDIDA" where cod_cita=:cod_cita';
    
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, [':cod_cita' => $_GET['id']]);
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M05", :cod_usuario, now(), "Edicion de cita")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

      }
      echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      break;
  }

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Citas - Climasys</title>
  
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
                  CITAS
                </h2>
                <?php if (($_GET['A']=='C' and tiene_acceso_a('C')) || ($_GET['A']=='U' and tiene_acceso_a('U'))) : ?>
                  <form id="formulario" method="post">
                    <?php if ($_GET['A']=='U'): ?>
                      <div class="form-group mt-2">
                        <label>Cita</label>
                        <input type="text" name="cod-cita" id="cod-cita" class="form-control campo" value="<?php echo $valores['cod_cita'] ?>" maxlength="50" required readonly>
                      </div>
                    <?php endif; ?>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Departamento</label>
                        <?php if ($_GET['A']=='C'): ?>
                          <select name="cod-departamento" id="cod-departamento" class="form-control campo" required>
                            <option value="">[SELECCIONE UN DEPARTAMENTO]</option>
                            <?php
                              $sql = 'select * from departamento where estado="ACTIVO"';
                              $conexion = abrir_conexion();
                              $registros = buscar_registros($conexion, $sql, []);
                              cerrar_conexion($conexion);

                              foreach ($registros as $item) {
                                echo '<option value="'.$item['cod_departamento'].'" '.(($item['cod_departamento']==$_GET['D']) ? 'selected' : '').'>'.$item['nombre'].'</option>';
                              }
                            ?>
                          </select> 
                        <?php elseif ($_GET['A']=='U'): ?>
                          <input type="hidden" name="cod-departamento" value="<?php echo $valores['cod_departamento'] ?>" required>
                          <input type="text" name="nombre-departamento" id="nombre-departamento" class="form-control campo" value="<?php echo $valores['depto'] ?>" required readonly>
                        <?php endif; ?>
                      </div>
                      <div class="flex-grow-1">
                        <label>Medico</label>
                        <?php if ($_GET['A']=='C'): ?>
                          <select name="dni-medico" id="dni-medico" class="form-control campo" required>
                            <option value="">[SELECCIONE UN MEDICO]</option>
                            <?php
                              $sql = 'select m.*, e.cod_departamento from medico m inner join especialidad e on e.dni_medico=m.dni_medico where e.cod_departamento=:cod_departamento and m.estado="ACTIVO"';
                              $conexion = abrir_conexion();
                              $registros = buscar_registros($conexion, $sql, [':cod_departamento' => $_GET['D']]);
                              cerrar_conexion($conexion);

                              foreach ($registros as $item) {
                                echo '<option value="'.$item['dni_medico'].'" '.(($item['dni_medico']==$_GET['M']) ? 'selected' : '').'>'.$item['nombre'].' '.$item['apellidos'].'</option>';
                              }
                            ?>
                          </select>
                        <?php elseif ($_GET['A']=='U'): ?>
                          <input type="hidden" name="dni_medico" value="<?php echo $valores['dni_medico'] ?>" required>
                          <input type="text" name="nombre-medico" id="nombre-medico" class="form-control campo" value="<?php echo $valores['nom_med'].' '.$valores['apell_med'] ?>" required readonly>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="form-group mt-2">
                      <label>Fecha</label>
                      <input type="date" name="fecha" id="fecha" class="form-control campo" value="<?php echo $valores['fecha'] ?>" >
                    </div>

                    <div class="form-group mt-2">
                      <label>Paciente</label>
                      <input type="hidden" name="dni-paciente" id="dni-paciente" class="campo" value="<?php echo $valores['dni_paciente'] ?>" required readonly>
                      <input type="text" name="paciente-nombre" id="paciente-nombre" class="form-control campo" value="<?php echo $valores['dni_paciente'].' - '.$valores['nom_pac'].' '.$valores['apell_pac'] ?>" maxlength="150" required readonly>
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
                          $sql = 'select dni_paciente, nombre, apellidos from paciente';
    
                          $conexion = abrir_conexion();
                          $registros = buscar_registros($conexion, $sql, []);
                          cerrar_conexion($conexion);

                          foreach ($registros as $item) {
                            echo '<li class="list-group-item list-group-item-action d-none paciente" data-dni="'.$item['dni_paciente'].'">'.$item['dni_paciente'].' - '.$item['nombre'].' '.$item['apellidos'].'</li>';
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
                      <th>Paciente</th>
                      <th>Departamento</th>
                      <th>Medico</th>
                      <th>Fecha</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = 'select c.*, p.nombre nom_pac, p.apellidos apell_pac, d.nombre depto, m.nombre nom_med, m.apellidos apell_med from paciente p inner join cita c inner join medico m inner join departamento d on c.dni_medico=m.dni_medico and c.dni_paciente=p.dni_paciente and c.cod_departamento=d.cod_departamento';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, []);
                      cerrar_conexion($conexion);

                      $acceso_editar = tiene_acceso_a('U');
                      $acceso_eliminar = tiene_acceso_a('D');
                      $acceso_imprimir = tiene_acceso_a('P');
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['cod_cita'].'</td>';
                        echo '<td>'.$item['nom_pac'].' '.$item['apell_pac'].'</td>';
                        echo '<td>'.$item['depto'].'</td>';
                        echo '<td>'.$item['nom_med'].' '.$item['apell_med'].'</td>';
                        echo '<td>'.$item['fecha'].'</td>';
                        echo '<td>'.$item['estado'].'</td>';

                        echo '<td class="d-flex gap-2">';
                        if ($acceso_editar && $item['estado'] == 'PENDIENTE') {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&id='.$item['cod_cita'].'" class="icono"><i class="fa-solid fa-square-pen"></i></a>';
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=A&id='.$item['cod_cita'].'" class="icono"><i class="fa-solid fa-square-check"></i></a>';
                        }

                        if ($acceso_eliminar && $item['estado'] == 'PENDIENTE') {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=D&id='.$item['cod_cita'].'" class="icono"><i class="fa-solid fa-square-xmark"></i></a>';
                        }

                        if ($acceso_imprimir) {
                          echo '<a target="recibo" href="//'.$_SERVER['HTTP_HOST'].'/recibo/cita.php?id='.$item['cod_cita'].'" class="icono"><i class="fa-solid fa-receipt"></i></a>';
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

      $('.paciente').on('click',function() {
        pacienteEstablecer($(this).data('dni'), $(this).text());
      })

      $('#busqueda')?.on('keyup',function() {
        renderizarLista()
      })

      $('#cod-departamento').on('change', function() {
        const uri = '<?php echo $_SERVER['REQUEST_URI'] ?>'

        if (uri.includes('A=C')) {
          window.location.href = '//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ?>?A=C&D='+$(this).val()
        } else if (uri.includes('A=U')) {
          window.location.href = '//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ?>?A=U&D='+$(this).val()
        }
      })

      $('#tabla').DataTable({
        dom: 'Bfrtip',
        buttons: [  
          {
            extend: 'excel',
            title: 'LISTADO DE CITAS',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }, 
          {
            extend: 'pdf',
            title: 'LISTADO DE CITAS',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }
        ],
      })
    })

    const pacienteEstablecer = (dni, nombre) => {
      $('#dni-paciente').val(dni)
      $('#paciente-nombre').val(nombre)
    }

    const renderizarLista = () => {
      const busqueda = $('#busqueda').val().toUpperCase()

      $('.paciente').each(function() {
        if (busqueda.trim() != '' && $(this).text().toUpperCase().includes(busqueda)) {
          $(this).removeClass('d-none')
        } else {
          $(this).addClass('d-none')
        }
      })
    }
  </script>
</body>
</html>