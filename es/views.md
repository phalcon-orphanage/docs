<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Usando Vistas</a> <ul>
        <li>
          <a href="#integrating-views-with-controllers">Integrando Vistas con Controladores</a>
        </li>
        <li>
          <a href="#hierarchical-rendering">Renderizado Jerárquico</a> 
          <ul>
            <li>
              <a href="#using-templates">Usando Plantillas</a>
            </li>
            <li>
              <a href="#control-rendering-levels">Control de Niveles de Renderizado</a>
            </li>
            <li>
              <a href="#disabling-render-levels">Deshabilitar niveles de renderizado</a>
            </li>
            <li>
              <a href="#picking-views">Selección de Vistas</a>
            </li>
            <li>
              <a href="#disabling-view">Deshabilitar la vista</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#simple-rendering">Renderizado Simple</a>
        </li>
        <li>
          <a href="#using-partials">Usando parciales</a>
        </li>
        <li>
          <a href="#value-transfer">Transferencia de valores del controlador a la vista</a>
        </li>
        <li>
          <a href="#caching-fragments">Almacenamiento en caché de fragmentos de la vista</a>
        </li>
        <li>
          <a href="#template-engines">Motores de Plantillas</a> 
          <ul>
            <li>
              <a href="#custom-template-engine">Crea tu propio adaptador de motor de plantillas</a>
            </li>
            <li>
              <a href="#changing-template-engine">Cambiar el motor de plantillas</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#injecting-services">Inyectando servicios en la vista</a>
        </li>
        <li>
          <a href="#stand-alone">Componente independiente</a> 
          <ul>
            <li>
              <a href="#stand-alone-hierarchical-rendering">Renderizado Jerárquico</a>
            </li>
            <li>
              <a href="#stand-alone-simple-rendering">Renderizado Simple</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#events">Eventos de la Vista</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Usando Vistas

Las vistas representan la interfaz de usuario de tu aplicación. Las vistas son frecuentemente archivos HTML con código PHP incrustado que realizan tareas relacionadas solamente a la presentación de datos. Las vistas llevan a cabo el trabajo de proveer datos al navegador web u otra herramienta que sea utilizada para hacer solicitudes desde tu aplicación.

`Phalcon\Mvc\View` y `Phalcon\Mvc\View\Simple` son responsables del manejo de la capa de vistas de tu aplicación MVC.

<a name='integrating-views-with-controllers'></a>

## Integrando Vistas con Controladores

Phalcon pasa automáticamente la ejecución al componente de vista tan pronto como un controlador particular ha completado su ciclo. El componente de vista buscará en la carpeta de vistas, una carpeta llamada como el mismo nombre del último controlador ejecutado y luego para un archivo nombrado como la última acción ejecutada. Por ejemplo, si se hace una petición a la URL *http://127.0.0.1/blog/posts/show/301*, Phalcon analizará la URL de la sigue manera:

| Dirección del servidor | 127.0.0.1 |
| ---------------------- | --------- |
| Directorio de Phalcon  | blog      |
| Controlador            | posts     |
| Acción                 | show      |
| Parámetro              | 301       |

El dispatcher o despachador buscará un `PostsController` y su acción `showAction`. Un archivo de controlador simple, para este ejemplo:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($postId)
    {
        // Pasamos el parámetro $postId a la vista
        $this->view->postId = $postId;
    }
}
```

El método `setVar()` nos permite crear variables en la vista a demanda, por lo que pueden ser utilizados en la plantilla de la vista. El ejemplo anterior muestra cómo se pasa el parámetro `$postId` a la respectiva plantilla de la vista.

<a name='hierarchical-rendering'></a>

## Renderizado Jerárquico

`Phalcon\Mvc\View` soporta una jerarquía de archivos y es el componente por defecto para la representación de vistas en Phalcon. Esta jerarquía permite puntos de plantilla comunes (vistas utilizadas comúnmente), así como carpetas con nombre del controlador que definen las respectivas plantillas de vista.

Este componente utiliza por defecto PHP en sí mismo como el motor de la plantilla, por lo tanto, las vistas deben tener la extensión `.phtml`. Si el directorio de vistas es *app/views* el componente de vista encontrará automáticamente estos tres archivos de vista.

| Nombre                    | Archivo                       | Descripción                                                                                                                                                                                                                       |
| ------------------------- | ----------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Vista de la acción        | app/views/posts/show.phtml    | Se trata de la vista relacionada con la acción. Sólo se mostrará cuando se ejecute la acción `show`.                                                                                                                              |
| Plantilla del controlador | app/views/layouts/posts.phtml | Esta es la vista relacionada con el controlador. Sólo se mostrará para cada acción ejecutada en el controlador "posts". Se reutilizará todo el código puesto en ejecución en el diseño de todas las acciones en este controlador. |
| Plantilla principal       | app/views/index.phtml         | Se trata de la acción principal que se mostrará para cada controlador o acción ejecutada dentro de la aplicación.                                                                                                                 |

No se requiere implementar todos los archivos antes mencionados. `Phalcon\Mvc\View` simplemente se moverá al siguiente nivel de la vista en la jerarquía de archivos. Si se aplican los 3 archivos, estos se procesaran de la siguiente manera:

```php
<!-- app/views/posts/show.phtml -->

