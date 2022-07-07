---
layout: default
language: 'es-es'
version: '5.0'
title: 'Vistas'
upgrade: '#views'
keywords: 'mvc, vista, componente vista, vista simple, respuestas'
---

# Vistas
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Las vistas representan la interfaz de usuario de su aplicación. Las vistas, son a menudo, archivos HTML con código PHP incrustado que realizan tareas relacionadas solamente a la presentación de datos. Las vistas formatean el contenido que necesita devolver al usuario/navegador web que inició la petición.

[Phalcon\Mvc\View][mvc-view] and [Phalcon\Mvc\View\Simple][mvc-view-simple] are responsible for the managing the view layer of your MVC application.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class InvoicesController extends Controller
{
    public function viewAction($invoiceId)
    {
        $this->view->invoiceId = $invoiceId;
    }
}
```

## Constantes
Hay varias constantes que controlan el comportamiento del proceso de renderizado una vez establecido en la vista

| Constante               | Descripción                                                  |
| ----------------------- | ------------------------------------------------------------ |
| `LEVEL_ACTION_VIEW`     | Nivel de Renderizado: A la vista de la acción                |
| `LEVEL_BEFORE_TEMPLATE` | Nivel de Renderizado: A las plantillas "anterior"            |
| `LEVEL_LAYOUT`          | Nivel de Renderizado: A la disposición del controlador       |
| `LEVEL_MAIN_LAYOUT`     | Nivel de Renderizado: A la disposición principal             |
| `LEVEL_NO_RENDER`       | Nivel de Renderizado: No renderiza ninguna vista             |
| `LEVEL_AFTER_TEMPLATE`  | Nivel de Renderizado: Renderiza a las plantillas "posterior" |

## Métodos

```php
public function __construct(array options = [])
```
Constructor Phalcon\Mvc\View

```php
public function __get(string $key): mixed | null
```
Método mágico para obtener las variables pasadas a la vista

```php
echo $this->view->invoices;
```

```php
public function __isset(string $key): bool
```
Método mágico para obtener si una variable está establecida en la vista

```php
echo isset($this->view->invoices);
```

```php
public function __set(string $key, var value)
```
Método mágico para pasar variables a las vistas

```php
$this->view->invoices = $invoices;
```

```php
public function cleanTemplateAfter(): View
```
Reestablece cualquier plantilla anterior de la disposición

```php
public function cleanTemplateBefore(): View
```
Restablece cualquier disposición de "plantilla anterior"

```php
public function disableLevel(mixed $level): ViewInterface
```
Deshabilita un nivel específico de renderizado

```php
$this->view->disableLevel(
    View::LEVEL_ACTION_VIEW
);
```
Renderiza todos los niveles excepto el nivel `ACTION`

```php
public function disable(): View
```
Deshabilita el proceso de auto-renderizado

```php
public function enable(): View
```
Habilita el proceso de auto-renderizado

```php
public function exists(string $view): bool
```
Comprueba si existe la vista

```php
public function finish(): View
```
Finaliza el proceso de renderizado deteniendo el búfer de salida

```php
public function getActionName(): string
```
Obtiene el nombre de la acción renderizada

```php
public function getActiveRenderPath(): string | array
```
Devuelve la ruta (o rutas) de las vistas que se están renderizando actualmente

```php
public function getBasePath(): string
```
Obtiene la ruta base

```php
public function getContent(): string
```
Devuelve la salida desde otra etapa de vista

```php
public function getControllerName(): string
```
Obtiene el nombre del controlador renderizado

```php
public function getLayout(): string
```
Obtiene el nombre de la vista principal

```php
public function getLayoutsDir(): string
```
Obtiene los diseños actuales del subdirectorio

```php
public function getMainView(): string
```
Obtiene el nombre de la vista principal

```php
public function getParamsToView(): array
```
Obtiene los parámetros de las vistas

```php
public function getPartial(
    string $partialPath, 
    mixed $params = null
): string
```
Renderiza una vista parcial

```php
echo $this->getPartial("shared/footer");
```
Recupera los contenidos de una parcial

```php
echo $this->getPartial(
    "shared/footer",
    [
        "content" => $html,
    ]
);
```
Recupera los contenidos de una parcial con argumentos

```php
public function getPartialsDir(): string
```
Obtiene el subdirectorio actual de parciales

```php
public function getRender(
    string $controllerName, 
    string $actionName, 
    array $params = [], 
    mixed configCallback = null
): string
```
Realiza el renderizado automático devolviendo la salida como una cadena

```php
$template = $this->view->getRender(
    "invoices",
    "show",
    [
        "invoices" => $invoices,
    ]
);
```

```php
public function getVar(string $key)
```
Devuelve un parámetro previamente establecido en la vista

```php
public function getViewsDir(): string | array
```
Devuelve el directorio de las vistas

```php
protected function getViewsDirs(): array
```
Devuelve los directorios de las vistas

```php
public function isDisabled(): bool
```
Si está habilitado el renderizado automático

```php
public function partial(
    string $partialPath, 
    mixed $params = null
)
```
Renderiza una vista parcial

```php
$this->partial("shared/footer");
```
Muestra una parcial dentro de otra vista

```php
$this->partial(
    "shared/footer",
    [
        "content" => $html,
    ]
);
```
Muestra una parcial dentro de otra vista con parámetros

```php
public function pick(var renderView): View
```
Elige una vista diferente a renderizar en vez del último-controlador/última-acción

```php
use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function saveAction()
    {
        // ...

        $this->view->pick("invoices/list");
    }
}
```

```php
public function registerEngines(
    array $engines
): View
```
Registra motores de plantillas

```php
$this->view->registerEngines(
    [
        ".phtml" => \Phalcon\Mvc\View\Engine\Php::class,
        ".volt"  => \Phalcon\Mvc\View\Engine\Volt::class,
        ".mhtml" => \MyCustomEngine::class,
    ]
);
```

```php
public function render(
    string $controllerName,
    string $actionName,
    array $params = []
): View | bool
```
Ejecuta el proceso de renderizado desde los datos de despacho

```php
$view
    ->start()
    ->render("posts", "recent")
    ->finish()
