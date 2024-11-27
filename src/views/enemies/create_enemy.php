<?php
require_once "../../config/db.php";
require_once "../../model/Enemy.php";

$enemies = [];

try {
    // Consultar la lista de enemigos
    $stmt = $db->query("SELECT * FROM enemies");
    $enemies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
}

// Guardar un nuevo personaje
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enemy = new Enemy($db);
    $enemy->setName($_POST['name'])
          ->setDescription($_POST['description'])
          ->setHealth($_POST['health'])
          ->setStrength($_POST['strength'])
          ->setDefense($_POST['defense'])
          ->setIsBoss(isset($_POST['isBoss']) ? 1 : 0);

    if ($enemy->save()) {
        header("Location: create_enemy.php");
        exit;
    } else {
        echo "<p>Error al crear el enemigo.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea tu enemigo</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Crea tu Enemigo</h1>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div>
            <label for="nameInput">Nombre:</label>
            <input type="text" name="name" id="nameInput" required>
        </div>
        
        <div>
            <label for="descriptionInput">Descripción:</label>
            <input type="text" name="description" id="descriptionInput" required>
        </div>

        <div>
            <label for="isBossInput">Es un boss:</label>
            <input type="checkbox" name="isBoss" id="isBossInput" value="1">
        </div>

        <div>
            <label for="healthInput">Puntos de Vida:</label>
            <input type="number" name="health" value="100" min="1" id="healthInput" required>
        </div>
        
        <div>
            <label for="strengthInput">Fuerza:</label>
            <input type="number" name="strength" value="10" min="1" id="strengthInput" required>
        </div>
        
        <div>
            <label for="defenseInput">Defensa:</label>
            <input type="number" name="defense" value="10" min="1" id="defenseInput" required>
        </div>
        
        <button type="submit">Crear enemigo</button>
    </form>

    <h1>Lista de enemigos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Es un boss</th>
                <th>PV</th>
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
                        <a href="delete_enemy.php?id=<?= $enemy['id']; ?>" onclick="return confirm('¿Estás seguro de borrar este enemigo?');">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="edit_enemy.php">Editar Enemigos</a></button>
        <button><a href="delete_enemy.php">Borrar Enemigos</a></button>
        <button><a href="list_enemies.php">Listar Enemigos</a></button> 
    </div>
</body>
</html>
