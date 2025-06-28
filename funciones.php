<?php 

require_once 'conexion.php';

//ESTA FUNCION SOLO SE UTILIZA CON POST
function crearCliente($email, $password, $nick){
    try{
        if($email === null || $password === null || $nick === null){
            http_response_code(500);
            echo json_encode([
                'success'=>false,
                'mensaje'=>'faltan datos obligatorios',
                'email' => $email,
                'password' => $password,
                'nick' => $nick
            ]);
            exit;
        }
        global $conn; //conexion con la base de datos, definida en el fichero conexion.php
        $query = $conn->prepare("INSERT INTO clientes (email, password, nick) values (?, ?, ?)");

        if(!$query){
            die("ha ocurrido un error en la creación de un nuevo usuario" . $conn->error);
        }

        //vincular parametros
        $query->bind_param("sss", $email, $password, $nick);

        if($query->execute()){
            echo json_encode([
                'success'=>true,
                'mensaje'=>'se ha creado un nuevo usuario satisfactoriamente'
            ]);
            http_response_code(201);
        }else{
            echo json_encode([
                'success'=>false,
                'mensaje'=>'ha ocurrido un problema al crear el nuevo usuario, vuelve a intentarlo'
            ]);
            http_response_code(500);
            exit();
        }
    }catch(Exception $e){
            echo json_encode([
                'success'=>false,
                'mensaje'=>'ha ocurrido un problema al crear el nuevo usuario, vuelve a intentarlo'
            ]);
            http_response_code(500);
            exit();
    }
}

//FUNCION PARA USAR SOLO CON GET
function mostrarUsuarios($email, $password){

    if($email === null || $password === null){
        http_response_code(400);
        json_encode([
            'success'=>false,
            'mensaje'=>'faltan datos obligatorios'
        ]);
        exit;
    }

    try{
        global $conn; //conexion con la base de datos, definida en el fichero conexion.php
        $query = $conn->prepare("SELECT password from clientes where email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if(!$result){
            http_response_code(500);
            echo json_encode([
                'success'=>false,
                'mensaje'=>'ha ocurrido un problema al consultar las credenciales'
            ]);
            exit();
        }

        if($row = $result->fetch_assoc()){
            $passwordBD = $row['password'];
            $nick = $row['nick'];
            if($passwordBD === $password){
            http_response_code(200);
            echo json_encode([
                'success'=>true,
                'mensaje'=>'el proceso se ha completado satisfactoriamente',
                'bienvenida'=>'bienvenido ' . $nick
            ]);
            }
        }



    }catch(Exception $E){
        http_response_code(500);
        echo json_encode([
                'success'=> false,
                'mensaje'=>'ha ocurrido un error al consultar los clientes',
                'error: ' => $E
        ]);
    }

}



?>