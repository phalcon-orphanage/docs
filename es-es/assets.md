---
layout: default
language: 'es-es'
version: '5.0'
upgrade: '#assets'
title: 'Recursos Activos'
keywords: 'recursos, js, css'
---

# Gestión de Recursos (Assets)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)
## Resumen
`Phalcon\Assets` es un componente que le permite gestionar recursos estáticos como hojas de estilo CSS o librerías JavaScript en una aplicación web.

[Phalcon\Assets\Manager][assets-manager] is the component you can use to register your assets and use them throughout your application. If you are using the [Phalcon\Di\FactoryDefault][di-factorydefault] container, the Assets Manager is already registered for you. Puede acceder a él usando la clave `assets` desde su contenedor Di.

```php
<?php

use Phalcon\Di\FactoryDefault();

$container = new FactoryDefault();
$manager   = $container->get('assets')
```

Alternatively, you can register the [Phalcon\Assets\Manager][assets-manager] in your `Phalcon\Di\Di`:

```php
<?php

use Phalcon\Assets\Manager;
use Phalcon\Di\Di();
use Phalcon\Html\TagFactory();

$container  = new Di();
$tagFactory = new TagFactory();

$container->set(
    'assets',
    function () use ($tagFactory) {
        return new Manager($tagFactory);
    }
)
```

If you do use the [Phalcon\Di\FactoryDefault][di-factorydefault], the [Phalcon\Html\TagFactory][html-helper] is already registered as a service with the name `tag` and automatically injected in the constructor of [Phalcon\Assets\Manager][assets-manager]. This is to ensure that objects are reused and memory usage is kept to a minimum. If you are registering the [Phalcon\Assets\Manager][assets-manager] on your own, and you already have the [Phalcon\Html\TagFactory][html-helper] registered in your container, you can reuse it without creating a new instance.

## Recursos Activos
Los recursos se pueden añadir al gestor o una colección usando las clases relativas a `Asset`. The [Phalcon\Assets\Asset][asset] class. El objeto acepta los datos necesarios para crear el recurso.
* `type`: can be `css`, `js` or something else, depending on whether you want to extend the functionality of the component.
* `path` : the path of the asset
* `local`: whether this is a local asset or not
* `filter`: any filter attached to this asset
* `attributes`: attributes relative to the asset
* `version`: version of the asset
* `autoVersion`: let the component auto version this asset or not

Each asset has a unique key assigned to it. The key is computed using `sha256` and it is calculated as: `$this->getType() . ":" . $this->getPath()`. This ensures uniqueness and does not duplicate assets in the asset manager.

```php
<?php

use Phalcon\Assets\Asset;

$asset = new Asset(
    'css',
    'css/bootstrap.css',
    true,
    null,
    [],
    '1.0',
    true
);
```

#### CSS
You can also use the [Phalcon\Assets\Asset\Css][asset-css] class to create a CSS asset. This class is a helper class that extends the [Phalcon\Assets\Asset][asset] class and internally sets the first parameter to `css`.

```php
<?php

use Phalcon\Assets\Asset\Css;

$asset = new Css(
    'css/bootstrap.css',
    true,
    null,
    [],
    '1.0',
    true
);
```

#### JS
You can also use the [Phalcon\Assets\Asset\Js][asset-js] class to create a JS asset. This class is a helper class that extends the [Phalcon\Assets\Asset][asset] class and internally sets the first parameter to `js`.

```php
<?php

use Phalcon\Assets\Asset\Js;

$asset = new Js(
    'js/bootstrap.js',
    true,
    null,
    [],
    '1.0',
    true
);
```

### En Línea
Hay veces que la aplicación necesita generar CSS o JS para ser inyectado en la vista. You can use the [Phalcon\Assets\Inline][asset-inline] class to generate this content. The object can be created with the following parameters:
* `type`: can be `css`, `js` or something else, depending on whether you want to extend the functionality of the component.
* `content`: the content to be injected
* `filter`: any filter attached to this asset
* `attributes`: attributes relative to the asset

