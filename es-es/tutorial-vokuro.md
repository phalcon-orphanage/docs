---
layout: default
language: 'es-es'
version: '5.0'
title: 'Tutorial - Vökuró'
keywords: 'tutorial, tutorial vokuro, paso a paso, mvc, seguridad, permisos'
---

# Tutorial - Vökuró
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg) ![](/assets/images/level-intermediate.svg)

## Vökuró
[Vökuró][github_vokuro] is a sample application, showcasing a typical web application written in Phalcon. This application focuses on:
- User Login (security)
- User Signup (security)
- User Permissions
- User management

> **NOTE**: You can use Vökuró as a starting point for your application and enhance it further to meet your needs. No significa que ésta sea una aplicación perfecta y se ajuste a todas las necesidades. 
> 
> {: .alert .alert-info }

> **NOTE**: This tutorial assumes that you are familiar with the concepts of the Model View Controller design pattern. (see References at the end of this tutorial) 
> 
> {: .alert .alert-warning }

> **NOTE**: Note the code below has been formatted to increase readability 
> 
> {: .alert .alert-warning }

## Instalación
### Descarga
In order to install the application, you can either clone or download it from [GitHub][github_vokuro]. Puede visitar la página de GitHub, descargar la aplicación y luego descomprimirla a un directorio de su máquina. Alternativamente, puede usar `git clone`:

```bash
git clone https://github.com/phalcon/vokuro
```

### Extensiones
Hay algunos prerrequisitos para que Vökuró funcione. You will need to have PHP >= 7.2 installed on your machine and the following extensions:
- ctype
- curl
- dom
- json
- iconv
- mbstring
- memcached
- opcache
- openssl
- pdo
- pdo_mysql
- psr
- session
- simplexml
- xml
- xmlwriter

Se necesita instalar Phalcon. Diríjase a la página [instalación](installation) si necesita ayuda con la instalación de Phalcon. Note that Phalcon v4 requires the PSR extension to be installed and loaded **before** Phalcon. To install PSR you can check the [php-psr][psr] GitHub page.

Finalmente, también necesitará asegurarse que ha actualizado los paquetes de *composer* (ver sección más abajo).

### Ejecutar
Si todos los requerimientos anteriores son satisfechos, puede ejecutar la aplicación usando el servidor web integrado de PHP ejecutando el siguiente comando en un terminal:

```bash
php -S localhost:8080 -t public/ .htrouter.php
```

El comando anterior empezará a servir el sitio para `localhost` en el puerto `8080`. Puede cambiar estos ajustes para que cumplan sus necesidades. Alternativamente, puede configurar su sitio en Apache o nginX usando un *virtual host*. Por favor, consulte la documentación correspondiente de cómo configurar un *virtual host* para estos servidores web.

### Docker
En la carpeta `resources` encontrará un `Dockerfile` que le permite configurar rápidamente el entorno y ejecutar la aplicación. Para usar el `Dockerfile` necesitamos decidir el nombre de nuestra aplicación dockerizada. Para los propósitos de este tutorial, usaremos `phalcon-tutorial-vokuro`.

Desde la raíz de la aplicación necesitamos compilar el proyecto (sólo necesita hacer esto una vez):

```bash
$ docker build -t phalcon-tutorial-vokuro -f docker/Dockerfile .
```

y ejecutarla

```bash
$ docker run -it --rm phalcon-tutorial-vokuro bash
```

Esto nos introducirá en el entorno dockerizado. Para comprobar la versión PHP:

```bash
root@c7b43060b115:/code $ php -v

PHP 7.3.9 (cli) (built: Sep 12 2019 10:08:33) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.9, Copyright (c) 1998-2018 Zend Technologies
    with Zend OPcache v7.3.9, Copyright (c) 1999-2018, by Zend Technologies
```

y Phalcon:

```bash
root@c7b43060b115:/code $ php -r 'echo Phalcon\Version::get();'

4.0.0
```

Ahora tiene un entorno dockerizado con todo los componentes necesarios para ejecutar Vökuró.

### Nanobox
En la carpeta `resources` también encontrará un fichero `boxfile.yml` que le permite usar nanobox para configurar el entorno rápidamente. Todo lo que tiene que hacer es copiar el fichero en la raíz de su directorio y ejecutar `nanobox run php-server`. Una vez que la aplicación está configurada por primera vez, será capaz de navegar a la dirección IP presentada en pantalla y trabajar con la aplicación.

For more information on how to set up nanobox, check our \[Environments Nanobox\]\[environments-nanobox\] page as well as the [Nanobox Guides][nanobox-guides] page

> **NOTE**: In this tutorial, we assume that your application has been downloaded or cloned in a directory called `vokuro`. 
> 
> {: .alert .alert-info }

## Estructura
Buscando en la estructura de la aplicación tenemos lo siguiente:

```bash
vokuro/
    .ci
    configs
    db
        migrations
        seeds
    public
    resources
    src
        Controllers
        Forms
        Models
        Phalcon
        Plugins
        Providers
    tests
    themes
        vokuro
    var
        cache
            acl
            metaData
            session
            volt
        logs
    vendor
```

| Directorio        | Descripción                                                   |
| ----------------- | ------------------------------------------------------------- |
| `.ci`             | Ficheros necesarios para configurar los servicios del CI      |
| `configs`         | Ficheros de configuración                                     |
| `db`              | Guarda las migraciones de la base de datos                    |
| `public`          | Punto de entrada para la aplicación, css, js, imágenes        |
| `resources`       | Ficheros Docker/nanobox para configurar la aplicación         |
| `src`             | Donde reside la aplicación (controladores, formularios, etc.) |
| `src/Controllers` | Controladores                                                 |
| `src/Forms`       | Formularios                                                   |
| `src/Models`      | Modelos de la Base de Datos                                   |
| `src/Plugins`     | Plugins                                                       |
| `src/Providers`   | Proveedores: configuración de servicios en el contenedor DI   |
| `tests`           | Pruebas                                                       |
| `themes`          | Temas/vistas para una fácil personalización                   |
| `themes/vokuro`   | Tema predeterminado para la aplicación                        |
| `var`             | Varios ficheros de soporte                                    |
| `var/cache`       | Ficheros de caché                                             |
| `var/logs`        | Logs                                                          |
| `vendor`          | Librerías basadas en vendor/composer                          |


## Configuración

### `.env`
[Vökuró][github_vokuro] uses the popular [Dotenv][dotenv] library by Vance Lucas. La librería usa un fichero `.env` ubicado en su carpeta raíz, que contiene parámetros de configuración como el nombre del servidor de base de datos, nombre de usuario, contraseña, etc. Hay un fichero `.env.example` que viene con Vökuró que puede copiar y renombrar a `.env` y luego editarlo para que coincida con su entorno. Necesita hacer esto primero para que su aplicación pueda funcionar correctamente.

Las opciones disponibles son:

| Opción               | Descripción                                                                                                                                                                                                    |
| -------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `APP_CRYPT_SALT`     | Random and long string that is used by the [Phalcon\Crypt](encryption-crypt) component to produce passwords and any additional security features                                                              |
| `APP_BASE_URI`       | Usualmente `/` si su servidor web apunta directamente al directorio Vökuró. Si tiene instalado Vökuró en un subdirectorio, puede ajustar la URI base                                                           |
| `APP_PUBLIC_URL`     | La URL pública de la aplicación. Se usa para los emails.                                                                                                                                                       |
| `DB_ADAPTER`         | El adaptador de base de datos. Los adaptadores disponibles son: `mysql`, `pgsql`, `sqlite`. Por favor, asegúrese de que tiene instaladas en su sistema las extensiones correspondientes para la base de datos. |
| `DB_HOST`            | El servidor de base de datos                                                                                                                                                                                   |
| `DB_PORT`            | El puerto de la base de datos                                                                                                                                                                                  |
| `DB_USERNAME`        | El nombre de usuario de la base de datos                                                                                                                                                                       |
| `DB_PASSWORD`        | La contraseña de la base de datos                                                                                                                                                                              |
| `DB_NAME`            | El nombre de la base de datos                                                                                                                                                                                  |
| `MAIL_FROM_NAME`     | El nombre *DE* al enviar *emails*                                                                                                                                                                              |
| `MAIL_FROM_EMAIL`    | El email *DE* al enviar *emails*                                                                                                                                                                               |
| `MAIL_SMTP_SERVER`   | El servidor SMTP                                                                                                                                                                                               |
| `MAIL_SMTP_PORT`     | El puerto SMTP                                                                                                                                                                                                 |
| `MAIL_SMTP_SECURITY` | La seguridad SMTP (ej. `tls`)                                                                                                                                                                                  |
| `MAIL_SMTP_USERNAME` | El nombre de usuario del SMTP                                                                                                                                                                                  |
| `MAIL_SMTP_PASSWORD` | La contraseña del SMTP                                                                                                                                                                                         |
| `CODECEPTION_URL`    | El servidor Codeception para pruebas. Si ejecuta las pruebas localmente este debería ser `127.0.0.1`                                                                                                           |
| `CODECEPTION_PORT`   | El puerto Codeception                                                                                                                                                                                          |


Una vez que el fichero de configuración está en su lugar, al visitar la dirección IP se presentará en pantalla algo similar a esto:

![](/assets/images/content/tutorial-vokuro-1.png)

### `Base de Datos`
También necesita inicializar la base de datos. [Vökuró][github_vokuro] uses the popular library [Phinx][phinx] by Rob Morgan (now the Cake Foundation). La librería usa su propio fichero de configuración (`phinx.php`), pero para Vökuró no necesita realizar ningún ajuste ya que `phinx.php` lee el fichero `.env` para recuperar los ajustes de configuración. Esto le permite establecer sus parámetros de configuración en un solo lugar.

Ahora necesitaremos ejecutar las migraciones. Para comprobar el estado de nuestra base de datos:

```bash
/app $ ./vendor/bin/phinx status
```

Verá la siguiente pantalla:

![](/assets/images/content/tutorial-vokuro-2.png)

Para inicializar la base de datos necesita ejecutar las migraciones:

```bash
/app $ ./vendor/bin/phinx migrate
```

La pantalla mostrará la operación:

![](/assets/images/content/tutorial-vokuro-3.png)

Y el comando `status` ahora mostrará todo verde:

![](/assets/images/content/tutorial-vokuro-4.png)

### Configuración
**acl.php**

Buscando en la carpeta `config/`, observará cuatro ficheros. No hay necesidad de cambiar estos ficheros para iniciar la aplicación, pero si desea personalizarla, éste es el lugar a visitar. The `acl.php` file returns an array of _routes_ that controls which routes are visible to only logged in users.

La configuración actual requerirá que un usuario se conecte, si visita estas rutas:

- `users/index`
- `users/search`
- `users/edit`
- `users/create`
- `users/delete`
- `users/changePassword`
- `profiles/index`
- `profiles/search`
- `profiles/edit`
- `profiles/create`
- `profiles/delete`
- `permissions/index`

Si usa Vökuró como punto de partida para su propia aplicación, necesitará modificar este fichero para añadir o quitar rutas, para asegurarse de que sus rutas protegidas estén detrás del mecanismo de inicio de sesión.

> **NOTE**: Keeping the private routes in an array is efficient and easy to maintain for a small to medium application. Una vez su aplicación empieza a crecer, podría necesitar considerar una técnica diferente para mantener sus rutas privadas como la base de datos con un mecanismo de caché. 
> 
> {: .alert .alert-info }

**config.php**

Este fichero mantiene todos los parámetros de configuración que necesita Vökuró. Usually you will not need to change this file, since the elements of the array are set by the `.env` file and [Dotenv][dotenv]. Sin embargo, podría querer cambiar la localización de sus logs u otras rutas, si decide cambiar la estructura de directorios.

Uno de los elementos que podría querer considerar cuando trabaje con Vökuró en su máquina local es `useMail` y establecerlo a `false`. Esto indicará a Vökuró que no intente conectar a un servidor de correo y enviar un email cuando un usuario se registre en el sitio.

**providers.php**

Este fichero contiene todos los proveedores que necesita Vökuró. Esto es una lista de clases de la aplicación, que registra la clase particular en el contenedor DI. Si necesita registrar nuevos componentes en su contenedor DI, puede añadirlos al vector de este fichero.

**routes.php**

Este fichero contiene las rutas que Vökuró entiende. El enrutador ya registra las rutas predeterminadas, por lo que cualquier ruta definida en `routes.php` es específica. Puede añadir cualquier ruta no estándar que necesite, al personalizar Vökuró, en este fichero. Como recordatorio, las rutas predeterminadas son:

```bash
/:controller/:action/:parameters
```

### Proveedores
Como se ha mencionado antes, Vökuró usa clases llamadas Proveedores para registrar servicios en el contenedor DI. Esto sólo es una forma de registrar servicios en el contenedor DI, nada le impide poner todos estos registros en un solo fichero.

Para Vökuró decidimos usar un fichero por servicio así como un `providers.php` (ver arriba) como vector de configuración de registro para estos servicios. Esto nos permite tener trozos de código mucho más pequeños, organizados en ficheros separados por servicio, así como un vector que nos permite registrar o desregistrar/desactivar un servicio sin eliminar ficheros. Todo lo que necesitamos hacer es cambiar el vector `providers.php`.

Las clases proveedor se encuentran en `src/Providers`. Each of the provider classes implements the [Phalcon\Di\ServiceProviderInterface][di-serviceproviderinterface] interface. Para más información, ver la sección de arranque a continuación.

## Composer
[Vökuró][github_vokuro] uses [composer][composer] to download and install supplemental PHP libraries. Las librerías usadas son:

- [Dotenv][dotenv]
- [Phinx][phinx]
- [Swift Mailer][swiftmailer]

Mirando en `composer.json` los paquetes requeridos son:

```json
"require": {
    "php": ">=7.2",
    "ext-openssl": "*",
    "ext-phalcon": "~4.0.0-beta.2",
    "robmorgan/phinx": "^0.11.1",
    "swiftmailer/swiftmailer": "^5.4",
    "vlucas/phpdotenv": "^3.4"
}
```

Si es una instalación nueva puede ejecutar

```bash
composer install
```

o si desea actualizar las instalaciones existentes de los paquetes anteriores:

```bash
composer update
```

For more information about composer, you can visit their [documentation][composer] page.

## Arranque
### Entrada
El punto de entrada a nuestra aplicación es `public/index.php`. Este fichero contiene el código necesario que inicia la aplicación y la ejecuta. También sirve como punto único de entrada de nuestra aplicación, haciendo las cosas mucho más fáciles para nosotros cuando queremos capturar errores, proteger ficheros, etc.

Veamos el código:

```php
<?php

use Vokuro\Application as VokuroApplication;

error_reporting(E_ALL);
$rootPath = dirname(__DIR__);

try {
    require_once $rootPath . '/vendor/autoload.php';

    /**
     * Load .env configurations
     */
    Dotenv\Dotenv::create($rootPath)->load();

    /**
     * Run Vökuró!
     */
    echo (new VokuroApplication($rootPath))->run();
} catch (Exception $e) {
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
}
```

En primer lugar, nos aseguramos que tenemos el reporte de errores al máximo. Por supuesto, puede cambiar esto si lo desea, o sustituir el código donde se controla el reporte de errores por una entrada en su fichero `.env`.

Un bloque `try`/`catch` envuelve todas las operaciones. Esto asegura que todos los errores sean capturados y mostrados por pantalla.

> **NOTE** You will need to rework the code to enhance security. Actualmente, si ocurre algún error con la base de datos, el código `catch` mostrará en pantalla las credenciales de la base de datos con la excepción. This code is intended as a tutorial not a full scale production application 
> 
> {: .alert .alert-danger }

Nos aseguramos que tenemos acceso a todas las librerías de soporte cargando el autocargador de *composer*. En `composer.json` también tenemos definida la entrada `autoload`, dirigiendo al autocargador a cargar cualquier clase con espacio de nombres `Vokuro` desde la carpeta `src`.

```json
"autoload": {
    "psr-4": {
        "Vokuro\\": "app/"
    },
    "files": [
        "app/Helpers.php"
    ]
}
```

Entonces cargaremos las variables de entorno definidas en nuestro fichero `.env` llamando

```php
Dotenv\Dotenv::create($rootPath)->load();
```

Finalmente, ejecutamos nuestra aplicación.

### Application
Toda la lógica de aplicación está envuelta en la clase `Vokuro\Application`. Veamos como se hace esto:

```php
<?php
declare(strict_types=1);

namespace Vokuro;

use Exception;
use Phalcon\Application\AbstractApplication;
use Phalcon\Di\DiInterface;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Application as MvcApplication;

/**
 * Vökuró Application
 */
class Application
{
    const APPLICATION_PROVIDER = 'bootstrap';

    /**
     * @var AbstractApplication
     */
    protected $app;

    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * Project root path
     *
     * @var string
     */
    protected $rootPath;

    /**
     * @param string $rootPath
     *
     * @throws Exception
     */
    public function __construct(string $rootPath)
    {
        $this->di       = new FactoryDefault();
        $this->app      = $this->createApplication();
        $this->rootPath = $rootPath;

        $this->di->setShared(self::APPLICATION_PROVIDER, $this);

        $this->initializeProviders();
    }

    /**
     * Run Vökuró Application
     *
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        return (string) $this
            ->app
            ->handle($_SERVER['REQUEST_URI'])
            ->getContent()
        ;
    }

    /**
     * Get Project root path
     *
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    /**
     * @return AbstractApplication
     */
    protected function createApplication(): AbstractApplication
    {
        return new MvcApplication($this->di);
    }

    /**
     * @throws Exception
     */
    protected function initializeProviders(): void
    {
        $filename = $this->rootPath 
                 . '/configs/providers.php';
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new Exception(
                'File providers.php does not exist or is not readable.'
            );
        }

        $providers = include_once $filename;
        foreach ($providers as $providerClass) {
            /** @var ServiceProviderInterface $provider */
            $provider = new $providerClass;
            $provider->register($this->di);
        }
    }
}

```

El constructor de la clase crea primero un nuevo contenedor DI y lo almacena en una propiedad local. Estamos usando [Phalcon\Di\FactoryDefault](di), que tiene muchos servicios ya registrados por nosotros.

Entonces creamos un nuevo [Phalcon\Mvc\Application](application) y lo almacenamos también en una propiedad. También almacenamos la ruta raíz porque es útil a lo largo de la aplicación.

Luego registramos est clase (`Vokuro\Application`) en el contenedor Di usando el nombre `bootstrap`. Esto nos permite tener acceso a esta clase desde cualquier parte de nuestra aplicación a través del contenedor Di.

Lo último que hacemos es registrar todos los proveedores. Aunque el objeto [Phalcon\Di\FactoryDefault](di) tiene muchos servicios ya registrados para nosotros, todavía necesitamos registrar proveedores que cubran las necesidades de nuestra aplicación. As mentioned above, each provider class implements the [Phalcon\Di\ServiceProviderInterface][di-serviceproviderinterface] interface, so we can load each class and call the `register()` method with the Di container to register each service. Por lo tanto, primero cargamos el vector de configuración `config/providers.php` y luego iteramos sobre las entradas y registramos cada proveedor por orden.

Los proveedores disponibles son:

| Proveedor                | Descripción                                       |
| ------------------------ | ------------------------------------------------- |
| `AclProvider`            | Permisos                                          |
| `AuthProvider`           | Autenticación                                     |
| `ConfigProvider`         | Valores de configuración                          |
| `CryptProvider`          | Encriptación                                      |
| `DbProvider`             | Acceso a base de datos                            |
| `DispatcherProvider`     | Despachador - qué controlador llamar para qué URL |
| `FlashProvider`          | Mensajes flash para retroalimentar al usuario     |
| `LoggerProvider`         | Registrador de errores y otra información         |
| `MailProvider`           | Soporte de email                                  |
| `ModelsMetadataProvider` | Metadatos para modelos                            |
| `RouterProvider`         | Rutas                                             |
| `SecurityProvider`       | Seguridad                                         |
| `SessionBagProvider`     | Datos de sesión                                   |
| `SessionProvider`        | Datos de sesión                                   |
| `UrlProvider`            | Gestión de URL                                    |
| `ViewProvider`           | Vistas y motor de vistas                          |


`run()` ahora gestionará `REQUEST_URI`, y devolverá el contenido de vuelta. Internamente, la aplicación calculará la ruta basándose en la petición, y despachará el controlador y vista correspondientes, antes de devolver el resultado de esta operación de vuelta al usuario como respuesta.

