<?php
require_once "../../config/db.php";
require_once "../../model/Character.php";

// Verificar si se recibió el ID del personaje
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de personaje no proporcionado.");
}

$id = $_GET['id'];

// Obtener los datos del personaje
$character = null;
try {
    $stmt = $db->prepare("SELECT * FROM characters WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $character = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$character) {
        die("Personaje no encontrado.");
    }
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}

// Procesar la edición si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $db->prepare("UPDATE characters SET name = :name, description = :description, health = :health, strength = :strength, defense = :defense WHERE id = :id");
        $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $stmt->bindValue(':health', $_POST['health'], PDO::PARAM_INT);
        $stmt->bindValue(':strength', $_POST['strength'], PDO::PARAM_INT);
        $stmt->bindValue(':defense', $_POST['defense'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: edit_character.php");
            exit;
        } else {
            echo "Error al actualizar el personaje.";
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
    <title>Editar Personaje</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Editar Personaje</h1>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id ?>" method="POST">
        <div>
            <label for="nameInput">Nombre:</label>
            <input type="text" name="name" id="nameInput" value="<?= htmlspecialchars($character['name']); ?>" required>
        </div>
        <div>
            <label for="descriptionInput">Descripción:</label>
            <input type="text" name="description" id="descriptionInput" value="<?= htmlspecialchars($character['description']); ?>" required>
        </div>
        <div>
            <label for="healthInput">Puntos de Vida:</label>
            <input type="number" name="health" id="healthInput" value="<?= $character['health']; ?>" min="1" required>
        </div>
        <div>
            <label for="strengthInput">Fuerza:</label>
            <input type="number" name="strength" id="strengthInput" value="<?= $character['strength']; ?>" min="1" required>
        </div>
        <div>
            <label for="defenseInput">Defensa:</label>
            <input type="number" name="defense" id="defenseInput" value="<?= $character['defense']; ?>" min="1" required>
        </div>
        <div>
            <button type="submit">Guardar Cambios</button>
            <a href="edit_character.php">
                <button type="button">Cancelar</button>
            </a>
        </div>
    </form>
</body>
</html>