```php
<?php

use Phalcon\Assets\Inline;

$asset = new Inline(
    'css',
    '.spinner {color: blue; }'
);
```
#### CSS
You can also use the [Phalcon\Assets\Inline\Css][asset-inline-css] class to create an inline CSS asset. This class is a helper class that extends the [Phalcon\Assets\Inline][asset-inline] class and internally sets the first parameter to `css`.

```php
<?php

use Phalcon\Assets\Inline\Css;

$asset = new Css(
    '.spinner {color: blue; }'
);
```

#### JS
You can also use the [Phalcon\Assets\Inline\Js][asset-inline-js] class to create an inline JS asset. This class is a helper class that extends the [Phalcon\Assets\Inline][asset-inline] class and internally sets the first parameter to `js`.

```php
<?php

use Phalcon\Assets\Asset\Js;

$asset = new Js(
    'alert("hello");'
);
```

### Personalizado
Implementing the [Phalcon\Assets\AssetInterface][asset-interface] enables you to create different asset classes that can be handled by the Asset Manager.

## Excepción
Any exceptions thrown in the Assets Manager component will be of type [Phalcon\Assets\Exception][asset-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Assets\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            // Add some local CSS assets
            $this->assets->addCss('css/style.css');
            $this->assets->addCss('css/index.css');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}

```

## Añadir Recursos
### Archivos
`Phalcon\Assets` supports two built-in assets: CSS and JavaScript assets. También puede crear otros tipos de recurso si lo necesita. El gestor de recursos almacena internamente dos colecciones de recursos por defecto - una para JavaScript y otra para CSS.

Fácilmente puede añadir recursos a estas colecciones:

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // Add some local CSS assets
        $this->assets->addCss('css/style.css');
        $this->assets->addCss('css/index.css');

        // And some local JavaScript assets
        $this->assets->addJs('js/jquery.js');
        $this->assets->addJs('js/bootstrap.min.js');
    }
}
```

Para un mejor rendimiento en la carga de la página, se recomienda colocar enlaces JavaScript al final del HTML en vez de en el elemento `<head>`. However, this might not be always feasible based on the Javascript files you need to load and their dependencies.

También puede añadir recursos al gestor usando objetos `Asset`:
```php
<?php

use Phalcon\Assets\Asset\Css;
use Phalcon\Assets\Asset\Js;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $css1 = new Css('css/style.css');
        $css2 = new Css('css/index.css');

        $this->assets->addAsset($css1);
        $this->assets->addAssetByType('css', $css2);

        $js1 = new Js('js/jquery.js');
        $js2 = new Js('js/bootstrap.min.js');

        $this->assets->addAsset($js1);
        $this->assets->addAssetByType('js', $js2);
    }
}
```

### En Línea
También puede añadir recursos en línea al gestor. Los recursos en línea representan cadenas de CSS o JS que necesitan ser inyectadas en sus vistas dinámicamente (no desde un fichero de recursos). `addInlineCode()`, `addInlineCodeByType()`, `addInlineCss()` y `addInlineJs()` están disponibles para su uso.

```php
<?php

use Phalcon\Assets\Manager;
use Phalcon\Assets\Inline;

$css      = '.spinner {color: blue; }';
$js       = 'alert("hello")';
$manager  = new Manager();
$assetCss = new Inline('css', $css};
$assetJs  = new Inline('js', $js};

$manager
    ->addInlineCode($assetCss)
    ->addInlineCode($assetJs)
;

$manager
    ->addInlineByType('css', $assetCss)
    ->addInlineByType('js', $assetJs)
;

$manager
    ->addInlineCss($css)
    ->addInlineJs($js)
;
```

## Recursos Locales/Remotos
Los recursos locales son aquellos que se proveen por la propia aplicación y están ubicados en una localización pública (normalmente `public`). The URLs for local assets are generated using the [url][url] service.

