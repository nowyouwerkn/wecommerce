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
    La plataforma autoadministrable de E-commerce de Werken
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
        <li><a href="#Configuración de Servidor">Configurando Servidor</a></li>
        <li><a href="#instalación">Instalación</a></li>
      </ul>
    </li>
    <li><a href="#uso">Uso</a></li>
    <ul>
      <li><a href="#Eventos de Facebook">Configurando Eventos de Facebook</a></li>
    </ul>
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

* PHP: `^7.4\|^8.0`
* Laravel: `8.*`
* MySQL: `^7.4`

<!-- GETTING STARTED -->
## Comenzando

### Pre-requisitos

Requerimientos mínimos de servidor:
* 1 CPU (Doble Nucleo)
* 1GB RAM
* 25GB SSD
* 1 TB Transferencia

Requerimientos recomendados de servidor:
* 1 CPU (Doble Nucleo)
* 2GB RAM
* 25 GB SSD
* 2 TB Transferencia

La configuración recomendada es LAMP Stack.

* Ubuntu - 18.04
* Apache2 - 2.4.29
* MySQL server 5.7.23
* PHP - 7.2
* Fail2ban - 0.10.2
* Postfix - 3.3.0
* Certbot - 0.26.1
* Phpmyadmin (OPCIONAL)

Tambien es posible implementar la plataforma en un Stack LEMP

* Ubuntu - 18.04
* Nginx - 1.14.0
* MySQL server 5.7.23
* PHP - 7.2
* Fail2ban - 0.10.2
* Postfix - 3.3.0
* Certbot - 0.26.1
* Phpmyadmin (OPCIONAL)

Las instrucciones de instalación se enfocarán en Apache 2, si se implementa en Nginx hacer modificaciones en donde sea necesario.

### Configuración de Servidor

#### Instalar Git, Unzip.

```
sudo apt-get install git
sudo apt-get install unzip

```

#### Instalar CURL + Composer

```
sudo apt-get install curl php8.0-curl php8.0-xml php8.0-gd php8.0-opcache php8.0-mbstring php8.0-zip php7.4-curl php7.4-xml php7.4-gd php7.4-opcache php7.4-mbstring php7.4-zip

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### Habilitar Mods

```
sudo phpenmod mbstring
sudo a2enmod rewrite
sudo systemctl restart apache2

```

#### Git CLONE del Proyecto en carpeta HTML

```
cd /var/www/html
git clone [RUTA DEL PROYECTO]
```

#### Habilitar Rewrite para la carpeta

```
sudo chmod -R 777 [NOMBRE_DE_LA_CARPETA]

```

#### Entrar en carpeta de proyecto

```
cd /[NOMBRE_DE_LA_CARPETA]
```

#### Actualizar carpeta con COMPOSER 

```
composer update
```

#### Crear una Llave de Encriptación

```
cp .env.example .env
php artisan key:generate
```
Es importante abrir el archivo .env para configurar la conexión a la base de datos si es que se requiere.

#### Configurar Directorio de Proyecto

/etc/apache2/sites-available/default.com.conf 

```
<VirtualHost *:80>
	ServerName [RUTA].com
	DocumentRoot /var/www/html/[[ NOMBRE_DE_LA_CARPETA ]]/public

	<Directory /var/www/html/[[ NOMBRE_DE_LA_CARPETA ]]/public>
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
```
Si es necesario utilizar un certificado de seguridad utilizar el puerto 443 y activar las capacidades SSL del servidor por medio de la linea de comandos. Es importante que el certificado se encuentre en la ruta correcta que se determina en ese documento.

#### Reiniciar Servidor

```
service apache2 reload

```

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
    App\Providers\FortifyServiceProvider::class,
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

* --tag=werkn-bootstrap (Tema principal)
* --tag=error-views
* --tag=translations
* --tag=public
* --tag=config
* --tag=seeders

Recomendamos correr la publicación automáticamente pero puedes seleccionar que es lo que necesitas. Principalmente los temas.

<strong>IMPORTANTE: </strong> El sistema utiliza Fortify para Autenticar usuarios asi que es importante publicar tambien los recursos de fortify con el siguiente comando:

```
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
```
Esto creará una carpeta llamada `Actions` dentro de `app`. En esta carpeta se encuentran los archivos de autenticación de Fortify. Si no has eliminado o editado tu archivo `User` dentro de tu carpeta de Modelos no necesitas hacer más, en caso contrario para que funcione con WeCommerce tendrás que editar el archivo `CreateNewUser` cambiando lo siguiente:

```
use App\Models\User;

cambiar por...

