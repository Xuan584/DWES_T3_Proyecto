<?php
require_once("../config/db.php");
require_once("../model/Character.php");
 
 
if($_SERVER['REQUEST_METHOD']=='POST'){
    $character=new Character($db);
    $character->setName($_POST['name'])
                ->setDescription($_POST['descripcion'])
                ->setHealth($_POST['health'])
                ->setStrength($_POST['strength'])
                ->setDefense($_POST['defense']);

    
    if($character->save()){
        echo "Se ha guardado el personaje";
    } else{
        echo "No se ha guardado el personaje";
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea tu personaje</title>
</head>
<body>
    <h1>Crea tu personaje</h1>
    <form action="save_character.php" method="post">
        <div>
            <label for="nameInput">Name:</label>
            <input name="name" type="text" id="nameInput">
        </div>

        <div>
            <label for="descriptionInput">Descripción:</label>
            <input type="text" name="description" id="descriptionInput">
        </div>

        <div>
            <label for="healthInput">Puntos de vida:</label>
            <input type="number" name="health" value="100" min="1"id="healthInput">
        </div>

        <div>
            <label for="strenghtInput">Fuerza:</label>
            <input type="number" name="strenght" value="10" min="1"id="strenghtInput">
        </div>

        <div>
            <label for="defensaInput">Defensa:</label>
            <input type="number" name="defensa" value="10" min="1"id="defensaInput">
        </div>

        <button type="submit"> Crear personaje</button>
    </form>
    
</body>
</html>