;
```
Muestra la vista de mensajes reciente (app/views/posts/recent.phtml)

```php
public function reset(): View
```
Resetea el componente vista a sus valores predeterminados de fábrica

```php
public function setBasePath(
    string $basePath
): View
```
Establece la ruta base. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
$view->setBasePath(__DIR__ . "/");
```

```php
public function setContent(
    string $content
): View
```
Establece externamente el contenido de la vista

```php
$this->view->setContent(
    "<h1>hello</h1>"
);
```

```php
public function setLayout(
    string $layout
): View
```
Cambia la disposición a usar en vez de usar el nombre del último nombre de controlador

```php
$this->view->setLayout("main");
```

```php
public function setLayoutsDir(
    string $layoutsDir
): View
```
Establece el subdirectorio de disposiciones. Debe ser un directorio dentro del directorio de vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
$view->setLayoutsDir(
    "../common/layouts/"
);
```

```php
public function setMainView(
    string viewPath
): View
```
Establece el nombre de la vista predeterminada. Debe ser un fichero sin extensión en el directorio de vistas

```php
$this->view->setMainView("base");
```
Renderiza como vista principal views-dir/base.phtml

```php
public function setPartialsDir(
    string $partialsDir
): View
```
Establece un subdirectorio de parciales. Debe ser un directorio dentro del directorio de vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
$view->setPartialsDir(
    "../common/partials/"
);
```

```php
public function setParamToView(
    string $key, 
    mixed $value
): View
```
Añade parámetros a las vistas (alias de setVar)

```php
$this
    ->view
    ->setParamToView("invoices", $invoices)
;
```

```php
public function setRenderLevel(
    int $level
): ViewInterface
```
Establece el nivel de renderizado de la vista

```php
$this->view->setRenderLevel(
    View::LEVEL_LAYOUT
);
```
Renderiza solo la vista relacionada con el controlador

```php
public function setTemplateAfter(
    mixed $templateAfter
): View
```
Establece una disposición de controlador "plantilla posterior"

```php
public function setTemplateBefore(
    mixed $templateBefore
): View
```
Establece una plantilla anterior a la disposición del controlador

```php
public function setVar(
    string $key, 
    mixed $value
): View
```
Establece un parámetro de vista único

```php
$this
    ->view
    ->setVar("invoices", $invoices)
;
```