## Base de Datos
Como hemos mencionado anteriormente, Vökuró se puede instalar con MariaDB/MySQL/Aurora, PostgreSql o SQLite como almacén de base de datos. Para los propósitos de este tutorial, usamos MariaDB. Las tablas que usa la aplicación son:

| Tabla                 | Descripción                               |
| --------------------- | ----------------------------------------- |
| `email_confirmations` | Confirmaciones de email de registro       |
| `failed_logins`       | Intentos de inicio de sesión fallidos     |
| `password_changes`    | Cuando cambia una contraseña y por quién  |
| `permissions`         | Vector de permisos                        |
| `phinxlog`            | Tabla de migraciones de Phinx             |
| `profiles`            | Perfil de cada usuario                    |
| `remember_tokens`     | _Remember Me_ functionality tokens        |
| `reset_passwords`     | Tabla de tokens de reseteo de contraseñas |
| `success_logins`      | Intentos de inicio de sesión correctos    |
| `users`               | Usuarios                                  |

## Modelos
Following the [Model-View-Controller][mvc] pattern, Vökuró has one model per database table (excluding the `phinxlog`). Los modelos nos permiten interactuar con las tablas de la base de datos de una forma orientada a objetos sencilla. Los modelos se localizan en el directorio `/src/Models`, y cada modelo define los campos relevantes, tabla origen así como cualquier relación entre este modelo y los otros. Algunos modelos también implementan reglas de validación para asegurarse que los datos se almacenan correctamente en la base de datos.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * SuccessLogins
 *
 * This model registers successfully logins registered users have made
 */
