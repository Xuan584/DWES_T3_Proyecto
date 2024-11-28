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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ítems</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Editar Ítems</h1>
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
                        <form action="edit_item_form.php" method="GET">
                            <input type="hidden" name="id" value="<?= $item['id']; ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="create_item.php">Crear Ítems</a></button>
        <button><a href="delete_item.php">Borrar Ítems</a></button>
    </div>
</body>
</html>