```php
public function setVars(
    array $params, 
    bool $merge = true
): View
```
Establece todos los parámetros de renderizado

```php
$this->view->setVars(
    [
        "invoices" => $invoices,
    ]
);
```

```php
public function setViewsDir(
    mixed $viewsDir
): View
```
Establece el directorio de las vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
public function start(): View
```
Inicia el proceso de renderizado habilitando el búfer de salida

```php
public function toString(
    string $controllerName,
    string $actionName,
    array params = []
): string
```
Renderiza la vista y la devuelve como una cadena

## Activación
Debe registrar el componente vista en su contenedor DI para habilitar las vistas en su aplicación.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);
```
If no engine is defined, the [Phalcon\Mvc\View\Engine\Php][mvc-view-engine-php] will be automatically registered for you. Estos son ficheros que contienen tanto código PHP como HTML y tienen la extensión `.phtml`. Para más información sobre el motor de plantilla [Volt](volt), consulte el documento correspondiente.

## Vistas en Controladores
Phalcon automáticamente pasa la ejecución al componente vista tan pronto como un controlador particular haya completado su ciclo. El componente vista buscará en la carpeta vistas por una carpeta llamada con el mismo nombre del último controlador ejecutado y luego por un fichero llamado como la última acción ejecutada. For instance, if a request is made to the URL *https://dev.phalcon.ld/admin/invoices/view/12345*, Phalcon will parse the URL as follows:

| Dirección del Servidor | `127.0.0.1` |
| ---------------------- | ----------- |
| Directorio Phalcon     | `admin`     |
| Controlador            | `invoices`  |
| Acción                 | `view`      |
| Parámetro              | `12345`     |

El despachador buscará un `InvoicesController` y su acción `viewAction`. Un fichero de controlador simple para este ejemplo:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class InvoicesController extends Controller
{
    public function viewAction($invoiceId)
    {
        $this->view->setVar('invoiceId', $invoiceId);
    }
}
```

El método `setVar()` nos permite crear variables de la vista bajo demanda, por lo que se pueden usar en la plantilla de la vista. El ejemplo anterior demuestra cómo pasar el parámetro `$invoiceId` a la respectiva plantilla de vista.

## Renderizado Jerárquico
[Phalcon\Mvc\View][mvc-view] is the default component for rendering views in Phalcon and supports a hierarchy of files. Esta jerarquía permite puntos de composición común (vistas usadas normalmente), así como carpetas con el nombre del controlador definiendo sus respectivas plantillas de vistas.

El motor de renderizado por defecto para el componente vista es PHP. Como resultado, todos los ficheros relacionados con las vistas necesitan tener la extensión `.phtml`. Para el ejemplo anterior:

```
https://dev.phalcon.ld/admin/invoices/view/12345
```
Asumiendo que el directorio de vistas es `app/views`, el componente vista automáticamente encontrará los 3 siguientes ficheros de vistas:

| Nombre                     | Archivo                          | Descripción                                                                                                   |
| -------------------------- | -------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| Vista de la Acción         | app/views/invoices/view.phtml    | Vista relacionada con la acción. Sólo será renderizada cuando la acción `view` se ejecute.                    |
| Disposición de Controlador | app/views/layouts/invoices.phtml | Vista relacionada con el controlador. Será renderizada para cada acción ejecutada en el `InvoicesController`. |
| Disposición Principal      | app/views/index.phtml            | Vista relacionada con la Aplicación. Se mostrará en cada controlador/acción de la aplicación                  |

No está obligado a implementar todos los ficheros mencionados arriba. [Phalcon\Mvc\View][mvc-view] will simply move to the next view level in the hierarchy of files. Si los tres ficheros de vista se implementan, entonces se procesarán como sigue:

```php
<!-- app/views/invoices/view.phtml -->

<h3>View Name: "view"</h3>

<p>I have received the parameter <?php echo $invoiceId; ?></p>
```

```php
<!-- app/views/layouts/invoices.phtml -->

<h2>Controller view: "invoices"</h2>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/index.phtml -->
<html>
    <head>
        <title>Example</title>
    </head>
    <body>
        <h1>Main layout!</h1>

        <?php echo $this->getContent(); ?>

    </body>
