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

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

Si solo desea empezar puede saltarse esto y crear automáticamente un proyecto Phalcon con nuestras [herramientas de desarrollo](/[[language]]/[[version]]/devtools-usage). (Se recomienda que si no han tenido experiencia o te quedas atascado, vuelvas aquí)

La mejor manera de utilizar esta guía es seguirla y tratar de divertirse. Usted puede obtener el código completo [aquí](https://github.com/phalcon/tutorial). Si quedas atrapado en algún problema que no puedes resolver por favor visítenos en [Discord](https://phalcon.link/discord) o en nuestro [Foro](https://phalcon.link/forum)

<a name='file-structure'></a>

## Estructura de archivos

Una característica clave de Phalcon es ser **débilmente acoplado**, usted puede construir un proyecto Phalcon con una estructura de directorios que sea conveniente para su aplicación. Dicho esto, cierta uniformidad es útil cuando colabora con otros, por lo que este tutorial utiliza una estructura "Estándar" donde debe sentirse como en casa si han trabajado con otros MVC en el pasado.   


```text
┗ tutorial
   ┣ app
   ┇ ┣ controllers
   ┇ ┇ ┣ IndexController.php
   ┇ ┇ ┗ SignupController.php
   ┇ ┣ models
   ┇ ┇ ┗ Users.php
   ┇ ┗ views
   ┗ public
      ┣ css
      ┣ img
      ┣ js
      ┗ index.php
```

Nota: Usted no verá un directorio **vendor** ya que todas las dependencias del núcleo de Phalcon se cargan en la memoria a través de la extensión de Phalcon, que usted debe tener instalada. Si te perdiste esa parte y no has instalado la extensión de Phalcon [por favor vuelve atras](/[[language]]/[[version]]/installation) y finaliza la instalación antes de continuar.

Si todo esto es nuevo, se recomienda que instale [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation), ya que aprovecha el servidor incorporado de PHP. Para que su aplicación se ejecute sin tener que configurar un servidor web, agregue este [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) a la raíz de su proyecto.

De lo contrario si desea utilizar Nginx [aquí](/[[language]]/[[version]]/webserver-setup#nginx) hay alguna configuración adicional

En Apache también puede utilizarse con [esta configuración adicional](/[[language]]/[[version]]/webserver-setup#apache)

Por último, si usted desea usar Cherokee la configuración [esta aquí](/[[language]]/[[version]]/webserver-setup#cherokee)

<a name='bootstrap'></a>

## Manos a la obra

The first file you need to create is the bootstrap file. Este archivo actúa como el punto de entrada y configuración de la aplicación. En este archivo puedes implementar la inicialización de componentes, así como el comportamiento de la aplicación.

This file handles 3 things:

- Registration of component autoloaders.
- Configuring **Services** and registering them with the **Dependency Injection** context.
- Resolving the application's HTTP requests.

<a name='autoloaders'></a>

### Cargadores automáticos

Los cargadores automáticos utilizan un cargador de archivos compatible con [PSR-4 ](http://www.php-fig.org/psr/psr-4/) que se ejecuta a través de la extensión C de Phalcon. Las cosas comunes que deben agregarse para el autocargador son tus **Controladores** y **Modelos**. Puede registrar **directorios** donde se buscará archivos de espacio de nombres de la aplicación. (Si quieres leer sobre otras maneras que usted puede utilizar cargadores automáticos diríjase a la sección de [Loader](/[[language]]/[[version]]/loader#overview))

Para empezar, permite registrar los directorios de **Modelos** y **Controladores** de nuestra aplicación. No se olvide de incluir el cargador en `Phalcon\Loader`.

**public/index.php**

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

Since Phalcon is **loosely coupled** services are registered with the frameworks Dependency Manager so they can be injected automatically to components and services wrapped in the **IoC** container. Frequently you will encounter the term **DI** which stands for Dependency Injection. Dependency Injection and Inversion of Control(IoC) may sound like a complex feature but in Phalcon their use is very simple and practical. Phalcon's IoC container consists of the following concepts:

- Service Container: a "bag" where we globally store the services that our application needs to function.
- Service or Component: Data processing object which will be injected into components

If you are still interested in the details please see this article by [Martin Fowler](https://martinfowler.com/articles/injection.html)

Each time the framework requires a component or service, it will ask the container using an agreed upon name for the service. Don't forget to include `Phalcon\Di` with setting up the service container.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](http://php.net/manual/en/functions.anonymous.php):

### Factory por defecto

`Phalcon\Di\FactoryDefault` es una variante de `Phalcon\Di`. To make things easier, it will automatically register most of the components that come with Phalcon. We recommend that you register your services manually but this has been included to help lower the barrier of entry when getting used to Dependency Management. Later, you can always specify once you become more comfortable with the concept.

**public/index.php**

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Crear un DI
$di = new FactoryDefault();
```

In the next part, we register the "view" service indicating the directory where the framework will find the views files. As the views do not correspond to classes, they cannot be charged with an autoloader.

**public/index.php**

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

Next, we register a base URI so that all URIs generated by Phalcon include the "tutorial" folder we setup earlier. Esto será importante más adelante en este tutorial cuando usemos la clase `Phalcon\Tag` para generar un hipervínculo.

**public/index.php**

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Configurar una URI base para que todas las URIs generadas incluyan la carpeta "tutorial"
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

In the last part of this file, we find `Phalcon\Mvc\Application`. Its purpose is to initialize the request environment, route the incoming request, and then dispatch any discovered actions; it aggregates any responses and returns them when the process is complete.

**public/index.php**

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

**public/index.php**

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

// Configurar una URI base para generar todas las URIs incluyendo la carpeta "tutorial"
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

As you can see, the bootstrap file is very short and we do not need to include any additional files. **Congratulations** you are well on your to having created a flexible MVC application in less than 30 lines of code.

<a name='controller'></a>

## Creando un controlador

By default Phalcon will look for a controller named **IndexController**. It is the starting point when no controller or action has been added in the request. (eg. http://localhost:8000/) An **IndexController** and its **IndexAction** should resemble the following example:

**app/controllers/IndexController.php**

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

Congratulations, you're phlying with Phalcon!

<a name='view'></a>

## Enviando la salida a una vista

Sending output to the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Todo debe ser pasado a la vista, la cual es la responsable de la salida de datos en pantalla. Phalcon buscará una vista con el mismo nombre que la última acción ejecutada dentro de un directorio llamado como el último controlador ejecutado. In our case (`app/views/index/index.phtml`):

**app/views/index/index.phtml**

```php
<?php echo "<h1>Hola!</h1>";
```

Our controller (`app/controllers/IndexController.php`) now has an empty action definition:

**app/controllers/IndexController.php**

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

The browser output should remain the same. The `Phalcon\Mvc\View` static component is automatically created when the action execution has ended. Learn more about views usage [here](/[[language]]/[[version]]/views).

<a name='signup-form'></a>

## Diseñar un formulario de registro

Now we will change the `index.phtml` view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

**app/views/index/index.phtml**

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

**app/views/index/index.phtml Procesado**

```html
<h1>Hola!</h1>

<a href="/signup">Regístrese aquí!</a>
```

Para generar la etiqueta usamos la clase `Phalcon\Tag`. Esta es una clase utilitaria que nos permite crear etiquetas HTML con los convenios del framework en mente. As this class is also a service registered in the DI we use `$this->tag` to access it.

A more detailed article regarding HTML generation can be found [here <tags>](/[[language]]/[[version]]/tag).

![](/images/content/tutorial-basic-2.png)

Aquí está el controlador de registro (`app/controllers/SignupController.php`):

**app/controllers/SignupController.php**

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

The empty index action gives the clean pass to a view with the form definition (`app/views/signup/index.phtml`):

**app/views/signup/index.phtml**

```php
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

Viewing the form in your browser will show something like this:

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag` also provides useful methods to build form elements.

El método `Phalcon\Tag::form()` recibe sólo un parámetro, por ejemplo, un URI relativo a una acción de control en la aplicación.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our `public/index.php` file throws this exception:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementing that method will remove the exception:

**app/controllers/SignupController.php**

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

If you click the "Send" button again, you will see a blank page. The name and email input provided by the user should be stored in a database. According to MVC guidelines, database interactions must be done through models so as to ensure clean object-oriented code.

<a name='model'></a>

## Creando un modelo

Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be created like this:

**create_users_table.sql**

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,
    PRIMARY KEY (`id`)
);
```

A model should be located in the `app/models` directory (`app/models/Users.php`). The model maps to the "users" table:

**app/models/Users.php**

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

**public/index.php**

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

**app/controllers/SignupController.php**

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

At the beginning of the **registerAction** we create an empty user object from the Users class, which manages a User's record. The class's public properties map to the fields of the `users` table in our database. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusión

As you can see, it's easy to start building an application using Phalcon. The fact that Phalcon runs from an extension significantly reduces the footprint of projects as well as giving it a considerable performance boost.

If you are ready to learn more check out the [Rest Tutorial](/[[language]]/[[version]]/tutorial-rest) next.