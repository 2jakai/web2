<?php
  session_start();
  if (empty($_SESSION['codigo'])) {
    header('Location: //'.$_SERVER['HTTP_HOST'].'/sesion/iniciar.php');
  }
?>