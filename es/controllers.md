<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Controladores</a> 
      <ul>
        <li>
          <a href="#using">Uso de Controladores</a>
        </li>
        <li>
          <a href="#dispatch-loop">Bucle de Despacho</a>
        </li>
        <li>
          <a href="#initializing">Inicialización de Controladores</a>
        </li>
        <li>
          <a href="#injecting-services">Inyección de servicios</a>
        </li>
        <li>
          <a href="#request-response">Request y Response</a>
        </li>
        <li>
          <a href="#session-data">Datos de Sesión</a>
        </li>
        <li>
          <a href="#services">Utilizando Servicios como Controladores</a>
        </li>
        <li>
          <a href="#events">Eventos en Controladores</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Controladores

<a name='using'></a>

## Uso de Controladores

Las acciones son métodos en un controlador que manejan las solicitudes. Por defecto todos los métodos públicos en un controlador son acciones y son accesibles por una URL. Las acciones son responsables de interpretar la consulta y crear una respuesta. Las respuestas son generalmente en forma de una vista renderizada, pero también hay otras formas de crear respuestas.

Por ejemplo, cuando usted accede a una URL como esta: `http://localhost/blog/posts/show/2015/the-post-title` Phalcon, por defecto, descompondrá cada parte de la siguiente manera:

| Descripción           | Slug           |
| --------------------- | -------------- |
| **Phalcon Directory** | blog           |
| **Controller**        | posts          |
| **Action**            | show           |
| **Parameter**         | 2015           |
| **Parameter**         | the-post-title |

En este caso, el controlador `PostsController` se encargará de esta solicitud. Hay no hay un lugar especial para poner los controladores en una aplicación, ellos son cargados con `Phalcon\Loader`, así que eres libre de organizar los controladores como desees.

Los controladores deben tener el sufijo `Controller` mientras que las acciones tienen el sufijo `Action`. Un ejemplo de un controlador es el siguiente:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {

    }
}
```

Los parámetros adicionales del URI se definen como parámetros de acción, por lo que se puede acceder fácilmente usando variables locales. Un controlador puede, opcionalmente, extender de `Phalcon\Mvc\Controller`. Haciendo esto, el controlador puede tener fácil acceso a los servicios de la aplicación.

Los parámetros sin un valor predeterminado son manejados como obligatorios. Ajuste los valores opcionales en los parámetros como se hace en PHP:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year = 2015, $postTitle = 'some default title')
    {

    }
}
```

Los parámetros se asignan en el mismo orden como fueron pasados en la ruta. Puede obtener un parámetro arbitrario por su nombre de la siguiente manera:

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
        $year      = $this->dispatcher->getParam('year');
        $postTitle = $this->dispatcher->getParam('postTitle');
    }
}
```

<a name='dispatch-loop'></a>

## Bucle de Despacho

El bucle de despacho se ejecutará dentro del Dispatcher hasta que no haya ninguna acción para ser ejecutada. En el ejemplo anterior se ha ejecutado sólo una acción. Ahora vamos a ver cómo el método `forward()` puede proporcionar un flujo más complejo de la operación en el bucle de despacho, enviando la ejecución a un controlador y acción diferente.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {
        $this->flash->error(
            "Ud. no tiene permisos para acceder a esta área"
        );

        // Cambiamos el flujo a otra acción
        $this->dispatcher->forward(
            [
                'controller' => 'users',
                'action'     => 'signin',
            ]
        );
    }
}
```

Si los usuarios no tienen permiso para acceder a una determinada acción entonces ellos se remitirán a la acción `signin` en el controlador `UsersController`.

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {

    }

    public function signinAction()
    {

    }
}
```

No hay un límite de `forwards` que pueda tener en su aplicación, siempre y cuando no den lugar a referencias circulares, en tal caso se detendrá la aplicación. Si hay no hay otras acciones para ser despachadas por el bucle de despacho, el dispatcher llamará automáticamente a la capa vista del MVC que es administrada por `Phalcon\Mvc\View`.

<a name='initializing'></a>

## Inicialización de Controladores

`Phalcon\Mvc\Controller` ofrece el método `initialize()`, que se ejecuta en primer lugar, antes de cualquier acción que se ejecute en un controlador. No se recomienda el uso del método `__construct()`.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public $settings;

    public function initialize()
    {
        $this->settings = [
            'mySetting' => 'value',
        ];
    }

    public function saveAction()
    {
        if ($this->settings['mySetting'] === 'value') {
            // ...
        }
    }
}
```

