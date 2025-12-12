<?php
session_start();
require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();

if (isset($_POST['entrar'])) {
    $id = trim($_POST['id']);
    $password = $_POST['password'];

    if ($id === "" || $password === "") {
        echo '<script>alert("Datos vacíos"); location="../index.html";</script>';
        exit();
    }

    $sql = $con->prepare("SELECT * FROM usuarios WHERE id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        if (password_verify($password, $fila['password'])) {

            
            session_regenerate_id(true);

            
            $_SESSION['id'] = $fila['id'];
            $_SESSION['nombre'] = $fila['nombre'];
            $_SESSION['email'] = $fila['email'];
            $_SESSION['telefono'] = $fila['telefono'];
            $_SESSION['id_rol'] = $fila['id_rol'];

            
            $_SESSION['ultimo_acceso'] = time();

        
            if ($_SESSION['id_rol'] == 1) {
                header("Location: ../admi/admi.php");
                exit();
            } elseif ($_SESSION['id_rol'] == 2) {
                header("Location: ../usuario/usuario.php");
                exit();
            } else {
                
                session_unset();
                session_destroy();
                header("Location: ../index.html");
                exit();
            }

        } else {
            echo '<script>alert("Contraseña incorrecta"); location="../index.html";</script>';
            exit();
        }
    } else {
        echo '<script>alert("Documento no encontrado"); location="../index.html";</script>';
        exit();
    }
}
?>
