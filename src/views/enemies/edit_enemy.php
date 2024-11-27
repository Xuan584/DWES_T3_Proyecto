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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Enemigos</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Editar Enemigos</h1>
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
                        <form action="edit_enemy_form.php" method="GET">
                            <input type="hidden" name="id" value="<?= $enemy['id']; ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="create_enemy.php">Crear Enemigos</a></button>
        <button><a href="delete_enemy.php">Borrar Enemigos</a></button>
        <button><a href="edit_enemy.php">Editar Enemigos</a></button>
    </div>
</body>
</html>
