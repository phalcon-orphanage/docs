<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Formación de Colas</a>
    </li>
    <li>
      <a href="$overview">Enrutamiento</a> <ul>
        <li>
          <a href="$defining">Definición de rutas</a> <ul>
            <li>
              <a href="$defining-named-parameters">Parámetros con nombres</a>
            </li>
            <li>
              <a href="$defining-short-syntax">Sintaxis corta</a>
            </li>
            <li>
              <a href="$defining-mixed-parameters">Mezcla de array y sintaxis corta</a>
            </li>
            <li>
              <a href="$defining-route-to-modules">Enrutamiento a los módulos</a>
            </li>
            <li>
              <a href="$defining-http-method-restrictions">Restricciones del método HTTP</a>
            </li>
            <li>
              <a href="$defining-using-conversors">Utilizando conversores</a>
            </li>
            <li>
              <a href="$defining-groups-of-routes">Grupos de rutas</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="$matching">Rutas coincidentes</a>
        </li>
        <li>
          <a href="$naming">Nombres de rutas</a>
        </li>
        <li>
          <a href="$usage">Ejemplos de Uso</a>
        </li>
        <li>
          <a href="$default-behavior">Comprotamiento predeterminado</a>
        </li>
        <li>
          <a href="$default-route">Establecer la ruta por defecto</a>
        </li>
        <li>
          <a href="$not-found-paths">Rutas Not Found</a>
        </li>
        <li>
          <a href="$default-paths">Configurar rutas por defecto</a>
        </li>
        <li>
          <a href="$extra-slashes">Tratar con barras extra o finales</a>
        </li>
        <li>
          <a href="$callbacks">Coincidencias por llamada de retorno</a>
        </li>
        <li>
          <a href="$hostname-constraints">Restricciones de nombre de host</a>
        </li>
        <li>
          <a href="$uri-sources">Fuentes URI</a>
        </li>
        <li>
          <a href="$testing">Probando tus rutas</a>
        </li>
        <li>
          <a href="$annotations">Anotaciones de Router</a>
        </li>
        <li>
          <a href="$registration">Registro de instancia de Router</a>
        </li>
        <li>
          <a href="$custom">Implementar tu propio Router</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Enrutamiento

El componente router le permite definir las rutas que se asignan a los controladores o gestores que deben recibir la solicitud. Un router simplemente procesa un URI para determinar esta información. El router tiene dos modos: MVC y match mode. El primer modo es ideal para trabajar con aplicaciones de MVC.

<a name='defining'></a>

## Definición de rutas

`Phalcon\Mvc\Router` proporciona capacidades avanzadas de enrutamiento. En el modo de MVC, puede definir rutas y vincularlas a controladores/acciones que usted requiera. Una ruta es definida de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Router;

// Crear un Router
$router = new Router();

// Definir una ruta
$router->add(
    '/admin/users/my-profile',
    [
        'controller' => 'users',
        'action'     => 'profile',
    ]
);

// Otra ruta
$router->add(
    '/admin/users/change-password',
    [
        'controller' => 'users',
        'action'     => 'changePassword',
    ]
);

$router->handle();
````

El primer parámetro del método <code>add()</code> es el patrón que quieres coincidir, opcionalmente, el segundo parámetro es para definir los caminos.
En este caso, si el URI es '/admin/users/my-profile', entonces se ejecutará del controlador 'users' la acción 'profile'. Es importante recordar que el router no ejecuta el controlador y la acción, sólo recoge esta información para informar la componente correcto (es decir, 'Phalcon\Mvc\Dispatcher') cual es el controlador y acción que debe ejecutar.

Una aplicación puede tener muchos caminos y definir rutas una por una puede ser una tarea engorrosa. En estos casos podemos crear rutas más flexibles:

