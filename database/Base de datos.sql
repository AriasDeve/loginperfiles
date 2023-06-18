CREATE DATABASE dbperfiles;
USE dbperfiles;

CREATE TABLE usuarios
(
	idusuario 		INT AUTO_INCREMENT PRIMARY KEY,
	apellidos 		VARCHAR(30)			NOT NULL,
	nombres 			VARCHAR(30)			NOT NULL,
	email 			VARCHAR(120) 		NULL,
	telefono 		CHAR(9) 				NULL,
	nombreusuario	VARCHAR(20)			NOT NULL,
	claveacceso		VARCHAR(90)			NOT NULL,
	nivelacceso		CHAR(3)				NOT NULL, -- ADM = Administrador, SPV = Supervisor, AST = Asistente
	estado			CHAR(1) 				NOT NULL DEFAULT '1',
	create_at 		DATETIME 			NOT NULL DEFAULT NOW(),
	update_at 		DATETIME 			NULL,
	CONSTRAINT uk_nombreusuario_usu UNIQUE (nombreusuario)
)ENGINE = INNODB;

-- Registramos 3 usuarios (cada uno de un nivel)
INSERT INTO usuarios 
	(apellidos, nombres, nombreusuario, claveacceso, nivelacceso)
	VALUES
		('Cárdenas Mejía', 'Katherine', 'katherinecm', 'CLAVE_AQUI', 'ADM'),
		('Mendoza Castro', 'Flor', 'flormc', 'CLAVE_AQUI', 'SPV'),
		('Hernandez Prada', 'Cristina', 'cristinahp', 'CLAVE_AQUI', 'AST');

-- Le actualizamos la clave por SENATI (encriptado)
UPDATE usuarios SET
	claveacceso = '$2y$10$WY.iP85bEYxBMkVBG0jKO.9Q97kEbofLVwJPUT1OAmsDzLXQ8Pcka';

SELECT * FROM usuarios;

-- TABLA RECUPERACIÓN DE CONTRASEÑAS

UPDATE usuarios SET email = '1337304@senati.pe'

CREATE TABLE recuperarclave
(
		idrecuperar			INT AUTO_INCREMENT PRIMARY KEY,
		idusuario			INT 					 NOT NULL,
		fechageneracion	DATETIME 		    NOT NULL DEFAULT NOW(),
		email					VARCHAR(120) 		 NOT NULL,	-- Email que se utilizó en ese momento
		clavegenerada		CHAR(4)				 NOT NULL,
		estado				CHAR(1)				 NOT NULL DEFAULT '1',
		CONSTRAINT fk_idusuario_rcl FOREIGN KEY (idusuario) REFERENCES usuarios(idusuario)	
)ENGINE = INNODB;

SELECT * FROM recuperarclave;
DELETE FROM recuperarclave;
ALTER TABLE recuperarclave AUTO_INCREMENT 1;
INSERT INTO recuperarclave (idusuario,email,clavegenerada) VALUES(1,'email@gmail.com','1234');

DELIMITER $$
CREATE PROCEDURE spu_registra_claverecuperacion(
	IN _idusuario		INT, 
	IN _email			VARCHAR(120),
	IN _clavegenerada CHAR(4)
)
BEGIN
UPDATE recuperarclave SET estado = '0' WHERE idusuario = _idusuario;
      INSERT INTO recuperarclave (idusuario,email,clavegenerada) 
				VALUES(_idusuario, _email,_clavegenerada);
END$$

CALL spu_registra_claverecuperacion(1,'1337304@senati.pe','1111');

-- despues de comprobar que funciona reiniciar la tabla
DELETE FROM recuperarclave;
ALTER TABLE recuperarclave AUTO_INCREMENT 1;

    SELECT COUNT(*) 'total' 
    FROM recuperarclave 
		WHERE idusuario = 3 AND 
				clavegenerada = '9595' 
				AND estado = '1' ;

SELECT * FROM recuperarclave ORDER BY 1 DESC;

	-- Todas las claves generadas (0/1) del usuario 3 (descendente)
SELECT * FROM recuperarclave ORDER BY 1 DESC;

SELECT * FROM recuperarclave WHERE idusuario = 3 AND estado = '0'; 
	DROP PROCEDURE spu_usuario_validartiempo	
	
-- Procedimiento Almacenado		
	DELIMITER $$
	CREATE PROCEDURE spu_usuario_validartiempo(
		IN _idusuario INT
	)
	BEGIN
		IF ((SELECT COUNT(*) FROM recuperarclave WHERE idusuario = _idusuario) =0) THEN
			SELECT 'GENERAR' AS 'status';
			ELSE
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
			END IF;
	END $$
	
	SELECT * FROM  usuarios WHERE nivelacceso IN('ADM','SPV') ORDER BY 2 DESC;
	
	CALL spu_usuario_validartiempo(1); -- ESTADO 1 / VENCIDO
	CALL spu_usuario_validartiempo(2); -- ESTADO 0
	CALL spu_usuario_validartiempo(3); -- ESTADO 1 / VENCIDO
	
	
	
	-- Procedimiento que valida la clave ingresada
	DELIMITER $$
	CREATE PROCEDURE spu_usuario_validarclave
	(
		IN _idusuario INT,
		IN _clavegenerada	CHAR(4)
	)
	BEGIN
		IF
		(
			(
				SELECT clavegenerada FROM recuperarclave 
				WHERE idusuario = _idusuario AND estado = '1'
				LIMIT 1
			) = _clavegenerada
		)
		THEN
			SELECT 'PERMITIDO' AS 'status';
		ELSE
			SELECT 'DENEGADO' AS 'status';
		END IF;
	END $$
	
	CALL spu_usuario_validarclave(1,'7062');
	
	-- PROCEDIMIENTO QUE FINALMENTE ACTUALIZARA LA CLAVE DESPUES DE TODAS LAS VALIDACIONES
	DELIMITER $$
	CREATE PROCEDURE spu_usuario_actualizarpasssword
	(
		IN _idusuario		INT,
		IN _claveacceso	VARCHAR(90)
	)
	BEGIN
		UPDATE usuarios SET claveacceso = _claveacceso WHERE idusuario = _idusuario;
		UPDATE recuperarclave SET estado = '0' WHERE idusuario = _idusuario; 
	END $$
	
