--PRIMER PARCIAL


create database perez
--MARCAS
CREATE TABLE libros (
libro_id SERIAL PRIMARY KEY,
libro_titulo VARCHAR(100) NOT NULL,
libro_autor VARCHAR(255),
libro_situacion SMALLINT DEFAULT 1
);



--PRESTAMOS
-- Tabla de productos (tabla hija de marcas)
CREATE TABLE prestamos (
prestamo_id SERIAL PRIMARY KEY,
prestamo_nombre_libro VARCHAR(150) NOT NULL,
prestamo_descripcion_libro VARCHAR(255),
prestamo_precio_libro DECIMAL(10,2) NOT NULL,
prestamo_stock_libro INT DEFAULT 0,
libro_id INT NOT NULL,
prestamo_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (libro_id) REFERENCES libros(libro_id)
);



--PERSONAS
-- Tabla de clientes (tabla independiente)
CREATE TABLE personas (
persona_id SERIAL PRIMARY KEY,
persona_nombres VARCHAR(100) NOT NULL,
persona_apellidos VARCHAR(100) NOT NULL,
persona_nit VARCHAR(15),
persona_telefono VARCHAR(8),
persona_correo VARCHAR(100),
persona_direccion VARCHAR(200),
persona_fecha_registro DATETIME YEAR TO MINUTE,
persona_situacion SMALLINT DEFAULT 1
);
