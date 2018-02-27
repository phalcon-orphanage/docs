<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">Tutorial - básico</a> 
      <ul>
        <li>
          <a href="#file-structure">Estructura de archivos</a>
        </li>
        <li>
          <a href="#bootstrap">Manos a la obra</a> 
          <ul>
            <li>
              <a href="#autoloaders">Cargadores automáticos</a>
            </li>
            <li>
              <a href="#dependency-management">Gestión de dependencias</a>
            </li>
            <li>
              <a href="#request">Tratar las solicitudes de la aplicación</a>
            </li>
            <li>
              <a href="#full-example">Poniendo todo junto</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#controller">Creando un controlador</a>
        </li>
        <li>
          <a href="#view">Enviando la salida a una vista</a>
        </li>
        <li>
          <a href="#signup-form">Diseñar un formulario de registro</a>
        </li>
        <li>
          <a href="#model">Creando un modelo</a>
        </li>
        <li>
          <a href="#database-connection">Establecer una conexión de base de datos</a>
        </li>
        <li>
          <a href="#storing-data">Almacenando datos utilizando modelos</a>
        </li>
        <li>
          <a href="#conclusion">Conclusión</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# Tutorial - básico

A lo largo de este tutorial, lo guiaremos a través de la creación de una aplicación con un formulario simple de registro comenzando desde cero. La siguiente guía es proporcionada para presentarle aspectos de diseño del framework Phalcon.

This tutorial covers the implementation of a simple MVC application, showing how fast and easy it can be done with Phalcon. This tutorial will get you started and help create an application that you can extend to address many needs. The code in this tutorial can also be used as a playground to learn other Phalcon specific concepts and ideas.

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

Si solo desea empezar puede saltarse esto y crear automáticamente un proyecto Phalcon con nuestras [herramientas de desarrollo](/[[language]]/[[version]]/devtools-usage). (Se recomienda que si no han tenido experiencia o te quedas atascado, vuelvas aquí)

La mejor manera de utilizar esta guía es seguirla y tratar de divertirse. Usted puede obtener el código completo [aquí](https://github.com/phalcon/tutorial). If you get hung-up on something please visit us on [Discord](https://phalcon.link/discord) or in our [Forum](https://phalcon.link/forum).

<a name='file-structure'></a>

## Estructura de archivos

A key feature of Phalcon is it's loosely coupled, you can build a Phalcon project with a directory structure that is convenient for your specific application. Dicho esto, cierta uniformidad es útil cuando colabora con otros, por lo que este tutorial utiliza una estructura "Estándar" donde debe sentirse como en casa si han trabajado con otros MVC en el pasado.   


```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

<div class='alert alert-warning'>
    <p>
        Nota: Usted no verá un directorio `vendor` ya que todas las dependencias del núcleo de Phalcon se cargan en la memoria a través de la extensión de Phalcon, que usted debe tener instalada. Si te perdiste esa parte y no has instalado la extensión de Phalcon por favor [vuelve atrás](/[[language]]/[[version]]/installation) y finaliza la instalación antes de continuar.
    </p>
</div>

Si todo esto es nuevo, se recomienda que instale [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation), ya que aprovecha el servidor incorporado de PHP. Para que su aplicación se ejecute sin tener que configurar un servidor web, agregue este [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) a la raíz de su proyecto.

Otherwise if you want to use Nginx here are some additional setup [here](/[[language]]/[[version]]/webserver-setup#nginx).

Apache can also be used with these additional setup [here](/[[language]]/[[version]]/webserver-setup#apache).

Finally, if you flavor is Cherokee use the setup [here](/[[language]]/[[version]]/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Manos a la obra

El primer archivo que necesitas crear es el archivo bootstrap. Este archivo actúa como el punto de entrada y configuración de la aplicación. En este archivo puedes implementar la inicialización de componentes, así como el comportamiento de la aplicación.

This file handles 3 things: - Registration of component autoloaders - Configuring Services and registering them with the Dependency Injection context - Resolving the application's HTTP requests

<a name='autoloaders'></a>

### Cargadores automáticos

Autoloaders leverage a [PSR-4](http://www.php-fig.org/psr/psr-4/) compliant file loader running through the Phalcon. Common things that should be added to the autoloader are your controllers and models. You can register directories which will search for files within the application's namespace. If you want to read about other ways that you can use autoloaders head [here](/[[language]]/[[version]]/loader#overview).

To start, lets register our app's `controllers` and `models` directories. Don't forget to include the loader from `Phalcon\Loader`.

`public/index.php`

```php
<?php

use Phalcon\Loader;

// Definimos algunas rutas absolutas en constantes para localizar los recursos
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();
```

<a name='dependency-management'></a>

### Gestión de dependencias

Since Phalcon is loosely coupled, services are registered with the frameworks Dependency Manager so they can be injected automatically to components and services wrapped in the [IoC](https://en.wikipedia.org/wiki/Inversion_of_control) container. Frequently you will encounter the term DI which stands for Dependency Injection. Dependency Injection and Inversion of Control(IoC) may sound like a complex feature but in Phalcon their use is very simple and practical. Phalcon's IoC container consists of the following concepts: - Service Container: a "bag" where we globally store the services that our application needs to function. - Service or Component: Data processing object which will be injected into components

Each time the framework requires a component or service, it will ask the container using an agreed upon name for the service. Don't forget to include `Phalcon\Di` with setting up the service container.

<div class='alert alert-warning'>
    <p>
        If you are still interested in the details please see this article by [Martin Fowler](https://martinfowler.com/articles/injection.html). Also we have [a great tutorial](/[[language]]/[[version]]/di) covering many use cases.
    </p>
</div>

### Factory por defecto

The `Phalcon\Di\FactoryDefault` is a variant of `Phalcon\Di`. To make things easier, it will automatically register most of the components that come with Phalcon. We recommend that you register your services manually but this has been included to help lower the barrier of entry when getting used to Dependency Management. Later, you can always specify once you become more comfortable with the concept.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](http://php.net/manual/en/functions.anonymous.php):

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Crear un DI
$di = new FactoryDefault();
```

En la siguiente parte, registraremos el servicio "vista" indicando el directorio donde el entorno de trabajo encontrará los archivos de las vistas. Como las vistas no corresponden a las clases, no se pueden cargar con un autoloader.

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

// Configurar la vista
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);
```

A continuación, registraremos una URI base para que todas las URIs generadas por Phalcon que coincidan con la ruta base de la aplicación osea "/". Esto será importante más adelante en este tutorial cuando usemos la clase `Phalcon\Tag` para generar un hipervínculo.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Configuramos el URI base
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);
```

