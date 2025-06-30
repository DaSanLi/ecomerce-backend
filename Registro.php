<?php 

require_once './funciones.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    exit(0); // Solo responde, no continúa
}

if($_SERVER["REQUEST_METHOD"] !== "POST" ){
    http_response_code(405);
    header("Content-Type: application/json");
    echo json_encode(['error' => 'Metodo no permitido']);
    exit();
} 

$data = json_decode(file_get_contents("php://input", true));

$email = $data->emailR ?? null;
$password = $data->passwordR ?? null;
$nick = $data->nick ?? null;


crearCliente($email, $password, $nick);//colocar en orden: email, contraseña, alias

?>