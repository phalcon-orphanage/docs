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

El primer archivo que necesitas crear es el archivo bootstrap. Este archivo actúa como el punto de entrada y configuración de la aplicación. En este archivo puedes implementar la inicialización de componentes, así como el comportamiento de la aplicación.

Este archivo se encarga de 3 cosas: - El registro de auto cargadores de componentes. -Configuración de **servicios** y registrarlos en el contenedor de **Inyección de dependencias**. -Resolución de las solicitudes HTTP de la aplicación.

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

Since Phalcon is **loosely coupled** services are registered with the frameworks Dependency Manager so they can be injected automatically to components and services wrapped in the **IoC** container. Frequently you will encounter the term **DI** which stands for Dependency Injection. La Inyección de Dependencia y la Inversión de Control (IoC) pueden parecer una característica compleja, pero en Phalcon su uso es muy simple y práctico. El contenedor IoC de Phalcon consta de los siguientes conceptos: - Contenedor de Servicio: una "bolsa" donde almacenamos globalmente los servicios que nuestra aplicación necesita para funcionar. - Service or Component: Data processing object which will be injected into components

If you are still interested in the details please see this article by [Martin Fowler](https://martinfowler.com/articles/injection.html)

Cada vez que el marco requiera un componente o servicio, solicitará el contenedor utilizando un nombre acordado para el servicio. Don't forget to include `Phalcon\Di` with setting up the service container.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](http://php.net/manual/en/functions.anonymous.php):

### Factory por defecto

`Phalcon\Di\FactoryDefault` es una variante de `Phalcon\Di`. Para facilitar las cosas, registrará automáticamente la mayoría de los componentes que vienen con Phalcon. We recommend that you register your services manually but this has been included to help lower the barrier of entry when getting used to Dependency Management. Later, you can always specify once you become more comfortable with the concept.

  
**public/index.php**

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Crear un DI
$di = new FactoryDefault();
```

  


En la siguiente parte, registraremos el servicio "vista" indicando el directorio donde el entorno de trabajo encontrará los archivos de las vistas. Como las vistas no corresponden a las clases, no se pueden cargar con un autoloader.

  
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

En la última parte de este archivo, encontramos `Phalcon\Mvc\Application`. Su propósito es inicializar el entorno de la solicitud, rutear la solicitud entrante y luego despachar cualquier acción descubierta; agrega todas las respuestas y las devuelve cuando el proceso se completa.

  
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
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Define some absolute path constants to aid in locating resources
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

  
¡Felicitaciones! Ahora estás volando con Phalcon.

<a name='view'></a>

## Enviando la salida a una vista

Enviar la salida por pantalla es a veces necesario pero no es aceptado como purista asi como la comunidad MVC puede atestiguar. Todo debe ser pasado a la vista, la cual es la responsable de la salida de datos en pantalla. Phalcon buscará una vista con el mismo nombre que la última acción ejecutada dentro de un directorio llamado como el último controlador ejecutado. En nuestro caso (`app/views/index/index.phtml`):

  
**app/views/index/index.phtml**

```php
<?php echo "<h1>Hola!</h1>";
```

  


Nuestro controlador (`app/controllers/IndexController.php`) ahora tiene una definición de acción vacía:

  
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

  


La salida del navegador debe seguir siendo la misma. El componente estático `Phalcon\Mvc\View` se crea automáticamente cuando haya terminado la ejecución de la acción. Learn more about `views usage here <views>`.

<a name='signup-form'></a>

## Diseñar un formulario de registro

Ahora vamos a cambiar el archivo de la vista `index.phtml`, para añadir un enlace a un nuevo controlador denominado "signup". El objetivo es permitir a los usuarios registrarse dentro de nuestra aplicación.

  
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

  
**app/views/index/index.phtml Rendered**

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

  


La ausencia de la acción en el index da el pase directo a una vista con la definición de formulario (`app/views/signup/index.phtml`):

  
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

  


En tu navegador, el formulario debería verse algo como así:

  
![](/images/content/tutorial-basic-3.png)

  
`Phalcon\Tag` también proporciona métodos útiles para construir elementos de formularios.

The :code:`Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our `public/index.php` file throws this exception:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementando este método se eliminará la excepción:

  
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

  


Si haces clic en el botón "Registrar" otra vez, verás una página en blanco. El nombre y correo electrónico proporcionados por el usuario deben estar guardados en una base de datos. Según las pautas MVC, las interacciones de la base de datos deben hacerse a través de modelos con el fin de garantizar la limpieza de código orientado a objetos.

<a name='model'></a>

## Creando un modelo

Phalcon provee el primer ORM PHP escrito enteramente en lenguaje C. En lugar de aumentar la complejidad del desarrollo, lo simplifica.

Antes de crear nuestro primer modelo, necesitamos crear una tabla de base de datos fuera de Phalcon para mapearlo. Se puede crear una tabla simple para almacenar usuarios registrados así:

  
**create_users_table.sql**

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,
    PRIMARY KEY (`id`)
);
```

  


Un modelo debe ubicarse en el directorio `app/models` (en este caso `app/models/Users.php`). El modelo se asigna a la tabla "users":

  
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

Para utilizar una conexión de base de datos y, posteriormente, acceder a los datos a través de nuestros modelos, debemos especificarlo en nuestro proceso de arranque. Una conexión de base de datos es justo un servicio mas que tiene nuestra aplicación y que puede ser utilizado para varios componentes:

  
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

  


At the beginning of the **registerAction** we create an empty user object from the Users class, which manages a User's record. The class's public properties map to the fields of the `users` table in our database. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. El método de `save()` devuelve un valor booleano que indica si el almacenamiento de los datos fue exitoso o no.

El ORM filtra automáticamente la entrada (auto-escape) para evitar inyecciones de SQL así que sólo tenemos que pasar la solicitud al método `save()`.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

  
![](/images/content/tutorial-basic-4.png)

  
<a name='conclusion'></a>

## Conclusión

As you can see, it's easy to start building an application using Phalcon. El hecho de que Phalcon se ejecute desde una extensión reduce significativamente la huella de los proyectos y le da un aumento considerable en el rendimiento.

Si está listo para obtener más información, consulte el [Rest Tutorial](/[[language]]/[[version]]/tutorial-rest) siguiente.