</html>
```

> **NOTE**: The call to `$this->getContent()` instructs [Phalcon\Mvc\View][mvc-view] on where to inject the contents of the previous view executed in the hierarchy. 
> 
> {: .alert .alert-info }

Para el ejemplo anterior, la salida será:

![](/assets/images/content/views-layout.png)

El HTML generado será:

```php
<html>
    <head>
        <title>Example</title>
    </head>
    <body>
        <h1>Main layout!</h1>

        <!-- app/views/layouts/invoices.phtml -->

        <h2>Controller view: "invoices"</h2>

        <!-- app/views/invoices/view.phtml -->

        <h3>View Name: "view"</h3>

        <p>I have received the parameter 12345</p>

    </body>
</html>
```

### Plantillas
Las plantillas son vistas que se pueden usar para compartir código de vista común. Ellas actúan como disposiciones del controlador, así que necesita colocarlas en el directorio de disposiciones.

Las plantillas se pueden renderizar antes de la disposición (usando `$this->view->setTemplateBefore()`) o se pueden renderizar después de la disposición (usando `this->view->setTemplateAfter()`). En el siguiente ejemplo la plantilla (`layouts/common.phtml`) se renderiza después de la disposición principal (`layouts/posts.phtml`):

```php
<?php

use Phalcon\Flash\Direct;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Direct $flash
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function initialize()
    {
        $this->view->setTemplateAfter('common');
    }

    public function lastAction()
    {
        $this->flash->notice(
            'These are the latest invoices'
        );
    }
}
```

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Invoices</title>
    </head>
    <body>
        <?php echo $this->getContent(); ?>
    </body>
</html>
```

```php
<!-- app/views/layouts/common.phtml -->

<ul class='menu'>
    <li><a href='/'>Home</a></li>
    <li><a href='/list'>List</a></li>
    <li><a href='/support'>Support</a></li>
</ul>

<div class='content'>
    <?php echo $this->getContent(); ?>
</div>
```

```php
<!-- app/views/layouts/invoices.phtml -->

<h1>Invoices</h1>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/invoices/last.phtml -->

<article>
    <h2>This is a title</h2>
    <p>This is Invoice One</p>
</article>

<article>
    <h2>Another title</h2>
    <p>This is Invoice Two</p>
</article>
```

La salida final será la siguiente:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Invoices</title>
    </head>
    <body>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Home</a></li>
            <li><a href='/list'>List</a></li>
            <li><a href='/support'>Support</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/layouts/invoices.phtml -->

            <h1>Invoices</h1>

            <!-- app/views/invoices/last.phtml -->

            <article>
                <h2>This is a title</h2>
                <p>This is Invoice One</p>
            </article>

            <article>
                <h2>Another title</h2>
                <p>This is Invoice Two</p>
            </article>

        </div>

    </body>
</html>
```

Si hubiésemos usado `$this->view->setTemplateBefore('common')`, este sería la salida final:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Blog's title</title>
    </head>
    <body>

        <!-- app/views/layouts/invoices.phtml -->

        <h1>Blog Title</h1>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Home</a></li>
            <li><a href='/articles'>Articles</a></li>
            <li><a href='/contact'>Contact us</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/invoices/last.phtml -->

            <article>
                <h2>This is a title</h2>
                <p>This is the post content</p>
            </article>

            <article>
                <h2>This is another title</h2>
                <p>This is another post content</p>
            </article>

        </div>

    </body>
</html>
```

### Niveles de Renderizado
As seen above, [Phalcon\Mvc\View][mvc-view] supports a view hierarchy. Podría necesitar controlar el nivel de renderizado producido por el componente vista. El método `Phalcon\Mvc\View::setRenderLevel()` ofrece esta funcionalidad.

