<?php
require_once "../../config/db.php";
require_once "../../model/Character.php";

// Consultar los personajes existentes
$characters = [];
try {
    $stmt = $db->query("SELECT * FROM characters");
    $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
}

// Procesar la eliminación si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $stmt = $db->prepare("DELETE FROM characters WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $successMessage = "Personaje eliminado correctamente.";
        } else {
            $errorMessage = "Error al eliminar el personaje.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
    // Actualizar la lista después de eliminar
    try {
        $stmt = $db->query("SELECT * FROM characters");
        $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Borrar Personajes</title>
    <script>
        function confirmDelete(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este personaje?")) {
                document.getElementById('deleteForm-' + id).submit();
            }
        }
    </script>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Borrar Personajes</h1>

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
                <th>Vida</th>
                <th>Fuerza</th>
                <th>Defensa</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($characters as $character): ?>
                <tr>
                    <td><?= htmlspecialchars($character['name']); ?></td>
                    <td><?= htmlspecialchars($character['description']); ?></td>
                    <td><?= $character['health']; ?></td>
                    <td><?= $character['strength']; ?></td>
                    <td><?= $character['defense']; ?></td>
                    <td>
                        <form id="deleteForm-<?= $character['id']; ?>" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $character['id']; ?>">
                            <button type="button" onclick="confirmDelete(<?= $character['id']; ?>)">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="create_character.php">Crear Personajes</a></button>
        <button><a href="edit_character.php">Editar Personajes</a></button>
        <button><a href="list_characters.php">Listar Personajes</a></button> 
    </div>
</body>
</html>
