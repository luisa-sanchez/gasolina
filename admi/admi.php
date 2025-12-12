<?php
session_start();
require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();


if (!isset($_SESSION['id'])) {
  header("Location: ../login.php");
  exit;
}



$sql = $con->prepare("SELECT nombre, id_rol FROM usuarios WHERE id = ?");
$sql->execute([$_SESSION['id']]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die(" Usuario no encontrado en la base de datos.");
}


$sql = $con->prepare("SELECT roles FROM roles WHERE id = ?");
$sql->execute([$user['id_rol']]);
$rol = $sql->fetch(PDO::FETCH_ASSOC);

if (!$rol) {
    die(" Rol no encontrado en la base de datos.");
}

$nombre = $user['nombre'];
$roles = $rol['roles'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administrador | terpel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Helvetica Neue', Arial, sans-serif;
      background-color: #f5f5f5;
    }
    .sidebar {
      height: 100vh;
      background-color: #ff0000ff;
      padding-top: 20px;
      position: fixed;
      width: 250px;
    }
    .sidebar a {
      display: block;
      color: #000;
      padding: 12px 20px;
      text-decoration: none;
      font-weight: 500;
    }
    .sidebar a:hover {
      background-color: #ff7676ff;
      border-radius: 8px;
    }
    .content {
      margin-left: 260px;
      padding: 30px;
    }
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  
  <div class="sidebar">
    <div class="text-center mb-4">
      <img src="../img/logo-blanco-terpel.png" width="150" alt="Logo">
      <div style="text-align:center; background:#ff0000ff; padding:10px;">
    
    <h2><?php echo $nombre . " eres " . $roles; ?></h2>
</div>
    </div>
    <a href="productos_admi.php"><i class="bi bi-box-seam"></i> Recargas</a>
    <a href="usuarios.php"><i class="bi bi-people"></i> Puntos de usuarios</a>
    <a href="compras.php"><i class="bi bi-cart"></i> usuarios</a>
    <a href="perfil.php"><i class="bi bi-person-circle"></i> Mi Perfil</a>
    <a href="../includes/logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
  </div>

  
  <div class="content">
    <nav class="navbar mb-4">
      <div class="container-fluid">
        <h4 class="m-0">menu de administrador</h4>
      </div>
    </nav>

    <div class="row">
      
      <div class="col-md-4 mb-4">
  <div class="card text-center shadow-sm border-danger">
    <div class="card-body">
      <i class="bi bi-people fs-1 text-danger"></i>
      <h5 class="mt-3 text-danger">GESTION DE USUARIOS</h5>
      <p class="text-dark">registro de nuevos usuarios</p>
      <a href="gestionar_usuarios.php" class="btn btn-danger text-white">REGISTRAR </a>
    </div>
  </div>
</div>

     <div class="col-md-4 mb-4">
  <div class="card text-center shadow-sm border-danger">
    <div class="card-body">
      <i class="bi bi-people fs-1 text-danger"></i>
      <h5 class="mt-3 text-danger">RECARGAR COMBUSTIBLE</h5>
      <p class="text-dark">no te quedes sin combustibles</p>
      <a href="recargar_compustible.php" class="btn btn-danger text-white">RECARGAR</a>
    </div>
  </div>
</div>
     <div class="col-md-4 mb-4">
  <div class="card text-center shadow-sm border-danger">
    <div class="card-body">
      <i class="bi bi-people fs-1 text-danger"></i>
      <h5 class="mt-3 text-danger">GESTION DE PUNTOS</h5>
      <p class="text-dark">mira cunatos puntos tienes registrados</p>
      <a href="puntos.php" class="btn btn-danger text-white">VER </a>
    </div>
  </div>
</div>
    </div>
  </div>

</body>
</html>
