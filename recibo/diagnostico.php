<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recibo de diagnostico</title>
  <style>
    table {
      width: 100%;
    }
    .t-center {
      text-align: center;
    }
    .t-end {
      text-align: end;
    }
    .br {
      height: 10px;
    }
  </style>
</head>
<body>
  <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/funciones.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/sesion/validar.php';

    if (!empty($_GET['id'])) {
      $sql = 'select d.*, p.nombre nom_pac, p.apellidos apell_pac, m.nombre nom_med, m.apellidos apell_med from paciente p inner join diagnostico d inner join medico m on d.dni_medico=m.dni_medico and d.dni_paciente=p.dni_paciente where d.cod_diagnostico=:cod_diagnostico';
  
      $conexion = abrir_conexion();
      $valores = buscar_registro($conexion, $sql, [':cod_diagnostico' => $_GET['id']]);
      cerrar_conexion($conexion);
    }
  ?>
  <table id="recibo">
    <tr>
      <td class="t-center" colspan="2">CLIMASYS</td>
    </tr>
    <tr>
      <td class="t-center" colspan="2">Recibo de Diagnostico</td>
    </tr>
    <tr class="br"></tr>
    <tr>
      <td>Diagnostico:</td>
      <td class="t-end" colspan="2"><?php echo $valores['cod_diagnostico'] ?></td>
    </tr>
    <tr>
      <td>Paciente:</td>
      <td class="t-end" colspan="2"><?php echo $valores['nom_pac'].' '.$valores['apell_pac'] ?></td>
    </tr>
    <tr>
      <td>Medico:</td>
      <td class="t-end" colspan="2"><?php echo $valores['nom_med'].' '.$valores['apell_med'] ?></td>
    </tr>
    <tr class="br"></tr>
    <tr>
      <td>Subtotal:</td>
      <td class="t-end">L<?php echo $valores['precio'] ?></td>
    </tr>
    <tr>
      <td>Impuesto:</td>
      <td class="t-end">L<?php echo ($valores['precio']*0.15) ?></td>
    </tr>
    <tr>
      <td>Total:</td>
      <td class="t-end">L<?php echo ($valores['precio']+$valores['precio']*0.15) ?></td>
    </tr>
  </table>

  <script src="//<?php echo $_SERVER['HTTP_HOST'].'/js/jquery-3.6.0.min.js'; ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/vfs_fonts.min.js"></script>
  <script>
    $(document).ready(function() {
      window.print()
    })
  </script>
</body>
</html>