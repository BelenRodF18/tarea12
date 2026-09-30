SET NAMES utf8mb4;

CREATE TABLE Clientes (
    ID_cliente      INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_completo VARCHAR(80)  NOT NULL,
    Email           VARCHAR(100) NOT NULL,
    Telefono        VARCHAR(20)  NOT NULL
);

CREATE TABLE Vendedores (
    ID_vendedor     INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_completo VARCHAR(80) NOT NULL
);

CREATE TABLE Autos (
    ID_auto   INT AUTO_INCREMENT PRIMARY KEY,
    Marca     VARCHAR(40) NOT NULL,
    Modelo    VARCHAR(40) NOT NULL,
    Matricula VARCHAR(10) NOT NULL UNIQUE,
    Precio    DECIMAL(12,2) NOT NULL
);

-- Cada auto se vende una sola vez (ID_auto UNIQUE).
-- Un cliente puede comprar muchos autos y un vendedor vender muchos.
CREATE TABLE Ventas (
    ID_venta    INT AUTO_INCREMENT PRIMARY KEY,
    ID_auto     INT NOT NULL UNIQUE,
    ID_cliente  INT NOT NULL,
    ID_vendedor INT NOT NULL,
    Monto       DECIMAL(12,2) NOT NULL,
    Fecha       DATE NOT NULL,
    FOREIGN KEY (ID_auto) REFERENCES Autos(ID_auto)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (ID_cliente) REFERENCES Clientes(ID_cliente)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (ID_vendedor) REFERENCES Vendedores(ID_vendedor)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

INSERT INTO Clientes (ID_cliente, Nombre_completo, Email, Telefono) VALUES
(1, 'Maria Gonzalez',   'maria.gonzalez@gmail.com',   '099123456'),
(2, 'Pedro Rodriguez',  'pedro.rodriguez@gmail.com',  '098234567'),
(3, 'Lucia Martinez',   'lucia.martinez@outlook.com', '091345678'),
(4, 'Carlos Gomez',     'carlos.gomez@gmail.com',     '094456789'),
(5, 'Sofia Lopez',      'sofia.lopez@gmail.com',      '092567890'),
(6, 'Julian Castro',    'julian.castro@gmail.com',    '095678901');

INSERT INTO Vendedores (ID_vendedor, Nombre_completo) VALUES
(1, 'Ana Torres'),
(2, 'Diego Fernandez'),
(3, 'Valentina Silva');

INSERT INTO Autos (ID_auto, Marca, Modelo, Matricula, Precio) VALUES
(1,  'Toyota',     'Corolla',  'SBA1234', 32000.00),
(2,  'Volkswagen', 'Gol',      'SBB2345', 18500.00),
(3,  'Chevrolet',  'Onix',     'SBC3456', 21000.00),
(4,  'Ford',       'Ranger',   'SBD4567', 45000.00),
(5,  'Fiat',       'Cronos',   'SBE5678', 19800.00),
(6,  'Renault',    'Kwid',     'SBF6789', 14500.00),
(7,  'Peugeot',    '208',      'SBG7890', 23500.00),
(8,  'Toyota',     'Hilux',    'SBH8901', 52000.00),
(9,  'Hyundai',    'HB20',     'SBI9012', 20500.00),
(10, 'Nissan',     'Kicks',    'SBJ0123', 29000.00);

-- Maria (1) compro 3 autos, Pedro (2) compro 2, Lucia (3) y Carlos (4) uno cada uno.
-- Sofia (5) y Julian (6) no compraron nada. Los autos 9 y 10 siguen sin vender.
-- La vendedora 3 todavia no tiene ventas.
INSERT INTO Ventas (ID_venta, ID_auto, ID_cliente, ID_vendedor, Monto, Fecha) VALUES
(1, 1, 1, 1, 31500.00, '2025-03-12'),
(2, 2, 2, 1, 18500.00, '2025-05-20'),
(3, 3, 1, 2, 20800.00, '2025-08-02'),
(4, 4, 3, 1, 44000.00, '2025-11-15'),
(5, 5, 4, 2, 19800.00, '2026-01-09'),
(6, 6, 2, 2, 14000.00, '2026-03-27'),
(7, 7, 1, 1, 23500.00, '2026-06-18');
