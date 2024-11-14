<?php
require_once("./config/db.php");
require_once("./model/Character.php");
 
 
if($_SERVER['REQUEST_METHOD']=='POST'){
        $character=new Character();
        $character->setName($_POST['name'])
                    ->setDescription($_POST['descripcion']);
 
        $stmt=$db->prepare("INSERT INTO characters(name,description) VALUES (:name,:description)");
        $stmt->bindValue(':name',$character->getName());
        $stmt->bindValue(':description', $character->getDescription());
 
        if($stmt->execute()){
            echo "Se ha guardado el personaje";
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
        <label for="nameInput">Name:</label>
        <input name="name" type="text" id="nameInput">
        <label for="descriptionInput">Descripción:</label>
        <input type="text" name="description" id="descriptionInput">
        <input type="submit" value="Crear un personaje">
       
 
    </form>
    <!--
    Atributos de <input>
    name="name": se usara en el servidor para capturar el valor ingresado
    ($_POST['name'])
    id= "nameInput":permite asociar el campo con el valor ingresado tambien permite selecionarlo en javascript o CSS
 
-->
</body>
</html>