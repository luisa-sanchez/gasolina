<?php
require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();

// Obtener todos los usuarios
$sql = $con->prepare("SELECT id, nombre, puntos FROM usuarios");
$sql->execute();
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios y Puntos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
    
        .card {
            border-radius: 15px;
        }
        .puntos {
            font-size: 22px;
            font-weight: bold;
            color: #fd0d0dff;
        }
    </style>
</head>
<body>
  <header>
    <img src="../img/logo-blanco-terpel.png" alt="Mercado Libre">
  </header>

  <div class="titulo">
    puntos obtenidos <br>por los usuarios  </br>
     <a href="admi.php" class="btn btn-secondary">Volver al inicio</a>
  </div>

    <div class="row">

        <?php foreach ($usuarios as $u): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm text-center p-3">
                    
                    <div class="card-body">
                        <h4 class="card-title"><?= $u['nombre']; ?></h4>

                        <p class="text-muted mb-1">
                            Documento: <strong><?= $u['id']; ?></strong>
                        </p>

                        <p class="puntos">
                            Puntos: <?= $u['puntos']; ?>
                        </p>

                        <a href="ver_usuario.php?id=<?= $u['id']; ?>" class="btn btn-primary">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

</body>
</html>
