<?php
require_once "../../config/db.php";
require_once "../../model/Enemy.php";

// Verificar si se recibió el ID del enemigo
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de enemigo no proporcionado.");
}

$id = $_GET['id'];

// Obtener los datos del enemigo
$enemy = null;
try {
    $stmt = $db->prepare("SELECT * FROM enemies WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $enemy = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$enemy) {
        die("Enemigo no encontrado.");
    }
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}

// Procesar la edición si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $db->prepare("
            UPDATE enemies 
            SET name = :name, 
                description = :description, 
                isBoss = :isBoss, 
                health = :health, 
                strength = :strength, 
                defense = :defense 
            WHERE id = :id
        ");
        $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $stmt->bindValue(':isBoss', isset($_POST['isBoss']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':health', $_POST['health'], PDO::PARAM_INT);
        $stmt->bindValue(':strength', $_POST['strength'], PDO::PARAM_INT);
        $stmt->bindValue(':defense', $_POST['defense'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: edit_enemy.php");
            exit;
        } else {
            echo "Error al actualizar el enemigo.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Enemigo</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Editar Enemigo</h1>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id ?>" method="POST">
        <div>
            <label for="nameInput">Nombre:</label>
            <input type="text" name="name" id="nameInput" value="<?= htmlspecialchars($enemy['name']); ?>" required>
        </div>
        <div>
            <label for="descriptionInput">Descripción:</label>
            <input type="text" name="description" id="descriptionInput" value="<?= htmlspecialchars($enemy['description']); ?>" required>
        </div>
        <div>
            <label for="isBossInput">¿Es jefe?:</label>
            <input type="checkbox" name="isBoss" id="isBossInput" <?= $enemy['isBoss'] ? 'checked' : ''; ?>>
        </div>
        <div>
            <label for="healthInput">Puntos de Vida:</label>
            <input type="number" name="health" id="healthInput" value="<?= $enemy['health']; ?>" min="1" required>
        </div>
        <div>
            <label for="strengthInput">Fuerza:</label>
            <input type="number" name="strength" id="strengthInput" value="<?= $enemy['strength']; ?>" min="1" required>
        </div>
        <div>
            <label for="defenseInput">Defensa:</label>
            <input type="number" name="defense" id="defenseInput" value="<?= $enemy['defense']; ?>" min="1" required>
        </div>
        <div>
            <button type="submit">Guardar Cambios</button>
            <a href="edit_enemy.php">
                <button type="button">Cancelar</button>
            </a>
        </div>
    </form>
</body>
</html>
