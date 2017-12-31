<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Gestión de Activos (Assets)</a> <ul>
        <li>
          <a href="#add">Agregando Recursos</a>
        </li>
        <li>
          <a href="#resources-local-remote">Recursos Locales/Remotos</a>
        </li>
        <li>
          <a href="#collections">Colecciones</a>
        </li>
        <li>
          <a href="#url-prefixes">Prefijos de URL</a>
        </li>
        <li>
          <a href="#minification-filtering">Reducción y Filtrado</a> <ul>
            <li>
              <a href="#builtin-filters">Filtros Incorporados</a>
            </li>
            <li>
              <a href="#custom-filters">Filtros Personalizados</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#custom-output">Salida Personalizada</a>
        </li>
        <li>
          <a href="#improving-performance">Mejorar el Rendimiento</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Gestión de Activos (Assets)

`Phalcon\Assets` es un componente que te permite administrar recursos estáticos como hojas de estilo CSS o las librerías de JavaScript en una aplicación web.

`Phalcon\Assets\Manager` está disponible en el contenedor de servicios, lo que permite incorporar recursos de cualquier parte de la aplicación dónde el contenedor esté disponible.

<a name='add'></a>

## Agregando Recursos

Un objeto Assets (o activos) admite dos tipos de recursos incorporados: CSS y JavaScripts. También puedes crear otros recursos si es necesario. El administrador de activos almacena internamente por defecto dos colecciones de recursos: una para JavaScript y otra para CSS.

Puedes agregar fácilmente recursos a estas colecciones, ve el siguiente ejemplo:

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // Agregar algunos recursos CSS locales
        $this->assets->addCss('css/style.css');
        $this->assets->addCss('css/index.css');

        // Y otros recursos JavaScript locales
        $this->assets->addJs('js/jquery.js');
        $this->assets->addJs('js/bootstrap.min.js');
    }
}
```

Luego en una vista, estos recursos se pueden imprimir:

```php
<html>
    <head>
        <title>Un sitio web asombroso</title>

        <?php $this->assets->outputCss(); ?>
    </head>

    <body>
        <!-- ... -->

        <?php $this->assets->outputJs(); ?>
    </body>
<html>
```

Sintaxis Volt:

```volt
<html>
    <head>
        <title>Un sitio web asombroso</title>

        {{ assets.outputCss() }}
    </head>

    <body>
        <!-- ... -->

        {{ assets.outputJs() }}
    </body>
<html>
```

Para lograr un mejor rendimiento al cargar la página, se recomienda colocar el código JavaScript al final del HTML en vez de en el `<head>`.

<a name='local-remote'></a>

## Recursos Locales/Remotos

Los recursos locales son aquellos que han sido proporcionados por la misma aplicación y está situados en la raíz de la aplicación. Las URLs de los recursos locales son generadas por el servicio `url`, generalmente `Phalcon\Mvc\Url`.

Los recursos remotos son comúnmente bibliotecas como [jQuery](https://jquery.com), [Bootstrap](http://getbootstrap.com), etc. que son proporcionados por una [CDN](https://en.wikipedia.org/wiki/Content_delivery_network).

El segundo parámetro de `addCss()` y `addJs()` dice si el recurso es local o no (`true` es local, `false` es remoto). De forma predeterminada, el administrador de activos asume que el recurso es local:

```php
<?php

public function indexAction()
{
    // Agregar algún recurso CSS remoto
    $this->assets->addCss('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css', false);

    // Luego agregar algunos recursos CSS locales
    $this->assets->addCss('css/style.css', true);
    $this->assets->addCss('css/extra.css');
}
```

<a name='collections'></a>

## Colecciones

Las Colecciones agrupan recursos del mismo tipo. El administrador de activos implícitamente crea dos colecciones: `css` y `js`. Puedes crear colecciones adicionales y hacer grupos de recursos específicos para colocar fácilmente esos recursos en las vistas:

```php
<?php

// Javascripts en la cabecera
$headerCollection = $this->assets->collection('header');

$headerCollection->addJs('js/jquery.js');
$headerCollection->addJs('js/bootstrap.min.js');

// Javascripts en el pie del documento
$footerCollection = $this->assets->collection('footer');

