<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CORS y tipo de respuesta
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

//creo la ruta con las credenciales
$configJson = file_get_contents(__DIR__ . '/config.json');
$db = json_decode($configJson);

//se establece la conexion
$conn = new mysqli(
        $db -> host,
        $db -> username,
        $db -> password,
        $db -> dbName
);

if($conn->connect_error){
    http_response_code(500);
    echo json_encode([
        'success'=> false,
        'mensaje'=>'ha ocurrido un problema al conectarse a la base de datos'
    ]);
    die ("la conexion no ha podido establecerse" . $conn->connect_error);
}

http_response_code(200); 


