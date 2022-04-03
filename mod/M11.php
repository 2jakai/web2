<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';
  validar_acceso();
  
  $valores = [
    'cod_diagnostico' => '',
    'cod_cita' => '',
    'dni_medico' => '',
    'dni_paciente' => '',
    'fecha' => '',
    'peso' => '',
    'altura' => '',
    'temperatura' => '',
    'presion' => '',
    'sintomas' => '',
    'observaciones' => '',
    'precio' => '',
  ];

  switch ($_GET['A']) {
    case 'C':
      if (!empty($_GET['C'])) {
        $sql = 'select * from cita where cod_cita=:cod_cita';
    
        $conexion = abrir_conexion();
        $cita = buscar_registro($conexion, $sql, [':cod_cita' => $_GET['C']]);
        cerrar_conexion($conexion);
        $valores['cod_cita'] = $cita['cod_cita'];
        $valores['dni_medico'] = $cita['dni_medico'];
        $valores['dni_paciente'] = $cita['dni_paciente'];
      }

      if (!empty($_POST)) {
        $data = [
          ':cod_cita' => $_POST['cod-cita'],
          ':dni_medico' => $_POST['dni-medico'],
          ':dni_paciente' => $_POST['dni-paciente'],
          ':peso' => $_POST['peso'],
          ':altura' => $_POST['altura'],
          ':temperatura' => $_POST['temperatura'],
          ':presion' => $_POST['presion'],
          ':sintomas' => $_POST['sintomas'],
          ':observaciones' => $_POST['observaciones'],
          ':precio' => $_POST['precio'],
        ];
    
        $sql = 'insert into diagnostico
          (cod_cita, dni_medico, dni_paciente, fecha, peso, altura, temperatura, presion, sintomas, observaciones, precio)
          values
          (:cod_cita, :dni_medico, :dni_paciente, now(), :peso, :altura, :temperatura, :presion, :sintomas, :observaciones, :precio)';
    
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Diagnostico creado correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M11", :cod_usuario, now(), "Creacion de diagnostico")', [':cod_usuario' => $_SESSION['codigo']]);
        cerrar_conexion($conexion);

        echo '<script>window.location.href = "//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=C"</script>';
      }
      break;
    case 'U':
      if (!empty($_GET['id'])) {
        $sql = 'select * from diagnostico where cod_diagnostico=:cod_diagnostico';
    
        $conexion = abrir_conexion();
        $valores = buscar_registro($conexion, $sql, [':cod_diagnostico' => $_GET['id']]);
        cerrar_conexion($conexion);
      }

      if (!empty($_POST)) {
        $data = [
          ':cod_diagnostico' => $_POST['cod-diagnostico'],
          ':cod_cita' => $_POST['cod-cita'],
          ':dni_medico' => $_POST['dni-medico'],
          ':dni_paciente' => $_POST['dni-paciente'],
          ':peso' => $_POST['peso'],
          ':altura' => $_POST['altura'],
          ':temperatura' => $_POST['temperatura'],
          ':presion' => $_POST['presion'],
          ':sintomas' => $_POST['sintomas'],
          ':observaciones' => $_POST['observaciones'],
          ':precio' => $_POST['precio'],
        ];
    
        $sql = 'update diagnostico set cod_cita=:cod_cita, dni_medico=:dni_medico, dni_paciente=:dni_paciente, peso=:peso, altura=:altura, temperatura=:temperatura, presion=:presion, sintomas=:sintomas, observaciones=:observaciones, precio=:precio where cod_diagnostico=:cod_diagnostico';
        $conexion = abrir_conexion();
        ejecutar_sql($conexion, $sql, $data, 'Diagnostico actualizado correctamente.');
        cerrar_conexion($conexion);

        $conexion = abrir_conexion();
        ejecutar_sql($conexion, 'insert into bitacora (cod_modulo, cod_usuario, fecha, evento) values ("M11", :cod_usuario, now(), "Edicion de diagnostico")', [':cod_usuario' => $_SESSION['codigo']]);
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
  <title>Diagnosticos - Climasys</title>
  
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
                  DIAGNOSTICOS
                </h2>
                <?php if (($_GET['A']=='C' and tiene_acceso_a('C')) || ($_GET['A']=='U' and tiene_acceso_a('U'))) : ?>
                  <form id="formulario" method="post">
                    <?php if ($_GET['A']=='U'): ?>
                      <div class="form-group mt-2">
                        <label>Codigo</label>
                        <input type="text" name="cod-diagnostico" id="cod-diagnostico" class="form-control campo" value="<?php echo $valores['cod_diagnostico'] ?>" maxlength="50" required readonly>
                      </div>
                    <?php endif; ?>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <?php if ($_GET['A']=='C'): ?>
                          <label>Cita</label>
                          <select name="cod-cita" id="cod-cita" class="form-control campo" required>
                            <option value="">[SELECCIONE UNA CITA]</option>
                            <?php
                              $sql = 'select * from cita where fecha=date(now()) and cod_cita not in (select cod_cita from diagnostico where fecha=date(now()))';
      
                              $conexion = abrir_conexion();
                              $registros = buscar_registros($conexion, $sql, []);
                              cerrar_conexion($conexion);
      
                              foreach ($registros as $item) {
                                echo '<option value="'.$item['cod_cita'].'" '.(($valores['cod_cita'] == $item['cod_cita']) ? 'selected' : '' ).' >'.$item['cod_cita'].'</option>';
                              }
                            ?>
                          </select>
                        <?php elseif ($_GET['A']=='U'): ?>
                          <label>Cita</label>
                          <input type="text" name="cod-cita" id="cod-cita" class="form-control campo" value="<?php echo $valores['cod_cita'] ?>" maxlength="50" required readonly>
                        <?php endif; ?>
                      </div>
                      <div class="flex-grow-1">
                        <label>Medico</label>
                        <input type="text" name="dni-medico" id="dni-medico" class="form-control campo" value="<?php echo $valores['dni_medico'] ?>" maxlength="50" required readonly>
                      </div>
                      <div class="flex-grow-1">
                        <label>Paciente</label>
                        <input type="text" name="dni-paciente" id="dni-paciente" class="form-control campo" value="<?php echo $valores['dni_paciente'] ?>" maxlength="50" required readonly>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Peso</label>
                        <input type="number" name="peso" id="peso" class="form-control campo" value="<?php echo $valores['peso'] ?>" step="1" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Altura</label>
                        <input type="number" name="altura" id="altura" class="form-control campo" value="<?php echo $valores['altura'] ?>" step="1" required>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Temperatura</label>
                        <input type="number" name="temperatura" id="temperatura" class="form-control campo" value="<?php echo $valores['temperatura'] ?>" step="1" required>
                      </div>
                      <div class="flex-grow-1">
                        <label>Presion</label>
                        <input type="text" name="presion" id="presion" class="form-control campo" value="<?php echo $valores['presion'] ?>" maxlength="50" required>
                      </div>
                    </div>
                    <div class="form-group mt-2 d-flex gap-2">
                      <div class="flex-grow-1">
                        <label>Sintomas</label>
                        <textarea name="sintomas" id="sintomas" class="form-control campo" maxlength="100" required><?php echo $valores['sintomas'] ?></textarea>
                      </div>
                      <div class="flex-grow-1">
                        <label>Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control campo" maxlength="100" required><?php echo $valores['observaciones'] ?></textarea>
                      </div>
                    </div>
                    <div class="form-group mt-2">
                      <label>Precio</label>
                      <input type="number" name="precio" id="precio" class="form-control campo" value="<?php echo $valores['precio'] ?>" step="0.5" required <?php echo ($_GET['A']=='U') ? 'readonly' : '' ?>>
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
                      <th>Cita</th>
                      <th>Medico</th>
                      <th>Paciente</th>
                      <th>Fecha</th>
                      <th>Peso</th>
                      <th>Altura</th>
                      <th>Temperatura</th>
                      <th>Presion</th>
                      <th>Sintomas</th>
                      <th>Observaciones</th>
                      <th>Precio</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = 'select d.*, m.nombre nom_med, m.apellidos apell_med, p.nombre nom_pac, p.apellidos apell_pac from diagnostico d inner join medico m inner join paciente p on d.dni_medico=m.dni_medico and d.dni_paciente=p.dni_paciente';
  
                      $conexion = abrir_conexion();
                      $registros = buscar_registros($conexion, $sql, []);
                      cerrar_conexion($conexion);

                      $acceso_editar = tiene_acceso_a('U');
                      $acceso_eliminar = tiene_acceso_a('D');
                      $acceso_imprimir = tiene_acceso_a('P');
  
                      foreach ($registros as $item) {
                        echo '<tr>';
                        echo '<td>'.$item['cod_diagnostico'].'</td>';
                        echo '<td>'.$item['cod_cita'].'</td>';
                        echo '<td>'.$item['nom_med'].' '.$item['apell_med'].'</td>';
                        echo '<td>'.$item['nom_pac'].' '.$item['apell_pac'].'</td>';
                        echo '<td>'.$item['fecha'].'</td>';
                        echo '<td>'.$item['peso'].'</td>';
                        echo '<td>'.$item['altura'].'</td>';
                        echo '<td>'.$item['temperatura'].'</td>';
                        echo '<td>'.$item['presion'].'</td>';
                        echo '<td>'.$item['sintomas'].'</td>';
                        echo '<td>'.$item['observaciones'].'</td>';
                        echo '<td>'.$item['precio'].'</td>';

                        echo '<td class="d-flex gap-2">';
                        if ($acceso_editar) {
                          echo '<a href="//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?A=U&id='.$item['cod_diagnostico'].'" class="icono"><i class="fa-solid fa-square-pen"></i></a>';
                        }

                        if ($acceso_imprimir) {
                          echo '<a target="recibo" href="//'.$_SERVER['HTTP_HOST'].'/recibo/diagnostico.php?id='.$item['cod_diagnostico'].'" class="icono"><i class="fa-solid fa-receipt"></i></a>';
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

      $('#cod-cita').on('change', function() {
        window.location.href = '//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ?>?A=C&C='+$(this).val()
      })
    })
  </script>
</body>
</html>