<div class="alert alert-warning">
    <p>
       El método <code>initialize()</code> se llama sólo si el evento <code>beforeExecuteRoute</code> se ejecuta con éxito. Esto evitará que la lógica de la aplicación en el inicializador no pueda ejecutar sin autorización.
    </p>
</div>

Si desea ejecutar cierta lógica de inicialización justo después de que se construye el objeto controlador puede implementar el método `onConstruct()`:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function onConstruct()
    {
        // ...
    }
}
```

<div class='alert alert-warning'>
    <p>
        Tenga en cuenta que el método <code>onConstruct()</code> se ejecuta incluso si no existe la acción a ejecutarse en el controlador o el usuario no tiene acceso a ella (según control de acceso personalizado proporcionado por el desarrollador).
    </p>
</div>

<a name='injecting-services'></a>

## Inyección de servicios

Si un controlador extiende de `Phalcon\Mvc\Controller` tiene fácil acceso al contenedor de servicios de la aplicación. Por ejemplo, si hemos registrado un servicio como éste:

```php
<?php

use Phalcon\Di;

$di = new Di();

$di->set(
    'storage',
    function () {
        return new Storage(
            '/some/directory'
        );
    },
    true
);
```

Entonces, podemos acceder a ese servicio de diferentes maneras:

```php
<?php

use Phalcon\Mvc\Controller;

class FilesController extends Controller
{
    public function saveAction()
    {
        // Inyección de servicios, simplemente accedemos por la propiedad con el mismo nombre
        $this->storage->save('/some/file');

        // Acceso al servicio desde el DI
        $this->di->get('storage')->save('/some/file');

        // Otra forma de acceder al servicio es utilizando los métodos mágicos
        $this->di->getStorage()->save('/some/file');

        // Otra forma válida de utilizar los métodos mágicos
        $this->getDi()->getStorage()->save('/some/file');

        // Utilizando la sintaxis de array
        $this->di['storage']->save('/some/file');
    }
}
```

Si usas Phalcon como un framwork full-stack, puedes leer los servicios proporcionados [por defecto](/[[language]]/[[version]]/di) en el framework.

<a name='request-response'></a>

## Request y Response

Suponiendo que el framework proporciona un conjunto de servicios previamente registrados. Explicaremos cómo interactuar con el entorno HTTP. El servicio `request` contiene una instancia de `Phalcon\Http\Request` y `response` contiene `Phalcon\Http\Response` que representa lo que va a ser enviado al cliente.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Chequeamos si la consulta fue hecha por POST
        if ($this->request->isPost()) {
            // Accedemos al los datos POST
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

El objeto `response`, generalmente, no se utiliza directamente, pero se construye antes de la ejecución de la acción, a veces (como en un evento `afterDispatch`) puede ser útil para acceder directamente a la respuesta:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function notFoundAction()
    {
        // Enviar la cabecera de respuesta HTTP 404
        $this->response->setStatusCode(404, 'Not Found');
    }
}
```

Más información sobre el entorno de HTTP en los artículos dedicados para [request](/[[language]]/[[version]]/request) y [response](/[[language]]/[[version]]/response).

<a name='session-data'></a>

## Datos de Sesión

Las sesiones nos ayudan a mantener los datos persistentes entre peticiones. Puedes acceder a `Phalcon\Session\Bag` desde cualquier controlador para encapsular los datos que necesita ser almacenados:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $this->persistent->name = 'Michael';
    }

    public function welcomeAction()
    {
        echo 'Welcome, ', $this->persistent->name;
    }
}
```

<a name='services'></a>

## Utilizando Servicios como Controladores

Los servicios pueden actuar como controladores, las clases de controladores son siempre solicitadas desde el contenedor de servicios. Por consiguiente, cualquier otra clase registrada con su nombre puede substituir fácilmente a un controlador:

```php
<?php

// Registrar un controlador como servicio
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);

// Registrar un controlador con su namespace como servicio
$di->set(
    'Backend\Controllers\IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);
```

<a name='events'></a>

## Eventos en Controladores

Los controladores automáticamente actúan como detectores de eventos del [dispatcher](/[[language]]/[[version]]/dispatcher), implementando métodos con los nombres de evento adecuados, permiten implementar puntos de anclaje para antes/después de ejecutar las acciones:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        // Este método se ejecuta antes de cada acción
        if ($dispatcher->getActionName() === 'save') {
            $this->flash->error(
                "Ud. no tiene permisos para guardar publicaciones"
            );

            $this->dispatcher->forward(
                [
                    'controller' => 'home',
                    'action'     => 'index',
                ]
            );

            return false;
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        // Ejecutado después de cada acción
    }
}
```