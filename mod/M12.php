<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();
  
  $valores = [
    'cod_receta' => '',
    'cod_diagnostico' => '',
    'cod_medicamento' => '',
    'dosis' => '',
    'periodo' => '',
  ];

  switch ($_GET['A']) {
    case 'C':
      if (!empty($_POST)) {
        $data = [
          ':cod_diagnostico' => $_POST['cod-diagnostico'],
          ':cod_medicamento' => $_POST['cod-medicamento'],
          ':dosis' => $_POST['dosis'],
          ':periodo' => $_POST['periodo'],
        ];
    
        $sql = 'insert into receta
          (cod_diagnostico, cod_medicamento, dosis, periodo)
          values
          (:cod_diagnostico, :cod_medicamento, :dosis, :periodo)';
    
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data);
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M12", :cod_usuario, now(), "Creacion de receta")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C&D='.$_GET['D'].'"</script>';
      }
      break;
    case 'D':
      if (!empty($_GET['id'])) {
        $sql = 'delete from receta where cod_receta=:cod_receta';
        $conexion = abrir_conexion();
        $medico = ejecutar_sql($conexion, $sql, [':cod_receta' => $_GET['id']], $mensaje);
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M12", :cod_usuario, now(), "Eliminacion de receta")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C&D='.$_GET['D'].'"</script>';
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
  <title>Recetas - Climasys</title>
  
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
                    }
                  ?> 
                  RECETAS
                </h2>
                <?php if ($_GET['A']=='C' and tiene_acceso_a('C')) : ?>
                  <form id="formulario" method="post">
                    <div class="form-group mt-2">
                      <label>Diagnostico</label>
                      <select name="cod-diagnostico" id="cod-diagnostico" class="form-control campo" required>
                        <option value="">[SELECCIONE UN DIAGNOSTICO]</option>
                        <?php
                          $sql = 'select * from diagnostico';
    
                          $conexion = abrir_conexion();
                          $registros = buscar_registros($conexion, $sql, []);
                          cerrar_conexion($conexion);
    
                          foreach ($registros as $item) {
                            echo '<option value="'.$item['cod_diagnostico'].'" '.(($_GET['D'] == $item['cod_diagnostico']) ? 'selected' : '' ).' >'.$item['cod_diagnostico'].'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group mt-2">
                      <label>Medicamento</label>
                      <select name="cod-medicamento" id="cod-medicamento" class="form-control campo" required>
                        <option value="">[SELECCIONE UN MEDICAMENTO]</option>
                        <?php
                          $sql = 'select * from medicamento';
    
                          $conexion = abrir_conexion();
                          $registros = buscar_registros($conexion, $sql, []);
                          cerrar_conexion($conexion);
    
                          foreach ($registros as $item) {
                            echo '<option value="'.$item['cod_medicamento'].'">'.$item['nombre'].'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Dosis</label>
                        <input type="text" name="dosis" id="dosis" class="form-control campo" maxlength="50" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Periodo</label>
                        <input type="text" name="periodo" id="periodo" class="form-control campo" maxlength="50" required>
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
                      <th>Medicamento</th>
                      <th>Dosis</th>
                      <th>Periodo</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = 'select 
                        r.*, m.nombre medicamento
                        from receta r inner join medicamento m
                        on m.cod_medicamento=r.cod_medicamento where r.cod_diagnostico=:cod_diagnostico';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, [':cod_diagnostico' => $_GET['D']]);
                      cerrar_conexion($conexion);

                      $acceso_editar = tiene_acceso_a('U');
                      $acceso_eliminar = tiene_acceso_a('D');
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['medicamento'].'</td>';
                        echo '<td>'.$item['dosis'].'</td>';
                        echo '<td>'.$item['periodo'].'</td>';

                        echo '<td class="d-flex gap-2">';
                        
                        if ($acceso_eliminar) {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=D&D='.$_GET['D'].'&id='.$item['cod_receta'].'" class="icono"><i class="fa-solid fa-square-xmark"></i></a>';
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
            title: 'LISTADO DE MEDICOS',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }, 
          {
            extend: 'pdf',
            title: 'LISTADO DE MEDICOS',
            exportOptions: {
              columns: ':not(:last-child)'
            } 
          }
        ],
      })

      $('#cod-diagnostico').on('change', function() {
        window.location.href = '//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ?>?A=C&D='+$(this).val()
      })
    })
  </script>
</body>
</html>