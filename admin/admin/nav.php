<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD - Pemilu Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary container-fluid ">
  <div class="container">
    <a class="navbar-brand" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php">Beranda</a>
        </li>
   
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="tps.php">Data Tps</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="calon.php">Data Calon</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="pemilu.php">Data Pemilu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="laporan.php">Laporan</a>
        </li>
      </ul>
      <ul class="navbar-nav d-flex">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo $_SESSION['username']; ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="crud.php">Edit Data</a></li>
            <li><hr class="dropdown-divider"></li>
            <form method="POST">
        <button class="dropdown-item btn" type="submit" name="logout">Logout</button>
    </form>
          </ul>
        </li>
</ul>
    </div>
  </div>
</nav>
