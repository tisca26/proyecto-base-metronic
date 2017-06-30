CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuarios_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `nombre` VARCHAR(100) NULL,
  `apellido_paterno` VARCHAR(100) NULL,
  `apellido_materno` VARCHAR(100) NULL,
  `email` VARCHAR(150) NULL,
  `passwd` VARCHAR(70) NULL,
  `estatus` INT(1) NOT NULL DEFAULT 1,
  `creacion` DATETIME DEFAULT   CURRENT_TIMESTAMP,
  `edicion` DATETIME ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuarios_id`),
  INDEX `usuarios_username_idx` (`username` ASC),
  INDEX `usuarios_estatus_idx` (`estatus` ASC))
ENGINE = InnoDB;

-- Bianconeri26!
INSERT INTO `usuarios` (`usuarios_id`, `username`, `nombre`, `apellido_paterno`, `apellido_materno`, `email`, `passwd`, `estatus`) VALUES
(1, 'tisca26', 'Gerardo Gabriel', 'Tiscareño', 'Gutiérrez', 'gerry.t26@gmail.com', '$2y$10$XQy2VIM.tJuZ3/3wxoLUtOduMWzPsFmopgR2g2c7bHeVBwQRPry4e', 1);

-- ----------------------------------------------------------

CREATE TABLE IF NOT EXISTS `resources` (
  `resources_id` INT NOT NULL AUTO_INCREMENT,
  `resource` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`resources_id`))
ENGINE = InnoDB;

--
-- Volcado de datos para la tabla `resources`
--

INSERT INTO `resources` (`resources_id`, `resource`) VALUES
(1, 'resources'),
(2, 'users'),
(3, 'groups'),
(4, 'acl'),
(5, 'dashboard'),
(6, 'menu');

-- ----------------------------------------------------------

CREATE TABLE IF NOT EXISTS `accesscontrollist` (
  `TARGETID` INT NOT NULL,
  `TYPEID` INT NOT NULL,
  `RESOURCEID` INT NOT NULL,
  `R` INT NULL,
  `I` INT NULL,
  `U` INT NULL,
  `D` INT NULL,
  INDEX `acl_targetid_idx` (`TARGETID` ASC),
  INDEX `acl_typeid_idx` (`TYPEID` ASC),
  INDEX `acl_resourceid_idx` (`RESOURCEID` ASC))
ENGINE = InnoDB;

--
-- Volcado de datos para la tabla `accesscontrollist`
--

INSERT INTO `accesscontrollist` (`TARGETID`, `TYPEID`, `RESOURCEID`, `R`, `I`, `U`, `D`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(1, 1, 2, 1, 1, 1, 1),
(1, 1, 3, 1, 1, 1, 1),
(1, 1, 4, 1, 1, 1, 1),
(1, 1, 5, 1, 1, 1, 1),
(1, 1, 6, 1, 1, 1, 1);

CREATE TABLE IF NOT EXISTS `groups` (
  `groups_id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(70) NOT NULL,
  `estatus` INT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`groups_id`),
  INDEX `groups_estatus_idx` (`estatus` ASC))
ENGINE = InnoDB;

INSERT INTO `groups` (`groups_id`, `nombre`, `estatus`) VALUES
(1, 'Administrador', 1);

CREATE TABLE IF NOT EXISTS `usersgroups` (
  `usuarios_id` INT NOT NULL DEFAULT 0,
  `groups_id` INT NOT NULL DEFAULT 0,
  INDEX `usersgroups_user_idx` (`usuarios_id` ASC),
  INDEX `usergroups_group_idx` (`groups_id` ASC))
ENGINE = InnoDB;

INSERT INTO `usersgroups` (`usuarios_id`, `groups_id`) VALUES (1, 1);


CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NULL,
  `shortdesc` VARCHAR(255) NULL,
  `page_uri` VARCHAR(60) NULL,
  `estatus` INT(1) NOT NULL DEFAULT 1,
  `parent_id` INT NULL,
  `orden` INT NOT NULL DEFAULT 1,
  `resource_id` INT NULL,
  `icon` VARCHAR(45) NULL,
  PRIMARY KEY (`menu_id`),
  INDEX `menu_parentid_idx` (`parent_id` ASC),
  INDEX `menu_estatus_idx` (`estatus` ASC),
  INDEX `menu_orden_idx` (`orden` ASC),
  INDEX `menu_recurso_idx` (`resource_id` ASC))
ENGINE = InnoDB;

INSERT INTO `menu` 
(`menu_id`, `nombre`, `shortdesc`, `page_uri`, `estatus`, `parent_id`, `orden`, `resource_id`) VALUES
(1, 'Administración', 'Administración', '', 1, 0, 0, NULL),
(2, 'Seguridad', 'Seguridad', 'resources/', 1, 1, 0, 1),
(3, 'Menú', 'Menú', 'menu/', 1, 1, 1, 6),
(4, 'Recursos', 'Recursos', 'resources/', 1, 2, 0, 1),
(5, 'Usuarios', 'Usuarios', 'users/', 1, 2, 1, 2),
(6, 'Grupos', 'Grupos', 'groups/', 1, 2, 2, 3);


CREATE OR REPLACE VIEW v_usuarios_activos AS 
SELECT u.*, GROUP_CONCAT(g.nombre ORDER BY g.nombre SEPARATOR ', ') as grupos, GROUP_CONCAT(g.groups_id ORDER BY g.groups_id SEPARATOR ', ') as grupos_id
FROM usuarios u
INNER JOIN usersgroups ug on u.usuarios_id = ug.usuarios_id
INNER JOIN groups g ON ug.groups_id = g.groups_id
WHERE u.estatus = 1 AND g.estatus = 1
GROUP BY u.usuarios_id;

CREATE OR REPLACE VIEW v_usuarios AS 
SELECT u.*, GROUP_CONCAT(g.nombre ORDER BY g.nombre SEPARATOR ', ') as grupos, GROUP_CONCAT(g.groups_id ORDER BY g.groups_id SEPARATOR ', ') as grupos_id
FROM usuarios u
INNER JOIN usersgroups ug on u.usuarios_id = ug.usuarios_id
INNER JOIN groups g ON ug.groups_id = g.groups_id
GROUP BY u.usuarios_id;


