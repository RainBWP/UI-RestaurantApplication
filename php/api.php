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

    public function insertNegocio($nombreD, $nombreN, $direccion, $rfc, $correoN, $contrasenaN) {
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        $stmt = $db->prepare("INSERT INTO negocios (nombre_dueño, nombre_negocio, direccion, rfc) VALUES (:nombreD, :nombreN, :direccion, :rfc)");
        $stmt->bindParam(':nombreD', $nombreD);
        $stmt->bindParam(':nombreN', $nombreN);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':rfc', $rfc);
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

    public function getMenu() {
        $menu = array();
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        // Consulta SQL para obtener los datos del menú
        $sql = "SELECT id_menu, nombre_producto, descripcion, precio, categoria, imagen FROM menu";
        $consulta = $db->prepare($sql);
        $consulta->execute();

        // Verificar si hay resultados
        if ($consulta->rowCount() > 0) {
            // Recorrer los resultados y agregarlos al array
            while($fila = $consulta->fetch()) {
                $menu[] = array(
                    "id_menu" => $fila['id_menu'],
                    "nombre_producto" => $fila['nombre_producto'],
                    "descripcion" => $fila['descripcion'],
                    "precio" => $fila['precio'],
                    "categoria" => $fila['categoria'],
                    "imagen" => $fila['imagen']
                );
            }
        }

        // Devolver el array
        return $menu;
    }

    public function getClienteName($email_cliente,$usuario_handle) {
        $conexion = new Conexion();
        $db = $conexion->getConexion();

        // Obtener el ID del cliente o negocio
        if ($usuario_handle == 'Cliente') {
            $stmt = $db->prepare("SELECT id FROM credenciales WHERE email = ?");
        } else if ($usuario_handle == 'Vendedor') {
            $stmt = $db->prepare("SELECT id FROM credenciales_negocios WHERE email_negocio = ?");
        } else {
            return 'No User';
        }
        console.log($stmt);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

            // Obtener el nombre del cliente o negocio
            if ($usuario_handle == 'Cliente') {
                $stmt = $db->prepare("SELECT nombre FROM clientes WHERE id = ?");
            } else if ($usuario_handle == 'Vendedor') {
                $stmt = $db->prepare("SELECT nombre FROM negocios WHERE id = ?");
            }

            $stmt->bindParam(1, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC)['nombre'];
            } else {
                return 'Nombre no encontrado';
            }
        } else {
            return 'ID no encontrado';
        }
    }

}
?>