```php
<?php

use Phalcon\Mvc\Router;

// Crear el router
$router = new Router();

// Definir una ruta
$router->add(
    '/admin/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);
``` es el patrón que quieres coincidir, opcionalmente, el segundo parámetro es para definir los caminos.
En este caso, si el URI es '/admin/users/my-profile', entonces se ejecutará del controlador 'users' la acción 'profile'. Es importante recordar que el router no ejecuta el controlador y la acción, sólo recoge esta información para informar la componente correcto (es decir, 'Phalcon\Mvc\Dispatcher') cual es el controlador y acción que debe ejecutar.

Una aplicación puede tener muchos caminos y definir rutas una por una puede ser una tarea engorrosa. En estos casos podemos crear rutas más flexibles:

```php
<?php

use Phalcon\Mvc\Router;

// Crear el router
$router = new Router();

// Definir una ruta
$router->add(
    '/admin/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);
</code>

En el ejemplo anterior, estamos usando comodines para hacer una ruta válida para muchos URIs. Por ejemplo, accediendo a la siguiente URL (`/admin/users/al/delete/dave/301`) produciría:

| Controlador | Acción | Parámetro | Parámetro |
|:-----------:|:------:|:---------:|:---------:|
|    users    | delete |   dave    |    301    |

El método `add()` recibe un patrón que opcionalmente se han predefinido los marcadores de posición y los modificadores de la expresión regular. Todos los patrones de enrutamiento deben comenzar con un carácter de barra diagonal (`/`). La sintaxis de expresión regular utilizada es igual a las [expresiones regulares PCRE](http://www.php.net/manual/en/book.pcre.php). Tenga en cuenta que, no es necesario añadir los delimitadores de expresión regular. Todos los patrones de ruta no distinguen entre mayúsculas y minúsculas.

El segundo parámetro define cómo las partes coincidentes deben enlazar al controlador/acción/parámetros. Las partes coincidentes son marcadores o subpatrones delimitados por paréntesis (corchetes redondeados). En el ejemplo anterior, el primer subpatrón de coincidencia (`:controller`) es la parte del controlador de la ruta, el segundo la acción y así sucesivamente.

Estos marcadores ayudan a escribir expresiones regulares que son más legibles para los desarrolladores y más fácil de entender. Están disponibles los siguientes marcadores:

| Marcador       | Expresión regular        | Uso                                                                                                                  |
| -------------- | ------------------------ | -------------------------------------------------------------------------------------------------------------------- |
| `/:module`     | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de módulo válido con caracteres alfanuméricos únicamente                                      |
| `/:controller` | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de controlador válido con caracteres alfanuméricos únicamente                                 |
| `/:action`     | `/([a-zA-Z0-9_-]+)`      | Coincide con un nombre de acción válido con caracteres alfanuméricos únicamente                                      |
| `/:params`     | `(/.*)*`                 | Coincide con una lista de palabras opcionales, separadas por barras. Sólo utilice este marcador al final de una ruta |
| `/:namespace`  | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de espacio de nombres de nivel único                                                          |
| `/:int`        | `/([0-9]+)`              | Coincide con un parámetro entero                                                                                     |

Los nombres de controlador son camelizados, esto significa que los caracteres (`-`) y (`_`) se quitan y el siguiente carácter se transformará en mayúscula. Por ejemplo, some_controller se convierte en SomeController.

Puesto que puede agregar tantas rutas como necesite mediante el método `add()`, el orden en que se agregan rutas indican su relevancia, las últimas rutas añadidas tienen más importancia que las primeras. Internamente, todas las rutas definidas son recorridas en orden inverso hasta que `Phalcon\Mvc\Router` encuentra una que coincida con la URI dada y la procesará, mientras que el resto serán ignoradas.

<a name='defining-named-parameters'></a>

### Parámetros con nombres

El ejemplo siguiente muestra cómo definir nombres a los parámetros de ruta:

```php
<?php

