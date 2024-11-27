<?php
require_once "../../config/db.php";
require_once "../../model/Enemy.php";

// Consultar los enemigos existentes
$enemies = [];
try {
    $stmt = $db->query("SELECT * FROM enemies");
    $enemies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
}

// Procesar la eliminación si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $stmt = $db->prepare("DELETE FROM enemies WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $successMessage = "Enemigo eliminado correctamente.";
        } else {
            $errorMessage = "Error al eliminar el enemigo.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
    // Actualizar la lista después de eliminar
    try {
        $stmt = $db->query("SELECT * FROM enemies");
        $enemies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al leer la base de datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Enemigos</title>
    <script>
        function confirmDelete(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este enemigo?")) {
                document.getElementById('deleteForm-' + id).submit();
            }
        }
    </script>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Borrar Enemigos</h1>

    <?php if (isset($successMessage)): ?>
        <p style="color: green;"><?= $successMessage; ?></p>
    <?php endif; ?>
    <?php if (isset($errorMessage)): ?>
        <p style="color: red;"><?= $errorMessage; ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Boss</th>
                <th>Vida</th>
                <th>Fuerza</th>
                <th>Defensa</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($enemies as $enemy): ?>
                <tr>
                    <td><?= htmlspecialchars($enemy['name']); ?></td>
                    <td><?= htmlspecialchars($enemy['description']); ?></td>
                    <td><?= $enemy['isBoss'] ? 'Sí' : 'No'; ?></td>
                    <td><?= $enemy['health']; ?></td>
                    <td><?= $enemy['strength']; ?></td>
                    <td><?= $enemy['defense']; ?></td>
                    <td>
                        <form id="deleteForm-<?= $enemy['id']; ?>" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $enemy['id']; ?>">
                            <button type="button" onclick="confirmDelete(<?= $enemy['id']; ?>)">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="create_enemy.php">Crear Enemigos</a></button>
        <button><a href="edit_enemy.php">Editar Enemigos</a></button>
        <button><a href="list_enemies.php">Listar Enemigos</a></button> 
    </div>
</body>
</html>
