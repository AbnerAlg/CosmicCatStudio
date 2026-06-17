-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 10:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cosmiccatstudio`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id_album` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `foto` longblob NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `album-artista`
--

CREATE TABLE `album-artista` (
  `id_album` int(11) NOT NULL,
  `id_artista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `album-cancion`
--

CREATE TABLE `album-cancion` (
  `id_album` int(11) NOT NULL,
  `id_cancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artista-musica`
--

CREATE TABLE `artista-musica` (
  `id_artista` int(11) NOT NULL,
  `id_musica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artistas`
--

CREATE TABLE `artistas` (
  `idartista` int(11) NOT NULL,
  `correo` varchar(80) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `nombre` varchar(90) NOT NULL,
  `nombre_artistico` varchar(90) NOT NULL,
  `Edad` int(11) NOT NULL,
  `Nacionalidad` int(11) NOT NULL,
  `Genero` int(11) NOT NULL,
  `Avatar` longblob NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carrito`
--

CREATE TABLE `carrito` (
  `id_oyente` int(11) NOT NULL,
  `id_productos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comentario-publicacion`
--

CREATE TABLE `comentario-publicacion` (
  `id_publicacion` int(11) NOT NULL,
  `id_comentario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `texto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comunidad`
--

CREATE TABLE `comunidad` (
  `id_comunidad` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `foto` longblob NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comunidad-publicacion`
--

CREATE TABLE `comunidad-publicacion` (
  `id_comunidad` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `musica`
--

CREATE TABLE `musica` (
  `id_musica` int(11) NOT NULL,
  `archivo` longblob NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `genero` varchar(30) NOT NULL,
  `colaboradores` text NOT NULL,
  `letra` text NOT NULL,
  `foto` longblob NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oyente`
--

CREATE TABLE `oyente` (
  `id_oyente` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contraseña` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `edad` int(11) NOT NULL,
  `nacionalidad` varchar(20) NOT NULL,
  `genero_musical` varchar(30) NOT NULL,
  `avatar` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oyente-comunidad`
--

CREATE TABLE `oyente-comunidad` (
  `id_oyente` int(11) NOT NULL,
  `id_comunidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `id_artista` int(11) NOT NULL,
  `imagen_producto` longblob NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publicacion`
--

CREATE TABLE `publicacion` (
  `id_publicacion` int(11) NOT NULL,
  `texto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id_album`);

--
-- Indexes for table `album-artista`
--
ALTER TABLE `album-artista`
  ADD KEY `relation8` (`id_album`),
  ADD KEY `relation9` (`id_artista`);

--
-- Indexes for table `album-cancion`
--
ALTER TABLE `album-cancion`
  ADD KEY `relation10` (`id_album`),
  ADD KEY `relation11` (`id_cancion`);

--
-- Indexes for table `artista-musica`
--
ALTER TABLE `artista-musica`
  ADD KEY `relation6` (`id_artista`),
  ADD KEY `relation7` (`id_musica`);

--
-- Indexes for table `artistas`
--
ALTER TABLE `artistas`
  ADD PRIMARY KEY (`idartista`),
  ADD UNIQUE KEY `SECONDARY` (`correo`,`nombre_artistico`) USING BTREE;

--
-- Indexes for table `carrito`
--
ALTER TABLE `carrito`
  ADD KEY `relation2` (`id_productos`),
  ADD KEY `relation3` (`id_oyente`);

--
-- Indexes for table `comentario-publicacion`
--
ALTER TABLE `comentario-publicacion`
  ADD KEY `relation12` (`id_publicacion`),
  ADD KEY `relation13` (`id_comentario`);

--
-- Indexes for table `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`);

--
-- Indexes for table `comunidad`
--
ALTER TABLE `comunidad`
  ADD PRIMARY KEY (`id_comunidad`);

--
-- Indexes for table `comunidad-publicacion`
--
ALTER TABLE `comunidad-publicacion`
  ADD KEY `relation14` (`id_comunidad`),
  ADD KEY `relation15` (`id_publicacion`);

--
-- Indexes for table `musica`
--
ALTER TABLE `musica`
  ADD PRIMARY KEY (`id_musica`);

--
-- Indexes for table `oyente`
--
ALTER TABLE `oyente`
  ADD PRIMARY KEY (`id_oyente`),
  ADD UNIQUE KEY `SECONDARY` (`correo`);

--
-- Indexes for table `oyente-comunidad`
--
ALTER TABLE `oyente-comunidad`
  ADD KEY `relation4` (`id_oyente`),
  ADD KEY `relation5` (`id_comunidad`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `relation` (`id_artista`);

--
-- Indexes for table `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id_publicacion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id_album` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artistas`
--
ALTER TABLE `artistas`
  MODIFY `idartista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comunidad`
--
ALTER TABLE `comunidad`
  MODIFY `id_comunidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `musica`
--
ALTER TABLE `musica`
  MODIFY `id_musica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oyente`
--
ALTER TABLE `oyente`
  MODIFY `id_oyente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album-artista`
--
ALTER TABLE `album-artista`
  ADD CONSTRAINT `relation8` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`),
  ADD CONSTRAINT `relation9` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`idartista`);

--
-- Constraints for table `album-cancion`
--
ALTER TABLE `album-cancion`
  ADD CONSTRAINT `relation10` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`),
  ADD CONSTRAINT `relation11` FOREIGN KEY (`id_cancion`) REFERENCES `artistas` (`idartista`);

--
-- Constraints for table `artista-musica`
--
ALTER TABLE `artista-musica`
  ADD CONSTRAINT `relation6` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`idartista`),
  ADD CONSTRAINT `relation7` FOREIGN KEY (`id_musica`) REFERENCES `musica` (`id_musica`);

--
-- Constraints for table `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `relation2` FOREIGN KEY (`id_productos`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `relation3` FOREIGN KEY (`id_oyente`) REFERENCES `oyente` (`id_oyente`);

--
-- Constraints for table `comentario-publicacion`
--
ALTER TABLE `comentario-publicacion`
  ADD CONSTRAINT `relation12` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id_publicacion`),
  ADD CONSTRAINT `relation13` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios` (`id_comentario`);

--
-- Constraints for table `comunidad-publicacion`
--
ALTER TABLE `comunidad-publicacion`
  ADD CONSTRAINT `relation14` FOREIGN KEY (`id_comunidad`) REFERENCES `comunidad` (`id_comunidad`),
  ADD CONSTRAINT `relation15` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id_publicacion`);

--
-- Constraints for table `oyente-comunidad`
--
ALTER TABLE `oyente-comunidad`
  ADD CONSTRAINT `relation4` FOREIGN KEY (`id_oyente`) REFERENCES `oyente` (`id_oyente`),
  ADD CONSTRAINT `relation5` FOREIGN KEY (`id_comunidad`) REFERENCES `comunidad` (`id_comunidad`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `relation` FOREIGN KEY (`id_artista`) REFERENCES `artistas` (`idartista`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