$router->add(
    '/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params',
    [
        'controller' => 'posts',
        'action'     => 'show',
        'year'       => 1, // ([0-9]{4})
        'month'      => 2, // ([0-9]{2})
        'day'        => 3, // ([0-9]{2})
        'params'     => 4, // :params
    ]
);
```

En el ejemplo anterior, la ruta no define una parte `controlador` o `acción`. Estas partes se reemplazan por valores fijos (`posts` and `show`). El usuario no sabrá el controlador realmente enviado por la solicitud. Dentro del controlador, se puede acceder a los parámetros nombrados de la siguiente manera:

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
        // Obtener el parámetro 'año'
        $year = $this->dispatcher->getParam('year');

        // Obtener el parámetro 'mes'
        $month = $this->dispatcher->getParam('month');

        // Obtener el parámetro 'día'
        $day = $this->dispatcher->getParam('day');

        // ...
    }
}
```

Tenga en cuenta que los valores de los parámetros se obtienen del despachador. Esto sucede porque es el componente que finalmente interactua con los controladores de su aplicación. Además, también hay otra forma de crear parámetros con nombre como parte del patrón:

```php
<?php

$router->add(
    '/documentation/{chapter}/{name}.{type:[a-z]+}',
    [
        'controller' => 'documentation',
        'action'     => 'show',
    ]
);
```

Puede acceder a sus valores de la misma manera que antes:

```php
<?php

use Phalcon\Mvc\Controller;

class DocumentationController extends Controller
{
    public function showAction()
    {
        // Obtener el parámetro 'nombre'
        $name = $this->dispatcher->getParam('name');

        // Obtener el parámetro 'tipo'
        $type = $this->dispatcher->getParam('type');

        // ...
    }
}
```

<a name='defining-short-syntax'></a>

### Sintaxis corta

Si no le gusta usar una matriz para definir las rutas de ruta, también hay disponible una sintaxis alternativa. Los siguientes ejemplos producen el mismo resultado:

```php
<?php

// Forma corta
$router->add(
    '/posts/{year:[0-9]+}/{title:[a-z\-]+}',
    'Posts::show'
);

// Forma Array 
$router->add(
    '/posts/([0-9]+)/([a-z\-]+)',
    [
       'controller' => 'posts',
       'action'     => 'show',
       'year'       => 1,
       'title'      => 2,
    ]
);
```

<a name='defining-mixed-parameters'></a>

### Mezcla de array y sintaxis corta

La matriz y la sintaxis corta se pueden mezclar para definir una ruta; en este caso, observe que los parámetros con nombre se agregan automáticamente a las rutas de ruta según la posición en la que se definieron:

```php
<?php

// La primera posición se debe omitir porque se usa para
// el parámetro nombrado 'país'
$router->add(
    '/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])',
    [
        'section' => 2, // Las posiciones comienzan con 2
        'article' => 3,
    ]
);
```

<a name='defining-route-to-modules'></a>

### Enrutamiento a los módulos

Puede definir rutas cuyas caminos incluyen módulos. Esto es especialmente adecuado para aplicaciones de varios módulos. Es posible definir una ruta predeterminada que incluya un comodín de módulo:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router(false);

$router->add(
    '/:module/:controller/:action/:params',
    [
        'module'     => 1,
        'controller' => 2,
        'action'     => 3,
        'params'     => 4,
    ]
);
```

En este caso, la ruta siempre debe tener el nombre del módulo como parte de la URL. Por ejemplo, la siguiente URL: `/admin/users/edit/sonny` se procesará como:

| Módulo | Controlador | Acción | Parámetro |
|:------:|:-----------:|:------:|:---------:|
| admin  |    users    |  edit  |   sonny   |

O puede vincular rutas específicas a módulos específicos:

```php
<?php

