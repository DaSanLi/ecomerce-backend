<?php

require_once './funciones.php';

if($_SERVER["REQUEST_METHOD"] !== "post" ){
    http_response_code(405);
    header("Content-Type: application/json");
    echo json_encode(['error' => 'Método no permitido']);
    exit();
} 

$data = json_decode(file_get_contents("php://input", true));

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

mostrarUsuarios($email, $password);