Este método se puede invocar desde el controlador o desde una capa de vista superior para interferir en el proceso de renderizado.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function findAction()
    {
        $this->view->setRenderLevel(
            View::LEVEL_NO_RENDER
        );

        // ...
    }

    public function viewAction($invoiceId)
    {
        $this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );
    }
}
```

Los niveles de renderizado disponibles son:

| Constante de Clase      | Descripción                                                                 | Orden |
| ----------------------- | --------------------------------------------------------------------------- |:-----:|
| `LEVEL_NO_RENDER`       | Indica que se evite generar ningún tipo de presentación.                    |       |
| `LEVEL_ACTION_VIEW`     | Genera la presentación a la vista asociada a la acción.                     |   1   |
| `LEVEL_BEFORE_TEMPLATE` | Genera plantillas de presentación antes que el diseño del controlador.      |   2   |
| `LEVEL_LAYOUT`          | Genera la presentación en el diseño del controlador.                        |   3   |
| `LEVEL_AFTER_TEMPLATE`  | Genera la presentación a las plantillas después del diseño del controlador. |   4   |
| `LEVEL_MAIN_LAYOUT`     | Genera la presentación del diseño principal. Fichero views/index.phtml      |   5   |

### Deshabilitar Niveles de Renderizado
Puedes deshabilitar niveles de renderizado temporal o permanentemente. Un nivel podría deshabilitarse permanentemente si no se utiliza en toda la aplicación:

```php
<?php

use Phalcon\Mvc\View;

$container->set(
    'view',
    function () {
        $view = new View();

        // Disable several levels
        $view->disableLevel(
            [
                View::LEVEL_LAYOUT      => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]
        );

        return $view;
    },
    true
);
```

O deshabilitarlo temporalmente en alguna parte de la aplicación:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function findAction()
    {
        $this->view->disableLevel(
            View::LEVEL_MAIN_LAYOUT
        );
    }
}
```

### Deshabilitar la Vista
Si su controlador no produce ninguna salida en la vista (o ni siquiera tiene una) puede deshabilitar el componente vista evitando un procesamiento innecesario:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function processAction()
    {
        $this->view->disable();
    }
}
```

Alternativamente, puede devolver `false` para producir el mismo efecto:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View   $view
 */
class InvoicesController extends Controller
{
    public function processAction()
    {
        return false;
    }
}
```

Puede devolver un objeto `response` para evitar deshabilitar la vista manualmente:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Response $response
 * @property View     $view
 */
class InvoicesController extends Controller
{
    public function processAction()
    {
        return $this
            ->response
            ->redirect('index/index')
        ;
    }
}
```

## Renderizado Simple
[Phalcon\Mvc\View\Simple][mvc-view-simple] is an alternative component to [Phalcon\Mvc\View][mvc-view]. It keeps most of the philosophy of [Phalcon\Mvc\View][mvc-view] but lacks of a hierarchy of files which is, in fact, the main feature of its counterpart.

Este componente le permite tener el control de cuando se renderiza una vista y su ubicación. Además, este componente puede aprovechar la herencia de vista disponible en motores de plantillas como [Volt](volt) y otros.

El componente por defecto se debe reemplazar en el contenedor de servicio:

```php
<?php

use Phalcon\Mvc\View\Simple;

$container->set(
    'view',
    function () {
        $view = new Simple();

        $view->setViewsDir('../app/views/');

        return $view;
    },
    true
);
```

El renderizado automático se debe deshabilitar en [Phalcon\Mvc\Application](application) (si es necesario):

```php
<?php

use Phalcon\Di\FactoryDefault;;
use Phalcon\Mvc\Application;

