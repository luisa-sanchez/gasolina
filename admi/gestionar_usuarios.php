<?php
session_start();
require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();

if (isset($_POST['registrar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST["password"];
    $rol = 2;
    $fecha_registro = date("Y-m-d H:i:s");

    // Verificar si el documento o correo ya existen
    $sql = $con->prepare("SELECT * FROM usuarios WHERE id = ? OR email = ?");
    $sql->execute([$id, $email]);
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        echo '<script>alert("Documento o correo ya existen");</script>';
    } elseif (empty($id) || empty($nombre) || empty($email) || empty($telefono) || empty($password)) {
        echo '<script>alert("Existen campos vacíos");</script>';
    } else {
        // Encriptar contraseña correctamente
        $hashing = password_hash($password, PASSWORD_DEFAULT);

        $insertSQL = $con->prepare("INSERT INTO usuarios (id, nombre, email, telefono, password, id_rol, fecha_registro) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertSQL->execute([$id, $nombre, $email, $telefono, $hashing, $rol, $fecha_registro]);

        echo '<script>alert("Registro exitoso");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crea tu cuenta | Mercado Libre</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff;
      margin: 0;
      padding: 0;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }
  header {
  background-color: #ff0000ff;
  padding: 5px 0; /* reducido */
}

  .titulo {
  text-align: center;
  background-color: #ff0000ff;
  padding: 15px 0; /* antes era 40px */
  font-size: 26px; 
  font-weight: 700;
  font-family: "Poppins", sans-serif;
  color: #ffffff;
  letter-spacing: 1px;
}

    header img {
      width: 220px;
      margin-left: 40px;
    }
    .registro-container {
      max-width: 400px;
      margin: 50px auto;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 30px;
    }
    
    .form-control {
      border-radius: 10px;
    }
    .btn-primary {
      background-color: #fa3434ff;
      border: none;
      border-radius: 10px;
      width: 100%;
      font-weight: bold;
    }
    .btn-primary:hover {
      background-color: #c82929ff;
    }
    .footer-text {
      text-align: center;
      font-size: 14px;
      margin-top: 10px;
      color: #777777;
    }
  </style>
</head>
<body>
  <header>
    <img src="../img/logo-blanco-terpel.png" alt="Mercado Libre">
  </header>

  <div class="titulo">
    registra usuarios <br>para beneficios </br>
     <a href="admi.php" class="btn btn-secondary">Volver al inicio</a>
  </div>

  <div class="registro-container">
    
    <form method="POST" action="">
      <div class="mb-3">
        <label for="id" class="form-label">Documento</label>
        <input type="number" name="id" class="form-control" id="id" placeholder="Número de documento" required>
      </div>

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombres completos</label>
        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre completo" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="ejemplo@correo.com" required>
      </div>

      <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="+57" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Crea una contraseña" required>
      </div>

      <button type="submit" name="registrar" class="btn btn-primary">Continuar</button>
    </form>

    <div class="footer-text">
    <a href="usuarios_todo.php">ver registros</a>
    </div>
  </div>
</body>
</html>
