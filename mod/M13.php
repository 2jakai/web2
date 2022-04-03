<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bitacora - Climasys</title>
  
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
                  BITACORA
                </h2>
                <form id="formulario" method="get">
                  <div class="form-group mt-2 d-flex gap-2">
                    <div class="flex-grow-1">
                      <label>Inicio</label>
                      <input type="date" name="inicio" id="inicio" class="form-control campo" value="<?php echo $_GET['inicio'] ?>" required>
                    </div>
                    <div class="flex-grow-1">
                      <label>Final</label>
                      <input type="date" name="final" id="final" class="form-control campo" value="<?php echo $_GET['final'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group mt-4">
                    <input type="submit" value="Generar" class="btn w-100">
                  </div>
                </form>
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
                      <th>Modulo</th>
                      <th>Usuario</th>
                      <th>Fecha</th>
                      <th>Evento</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = 'select * from bitacora where fecha between :inicio and :final';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, [':inicio' => $_GET['inicio'], ':final' => $_GET['final']]);
                      cerrar_conexion($conexion);
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['cod_bitacora'].'</td>';
                        echo '<td>'.$item['cod_modulo'].'</td>';
                        echo '<td>'.$item['cod_usuario'].'</td>';
                        echo '<td>'.$item['fecha'].'</td>';
                        echo '<td>'.$item['evento'].'</td>';
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
            title: 'BITACORA'
          }, 
          {
            extend: 'pdf',
            title: 'BITACORA'
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