try {
    $container   = new FactoryDefault();
    $application = new Application($container);

    $application->useImplicitView(false);

    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

Para renderizar una vista es necesario llamar explícitamente al método de renderizado indicando la ruta relativa a la vista que quieres mostrar:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Response $response
 * @property View     $view
 */
class InvoicesController extends Controller
{

    public function indexAction()
    {
        // 'views-dir/index.phtml'
        echo $this->view->render('index');

        // 'views-dir/posts/show.phtml'
        echo $this->view->render('posts/show');

        // 'views-dir/index.phtml' passing variables
        echo $this->view->render(
            'index',
            [
                'posts' => Invoices::find(),
            ]
        );

        // 'views-dir/invoices/view.phtml' passing variables
        echo $this->view->render(
            'invoices/view',
            [
                'posts' => Invoices::find(),
            ]
        );
    }
}
```

This is different to the `render` that [Phalcon\Mvc\View][mvc-view] implements, which uses controllers and actions as parameters:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Simple;

$params = [
    'invoices' => Invoices::find(),
];

// Phalcon\Mvc\View
$view = new View();
echo $view->render('invoices', 'view', $params);

// Phalcon\Mvc\View\Simple
$simpleView = new Simple();
echo $simpleView->render('invoices/view', $params);
```

### Selección de Vistas
As mentioned above, when [Phalcon\Mvc\View][mvc-view] is managed by [Phalcon\Mvc\Application](application), the view rendered is the one related with the last controller and action executed. Podría sobreescribir esto usando el método `pick()`:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Response $response
 * @property View     $view
 */
class InvoicesController extends Controller
{
    public function listAction()
    {
        // Pick 'views-dir/invoices/search' as view to render
        $this->view->pick('invoices/search');

        // Pick 'views-dir/invoices/list' as view to render
        $this->view->pick(
            [
                'invoices',
            ]
        );

        // Pick 'views-dir/invoices/search' as view to render
        $this->view->pick(
            [
                1 => 'search',
            ]
        );
    }
}
```

## Parciales
Las plantillas parciales son otra forma de romper el proceso de renderizado en trozos más sencillos y manejables que se pueden reutilizar por diferentes partes de la aplicación. Con un parcial, puede mover el código para renderizar una pieza particular de una respuesta a su propio fichero.

Una forma de usar parciales es tratarlas como fragmentos HTML que se pueden inyectar donde se necesite con cualquier parámetro necesario:

```php
<div class='top'>
    <?php $this->partial('shared/ad_banner'); ?>
</div>

<div class='content'>
    <h1>Invoices</h1>

    <p>Check out our specials!</p>
    ...
</div>

<div class='footer'>
    <?php $this->partial('shared/footer'); ?>
</div>
```

El método `partial()` acepta un segundo parámetro como un vector de variables/parámetros que sólo existirá en el ámbito del parcial:

```php
<?php 
    $this->partial(
        'shared/ad_banner', 
        [
            'id'   => $site->id, 
            'size' => 'big'
        ]
    ); 
?>
```

## Valores
[Phalcon\Mvc\View][mvc-view] is available in each controller using the view variable (`$this->view`). Puede usar ese objeto para establecer variables directamente a la vista desde una acción de controlador usando el método `setVar()`.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class InvoicesController extends Controller
{
    public function viewAction($invoiceId)
    {
        $invoice = Invoices::findFirst(
            [
                'conditions' => 'inv_id = :id:',
                'bind'       => [
                    'id' => abs(intval($invoiceId)),
                ]
            ]
        );
        $customer = $invoice->getRelated('customer');

        $this->view->setVar('invoice', $invoice);

        $this->view->customerId = $customer->cst_id;

        $this->view->setVars(
            [
                'name_first' => $customer->name_first,
                'name_last'  => $customer->name_last,
            ]
        );
    }
}
```

Una variable con el nombre del primer parámetro de `setVar()` se creará e la vista, lista para usar. The variable can be of any type, from a simple `string`, `integer` etc. variable to a more complex structure such as `array`, collection etc.

```php
<h1>
    Invoices [Customer #{{ customerId }}]
</h1>

<div class='invoice'>
<?php

    foreach ($invoices as $invoice) {
        echo '<h2>', $invoice->inv_title, '</h2>';
    }

?>
</div>
```

## Motores de Plantillas
Los Motores de Plantillas ayuda a los diseñadores a crear vistas sin el uso de una sintaxis complicada. Phalcon incluye un motor de plantillas poderoso y rápido llamado [Volt](volt) que ayuda con el desarrollo de la vista sin sacrificar la velocidad de procesamiento.

### PHP
The [Phalcon\Mvc\View\Engine\Php][mvc-view-engine-php] is the default template engine, if none has been specified.

```php
<?php

use Phalcon\Mvc\View;

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    },
    true
);
```

### Volt
Podría querer usar [Volt](volt) como su motor de plantillas. Para configurarlo necesita registrar el motor y pasarlo al componente vista.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\ViewBaseInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

$container = new FactoryDefault();

$container->setShared(
    'voltService',
    function (ViewBaseInterface $view) {
        $volt = new Volt($view, $this);
        $volt->setOptions(
            [
                'always'    => true,
                'extension' => '.php',
                'separator' => '_',
                'stat'      => true,
                'path'      => appPath('storage/cache/volt/'),
                'prefix'    => '-prefix-',
            ]
        );

        return $volt;
    }
);

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.volt' => 'voltService',
            ]
        );

        return $view;
    }
);
```

### Mustache/Twig/Smarty
If you like to use [Mustache][mustache], [Twig][twig] or [Smarty][smarty] as your template engine, you can visit our [incubator][incubator-engines] repository for examples on how to activate these engines in your application

### Personalizado
When using an external template engine, [Phalcon\Mvc\View][mvc-view] provides exactly the same view hierarchy and it is still possible to access the API inside these templates. Si quiere crear su propio motor de plantillas, puede aprovechar el API para realizar las operaciones que necesite.

A template engine adapter is a class that acts as bridge between [Phalcon\Mvc\View][mvc-view] and the template engine itself. Normalmente, solo necesita dos métodos implementados: `__construct()` y `render()`. The first one receives the [Phalcon\Mvc\View][mvc-view] instance that creates the engine adapter and the DI container used by the application.

El método `render()` acepta una ruta absoluta al fichero de vista y el conjunto de parámetros de la vista usando `$this->view->setVar()`. Podría leerlo o requerirlo cuando fuese necesario.

```php
<?php

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\View\Engine\AbstractEngine;
use Phalcon\Mvc\View;