$router->add(
    '/login',
    [
        'module'     => 'backend',
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/products/:action',
    [
        'module'     => 'frontend',
        'controller' => 'products',
        'action'     => 1,
    ]
);
```

O agréguelos a namespaces específicos:

```php
<?php

$router->add(
    '/:namespace/login',
    [
        'namespace'  => 1,
        'controller' => 'login',
        'action'     => 'index',
    ]
);
```

Los nombres de Namespaces/class se deben pasar separados:

```php
<?php

$router->add(
    '/login',
    [
        'namespace'  => 'Backend\Controllers',
        'controller' => 'login',
        'action'     => 'index',
    ]
);
```

<a name='defining-http-method-restrictions'></a>

### Restricciones del método HTTP

Cuando agrega una ruta usando simplemente `add()`, la ruta se habilitará para cualquier método HTTP. A veces podemos restringir una ruta a un método específico, esto es especialmente útil al crear aplicaciones RESTful:

```php
<?php

// Esta ruta solo se combinará si el método HTTP es GET
$router->addGet(
    '/products/edit/{id}',
    'Products::edit'
);

// Esta ruta solo se combinará si el método HTTP es POST
$router->addPost(
    '/products/save',
    'Products::save'
);

// Esta ruta se combinará si el método HTTP es POST o PUT
$router->add(
    '/products/update',
    'Products::update'
)->via(
    [
        'POST',
        'PUT',
    ]
);
```

<a name='defining-using-conversors'></a>

### Utilizando conversores

Los conversores le permiten transformar libremente los parámetros de la ruta antes de pasarlos al dispatcher. Los siguientes ejemplos muestran cómo usarlos:

```php
<?php

// El nombre de la acción permite guiones, una acción puede ser: /products/new-ipod-nano-4-generation
$route = $router->add(
    '/products/{slug:[a-z\-]+}',
    [
        'controller' => 'products',
        'action'     => 'show',
    ]
);

$route->convert(
    'slug',
    function ($slug) {
        // Transformar la slug quitando los guiones
        return str_replace('-', '', $slug);
    }
);
```

Otro caso de uso para conversores es vincular un modelo en una ruta. Esto permite que el modelo pase directamente a la acción definida:

```php
<?php

// Este ejemplo se basa en la suposición de que el ID se está utilizando como parámetro en la url:
 /products/4
$route = $router->add(
    '/products/{id}',
    [
        'controller' => 'products',
        'action'     => 'show',
    ]
);

$route->convert(
    'id',
    function ($id) {
        // Obtener el modelo
        return Product::findFirstById($id);
    }
);
```

<a name='defining-groups-of-routes'></a>

### Grupos de rutas

Si un conjunto de rutas tiene caminos comunes, se pueden agrupar para mantenerlas fácilmente:

```php
<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router = new Router();

// Crea un grupo con un módulo y un controlador común
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'index',
    ]
);

// Todas las rutas comienzan con /blog
$blog->setPrefix('/blog');

// Agrega una ruta al grupo
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Agregue otra ruta al grupo
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// Esta ruta se asigna a un controlador diferente al predeterminado
$blog->add(
    '/blog',
    [
        'controller' => 'blog',
        'action'     => 'index',
    ]
);

// Agregue el grupo al enrutador
$router->mount($blog);
```

Puede mover grupos de rutas a archivos separados para mejorar la organización y la reutilización de código en la aplicación:

```php
<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

class BlogRoutes extends RouterGroup
{
    public function initialize()
    {
        // Rutas predeterminadas
        $this->setPaths(
            [
                'module'    => 'blog',
                'namespace' => 'Blog\Controllers',
            ]
        );

        // Todas las rutas comienzan con /blog
        $this->setPrefix('/blog');

        // Agrega una ruta al grupo
        $this->add(
            '/save',
            [
                'action' => 'save',
            ]
        );

        // Agregue otra ruta al grupo
        $this->add(
            '/edit/{id}',
            [
                'action' => 'edit',
            ]
        );

        // Esta ruta se asigna a un controlador diferente al predeterminado
        $this->add(
            '/blog',
            [
                'controller' => 'blog',
                'action'     => 'index',
            ]
        );
    }
}
```

Luego monte el grupo en el router:

```php
<?php

// Agregue el grupo al enrutador
$router->mount(
    new BlogRoutes()
);
```

<a name='matching'></a>

## Rutas coincidentes

Se debe pasar un URI válido al Router para que pueda procesarlo y encontrar una ruta coincidente. De forma predeterminada, el URI de enrutamiento se toma de la variable `$_GET['_url']` creada por el módulo de motor de re-escritura. Un par de reglas de re-escritura que funcionan muy bien con Phalcon son:

```apacheconfig
RewriteEngine On
RewriteCond   %{REQUEST_FILENAME} !-d
RewriteCond   %{REQUEST_FILENAME} !-f
RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
```

En esta configuración, cualquier solicitud a archivos o carpetas que no existen se enviará a `index.php`. El siguiente ejemplo muestra cómo usar este componente en modo independiente:

```php
<?php

