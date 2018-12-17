-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 17-12-2018 a las 13:24:27
-- Versión del servidor: 5.7.21
-- Versión de PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `daxgallery`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

DROP TABLE IF EXISTS `imagen`;
CREATE TABLE IF NOT EXISTS `imagen` (
  `imageId` int(11) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(256) NOT NULL,
  `descripcion` varchar(1024) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `dislikes` int(11) NOT NULL DEFAULT '0',
  `publicada` tinyint(1) NOT NULL DEFAULT '0',
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`imageId`),
  KEY `usuario` (`usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`imageId`, `ruta`, `descripcion`, `likes`, `dislikes`, `publicada`, `usuario`) VALUES
(59, 'images/23/4100888-drift-wallpaper.jpeg', 'YRRYRTYRT', 9, 6, 1, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `pass` varchar(256) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`userId`, `nombre`, `email`, `pass`) VALUES
(25, 'Carlos MartÃ­n Ruiz', 'crlsmartnruiz@gmail.com8798', '$2y$11$1.mJeGUonxj.2LBfS4Xacu8JxscgOMAmGXUHZ140Mq708NC.bFSFG'),
(23, 'AndrÃ©s PÃ©rez', 'andres@correo.com', '$2y$11$mbv/V8jgJakWw10McHCtBOImVLo0.HuSy87jZW//FW5QUx/0sfr66'),
(24, 'Carlos MartÃ­n Ruiz', 'crlsmartnruiz@gmail.com', '$2y$11$u6P2ujjlY0/axajKuwbaE.JLWt/ODqR/doDLoEFq9ZLSU/DQVLf8u'),
(26, 'Carlos MartÃ­n Ruiz', 'crlsmartnruiz@gmail.comfsf', '$2y$11$5RXgRLtuRMYdyBPvUIDZrew2iVbpgJecrnWvaId5D/wR3GW73Z5lK');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
