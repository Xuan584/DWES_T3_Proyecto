<?php
require_once "../../config/db.php";
require_once "../../model/Item.php";

// Consultar los ítems existentes
$items = [];
try {
    $stmt = $db->query("SELECT * FROM items");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
}

// Procesar la eliminación si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $stmt = $db->prepare("DELETE FROM items WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $successMessage = "Ítem eliminado correctamente.";
        } else {
            $errorMessage = "Error al eliminar el ítem.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
    // Actualizar la lista después de eliminar
    try {
        $stmt = $db->query("SELECT * FROM items");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Borrar Ítems</title>
    <script>
        function confirmDelete(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este ítem?")) {
                document.getElementById('deleteForm-' + id).submit();
            }
        }
    </script>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Borrar Ítems</h1>

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
                <th>Tipo</th>
                <th>Efecto</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= htmlspecialchars($item['description']); ?></td>
                    <td><?= htmlspecialchars($item['type']); ?></td>
                    <td><?= $item['effect']; ?></td>
                    <td>
                        <form id="deleteForm-<?= $item['id']; ?>" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $item['id']; ?>">
                            <button type="button" onclick="confirmDelete(<?= $item['id']; ?>)">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="create_item.php">Crear Ítems</a></button>
        <button><a href="edit_item.php">Editar Ítems</a></button>
        <button><a href="list_items.php">Listar Ítems</a></button> 
    </div>
</body>
</html>