$footerCollection->addJs('js/jquery.js');
$footerCollection->addJs('js/bootstrap.min.js');
```

Luego en las vistas:

```php
<html>
    <head>
        <title>Algún sitio web asombroso</title>

        <?php $this->assets->outputJs('header'); ?>
    </head>

    <body>
        <!-- ... -->

        <?php $this->assets->outputJs('footer'); ?>
    </body>
<html>
```

Sintaxis Volt:

```twig
<html>
    <head>
        <title>Algún sitio web asombroso</title>

        {{ assets.outputCss('header') }}
    </head>

    <body>
        <!-- ... -->

        {{ assets.outputJs('footer') }}
    </body>
<html>
```

<a name='url-prefixes'></a>

## Prefijos de URL

Las colecciones pueden tener un URL de prefijo, esto te permite cambiar fácilmente de un servidor a otro en cualquier momento:

```php
<?php

$footerCollection = $this->assets->collection('footer');

if ($config->environment === 'development') {
    $footerCollection->setPrefix('/');
} else {
    $footerCollection->setPrefix('http:://cdn.example.com/');
}

$footerCollection->addJs('js/jquery.js');
$footerCollection->addJs('js/bootstrap.min.js');
```

También está disponible una sintaxis encadenable:

```php
<?php

$headerCollection = $assets
    ->collection('header')
    ->setPrefix('http://cdn.example.com/')
    ->setLocal(false)
    ->addJs('js/jquery.js')
    ->addJs('js/bootstrap.min.js');
```

<a name='minification-filtering'></a>

## Reducción y Filtrado

`Phalcon\Assets` proporciona un método incorporado de reducción (minificado) de recursos JavaScript y CSS. Puedes crear una colección de recursos y dar instrucciones al administrador de activos sobre cuales deben ser filtrados y cuáles deben dejarse como están. Además de lo anterior, el método `Jsmin`, creado por [Douglas Crockford](http://www.crockford.com) es parte de la extensión principal que ofrece reducción de archivos JavaScript para obtener un máximo rendimiento. En en caso de CSS, el método `CSSMin`, creado por [Ryan Day](https://github.com/soldair) también está disponible para reducir los archivos CSS.

En el ejemplo siguiente muestra cómo reducir una colección de recursos:

```php
<?php

$manager

    // Este JavaScripts es ubicado en el final de la página
    ->collection('jsFooter')

    // El nombre final del archivo reducido
    ->setTargetPath('final.js')

    // La etiqueta del script es generado con esta URI
    ->setTargetUri('production/final.js')

    // Este es un recurso remoto que no necesita ser filtrado
    ->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false)

    // Este es un recurso local que necesita ser filtrado
    ->addJs('common-functions.js')
    ->addJs('page-functions.js')

    // Unir todos los recursos en un solo archivo
    ->join(true)

    // Usar el filtro incorporado jsmin
    ->addFilter(
        new Phalcon\Assets\Filters\Jsmin()
    )

    // Usar un filtro personalizado
    ->addFilter(
        new MyApp\Assets\Filters\LicenseStamper()
    );
```

Una colección puede contener recursos JavaScript o CSS pero no ambos. Algunos recursos pueden ser remotos, es decir, son obtenidos por HTTP desde una fuente remota para filtrarlos mas tarde. Se recomienda convertir los recursos externos a locales para un mejor rendimiento.

Como hemos visto anteriormente, se utiliza el método `addJs()` para agregar recursos a la colección, el segundo parámetro indica si el recurso es externo o no y el tercer parámetro indica si el recurso debe ser filtrado o dejarlo como está:

```php
<?php

// Este Javascripts es ubicado al final de la página
$jsFooterCollection = $manager->collection('jsFooter');

// Este es un recurso remoto que no necesita ser filtrado
$jsFooterCollection->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false);

// Este es un recurso local que debe ser filtrado
$jsFooterCollection->addJs('common-functions.js');
$jsFooterCollection->addJs('page-functions.js');
```

Los filtros se registran en la colección, además se pueden definir múltiples filtros, los recursos de la colección son filtrados en el mismo orden en que fueron registraron los filtros:

```php
<?php

// Usar el filtro incorporado Jsmin
$jsFooterCollection->addFilter(
    new Phalcon\Assets\Filters\Jsmin()
);

