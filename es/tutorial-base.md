<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">Tutorial - básico</a> <ul>
        <li>
          <a href="#file-structure">Estructura de archivos</a>
        </li>
        <li>
          <a href="#bootstrap">Manos a la obra</a> <ul>
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

A lo largo de este primer tutorial, lo guiaremos a través de la creación de una aplicación con un formulario simple de registro comenzando desde cero. También explicaremos los aspectos básicos del comportamiento del entorno de trabajo. Si estás interesado en las herramientas de generación automática de código para Phalcon, puedes revisar nuestras [herramientas de desarrollo](/[[language]]/[[version]]/developer-tools).

La mejor manera de utilizar esta guía es seguir cada paso a la vez. Puedes obtener el código completo [aquí](https://github.com/phalcon/tutorial).

<a name='file-structure'></a>

## Estructura de archivos

Phalcon no impone una estructura específica de archivos para el desarrollo de aplicaciones. Debido a que está ligeramente acoplado, tu puedes implementar aplicaciones Phalcon con la estructura de archivos que te sea más cómoda de usar.

Para el objetivo de este tutorial y como punto de partida, sugerimos esta estructura, que es realmente simple:

```bash
tutorial/
  app/
    controllers/
    models/
    views/
  public/
    css/
    img/
    js/
```

Ten presente que no necesitas ningún directorio de librerías relacionado con Phalcon. El entorno de trabajo está disponible en memoria, listo para que lo uses.

Antes de continuar, asegúrate de tener correctamente [instalado Phalcon](/[[language]]/[[version]]/installation) y que tienes configurados [nginX](/[[language]]/[[version]]/setup#nginx), [Apache](/[[language]]/[[version]]/setup#apache) o [Cherokee](/[[language]]/[[version]]/setup#cherokee).

<a name='bootstrap'></a>

## Manos a la obra

El primer archivo que necesitas crear es el archivo bootstrap. Este archivo es muy importante dado que sirve como base para tu aplicación, dándote el control para todos los aspectos de la misma. En este archivo puedes implementar la inicialización de componentes, así como el comportamiento de la aplicación.

Por último, es responsable de hacer 3 cosas:

- Establecer el autoloader.
- Configurar el Inyector de dependencias.
- Tratar las solicitudes de la aplicación.

<a name='autoloaders'></a>

### Cargadores automáticos

La primera parte que encontramos en el bootstrap es registrar un autoloader. Esto se usará para cargar las clases, como los controladores y modelos en la aplicación. Por ejemplo, podemos registrar uno o más directorios de controladores, incrementando la flexibilidad de la aplicación. En nuestro ejemplo, hemos usado el componente `Phalcon\Loader`.

Con esto, podemos cargar clases usando varias estrategias, pero para este ejemplo hemos elegido ubicar las clases basadas en directorios predefinidos:

```php
use Phalcon\Loader; 

// ... 

$loader = new Loader(); 

$loader->registerDirs(
     [
         '../app/controllers/',
         '../app/models/',
     ]
); 

$loader->register();
```

<a name='dependency-management'></a>

### Gestión de dependencias

A very important concept that must be understood when working with Phalcon is its `dependency injection container <di>`. It may sound complex but is actually very simple and practical.

A service container is a bag where we globally store the services that our application will use to function. Each time the framework requires a component, it will ask the container using an agreed upon name for the service. Since Phalcon is a highly decoupled framework, `Phalcon\Di` acts as glue facilitating the integration of the different components achieving their work together in a transparent manner.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Crear un DI
$di = new FactoryDefault();
```

`Phalcon\Di\FactoryDefault` es una variante de `Phalcon\Di`. To make things easier, it has registered most of the components that come with Phalcon. Thus we should not register them one by one. Later there will be no problem in replacing a factory service.

En la siguiente parte, registraremos el servicio "vista" indicando el directorio donde el entorno de trabajo encontrará los archivos de las vistas. Como las vistas no corresponden a las clases, no se pueden cargar con un autoloader.

Services can be registered in several ways, but for our tutorial we'll use an [anonymous function](http://php.net/manual/en/functions.anonymous.php):

```php
<?php

use Phalcon\Mvc\View;

// ...

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);
```

Next we register a base URI so that all URIs generated by Phalcon include the "tutorial" folder we setup earlier. Esto será importante más adelante en este tutorial cuando usemos la clase `Phalcon\Tag` para generar un hipervínculo.

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $url = new UrlProvider();

        $url->setBaseUri('/tutorial/');

        return $url;
    }
);
```

<a name='request'></a>

### Tratar las solicitudes de la aplicación

En la última parte de este archivo, encontramos `Phalcon\Mvc\Application`. Su propósito es inicializar el entorno de la solicitud, rutear la solicitud entrante y luego despachar cualquier acción descubierta; agrega todas las respuestas y las devuelve cuando el proceso se completa.

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

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        '../app/controllers/',
        '../app/models/',
    ]
);

$loader->register();

// Create a DI
$di = new FactoryDefault();

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $url = new UrlProvider();

        $url->setBaseUri('/tutorial/');

        return $url;
    }
);