use Phalcon\Mvc\Router;

// Creando un enrutador
$router = new Router();

// Definir rutas aquí si alguna
// ...

// Tomando el URI de $_GET['_url']
$router->handle();

// O estableciendo el valor de URI directamente
$router->handle('/employees/edit/17');

// Obtener el controlador procesado
echo $router->getControllerName();

// Obtener la acción procesada
echo $router->getActionName();

// Obtener la ruta correspondiente
$route = $router->getMatchedRoute();
```

<a name='naming'></a>

## Nombres de rutas

Cada ruta que se agrega al router se almacena internamente como un objeto `Phalcon\Mvc\Router\Route`. Esa clase encapsula todos los detalles de cada ruta. Por ejemplo, podemos darle un nombre a una ruta para identificarlo de manera única en nuestra aplicación. Esto es especialmente útil si desea crear URLs a partir de él.

```php
<?php

$route = $router->add(
    '/posts/{year}/{title}',
    'Posts::show'
);

$route->setName('show-posts');
```

Luego, usando por ejemplo el componente `Phalcon\Mvc\Url` podemos construir rutas desde su nombre:

```php
<?php

// Returns /posts/2012/phalcon-1-0-released
echo $url->get(
    [
        'for'   => 'show-posts',
        'year'  => '2012',
        'title' => 'phalcon-1-0-released',
    ]
);
```

<a name='usage'></a>

## Ejemplos de Uso

Los siguientes son ejemplos de rutas personalizadas:

```php
<?php

// Coincidencia '/system/admin/a/edit/7001'
$router->add(
    '/system/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);

// Coincidencia '/es/news'
$router->add(
    '/([a-z]{2})/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
        'language'   => 1,
    ]
);

