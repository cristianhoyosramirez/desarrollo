UPDATE kardex
SET id_estado = 8
WHERE id_estado IS NULL;



INSERT INTO mesas(nombre, estado, valor_pedido, fk_usuario)VALUES ( 'VENTAS DE MOSTRADOR', 1, 0, 6);


INSERT INTO tipo_empresa(nombre)VALUES ('Comercio al por menor con edicion de precios');


ALTER TABLE configuracion_pedido ADD COLUMN requiere_mesa boolean;
ALTER TABLE configuracion_pedido ALTER COLUMN requiere_mesa SET DEFAULT true;


-- Column: encabezado_factura

-- ALTER TABLE configuracion_pedido DROP COLUMN encabezado_factura;

ALTER TABLE configuracion_pedido ADD COLUMN encabezado_factura character varying(399);

-- Column: pie_factura

-- ALTER TABLE configuracion_pedido DROP COLUMN pie_factura;

ALTER TABLE configuracion_pedido ADD COLUMN pie_factura character varying(399);



ALTER TABLE producto ADD COLUMN favorito boolean;
ALTER TABLE producto ALTER COLUMN favorito SET DEFAULT false;
--productos favoritos en comanda 
alter table configuracion_pedido add column producto_favoroitos boolean default 'FALSE';

UPDATE configuracion_pedido set requiere_mesa='true';
