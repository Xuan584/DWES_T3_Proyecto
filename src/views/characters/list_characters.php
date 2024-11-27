<?php
require_once "../../config/db.php";
require_once "../../model/Character.php";

$characters = [];

try{
    $stmt=$db->query("SELECT * FROM characters");
    $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e){
    echo "Error al leer la base de datos: " . $e->getMessage();
}
include("../partials/_menu.php") ?>

<h1>Lista de personajes</h1>
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>PV</th>
                    <th>Fuerza</th>
                    <th>Defensa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($characters as $character):?>
                    <tr>
                        <td>img</td>
                        <td><?= $character['name']?></td>
                        <td><?= $character['description']?></td>
                        <td><?= $character['health']?></td>
                        <td><?= $character['strength']?></td>
                        <td><?= $character['defense']?></td>
                        <td>
                        <form action="edit_character_form.php" method="GET">
                            <input type="hidden" name="id" value="<?=$character['id']?>">
                            <button type="submit">Editar</button>
                        </form>
                        <form action="delete_character.php" method="POST">
                            <input type="hidden" name="id" value="<?=$character['id']?>">
                            <button type="submit">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
    </table>

    <div>
        <button><a href="create_character.php">Crear Personajes</a></button>
        <button><a href="delete_character.php">Delete Personajes</a></button>
        <button><a href="edit_character.php">Editar Personajes</a></button> 
    </div>