// Coincidencia '/es/news'
$router->add(
    '/{language:[a-z]{2}}/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);

// Coincidencia '/admin/posts/edit/100'
$router->add(
    '/admin/:controller/:action/:int',
    [
        'controller' => 1,
        'action'     => 2,
        'id'         => 3,
    ]
);

// Coincidencia '/posts/2015/02/some-cool-content'
$router->add(
    '/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)',
    [
        'controller' => 'posts',
        'action'     => 'show',
        'year'       => 1,
        'month'      => 2,
        'title'      => 3,
    ]
);

// Coincidencia '/manual/en/translate.adapter.html'
$router->add(
    '/manual/([a-z]{2})/([a-z\.]+)\.html',
    [
        'controller' => 'manual',
        'action'     => 'show',
        'language'   => 1,
        'file'       => 2,
    ]
);

// Coincidencia /feed/fr/le-robots-hot-news.atom
$router->add(
    '/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}',
    'Feed::get'
);

// Coincidencia /api/v1/users/peter.json
$router->add(
    '/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)',
    [
        'controller' => 'api',
        'version'    => 1,
        'format'     => 4,
    ]
);
```

<h5 class='alert alert-warning'>Ten cuidado con los caracteres permitidos en una expresión regular para los controladores y los espacios de nombres. Éstos se convierten en nombres de clase y a su vez estos son pasados a través del sistema de archivos y podrían ser utilizados por atacantes para leer archivos no autorizados. Una expresión regular segura puede ser así: <code>/([a-zA-Z0-9\_\-]+)</code> </h5>

<a name='default-behavior'></a>

## Comportamiento predeterminado

`Phalcon\Mvc\Router` tiene un comportamiento predeterminado que proporciona un enrutamiento muy simple que siempre espera un URI que coincida con el siguiente patrón: `/:controller/:action/:params`

Por ejemplo, para una URL como esta `http://phalconphp.com/documentation/show/about.html`, este router lo traducirá de la siguiente manera:

|  Controlador  | Acción | Parámetro  |
|:-------------:|:------:|:----------:|
| documentation |  show  | about.html |

Si no desea que el router tenga este comportamiento, debe crear el router pasando `false` como primer parámetro:

```php
<?php

use Phalcon\Mvc\Router;

// Crea el enrutador sin rutas predeterminadas
$router = new Router(false);
```

<a name='default-route'></a>

## Establecer la ruta por defecto

Cuando se accede a su aplicación sin ninguna ruta, la ruta '/' se usa para determinar qué rutas se deben usar para mostrar la página inicial en su sitio web/aplicación:

```php
<?php

$router->add(
    '/',
    [
        'controller' => 'index',
        'action'     => 'index',
    ]
);
```

<a name='not-found-paths'></a>

## Rutas no encontradas

Si ninguna de las rutas especificadas en el router coincide, puede definir un grupo de rutas para usar en este escenario:

```php
<?php

// Establecer camino 404
$router->notFound(
    [
        'controller' => 'index',
        'action'     => 'route404',
    ]
);
```

Esto es tipicamente para una página Error 404.

<a name='default-paths'></a>

## Configurar rutas por defecto

Es posible definir valores predeterminados para el módulo, controlador o acción. Cuando a una ruta le falta alguna de esas rutas, el router puede completarla automáticamente:

```php
<?php

// Establecer un predeterminado específico
$router->setDefaultModule('backend');
$router->setDefaultNamespace('Backend\Controllers');
$router->setDefaultController('index');
$router->setDefaultAction('index');

// Using an array
$router->setDefaults(
    [
        'controller' => 'index',
        'action'     => 'index',
    ]
);
```

<a name='extra-slashes'></a>

## Tratar con barras extra o finales

A veces se puede acceder a una ruta con barras posteriores extras. Esas barras adicionales llevarían a producir un estado no-encontrado en el despachador. Puede configurar el router para eliminar automáticamente las barras desde el final de la ruta administrada:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// Eliminar barras diagonales automáticamente
$router->removeExtraSlashes(true);
```

O bien, puede modificar rutas específicas para aceptar opcionalmente barras inclinadas posteriores:

```php
<?php

// El patrón [/]{0,1} permite a esta ruta tener opcionalmente una barra al final
$router->add(
    '/{language:[a-z]{2}}/:controller[/]{0,1}',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);
```

<a name='callbacks'></a>

## Coincidencias por llamada de retorno

A veces, las rutas solo deben coincidir si cumplen con condiciones específicas. Puede agregar condiciones arbitrarias a las rutas usando la devolución de llamada `beforeMatch()`. Si esta función devuelve `false`, la ruta se tratará como no-coincidente:

```php
<?php

$route = $router->add('/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
    ]
);

$route->beforeMatch(
    function ($uri, $route) {
        // Comprobar si la consulta fue hecha con Ajax
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return false;
        }

        return true;
    }
);
```

Puede volver a utilizar estas condiciones adicionales en las clases:

```php
<?php

class AjaxFilter
{
    public function check()
    {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}
```

Y usa esta clase en lugar de la función anónima:

```php
<?php

$route = $router->add(
    '/get/info/{id}',
    [
        'controller' => 'products',
        'action'     => 'info',
    ]
);

$route->beforeMatch(
    [
        new AjaxFilter(),
        'check'
    ]
);
```

A partir de Phalcon 3, hay otra forma de comprobar esto:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
    ]
);

$route->beforeMatch(
    function ($uri, $route) {
        /**
         * @var string $uri
         * @var \Phalcon\Mvc\Router\Route $route
         * @var \Phalcon\DiInterface $this
         * @var \Phalcon\Http\Request $request
         */
        $request = $this->getShared('request');

        // Verifica si la solicitud fue hecha con Ajax
        return $request->isAjax();
    }
);
```

<a name='hostname-constraints'></a>

## Restricciones de nombre de host

El router le permite establecer restricciones de nombre de host, esto significa que las rutas específicas o un grupo de rutas pueden restringirse para que solo coincidan si la ruta también cumple con la restricción de nombre de host:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
        'action'     => 'login',
    ]
);

