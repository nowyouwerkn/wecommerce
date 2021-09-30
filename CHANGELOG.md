# Changelog

Todos los cambios notables para `wecommerce` serán documentados en este archivo

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
