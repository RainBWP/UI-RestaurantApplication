<?php
class Api {

    // manejar solicitudes de API POST

    public function insertCliente($nombre, $correo, $contrasena) {
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        $stmt = $db->prepare("INSERT INTO clientes (nombre) VALUES (:nombre)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();

        // Verificar si la inserción fue exitosa
        if ($stmt->rowCount() > 0) {
            // Obtener el ID del cliente recién insertado
            $id_cliente = $db->lastInsertId();

            // Insertar correo y contraseña en la tabla 'credenciales' junto con el ID del cliente
            $stmt_credenciales = $db->prepare("INSERT INTO credenciales (email, password, id_cliente) VALUES (:correo, :contrasena, :id_cliente)");
            $stmt_credenciales->bindParam(':correo', $correo);
            $stmt_credenciales->bindParam(':contrasena', $contrasena);
            $stmt_credenciales->bindParam(':id_cliente', $id_cliente);
            $stmt_credenciales->execute();

            // Verificar si la inserción de credenciales fue exitosa
            if ($stmt_credenciales->rowCount() > 0) {
                return 'success';
            } else {
                return 'Error al insertar credenciales: ' . implode(", ", $stmt_credenciales->errorInfo());
            }
        } else {
            return 'Error al insertar cliente: ' . implode(", ", $stmt->errorInfo());
        }
    }

    public function insertNegocio($nombreD, $nombreN, $direccion, $rfc, $correoN, $contrasenaN, $imagenN) {
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        $stmt = $db->prepare("INSERT INTO negocios (nombre_dueño, nombre_negocio, direccion, rfc, imagen) VALUES (:nombreD, :nombreN, :direccion, :rfc, :imagenN)");
        $stmt->bindParam(':nombreD', $nombreD);
        $stmt->bindParam(':nombreN', $nombreN);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':rfc', $rfc);
        $stmt->bindParam(':imagenN', $imagenN);
        $stmt->execute();

        // Verificar si la inserción fue exitosa
        if ($stmt->rowCount() > 0) {
            // Obtener el ID del negocio recién insertado
            $id_negocio = $db->lastInsertId();

            // Insertar correo y contraseña en la tabla 'credenciales_negocios' junto con el ID del negocio
            $stmt_credenciales = $db->prepare("INSERT INTO credenciales_negocios (email_negocio, password_negocio, id_negocio) VALUES (:correoN, :contrasenaN, :id_negocio)");
            $stmt_credenciales->bindParam(':correoN', $correoN);
            $stmt_credenciales->bindParam(':contrasenaN', $contrasenaN);
            $stmt_credenciales->bindParam(':id_negocio', $id_negocio);
            $stmt_credenciales->execute();

            // Verificar si la inserción de credenciales fue exitosa
            if ($stmt_credenciales->rowCount() > 0) {
                return 'success';
            } else {
                return 'Error al insertar credenciales: ' . implode(", ", $stmt_credenciales->errorInfo());
            }
        } else {
            return 'Error al insertar negocio: ' . implode(", ", $stmt->errorInfo());
        }
    }

    public function insertProducto($nombreP, $descripcion, $precio, $categoria, $id_negocio, $imagen) {
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        $stmt = $db->prepare("INSERT INTO menu (nombre_producto, descripcion, precio, categoria, id_negocio, imagen) VALUES (:nombreP, :descripcion, :precio, :categoria, :id_negocio, :imagen)");
        $stmt->bindParam(':nombreP', $nombreP);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':id_negocio', $id_negocio);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->execute();