Remote assets are those such as common libraries like [jQuery][jquery], [Bootstrap][bootstrap], etc. that are provided by a [CDN][cdn].

El segundo parámetro de `addCss()` y `addJs()` significa si el recurso es local o no (`true` es local, `false` es remoto). Por defecto, el gestor de recursos asumirá que el recurso es local:

```php
<?php

public function indexAction()
{
    $this->assets->addCss(
        '//cdn.assets.com/bootstrap/4/css/library.min.css', 
        false
    );

    $this->assets->addCss('css/style.css', true);
    $this->assets->addCss('css/extra.css');
}
```

## Colecciones
[Phalcon\Assets\Collections][collections] are objects that group assets of the same type. El gestor de recursos implícitamente crea dos colecciones: `css` y `js`. Puede crear colecciones adicionales para agrupar recursos específicos y facilitar la colocación de esos recursos en las vistas:

```php
<?php

// Javascript - header
$headerCollection = $this->assets->collection('headerJs');

$headerCollection->addJs('js/jquery.js');
$headerCollection->addJs('js/bootstrap.min.js');

// Javascript - footer
$footerCollection = $this->assets->collection('footerJs');

$footerCollection->addJs('js/jquery.js');
$footerCollection->addJs('js/bootstrap.min.js');
```

### Obtener
The _getter_ methods exposed by the component, allow you to get the collection from anywhere in your code and manipulate it according to your needs. El gestor ofrece `get()`, `getCollection()`, `getCss()` y `getJs()`. Estos métodos devolverán la colección que almacena el gestor. `getCss()` y `getJs()` devolverán las colecciones incorporadas preregistradas.

The `collection()` method acts as a _creator_ and _getter_ at the same time. Le permite crear una colección y obtenerla para que le puedas añadir recursos. `getCss()` y `getJs()` realizan la misma función, es decir, crean la colección si no existe y la devuelven. Estas dos colecciones establecen las colecciones predefinidas `css` y `js` en el gestor.

```php
<?php

$headerCollection = $this->assets->collection('headerJs');

$headerCollection = $this->assets->get('headerJs');
```

### Has
The `has()` method allows you to check if a particular collection exists in the manager;
```php
<?php

$headerCollection = $this->assets->collection('headerJs');

echo $this->assets->has('headerJs'); // true
```

### Establecer
Si las colecciones incorporadas `css` y `js` no son suficientes para sus necesidades, puede adjuntar una nueva colección al gestor usando `set()`.

```php
<?php

use Phalcon\Assets\Collection;

$collection = new Collection();

$this->assets->set('outputJs', $collection);
```

## Prefijos de URL
Las colecciones pueden ser prefijadas por URL, permitiéndole cambiar el prefijo fácilmente basado en las necesidades de su aplicación. An example of this can be changing from local to production environments and using a different [CDN][cdn] URL for your assets:

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

También puede encadenar las llamadas a métodos si se prefiere esa sintaxis:

```php
<?php

$headerCollection = $this
    ->assets
    ->collection('header')
    ->setPrefix('https://cdn.example.com/')
    ->setLocal(false)
    ->addJs('js/jquery.js')
    ->addJs('js/bootstrap.min.js');
```

### Filtros Incorporados
Los recursos se pueden filtrar, es decir, manipular antes de su salida a la vista. Aunque Phalcon v3 ofrecía minificadores para JavaScript y CSS, limitaciones en la licencia no nos permiten continuar usando estas librerías. For v5 we are offering only the [Phalcon\Assets\Filters\None][filter-none] filter (which does not change the asset contents) and the [Phalcon\Assets\FilterInterface][filter-interface] interface, offering the ability to create custom filters.

