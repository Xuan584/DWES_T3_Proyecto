<?php

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'dwes_proyecto_t3';
$username = 'root';
$password = '';

// Crear nueva instancia de PDO para conectar a la base de datos

try{
    $db = new PDO("mysql:host = $host;dbname = $dbname;charset = utf8",
                $username,
                $password);

    $db->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
    echo "Conexión realizada";
    
} catch (PDOException){
    echo "Error de conexión: " . $e->getMessage();
    exit;
};