<h3>Esto muestra la vista!</h3>

<p>Recibimos el parámetro: <?php echo $postId; ?></p>
```

```php
<!-- app/views/layouts/posts.phtml -->

<h2>Esta es la plantilla del controlador "posts"!</h2>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/index.phtml -->
<html>
    <head>
        <title>Ejemplo</title>
    </head>
    <body>

        <h1>Esta es la plantilla principal!</h1>

        <?php echo $this->getContent(); ?>

    </body>
</html>
```

Tenga en cuenta las líneas donde el método `$this->getContent()` fue llamado. Este método indica a `Phalcon\Mvc\View` en donde inyectar el contenido de la vista anterior en jerarquía. Para el ejemplo anterior, la salida sería:

.. figure:: ../_static/img/views-1.png :align: center

El código HTML generado por la solicitud será:

```php
<!-- app/views/index.phtml -->
<html>
    <head>
        <title>Ejemplo</title>
    </head>
    <body>

        <h1>Esta es la plantilla principal!</h1>

        <!-- app/views/layouts/posts.phtml -->

        <h2>Esta es la plantilla el controlador "posts"!</h2>

        <!-- app/views/posts/show.phtml -->

        <h3>Esta es la vista!</h3>

        <p>Recibimos el parámetro: 101</p>

    </body>
</html>
```

<a name='using-templates'></a>

### Usando Plantillas

Las plantillas son vistas que se pueden utilizar para compartir el código común de las vistas. Actúan como plantillas de controladores, por lo que necesitará colocarlas en el directorio de plantillas.

Las plantillas se pueden procesar antes del diseño (usando `$this->view->setTemplateBefore()`) o puede hacerse después (usando `$this->view->setTemplateAfter()`). En el ejemplo siguiente se renderiza la plantilla (`layouts/common.phtml`) después del controlador principal (`layouts/posts.phtml`):

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function initialize()
    {
        $this->view->setTemplateAfter('common');
    }

    public function lastAction()
    {
        $this->flash->notice(
            'Estos son los últimos posts'
        );
    }
}
```

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Título del Blog</title>
    </head>
    <body>
        <?php echo $this->getContent(); ?>
    </body>
</html>
```

```php
<!-- app/views/layouts/common.phtml -->

<ul class='menu'>
    <li><a href='/'>Página principal</a></li>
    <li><a href='/articles'>Artículos</a></li>
    <li><a href='/contact'>Contáctenos</a></li>
</ul>

<div class='content'><?php echo $this->getContent(); ?></div>
```

```php
<!-- app/views/layouts/posts.phtml -->

<h1>Título del Blog</h1>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/posts/last.phtml -->

<article>
    <h2>Este es el artículo</h2>
    <p>Este es el contenido de la publicación</p>
</article>

<article>
    <h2>Este es otro título</h2>
    <p>Este es el contenido de otra publicación</p>
</article>
```

El resultado final será el siguiente:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Título del Blog</title>
    </head>
    <body>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Página principal</a></li>
            <li><a href='/articles'>Artículos</a></li>
            <li><a href='/contact'>Contáctenos</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/layouts/posts.phtml -->

            <h1>Título del Blog</h1>

            <!-- app/views/posts/last.phtml -->

            <article>
                <h2>Este es un título</h2>
                <p>Este es el contenido de la publicación</p>
            </article>

            <article>
                <h2>Este es otro título</h2>
                <p>Este es el contenido de otra publicación</p>
            </article>

        </div>

    </body>
</html>
```