$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

As you can see, the bootstrap file is very short and we do not need to include any additional files. We have set ourselves a flexible MVC application in less than 30 lines of code.

<a name='controller'></a>

## Creando un controlador

By default Phalcon will look for a controller named "Index". It is the starting point when no controller or action has been passed in the request. The index controller (`app/controllers/IndexController.php`) looks like:

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

Las clases del controlador tienen que tener el sufijo "Controller" y las acciones del controlador tienen que tener el sufijo "Action". Si accedes a la aplicación desde tu navegador, deberías ver algo como esto:

![](/images/content/tutorial-basic-1.png)

¡Felicitaciones! Ahora estás volando con Phalcon.

<a name='view'></a>

## Enviando la salida a una vista

Enviar la salida por pantalla es a veces necesario pero no es aceptado como purista asi como la comunidad MVC puede atestiguar. Todo debe ser pasado a la vista, la cual es la responsable de la salida de datos en pantalla. Phalcon buscará una vista con el mismo nombre que la última acción ejecutada dentro de un directorio llamado como el último controlador ejecutado. En nuestro caso (`app/views/index/index.phtml`):

```php
<?php echo "<h1>Hola!</h1>";
```

Nuestro controlador (`app/controllers/IndexController.php`) ahora tiene una definición de acción vacía:

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

La salida del navegador debe seguir siendo la misma. El componente estático `Phalcon\Mvc\View` se crea automáticamente cuando haya terminado la ejecución de la acción. Learn more about `views usage here <views>`.

<a name='signup-form'></a>

## Diseñar un formulario de registro

Ahora vamos a cambiar el archivo de la vista `index.phtml`, para añadir un enlace a un nuevo controlador denominado "signup". El objetivo es permitir a los usuarios registrarse dentro de nuestra aplicación.

```php
<?php

echo "<h1>Hola!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    "signup",
    "Regístrese aquí!"
);
```

El código HTML generado muestra una etiqueta de enlace HTML ("a") vinculando a un nuevo controlador:

```html
<h1>Hola!</h1>

<a href="/tutorial/signup">Regístrese aquí!</a>
```

Para generar la etiqueta usamos la clase `Phalcon\Tag`. Esta es una clase utilitaria que nos permite crear etiquetas HTML con los convenios del framework en mente. Como esta clase es también un servicio registrado en el DI, utilizamos `$this->tag` para acceder a él.

Un artículo más detallado en cuanto a generación de HTML puede ser `encontrado aquí <tags>`.

![](/images/content/tutorial-basic-2.png)

Aquí está el controlador de registro (`app/controllers/SignupController.php`):

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

```php
<h2>
    Sign up using this form
</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">
            Name
        </label>

        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">
            E-Mail
        </label>

        <?php echo $this->tag->textField("email"); ?>
    </p>



    <p>
        <?php echo $this->tag->submitButton("Register"); ?>
    </p>

</form>
```

En tu navegador, el formulario debería verse algo como así:

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag` también proporciona métodos útiles para construir elementos de formularios.

The :code:`Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our `public/index.php` file throws this exception:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementando este método se eliminará la excepción:

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

Si haces clic en el botón "Registrar" otra vez, verás una página en blanco. El nombre y correo electrónico proporcionados por el usuario deben estar guardados en una base de datos. Según las pautas MVC, las interacciones de la base de datos deben hacerse a través de modelos con el fin de garantizar la limpieza de código orientado a objetos.

<a name='model'></a>

## Creando un modelo

Phalcon provee el primer ORM PHP escrito enteramente en lenguaje C. En lugar de aumentar la complejidad del desarrollo, lo simplifica.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be defined like this:

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,
    PRIMARY KEY (`id`)
);
```

Un modelo debe ubicarse en el directorio `app/models` (en este caso `app/models/Users.php`). El modelo se asigna a la tabla "users":

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

In order to be able to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. Una conexión de base de datos es justo un servicio mas que tiene nuestra aplicación y que puede ser utilizado para varios componentes:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Setup the database service
$di->set(
    'db',
    function () {
        return new DbAdapter(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'test_db',
            ]
        );
    }
);
```

With the correct database parameters, our models are ready to work and interact with the rest of the application.

<a name='storing-data'></a>

## Almacenando datos utilizando modelos

Receiving data from the form and storing them in the table is the next step.

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

We then instantiate the Users class, which corresponds to a User record. The class public properties map to the fields of the record in the users table. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. El método de `save()` devuelve un valor booleano que indica si el almacenamiento de los datos fue exitoso o no.

El ORM filtra automáticamente la entrada (auto-escape) para evitar inyecciones de SQL así que sólo tenemos que pasar la solicitud al método `save()`.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign up form our screen will look like this:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusión

Este es un tutorial muy simple y como se puede ver, es fácil empezar a construir una aplicación usando Phalcon. El hecho de que Phalcon es una extensión de tu servidor web no interfiere con la facilidad de desarrollo o con las características disponibles. Te invitamos a seguir leyendo el manual para que puedas descubrir algunas funciones adicionales que ofrece Phalcon!