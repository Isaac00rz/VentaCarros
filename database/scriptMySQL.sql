Create DATABASE Agencia;

Use Agencia;

CREATE TABLE Vendedor(
	Id Integer PRIMARY KEY AUTO_INCREMENT,
    Nombre Varchar(100),
    ApellidoP varchar(100),
    ApellidoM varchar(100),
    Telefono varchar(20),
    Email varchar(200)
);

CREATE TABLE Cliente(
	RFC Varchar(50) PRIMARY KEY NOT NULL,
    Nombre Varchar(150),
    Calle Varchar(150),
    NoExterior Integer,
    NoInterior Integer,
    Colonia Varchar(150),
    Ciudad Varchar(150),
    Estado Varchar(150)
);

CREATE TABLE Auto(
	Id Integer PRIMARY KEY AUTO_INCREMENT,
    Nombre Varchar(150),
    Modelo Varchar(150),
    Marca Varchar(150),
    Precio Double
);

CREATE TABLE Venta (
    Id Integer PRIMARY KEY AUTO_INCREMENT, 
    IdVendedor Integer NOT NULL, 
    IdCliente varchar(50) NOT NULL,
    IdAuto Integer NOT NULL,
    Descuento Double,
    Enganche Double NOT NULL,
    Plazos Integer NOT NULL,
    Interes Double,
    Fecha Date NOT NULL,
    Tasa Double,
    FOREIGN KEY (IdVendedor) REFERENCES Vendedor(Id),
    FOREIGN KEY (IdCliente) REFERENCES Cliente(RFC),
    FOREIGN KEY (IdAuto) REFERENCES Auto(Id)
);

CREATE TABLE Pago(
	Id Integer PRIMARY KEY AUTO_INCREMENT,
    IdCliente varchar(50) NOT NULL,
    IdVenta Integer NOT NULL,
    Fecha Date,
    Importe Double,
    FOREIGN KEY (IdCliente) REFERENCES Cliente(RFC),
    FOREIGN KEY (IdVenta) REFERENCES Venta(Id)
);