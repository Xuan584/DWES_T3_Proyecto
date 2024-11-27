<?php
require_once "../../config/db.php";
require_once "../../model/Enemy.php";

$enemies = [];

try {
    $stmt = $db->query("SELECT * FROM enemies");
    $enemies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
}

include("../partials/_menu.php");
?>

<h1>Lista de enemigos</h1>
<table>
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>¿Es jefe?</th>
            <th>PV</th>
            <th>Fuerza</th>
            <th>Defensa</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($enemies as $enemy): ?>
            <tr>
                <td>img</td> <!-- Puedes ajustar este campo para mostrar una imagen real -->
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
                    <form action="delete_enemy.php" method="POST">
                        <input type="hidden" name="id" value="<?= $enemy['id']; ?>">
                        <button type="submit">Borrar</button>
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
