<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();
  
  $valores = [
    'dni_medico' => '',
    'cod_departamento' => '',
  ];

  switch ($_GET['A']) {
    case 'C':
      if (!empty($_POST)) {
        $sql = 'select * from especialidad where dni_medico=:dni_medico and cod_departamento=:cod_departamento';
    
        $conexion = abrir_conexion();
        $registro = buscar_registro($conexion, $sql, [
          ':dni_medico' => $_POST['medico'],
          ':cod_departamento' => $_POST['departamento'],
        ]);
        cerrar_conexion($conexion);
        
        if (empty($registro)) {
          $data = [
            ':dni_medico' => $_POST['medico'],
            ':cod_departamento' => $_POST['departamento'],
          ];
      
          $sql = 'insert into especialidad
            (dni_medico, cod_departamento)
            values
            (:dni_medico, :cod_departamento)';
      
          $conexion = abrir_conexion();
          ejecutar_sql($conexion, $sql, $data, 'Especialidad creada correctamente.');
          cerrar_conexion($conexion);

          $conexion = abrir_conexion();
          ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M08", :cod_usuario, now(), "Creacion de especialidad")', [':cod_usuario' => $_SESSION['codigo']]);
          cerrar_conexion($conexion);
  
          echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
        } else {
          echo '<script>alert("La especialidad ya existe")</script>';
        }
      }
      break;
    case 'D':
      $sql = 'delete from especialidad where cod_especialidad=:cod_especialidad';
  
      $conexion = abrir_conexion();
      ejecutar_sql($conexion, $sql, [':cod_especialidad' => $_GET['id']], 'Especialidad eliminada correctamente.');
      cerrar_conexion($conexion);

      $conexion = abrir_conexion();
      ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M08", :cod_usuario, now(), "Eliminacion de especialidad")', [':cod_usuario' => $_SESSION['codigo']]);
      cerrar_conexion($conexion);

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
  <title>Especialidades - Climasys</title>
  
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
                  ESPECIALIDADES
                </h2>
                <?php if (($_GET['A']=='C' and tiene_acceso_a('C')) || ($_GET['A']=='U' and tiene_acceso_a('U'))) : ?>
                  <form id="formulario" method="post">
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Departamento</label>
                        <select name="departamento" id="departamento" class="form-control campo">
                          <option value="">[SELECCIONE UN DEPARTAMENTO]</option>
                          <?php
                            $sql = 'select * from departamento';
                            $conexion = abrir_conexion();
                            $registros = buscar_registros($conexion, $sql, []);
                            cerrar_conexion($conexion);

                            foreach ($registros as $item) {
                              echo '<option value="'.$item['cod_departamento'].'">'.$item['nombre'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                      <div class="flex-grow-1">
                        <label>Medico</label>
                        <select name="medico" id="medico" class="form-control campo">
                          <option value="">[SELECCIONE UN MEDICO]</option>
                          <?php
                            $sql = 'select * from medico';
                            $conexion = abrir_conexion();
                            $registros = buscar_registros($conexion, $sql, []);
                            cerrar_conexion($conexion);

                            foreach ($registros as $item) {
                              echo '<option value="'.$item['dni_medico'].'">'.$item['nombre'].' '.$item['apellidos'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
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
                      <th>Especialidad</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = 'select e.cod_especialidad, m.dni_medico, m.nombre, m.apellidos, d.nombre especialidad
                      from medico m inner join especialidad e inner join departamento d 
                      on e.dni_medico=m.dni_medico and e.cod_departamento=d.cod_departamento
                      order by m.dni_medico';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, []);
                      cerrar_conexion($conexion);

                      $acceso_eliminar = tiene_acceso_a('D');
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['dni_medico'].'</td>';
                        echo '<td>'.$item['nombre'].' '.$item['apellidos'].'</td>';
                        echo '<td>'.$item['especialidad'].'</td>';

                        echo '<td class="d-flex gap-2">';
                        if ($acceso_eliminar) {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=D&id='.$item['cod_especialidad'].'" class="icono"><i class="fa-solid fa-square-xmark"></i></a>';
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
            title: 'LISTADO DE ESPECIALIDADES',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }, 
          {
            extend: 'pdf',
            title: 'LISTADO DE ESPECIALIDADES',
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