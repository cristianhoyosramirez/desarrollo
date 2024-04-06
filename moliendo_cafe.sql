-- Column: sub_categoria

-- ALTER TABLE configuracion_pedido DROP COLUMN sub_categoria;

ALTER TABLE configuracion_pedido ADD COLUMN sub_categoria boolean;
ALTER TABLE configuracion_pedido ALTER COLUMN sub_categoria SET DEFAULT false;

update configuracion_pedido set sub_categoria='false';


CREATE TABLE producto_catego_sub
(
  id serial NOT NULL,
  id_categoria character varying(255),
  id_sub_categoria integer,
  CONSTRAINT pk_producto_categoria PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE producto_catego_sub
  OWNER TO postgres;


  -- Column: saldo

-- ALTER TABLE pagos DROP COLUMN saldo;

ALTER TABLE pagos ADD COLUMN saldo integer;


-- Column: valor_ico

-- ALTER TABLE kardex DROP COLUMN valor_ico;

ALTER TABLE kardex ADD COLUMN valor_ico integer;


-- Column: valor_iva

-- ALTER TABLE kardex DROP COLUMN valor_iva;

ALTER TABLE kardex ADD COLUMN valor_iva integer;


alter table kardex add column aplica_ico boolean;

--Adicionar la columna id_apertura en la tabla configuracion_pedido
--18 de Diciembre de 2023
CREATE SEQUENCE consecutivo_informe_numero_seq;

ALTER TABLE consecutivo_informe
ALTER COLUMN numero
SET DEFAULT nextval('consecutivo_informe_numero_seq'::regclass);

ALTER TABLE consecutivo_informe
ALTER COLUMN numero
SET DEFAULT nextval('consecutivo_informe_numero_seq'::regclass);

ALTER SEQUENCE consecutivo_informe_numero_seq RESTART WITH 213;


-- DROP TABLE sub_categoria;

CREATE TABLE sub_categoria
(
  id serial NOT NULL,
  nombre character varying(50),
  id_categoria integer,
  CONSTRAINT pk_sub_categoria PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE sub_categoria
  OWNER TO postgres;

