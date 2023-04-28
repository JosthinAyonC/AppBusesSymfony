DROP TABLE IF EXISTS solicitud;
DROP TABLE IF EXISTS reserva;
DROP TABLE IF EXISTS usuario;
create table usuario(
id_usuario serial,
nombre varchar(100),
apellido varchar(100),
correo varchar(100) unique,
clave varchar(100),
roles json,
estado varchar(1),

constraint pk_usuario primary key (id_usuario)
);

create table reserva(
id_reserva serial,
nombre varchar(100),
precio real,
fecha timestamp,

constraint pk_reserva primary key (id_reserva)
);

create table solicitud(
id_solicitud serial,
observacion varchar(200),
estado_solicitud varchar(20),
estado_db varchar(1),
id_usuario int,
id_reserva int,
constraint pk_solicitud primary key (id_solicitud),
  
constraint pk_solicitud_usuario foreign key (id_solicitud) references
    usuario(id_usuario),
constraint pk_solicitud_reserva foreign key (id_reserva) references
    reserva(id_reserva),

);


INSERT INTO usuario(
nombre, apellido, correo, clave, roles, estado)
VALUES
(
'Josthin', 'Ayon', 'oswayon9@hotmail.com',
'$2y$13$yE9EI8TQZ04C9HWWmcpWOuLQbm8l/zAHa2SKr.EpkyQLhengUBMuS',
'["ROLE_ADMIN"]', 'A' 
);

