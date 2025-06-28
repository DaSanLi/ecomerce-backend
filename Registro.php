<?php 

//require './conexion.php';
require_once './funciones.php';

if($_SERVER["REQUEST_METHOD"] !== "POST" ){
    http_response_code(405);
    header("Content-Type: application/json");
    echo json_encode(['error' => 'Método no permitido']);
    exit();
} 

$data = json_decode(file_get_contents("php://input", true));

$email = $data->email ?? null;
$password = $data->password ?? null;
$nick = $data->nick ?? null;


crearCliente($email, $password, $nick);//colocar en orden: email, contraseña, alias

?>