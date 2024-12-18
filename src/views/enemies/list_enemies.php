<?php
require_once "../../config/db.php";

// Obtener enemigos
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
    <title>Lista de Enemigos</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Lista de Enemigos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>¿Es jefe?</th>
                <th>Vida</th>
                <th>Fuerza</th>
                <th>Defensa</th>
                <th>Acciones</th>
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
                        <a href="edit_enemy.php?id=<?= $enemy['id']; ?>">Editar</a>
                        <a href="delete_enemy.php?id=<?= $enemy['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <a href="create_enemy.php">Crear Enemigo</a>
    </div>
</body>
</html>
