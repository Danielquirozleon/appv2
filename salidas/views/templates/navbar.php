<?php
// views/templates/navbar.php
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?= BASE_URL ?>"><?= APP_NAME ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?r=salida/index">Salidas</a></li>
      <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?r=historial/index">Historial</a></li>
      <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?r=import/index">Importación</a></li>
      <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?r=user/index">Usuarios</a></li>
      <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?r=report/index">Reportes</a></li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?r=auth/logout">Salir</a></li>
    </ul>
  </div>
</nav>
