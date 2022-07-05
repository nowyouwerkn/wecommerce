# Changelog

Todos los cambios notables para `wecommerce` serán documentados en este archivo

## 1.6.1 - 2022-06-26
- Cambio de pantalla Vista General
- Se agrega un listado especial en sección de "Canales de Venta"
- Nuevos indicadores para ofrecer más claridad entre diferencias de ingreso por semana y promedios de ordenes semanales.
- Nuevo indicador de estátus de orden con mayor claridad. Estilo de iconos identicos a los del listado de ordenes para relacionarlo visualmente y en color.

## 1.6 - 2022-06-20
- Funcionalidad de opciones de envio múltiples que permite recolección en tienda.
- Cambios en cálculo de impuestos, ahora las configuraciones de impuestos son globales dependiento del país de configuración.
- Cambios visuales en pantallas del back.

## 1.5 - 2022-02-22
- Funcionalidad de solicitud de factura
- Cambios en responsivo para el checkout
- Nueva función de "Historial de Recomendaciones" que ofrece sugerencias de producto de acuerdo a lo que el usuario ha visto en la página
- Completado automático en el checkout para las direcciones de acuerdo al código postal.
- Funcionalidad de relaciones y colores para los productos

## 1.4.3 - 2022-01-04
- Ya está disponible la opción de activar y desactivar los métodos de pago de Mercado Pago. 
- Se Agrega la funcionalidad de activar y desactivar el modo sandbox para las pasarelas de pago.
- Se añade un botón para activar y desactivar el  método de pago.
- Se permite elegir la estructura del banner para alinear y acomodar los textos.
- Ya está disponible la opción de elegir un color para los textos y botones presentes en el banner. 
- La sección de banners ahora acepta la inclusión de videos (Desde Youtube).
- En el listado de Subcategorías, se generó un contador de productos diferentes en cada subcategoría. 
- Ya se cuenta con un sistema de prioridad, para determinar el orden en las colecciones. En caso de que dos elementos tengan el mismo número de prioridad, se determinará cuál procederá primero por orden de creación. 
- Al dar clic en el listado de subcategorías, se abrirá una vista de detalle con el listado de productos vinculados. 
- Se validarán los requisitos para aplicar un cupón. Si no se cumplen dichos requerimientos, no se permitirá el uso del cupón. 
- El check out ahora es responsivo. 
- Cuando se compre como invitado, si ya se tiene una cuenta se manda un mensaje especificando que el correo ya se encuentra ocupado. 
- El cliente ahora tiene la opción de usar una casilla de verificación en caso de que la dirección en envío y la dirección de facturación sean la misma. 
- Ahora se cuenta con sistema de múltiples direcciones para preseleccionar en el check out. 
- Se agrega la funcionalidad de orden y filtrado para el listado de clientes. 
- Ahora se guarda el historial de cambios a los productos. 
- Se puede agregar una vista personalizada a los productos que tienen descuento, para poder filtrar los objetos más eficazmente. 
- El inventario ahora cuenta con un sistema de orden y filtrado.
- El inventario ahora cuenta con sistema de búsqueda específico. 
- Barra de búsqueda específica para productos y características. 
- La sección de productos ahora cuenta con un sistema de orden y filtrado.
- Expansión para permitir calificar los productos mediante estrellas. 
- Se Agrega campo de EAN/UPC a la creación de variantes. (Adaptación para ligar a otras tiendas).
- Ya está disponible la función de “reglas especiales” para envíos. 
- Ya está disponible la función de “opciones de envío” .
- Se implementó un sistema histórico de cambios para guardar los cambios realizados por los usuarios por módulo. 
- Correos de notificación para varios procesos. 
- Se guarda ahora el historial de las órdenes.  
- Ahora se indica en la orden, el cupón que el cliente empleó a la hora de hacer su pedido.
- El listado de órdenes ahora cuenta con sistema de filtrado y búsqueda. 
- CLAB de catálogo de guías de tallas categorizadas por colección. (Se puede crear un tipo de guía de talla que aplique la colección de zapatos o de playeras respectivamente).
- Se genera la opción de subir guía de tallas de acuerdo con las colecciones. 
- Ahora las plataformas cuentan con sección de preguntas frecuentes.

## 1.4.1 - 2021-11-12

### Agregado
- Ahora es posible activar modo Sandbox en metodos de pago y guardar llaves de sandbox.
- Se agregaron botones de filtro, y barra de busqueda en inventario y productos.
- Ahora es posible desactivar metodos de pago individualmente.
- Modificaciones generales en varios modulos del sistema.
- Modificaciones en el modulo de pop-ups.
- Modificaciones para reglas especiales de envio y su validacion en el checkout.
- Seccion de preguntas frecuentes agregada.
- Ahora se pueden crear nuevos textos legales y editar los titulos.
- Ajustes del template werkn-backbone-bootstrap

## 1.4 - 2021-11-09

### Agregado
- Ahora es posible agregar MercadoPago como nueva opción de pago en el checkout.
- Modificaciones generales en varios modulos del sistema.
- Nuevo indicador de estado de ordenes en la vista general.

## 1.3.1 - 2021-10-27

### Agregado
- Se optimizaron todas las peticiones al usuario en los controladores FrontController y los respectivos en el panel de administración. Esto mejoró el rendimiento del sitio por varios segundos.
- Nueva plantilla basada completamente en Bootstrap para usar como base de proyecto.
- Nuevos estilos para plantilla bootstrap

