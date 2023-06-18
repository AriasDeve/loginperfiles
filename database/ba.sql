/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.24-MariaDB : Database - dbperfiles
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbperfiles` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `dbperfiles`;

/*Table structure for table `recuperarclave` */

DROP TABLE IF EXISTS `recuperarclave`;

CREATE TABLE `recuperarclave` (
  `idrecuperar` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `fechageneracion` datetime NOT NULL DEFAULT current_timestamp(),
  `email` varchar(120) NOT NULL,
  `clavegenerada` char(4) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idrecuperar`),
  KEY `fk_idusuario_rcl` (`idusuario`),
  CONSTRAINT `fk_idusuario_rcl` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `recuperarclave` */

insert  into `recuperarclave`(`idrecuperar`,`idusuario`,`fechageneracion`,`email`,`clavegenerada`,`estado`) values 
(1,1,'2023-06-06 17:14:20','1337304@senati.pe','6504','0'),
(2,1,'2023-06-06 17:15:08','1337304@senati.pe','9595','0'),
(3,3,'2023-06-06 17:59:27','1337304@senati.pe','7609','0'),
(4,2,'2023-06-12 08:00:32','1337304@senati.pe','8471','0'),
(5,2,'2023-06-12 08:58:53','1337304@senati.pe','2204','0'),
(6,3,'2023-06-12 09:15:58','1337304@senati.pe','5256','0'),
(7,3,'2023-06-12 12:00:00','1337304@senati.pe','5862','1'),
(8,1,'2023-06-12 13:45:12','1337304@senati.pe','4883','0'),
(9,1,'2023-06-12 14:19:37','1337304@senati.pe','7062','0'),
(10,1,'2023-06-12 14:45:26','1337304@senati.pe','7063','0'),
(11,1,'2023-06-12 15:03:34','1337304@senati.pe','9953','0'),
(12,1,'2023-06-12 15:36:30','1337304@senati.pe','4586','0'),
(13,1,'2023-06-12 15:43:15','1337304@senati.pe','9662','0'),
(14,1,'2023-06-12 16:12:29','1337304@senati.pe','9803','0');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `apellidos` varchar(30) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `telefono` char(9) DEFAULT NULL,
  `nombreusuario` varchar(20) NOT NULL,
  `claveacceso` varchar(90) NOT NULL,
  `nivelacceso` char(3) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `uk_nombreusuario_usu` (`nombreusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `usuarios` */

insert  into `usuarios`(`idusuario`,`apellidos`,`nombres`,`email`,`telefono`,`nombreusuario`,`claveacceso`,`nivelacceso`,`estado`,`create_at`,`update_at`) values 
(1,'Cárdenas Mejía','Katherine','1337304@senati.pe',NULL,'katherinecm','$2y$10$axbASjPSjUQnA77dkDhMz.P9qgpyl7pJqmGKv4jiKkztQmS9ccx9.','ADM','1','2023-05-30 10:11:22',NULL),
(2,'Mendoza Castro','Flor','1337304@senati.pe',NULL,'flormc','$2y$10$WY.iP85bEYxBMkVBG0jKO.9Q97kEbofLVwJPUT1OAmsDzLXQ8Pcka','SPV','1','2023-05-30 10:11:22',NULL),
(3,'Hernandez Prada','Cristina','1337304@senati.pe',NULL,'cristinahp','$2y$10$WY.iP85bEYxBMkVBG0jKO.9Q97kEbofLVwJPUT1OAmsDzLXQ8Pcka','AST','1','2023-05-30 10:11:22',NULL);

/* Procedure structure for procedure `spu_registra_claverecuperacion` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_registra_claverecuperacion` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_registra_claverecuperacion`(
	IN _idusuario		int, 
	in _email			VARCHAR(120),
	in _clavegenerada CHAR(4)
)
begin
UPDATE recuperarclave SET estado = '0' WHERE idusuario = _idusuario;
      INSERT INTO recuperarclave (idusuario,email,clavegenerada) 
				VALUES(_idusuario, _email,_clavegenerada);
end */$$
DELIMITER ;

/* Procedure structure for procedure `spu_usuario_actualizarpasssword` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_usuario_actualizarpasssword` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuario_actualizarpasssword`(
		IN _idusuario		INT,
		IN _claveacceso	VARCHAR(90)
	)
BEGIN
		UPDATE usuarios SET claveacceso = _claveacceso WHERE idusuario = _idusuario;
		UPDATE recuperarclave SET estado = '0' WHERE idusuario = _idusuario; 
	END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_usuario_validarclave` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_usuario_validarclave` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuario_validarclave`(
		IN _idusuario INT,
		IN _clavegenerada	CHAR(4)
	)
BEGIN
		IF
		(
			(
				SELECT clavegenerada FROM recuperarclave 
				WHERE idusuario = _idusuario and estado = '1'
				limit 1
			) = _clavegenerada
		)
		THEN
			SELECT 'PERMITIDO' AS 'status';
		else
			SELECT 'DENEGADO' AS 'status';
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_usuario_validartiempo` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_usuario_validartiempo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuario_validartiempo`(
		IN _idusuario INT
	)
BEGIN
		if ((select count(*) from recuperarclave where idusuario = _idusuario) =0) then
			select 'GENERAR' AS 'status';
			else
				-- Buscamos el último estado del usuario . si es 0, entonces debe GENERAR el código
				IF ((SELECT estado FROM recuperarclave WHERE idusuario = _idusuario ORDER BY 1 DESC LIMIT 1)= 0)THEN
					SELECT 'GENERAR' AS 'status';
				ELSE
					-- En esta sección, el último registro es '1', NO sabemos si está dentro de los 15min permitidos
					IF
					(
							(
								SELECT COUNT(*) FROM recuperarclave 
								WHERE idusuario = _idusuario AND estado = '1' AND
								NOW()NOT BETWEEN fechageneracion AND DATE_ADD(fechageneracion,INTERVAL 15 MINUTE)
								ORDER BY fechageneracion DESC LIMIT 1						
							) = 1
						)THEN
							-- El usuario tiene estado 1, pero esta fuera de los 15 minutos
							SELECT 'GENERAR' AS 'status';
						ELSE
							SELECT 'DENEGAR' AS 'status';
					END IF;
				END IF;
			end if;
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
