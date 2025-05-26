create database perez

CREATE TABLE libros (
    libro_id SERIAL PRIMARY KEY,
    libro_titulo VARCHAR(255),
    libro_autor VARCHAR(255),
    libro_situacion SMALLINT DEFAULT 1
);

-- 2. TABLA DE PERSONAS (solo nombre)
CREATE TABLE personas (
    persona_id SERIAL PRIMARY KEY,
    persona_nombre VARCHAR(255),
    persona_situacion SMALLINT DEFAULT 1
);

-- 3. TABLA DE PRÉSTAMOS (vacía - el usuario ingresará datos)

CREATE TABLE prestamos (
    prestamo_id SERIAL PRIMARY KEY,
    prestamo_libro_id INT,
    prestamo_persona_id INT,
    prestamo_fecha_prestamo DATETIME YEAR TO MINUTE,
    prestamo_devuelto CHAR(1) DEFAULT 'N', -- S=Devuelto, N=No devuelto (Activo)
    prestamo_fecha_devolucion DATETIME YEAR TO MINUTE,
    prestamo_situacion SMALLINT DEFAULT 1
);

INSERT INTO libros (libro_titulo, libro_autor) VALUES
('Don Quijote de la Mancha', 'Cervantes');
INSERT INTO libros (libro_titulo, libro_autor) VALUES
('Cien Años de Soledad', 'Gabriel Márquez');
INSERT INTO libros (libro_titulo, libro_autor) VALUES
('El Principito', 'Antoine');
INSERT INTO libros (libro_titulo, libro_autor) VALUES
('Orgullo y Prejuicio', 'Jane Austen');


-- ===================================
-- INSERTAR 10 PERSONAS
-- ===================================
INSERT INTO personas (persona_nombre) VALUES
('María Elena García');
INSERT INTO personas (persona_nombre) VALUES
('Carlos Roberto Mendoza');
INSERT INTO personas (persona_nombre) VALUES
('Ana Sofía Morales');
INSERT INTO personas (persona_nombre) VALUES
('Luis Fernando Hernández');
INSERT INTO personas (persona_nombre) VALUES
('Carmen Beatriz Rodríguez');
INSERT INTO personas (persona_nombre) VALUES
('José Antonio López');
INSERT INTO personas (persona_nombre) VALUES
('Miguel Ángel Torres');