### Filtros Personalizados
Crear filtros personalizados es muy fácil. You can use this extensibility to take advantage of existing and more advanced filtering/minification tools like [YUI][yui], [Sass][sass], [Closure][closure], etc.:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
 * Filters CSS content using YUI
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
     * @param string $contents
     *
     * @return string
     */
    public function filter($contents)
    {
        // Write the string contents into a temporal file
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

        // Return the contents of file
        return file_get_contents('temp/my-temp-file-2.css');
    }
}
```

Uso:

```php
<?php

// Get some CSS collection
$css = $this->assets->get('head');

// Add/Enable the YUI compressor filter in the collection
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

En el ejemplo anterior, usamos un filtro personalizado llamado `LicenseStamper`, que añade el mensaje de licencia al principio del fichero:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
 * @param string $contents
 *
 * @return string
 */
class LicenseStamper implements FilterInterface
{
    /**
     * Do the filtering
     *
     * @param string $contents
     * @return string
     */
    public function filter($contents)
    {
        $license = '/* (c) 2019 Your Name Here */';

        return $license . PHP_EOL . PHP_EOL . $contents;
    }
}
```

## Salida
After all the assets have been added to their relevant collections you can use the output methods to _print_ HTML in your views. Estos métodos son `output()`, `outputCss()`, `outputJs()`, `outputInline()`, `outputInlineCss()` y `outputInlineJs()`.

Para mostrar ficheros:

```php
<?php

// Javascript - header
$headerCollection = $this->assets->collection('headerJs');

$headerCollection->addJs('js/jquery.js');
$headerCollection->addJs('js/bootstrap.min.js');

// Javascript - footer
$footerCollection = $this->assets->collection('footerJs');

$footerCollection->addJs('js/jquery.js');
$footerCollection->addJs('js/bootstrap.min.js');
```

Entonces en las vistas:

```php
<html>
    <head>
        <title>Some amazing website</title>

        <?php $this->assets->outputJs('headerJs'); ?>
    </head>

    <body>
        <!-- ... -->

        <?php $this->assets->outputJs('footerJs'); ?>
    </body>
<html>
```

Sintaxis Volt:

```twig
<html>
    <head>
        <title>Some amazing website</title>

        {% raw %}{{ assets.outputCss('header') }}{% endraw %}
    </head>

    <body>
        <!-- ... -->

        {% raw %}{{ assets.outputJs('footer') }}{% endraw %}
    </body>
<html>
```

Para mostrar en línea:


```php
<?php

$css      = '.spinner {color: blue; }';
$js       = 'alert("hello")';
$assetCss = new Inline('css', $css};
$assetJs  = new Inline('js', $js};

$this
    ->assets
    ->addInlineCss($css)
    ->addInlineJs($js)
;
```

Entonces en las vistas:

```php
<html>
    <head>
        <title>Some amazing website</title>
    </head>
    <?php $this->assets->outputInlineCss(); ?>
    <body>

        <!-- ... -->

        <?php $this->assets->outputInlineJs(); ?>
    </body>
<html>
```

Sintaxis Volt:

```twig
<html>
    <head>
        <title>Some amazing website</title>

        {% raw %}{{ assets.outputInlineCss() }}{% endraw %}
    </head>

    <body>
        <!-- ... -->

        {% raw %}{{ assets.outputInlineJs() }}{% endraw %}
    </body>
<html>
```
Las líneas anteriores se traducirán a:

```html
<html>
    <head>
        <title>Some amazing website</title>

        <style>.spinner {color: blue; }</style>
    </head>

    <body>
        <!-- ... -->

        <script type="application/javascript">alert("hello")</script>
    </body>
<html>
```

## Salida Personalizada
Los métodos `outputJs()` y `outputCss()` están disponibles para generar el código HTML necesario de acuerdo a cada tipo de recurso. Puede sobreescribir este método o imprimir manualmente los recursos de la siguiente manera:

```php
<?php

use Phalcon\Tag;

$jsCollection = $this->assets->collection('js');

