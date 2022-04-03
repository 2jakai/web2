<nav id="navbar" class="navbar flex-nowrap align-items-end bg-green">
  <div class="container-fluid flex-nowrap">
    <div class="d-flex flex-nowrap gap-3 align-items-center">
      <button id="sidebarToggle" class="btn">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="d-flex flex-column">
        <a class="marca" href="//<?php echo $_SERVER['HTTP_HOST'] ?>">CLIMASYS</a>
        <span class="sesion-tipo"><?php echo $_SESSION['tipo'] ?></span>
      </div>
    </div>
    <div class="der btn-group">
      <a href="<?php echo '//'.$_SERVER['HTTP_HOST'].'/sesion/terminar.php'?>" class="btn">Log out</a>
    </div>
  </div>
</nav>