<?php

// Configuración de la base de datos
$host = 'db';
$dbname = 'dwes_t3_rpg_clase';
$username = 'user';
$password = 'userpassword';

// Crear nueva instancia de PDO para conectar a la base de datos
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión realizada";

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
