# Backend en php de la aplicacion
## Instalacion
Para instalar actualmente solo se puede mover los archivos adentro de tu servidor `apache`
Se deben que mover al siguiente directorio
```sh
copy [gitfolder]/php [xmapp||apache]/htdocs/AppVue
```
Por ultimo hay que ejecutar dos aplicaciones _no importan los puertos_
`SQL || phpMyAdmin`
`Apache`

Seria necesario usar un SQL con los siguientes datos
```sql
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `credenciales` (
  `id_credencial` int(11) NOT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `credenciales_negocios` (
  `id_credencial_negocio` int(11) NOT NULL,
  `email_negocio` text DEFAULT NULL,
  `password_negocio` text DEFAULT NULL,
  `id_negocio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nombre_producto` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `categoria` text DEFAULT NULL,
  `id_negocio` int(11) DEFAULT NULL,
  `imagen` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `negocios` (
  `id_negocio` int(11) NOT NULL,
  `nombre_dueño` text DEFAULT NULL,
  `nombre_negocio` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `rfc` text DEFAULT NULL
  `imagen` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

ALTER TABLE `credenciales`
  ADD PRIMARY KEY (`id_credencial`),
  ADD KEY `id_cliente` (`id_cliente`);

ALTER TABLE `credenciales_negocios`
  ADD PRIMARY KEY (`id_credencial_negocio`),
  ADD KEY `id_negocio` (`id_negocio`);

ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_negocio` (`id_negocio`);

ALTER TABLE `negocios`
  ADD PRIMARY KEY (`id_negocio`);

ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `credenciales`
  MODIFY `id_credencial` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `credenciales_negocios`
  MODIFY `id_credencial_negocio` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `negocios`
  MODIFY `id_negocio` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `credenciales`
  ADD CONSTRAINT `credenciales_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

ALTER TABLE `credenciales_negocios`
  ADD CONSTRAINT `credenciales_negocios_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`);

ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`);
COMMIT;

```