$route->setHostName('admin.company.com');
```

El nombre de host también se puede pasar como expresiones regulares:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
        'action'     => 'login',
    ]
);

$route->setHostName('([a-z]+).company.com');
```

En grupos de rutas, puede configurar una restricción de nombre de host que se aplique a todas las rutas del grupo:

```php
<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

// Crear un grupo con un módulo y un controlador en común
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'posts',
    ]
);

// Restricción de nombre de host
$blog->setHostName('blog.mycompany.com');

// Todas las rutas comienzan con /blog
$blog->setPrefix('/blog');

// Ruta por defecto
$blog->add(
    '/',
    [
        'action' => 'index',
    ]
);

// Agregar una ruta por defecto
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Agregar otra ruta al grupo
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// Agregar el grupo al router
$router->mount($blog);
```

<a name='uri-sources'></a>

## Fuentes URI

Por defecto, la información del URI se obtiene de la variable `$_GET['_url']`, esto es pasado por Rewrite-Engine a Phalcon, también puede usar `$_SERVER['REQUEST_URI']` si es necesario:

```php
<?php

use Phalcon\Mvc\Router;

// ...

// Usar $_GET['_url'] (por defecto)
$router->setUriSource(
    Router::URI_SOURCE_GET_URL
);

// Usar $_SERVER['REQUEST_URI']
$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);
```

O puede pasar manualmente el URI al método `handle()`:

```php
<?php

$router->handle('/some/route/to/handle');
```

<h5 class='alert alert-danger'>Ten en cuenta que al usar <code>Router::URI_SOURCE_GET_URL</code> la Uri sera decodificada automáticamente porque se basa en la solicitud <code>$_REQUEST</code> superglobal. Sin embargo, en este momento, si usas <code>Router::URI_SOURCE_SERVER_REQUEST_URI</code> la Uri no será decodificada automáticamente. Esto cambiará en la siguiente versión mayor.</h5>

<a name='testing'></a>

## Probando tus rutas

Como este componente no tiene dependencias, puede crear un archivo como se muestra a continuación para probar sus rutas:

```php
<?php

use Phalcon\Mvc\Router;

// Estas rutas simulan URIs reales
$testRoutes = [
    '/',
    '/index',
    '/index/index',
    '/index/test',
    '/products',
    '/products/index/',
    '/products/show/101',
];

$router = new Router();

// Agregar aquí las rutas personalizadas
// ...

// Probar cada ruta
foreach ($testRoutes as $testRoute) {
    // Gestionar la ruta
    $router->handle($testRoute);

    echo 'Probando ', $testRoute, '<br>';

    // Comprobar si alguna ruta coincidio
    if ($router->wasMatched()) {
        echo 'Controlador: ', $router->getControllerName(), '<br>';
        echo 'Acción: ', $router->getActionName(), '<br>';
    } else {
        echo "La ruta no coincidió con ninguna ruta<br>";
    }

    echo '<br>';
}
```

<a name='annotations'></a>

## Anotaciones de Router

Este componente proporciona una variante que se integra con el servicio [annotations](/[[language]]/[[version]]/annotations). Al usar esta estrategia, puede escribir las rutas directamente en los controladores en lugar de agregarlas en el registro del servicio:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Usar las anotaciones del router. Pasamos el valor false ya que no queremos que el router agregue los patrones por defecto
    $router = new RouterAnnotations(false);

    // Leer las anotaciones desde ProductsController si las URI comienzan con /api/products
    $router->addResource('Products', '/api/products');

    return $router;
};
```

Las anotaciones se pueden definir de la siguiente manera:

```php
<?php

/**
 * @RoutePrefix('/api/products')
 */
class ProductsController
{
    /**
     * @Get(
     *     '/'
     * )
     */
    public function indexAction()
    {

    }

    /**
     * @Get(
     *     '/edit/{id:[0-9]+}',
     *     name='edit-robot'
     * )
     */
    public function editAction($id)
    {

    }

