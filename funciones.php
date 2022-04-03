<?php
  function abrir_conexion() {
    $usuario = 'id18717606_201910080047';
    $clave = '201910080047@Pass';
    $enlace = 'mysql:host=localhost;dbname=id18717606_climasys;';
    
    try {
      $conexion = new PDO($enlace, $usuario, $clave);
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conexion->exec('set time_zone = "-6:00"');
    } catch (Exception $ex) {
      die($ex->getMessage());
    }

    return $conexion;
  }

  function ejecutar_sql($conexion, $sql, $data, $mensaje='') {
    try {
      $sentencia = $conexion->prepare($sql);
      $sentencia->execute($data);
      $sentencia->closeCursor();
      if ($mensaje != '') {
        echo '<script>alert("'.$mensaje.'")</script>';
      }
    } catch (Exception $ex) {
      echo '<script>alert("'.$ex->getMessage().'")</script>';
    }
  }

  function buscar_registro($conexion, $sql, $data) {
    $registro = [];

    try {
      $sentencia = $conexion->prepare($sql);
      $sentencia->execute($data);
      $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
      $sentencia->closeCursor();
    } catch (Exception $ex) {
      echo '<script>alert("'.$ex->getMessage().'")</script>';
    }

    return $registro;
  }

  function buscar_registros($conexion, $sql, $data) {
    $registros = [];

    try {
      $sentencia = $conexion->prepare($sql);
      $sentencia->execute($data);
      $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
      $sentencia->closeCursor();
    } catch (Exception $ex) {
      echo '<script>alert("'.$ex->getMessage().'")</script>';
    }

    return $registros;
  }

  function cerrar_conexion($conexion) {
    $conexion = null;
  }

  function iniciar_session($variables = []) {
    session_start();
    foreach ($variables as $key => $value) {
      $_SESSION[$key] = $value;
    }
  }

  function generar_lista_modulo($lista) {
    $html = '';
    foreach ($lista as $item) {
      $modulo = '/mod/'.$item['cod_modulo'].'.php';
      if ($modulo) {
        $html .= '<a href="//'.$_SERVER['HTTP_HOST'].$modulo.'?A=C" class="modulo list-group-item list-group-item-action">'.$item['nombre'].'</a>';
      }
    }

    return $html;
  }

  function tiene_acceso_a($accion) {
    $modulo = basename($_SERVER["SCRIPT_FILENAME"], '.php');

    $sql = 'select * from acceso where cod_modulo=:cod_modulo and cod_usuario=:cod_usuario';
    $conexion = abrir_conexion();
    $registro = buscar_registro($conexion,$sql,[':cod_modulo' => $modulo, ':cod_usuario' => $_SESSION['codigo']]);
    cerrar_conexion($conexion);

    if (empty($registro)) {
      return false;
    }
     
    if (strpos($registro['acciones'], $accion) === false) {
      return false;
    }

    return true;
  }

  function validar_acceso() {
    $modulo = basename($_SERVER["SCRIPT_FILENAME"], '.php');

    $sql = 'select * from acceso where cod_modulo=:cod_modulo and cod_usuario=:cod_usuario';
    $conexion = abrir_conexion();
    $registro = buscar_registro($conexion,$sql,[':cod_modulo' => $modulo, ':cod_usuario' => $_SESSION['codigo']]);
    cerrar_conexion($conexion);

    if (empty($registro)) {
      header('Location: //'.$_SERVER['HTTP_HOST']);
    }
  }
?>