### Eliminado
- Estructura de Checkout anterior a la actualización 1.3
- Archivos de estilos y funcionalidad de checkout anterior a la versión 1.3

## 1.3 - 2021-10-21

### Agregado
- Cambio mayor a estructura de Checkout.
- Reducción de archivos de checkout simplificando la estructura.
- Las opciones de métodos de pago en la vista de carrito y el menú desplegable de carrito se simplifican a un solo botón, dejando la selección de los metodos de pago en la sección de checkout.
- Revisión de eventos de Facebook en la pantalla de "Compra Exitosa"

### Reparado
- Se validan más a profundidad los cupones al usarse en conjunto con las reglas de envios especiales.
- Se repararon los validadores de existencia en el módulo de Carrito. Ahora no es posible agregar más productos a tu carrito de lo que hay disponible.

## 1.2.2 - 2021-10-19

### Agregado
- Nueva tarjeta de estadísticas de venta por semanas en la vista principal del Dashboard.
- Nueva tarjeta de conteo de inventario en la vista principal del Dashboard.

## 1.2.1 - 2021-10-12

### Agregado
- Nueva funcionalidad de "Reglas especiales de envios" en la sección de envios. Esto permite colocar promociones para la compra final del cliente que correspondan al costo del envio. Funciona en conjuto con cupones si se requiere.

### Reparado
- Algunas observaciones de ortografía

## 1.2 - 2021-09-22

### Agregado
- Módulo Pop-Up, una extensión opcional que permite mostrar pop-ups informativos a los usuarios.
- Se agrega la leyenda "Estos son los terminos y condiciones que aceptaste al completar tu compra" a las plantillas de correo.
- Ahora se puede ver el detalle de variantes que muestra un listado con los productos relacionados.
- Ahora se puede Imprimir una lista de empaque en tamaño carta para las ordenes realizadas.
- Funcionalidad de seguimiento de orden por medio del numero de orden y el correo de compra desde el Front sin necesidad de hacer login.
- Cambió el formato de exportación de las ordenes y clientes. Ahora las ordenes muestran su información de carrito y del comprador de una forma más sencilla.

### Reparado
- Los pagos procesados por Stripe y Openpay ahora regresan el mensaje de error al checkout cuando se encontraba una excepción.
- Cuando la sesión caduca, el programa manda un mensaje de error en las peticiones asíncronas de AJAX

## 1.1 - 2021-09-14

### Agregado
- Nuevas opciones de configuración para catálogo facilitando la conexión para venta en Facebook e Instagram.

### Reparado
- Algunos eventos de la API de Conversiones de Facebook eran identificados como "duplicados", se resolvió en esta versión.


## 1.0.8 - 2021-09-08

### Agregado
- Nuevas funcionalidades de eventos de pixel de Facebook en diferentes vistas.
- Funcionalidad de seguimiento de eventos de Facebook con la API de Conversiones. (Requiere Token e Identificador de Pixel proporcionados por Facebook).


## 1.0.7 - 2021-09-02

### Agregado
- Indicadores contadores en la barra lateral para órdenes nuevas y reseñas por aprobar.

### Reparado
- Revisión de ortografía general del panel administrativo.


## 1.0.6 - 2021-08-19

### Agregado
- Funcionalidad para cambiar estado de banner a Activado o Desactivado permitiendo mostrar múltiples banners en la vista principal.

### Reparado
- Cambio de orden a cancelado ahora es funcional.
- Funcionalidad de borrado de banners
- Funcionalidad de editar banner.


## 1.0.5 - 2021-08-19

### Agregado
- Funcionalidad para cambiar estado de orden desde el listado general de ordenes.
- Cambio de diseño en etiquetas de estado e identificador de pago en detalle de orden para simplificar visualmente la vista.
- Cambios de diseño en los correos de notificación que se envian desde el sistema.
- Filtros indicadores en módulo ordenes.
- Sistema de búsqueda y filtrado para listado de ordenes.

### Reparado
- Listado de cupones cambiado para ser más descriptivo con las fechas de expiración de los cupones.
- Detalles de ortografía en plataforma autoadministrable.


## 1.0.4 - 2021-08-09

### Agregado
- Módulo de Variantes. Se permite ahora visualizar y borrar las variantes que se han creado en el sistema.
- Información de Metodo de pago para las órdenes. Esta información se puede visualizar en la tabla de ordenes del panel administrativo y en el listado de ordenes del perfil del cliente.

### Reparado
- Funcionalidad de filtrado de catálogo ahora funciona correctamente. Toma en cuenta todas las variantes y las filtra de acuerdo a la selección.
- Problema de integridad de base de datos al borrar cupones solucionado.
- Las pantallas de error no mostraban la estructura de apariencia correcta. Solucionado.


## 1.0.3 - 2021-07-14

### Agregado
- Sistema de Búsqueda General en el panel administrativo. Solo se puede buscar por producto.
- Modo Oscuro/Claro configurable por usuario administrativo de forma manual.

## 1.0.2 - 2021-07-14

### Agregado
- Funcionalidad de "Apariencia/Personalizar" para mejorar el uso de plantillas y diseños personalizados en la plataforma.

### Eliminado
- Limpieza de plantilla `werkn-backbone` en varios archivos.

## 1.0.1 - 2021-07-14

### Agregado
- Creación de documentación inicial en `README.md`

## 1.0.0 - 2021-07-08

### Agregado
- Todo, lanzamiento inicial.