<a name='request'></a>

### Tratar las solicitudes de la aplicación

En la última parte de este archivo, encontramos `Phalcon\Mvc\Application`. Su propósito es inicializar el entorno de la solicitud, rutear la solicitud entrante y luego despachar cualquier acción descubierta; agrega todas las respuestas y las devuelve cuando el proceso se completa.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);
$response = $application->handle();
$response->send();
```

<a name='full-example'></a>

### Poniendo todo junto

El archivo `tutorial/public/index.php` debería verse como:

`public/index.php`

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;

// Definimos algunas rutas constantes para localizar recursos
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Registramos un autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

// Crear un DI
$di = new FactoryDefault();

// Configurar el componente vista
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

// Configurar el URI base
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($di);

try {
    // Gestionar la consulta
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Excepción: ', $e->getMessage();
}
```

As you can see, the bootstrap file is very short and we do not need to include any additional files. Congratulations you are well on your to having created a flexible MVC application in less than 30 lines of code.

<a name='controller'></a>

## Creando un controlador

By default Phalcon will look for a controller named `IndexController`. It is the starting point when no controller or action has been added in the request (eg. `http://localhost:8000/`). An `IndexController` and its `IndexAction` should resemble the following example:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        echo '<h1>Hola!</h1>';
    }
}
```

The controller classes must have the suffix `Controller` and controller actions must have the suffix `Action`. If you access the application from your browser, you should see something like this:

![](/images/content/tutorial-basic-1.png)

¡Felicitaciones! Ahora estás volando con Phalcon.

<a name='view'></a>

## Enviando la salida a una vista

Enviar la salida por pantalla es a veces necesario pero no es aceptado como purista asi como la comunidad MVC puede atestiguar. Todo debe ser pasado a la vista, la cual es la responsable de la salida de datos en pantalla. Phalcon buscará una vista con el mismo nombre que la última acción ejecutada dentro de un directorio llamado como el último controlador ejecutado. En nuestro caso (`app/views/index/index.phtml`):

`app/views/index/index.phtml`

```php
<?php echo "<h1>Hola!</h1>";
```

Nuestro controlador (`app/controllers/IndexController.php`) ahora tiene una definición de acción vacía:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {

    }
}
```

