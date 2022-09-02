---
layout: default
upgrade: '#url'
title: 'URL'
keywords: 'url, gestión url, generación url, url estática, url dinámica'
---

# Componente Url
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Mvc\Url][url] is the component responsible for generating URLs in a Phalcon application. También se puede usar para construir URLs basadas en rutas.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

$url->setBaseUri("/portal/");
echo $url->get("invoices/edit/1"); // /portal/invoices/edit/1 

echo $url->get(
    [
        "for"   => "invoices-edit", // route name
        "title" => "Edit Invoice",  // title
        "id"    => 1,               // route parameter
    ]                             
);
```

## Generación
The [Phalcon\Mvc\Url][url] component can generate URLs that are static as well as dynamic ones. Las URLs dinámicas se pueden generar también basadas en parámetros o rutas de su aplicación, como se define usando el componente \[Router\]\[routing\].

## URLs Estáticas
Las URLs estáticas son las que se refieren a recursos estáticos. Pueden ser imágenes, recursos CSS/JS, vídeos, etc. The [Phalcon\Mvc\Url][url] component offers an easy way to generate those URLs.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

echo $url->getStatic("img/logo.png");
```

Junto con `getStatic()`, el componente también ofrece los métodos *getter* `getStaticBaseUri()` y *setter* `setStaticBaseUri()`, que le permiten establecer un prefijo para todas sus URLs estáticas. Esta funcionalidad puede ser especialmente útil cuando necesita configurar un CDN o una localización diferente donde están almacenados sus recursos.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

$this->setStaticBaseUri('https://assets.phalcon.io/');

echo $url->getStaticBaseUri(); // https://assets.phalcon.io/
```

y cuando sea necesario usar un CDN para su entorno de producción:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

if ($environment === 'production') {
    $this->setStaticBaseUri('https://assets.phalcon.io/');
}

echo $url->getStatic('img/logo.png'); // https://assets.phalcon.io/img/logo.png
```

El código anterior añadirá un prefijo a todos los recursos estáticos con `https://assets.phalcon.io`, asegurando que todos los recursos en su entorno de producción usan la URL del CDN, mientras que en el desarrollo local se cargarán directamente desde su máquina.

> **NOTE**: The trailing slash in the `setStaticBaseUrl()` parameter is optional. If it is not specified, it will automatically be appended to the passed parameter 
> 
> {: .alert .alert-info }

Finalmente, dependiendo de las rutas que haya especificado, puede recuperar un recurso estático definido como una ruta nombrada pasando un vector a `getStatic()` y usando la palabra clave `for` como clave y el nombre de la ruta como valor.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

echo $url->getStatic(
    [
        'for' => 'logo-cdn',
    ]
);
```

## URLs Dinámicas
Las URLs dinámicas son URLs que se generan dinámicamente, ej. basadas en las rutas o URLs de su aplicación. The [Phalcon\Mvc\Url][url] component offers an easy way to generate those URLs.

Depending on which directory of your document root your application is installed, it may have a base URI or not. Por ejemplo, si su *document root* es `/var/www/htdocs` y su aplicación está instalada en `/var/www/htdocs/app` entonces su *baseUri* será `/app/`. Si está usando un *VirtualHost* o su aplicación está instalada en el *document root*, entonces su URI base es `/`.

Si no está seguro y quiere saber cuál es su URI base, puede ejecutar el siguiente código en la carpeta de su aplicación:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

echo $url->getBaseUri();
```

Por defecto, Phalcon intentará detectar su URI base. Se recomienda que especifique la URI base usted mismo, ya que aumenta notablemente el rendimiento.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

echo $url->get("/portal/invoices/edit/1");
```

Junto con `get()`, el componente también ofrece los métodos *getter* `getBaseUri()` y *setter* `setBaseUri()`, que le permiten configurar un prefijo para todas sus URLs. Esta funcionalidad puede ser especialmente útil cuando necesita configurar un `prefijo` para sus URLs, ej. si trabaja con módulos que tienen un prefijo específico para todas las rutas.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

$this->setBaseUri('/portal/');

echo $url->getBaseUri(); // /portal/

echo $url->get('invoices/edit/1'); // /portal/invoices/edit/1
```

The above code will prefix all the URLs with `/portal/`, allowing you to _group_ URLs easier. Por ejemplo, si tiene `InvoicesController` y quiere que las URLs estén prefijadas con `/portal/`, puede usar `setBaseUri()` en el método `initialize()`:

```php
<?php

use Phalcon\Mvc\Url;
use Phalcon\Mvc\Controller

/**
 * @property Url $url
 */
class InvoicesController extends Controller
{
    public function initialize()
    {
        $this->url->setBaseUri('/portal/');
    }
}
```

Y ahora podemos generar cualquier URL usando `get()` en acciones posteriores, que serán prefijadas con `/portal/`

> **NOTE**: The trailing slash in the `setBaseUrl()` parameter is optional. If it is not specified, it will automatically be appended to the passed parameter 
> 
> {: .alert .alert-info }


### Ruteo
Si está usando el [Router](routing) con su comportamiento predeterminado, su aplicación será capaz de encajar rutas basadas en el siguiente patrón:

> /:controller/:action/:params 
> 
> {: .alert .alert-info }


Por lo tanto, es fácil crear rutas que satisfagan ese patrón (o cualquier otro patrón definido en el enrutador) pasando una cadena al método `get()`:

```php
<?php echo $url->get('products/save'); ?>
```