Si hubiéremos usado `$this->view->setTemplateBefore('common')`, este sería el resultado final:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Título del Blog</title>
    </head>
    <body>

        <!-- app/views/layouts/posts.phtml -->

        <h1>Título del Blog</h1>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Página principal</a></li>
            <li><a href='/articles'>Artículos</a></li>
            <li><a href='/contact'>Contáctenos</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/posts/last.phtml -->

            <article>
                <h2>Este es un título</h2>
                <p>Este es el contenido de la publicación</p>
            </article>

            <article>
                <h2>Este es otro título</h2>
                <p>Este es otro contenido de publicación</p>
            </article>

        </div>

    </body>
</html>
```

<a name='control-rendering-levels'></a>

### Control de Niveles de Renderizado

Como se vio anteriormente, `Phalcon\Mvc\View` soporta una jerarquía de vistas. Usted puede necesitar controlar el nivel de renderizado producido por el componente de la vista. El método `Phalcon\Mvc\View::setRenderLevel()` ofrece esta funcionalidad.

Este método puede ser invocado desde el controlador o desde una capa de vista superior para interferir en el proceso de renderizado.

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function findAction()
    {
        // Esta es una respuesta en Ajax, no es necesario generar ninguna vista
        $this->view->setRenderLevel(
            View::LEVEL_NO_RENDER
        );

        // ...
    }

    public function showAction($postId)
    {
        // Solo mostraremos la vista relacionada con la acción
        $this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );
    }
}
```

Los niveles de renderizado disponibles son:

| Constante de clase      | Descripción                                                                 | Orden |
| ----------------------- | --------------------------------------------------------------------------- |:-----:|
| `LEVEL_NO_RENDER`       | Indicado para evitar la generación de cualquier tipo de presentación.       |       |
| `LEVEL_ACTION_VIEW`     | Genera la presentación a la vista asociada a la acción.                     |   1   |
| `LEVEL_BEFORE_TEMPLATE` | Genera plantillas de presentación previas al diseño del controlador.        |   2   |
| `LEVEL_LAYOUT`          | Genera la presentación en el diseño del controlador.                        |   3   |
| `LEVEL_AFTER_TEMPLATE`  | Genera la presentación a las plantillas después del diseño del controlador. |   4   |
| `LEVEL_MAIN_LAYOUT`     | Genera la presentación en el diseño principal. Archivo views/index.phtml    |   5   |

<a name='disabling-render-levels'></a>

### Deshabilitar niveles de renderizado

Es posible deshabilitar permanentemente o temporalmente los niveles renderizado. Un nivel se puede desactivar permanentemente si no es utilizado en toda la aplicación:

```php
<?php

use Phalcon\Mvc\View;

$di->set(
    'view',
    function () {
        $view = new View();

        // Desactivar varios niveles
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

O desactivar temporalmente en alguna parte de la aplicación:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function findAction()
    {
        $this->view->disableLevel(
            View::LEVEL_MAIN_LAYOUT
        );
    }
}
```

<a name='picking-views'></a>

### Selección de Vistas

Como se mencionó anteriormente, cuando `Phalcon\Mvc\View` es administrada por `Phalcon\Mvc\Application` la vista renderizada está relacionada con el último controlador y acción ejecutadas. Podría anular esto mediante el método `Phalcon\Mvc\View::pick()`:

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function listAction()
    {
        // Seleccionar 'views-dir/products/search' como vista a renderizar
        $this->view->pick('products/search');

        // Seleccionar 'views-dir/books/list' como vista a renderizar
        $this->view->pick(
            [
                'books',
            ]
        );

        // Seleccionar 'views-dir/products/search' como vista a renderizar
        $this->view->pick(
            [
                1 => 'search',
            ]
        );
    }
}
```

<a name='disabling-view'></a>

### Deshabilitar la vista

Si su controlador no produce ninguna salida en la vista (o ni siquiera tiene una) es posible deshabilitar el componente de vista, evitando un procesamiento innecesario:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // Cerrar sesión
        // ...

        // Desactivar la vista para evitar renderizado
        $this->view->disable();
    }
}
```

Como alternativa, puede devolver `false` para producir el mismo resultado:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // ...

        // Desactivar la vista para evitar renderizado
        return false;
    }
}
```

Puede devolver un objeto `response` para evitar desactivar la vista manualmente:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // Cerrar sesión
        // ...

        // Una redirección HTTP
        return $this->response->redirect('index/index');
    }
}
```

