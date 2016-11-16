-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesscontrollist`
--

CREATE TABLE IF NOT EXISTS `accesscontrollist` (
  `TARGETID` int(11) NOT NULL,
  `TYPEID` int(11) NOT NULL,
  `RESOURCEID` int(11) NOT NULL,
  `R` int(11) DEFAULT NULL,
  `I` int(11) DEFAULT NULL,
  `U` int(11) DEFAULT NULL,
  `D` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `accesscontrollist`
--

INSERT INTO `accesscontrollist` (`TARGETID`, `TYPEID`, `RESOURCEID`, `R`, `I`, `U`, `D`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(1, 1, 2, 1, 1, 1, 1),
(1, 1, 3, 1, 1, 1, 1),
(1, 1, 4, 1, 1, 1, 1),
(1, 1, 5, 1, 1, 1, 1),
(1, 1, 6, 1, 1, 1, 1),
(1, 1, 7, 1, 1, 1, 1),
(1, 1, 8, 1, 1, 1, 1),
(1, 1, 9, 1, 1, 1, 1),
(2, 1, 5, 1, 1, 1, 1),
(2, 1, 9, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`ID` int(11) NOT NULL,
  `NAME` varchar(200) NOT NULL,
  `ENABLE` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`ID`, `NAME`, `ENABLE`) VALUES
(1, 'Administrador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `page_uri` varchar(60) NOT NULL,
  `status` varchar(10) NOT NULL,
  `parentid` int(11) NOT NULL,
  `orderr` int(11) NOT NULL,
  `resourceid` int(11) DEFAULT NULL,
  `icon` varchar(59)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `name`, `shortdesc`, `page_uri`, `status`, `parentid`, `orderr`, `resourceid`) VALUES
(1, 'Administración', 'Administración', '', 'active', 0, 0, NULL),
(2, 'Seguridad', 'Seguridad', 'resources/', 'active', 1, 0, 1),
(3, 'Menú', 'Menú', 'menu/', 'active', 1, 1, 6),
(4, 'Recursos', 'Recursos', 'resources/', 'active', 2, 0, 1),
(5, 'Usuarios', 'Usuarios', 'users/', 'active', 2, 1, 2),
(6, 'Grupos', 'Grupos', 'groups/', 'active', 2, 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
`ID` int(11) NOT NULL,
  `RESOURCE` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `resources`
--

INSERT INTO `resources` (`ID`, `RESOURCE`) VALUES
(1, 'resources'),
(2, 'users'),
(3, 'groups'),
(4, 'acl'),
(5, 'welcome'),
(6, 'menu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`ID` int(11) NOT NULL,
  `NICKNAME` varchar(200) NOT NULL,
  `NOMBRE` varchar(200) NOT NULL,
  `APELLIDOS` varchar(200) NOT NULL,
  `EMAIL` varchar(200) NOT NULL,
  `PASSWORD` varchar(500) NOT NULL,
  `ENABLE` int(11) NOT NULL,
  `CREATEDATE` datetime DEFAULT NULL,
  `EDITDATE` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `NICKNAME`, `NOMBRE`, `APELLIDOS`, `EMAIL`, `PASSWORD`, `ENABLE`, `CREATEDATE`, `EDITDATE`) VALUES
(1, 'tisca26', 'Gerardo Gabriel', 'Tiscareño Gutiérrez', 'gerardo.tiscareno@icognitis.com', '$2y$10$sF4CExCSE.E6dLZHppOIb.vXs3qztrMNuPYsu7n02MZuQL3CPxILW', 1, '2016-11-15 00:00:00', '2016-11-15 00:00:00');
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usersgroups`
--

CREATE TABLE IF NOT EXISTS `usersgroups` (
  `USERID` int(11) NOT NULL,
  `GROUPID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usersgroups`
--

INSERT INTO `usersgroups` (`USERID`, `GROUPID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_usuarios`
--
CREATE TABLE IF NOT EXISTS `v_usuarios` (
`usuario` varchar(200)
,`nombre` varchar(200)
,`apellidos` varchar(200)
,`nombregrupo` varchar(200)
,`ID` int(11)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `v_usuarios`
--
DROP TABLE IF EXISTS `v_usuarios`;

CREATE OR REPLACE VIEW `v_usuarios` AS 
select 
`users`.`NICKNAME` AS `usuario`,
`users`.`NOMBRE` AS `nombre`,
`users`.`APELLIDOS` AS `apellidos`,
`groups`.`NAME` AS `nombregrupo`,
`users`.`ID` AS `ID` 
from 
`users` 
inner join `usersgroups` on `users`.`ID` = `usersgroups`.`USERID`
inner join `groups` on `usersgroups`.`GROUPID` = `groups`.`ID`;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesscontrollist`
--
ALTER TABLE `accesscontrollist`
 ADD PRIMARY KEY (`TARGETID`,`TYPEID`,`RESOURCEID`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idmenu_UNIQUE` (`id`);

--
-- Indices de la tabla `resources`
--
ALTER TABLE `resources`
 ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `"ID"_UNIQUE` (`ID`), ADD UNIQUE KEY `NICKNAME_UNIQUE` (`NICKNAME`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `resources`
--
ALTER TABLE `resources`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
