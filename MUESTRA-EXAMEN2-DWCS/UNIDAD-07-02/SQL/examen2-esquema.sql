drop database if exists examen2;
create database examen2 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

use examen2;


create table if not exists tiendas(
id int auto_increment primary key,
nombre varchar(100) not null,
tlf varchar(13) null
);


create table if not exists familias(
cod varchar(6) primary key,
nombre varchar(200) not null
);


create table if not exists productos(
id int auto_increment primary key,
nombre varchar(200) not null,
nombre_corto varchar(50) unique not null,
descripcion text null,
pvp decimal(10, 2) not null,
familia varchar(6) not null,
constraint fk_prod_fam foreign key(familia) references familias(cod) on update
cascade on delete cascade
);


create table if not exists stocks(
producto int,
tienda int,
unidades int unsigned not null,
constraint pk_stock primary key(producto, tienda),
constraint fk_stock_prod foreign key(producto) references productos(id) on update
cascade on delete cascade,
constraint fk_stock_tienda foreign key(tienda) references tiendas(id) on update
cascade on delete cascade
);


create table empleados (
id int auto_increment primary key,
usuario varchar(20) unique,
pass varchar(64) not null
);


create table if not exists clientes (
id int auto_increment primary key,
nombre varchar(50) not null,
apellido1 varchar(50) not null,
apellido2 varchar(50),
direccion text null,
telefono varchar(10),
usuario varchar(20) unique,
pass varchar(64) not null
);

create table if not exists ventas (
id int auto_increment not null,
ticket int not null,
id_producto int not null,
id_cliente int not null,
id_empleado int,
id_tienda int,
pvp decimal(10, 2) not null,
fecha timestamp default current_timestamp,
constraint pk_ventas primary key(id, ticket),
constraint fk_ventas_productos foreign key(id_producto) references productos(id) on update cascade on delete restrict,
constraint fk_ventas_clientes foreign key(id_cliente) references clientes(id) on update cascade on delete restrict,
constraint fk_ventas_tienda foreign key(id_tienda) references tiendas(id) on update cascade on delete set null,
constraint fk_ventas_empleado foreign key(id_empleado) references empleados(id) on update cascade on delete set null
);

drop user if exists gestor@'localhost';
create user gestor@'localhost' identified by "secreto";
grant all on examen2.* to gestor@'localhost';

