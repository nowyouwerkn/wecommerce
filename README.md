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

* PHP: `^7.2\|^8.0`
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

Limpia el caché de tu configuración
```
php artisan optimize:clear
#o
php artisan config:clear
```

El sistema necesita utilizar la ruta "/" que está utilizada por Laravel como vista de ejemplo. Accede al documento routes.php de tu proyecto de Laravel y comenta o borra la ruta predeterminada que esté en el sistema.

Al realizarlo puedes usar 
```
php artisan serve
```
para prender tu servidor y acceder a /instalador para comenzar la instalación.

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