Tenga en cuenta que no es necesario anteponer la URI base. Si tiene rutas nombradas fácilmente puede definirlas dinámicamente. Por ejemplo, para la siguiente ruta:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router
    ->add(
        '/portal/invoices/edit/{id}',
        [
            'module'     => 'portal',
            'controller' => 'invoices',
            'action'     => 'edit',
        ]
    )
    ->setName('invoices-edit');
```

Ahora puede generar una URL definida en la ruta nombrada `invoice-edit`, pasando un vector a `get()` y usar la palabra clave `for` como clave y el nombre de la ruta como valor.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

echo $url->get(
    [
        'for' => 'invoices-edit',
        'id'  => 1,
    ]
);
```

Lo anterior producirá `/portal/invoices/edit/1`.

### mod_rewrite
Developers that are utilizing `mod_rewrite` in their Apache installations, [Phalcon\Mvc\Url][url] offers the necessary functionality to replace `mod_rewrite`. This is especially useful if the target system does not have the module installed, or you cannot install it yourself.

The following example shows you how to replace `mod_rewrite` with [Phalcon\Mvc\Url][url]:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

$url->setBaseUri('/app/public/index.php?_url=/'); // $_GET['_url']

echo $url->get('products/save'); // /app/public/index.php?_url=/portal/invoices/save
```

También puede usar `$_SERVER['REQUEST_URI']`. Esto requiere un poco más de trabajo, ya que necesitamos usar el componente [Router](routing) para rellenar `$_SERVER['REQUEST_URI']`. Nuestra configuración de rutas necesita cambiar a:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// ... Define routes

$uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);

$router->handle($uri);
```

y ahora la aplicación puede procesar la URL como se espera:

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

$url->setBaseUri('/app/public/index.php'); // $_SERVER['REQUEST_URI']

echo $url->get('products/save'); // /app/public/index.php/portal/invoices/save
```

> **NOTE**: If you can, avoid replacing `mod_rewrite` with the code above. Tener el mecanismo de encaje de rutas necesario gestionado por el servidor web es mucho más rápido que gestionarlo en su propia aplicación. 
> 
> {: .alert .alert-info }

### View/Volt
La función `url` está disponible en volt para generar URLs usando este componente:

```twig
{% raw %}
<a href='{{ url('invoices/edit/1') }}'>Edit</a>
{% endraw %}
```

Generar rutas estáticas:

```twig
{% raw %}
<link rel='stylesheet' href='{{ static_url('css/style.css') }}' type='text/css' />
{% endraw %}
```

## Path
Although a `path` is not really a URL, the [Phalcon\Mvc\Url][url] offers methods that allow you to create paths for your application, the same way as URLs.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

echo $url->path("/data/app/storage/");
```

Junto con `path()`, el componente también ofrece los métodos *getter* `getBasePath()` y *setter* `setBasePath()`, que le permiten configurar un prefijo para todos sus caminos.

```php
<?php

use Phalcon\Mvc\Url;

$url = new Url();

$this->setBasePath('/data/app/');

echo $url->getBasePath(); // /data/app/

echo $url->path('storage/config.php'); // /data/app/storage/config.php
```

El código anterior prefijará todos los caminos con `/data/app/`.

> **NOTE**: The trailing slash in the `setBasePath()` parameter is optional. If it is not specified, it will automatically be appended to the passed parameter 
> 
> {: .alert .alert-info }

## Excepciones
Any exceptions thrown in the [Phalcon\Mvc\Url][url] component will be of type [Phalcon\Mvc\Url\Exception][url-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Mvc\Url\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            // Get some configuration values
            $this->url->get('/portal/invoices/list');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Personalizado
The \[Phalcon\Mvc\Url\UrlInterface\]\[url-interface\] is available if you wish to implement your own `Url` component. Implementar este interfaz asegurará que su componente personalizado funcionará con Phalcon.

## Inyección de Dependencias
If you use the [Phalcon\Di\FactoryDefault][factorydefault] container, the [Phalcon\Mvc\Url][url] is already registered for you. However, you might want to override the default registration in order to set your own `setBaseUri()`. Alternatively if you are not using the [Phalcon\Di\FactoryDefault][factorydefault] and instead are using the [Phalcon\Di](di) the registration is the same. Al hacerlo, podrá acceder a su objeto de configuración desde controladores, modelos, vistas y cualquier componente que implemente `Injectable`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url;

// Create a container
$container = new FactoryDefault();

$container->set(
    'url',
    function () {
        $url = new Url();

        $url->setBaseUri('/portal/');

        return $url;
    },
    true
);
```

El componente está disponible ahora en sus controladores usando la clave `url`

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Url;

/**
 * @property Url $url
 */
class MyController extends Controller
{
    private function getUrl(): string
    {
        return $this->url->get('/portal/invoices/link');
    }
}
```

También en sus vistas (sintaxis Volt) el método ayudante `url` ofrece la misma funcionalidad:

```twig
{% raw %}{{ url('/portal/invoices/link') }}{% endraw %}
```

Por supuesto, puede acceder al objeto de la misma forma que cualquier servicio registrado en el contenedor Di:

```twig
{% raw %}{{ url.get('/portal/invoices/link') }}{% endraw %}
```

[url]: api/phalcon_mvcl#mvc-url
[url-exception]: api/phalcon_mvc#mvc-url-exception
[factorydefault]: api/phalcon_di#di-factorydefault
