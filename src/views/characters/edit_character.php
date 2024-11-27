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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personajes</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Editar Personajes</h1>
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
                        <form action="edit_character_form.php" method="GET">
                            <input type="hidden" name="id" value="<?= $character['id']; ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="create_character.php">Crear Personajes</a></button>
        <button><a href="delete_character.php">Borrar Personajes</a></button>
        <button><a href="edit_character.php">Editar Personajes</a></button>
    </div>
</body>
</html>