// Usar un filtro personalizado
$jsFooterCollection->addFilter(
    new MyApp\Assets\Filters\LicenseStamper()
);
```

Debes tener en cuenta que los filtros incorporados y los personalizados pueden aplicarse de forma transparente a las colecciones. El último paso es decidir si todos los recursos de la colección deben ser unidos en un solo archivo o entregar cada uno de ellos individualmente. Para indicar a la colección que todos los recursos deben ser unidos, puedes utilizar el método `join()`.

Si los recursos se van a unir, es necesario también definir que archivo se utilizará para almacenar los recursos y que URI se utilizará para mostrarlo. Estos ajustes se configuran con `setTargetPath()` y `setTargetUri()`:

```php
<?php

$jsFooterCollection->join(true);

// La ruta y nombre del archivo final
$jsFooterCollection->setTargetPath('public/production/final.js');

// La etiqueta HTML del script es generada con esta URI
$jsFooterCollection->setTargetUri('production/final.js');
```

<a name='builtin-filters'></a>

### Filtros Incorporados

Phalcon proporciona 2 filtros incorporados para reducir tanto JavaScript como CSS. Su backend de C causa el mínimo de carga para realizar esta tarea:

| Filtro                             | Descripción                                                                                                                    |
| ---------------------------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| `Phalcon\Assets\Filters\Jsmin`  | Reduce archivos JavaScript eliminando caracteres innecesarios que son ignorados por los compiladores/intérpretes de Javascript |
| `Phalcon\Assets\Filters\Cssmin` | Reduce archivos CSS al quitar caracteres innecesarios que son ignorados por los navegadores                                    |

<a name='custom-filters'></a>

### Filtros Personalizados

Además de los filtros incorporados, puede crear sus propios filtros. Estos pueden tomar ventaja de herramientas más avanzadas como [YUI](http://yui.github.io/yuicompressor/), [Sass](http://sass-lang.com/), [Closure](https://developers.google.com/closure/compiler/), etc.:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
 * Flitra el contenido de archivos CSS usando YUI
 *
 * @param string $contents
 * @return string
 */
class CssYUICompressor implements FilterInterface
{
    protected $options;

    /**
     * CssYUICompressor constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Hace el filtrado
     *
     * @param string $contents
     *
     * @return string
     */
    public function filter($contents)
    {
        // Escribe las cadenas de caracteres filtradas en un archivo temporal
        file_put_contents('temp/my-temp-1.css', $contents);

        system(
            $this->options['java-bin'] .
            ' -jar ' .
            $this->options['yui'] .
            ' --type css ' .
            'temp/my-temp-file-1.css ' .
            $this->options['extra-options'] .
            ' -o temp/my-temp-file-2.css'
        );

        // Devuelve el contenido del archivo
        return file_get_contents('temp/my-temp-file-2.css');
    }
}
```

Uso:

```php
<?php

// Obtiene alguna colección CSS
$css = $this->assets->get('head');

// Agrega/Habilita el filtro reductor YUI en la colección
$css->addFilter(
    new CssYUICompressor(
        [
            'java-bin'      => '/usr/local/bin/java',
            'yui'           => '/some/path/yuicompressor-x.y.z.jar',
            'extra-options' => '--charset utf8',
        ]
    )
);
```

En un ejemplo anterior, hemos utilizado un filtro personalizado llamado `LicenseStamper`:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
 * Agrega un mensaje de licencia  al principio del archivo
 *
 * @param string $contents
 *
 * @return string
 */
class LicenseStamper implements FilterInterface
{
    /**
     * Hace el filtrado
     *
     * @param string $contents
     * @return string
     */
    public function filter($contents)
    {
        $license = '/* (c) 2015 Your Name Here */';

        return $license . PHP_EOL . PHP_EOL . $contents;
    }
}
```

<a name='custom-output'></a>

## Salida Personalizada

Los métodos `outputJs()` y `outputCss()` están disponibles para generar el código HTML necesario según cada tipo de recursos. Usted puede sobrecargar estos métodos o imprimir manualmente los recursos de la siguiente manera:

```php
<?php

use Phalcon\Tag;

$jsCollection = $this->assets->collection('js');

foreach ($jsCollection as $resource) {
    echo Tag::javascriptInclude(
        $resource->getPath()
    );
}
```

<a name='improving-performance'></a>

## Mejorar el Rendimiento

Hay muchas maneras de optimizar el procesamiento de los recursos. Describiremos un método sencillo a continuación que te permite manejar recursos directamente a través de un servidor web para optimizar el tiempo de respuesta.

Primero tenemos que configurar el gestor de activos (Assets Manager). Vamos a utilizar el controlador base, pero puedes utilizar el proveedor de servicios o desde cualquier otro lugar:

```php
<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Assets\Filters\Jsmin;

