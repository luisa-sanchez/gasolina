<?php
require_once '../config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("
    SELECT u.*, r.roles AS roles
    FROM usuarios u
    LEFT JOIN roles r ON r.id = u.id_rol
    ORDER BY u.id DESC
");
$sql->execute();
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Usuarios Registrados</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
  /* Estilo de tarjetas más pequeñas y ordenadas */
  #listaUsuarios {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }

  .usuario-card {
    width: 260px;       /* tamaño reducido */
    margin: 0;
  }

  .usuario-card .card {
    border-radius: 12px;
    padding: 8px;
  }

  .usuario-card .card-title {
    font-size: 1.1rem;
    font-weight: 600;
  }

  .usuario-card .card-text {
    font-size: 0.85rem;
  }

  .usuario-card .btn {
    padding: 4px 10px;
    font-size: 0.8rem;
  }
</style>

</head>
<body class="bg-light">

<div class="container py-5">

  <!-- Título y volver -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">TODOS LOS USUARIOS REGISTRADOS</h1>
    <a href="admi.php" class="btn btn-secondary">Volver al inicio</a>
  </div>

  <!-- Buscador -->
  <div class="input-group mb-4">
    <input type="text" id="busqueda" class="form-control" placeholder="Buscar usuario por nombre o documento...">
    <span class="input-group-text"><i class="bi bi-search"></i></span>
  </div>

  <!-- LISTA DE USUARIOS -->
  <div id="listaUsuarios">
    <?php foreach ($usuarios as $usu): ?>
      <div class="usuario-card">
        <div class="card shadow-sm border-0 h-100">

          <div class="card-body text-center">

            <h5 class="card-title"><?= htmlspecialchars($usu['nombre']) ?></h5>

            <p class="card-text text-muted mb-2">
              Rol: <?= htmlspecialchars($usu['id_rol']) ?>
            </p>

            <a href="editar_producto.php?id=<?= $usu['id'] ?>" class="btn btn-warning btn-sm me-2">
              <i class="bi bi-pencil"></i> Editar
            </a>

            <button class="btn btn-danger btn-sm eliminar-btn" data-id="<?= $usu['id'] ?>">
              <i class="bi bi-trash"></i> Eliminar
            </button>

          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
// Filtro de búsqueda
const inputBusqueda = document.getElementById("busqueda");
const cards = document.querySelectorAll(".usuario-card");

inputBusqueda.addEventListener("input", () => {
  const texto = inputBusqueda.value.toLowerCase();
  cards.forEach(card => {
    const nombre = card.querySelector(".card-title").textContent.toLowerCase();
    const rol = card.querySelector(".card-text").textContent.toLowerCase();
    card.style.display = (nombre.includes(texto) || rol.includes(texto)) ? "" : "none";
  });
});

// Eliminar usuario
document.querySelectorAll(".eliminar-btn").forEach(btn => {
  btn.addEventListener("click", async () => {
    const id = btn.getAttribute("data-id");
    if (!confirm("¿Seguro que deseas eliminar este usuario?")) return;

    try {
      const res = await axios.post("eliminar_producto.php", { id });

      if (res.data.message) {
        alert(res.data.message);
        location.reload();
      } else {
        alert(res.data.error || "Error al eliminar.");
      }

    } catch (error) {
      console.error(error);
      alert("❌ Error al intentar eliminar el usuario.");
    }
  });
});
</script>

</body>
</html>
