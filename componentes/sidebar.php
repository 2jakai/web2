<?php
  $sql = 'select m.cod_modulo, m.nombre from modulo m inner join acceso a on m.cod_modulo=a.cod_modulo where a.cod_usuario=:usuario and m.estado="ACTIVO"';
      
  $conexion = abrir_conexion();
  $registros = buscar_registros($conexion, $sql, [':usuario' => $_SESSION['codigo']]);
  cerrar_conexion($conexion);
?>

<nav id="sidebar" class="list-group bg-green rounded-0">
  <?php
    if (!empty($registros)) {
      echo generar_lista_modulo($registros);
    }
  ?>
</nav>