    /**
     * @Route(
     *     '/save',
     *     methods={'POST', 'PUT'},
     *     name='save-robot'
     * )
     */
    public function saveAction()
    {

    }

    /**
     * @Route(
     *     '/delete/{id:[0-9]+}',
     *     methods='DELETE',
     *     conversors={
     *         id='MyConversors::checkId'
     *     }
     * )
     */
    public function deleteAction($id)
    {

    }

    public function infoAction($id)
    {

    }
}
```

Solo los métodos marcados con anotaciones válidas se usan como rutas. Lista de anotaciones compatibles:

| Nombre      | Descripción                                                                                                          | Uso                                    |
| ----------- | -------------------------------------------------------------------------------------------------------------------- | -------------------------------------- |
| RoutePrefix | Un prefijo que debe ser agregado al comienzo de cada URI. Esta anotación debe ser ubicada en el docblock de la clase | `@RoutePrefix('/api/products')`        |
| Route       | Esta anotación marca al método como una ruta. Esta anotación debe ser ubicada en el docblock del método              | `@Route('/api/products/show')`         |
| Get         | Esta anotación marca el método como una ruta restringida al método `GET` de HTTP                                     | `@Get('/api/products/search')`         |
| Post        | Esta anotación marca el método como una ruta restringida al método `POST` de HTTP                                    | `@Post('/api/products/save')`          |
| Put         | Esta anotación marca el método como una ruta restringida al método `PUT` de HTTP                                     | `@Put('/api/products/save')`           |
| Delete      | Esta anotación marca el método como una ruta restringida al método `DELETE` de HTTP                                  | `@Delete('/api/products/delete/{id}')` |
| Options     | Esta anotación marca el método como una ruta restringida al método `OPTIONS` de HTTP                                 | `@Option('/api/products/info')`        |

Para las anotaciones que agregan rutas, se admiten los siguientes parámetros:

| Nombre     | Descripción                                                         | Uso                                                                  |
| ---------- | ------------------------------------------------------------------- | -------------------------------------------------------------------- |
| methods    | Define uno o más métodos HTTP que la ruta debe cumplir              | `@Route('/api/products', methods={'GET', 'POST'})`                   |
| name       | Define el nombre de la ruta                                         | `@Route('/api/products', name='get-products')`                       |
| paths      | Un arreglo de rutas como el pasado en `Phalcon\Mvc\Router::add()` | `@Route('/posts/{id}/{slug}', paths={module='backend'})`             |
| conversors | Un hash del conversor para aplicar a los parámetros                 | `@Route('/posts/{id}/{slug}', conversors={id='MyConversor::getId'})` |

Si está utilizando módulos en su aplicación, es mejor utilizar el método `addModuleResource()`:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Usar las anotaciones del router
    $router = new RouterAnnotations(false);

    // Leer las anotaciones desde Backend\Controllers\ProductsController si la URI comienza con /api/products
    $router->addModuleResource('backend', 'Products', '/api/products');

    return $router;
};
```

<a name='registration'></a>

## Registro de instancia de Router

Puede registrar el router durante el registro del servicio con el inyector de dependencia Phalcon para que esté disponible dentro de los controladores.

Necesita agregar el código a continuación en su archivo bootstrap (por ejemplo, `index.php` o `app/config/services.php` si utiliza [Phalcon Developer Tools](http://phalconphp.com/en/download/tools).

```php
<?php

/**
 * Agregar capacidades de ruteo
 */
$di->set(
    'router',
    function () {
        require __DIR__ . '/../app/config/routes.php';

        return $router;
    }
);
```

Necesita crear `app/config/routes.php` y agregar el código de inicialización del router, por ejemplo:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    '/login',
    [
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/products/:action',
    [
        'controller' => 'products',
        'action'     => 1,
    ]
);

return $router;
```

<a name='custom'></a>

## Implementar tu propio Router

Debe implementar la interfaz `Phalcon\Mvc\RouterInterface` para crear su propio enrutador reemplazando uno proporcionado por Phalcon.