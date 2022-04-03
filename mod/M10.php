<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();
  
  $valores = [
    'cod_medicamento' => '',
    'cod_proveedor' => '',
    'nombre' => '',
    'ingreso' => '',
    'vencimiento' => '',
    'cantidad' => '',
    'costo' => '',
    'precio' => '',
    'descripcion' => '',
  ];

  switch ($_GET['A']) {
    case 'C':
      if (!empty($_POST)) {
        $data = [
          ':cod_medicamento' => $_POST['cod-medicamento'],
          ':cod_proveedor' => $_POST['cod-proveedor'],
          ':nombre' => $_POST['nombre'],
          ':ingreso' => $_POST['ingreso'],
          ':vencimiento' => $_POST['vencimiento'],
          ':cantidad' => $_POST['cantidad'],
          ':costo' => $_POST['costo'],
          ':precio' => $_POST['precio'],
          ':descripcion' => $_POST['descripcion'],
        ];
  
        $sql = 'insert into medicamento
          (cod_medicamento, cod_proveedor, nombre, ingreso, vencimiento, cantidad, costo, precio, descripcion)
          values
          (:cod_medicamento, :cod_proveedor, :nombre, :ingreso, :vencimiento, :cantidad, :costo, :precio, :descripcion)';
  
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Medicamento creada correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M10", :cod_usuario, now(), "Creacion de medicamento")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      }
      break;
    case 'U':
      if (!empty($_GET['id'])) {
        $sql = 'select * from medicamento where cod_medicamento=:cod_medicamento';
    
        $conexion = abrir_conexion();
        $valores = buscar_registro($conexion, $sql, [':cod_medicamento' => $_GET['id']]);
        cerrar_conexion($conexion);
      }

      if (!empty($_POST)) {
        $data = [
          ':cod_medicamento' => $_POST['cod-medicamento'],
          ':cod_proveedor' => $_POST['cod-proveedor'],
          ':nombre' => $_POST['nombre'],
          ':ingreso' => $_POST['ingreso'],
          ':vencimiento' => $_POST['vencimiento'],
          ':cantidad' => $_POST['cantidad'],
          ':costo' => $_POST['costo'],
          ':precio' => $_POST['precio'],
          ':descripcion' => $_POST['descripcion'],
        ];
    
        $sql = 'update medicamento set cod_proveedor=:cod_proveedor, nombre=:nombre, ingreso=:ingreso, vencimiento=:vencimiento, cantidad=:cantidad, costo=:costo, precio=:precio, descripcion=:descripcion where cod_medicamento=:cod_medicamento';
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Medicamento actualizada correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M10", :cod_usuario, now(), "Edicion de medicamento")', [':cod_usuario' => $_SESSION['codigo']]);
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
  <title>Medicamentos - Climasys</title>
  
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
                  MEDICAMENTOS
                </h2>
                <?php if (($_GET['A']=='C' and tiene_acceso_a('C')) || ($_GET['A']=='U' and tiene_acceso_a('U'))) : ?>
                  <form id="formulario" method="post">
                    <?php if ($_GET['A']=='U'): ?>
                      <div class="form-group mt-2">
                        <label>Codigo</label>
                        <input type="text" name="cod-medicamento" id="cod-medicamento" class="form-control campo" value="<?php echo $valores['cod_medicamento'] ?>" maxlength="50" required readonly>
                      </div>
                    <?php endif; ?>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control campo" value="<?php echo $valores['nombre'] ?>" maxlength="50" required>
                      </div>
                      <div>
                        <label>Proveedor</label>
                        <select name="cod-proveedor" id="cod-proveedor" class="form-control campo" required>
                          <option value="">[SELECCIONE UN PROVEEDOR]</option>
                          <?php
                            $sql = 'select * from proveedor where estado="ACTIVO"';
    
                            $conexion = abrir_conexion();
                            $registros = buscar_registros($conexion, $sql, []);
                            cerrar_conexion($conexion);
    
                            foreach ($registros as $item) {
                              echo '<option value="'.$item['cod_proveedor'].'" '.(($valores['cod_proveedor'] == $item['cod_proveedor']) ? 'selected' : '' ).' >'.$item['nombre'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Fecha de ingreso</label>
                        <input type="date" name="ingreso" id="ingreso" class="form-control campo" value="<?php echo $valores['ingreso'] ?>" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Fecha de vencimiento</label>
                        <input type="date" name="vencimiento" id="vencimiento" class="form-control campo" value="<?php echo $valores['vencimiento'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control campo" value="<?php echo $valores['cantidad'] ?>" step="1" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Costo</label>
                        <input type="number" name="costo" id="costo" class="form-control campo" value="<?php echo $valores['costo'] ?>" step="0.5" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Precio</label>
                        <input type="number" name="precio" id="precio" class="form-control campo" value="<?php echo $valores['precio'] ?>" step="0.5" required>
                      </div>
                    </div>
                    <div class="form-group mt-2">
                      <label>Descripcion</label>
                      <textarea name="descripcion" id="descripcion" class="form-control campo" maxlength="100" required><?php echo $valores['descripcion'] ?></textarea>
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
                      <th>Proveedor</th>
                      <th>Ingreso</th>
                      <th>Vencimiento</th>
                      <th>Cantidad</th>
                      <th>Costo</th>
                      <th>Precio</th>
                      <th>Descripcion</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = 'select m.*, p.nombre proveedor from medicamento m inner join proveedor p on m.cod_proveedor=p.cod_proveedor';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, []);
                      cerrar_conexion($conexion);

                      $acceso_editar = tiene_acceso_a('U');
                      $acceso_eliminar = tiene_acceso_a('D');
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['cod_medicamento'].'</td>';
                        echo '<td>'.$item['nombre'].'</td>';
                        echo '<td>'.$item['proveedor'].'</td>';
                        echo '<td>'.$item['ingreso'].'</td>';
                        echo '<td>'.$item['vencimiento'].'</td>';
                        echo '<td>'.$item['cantidad'].'</td>';
                        echo '<td>'.$item['costo'].'</td>';
                        echo '<td>'.$item['precio'].'</td>';
                        echo '<td>'.$item['descripcion'].'</td>';

                        echo '<td class="d-flex gap-2">';
                        if ($acceso_editar) {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&id='.$item['cod_medicamento'].'" class="icono"><i class="fa-solid fa-square-pen"></i></a>';
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
    })
  </script>
</body>
</html>