La salida del navegador debe seguir siendo la misma. El componente estático `Phalcon\Mvc\View` se crea automáticamente cuando haya terminado la ejecución de la acción. Más información sobre el uso de las vistas [aquí](/[[language]]/[[version]]/views).

<a name='signup-form'></a>

## Diseñar un formulario de registro

Ahora vamos a cambiar el archivo de la vista `index.phtml`, para añadir un enlace a un nuevo controlador denominado "signup". El objetivo es permitir a los usuarios registrarse dentro de nuestra aplicación.

`app/views/index/index.phtml`

```php
<?php

echo "<h1>Hola!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    'signup',
    'Registrese Aquí!'
);
```

El código HTML generado muestra una etiqueta HTML de ancla (`<a>`) vinculando a un nuevo controlador:

`app/views/index/index.phtml` (renderizado)

```html
<h1>Hola!</h1>

<a href="/signup">Regístrese aquí!</a>
```

Para generar la etiqueta usamos la clase `Phalcon\Tag`. Esta es una clase utilitaria que nos permite crear etiquetas HTML con los convenios del framework en mente. Como esta clase también es un servicio registrado en el DI, usamos `$this->tag` para acceder a ella.

Un artículo más detallado en cuanto a generación de HTML puede ser [encontrado aquí](/[[language]]/[[version]]/tag).

![](/images/content/tutorial-basic-2.png)

Aquí está el controlador de registro (`app/controllers/SignupController.php`):

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }
}
```

La ausencia de la acción en el index da el pase directo a una vista con la definición de formulario (`app/views/signup/index.phtml`):

`app/views/signup/index.phtml`

```html
<h2>Registrarse utilizando este formulario</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">Nombre</label>
        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">E-Mail</label>
        <?php echo $this->tag->textField("email"); ?>
    </p>

    <p>
        <?php echo $this->tag->submitButton("Registrar"); ?>
    </p>

</form>
```

En tu navegador, el formulario debería verse algo como así:

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag` también proporciona métodos útiles para construir elementos de formularios.

El método `Phalcon\Tag::form()` recibe sólo un parámetro, por ejemplo, un URI relativo a un controlador/acción en la aplicación.

Al hacer clic en el botón "Registrar", usted recibirá una excepción del framework, lo que indica que nos falta la acción `register` en el controlador `signup`. Nuestro archivo `public/index.php` lanza esta excepción:

    Exception: Action "register" was not found on handler "signup"
    

Implementando este método se eliminará la excepción:

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {

    }
}
```

Si haces clic en el botón "Registrar" otra vez, verás una página en blanco. The name and email input provided by the user should be stored in a database. Según las pautas MVC, las interacciones de la base de datos deben hacerse a través de modelos con el fin de garantizar la limpieza de código orientado a objetos.

<a name='model'></a>

## Creando un modelo

Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be created like this:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,
    PRIMARY KEY (`id`)
);
```

A model should be located in the `app/models` directory (`app/models/Users.php`). The model maps to the "users" table:

`app/models/Users.php`

```php
<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $name;
    public $email;
}
```

<a name='database-connection'></a>

## Establecer una conexión de base de datos

In order to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. A database connection is just another service that our application has that can be used for several components:

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Configurar servicio de base de datos
$di->set(
    'db',
    function () {
        return new DbAdapter(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial1',
            ]
        );
    }
);
```

With the correct database parameters, our models are ready to work and interact with the rest of the application.

<a name='storing-data'></a>

## Almacenando datos utilizando modelos

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        $user = new Users();

        // Almacenar y comprobar errores
        $success = $user->save(
            $this->request->getPost(),
            [
                "name",
                "email",
            ]
        );

        if ($success) {
            echo "¡Gracias por registrarte!";
        } else {
            echo "Lo sentimos, se generaron los siguiente problemas: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
```

At the beginning of the `registerAction` we create an empty user object from the Users class, which manages a User's record. The class's public properties map to the fields of the `users` table in our database. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusión

As you can see, it's easy to start building an application using Phalcon. The fact that Phalcon runs from an extension significantly reduces the footprint of projects as well as giving it a considerable performance boost.

If you are ready to learn more check out the [Rest Tutorial](/[[language]]/[[version]]/tutorial-rest) next.