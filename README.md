[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]

<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/nowyouwerkn/wecommerce">
    <img src="images/logo.png" alt="Logo" width="260">
  </a>

  <h3 align="center">WeCommerce</h3>

  <p align="center">
    La plataforma autoadministrable de E-commerce de Werkn
    <br />
    <a href="https://github.com/nowyouwerkn/wecommerce"><strong>Lee la documentación »</strong></a>
    <br />
    <br />
    <a href="https://github.com/nowyouwerkn/wecommerce/issues">Reportar Problema</a>
    ·
    <a href="https://github.com/nowyouwerkn/wecommerce/issues">Solicitar Funcionalidad</a>
  </p>
</p>


<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary><h5 style="display: inline-block">Indice de Contenido</h5></summary>
  <ol>
    <li>
      <a href="#acerca-del-proyecto">Acerca del Proyecto</a>
      <ul>
        <li><a href="#tecnologías">Tecnologías</a></li>
      </ul>
    </li>
    <li>
      <a href="#comenzado">Comenzando</a>
      <ul>
        <li><a href="#pre-requisitos">Pre-requisitos</a></li>
        <li><a href="#instalación">Instalación</a></li>
      </ul>
    </li>
    <li><a href="#uso">Uso</a></li>
    <li><a href="#personalizar">Personalizar</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contirbuir</a></li>
    <li><a href="#licencia">Licencia</a></li>
    <li><a href="#contacto">Contacto</a></li>
    <li><a href="#agradecimientos">Agradecimientos</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->
## Acerca del Proyecto

[![Product Name Screen Shot][product-screenshot]](https://werkn.mx/wecommerce)

### Tecnologías

* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)
* [Laravel](https://laravel.com)

<!-- GETTING STARTED -->
## Comenzando

### Pre-requisitos

* PHP: `^7.4\|^8.0`
* Laravel: `8.*`

### Instalación

Para comenzar a usar este paquete debes usar el siguiente comando para agregarlo a tu instalación de Laravel.
```
composer require nowyouwerkn/wecommerce
```

Es necesario agregar proveedores al proyecto para poder utilizar todas las funciones de las librerias utilizadas por el paquete. Esto se agrega en el archivo `config/app.php` 

```
'providers' => [
    // ...
    Nowyouwerkn\WeCommerce\WeCommerceServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
];

'aliases' => [
    // ...
    'Image' => Intervention\Image\Facades\Image::class,
    'Excel' => Maatwebsite\Excel\Facades\Excel::class
];
```

Publica todos los assets del paquete y sus dependencias usando
```
php artisan vendor:publish --provider="Nowyouwerkn\WeCommerce\WeCommerceServiceProvider" --force
```
Para que funcione correctamente el sistema es OBLIGATORIO publicar los archivos de `migrations`, `seeders`, `theme`, `public` y `config`. Puedes escoger que elemento quieres publicar con las siguientes etiquetas.

Etiquetas de elementos publicables:

* --tag=theme
* --tag=error-views
* --tag=translations
* --tag=public
* --tag=config
* --tag=migrations
* --tag=seeders

Limpia el caché de tu configuración
```
php artisan optimize:clear
#o
php artisan config:clear
```

El sistema necesita utilizar la ruta "/" que usa Laravel como vista de ejemplo en las rutas. Accede al documento `web.php` de tu proyecto de Laravel y sobreescribe la información con el archivo que se encuentra aqui: `https://github.com/nowyouwerkn/wecommerce/blob/main/src/routes.php`. Al realizarlo podrás usar.
```
php artisan serve
```
para prender tu servidor y acceder a `/instalador` para comenzar la instalación. Si estás usando Homestead no es necesario usar `php artisan serve`.

Si prefieres preparar manualmente el proyecto sigue los siguientes comandos.

```
php artisan migrate
php artisan db:seed
```


### Modificaciones necesarias a Laravel

1. Cambiar en el archivo RouteServiceProvider la ruta de redirección a:
```
public const HOME = '/profile';
```

2. Sobreescribir el archivo routes.php de tu proyecto de laravel con el archivo routes del repositorio.
```
Ruta:
https://github.com/nowyouwerkn/wecommerce/blob/main/src/routes.php
```

3. En tu archivo `app.php` dentro de la carpeta `config` sobreescribe la información de zona horaria con lo siguiente:
```
'timezone' => 'America/Mexico_City',
```

4. (OPCIONAL) Si quieres usar las traducciones en español debes sobreescribir tu objeto `locale` de tu archivo `app.php` dentro de la carpeta `config` con lo siguiente. Si publicaste los archivos del paquete correctamente el sistema automáticamente usará la traducción:
```
'locale' => 'es',
```
<!-- USAGE EXAMPLES -->
## Uso
El paquete publica automáticamente las vistas de front que verán los compradores asi como todos los estilos relacionados a su funcionamiento. Puedes editar las vistas de front que se encuentran en `resources/views/front/theme/werkn-backbone`.

Estructura:
* :open_file_folder: theme
  * :open_file_folder: werkn-backbone
    * :open_file_folder: layouts
      * :open_file_folder: partials
        * _messages.blade.php
        * _modal_messages.blade.php
      * _filter_sidebar.blade.php
      * _product_card.blade.php
      * footer.blade.php
      * header.blade.php
      * main.blade.php
      * nav-user.blade.php
    * :open_file_folder: search
      * general_query.blade.php
    * :open_file_folder: user_profile
      * account.blade.php
      * address.blade.php
      * profile.blade.php
      * shopping.blade.php
      * wishlist.blade.php
    * auth.blade.php
    * cart.blade.php
    * catalog.blade.php
    * catalog_filter.blade.php
    * checkout.blade.php
    * detail.blade.php
    * index.blade.php :house:


Para hacer cambios en los estilos puedes modificar libremente el archivo `main.blade.php` dentro de `layouts` para modificar o eliminar los archivos originales de la plantilla. Para sobreescribir los preexistentes recomendamos hacer todo dentro de la carpeta `css` en el archivo `w-custom.css`


<!-- ROADMAP -->
## Roadmap

Revisa los [tickets abiertos](https://github.com/nowyouwerkn/wecommerce/issues) para una lista estructurada de las funcionalidades propuestas y problemas conocidos en producción.

<!-- LICENCE -->
## Licencia

MIT License

Copyright (c) [2021] [Werkn S.A de C.V]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

<!-- CONTACT -->
## Contacto

Werkn S.A de C.V - [@nowyouwerkn](https://instagram.com/nowyouwerkn) - hey@werkn.mx
Link de Proyecto: [https://github.com/nowyouwerkn/wecommerce](https://github.com/nowyouwerkn/wecommerce)


<!-- ACKNOWLEDGEMENTS -->
## Agradecimientos
* [GitHub Emoji Cheat Sheet](https://www.webpagefx.com/tools/emoji-cheat-sheet)
* [Img Shields](https://shields.io)
* [Choose an Open Source License](https://choosealicense.com)
* [Font Awesome](https://fontawesome.com)


<!-- MARKDOWN LINKS & IMAGES -->
[forks-shield]:   https://img.shields.io/github/forks/nowyouwerkn/wecommerce
[forks-url]: https://github.com/nowyouwerkn/wecommerce/network/members
[stars-shield]: https://img.shields.io/github/stars/nowyouwerkn/wecommerce
[stars-url]: https://github.com/nowyouwerkn/wecommerce/stargazers
[issues-shield]: hhttps://img.shields.io/github/issues/nowyouwerkn/wecommerce
[issues-url]: https://github.com/nowyouwerkn/wecommerce/issues
[product-screenshot]: images/screenshot.png
