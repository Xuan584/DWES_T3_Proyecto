<?php
require_once "../../config/db.php";
require_once "../../model/Item.php";

// Verificar si se recibió el ID del ítem
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de ítem no proporcionado.");
}

$id = $_GET['id'];

// Obtener los datos del ítem
$item = null;
try {
    $stmt = $db->prepare("SELECT * FROM items WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        die("Ítem no encontrado.");
    }
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}

// Procesar la edición si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $img = $item['img']; // Mantener la URL original de la imagen
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $imgName = basename($_FILES['img']['name']);
            $imgPath = $uploadDir . $imgName;

            if (move_uploaded_file($_FILES['img']['tmp_name'], $imgPath)) {
                $img = $imgPath; // Actualizar la URL de la imagen
            } else {
                echo "Error al subir la imagen.";
            }
        }

        $stmt = $db->prepare("UPDATE items SET name = :name, description = :description, type = :type, effect = :effect WHERE id = :id");
        $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $stmt->bindValue(':type', $_POST['type'], PDO::PARAM_STR);
        $stmt->bindValue(':effect', $_POST['effect'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: edit_item.php");
            exit;
        } else {
            echo "Error al actualizar el ítem.";
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
    <title>Editar Ítem</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Editar Ítem</h1>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nameInput">Nombre:</label>
            <input type="text" name="name" id="nameInput" value="<?= htmlspecialchars($item['name']); ?>" required>
        </div>
        <div>
            <label for="descriptionInput">Descripción:</label>
            <input type="text" name="description" id="descriptionInput" value="<?= htmlspecialchars($item['description']); ?>" required>
        </div>
        <div>
            <label for="typeInput">Tipo:</label>
            <select name="type" id="typeInput" required>
                <option value="weapon" <?= $item['type'] === 'weapon' ? 'selected' : ''; ?>>Weapon</option>
                <option value="armor" <?= $item['type'] === 'armor' ? 'selected' : ''; ?>>Armor</option>
                <option value="potion" <?= $item['type'] === 'potion' ? 'selected' : ''; ?>>Potion</option>
                <option value="misc" <?= $item['type'] === 'misc' ? 'selected' : ''; ?>>Misc</option>
            </select>
        </div>
        <div>
            <label for="effectInput">Efecto (+/-):</label>
            <input type="number" name="effect" id="effectInput" value="<?= $item['effect']; ?>" required>
        </div>
        <div>
            <button type="submit">Guardar Cambios</button>
            <a href="edit_item.php">
                <button type="button">Cancelar</button>
            </a>
        </div>
    </form>
</body>
</html>