use Nowyouwerkn\WeCommerce\Models\User;
```

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

2. En tu archivo `app.php` dentro de la carpeta `config` sobreescribe la información de zona horaria con lo siguiente:
```
'timezone' => 'America/Mexico_City',
```

3. (OPCIONAL) Si quieres usar las traducciones en español debes sobreescribir tu objeto `locale` de tu archivo `app.php` dentro de la carpeta `config` con lo siguiente. Si publicaste los archivos del paquete correctamente el sistema automáticamente usará la traducción:
```
'locale' => 'es',
```
<!-- USAGE EXAMPLES -->
## Uso
El paquete publica automáticamente las vistas de front que verán los compradores asi como todos los estilos relacionados a su funcionamiento. Puedes editar las vistas de front que se encuentran en `resources/views/front/theme/werkn-backbone-bootstrap`.

Estructura:
* :open_file_folder: theme
  * :open_file_folder: werkn-backbone-bootstrap
    * :open_file_folder: auth
      * login.blade.php
      * register.blade.php
      * forgot-password.blade.php
      * reset-password.blade.php
    * :open_file_folder: checkout
      * :open_file_folder: utilities
        * _order_address.blade.php
        * _order_address.blade.php
        * _order_contact.blade.php
        * _order_payment.blade.php
        * _order_shipping.blade.php
        * _order_summary.blade.php
      * index.blade.php
    * :open_file_folder: layouts
      * :open_file_folder: checkout
        * footer.blade.php
        * header.blade.php
        * main.blade.php
      * :open_file_folder: partials
        * _cookies_notice_.blade.php
        * _headerbands.blade.php
        * _messages_errors.blade.php
        * _messages.blade.php
        * _modal_messages.blade.php
        * _modal_popup.blade.php
        * _werkn_bar_.blade.php
      * :open_file_folder: utilities
        * _cart_item_.blade.php
        * _filter_sidebar_.blade.php
        * _order_card_.blade.php
        * _product_card_.blade.php
      * _filter_sidebar.blade.php
      * footer.blade.php
      * header.blade.php
      * main.blade.php
      * nav-user.blade.php
    * :open_file_folder: search
      * element.blade.php
      * index.blade.php
      * query.blade.php
    * :open_file_folder: user_profile
      * account.blade.php
      * address.blade.php
      * edit_address.blade.php
      * image.blade.php
      * profile.blade.php
      * shopping.blade.php
      * wishlist.blade.php
    * cart.blade.php
    * catalog.blade.php
    * catalog_filter.blade.php
    * detail.blade.php
    * faqs.blade.php
    * legal.blade.php
    * order_tracking.blade.php
    * purchase_complete.blade.php
    * index.blade.php :house:

### Eventos de Facebook
La plataforma esta preparada para recibir eventos de Facebook integrando el código de pixel desde `Integraciones del Sistema` en la sección de `Preferencias Generales` de la configuración, asi como la conexión con la API de Conversiones de Facebook.

Los eventos que el sistema monitorea son:
* PageView
* ViewContent
* Search
* Purchase
* InitiateCheckout
* Contact
* AddToWishlist
* AddToCart
* AddPaymentInfo

Para activar el evento <strong>Contact</strong> agrega la clase `contact_action` a los links que ejecuten una acción de contacto. (mailto, tel, chat, etc.)

## Personalizar

Para hacer cambios en los estilos puedes modificar libremente el archivo `main.blade.php` dentro de `layouts` para modificar o eliminar los archivos originales de la plantilla. Para sobreescribir los preexistentes recomendamos hacer todo dentro de la carpeta `css` en el archivo `w-custom.css`

Si prefieres crear un nuevo tema que no se sobreescriba al actualizar puedes copiar y pegar la carpeta `werkn-backbone-bootstrap` y ponerle el nombre de tu proyecto. Siguiendo la estructura de la sección anterior el controlador `FrontController` vinculará automaticamente las vistas a la carpeta dentro de `theme`. <strong>Este cambio de estilo se debe configurar en el panel administrativo en Configuración > Apariencia y dar de alta el nombre de la carpeta.</strong>

<strong>Recomendación:</strong> Para mantener limpio el proyecto para facilitar su actualización a futuro lo mejor es colocar los estilos básicos de tu nuevo tema dentro de la carpeta public > themes > [NOMBRE DE TU TEMA]. Los estilos particulares los puedes encontrar en la carpeta css.

Estructura de carpeta theme

* :open_file_folder: themes
  * werkn-backbone-bootstrap
    * [...]
  * [TU PROYECTO]

Estructura de carpeta css:

* :open_file_folder: css
  * w-custom.css (Estilos particulares globales)
  * w-checkout.css (Para personalizar tu checkout)

<!-- ROADMAP -->
## Roadmap

Revisa los [tickets abiertos](https://github.com/nowyouwerkn/wecommerce/issues) para una lista estructurada de las funcionalidades propuestas y problemas conocidos en producción.

<!-- LICENCE -->
## Licencia

MIT License

Copyright (c) [2022] [Werken S.A de C.V]

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