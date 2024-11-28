<?php
require_once "../../config/db.php";
require_once "../../model/Character.php";

$characters = [];

// Consultar los personajes existentes
try {
    $stmt = $db->query("SELECT * FROM characters");
    $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
}

// Guardar un nuevo personaje
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $character = new Character($db);
    $character->setName($_POST['name'])
              ->setDescription($_POST['description'])
              ->setHealth($_POST['health'])
              ->setStrength($_POST['strength'])
              ->setDefense($_POST['defense']);

    if ($character->save()) {
        header("Location: create_character.php");
    } else {
        echo "<p>Error al crear el personaje.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea tu personaje</title>
</head>
<body>
    <?php include("../partials/_menu.php"); ?>

    <h1>Crea tu personaje</h1>
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
        
        <button type="submit">Crear personaje</button>
    </form>

    <h1>Lista de personajes</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Vida</th>
                <th>Fuerza</th>
                <th>Defensa</th>
                <th>Acciones</th>
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
                        <a href="edit_character_form.php?id=<?= $character['id']; ?>">Editar</a>
                        <a href="delete_character.php">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button><a href="edit_character.php">Editar Personajes</a></button>
        <button><a href="delete_character.php">Borrar Personajes</a></button>
        <button><a href="list_characters.php">Editar Personajes</a></button> 
    </div>
</body>
</html>