class SuccessLogins extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $usersId;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     * @var string
     */
    public $userAgent;

    public function initialize()
    {
        $this->belongsTo(
            'usersId', 
            Users::class, 
            'id', 
            [
                'alias' => 'user',
            ]
        );
    }
}
```

En el modelo anterior, hemos definido todos los campos de la tabla como propiedades públicas para un acceso fácil:

```php
echo $successLogin->ipAddress;
```

> **NOTE**: If you notice, the property names map exactly the case (upper/lower) of the field names in the relevant table. 
> 
> {: .alert .alert-warning }

En el método `initialize()`, también definimos las relaciones entre este modelo y el modelo `Users`. Asignamos los campos (local/remoto) así como un `alias` para esta relación. Por lo tanto, ahora podemos acceder al usuario relacionado con un registro de este modelo como sigue:

```php
echo $successLogin->user->name;
```

> **NOTE**: Feel free to open each model file and identify the relationships between the models. Check our documentation for the difference between various types of relationships 
> 
> {: .alert .alert-info }

## Controladores
Again following the [Model-View-Controller][mvc] pattern, Vökuró has one controller to handle a specific _parent_ route. Esto significa que `AboutController` gestiona la ruta `/about`. Todos los controladores se localizan en el directorio `/src/Cotnrollers`.

El controlador predeterminado es `IndexController`. Todas las clases controlador tienen el sufijo `Controller`. Cada controlador tiene métodos con el sufijo `Action` y la acción predeterminada es `indexAction`. Por lo tanto, si visita el sitio con sólo la URL, se llamará `IndexController` y se ejecutará `indexAction`.

Después de eso, a no ser que tenga rutas específicas registradas, las rutas predeterminadas (automáticamente registradas) intentarán encajar:

```bash
/profiles/search
```

a

```bash
/src/Controllers/ProfilesController.php -> searchAction
```

Los controladores, acciones y rutas disponibles para Vökuró son:

| Controlador   | Acción           | Ruta                      | Descripción                               |
| ------------- | ---------------- | ------------------------- | ----------------------------------------- |
| `About`       | `index`          | `/about`                  | Muestra la página `about`                 |
| `Índice`      | `index`          | `/`                       | Acción predeterminada - página de inicio  |
| `Permisos`    | `index`          | `/permissions`            | Ver/cambiar permisos para un nivel perfil |
| `Privacy`     | `index`          | `/privacy`                | Ver la página de privacidad               |
| `Profiles`    | `index`          | `/profiles`               | Ver página predeterminada de perfiles     |
| `Profiles`    | `create`         | `/profiles/create`        | Crear perfil                              |
| `Profiles`    | `delete`         | `/profiles/delete`        | Eliminar perfil                           |
| `Profiles`    | `edit`           | `/profiles/edit`          | Editar perfil                             |
| `Profiles`    | `search`         | `/profiles/search`        | Buscar perfiles                           |
| `Session`     | `index`          | `/session`                | Acción predeterminada de sesión           |
| `Session`     | `forgotPassword` | `/session/forgotPassword` | Ha olvidado la contraseña                 |
| `Session`     | `login`          | `/session/login`          | Inicio de sesión                          |
| `Session`     | `logout`         | `/session/logout`         | Cerrar sesión                             |
| `Session`     | `signup`         | `/session/signup`         | Registro                                  |
| `Terms`       | `index`          | `/terms`                  | Ver la página de términos                 |
| `UserControl` | `confirmEmail`   | `/confirm`                | Confirmar email                           |
| `UserControl` | `resetPassword`  | `/reset-password`         | Resetear contraseña                       |
| `Usuarios`    | `index`          | `/users`                  | Pantalla predeterminada de usuarios       |
| `Usuarios`    | `changePassword` | `/users/changePassword`   | Cambiar contraseña de usuario             |
| `Usuarios`    | `create`         | `/users/create`           | Crear usuario                             |
| `Usuarios`    | `delete`         | `/users/delete`           | Eliminar usuario                          |
| `Usuarios`    | `edit`           | `/users/edit`             | Editar usuario                            |


## Vistas
The last element of the [Model-View-Controller][mvc] pattern is the views. Vökuró usa [Volt](volt) como el motor de vista para sus vistas.

> **NOTE**: Generally, one would expect to see a `views` folder under the `/src` folder. Vökuró usa un enfoque diferente, almacenando todas los ficheros de las vistas bajo `/themes/vokuro`. 
> 
> {: .alert .alert-info }

El directorio de vistas contiene directorios que mapean a cada controlador. Dentro de cada uno de esos directorios, se mapean ficheros `.volt` a cada acción. Así por ejemplo la ruta:

```bash
/profiles/create
```

mapea a:

```bash
ProfilesController -> createAction
```

y la vista se localiza en:

```bash
/themes/vokuro/profiles/create.volt
```

Las vistas disponibles son:

| Controlador | Acción           | Vistas                         | Descripción                               |
| ----------- | ---------------- | ------------------------------ | ----------------------------------------- |
| `About`     | `index`          | `/about/index.volt`            | Muestra la página `about`                 |
| `Índice`    | `index`          | `/index/index.volt`            | Acción predeterminada - página de inicio  |
| `Permisos`  | `index`          | `/permissions/index.volt`      | Ver/cambiar permisos para un nivel perfil |
| `Privacy`   | `index`          | `/privacy/index.volt`          | Ver la página de privacidad               |
| `Profiles`  | `index`          | `/profiles/index.volt`         | Ver página predeterminada de perfiles     |
| `Profiles`  | `create`         | `/profiles/create.volt`        | Crear perfil                              |
| `Profiles`  | `delete`         | `/profiles/delete.volt`        | Eliminar perfil                           |
| `Profiles`  | `edit`           | `/profiles/edit.volt`          | Editar perfil                             |
| `Profiles`  | `search`         | `/profiles/search.volt`        | Buscar perfiles                           |
| `Session`   | `index`          | `/session/index.volt`          | Acción predeterminada de sesión           |
| `Session`   | `forgotPassword` | `/session/forgotPassword.volt` | Ha olvidado la contraseña                 |
| `Session`   | `login`          | `/session/login.volt`          | Inicio de sesión                          |
| `Session`   | `logout`         | `/session/logout.volt`         | Cerrar sesión                             |
| `Session`   | `signup`         | `/session/signup.volt`         | Registro                                  |
| `Terms`     | `index`          | `/terms/index.volt`            | Ver la página de términos                 |
| `Usuarios`  | `index`          | `/users/index.volt`            | Pantalla predeterminada de usuarios       |
| `Usuarios`  | `changePassword` | `/users/changePassword.volt`   | Cambiar contraseña de usuario             |
| `Usuarios`  | `create`         | `/users/create.volt`           | Crear usuario                             |
| `Usuarios`  | `delete`         | `/users/delete.volt`           | Eliminar usuario                          |
| `Usuarios`  | `edit`           | `/users/edit.volt`             | Editar usuario                            |

El fichero `/index.volt` contiene el diseño principal de la página, incluyendo hojas de estilo, referencias javascript, etc. El directorio `/layouts` contiene diferentes diseños que se usan en la aplicación, por ejemplo uno `public` si el usuario no está conectado, y uno `private` para los usuarios conectados. Las vistas individuales se inyectan en los diseños y construyen la página final.

## Components
Hay varios componentes que usamos en Vökuró, ofreciendo funcionalidad a lo largo de la aplicación. Todos estos componentes se localizan en el directorio `/src/Plugins`.

### Acl
`Vokuro\Plugins\Acl\Acl` is a component that implements an [Access Control List][acl] for our application. La ACL controla qué usuario tiene acceso a qué recurso. Puede leer más sobre ACL en nuestra [página dedicada](acl).

In this component, We define the resources that are considered _private_. Estos se mantienen en un vector interno con el controlador como clave y la acción como el valor, e identificamos qué controlador/acción requiere autenticación. Eso también mantiene descripciones legibles para humanos en las acciones usadas a través de la aplicación.

El componente expone los siguientes métodos:

| Método                                      | Devuelve     | Descripción                                                        |
| ------------------------------------------- | ------------ | ------------------------------------------------------------------ |
| `getActionDescription($action)`             | `string`     | Devuelve la descripción de la acción según su nombre simplificado  |
| `getAcl()`                                  | `Objeto ACL` | Devuelve la lista ACL                                              |
| `getPermissions(Profiles $profile)`         | `array`      | Devuelve los permisos asignados a un perfil                        |
| `getResources()`                            | `array`      | Devuelve todos los recursos y sus acciones disponibles             |
| `isAllowed($profile, $controller, $action)` | `bool`       | Comprueba si el perfil actual tiene permitido acceder a un recurso |
| `isPrivate($controllerName)`                | `bool`       | Comprueba si un controlador es privado o no                        |
| `rebuild()`                                 | `Objeto ACL` | Reconstruye la lista de acceso en un fichero                       |

### Auth
`Vokuro\Plugins\Auth\Auth` es un componente que gestiona la autenticación y ofrece gestión de identidad en Vökuró.

El componente expone los siguientes métodos:

| Método                                   | Descripción                                                                            |
| ---------------------------------------- | -------------------------------------------------------------------------------------- |
| `check($credentials)`                    | Comprueba las credenciales de usuario                                                  |
| `saveSuccessLogin($user)`                | Crea la configuración del entorno recuérdame, las cookies relacionadas y genera tokens |
| `registerUserThrottling($userId)`        | Implementa el bloqueo de acceso. Reduce la efectividad de ataques de fuerza bruta      |
| `createRememberEnvironment(Users $user)` | Crea la configuración del entorno recuérdame, las cookies relacionadas y genera tokens |
| `hasRememberMe(): bool`                  | Comprueba si la sesión tiene una cookie recuérdame                                     |
| `loginWithRememberMe(): Response`        | Inicia sesión utilizando la información en las cookies                                 |
| `checkUserFlags(Users $user)`            | Comprueba si el usuario está baneado/inactivo/suspenddo                                |
| `getIdentity(): array / null`            | Devuelve la identidad actual                                                           |
| `getName(): string`                      | Devuelve el nombre del usuario                                                         |
| `remove()`                               | Elimina la información de identidad del usuario de la sesión                           |
| `authUserById($id)`                      | Autentica al usuario por su id                                                         |
| `getUser(): Users`                       | Obtiene la entidad relacionada con el usuario de la identidad activa                   |
| `findFirstByToken($token): int / null`   | Devuelve el usuario del token actual                                                   |
| `deleteToken(int $userId)`               | Elimina el token del usuario actual de la sesión                                       |

### Mail
`Vokuro\Plugins\Mail\Mail` is a wrapper to [Swift Mailer][swiftmailer]. Expone dos métodos `send()` y `getTemplate()` que le permite obtener una plantilla desde las vistas y rellenarla con datos. El HTML resultante se puede usar en el método `send()` junto con el destinatario y otros parámetros para enviar el mensaje de email.

> **NOTE**: Note that this component is used only if `useMail` is enabled in your `.env` file. También necesitará asegurarse de que el servidor SMTP y las credenciales son válidos. 
> 
> {: .alert .alert-info }

## Registro
### Controlador

Para poder acceder a todas las áreas de Vökuró necesita tener una cuenta. Vökuró le permite registrarse en el sitio haciendo click en el botón `Crear una Cuenta`.

Lo que esto hará es llevarle a la URL `/session/signup`, que a su vez llamará a `SessionController` y `signupAction`. Echemos un vistazo a lo que está ocurriendo en `signupAction`:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Flash\Direct;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Security;
use Phalcon\Mvc\View;
use Vokuro\Forms\SignUpForm;
use Vokuro\Models\Users;

/**
 * @property Dispatcher $dispatcher
 * @property Direct     $flash
 * @property Request    $request
 * @property Security   $security
 * @property View       $view
 */
class SessionController extends ControllerBase
{
    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        // ....

        $this->view->setVar('form', $form);
    }
}
```

El flujo de trabajo de la aplicación es:

- Visita `/session/signup`
    - Crea formulario, envía formulario a la vista, renderiza el formulario
- Envía datos (no post)
    - El formulario se muestra de nuevo, no ocurre nada más
- Envía datos (post)
    - Errores
        - Validadores del formulario tiene errores, envía el formulario a la vista, renderiza el formulario (se mostrarán los errores)
    - Sin errores
        - Se sanean los datos
        - Se crea nuevo modelo
        - Se guardan datos en la base de datos
            - Error
                - Se muestra mensaje en pantalla y actualiza el formulario
            - Éxito
                - Registro guardado
                - Muestra confirmación en pantalla
                - Envía email (si corresponde)