        // Verificar si la inserción fue exitosa
        if ($stmt->rowCount() > 0) {
            return 'success';
        } else {
            return 'Error al insertar producto: ' . implode(", ", $stmt->errorInfo());
        }
    }

    public function inicioSesion($usuario, $email, $password) {
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        if ($usuario == 'Cliente') {
            $stmt = $db->prepare("SELECT * FROM credenciales WHERE email = ? AND password = ?");
        }
        else if ($usuario == 'Vendedor') {
            $stmt = $db->prepare("SELECT * FROM credenciales_negocios WHERE email_negocio = ? AND password_negocio = ?");
        }
        else {
            return 'Error, usuario indefinido';
        }
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $password);
        $stmt->execute();

        // Verificar si las credenciales son válidas
        if ($stmt->rowCount() > 0) {
            return 'success';
        } else {
            return 'Credenciales inválidas: ' . implode(", ", $stmt->errorInfo());
        }
    }

    public function getMenu($id_negocio) {
        $menu = array();
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        // Consulta SQL para obtener los datos del menú
        $sql = "SELECT id_menu, nombre_producto, descripcion, precio, categoria, imagen, id_negocio FROM menu WHERE id_negocio = :id_negocio";
        $consulta = $db->prepare($sql);
        $consulta->bindParam(':id_negocio', $id_negocio);
        $consulta->execute();

        // Verificar si hay resultados
        if ($consulta->rowCount() > 0) {
            // Recorrer los resultados y agregarlos al array
            while($fila = $consulta->fetch()) {
                $nombre_negocio = $this->getNombreNegocio($fila['id_negocio']); // Obtener el nombre del negocio
                $menu[] = array(
                    "id_menu" => $fila['id_menu'],
                    "nombre" => $fila['nombre_producto'],
                    "descripcion" => $fila['descripcion'],
                    "precio" => $fila['precio'],
                    "categoria" => $fila['categoria'],
                    "imagen" => $fila['imagen']
                );
            }
        }
        // Devolver el array
        return array('nombreRestaurante' => $nombre_negocio,
                'menu' => $menu); ;
    }

    private function getNombreNegocio($id_negocio) {
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        $stmt = $db->prepare("SELECT nombre_negocio FROM negocios WHERE id_negocio = :id_negocio");
        $stmt->bindParam(':id_negocio', $id_negocio);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC)['nombre_negocio'];
        } else {
            return '';
        }
    }
    public function getClienteName($email_cliente,$usuario_handle) {
        $conexion = new Conexion();
        $db = $conexion->getConexion();
    
        // Obtener el ID del cliente o negocio
        if ($usuario_handle == 'Cliente') {
            $stmt = $db->prepare("SELECT id_cliente FROM credenciales WHERE email = ?");
        } else if ($usuario_handle == 'Vendedor') {
            $stmt = $db->prepare("SELECT id_negocio FROM credenciales_negocios WHERE email_negocio = ?");
        } else {
            return 'none';
        }
        $stmt->bindParam(1, $email_cliente);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            //$id = $stmt->fetch(PDO::FETCH_ASSOC)['id_cliente'];
    
            // Obtener el nombre del cliente o negocio
            if ($usuario_handle == 'Cliente') {
                $id = $stmt->fetch(PDO::FETCH_ASSOC)['id_cliente'];
                $stmt = $db->prepare("SELECT nombre FROM clientes WHERE id_cliente = ?");
            } else if ($usuario_handle == 'Vendedor') {
                $id = $stmt->fetch(PDO::FETCH_ASSOC)['id_negocio'];
                $stmt = $db->prepare("SELECT nombre_dueño FROM negocios WHERE id_negocio = ?");
            }
    
            $stmt->bindParam(1, $id);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                if ($usuario_handle == 'Cliente') {
                    return $stmt->fetch(PDO::FETCH_ASSOC)['nombre'];
                } else {
                    return $stmt->fetch(PDO::FETCH_ASSOC)['nombre_dueño'];
                }
            } else {
                return 'none';
            }
        } else {
            return 'none';
        }
    }

    public function getAllRestaurants() {
        $restaurantes = array();
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        $sql = "SELECT id_negocio, nombre_negocio, direccion, imagen FROM negocios";
        $consulta = $db->prepare($sql);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            while($fila = $consulta->fetch()) {
                $restaurantes[] = array(
                    "restaurant_id" => $fila['id_negocio'],
                    "restaurant_name" => $fila['nombre_negocio'],
                    "direccion" => $fila['direccion'],
                    "restaurant_logo" => $fila['imagen'],
                    "get_restaurant" => ""
                );
            }
        }

        return $restaurantes;
    }

}
?>