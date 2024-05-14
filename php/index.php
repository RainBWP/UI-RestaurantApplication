<?php
require_once('cors.php');
require_once('conexion.php');
require_once('api.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == "POST") {
    $json = null;
    $data = json_decode(file_get_contents("php://input"), true);
    $api = new Api();
    if($data['tipo'] == "Cliente") {
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $contrasena = $data['contrasena'];
        $json = $api->insertCliente($nombre, $correo, $contrasena);
    }
    else if ($data['tipo'] == "Negocio") {
        $nombreD = $data['nombre_propietario'];
        $nombreN = $data['nombre_negicio'];
        $direccion = $data['direccion'];
        $rfc = $data['rfc'];
        $correoN = $data['correo'];
        $contrasenaN = $data['contrasena'];
        $json = $api->insertNegocio($nombreD, $nombreN, $direccion, $rfc, $correoN, $contrasenaN);
    }
    else if ($data['tipo'] == "Producto") {
        $nombreP = $data['producto_nombre'];
        $descripcion = $data['producto_descripcion'];
        $precio = $data['producto_precio'];
        $categoria = $data['producto_categoria'];
        $id_negocio = $data['id_negocio'];
        $imagen = $data['producto_imagen'];
        $json = $api->insertProducto($nombreP, $descripcion, $precio, $categoria, $id_negocio, $imagen);
    }
    else if ($data['tipo'] == "Login") {
        $usuario = $data['usuario'];
        $email = $data['email'];
        $password = $data['password'];
        $json = $api->inicioSesion($usuario, $email, $password);
    }else if ($data['tipo'] == "NombreCliente") {
        $email = $data['email_cliente'];
        $tipoUsuario = $data['usuario_handle'];
        $json = $api->getClienteName($email, $tipoUsuario);
    }else if ($data['tipo'] == "MenuNegocio") {
        $id_negocio = $data['id_negocio'];
        $json = $api->getMenu($id_negocio);
    } else {
        echo "Tipo de usuario indefinido";
    }
    echo $json;
}
// Obtener productos de la tabla Menu
else if($method == "GET") {
    $vector = array();
    $api = new Api();
    $vector = $api->getAllRestaurants();
    $json = json_encode($vector);
    echo $json;
}
// Eliminar productos de la tabla Menu
else if($method == "DELETE") {
    $json = null;
    $id_producto = $_REQUEST['producto_id'];
    $api = new Api();
    $json = $api->deleteProducto($id_producto);
    echo $json;
}
else {
    echo "Metodo indefinido";
}
?>