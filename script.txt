create table cliente(
id_cliente int AUTO_INCREMENT PRIMARY KEY,
nombre varchar(30),
apellidos varchar(30),
empresa varchar(50),
telefono varchar(10),
direccion varchar(50));

create table categoria(
id_categoria int auto_increment primary key,
nombre varchar(40));

create table producto(
id_producto int auto_increment primary key,
descripcion varchar(30),
precio float not null,
id_categoria int not null,
foreign key(id_categoria) references categoria(id_categoria));

create table venta(
id_venta int auto_increment primary key,
fecha date,
id_cliente int,
foreign key(id_cliente) references cliente(id_cliente));

create table detalle_venta(
id_venta int,
id_producto int,
preciov float,
cantidad int,
primary key(id_venta,id_producto),
foreign key(id_venta) references venta(id_venta),
foreign key(id_producto) references producto(id_producto));