/**
 * App\Controllers\ControllerBase
 *
 * Este es el controlador base para todos los controladores en la aplicación.
 */
class ControllerBase extends Controller
{
    public function onConstruct()
    {
        $this->assets
            ->useImplicitOutput(false)
            ->collection('global')
            ->addJs('https://code.jquery.com/jquery-3.2.1.js', false, true)
            ->addFilter(new Jsmin());
    }
}
```

Entonces tenemos que configurar el enrutamiento:

```php
<?php
/*
 * Define rutas personalizadas.
 * Este archivo se incluye en la definición del servicio de enrutado (router service).
 */
$router = new Phalcon\Mvc\Router();

$router->addGet('/assets/(css|js)/([\w.-]+)\.(css|js)', [
    'controller' => 'assets',
    'action'     => 'serve',
    'type'       => 1,
    'collection' => 2,
    'extension'  => 3,
]);

// Otras rutas...
```

Por último, tenemos que crear un controlador para manejar las solicitudes de recursos:

```php
<?php

namespace App\Controllers;

use Phalcon\Http\Response;

/**
 * Provee activos del sitio.
 */
class AssetsController extends ControllerBase
{
    public function serveAction() : Response
    {
        // Se crea una instancia de Response
        $response = new Response();

        // Se prepara un ruta para salida (output)
        $collectionName = $this->dispatcher->getParam('collection');
        $extension      = $this->dispatcher->getParam('extension');
        $type           = $this->dispatcher->getParam('type');
        $targetPath     = "assets/{$type}/{$collectionName}.{$extension}";

        // Se define el tipo de contenido
        $contentType = $type == 'js' ? 'application/javascript' : 'text/css';
        $response->setContentType($contentType, 'UTF-8');

        // Verifica la exitencia de la colección
        if (!$this->assets->exists($collectionName)) {
            return $response->setStatusCode(404, 'Not Found');
        }

        // Define la Colección de Activos (Assets Collection)
        $collection = $this->assets
            ->collection($collectionName)
            ->setTargetUri($targetPath)
            ->setTargetPath($targetPath);

        // Almacena el contenido en disco y devuelve una ruta validada
        $contentPath = $this->assets->output($collection, function (array $parameters) {
            return BASE_PATH . '/public/' . $parameters[0];
        }, $type);

        // Establece el contenido de la respuesta
        $response->setContent(file_get_contents($contentPath));

        // Devuelve la respuesta
        return $response;
    }
}
```

Si existen recursos precompilados en el sistema de archivos, estos deben ser entregados directamente por el servidor web. Para obtener los beneficios de los recursos estáticos tenemos que actualizar la configuración de nuestro servidor. Vamos a utilizar un ejemplo de configuración de Nginx. Para Apache será un poco diferente:

```nginx
location ~ ^/assets/ {
    expires 1y;
    add_header Cache-Control public;
    add_header ETag "";

    # Si existe el archivo como un archivo estático, entregar directamente sin
    # ejecutar todas las otras pruebas de reescritura en el
    try_files $uri $uri/ @phalcon;
}

location / {
    try_files $uri $uri/ @phalcon;
}

location @phalcon {
    rewrite ^(.*)$ /index.php?_url=$1;
}

# Otras configuraciones
```

Necesitamos crear los directorios `assets/js` y `assets/css` en la raíz de la aplicación (por ejemplo: `public`).

Cada vez que el usuario solicita recursos con una dirección del tipo `/assets/js/global.js`, el pedido será redirigido a `AssetsController` en el caso que este fichero esté ausente en el sistema de archivos. De lo contrario el recurso será manejado por el servidor web.

No es el mejor ejemplo. Sin embargo, refleja la idea principal: la configuración adecuada de un servidor web con una aplicación puede ayudar a optimizar el tiempo de respuesta múltiple.

Puedes encontrar más información sobre la configuración del servidor Web y Enrutamiento en los artículos siguientes: [Configuración del Servidor Web](/[[language]]/[[version]]/webserver-setup) y [Enrutamiento](/[[language]]/[[version]]/routing).