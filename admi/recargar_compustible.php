<?php
require_once '../config/database.php';
$db = new Database();
$con = $db->conectar();


$precio_gasolina = 14000;
$precio_acpm = 9500;

$response = "";

if (isset($_GET["buscar"])) {
    $id = $_GET["id"];

    $sql = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
    $sql->execute([$id]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);

    echo json_encode($u);
    exit;
}


if (isset($_POST["registrar"])) {

    $id = $_POST["id"];
    $tipo = $_POST["tipo"];
    $dinero = floatval($_POST["dinero"]);

    
    $sql = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
    $sql->execute([$id]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $response = "<div class='alert alert-danger text-center'>❌ Documento no encontrado.</div>";
    } else {

        // Convertir dinero → galones
        if ($tipo == "gasolina") {
            $galones = $dinero / $precio_gasolina;
        } else {
            $galones = $dinero / $precio_acpm;
        }

        // Redondear a 2 decimales
        $galones = round($galones, 2);

       // Calcular puntos
    if ($galones == 1 || $precio_gasolina>= 14000) {
    
    $puntos = $tipo == "gasolina" ? 1 : 3;
} else {
    $puntos = 0;
}


        
        $ins = $con->prepare("
            INSERT INTO recargas (id_usuario, tipo, galones, puntos, fecha)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $ins->execute([$user["id"], $tipo, $galones, $puntos]);

        // Sumar puntos al usuario
        if ($puntos > 0) {
            $upd = $con->prepare("UPDATE usuarios SET puntos = puntos + ? WHERE id = ?");
            $upd->execute([$puntos, $user["id"]]);
        }

        $response = "
            <div class='alert alert-success text-center'>
            ✔ Recarga registrada correctamente.<br>
            Usuario: <strong>{$user['nombre']}</strong><br>
            Galones cargados: <strong>$galones</strong><br>
            Puntos obtenidos: <strong>$puntos</strong>
            </div>";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recarga de Combustible</title>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
    </style>
    
</head>
<body>
  <header>
    <img src="../img/logo-blanco-terpel.png" alt="TERPEL">
  </header>

  <div class="titulo">
    RECARGA COMBUSTIBLE<br>PARA EL BIEN DE TU VEHICULO</br>
     <a href="admi.php" class="btn btn-secondary">Volver al inicio</a>
  </div>


    <?= $response ?>

    <div class="card p-4 shadow-sm mx-auto" style="max-width: 550px;">

        <form method="POST">

            <!-- Documento -->
            <label class="form-label">Documento del usuario</label>
            <input type="text" name="id" id="id" class="form-control mb-2" required>

            <!-- Nombre automático -->
            <input type="text" id="nombre" class="form-control mb-3" placeholder="Nombre del usuario" readonly>

            <!-- Tipo de combustible -->
            <label class="form-label">Tipo de combustible</label>
            <select name="tipo" id="tipo" class="form-select mb-3" required>
                <option value="gasolina">Gasolina</option>
                <option value="acpm">ACPM</option>
            </select>

            <!-- Dinero -->
            <label class="form-label">Valor en dinero (COP)</label>
            <input type="number" name="dinero" id="dinero" class="form-control mb-3" required>

            <!-- Vista previa de galones -->
            <div class="alert alert-info text-center d-none" id="infoGalones">
                Galones calculados: <strong id="gals"></strong><br>
                Puntos obtenidos: <strong id="pts"></strong>
            </div>

            <button type="submit" name="registrar" class="btn btn-primary w-100">
                Registrar Recarga
            </button>
        </form>
    </div>
</div>

<script>
// Buscar usuario automáticamente por documento
document.getElementById("documento").addEventListener("input", async () => {
    let documento = document.getElementById("documento").value;

    if (documento.length < 3) return;

    const res = await axios.get("recarga_combustible.php", {
        params: { buscar: 1, documento }
    });

    if (res.data) {
        document.getElementById("nombre").value = res.data.nombre;
    } else {
        document.getElementById("nombre").value = "";
    }
});

// Cálculo dinámico de galones + puntos
const info = document.getElementById("infoGalones");
const gals = document.getElementById("gals");
const pts = document.getElementById("pts");

function calcular() {
    let dinero = parseFloat(document.getElementById("dinero").value);
    let tipo = document.getElementById("tipo").value;

    if (isNaN(dinero) || dinero <= 0) {
        info.classList.add("d-none");
        return;
    }

    let precio_gasolina = <?= $precio_gasolina ?>;
    let precio_acpm = <?= $precio_acpm ?>;

    let galones = tipo === "gasolina" ? dinero / precio_gasolina
                                      : dinero / precio_acpm;

    galones = galones.toFixed(2);

    gals.textContent = galones;

    pts.textContent = galones == 1 ? (tipo === "gasolina" ? 1 : 3) : 0;

    info.classList.remove("d-none");
}

document.getElementById("dinero").addEventListener("input", calcular);
document.getElementById("tipo").addEventListener("change", calcular);
</script>

</body>
</html>
