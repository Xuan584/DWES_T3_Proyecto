<?php

require_once("../config/db.php");

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(!isset($_POST['id']) || empty($_POST['id'])){
        die("No se ha recibido el id");
    }
    try{
        $stmt = $db->prepare("DELETE FROM characters WHERE id = :id");
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        if($stmt->execute()){
            header("Location: ../views/create_character.php");
            exit;
        }
    } catch(PDOException $e){
        echo "Error al borrar: " . $e->getMessage();
    }

} else{
    die ("Metodo no permitido");
}