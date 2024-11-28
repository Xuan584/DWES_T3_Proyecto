<?php
require_once "../../config/db.php";

// Obtener personajes
$items = [];
try {
    $stmt = $db->query("SELECT * FROM items");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personajes</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Lista de Personajes</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Efecto</th>
                <th>Acciones</th>
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
                        <a href="edit_item_form.php?id=<?= $item['id']; ?>">Editar</a>
                        <a href="delete_item.php">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <a href="create_item.php">Crear Personaje</a>
    </div>
</body>
</html>
