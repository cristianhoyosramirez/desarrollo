--12 de Agosto de 2023 
--Borrado de tres campos de la tabla mesa 
alter table
  mesas drop estado;

alter table
  mesas drop valor_pedido;

alter table
  mesas drop fk_usuario;

--Insertar una mesa SISTEMA para la facturacion rápida 
INSERT INTO
  mesas(nombre)
VALUES
  ('SISTEMA');

alter table
  pedido drop fk_usuario;

--Factura electronica 
INSERT INTO
  estado(descripcionestado)
VALUES
  ('Factura electrónica ');

-- Table: bancos
-- DROP TABLE bancos;
CREATE TABLE bancos (
  id serial NOT NULL,
  nombre character varying(50)
) WITH (OIDS = FALSE);

ALTER TABLE
  bancos OWNER TO postgres;

--Insertar
INSERT INTO
  bancos(nombre)
VALUES
  ('Transferecia');

--24 DE AGOSTO 
DROP TABLE pedidos;

-- Table: pedido
-- DROP TABLE pedido;
CREATE TABLE pedido (
  id serial NOT NULL,
  fk_mesa integer,
  fk_usuario integer,
  valor_total integer,
  nota_pedido character varying(1000),
  cantidad_de_productos integer,
  fecha_creacion timestamp without time zone,
  fecha_actualizacion timestamp without time zone,
  deleted_at date,
  numero_factura character varying(50),
  impuesto_iva double precision DEFAULT 0,
  base_ico double precision DEFAULT 0,
  impuesto_ico double precision DEFAULT 0,
  base_iva double precision DEFAULT 0,
  CONSTRAINT pk_pedido PRIMARY KEY (id),
  CONSTRAINT fk_mesa FOREIGN KEY (fk_mesa) REFERENCES mesas (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_usuario FOREIGN KEY (fk_usuario) REFERENCES usuario_sistema (idusuario_sistema) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION
) WITH (OIDS = FALSE);

ALTER TABLE
  pedido OWNER TO postgres;

--Actualizacion nombre cliente de general a cuantias menores 
UPDATE
  CLIENTE
SET
  nombrescliente = 'CUANTIAS MENORES'
where
  nitcliente = '22222222';

--Renombrar campo de partir factura 
ALTER TABLE
  partir_factura RENAME COLUMN nombre_producto TO nombreproducto;

update
  estado
set
  descripcionestado = 'POS CONTADO'
where
  idestado = 1;

update
  estado
set
  descripcionestado = 'POS CRÉDITO'
where
  idestado = 2;

-- Column: fecha_y_hora_factura_venta
-- ALTER TABLE documento_electronico DROP COLUMN fecha_y_hora_factura_venta;
ALTER TABLE
  documento_electronico
ADD
  COLUMN fecha_y_hora_factura_venta timestamp without time zone;

-- agregar constraint a la tabla pedido 
-- Column: fecha_y_hora_factura_venta
-- ALTER TABLE kardex DROP COLUMN fecha_y_hora_factura_venta;
ALTER TABLE
  kardex
ADD
  COLUMN fecha_y_hora_factura_venta timestamp without time zone;

-- Table: factura_propina
-- DROP TABLE factura_propina;
CREATE TABLE factura_propina (
  id serial NOT NULL,
  estado character varying(10),
  valor_propina character varying(20),
  id_factura integer,
  CONSTRAINT pk_factura_forma_pago PRIMARY KEY (id)
) WITH (OIDS = FALSE);

ALTER TABLE
  factura_propina OWNER TO postgres;

-- Column: id_apertura
-- ALTER TABLE factura_propina DROP COLUMN id_apertura;
ALTER TABLE
  factura_propina
ADD
  COLUMN id_apertura integer;

-- Column: fecha_y_hora_factura_venta
-- ALTER TABLE factura_propina DROP COLUMN fecha_y_hora_factura_venta;
ALTER TABLE
  factura_propina
ADD
  COLUMN fecha_y_hora_factura_venta timestamp without time zone;

-- Column: id_categoria
-- ALTER TABLE kardex DROP COLUMN id_categoria;
ALTER TABLE
  kardex
ADD
  COLUMN id_categoria character varying (20);

-- Column: fecha
-- ALTER TABLE factura_propina DROP COLUMN fecha;
ALTER TABLE
  factura_propina
ADD
  COLUMN fecha date;

-- Column: hora
-- ALTER TABLE factura_propina DROP COLUMN hora;
ALTER TABLE
  factura_propina
ADD
  COLUMN hora time with time zone;

DROP TABLE IF EXISTS pedido_pos;

DROP TABLE IF EXISTS producto_pedido_pos;

-- Column: id_apertura
-- ALTER TABLE kardex DROP COLUMN id_apertura;
ALTER TABLE
  kardex
ADD
  COLUMN id_apertura integer;

-- Column: valor_unitario
-- ALTER TABLE reporte_ventas_producto_categorias DROP COLUMN valor_unitario;
ALTER TABLE
  reporte_ventas_producto_categorias
ADD
  COLUMN valor_unitario double precision;

-- Column: valor_unitario
-- ALTER TABLE kardex DROP COLUMN valor_unitario;
ALTER TABLE
  kardex
ADD
  COLUMN valor_unitario double precision;

-- Column: id_apertura
-- ALTER TABLE detalle_devolucion_venta DROP COLUMN id_apertura;
ALTER TABLE
  detalle_devolucion_venta
ADD
  COLUMN id_apertura integer;

-- Column: propina
-- ALTER TABLE pedido DROP COLUMN propina;
ALTER TABLE
  pedido
ADD
  COLUMN propina character varying(30);

ALTER TABLE
  pedido
ALTER COLUMN
  propina
SET
  DEFAULT 0;

-- Table: factura_propina
-- DROP TABLE factura_propina;
CREATE TABLE factura_propina (
  id serial NOT NULL,
  estado character varying(10),
  valor_propina integer,
  id_factura integer,
  id_apertura integer,
  fecha_y_hora_factura_venta timestamp without time zone,
  fecha date,
  hora time with time zone,
  CONSTRAINT pk_factura_forma_pago PRIMARY KEY (id)
) WITH (OIDS = FALSE);

ALTER TABLE
  factura_propina OWNER TO postgres;

-- Table: pagos
-- DROP TABLE pagos;
CREATE TABLE pagos (
  id serial NOT NULL,
  fecha date,
  hora time with time zone,
  documento character varying(50),
  valor integer,
  propina integer,
  total_documento integer,
  efectivo integer,
  trnasferencia integer,
  total_pago integer,
  id_usuario_facturacion integer,
  id_mesero integer,
  id_estado integer
) WITH (OIDS = FALSE);

ALTER TABLE
  pagos OWNER TO postgres;

-- Table: boletas
-- DROP TABLE boletas;
CREATE TABLE boletas (
  id serial NOT NULL,
  nitcliente character varying(30),
  fecha_generacion date,
  hora_generacion time with time zone,
  estado character varying(30),
  fecha_ingreso date,
  hora_ingreso time with time zone,
  observaciones character varying(200),
  nombre_qr character varying(200),
  localidad character varying(50),
  CONSTRAINT pk_boletas PRIMARY KEY (id)
) WITH (OIDS = FALSE);

ALTER TABLE
  boletas OWNER TO postgres;

--- 13 de Septiembre de 2023 -- 
-- Column: mesero_pedido
-- ALTER TABLE configuracion_pedido DROP COLUMN mesero_pedido;
ALTER TABLE
  configuracion_pedido
ADD
  COLUMN mesero_pedido boolean;

update
  configuracion_pedido
set
  mesero_pedido = true;

-- Column: id_apertura
-- ALTER TABLE documento_electronico DROP COLUMN id_apertura;
ALTER TABLE
  documento_electronico
ADD
  COLUMN id_apertura integer;

-- Column: id_apertura
-- ALTER TABLE factura_electronica DROP COLUMN id_apertura;
ALTER TABLE
  factura_venta
ADD
  COLUMN id_apertura integer;

-- Column: id_apertura
-- ALTER TABLE retiro_forma_pago DROP COLUMN id_apertura;
ALTER TABLE
  retiro_forma_pago
ADD
  COLUMN id_apertura integer;

-- Column: id_apertura
-- ALTER TABLE devolucion_venta_efectivo DROP COLUMN id_apertura;
ALTER TABLE
  devolucion_venta_efectivo
ADD
  COLUMN id_apertura integer;

alter table
  pagos
add
  column recibido_efectivo integer;

alter table
  pagos
add
  column recibido_transferencia integer;

alter table
  pagos
add
  column cambio integer;

alter table
  factura_propina
add
  column id_mesa integer;

alter table
  producto_pedido
add
  CONSTRAINT fk_pedido FOREIGN KEY (numero_de_pedido) REFERENCES pedido (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION --Borrar id_meseros en la mesa 
alter table
  mesas drop id_mesero;

--Correccion en tabla ico 
insert into
  ico_consumo (id_ico, valor_ico)
values
  (1, 0) el producto no le esta cargando a ninguna cuenta el cafe uba y no trae el tercero de yolanda lopez mejia en rebeca -- Column: propina
  -- ALTER TABLE configuracion_pedido DROP COLUMN propina;
ALTER TABLE
  configuracion_pedido
ADD
  COLUMN propina character varying(50);

-- Column: propina
-- ALTER TABLE pedido DROP COLUMN propina;
ALTER TABLE
  pedido
ADD
  COLUMN propina character varying(30);

ALTER TABLE
  pedido
ALTER COLUMN
  propina
SET
  DEFAULT 0;

-- Column: id_mesero
-- ALTER TABLE factura_propina DROP COLUMN id_mesero;
ALTER TABLE
  factura_propina
ADD
  COLUMN id_mesero integer;

-- Column: transferencia
-- ALTER TABLE pagos DROP COLUMN transferencia;
ALTER TABLE
  pagos
ADD
  COLUMN transferencia integer;

-- Column: id_apertura
-- ALTER TABLE pagos DROP COLUMN id_apertura;
ALTER TABLE
  pagos
ADD
  COLUMN id_apertura integer;

--CAmbiar tipo de datos en la tabla factura_propina
ALTER TABLE
  factura_propina
ALTER COLUMN
  valor_propina TYPE integer USING (valor_propina :: integer);

--Usuario tipo mesero 
insert into
  tipo (descripciontipo)
values
  ('mesero');

-- Table: impuesto_saludable
-- DROP TABLE impuesto_saludable;
CREATE TABLE impuesto_saludable (
  id serial NOT NULL,
  nombre character varying(50)
) WITH (OIDS = FALSE);

ALTER TABLE
  impuesto_saludable OWNER TO postgres;

insert into
  impuesto_saludable (nombre)
values
  ('impuesto 1');

insert into
  impuesto_saludable (nombre)
values
  ('impuesto 2');

---Creacion de campo id_impuesto 
alter table
  producto
add
  column id_impuesto_saludable integer;

alter table
  producto
add
  column valor_impuesto_saludable double precision;

---Creacion de campo id_impuesto  en la tabla producto factura venta 
alter table
  producto_factura_venta
add
  column id_impuesto_saludable integer;

alter table
  producto_factura_venta
add
  column valor_impuesto_saludable double precision;

-- Column: valor_defecto_propina
-- ALTER TABLE configuracion_pedido DROP COLUMN valor_defecto_propina;
ALTER TABLE
  configuracion_pedido
ADD
  COLUMN valor_defecto_propina integer;

ALTER TABLE
  configuracion_pedido
ALTER COLUMN
  valor_defecto_propina
SET
  DEFAULT 1;

-- Column: propina
-- ALTER TABLE documento_electronico DROP COLUMN propina;
ALTER TABLE
  documento_electronico
ADD
  COLUMN propina integer;

-- Column: id_mesa
-- ALTER TABLE factura_propina DROP COLUMN id_mesa;
ALTER TABLE
  factura_propina
ADD
  COLUMN id_mesa integer;

-- Columna en la tabla pagos 
alter table
  pagos
add
  column id_factura integer;

-- Columna en la tabla kardex 
alter table
  kardex
add
  column id_factura integer;

--Campos en la tabla kardex 
alter table
  kardex
add
  column costo integer DEFAULT 0;

alter table
  kardex
add
  column ico double precision DEFAULT 0;

alter table
  kardex
add
  column iva double precision DEFAULT 0;

-- Columna en la tabla kardex 
alter table
  kardex
add
  column id_estado integer;

---Configuracion de impresora ---
alter table
  caja
add
  column id_impresora integer;

update
  caja
set
  id_impresora = 1
where
  numerocaja = 1;

ALTER TABLE
  caja
ADD
  CONSTRAINT pk_impresora FOREIGN KEY (id_impresora) REFERENCES impresora (id) MATCH simple on
UPDATE no action ON
DELETE no action;

---Configuracion de impresora ---
--Configuracion de licencia 
ALTER TABLE
  configuracion_pedido
ADD
  COLUMN estado_licencia BOOLEAN DEFAULT false;

-- Column: valor_ico
-- ALTER TABLE kardex DROP COLUMN valor_ico;
ALTER TABLE
  kardex
ADD
  COLUMN valor_ico integer;

-- Column: valor_iva
-- ALTER TABLE kardex DROP COLUMN valor_iva;
ALTER TABLE
  kardex
ADD
  COLUMN valor_iva integer;

alter table
  kardex
add
  column aplica_ico boolean;

--18 de Diciembre de 2023
CREATE SEQUENCE consecutivo_informe_numero_seq;

ALTER TABLE
  consecutivo_informe
ALTER COLUMN
  numero
SET
  DEFAULT nextval('consecutivo_informe_numero_seq' :: regclass);

ALTER TABLE
  consecutivo_informe
ALTER COLUMN
  numero
SET
  DEFAULT nextval('consecutivo_informe_numero_seq' :: regclass);

-- Column: id_apertura
-- ALTER TABLE consecutivo_informe DROP COLUMN id_apertura;
ALTER TABLE
  consecutivo_informe
ADD
  COLUMN id_apertura integer;

ALTER TABLE
  consecutivo_informe
ALTER COLUMN
  id_apertura
SET
  NOT NULL;

ALTER TABLE
  consecutivo_informe
ALTER COLUMN
  id_apertura
SET
  DEFAULT 1;

-- Column: sub_categoria
-- ALTER TABLE configuracion_pedido DROP COLUMN sub_categoria;
ALTER TABLE
  configuracion_pedido
ADD
  COLUMN sub_categoria boolean;

ALTER TABLE
  configuracion_pedido
ALTER COLUMN
  sub_categoria
SET
  DEFAULT false;

-- DROP TABLE sub_categoria;
CREATE TABLE sub_categoria (
  id serial NOT NULL,
  nombre character varying(50),
  id_categoria integer,
  CONSTRAINT pk_sub_categoria PRIMARY KEY (id)
) WITH (OIDS = FALSE);

ALTER TABLE
  sub_categoria OWNER TO postgres;

-- Column: id_subcategoria
-- ALTER TABLE producto DROP COLUMN id_subcategoria;
ALTER TABLE
  producto
ADD
  COLUMN id_subcategoria integer;

-- Table: producto_catego_sub
-- DROP TABLE producto_catego_sub;
-- Table: producto_catego_sub
-- DROP TABLE producto_catego_sub;
CREATE TABLE producto_catego_sub (
  id serial NOT NULL,
  id_categoria character varying(255),
  id_sub_categoria integer,
  CONSTRAINT pk_producto_categoria PRIMARY KEY (id)
) WITH (OIDS = FALSE);

ALTER TABLE
  producto_catego_sub OWNER TO postgres;

-- Column: id_mesero
-- ALTER TABLE pedidos_borrados DROP COLUMN id_mesero;
ALTER TABLE
  pedidos_borrados
ADD
  COLUMN id_mesero integer;

-- Foreign Key: fk_usuario_eliminacion
-- ALTER TABLE pedidos_borrados DROP CONSTRAINT fk_usuario_eliminacion;
ALTER TABLE
  pedidos_borrados
ADD
  CONSTRAINT fk_usuario_eliminacion FOREIGN KEY (id_mesero) REFERENCES usuario_sistema (idusuario_sistema) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;

-- Column: id_mesero
-- ALTER TABLE productos_borrados DROP COLUMN id_mesero;
ALTER TABLE
  productos_borrados
ADD
  COLUMN id_mesero integer;

-- Constraint: pk_productos_borrados
-- ALTER TABLE productos_borrados DROP CONSTRAINT pk_productos_borrados;
ALTER TABLE
  productos_borrados
ADD
  CONSTRAINT pk_productos_borrados PRIMARY KEY(id);

-- Foreign Key: fk_usuario_creacion
-- ALTER TABLE productos_borrados DROP CONSTRAINT fk_usuario_creacion;
ALTER TABLE
  productos_borrados
ADD
  CONSTRAINT fk_usuario_creacion FOREIGN KEY (id_mesero) REFERENCES usuario_sistema (idusuario_sistema) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;

-- Column: id_apertura
-- ALTER TABLE factura_venta DROP COLUMN id_apertura;
ALTER TABLE
  factura_venta
ADD
  COLUMN id_apertura integer;

-- Column: saldo
-- ALTER TABLE pagos DROP COLUMN saldo;
ALTER TABLE
  pagos
ADD
  COLUMN saldo integer;

-- Column: alerta
-- ALTER TABLE resolucion_electronica DROP COLUMN alerta;
ALTER TABLE
  resolucion_electronica
ADD
  COLUMN alerta integer;

-- Column: estado
-- ALTER TABLE estado DROP COLUMN estado;
ALTER TABLE
  estado
ADD
  COLUMN estado boolean;

ALTER TABLE
  estado
ALTER COLUMN
  estado
SET
  DEFAULT true;

-- Column: orden
-- ALTER TABLE estado DROP COLUMN orden;
ALTER TABLE
  estado
ADD
  COLUMN orden integer;

/*** 
 Importante en la tabla estado actualizar la columna estado y la columna orden **/
update
  departamento
set
  nombredepartamento = 'Risaralda'
where
  iddepartamento = 772 CREATE TABLE temp_producto_pedido (
    id serial NOT NULL,
    numero_de_pedido integer,
    cantidad_producto integer,
    nota_producto character varying(500),
    valor_unitario integer,
    valor_total integer,
    se_imprime_en_comanda boolean,
    codigo_categoria character varying(50),
    codigointernoproducto character varying(50)
  ) WITH (OIDS = FALSE);

-- Column: nit_cliente
-- ALTER TABLE pagos DROP COLUMN nit_cliente;
ALTER TABLE
  pagos
ADD
  COLUMN nit_cliente character varying(50);

DO $ $ DECLARE registro record;

nit_cliente_result text;

-- Variable para almacenar el resultado de la consulta
cur_pagos CURSOR FOR
SELECT
  id,
  id_factura
FROM
  pagos
WHERE
  id_estado = 1;

BEGIN FOR registro IN cur_pagos LOOP -- Realizar la consulta SELECT y almacenar el resultado en la variable nit_cliente_result
SELECT
  nitcliente INTO nit_cliente_result
FROM
  factura_venta
WHERE
  id = registro.id_factura;

-- Actualizar la tabla pagos con el valor capturado
UPDATE
  pagos
SET
  nit_cliente = nit_cliente_result
WHERE
  id = registro.id;

-- Puedes realizar otras operaciones aquí usando el valor de nit_cliente_result
END LOOP;

END $ $ LANGUAGE 'plpgsql';

DO $ $ DECLARE registro record;

nit_cliente_result text;

-- Variable para almacenar el resultado de la consulta
cur_pagos CURSOR FOR
SELECT
  id,
  id_factura
FROM
  pagos
WHERE
  id_estado = 8;

BEGIN FOR registro IN cur_pagos LOOP -- Realizar la consulta SELECT y almacenar el resultado en la variable nit_cliente_result
SELECT
  nit_cliente INTO nit_cliente_result
FROM
  documento_electronico
WHERE
  id = registro.id_factura;

-- Actualizar la tabla pagos con el valor capturado
UPDATE
  pagos
SET
  nit_cliente = nit_cliente_result
WHERE
  id = registro.id;

-- Puedes realizar otras operaciones aquí usando el valor de nit_cliente_result
END LOOP;

END $ $ LANGUAGE 'plpgsql';

-- Column: columna
-- ALTER TABLE estado DROP COLUMN columna;
ALTER TABLE
  estado
ADD
  COLUMN consulta boolean;

-- Column: subcategoria
-- ALTER TABLE categoria DROP COLUMN subcategoria;
ALTER TABLE
  categoria
ADD
  COLUMN subcategoria boolean;

CREATE TABLE tipo_empresa (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR(50)
);

INSERT INTO
  tipo_empresa(nombre)
VALUES
  ('Bares y restaurantes   ');

INSERT INTO
  tipo_empresa(nombre)
VALUES
  ('Comercio al por menor   ');

  -- Column: fk_tipo_empresa

-- ALTER TABLE empresa DROP COLUMN fk_tipo_empresa;

ALTER TABLE empresa ADD COLUMN fk_tipo_empresa integer;

-- Foreign Key: fk_tipo_empresa
-- ALTER TABLE empresa DROP CONSTRAINT fk_tipo_empresa;
ALTER TABLE
  empresa
ADD
  CONSTRAINT fk_tipo_empresa FOREIGN KEY (fk_tipo_empresa) REFERENCES tipo_empresa (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;

UPDATE
  empresa
set
  fk_tipo_empresa = 1;


  -- Column: borrar_remisiones

-- ALTER TABLE configuracion_pedido DROP COLUMN borrar_remisiones;

ALTER TABLE configuracion_pedido ADD COLUMN borrar_remisiones boolean;

update configuracion_pedido set borrar_remisiones='true';

-- Column: id_pedido

-- ALTER TABLE kardex DROP COLUMN id_pedido;

ALTER TABLE kardex ADD COLUMN id_pedido integer;

-- Constraint: id_pedido

-- ALTER TABLE kardex DROP CONSTRAINT id_pedido;

ALTER TABLE kardex
  ADD CONSTRAINT id_pedido UNIQUE(id_pedido);


  -- Column: id_pedido

-- ALTER TABLE pagos DROP COLUMN id_pedido;

ALTER TABLE pagos ADD COLUMN id_pedido integer;


-- Column: descripcion

-- ALTER TABLE regimen DROP COLUMN descripcion;

ALTER TABLE regimen ADD COLUMN descripcion character varying(100);
update regimen set descripcion ='RESPONSABLE DE IVA'  where idregimen= 1;
update regimen set descripcion ='NO RESPONSABLE DE IVA'  where idregimen= 2;

-- Column: partir_comanda

-- ALTER TABLE configuracion_pedido DROP COLUMN partir_comanda;

alter table configuracion_pedido add column partir_comanda boolean;

update configuracion_pedido set partir_comanda='true'