foreach ($jsCollection as $asset) {
    echo Tag::javascriptInclude(
        $asset->getPath()
    );
}
```

## Salida Implícita Vs Explícita
Hay veces que podría necesitar mostrar implícitamente la salida del gestor. Para hacer esto, puede usar el método`useImplicitOutput()`. Calling `output()` after that will _echo_ the HTML on the screen.

```php
<?php

$this
    ->assets
    ->useImplicitOutput(true)
    ->addCss('css/style.css')
    ->output()
;
```

## Versionado
Los componentes `Assets` también soportan versionado (automático o manual). Versioning of assets is also known as [cache busting][cache-busting]. En resumen, los ficheros CSS y JS se pueden cachear fácilmente a nivel de navegador. Como tal, cualquier actualización que se suba al sistema de producción con una versión, podría incluir ficheros CSS y JS actualizados. Ya que los navegadores cachean esos recursos, el contenido actualizado no se entregará al navegador del usuario inmediatamente, resultando en una potencial pérdida de funcionalidad. Versionando los recursos, nos aseguramos de que los navegadores son instruidos para descargar de nuevo los ficheros de recursos y por tanto recibir el último código CSS y JS desde el servidor.

Para añadir un número de versión a sus recursos, necesita añadir la cadena de versión mientras crea el objeto de recurso:
```php
<?php

use Phalcon\Assets\Asset\Css;

$asset = new Css(
    'css/bootstrap.css',
    true,
    null,
    [],
    '1.0'
);
```

Lo anterior resulta en el siguiente script como salida:

```html
<link rel="stylesheet" href="css/bootstrap.css?ver=1.0"
```

Entonces puede almacenar la versión en su fichero de configuración y en cualquier otro almacenamiento y actualizarla cuando se publique una nueva versión en producción.

### Autoversionado
También puede usar la fecha del fichero del recurso para controlar el versionado de sus recursos.
```php
<?php

use Phalcon\Assets\Asset\Css;

$asset = new Css(
    'css/bootstrap.css',
    true,
    null,
    [],
    null,
    true
);
```
Lo anterior resultará en el siguiente script como salida (asumiendo que su fichero fuera modificado el 20 de Mayo de 2019): Asumiendo que su fichero fue modificado por última vez el 20 de Mayo, la versión
```html
<link rel="stylesheet" href="css/bootstrap.css?ver=1558392141">
```

> **NOTE** Using the auto version feature is not recommended for production environments, since Phalcon will need to read the modification time of the asset file for every request. Esto resultará en operaciones de lectura innecesarias en el sistema de ficheros. 
> 
> {: .alert .alert-warning }

## Mejorar el Rendimiento
Hay muchas formas de optimizar el procesamiento de los recursos. Un método es permitir al servidor web gestionar los recursos, mejorando así el tiempo de respuesta. Primero necesitamos configurar el Gestor de Recursos. Usaremos un controlador base, pero puede usar el gestor donde lo necesite, accediendo a él desde el contenedor Di:

```php
<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

/**
 * App\Controllers\ControllerBase
 *
 * This is the base controller for all controllers in the application.
 */
class ControllerBase extends Controller
{
    public function onConstruct()
    {
        $this
            ->assets
            ->useImplicitOutput(false)
            ->collection('global')
            ->addJs('https://code.jquery.com/jquery-4.0.1.js', false, true)
        ;
    }
}
```

Necesitamos configurar el enrutamiento:

```php
<?php

/**
 * Define custom routes.
 * This file gets included in the router service definition.
 */
$router = new Phalcon\Mvc\Router();

$router->addGet(
    '/assets/(css|js)/([\w.-]+)\.(css|js)',
    [
        'controller' => 'assets',
        'action'     => 'serve',
        'type'       => 1,
        'collection' => 2,
        'extension'  => 3,
    ]
);

// Other routes...
```

Finalmente, necesitamos crear un controlador para gestionar las peticiones de recursos:

```php
<?php

namespace App\Controllers;

use Phalcon\Http\Response;

/**
 * Serve site assets.
 */