### Form

In order to have validation for user supplied data, we are utilizing the [Phalcon\Forms\Form](forms) and [Phalcon\Validation\*](filter-validation) classes. Estas clases nos permiten crear elementos HTML y adjuntarles validadores. El formulario se pasa entonces a la vista, donde los elementos HTML actuales se renderizan en la pantalla.

Cuando el usuario envía la información, envía los datos publicados de vuelta al formulario y los validadores correspondientes validan la entrada y devuelven cualquier posible mensaje de error.

> **NOTE**: All the forms for Vökuró are located in `/src/Forms` 
> 
> {: .alert .alert-info }

Primero creamos un objeto `SignUpForm`. En ese objeto definimos todos los elementos HTML que necesitamos con sus respectivos validadores:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SignUpForm extends Form
{
    /**
     * @param string|null $entity
     * @param array       $options
     */
    public function initialize(
        string $entity = null, 
        array $options = []
    ) {
        $name = new Text('name');
        $name->setLabel('Name');
        $name->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The name is required',
                    ]
                ),
            ]
        );

        $this->add($name);

        // Email
        $email = new Text('email');
        $email->setLabel('E-Mail');
        $email->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The e-mail is required',
                    ]
                ),
                new Email(
                    [
                        'message' => 'The e-mail is not valid',
                    ]
                ),
            ]
        );

        $this->add($email);

        // Password
        $password = new Password('password');
        $password->setLabel('Password');
        $password->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The password is required',
                    ]
                ),
                new StringLength(
                    [
                        'min'            => 8,
                        'messageMinimum' => 'Password is too short. ' .
                                            'Minimum 8 characters',
                    ]
                ),
                new Confirmation(
                    [
                        'message' => "Password doesn't match " .
                                     "confirmation",
                        'with'    => 'confirmPassword',
                    ]
                ),
            ]
        );

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password');
        $confirmPassword->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The confirmation password ' .
                                     'is required',
                    ]
                ),
            ]
        );

        $this->add($confirmPassword);

        // Remember
        $terms = new Check(
            'terms', 
            [
                'value' => 'yes',
            ]
        );

        $terms->setLabel('Accept terms and conditions');
        $terms->addValidator(
            new Identical(
                [
                    'value'   => 'yes',
                    'message' => 'Terms and conditions must be ' .
                                 'accepted',
                ]
            )
        );

        $this->add($terms);

        // CSRF
        $csrf = new Hidden('csrf');
        $csrf->addValidator(
            new Identical(
                [
                    'value'   => $this->security->getRequestToken(),
                    'message' => 'CSRF validation failed',
                ]
            )
        );
        $csrf->clear();

        $this->add($csrf);

        // Sign Up
        $this->add(
            new Submit(
                'Sign Up', 
                [
                    'class' => 'btn btn-success',
                ]
            )
        );
    }

    /**
     * Prints messages for a specific element
     *
     * @param string $name
     *
     * @return string
     */
    public function messages(string $name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                return $message;
            }
        }

        return '';
    }
}
```

En el método `initialize` estamos configurando todos los elementos HTML que necesitamos. Estos elementos son:

| Elemento          | Tipo       | Descripción                   |
| ----------------- | ---------- | ----------------------------- |
| `name`            | `Text`     | El nombre del usuario         |
| `email`           | `Text`     | El email de la cuenta         |
| `password`        | `Password` | La contraseña para la cuenta  |
| `confirmPassword` | `Password` | Confirmación de la contraseña |
| `terms`           | `Check`    | Acepta la casilla de términos |
| `csrf`            | `Hidden`   | Elemento de protección CSRF   |
| `Registro`        | `Submit`   | Botón de enviar               |

Añadir elementos es bastante sencillo:

```php
<?php
declare(strict_types=1);

// Email
$email = new Text('email');
$email->setLabel('E-Mail');
$email->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'The e-mail is required',
            ]
        ),
        new Email(
            [
                'message' => 'The e-mail is not valid',
            ]
        ),
    ]
);

