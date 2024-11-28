<?php
require_once "../../config/db.php";
require_once "../../model/Item.php";

$items = [];

// Consultar los ítems existentes
try {
    $stmt = $db->query("SELECT * FROM items");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
}

// Guardar un nuevo ítem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear el ítem
    $item = new Item($db);
    $item->setName($_POST['name']);
    $item->setDescription($_POST['description']);
    $item->setType($_POST['type']);
    $item->setEffect($_POST['effect']);

    if ($item->save()) {
        header("Location: create_item.php");
    } else {
        echo "<p>Error al crear el ítem.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea tu ítem</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Crea tu ítem</h1>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nameInput">Nombre:</label>
            <input type="text" name="name" id="nameInput" required>
        </div>

        <div>
            <label for="descriptionInput">Descripción:</label>
            <input type="text" name="description" id="descriptionInput"></input>
        </div>

        <div>
            <label for="typeInput">Tipo:</label>
            <select name="type" id="typeInput" required>
                <option value="weapon">Weapon</option>
                <option value="armor">Armor</option>
                <option value="potion">Potion</option>
                <option value="misc">Misc</option>
            </select>
        </div>

        <div>
            <label for="effectInput">Efecto (+/-):</label>
            <input type="number" name="effect" id="effectInput" value="0" required>
        </div>

        <button type="submit">Crear ítem</button>
    </form>

    <h1>Lista de ítems</h1>
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
                        <a href="edit_item.php?id=<?= $item['id']; ?>">Editar</a>
                        <a href="delete_item.php?id=<?= $item['id']; ?>" onclick="return confirm('¿Estás seguro de borrar este ítem?');">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="edit_item.php">Editar Ítems</a></button>
        <button><a href="delete_item.php">Borrar Ítems</a></button>
        <button><a href="list_items.php">Lista de Ítems</a></button> 
    </div>
</body>
</html>