class AssetsController extends ControllerBase
{
    public function serveAction(): Response
    {
        // Getting a response instance
        $response = new Response();

        // Prepare output path
        $collectionName = $this->dispatcher->getParam('collection');
        $extension      = $this->dispatcher->getParam('extension');
        $type           = $this->dispatcher->getParam('type');
        $targetPath     = "assets/{$type}/{$collectionName}.{$extension}";

        // Setting up the content type
        $contentType = $type == 'js' ? 'application/javascript' : 'text/css';
        $response->setContentType($contentType, 'UTF-8');

        // Check collection existence
        if (!$this->assets->exists($collectionName)) {
            return $response->setStatusCode(404, 'Not Found');
        }

        // Setting up the Assets Collection
        $collection = $this->assets
            ->collection($collectionName)
            ->setTargetUri($targetPath)
            ->setTargetPath($targetPath);

        // Store content to the disk and return fully qualified file path
        $contentPath = $this->assets->output(
            $collection,
            function (array $parameters) {
                return BASE_PATH . '/public/' . $parameters[0];
            },
            $type
        );

        // Set the content of the response
        $response->setContent(
            file_get_contents($contentPath)
        );

        // Return the response
        return $response;
    }
}
```

Si existen recursos precompilados en el sistema de ficheros deben ser servidos directamente por el servidor web. Así que para obtener beneficios de los recursos estáticos debemos actualizar la configuración de nuestro servidor. Usaremos un ejemplo de configuración para Nginx. Para Apache será un poco diferente:

```nginx
location ~ ^/assets/ {
    expires 1y;
    add_header Cache-Control public;
    add_header ETag "";

    # If the file exists as a static file serve it directly without
    # running all the other rewrite tests on it
    try_files $uri $uri/ @phalcon;
}

location / {
    try_files $uri $uri/ @phalcon;
}

location @phalcon {
    rewrite ^(.*)$ /index.php?_url=$1;
}

```
# Otras Directivas de Configuración

We need to create `assets/js` and `assets/css` directories in the document root of the application (eg. `public`).

Cada vez que la aplicación solicite recursos como `/assets/js/global.js` la aplicación comprobará si el recurso existe. En caso afirmativo, será gestionado por el servidor web. Alternativamente será redirigido a `AssetsController` para la gestión desde la aplicación.

No recomendamos el uso del ejemplo anterior en entornos de producción y aplicaciones de alta carga. Sin embargo, el ejemplo muestra lo que es posible hacer usando este componente. La implementación que elija depende de las necesidades de su aplicación.

In most cases, your web server, [CDN][cdn] or services such as [Varnish HTTP Cache][varnish] would be more preferable.

[asset]: api/phalcon_assets#assets-asset
[asset-css]: api/phalcon_assets#assets-asset-css
[asset-js]: api/phalcon_assets#assets-asset-js
[asset-interface]: api/phalcon_assets#assets-assetinterface
[asset-inline]: api/phalcon_assets#assets-inline
[asset-inline-css]: api/phalcon_assets#assets-inline-css
[asset-inline-js]: api/phalcon_assets#assets-inline-js
[asset-exception]: api/phalcon_assets#assets-exception
[assets-manager]: api/phalcon_assets#assets-manager
[bootstrap]: https://getbootstrap.com
[cache-busting]: https://www.keycdn.com/support/what-is-cache-busting
[cdn]: https://en.wikipedia.org/wiki/Content_delivery_network
[closure]: https://developers.google.com/closure/compiler
[collections]: api/phalcon_assets#assets-collection
[di-factorydefault]: api/phalcon_di#di-factorydefault
[filter-interface]: api/phalcon_assets#assets-filterinterface
[filter-none]: api/phalcon_assets#assets-filters-none
[jquery]: https://jquery.com
[sass]: https://sass-lang.com
[html-helper]: html-helper
[yui]: https://yui.github.io/yuicompressor
[url]: mvc-url
[varnish]: https://varnish-cache.org/