class CustomEngine extends AbstractEngine
{
    /**
     * @param View        $view
     * @param DiInterface $container
     */
    public function __construct($view, DiInterface $container)
    {
        parent::__construct($view, $container);
    }

    /**
     * @param string $path
     * @param array $params
     */
    public function render(string $path, $params)
    {
        // Access view
        $view = $this->view;

        // Options
        $options = $this->options;

        // Render the view
        // ...
    }
}
```

Ahora puede reemplazar el motor de plantillas con el suyo en la parte de su código de configuración de la vista. Siempre puede usar más de un motor al mismo tiempo. Para lograr esto necesita llamar a `Phalcon\Mvc\View::registerEngines()` que acepta un vector con las instrucciones de configuración de los motores a registrar. La clave de cada motor es la extensión de los ficheros que necesita procesar. No puede registrar dos motores con la misma clave.

El orden en el que se definen los motores de plantillas con `Phalcon\Mvc\View::registerEngines()` establece la prioridad de ejecución. If [Phalcon\Mvc\View][mvc-view] finds two views with the same name but different extensions, it will only render the first one.

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php;

$container->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.my-html' => \CustomEngine::class,
            ]
        );

        $view->registerEngines(
            [
                '.my-html' => \CustomEngine::class,
                '.phtml'   => Php::class,
            ]
        );

        return $view;
    },
    true
);
```

## Inyección de Dependencias
Dado que nuestra vista se registra en nuestro contenedor de Inyección de Dependencias, los servicios disponibles en el contenedor también están disponibles en la vista. Cada servicio está disponible desde una propiedad con el mismo nombre que el servicio definido.

```js
<script type='text/javascript'>

$.ajax({
    url: '<?php echo $this->url->get('invoices/get'); ?>'
})
.done(function () {
    alert('Done!');
});

</script>
```

In the example above, we are utilizing the [Phalcon\Url](mvc-url) component in our javascript code, to correctly set up the URL in our application. El servicio está disponible en la vista accediendo a `$this->url`.

## Independiente
You can also use the view as a _glue_ component in your application. Solo necesitará tener la configuración adecuada y luego usar la vista para devolver los resultados procesados.

### Renderizado Jerárquico
Una vez configurada la vista con las opciones que necesita su aplicación, puede pasarle variables, como se ha visto arriba, luego llame a `start()`, `render()` y `finish()`. Esto permitirá a la vista compilar los datos y prepararlos para usted. Puede imprimir el contenido producido llamando a `getContent()`.

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

$view->setViewsDir('../app/views/');

//...

$view->setVar('invoices', $invoices);
$view->setVar('isAdmin', true);

$view->start();
$view->render('invoices', 'list');
$view->finish();

echo $view->getContent();
```

O usando una sintaxis más corta:

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

echo $view->getRender(
    'invoices',
    'list',
    [
        'invoices' => $invoices,
        'isAdmin'  => true,
    ],
    function ($view) {
        $view->setViewsDir('../app/views/');

        $view->setRenderLevel(
            View::LEVEL_LAYOUT
        );
    }
);
```

### Renderizado Simple
You can also use the much smaller [Phalcon\Mvc\View\Simple][mvc-view-simple] as a stand alone component. Este componente es extremadamente útil cuando quiere renderizar una plantilla que no siempre está ligada a la estructura de su aplicación. Un ejemplo es renderizar código HTML requerido por emails.