<a name='simple-rendering'></a>

## Renderizado Simple

`Phalcon\Mvc\View\Simple` es un componente alternativo de `Phalcon\Mvc\View`. Mantiene la mayor parte de la filosofía del componente `Phalcon\Mvc\View` pero carece de una jerarquía de archivos que es, de hecho, la característica principal de su contraparte.

Este componente permite al desarrollador tener el control de cuando se representa una vista y su ubicación. Además, este componente puede aprovechar la herencia de vistas disponible en los motores de plantilla como `Volt` y otros.

Por defecto, este componente debe ser sustituido en el contenedor de servicios:

```php
<?php

use Phalcon\Mvc\View\Simple as SimpleView;

$di->set(
    'view',
    function () {
        $view = new SimpleView();

        $view->setViewsDir('../app/views/');

        return $view;
    },
    true
);
```

El renderizado automático debe estar deshabilitado en `Phalcon\Mvc\Application` (si es necesario):

```php
<?php

use Exception;
use Phalcon\Mvc\Application;

try {
    $application = new Application($di);

    $application->useImplicitView(false);

    $response = $application->handle();

    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

Para presentar una vista es necesario llamar explícitamente al método `render()` indicando la ruta relativa a la vista que desea mostrar:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {
        // Renderizar 'views-dir/index.phtml'
        echo $this->view->render('index');

        // Renderizar 'views-dir/posts/show.phtml'
        echo $this->view->render('posts/show');

        // Renderizar 'views-dir/index.phtml' pasando variables
        echo $this->view->render(
            'index',
            [
                'posts' => Posts::find(),
            ]
        );

        // Renderizar 'views-dir/posts/show.phtml' pasando variables
        echo $this->view->render(
            'posts/show',
            [
                'posts' => Posts::find(),
            ]
        );
    }
}
```

Esto es diferente a `Phalcon\Mvc\View` cuyo método `render()` utiliza los controladores y acciones como parámetros:

```php
<?php

$params = [
    'posts' => Posts::find(),
];

// Phalcon\Mvc\View
$view = new \Phalcon\Mvc\View();
echo $view->render('posts', 'show', $params);

// Phalcon\Mvc\View\Simple
$simpleView = new \Phalcon\Mvc\View\Simple();
echo $simpleView->render('posts/show', $params);
```

<a name='using-partials'></a>

## Usando parciales

Las plantillas parciales son otra forma de dividir el proceso de renderizado en fragmentos más simples y manejables que pueden ser reutilizados por diferentes partes de la aplicación. Con un parcial, se puede mover el código para representar una pieza particular de una respuesta a su propio archivo.

Una forma de utilizar elementos parciales es tratarlos como el equivalente de subrutinas: como una manera de mover datos de una vista para que su código pueda ser más fácilmente entendido. Por ejemplo, podría tener una vista con este aspecto:

```php
<div class='top'><?php $this->partial('shared/ad_banner'); ?></div>

<div class='content'>
    <h1>Robots</h1>

    <p>Revise nuestras ofertas para robots:</p>
    ...
</div>

<div class='footer'><?php $this->partial('shared/footer'); ?></div>
```

El método `partial()` acepta un segundo parámetro como un conjunto de variables o parámetros que sólo existe en el ámbito del parcial:

```php
<?php $this->partial('shared/ad_banner', ['id' => $site->id, 'size' => 'big']); ?>
```

<a name='value-transfer'></a>

## Transferencia de valores del controlador a la vista

`Phalcon\Mvc\View` está disponible en cada controlador utilizando la variable de vista (`$this->view`). Puede utilizar ese objeto para establecer variables directamente a la vista en una acción de controlador mediante el método `setVar()`.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction()
    {
        $user  = Users::findFirst();
        $posts = $user->getPosts();

        // Pasar todos los nombres de usuarios y las publicaciones a la vista
        $this->view->setVar('username', $user->username);
        $this->view->setVar('posts', $posts);

        // Utilizando los setters mágicos
        $this->view->username = $user->username;
        $this->view->posts    = $posts;

        // Pasando más de una variable al mismo tiempo
        $this->view->setVars(
            [
                'username' => $user->username,
                'posts'    => $posts,
            ]
        );
    }
}
```

Se creará una variable con el nombre del primer parámetro de `setVar()` en la vista, lista para ser utilizada. La variable puede ser de cualquier tipo, desde una simple cadena, entero, etcétera. a una variable con una estructura más compleja como una matriz, colección, etcétera.

```php
<h1>
    Publicaciones de {{ username }}
