create database proyecto;
use proyecto;

create table Usuario(
IDUsuario int primary key auto_increment not null,
Nombre varchar (100) not null,
Apellido varchar(100) not null,
Identificacion enum('C.C','T.I','C.E','P.P.T') NOT NULL,
Documento varchar(100) not null,
Telefono varchar(100) not null,
Email varchar(100) not null,
Ficha varchar(100) not null,
Usuario  varchar(100) not null,
Rol enum ('Estudiante','Administrador') not null,
Contraseña  varchar(100) not null
);
describe Usuario;

create table Instructores(
IDinstructor int primary key auto_increment not null,
Nombrein varchar (100) not null,
Apellidoin varchar(100) not null,
Identificacionin enum('C.C','T.I','C.E','P.P.T') NOT NULL,
Documentoin varchar(100) not null,
Emailin varchar(100) not null,
Usuarioin  varchar(100) not null,
Contraseñain  varchar(100) not null
);
describe Instructores;

create table Tabletas(
CodEquipo int primary key auto_increment not null,
Placa text,
Descripcion text,
Tableta enum('PEN TABLET PTH-65','PEN TABLET PTH-850','Wacom One') NOT NULL,
Usua int unique
);

create table Administrador(
idAdministrador int primary key auto_increment not null,
Anotaciones varchar(100),
idUsuario int,
codequipo int
);

CREATE TABLE Reservas (
    IDReserva INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    IDUsuario INT,
    CodEquipo INT,
    Fichausu VARCHAR(100) NOT NULL,
    FechaReserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (IDUsuario) REFERENCES Usuario(IDUsuario),
    FOREIGN KEY (CodEquipo) REFERENCES Tabletas(CodEquipo)
	ON DELETE SET NULL);