```php
<?php

use Phalcon\Mvc\View\Simple;

$view = new Simple();

$view->setViewsDir('../app/views/');

echo $view->render('templates/welcome');

echo $view->render(
    'templates/welcome',
    [
        'email'   => $email,
        'content' => $content,
    ]
);
```
En el ejemplo anterior, configuramos el motor y luego mostramos una plantilla renderizada por pantalla (`templates/welcome`). También podemos enviar parámetros a la plantilla emitiendo un vector como segundo parámetro. Las claves son los nombres de las variables.

## Eventos
[Phalcon\Mvc\View][mvc-view] and [Phalcon\Mvc\View\Simple][mvc-view-simple] are able to send events to an [Events Manager](events) if it is present. Los eventos se disparan usando el tipo `view`. Si un evento devuelve `false` puede parar la operación activa. Se soportan los siguientes eventos:

| Nombre de evento   | Disparado                                      | Puede detenerse |
| ------------------ | ---------------------------------------------- |:---------------:|
| `afterRender`      | Después de completar el proceso de renderizado |       No        |
| `afterRenderView`  | Después de renderizar una vista existente      |       No        |
| `beforeRender`     | Antes de iniciar el proceso de renderizado     |       Si        |
| `beforeRenderView` | Antes de renderizar una vista existente        |       Si        |
| `notFoundView`     | Cuando no se encuentra una vista               |       No        |

En el ejemplo siguiente se muestra cómo adjuntar oyentes (listeners) a este componente:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\View;

$container = new FactoryDefault();
$container->set(
    'view',
    function () {
        $manager = new Manager();

        $manager->attach(
            'view',
            function (Event $event, $view) {
                echo $event->getType(), ' - ', 
                     $view->getActiveRenderPath(), PHP_EOL;
            }
        );

        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->setEventsManager($manager);

        return $view;
    },
    true
);
```

The following example demonstrates how you can create a plugin that _tidies up_ your HTML produced by the render process using [Tidy][tidy].

```php
<?php

use Phalcon\Events\Event;

class TidyPlugin
{
    public function afterRender(Event $event, $view)
    {
        $tidyConfig = [
            'clean'          => true,
            'output-xhtml'   => true,
            'show-body-only' => true,
            'wrap'           => 0,
        ];

        $tidy = tidy_parse_string(
            $view->getContent(),
            $tidyConfig,
            'UTF8'
        );

        $tidy->cleanRepair();

        $view->setContent(
            (string) $tidy
        );
    }
}
```
y ahora podemos adjuntarlo a nuestro gestor de eventos:

```php
<?php

$manager->attach(
    'view:afterRender',
    new TidyPlugin()
);
```

## Excepciones

Any exceptions thrown in the view components ([Phalcon\Mvc\View][mvc-view] or [Phalcon\Mvc\View\Simple][mvc-view-simple]) will be of type [Phalcon\Mvc\Exception][mvc-view-exception] or [Phalcon\View\Engine\Volt\Exception][mvc-view-engine-volt-exception] if you are using [Volt](volt). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Exception;

try {

    $view = new View();

    echo $view->getRender(
        'unknown-view',
        'list',
        [
            'invoices' => $invoices,
            'isAdmin'  => true,
        ],
        function ($view) {
            $view->setViewsDir('../app/views/');

            $view->setRenderLevel(
                View::LEVEL_LAYOUT
            );
        }
    );
} catch (Exception $ex) {
    echo $ex->getMessage();
}

```

[incubator-engines]: https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Mvc/View/Engine
[mvc-view]: api/phalcon_mvc#mvc-view
[mvc-view-engine-php]: api/phalcon_mvc#mvc-view-engine-php
[mvc-view-engine-volt-exception]: api/phalcon_mvc#mvc-view-engine-volt-exception
[mvc-view-exception]: api/phalcon_mvc#mvc-view-exception
[mvc-view-simple]: api/phalcon_mvc#mvc-view-simple
[mustache]: https://github.com/bobthecow/mustache.php
[smarty]: https://www.smarty.net/
[tidy]: https://www.php.net/manual/en/book.tidy.php
[twig]: https://twig.symfony.com/