</h1>

<div class='post'>
<?php

    foreach ($posts as $post) {
        echo '<h2>', $post->title, '</h2>';
    }

?>
</div>
```

<a name='caching-fragments'></a>

## Almacenamiento en caché de fragmentos de la vista

A veces cuando desarrollas sitios web dinámicos y algunas áreas de ellos no se actualizan muy a menudo, la salida es exactamente el misma entre las solicitudes. `Phalcon\Mvc\View` ofrece el almacenamiento en caché de una parte o la salida renderizada entera para aumentar el rendimiento.

`Phalcon\Mvc\View` se integra con `Phalcon\Cache` para proporcionar una manera más fácil para almacenar fragmentos de salida. Manualmente puede establecer el gestor de caché o establecer un gestor global:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function showAction()
    {
        // Cachear una vista usando la configuración por defecto
        $this->view->cache(true);
    }

    public function showArticleAction()
    {
        // Cachear esta vista por una hora
        $this->view->cache(
            [
                'lifetime' => 3600,
            ]
        );
    }

    public function resumeAction()
    {
        // Cachear esta vista por un día con la clave 'resume-cache'
        $this->view->cache(
            [
                'lifetime' => 86400,
                'key'      => 'resume-cache',
            ]
        );
    }

    public function downloadAction()
    {
        // Pasando un servicio personalizado
        $this->view->cache(
            [
                'service'  => 'myCache',
                'lifetime' => 86400,
                'key'      => 'resume-cache',
            ]
        );
    }
}
```

