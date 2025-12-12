<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();

$id_usuario = $_SESSION['id'];

// Obtener puntos y datos
$sql = $con->prepare("SELECT nombre, email, puntos, fecha_registro FROM usuarios WHERE id = ?");
$sql->execute([$id_usuario]);
$usuario = $sql->fetch(PDO::FETCH_ASSOC);

// Obtener última recarga (si existe)
$sql2 = $con->prepare("SELECT fecha FROM recargas WHERE id_usuario = ? ORDER BY id DESC LIMIT 1");
$sql2->execute([$id_usuario]);
$ultima = $sql2->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis Puntos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
    background: url('../img/lindos.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Poppins', sans-serif;
}

    .card-premium {
        background: #fff;
        width: 420px;
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
    }

    .card-premium::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 180px;
        height: 180px;
        background: #fd0d0dff;
        border-radius: 50%;
        opacity: .15;
    }

    .circle-icon {
        width: 85px;
        height: 85px;
        background: #fd310dff;
        border-radius: 50%;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 40px;
        margin: 0 auto;
    }

    .points {
        font-size: 48px;
        font-weight: 700;
        color: #fd0d0dff;
    }

    .label-text {
        color: #6c757d;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-box {
        background: #f7f9fc;
        padding: 15px;
        border-radius: 12px;
        margin-top: 15px;
    }

    .btn-custom {
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 16px;
    }

</style>
</head>

<body>

<div class="card-premium">

    <div class="circle-icon mb-3">
        <i class="bi bi-stars"></i>
    </div>

    <h2 class="text-center mb-1"><?= $usuario['nombre'] ?></h2>
    <p class="text-center text-muted mb-4"><?= $usuario['email'] ?></p>

    <p class="label-text text-center">Mis puntos actuales</p>
    <p class="points text-center"><?= $usuario['puntos'] ?> </p>

    <div class="info-box">
        <p class="mb-1"><strong>Última recarga:</strong></p>
        <p class="text-muted">
            <?= $ultima ? $ultima['fecha'] : "No tiene recargas aún" ?>
        </p>
    </div>

    <div class="info-box mt-3">
        <p class="mb-1"><strong>Fecha de registro:</strong></p>
        <p class="text-muted"><?= $usuario['fecha_registro'] ?></p>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary btn-custom">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

</div>

</body>
</html>