$this->add($email);
```

Primero creamos un objeto `Text` y establecemos su nombre a `email`. También establecemos la etiqueta del elemento a `E-Mail`. Después de eso adjuntamos varios validadores al elemento. Estos se invocarán después de que el usuario envíe los datos, y los datos se pasen en el formulario.

Como vemos arriba, adjuntamos el validador `PresenceOf` en el elemento `email` con un mensaje `The e-mail is required`. El validador comprobará si el usuario ha enviado los datos cuando hace click en el botón enviar y producirá el mensaje si el validador falla. El validador comprueba el vector pasado (normalmente `$_POST`) y para este elemento particular comprobará `$_POST['email']`.

También adjunta el validador `Email`, que es responsable de comprobar si una dirección de email es válida. Como puede ver los validadores residen en un vector, por lo que fácilmente puede adjuntar tantos validadores como necesite.

Lo último que hacemos es añadir el elemento en el formulario.

Tenga en cuenta que el elemento `terms` no tiene ningún validador adjunto a él, por lo que nuestro formulario no comprobará los contenidos del elemento.

Atención especial a los elementos `password` and `confirmPassword`. Notará que ambos elementos son del tipo `Password`. La idea es que necesita escribir la contraseña dos veces, y las contraseñas deben coincidir para evitar errores.

El campo `password` tiene dos validadores de contenido: `PresenceOf` es decir, es requerido y `StringLength`: necesitamos que la contraseña tenga más de 8 caracteres. También adjuntamos un tercer validador llamado `Confirmation`. Este validador especial vincula el elemento `password` con el elemento `confirmPassword`. Cuando se activa para validarlos comprueba los contenidos de ambos elementos y si no son idénticos, aparecerá el mensaje de error, y la validación fallará.

### Vistas

Ahora que tenemos todo configurado en nuestro formulario, pasamos el formulario a la vista:

```php
$this->view->setVar('form', $form);
```

Our view now needs to _render_ the elements:

```twig
{% raw %}
{# ... #}
{% 
    set isEmailValidClass = form.messages('email') ? 
        'form-control is-invalid' : 
        'form-control' 
%}
{# ... #}

<h1 class="mt-3">Sign Up</h1>

<form method="post">
    {# ... #}

    <div class="form-group row">
        {{ 
            form.label(
                'email', 
                [
                    'class': 'col-sm-2 col-form-label'
                ]
            ) 
        }}
        <div class="col-sm-10">
            {{ 
                form.render(
                    'email', 
                    [
                        'class': isEmailValidClass, 
                        'placeholder': 'Email'
                    ]
                ) 
            }}
            <div class="invalid-feedback">
                {{ form.messages('email') }}
            </div>
        </div>
    </div>

    {# ... #}
    <div class="form-group row">
        <div class="col-sm-10">
            {{ 
                form.render(
                    'csrf', 
                    [
                        'value': security.getToken()
                    ]
                ) 
            }}
            {{ form.messages('csrf') }}

            {{ form.render('Sign Up') }}
        </div>
    </div>
</form>

<hr>

{{ link_to('session/login', "&larr; Back to Login") }}
{% endraw %}
```

La variable que establecemos en nuestra vista para nuestro objeto `SignUpForm` se llama `form`. Por lo tanto, la usamos directamente y llamamos a sus métodos. La sintaxis en Volt es ligeramente diferente. En PHP usaríamos `$form->render()` mientras que en Volt usaremos `form.render()`.

Las vistas contienen un condicional en la parte superior, que comprueba si ha habido algún error en nuestro formulario, en cuyo caso, adjunta la clase CSS `is-invalid` al elemento. Esta clase pone un bonito borde rojo en el elemento, resaltando el error y mostrando el mensaje.

Después de eso tenemos etiquetas HTML regulares con el estilo correspondiente. Para mostrar el código HTML de cada elemento necesitamos llamar `render()` sobre `form` con el nombre de elemento correspondiente. También tenga en cuenta que llamamos `form.label()` con el mismo nombre de elemento, para poder crear las etiquetas `<label>` correspondientes.

Al final de la vista renderizamos el campo oculto `CSRF` así como el botón de enviar `Sign Up`.

### Post
As mentioned above, once the user fills the form and clicks the `Sign Up` button, the form will _self post_ i.e. it will post the data on the same controller and action (in our case `/session/signup`). La acción ahora necesita procesar los datos publicados:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Flash\Direct;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Security;
use Phalcon\Mvc\View;
use Vokuro\Forms\SignUpForm;
use Vokuro\Models\Users;

/**
 * @property Dispatcher $dispatcher
 * @property Direct     $flash
 * @property Request    $request
 * @property Security   $security
 * @property View       $view
 */
class SessionController extends ControllerBase
{
    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        if (true === $this->request->isPost()) {
            if (false !== $form->isValid($this->request->getPost())) {
                $name     = $this
                    ->request
                    ->getPost('name', 'striptags')
                ;
                $email    = $this
                    ->request
                    ->getPost('email')
                ;
                $password = $this
                    ->request
                    ->getPost('password')
                ;
                $password = $this
                    ->security
                    ->hash($password)
                ;

                $user = new Users(
                    [
                        'name'       => $name,
                        'email'      => $email,
                        'password'   => $password,
                        'profilesId' => 2,
                    ]
                );

                if ($user->save()) {
                    return $this->dispatcher->forward([
                        'controller' => 'index',
                        'action'     => 'index',
                    ]);
                }

                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            }
        }

        $this->view->setVar('form', $form);
    }
}
```

Si el usuario ha enviado datos, la siguiente línea evaluará y estaremos ejecutando código dentro de la sentencia `if`:

```php
if (true === $this->request->isPost()) {
```

Aquí estamos comprobando la petición que llegó del usuario, si es un `POST`. Ahora que lo es, necesitamos usar los validadores del formulario y comprobar si tenemos algún error. El objeto [Phalcon\Http\Request](request), nos permite obtener esos datos fácilmente usando:

```php
$this->request->getPost()
```

Ahora necesitamos pasar estos datos publicados en el formulario y llamar `isValid`. Esto disparará todos los validadores de cada elemento y si alguno de ellos falla, el formulario rellenará la colección de mensajes internos y devolverá `false`

```php
if (false !== $form->isValid($this->request->getPost())) {
```

Si todo es correcto, usamos otra vez el objeto [Phalcon\Http\Request](request) para recuperar los datos publicados y además sanearlos. El siguiente ejemplo elimina las etiquetas de la cadena `name` enviada:

```php
$name     = $this
    ->request
    ->getPost('name', 'striptags')
;
```

Tenga en cuenta que nunca almacenamos contraseñas en texto plano. Instead we use the [Phalcon\Security](encryption-security) component and call `hash` on it, to transform the supplied password to a one way hash and store that instead. De esta forma, si alguien compromete nuestra base de datos, al menos no tendrá acceso a las contraseñas en texto plano.

```php
$password = $this
    ->security
    ->hash($password)
;
```

Ahora necesitamos almacenar los datos proporcionados en la base de datos. Hacemos eso creando un nuevo modelo `Users`, le pasamos los datos saneados y llamamos a `save`:

```php
$user = new Users(
    [
        'name'       => $name,
        'email'      => $email,
        'password'   => $password,
        'profilesId' => 2,
    ]
);

if ($user->save()) {
    return $this
        ->dispatcher
        ->forward(
            [
                'controller' => 'index',
                'action'     => 'index',
            ]
        );
}
```

Si `$user->save()` devuelve `true`, el usuario será enviado a la página de inicio (`index/index`) y le aparecerá en pantalla un mensaje de éxito.

### Modelo

**Relaciones**

Ahora necesitamos comprobar el modelo `Users`, ya que hay alguna lógica que hemos aplicado aquí, en particular los eventos `afterSave` y `beforeValidationOnCreate`.

El método principal, la configuración si le gusta ocurre en el método `initialize`. Ese es el lugar donde establecemos todas las [relaciones](db-models-relationships) del modelo. Para la clase `Users` tenemos varias relaciones definidas. Podría preguntar, ¿porqué relaciones? Phalcon ofrece una forma fácil de recuperar datos relacionados con un modelo particular.

Si por ejemplo quiere comprobar todos los inicios de sesión correctos para un usuario particular, puede hacerlo con el siguiente fragmento de código:

```php
<?php
declare(strict_types=1);

use Vokuro\Models\SuccessLogins;
use Vokuro\Models\Users;

$user = Users::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => [
            'id' => 7,
        ] 
    ]
);

$logins = SuccessLogin::find(
    [
        'conditions' => 'userId = :userId:',
        'bind'       => [
            'userId' => 7,
        ] 
    ]
);
```

El código anterior obtiene el usuario con id `7` y luego obtiene todos los inicios de sesión correctos de la tabla correspondiente para ese usuario.

Usando las relaciones podemos dejar que Phalcon haga todo el trabajo pesado por nosotros. Con lo que el código anterior sería:

```php
<?php
declare(strict_types=1);

use Vokuro\Models\SuccessLogins;
use Vokuro\Models\Users;

$user = Users::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => [
            'id' => 7,
        ] 
    ]
);

$logins = $user->successLogins;

$logins = $user->getRelated('successLogins');
```

Las últimas dos líneas hacen exactamente lo mismo. Es una cuestión de preferencia qué sintaxis quiere usar. Phalcon consultará la tabla relacionada, filtrando la tabla relacionada con el id del usuario.

Para nuestra tabla `Users` definimos las siguientes relaciones:

| Nombre            | Campo origen | Campo destino | Modelo            |
| ----------------- | ------------ | ------------- | ----------------- |
| `passwordChanges` | `id`         | `usersId`     | `PasswordChanges` |
| `profile`         | `profileId`  | `id`          | `Profiles`        |
| `resetPasswords`  | `id`         | `usersId`     | `ResetPasswords`  |
| `successLogins`   | `id`         | `usersId`     | `SuccessLogins`   |

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    // ...

    public function initialize()
    {
        $this->belongsTo(
            'profilesId', 
            Profiles::class, 
            'id', 
            [
                'alias'    => 'profile',
                'reusable' => true,
            ]
        );

        $this->hasMany(
            'id', 
            SuccessLogins::class, 
            'usersId', 
            [
                'alias'      => 'successLogins',
                'foreignKey' => [
                    'message' => 'User cannot be deleted because ' .
                                 'he/she has activity in the system',
                ],
            ]
        );

        $this->hasMany(
            'id', 
            PasswordChanges::class, 
            'usersId', 
            [
                'alias'      => 'passwordChanges',
                'foreignKey' => [
                    'message' => 'User cannot be deleted because ' .
                                 'he/she has activity in the system',
                ],
            ]
        );

        $this->hasMany(
            'id', 
            ResetPasswords::class, 
            'usersId', [
            'alias'      => 'resetPasswords',
            'foreignKey' => [
                'message' => 'User cannot be deleted because ' .
                             'he/she has activity in the system',
            ],
        ]);
    }

    // ...
}
```

Como puede ver en las relaciones definidas, tenemos un `belongsTo` y tres `hasMany`. Todas las relaciones tienen un alias para que podamos acceder a ellas más fácilmente. La relación `belongsTo` también tiene el parámetro `reusable` activo. Esto significa que si la relación se llama más de una vez en la misma petición, Phalcon realizaría la consulta a la base de datos sólo la primera vez y cachearía el conjunto de resultados. Cualquier llamada posterior usará el conjunto de resultados cacheado.

También destacar que hemos definido mensajes específicos para claves ajenas. Si se infringe la relación particular, se generará el mensaje definido.

**Eventos**

[Phalcon\Mvc\Model](db-models) está diseñado para disparar [eventos](events) específicos. Estos métodos de eventos se pueden localizar en un oyente o en el propio modelo.

Para el modelo `Users`, adjuntamos código a los eventos `afterSave` y `beforeValidationOnCreate`.


```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function beforeValidationOnCreate()
    {
        if (true === empty($this->password)) {
            $tempPassword = preg_replace(
                '/[^a-zA-Z0-9]/', 
                '', 
                base64_encode(openssl_random_pseudo_bytes(12))
            );

            $this->mustChangePassword = 'Y';

            $this->password = $this->getDI()
                                   ->getSecurity()
                                   ->hash($tempPassword)
            ;
        } else {
            $this->mustChangePassword = 'N';
        }

        if ($this->getDI()->get('config')->useMail) {
            $this->active = 'N';
        } else {
            $this->active = 'Y';
        }

        $this->suspended = 'N';

        $this->banned = 'N';
    }
}
```

`beforeValidationOnCreate` disparará cada vez que tenemos un nuevo registro (`Create`), antes de que ocurra alguna validación. We check if we have a defined password and if not, we will generate a random string, then hash that string using [Phalcon\Security](encryption-security) and storing it in the `password` property. También activamos el parámetro para cambiar la contraseña.

Si la contraseña no está vacía, solo establecemos el campo `mustChangePassword` a `N`. Finalmente, establecemos algunos valores predeterminados sobre si el usuario está `active` (activo), `suspended` (suspendido) o `banned` (baneado). Esto asegura que nuestro registro está listo antes de ser insertado en la base de datos.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function afterSave()
    {
        if ($this->getDI()->get('config')->useMail) {
            if ($this->active == 'N') {
                $emailConfirmation          = new EmailConfirmations();
                $emailConfirmation->usersId = $this->id;

                if ($emailConfirmation->save()) {
                    $this->getDI()
                         ->getFlash()
                         ->notice(
                            'A confirmation mail has ' .
                            'been sent to ' . $this->email
                        )
                    ;
                }
            }
        }
    }
}
```

El evento `afterSave` se dispara justo después de guardar un registro en la base de datos. En este evento comprobamos si los emails están habilitados (ver ajuste `useMail` del fichero `.env`), y si están activos creamos un nuevo registro en la tabla `EmailConfirmations` y guardamos el registro. Una vez que se ha hecho todo, aparecerá un aviso en pantalla.

> **NOTE**: Note that the `EmailConfirmations` model also has an `afterCreate` event, which is responsible for actually sending the email to the user. 
> 
> {: .alert .alert-info }

**Validación**

El modelo también tiene el método `validate` que nos permite adjuntar un validador a cualquier número de campos de nuestro modelo. Para la tabla `Users`, necesitamos que el `email` sea único. As such, we attach the `Uniqueness` [validator](filter-validation) to it. El validador se disparará justo antes de que se realice cualquier operación de guardado en el modelo y se devolverá el mensaje si la validación falla.


```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email', 
            new Uniqueness(
                [
                    "message" => "The email is already registered",
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

## Conclusión
Vökuró es una aplicación de ejemplo que usamos para demostrar algunas de las características que Phalcon ofrece. Definitivamente, no es una solución que cubra todas las necesidades. Sin embargo, puede usarla como punto de partida para desarrollar su aplicación.

## Referencias

- [Definición de Listas de Control de Acceso][acl]
- [Composer][composer]
- [DotEnv - Vance Lucas][dotenv]
- [Definición Modelo-Vista-Controlador][mvc]
- [Guías Nanobox][nanobox-guides]
- [Phinx - Cake PHP][phinx]
- [Extensión PSR][psr]
- [Swift Mailer][swiftmailer]
- [ACL Phalcon](acl)
- [Formularios Phalcon](forms)
- [Respuesta HTTP Phalcon](response)
- [Seguridad Phalcon](encryption-security)
- [Vökuró - Repositorio GitHub][github_vokuro]


[acl]: https://en.wikipedia.org/wiki/Access-control_list


[acl]: https://es.wikipedia.org/wiki/Lista_de_control_de_acceso
[composer]: https://getcomposer.org
[composer]: https://getcomposer.org
[composer]: https://getcomposer.org
[di-serviceproviderinterface]: api/phalcon_di#di-serviceproviderinterface
[dotenv]: https://github.com/vlucas/phpdotenv
[dotenv]: https://github.com/vlucas/phpdotenv
[github_vokuro]: https://github.com/phalcon/vokuro
[github_vokuro]: https://github.com/phalcon/vokuro
[github_vokuro]: https://github.com/phalcon/vokuro
[mvc]: https://es.wikipedia.org/wiki/Modelo%E2%80%93vista%E2%80%93controlador
[mvc]: https://en.wikipedia.org/wiki/Model–view–controller
[nanobox-guides]: https://guides.nanobox.io/php/
[nanobox-guides]: https://guides.nanobox.io/php/
[phinx]: https://github.com/cakephp/phinx
[phinx]: https://github.com/cakephp/phinx
[psr]: https://github.com/jbboehr/php-psr
[psr]: https://github.com/jbboehr/php-psr
[swiftmailer]: https://swiftmailer.symfony.com