Cuando no definimos una clave a la caché, el componente crea automáticamente una usando un hash [MD5](http://php.net/manual/en/function.md5.php) del nombre del controlador y de la vista que actualmente se están renderizando, en el formato `controlador/vista`. Es una buena práctica definir una clave para cada acción, así usted puede identificar fácilmente la caché asociada a cada vista.

Cuando el componente de vista necesita almacenar en caché algo, solicitará un servicio de caché desde el contenedor de servicios. La convención de nombres de servicio para este servicio es `viewCache`:

```php
<?php

use Phalcon\Cache\Frontend\Output as OutputFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheBackend;

// Configuramos el servicio de cache para las vistas
$di->set(
    'viewCache',
    function () {
        // Por defecto, almacenar datos por un día
        $frontCache = new OutputFrontend(
            [
                'lifetime' => 86400,
            ]
        );

        // Configuración de conexión con Memcached
        $cache = new MemcacheBackend(
            $frontCache,
            [
                'host' => 'localhost',
                'port' => '11211',
            ]
        );

        return $cache;
    }
);
```

<div class="alert alert-warning">
    <p>
        El frontend debe ser siempre <a href="/[[language]]/[[version]]/api/Phalcon_Cache_Frontend_Output">Phalcon\Cache\Frontend\Output</a> y el servicio <code>viewCache</code> debe estar registrado siempre como abierto (no compartido) en el contenedor de servicios (DI).
    </p>
</div>

Al usar vistas, el almacenamiento en caché se puede usar para evitar que los controladores tengan que generar los datos de la vista en cada solicitud.

Para lograr esto debemos identificar de forma única cada cache con una clave. Primero verificamos que la caché no existe o si ha expirado, para hacer los cálculos y consultas a mostrar en la vista:

```php
<?php

use Phalcon\Mvc\Controller;

class DownloadController extends Controller
{
    public function indexAction()
    {
        // Comprobar si existe o ha expirado el cache con clave 'downloads'
        if ($this->view->getCache()->exists('downloads')) {
            // Consultar últimas descargas
            $latest = Downloads::find(
                [
                    'order' => 'created_at DESC',
                ]
            );

            $this->view->latest = $latest;
        }

        // Activar el cache con la misma clave 'downloads'
        $this->view->cache(
            [
                'key' => 'downloads',
            ]
        );
    }
}
```

El [sitio alternativo de PHP](https://github.com/phalcon/php-site) es un ejemplo de implementación del almacenamiento en fragmentos de caché.

<a name='template-engines'></a>

## Motores de Plantillas

Los motores de plantillas ayudan a los diseñadores a crear vistas sin el uso de una sintaxis complicada. Phalcon incluye un motor de plantillas de gran alcance y muy rápido, llamado `Volt`. `Phalcon\Mvc\View` le permite utilizar otros motores de plantillas en lugar de PHP o Volt.

Usando un motor diferente, generalmente requiere un análisis de texto complejo mediante el uso de bibliotecas PHP externas para generar el resultado final para el usuario. Esto generalmente incrementa el número de recursos que utilizará la aplicación.

Si se utiliza un motor de plantilla externo, `Phalcon\Mvc\View` proporciona exactamente la misma jerarquía de vistas y es posible acceder al API dentro de estas plantillas con un poco más de esfuerzo.

Este componente utiliza adaptadores, estos ayudan a Phalcon a hablar con los motores de plantillas externos en forma unificada, vamos a ver cómo hacer una integración.

<a name='custom-template-engine'></a>

### Crea tu propio adaptador de motor de plantillas

Hay muchos motores de plantillas que puede integrar o puede crear uno propio. El primer paso para empezar a utilizar un motor externo es crear un adaptador.

Un adaptador de motor de la plantilla es una clase que actúa como puente entre el `Phalcon\Mvc\View` y el motor mismo. Generalmente sólo hay dos métodos implementados: `__construct ()` y `render()`. El primero de ellos recibe la instancia de `Phalcon\Mvc\View` que crea el adaptador del motor y el contenedor DI utilizado por la aplicación.

El método `render()` acepta una ruta de acceso absoluta del archivo de la vista y los parámetros de la vista usando `$this->view->setVar()`. Puedes leerlo o requerirlo cuando sea necesario.

```php
<?php

use Phalcon\DiInterface;
use Phalcon\Mvc\Engine;

class MyTemplateAdapter extends Engine
{
    /**
     * Constructor del adaptador
     *
     * @param \Phalcon\Mvc\View $view
     * @param \Phalcon\Di $di
     */
    public function __construct($view, DiInterface $di)
    {
        // Aquí inicializamos el adaptador
        parent::__construct($view, $di);
    }

    /**
     * Renderizamos una vista usando el motor de plantillas
     *
     * @param string $path
     * @param array $params
     */
    public function render($path, $params)
    {
        // Accedemos a la vista
        $view = $this->_view;

        // Accedemos a las opciones
        $options = $this->_options;

        // Renderizamos la vista
        // ...
    }
}
```

<a name='changing-template-engine'></a>

### Cambiar el motor de plantillas

Es posible reemplazar el motor de plantillas completamente o utilizar más de un motor de plantillas al mismo tiempo. El método `Phalcon\Mvc\View::registerEngines()` acepta una matriz que contiene los datos que definen a los motores de plantillas. La clave de cada motor es la extensión de los archivos que ayudará a distinguir entre uno y otro. Los archivos de plantilla relacionados con un motor en particular deben tener dichas extensiones.

La orden en que los motores se definen con `Phalcon\Mvc\View::registerEngines()` define la relevancia en la ejecución. Si `Phalcon\Mvc\View` encuentra a dos vistas con el mismo nombre pero distintas extensiones, sólo renderizará la primera de ellas.

Si desea registrar un motor o un conjunto de ellos para cada solicitud en la aplicación. Podría registrarlo cuando se crea el servicio de vista:

```php
<?php

use Phalcon\Mvc\View;

// Configurar el componente de vista
$di->set(
    'view',
    function () {
        $view = new View();

        // Se requiere un separador de directorios al final
        $view->setViewsDir('../app/views/');

        // Establecer el motor
        $view->registerEngines(
            [
                '.my-html' => 'MyTemplateAdapter',
            ]
        );

        // Utilizar más de un motor de plantillas
        $view->registerEngines(
            [
                '.my-html' => 'MyTemplateAdapter',
                '.phtml'   => 'Phalcon\Mvc\View\Engine\Php',
            ]
        );

        return $view;
    },
    true
);
```

Hay adaptadores disponibles para varios motores de plantillas en la [incubadora de Phalcon](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Mvc/View/Engine)

<a name='injecting-services'></a>

## Inyectando servicios en la vista

Cada vista ejecutada está incluida dentro de una instancia de `Phalcon\Di\Injectable`, proporcionando fácil acceso al contenedor de servicios de la aplicación.

En el ejemplo siguiente se muestra cómo escribir con jQuery una [petición ajax](http://api.jquery.com/jQuery.ajax/) utilizando una URL con los convenios del framework. El servicio `url` (generalmente `Phalcon\Mvc\Url`) es inyectado en la vista accediendo a la propiedad del mismo nombre:

```js
<script type='text/javascript'>

$.ajax({
    url: '<?php echo $this->url->get('cities/get'); ?>'
})
.done(function () {
    alert('Terminado!');
});

</script>
```

<a name='stand-alone'></a>

## Componente independiente

Todos los componentes de Phalcon pueden utilizarse como *pegamento* de componentes individualmente porque están debilmente acoplados entre si:

<a name='stand-alone-hierarchical-rendering'></a>

### Renderizado Jerárquico

A continuación mostraremos como utilizar `Phalcon\Mvc\View` en modo independiente:

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

// Es requerido el separador de directorios al final
$view->setViewsDir('../app/views/');

// Pasando variables a las vistas, estás se crearán como variables locales
$view->setVar('someProducts', $products);
$view->setVar('someFeatureEnabled', true);

// Comenzar el buffer de salida
$view->start();

// Renderizar toda la jerarquía relacionada con la vista products/list.phtml
$view->render('products', 'list');

// Finalizamos el buffer de salida
$view->finish();

echo $view->getContent();
```

También existe una sintaxis corta:

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

echo $view->getRender(
    'products',
    'list',
    [
        'someProducts'       => $products,
        'someFeatureEnabled' => true,
    ],
    function ($view) {
        // Configurar aquí cualquier opción extra

        $view->setViewsDir('../app/views/');

        $view->setRenderLevel(
            View::LEVEL_LAYOUT
        );
    }
);
```

<a name='stand-alone-simple-rendering'></a>

### Renderizado Simple

A continuación mostraremos como utilizar `Phalcon\Mvc\View\Simple` en modo independiente:

```php
<?php

use Phalcon\Mvc\View\Simple as SimpleView;

$view = new SimpleView();

// Es requerido el separador de directorios al final
$view->setViewsDir('../app/views/');

// Renderizar una vista y regresar el contenido como una cadena
echo $view->render('templates/welcomeMail');

// Renderizar una vista pasando parámetros
echo $view->render(
    'templates/welcomeMail',
    [
        'email'   => $email,
        'content' => $content,
    ]
);
```

<a name='events'></a>

## Eventos de la Vista

`Phalcon\Mvc\View` y `Phalcon\Mvc\View\Simple` son capaces de enviar eventos a un `EventsManager` si este está presente. Los eventos se desencadenan mediante el tipo `view`. Si algún evento devuelve false podría detener la operación activa. Son soportados los siguientes eventos:

| Nombre de Evento | Activador                                               | ¿Puede detener la operación? |
| ---------------- | ------------------------------------------------------- |:----------------------------:|
| beforeRender     | Activado antes de iniciar el proceso de renderización   |              Sí              |
| beforeRenderView | Activado antes de renderizar una vista existente        |              Sí              |
| afterRenderView  | Activado después de renderizar una vista existente      |              No              |
| afterRender      | Activado después de completar el proceso de renderizado |              No              |
| notFoundView     | Activado cuando una vista no se encontró                |              No              |

En el ejemplo siguiente, se muestra cómo adjuntar oyentes (listeners) a este componente:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View;

$di->set(
    'view',
    function () {
        // Crear un gestor de eventos
        $eventsManager = new EventsManager();

        // Adjuntar un oyente para el tipo 'view'
        $eventsManager->attach(
            'view',
            function (Event $event, $view) {
                echo $event->getType(), ' - ', $view->getActiveRenderPath(), PHP_EOL;
            }
        );

        $view = new View();

        $view->setViewsDir('../app/views/');

        // Enlazar el eventsManager con el componente de la vista
        $view->setEventsManager($eventsManager);

        return $view;
    },
    true
);
```

En el ejemplo siguiente, se muestra cómo crear un plugin que limpia y repara el código HTML producido por el proceso de renderizado, utilizando la extensión [Tidy](http://www.php.net/manual/en/book.tidy.php):

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

// Adjuntar el plugin como un oyente
$eventsManager->attach(
    'view:afterRender',
    new TidyPlugin()
);
```