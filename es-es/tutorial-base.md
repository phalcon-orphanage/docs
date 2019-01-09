* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='basic'></a>

# Tutorial - básico

A lo largo de este tutorial, lo guiaremos a través de la creación de una aplicación con un formulario simple de registro comenzando desde cero. La siguiente guía es proporcionada para presentarle aspectos de diseño del framework Phalcon.

Este tutorial cubre la implementación de una aplicación MVC simple, que muestra qué tan rápido y fácil se puede hacerla con Phalcon. Este tutorial lo ayudará a comenzar y a crear una aplicación que puede ampliar para satisfacer muchas necesidades. El código en este tutorial también se puede utilizar como área de juegos para aprender otros conceptos e ideas específicas de Phalcon.

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

If you just want to get started you can skip this and create a Phalcon project automatically with our [developer tools](/3.4/en/devtools-usage). (Se recomienda que si no han tenido experiencia o te quedas atascado, vuelvas aquí)

La mejor manera de utilizar esta guía es seguirla y tratar de divertirse. Usted puede obtener el código completo [aquí](https://github.com/phalcon/tutorial). Si quedas atrapado en algún problema que no puedes resolver, por favor, visítenos en [Discord](https://phalcon.link/discord) o en nuestro [Foro](https://phalcon.link/forum).

<a name='file-structure'></a>

## Estructura de archivos

Una característica clave de Phalcon es ser débilmente acoplado, usted puede construir un proyecto Phalcon con una estructura de directorios que sea conveniente para su aplicación. Dicho esto, cierta uniformidad es útil cuando colabora con otros, por lo que este tutorial utiliza una estructura "Estándar" donde debe sentirse como en casa si han trabajado con otros MVC en el pasado.   


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
        Nota: Usted no verá un directorio `vendor` ya que todas las dependencias del núcleo de Phalcon se cargan en la memoria a través de la extensión de Phalcon, que usted debe tener instalada. If you missed that part have not installed the Phalcon extension [please go back](/3.4/en/installation) and finish the installation before continuing.
    </p>
</div>

If this is all brand new it is recommended that you install the [Phalcon Devtools](/3.4/en/devtools-installation) since it leverages PHP's built-in server you to get your app running without having to configure a web server by adding this [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) to the root of your project.

Otherwise if you want to use Nginx here are some additional setup [here](/3.4/en/webserver-setup#nginx).

Apache can also be used with these additional setup [here](/3.4/en/webserver-setup#apache).

Finally, if you flavor is Cherokee use the setup [here](/3.4/en/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Manos a la obra

El primer archivo que necesitas crear es el archivo bootstrap. Este archivo actúa como el punto de entrada y configuración de la aplicación. En este archivo puedes implementar la inicialización de componentes, así como el comportamiento de la aplicación.

Este archivo gestiona 3 cosas:

- Registro de componente cargadores automáticos
- Configuración de servicios y luego registrarlos en el contenedor de Inyección de dependencias
- Resolución de las solicitudes HTTP de la aplicación

<a name='autoloaders'></a>

### Cargadores automáticos

Los Cargadores Automáticos utilizan un cargador de archivos compatible con [PSR-4](http://www.php-fig.org/psr/psr-4/) a través de Phalcon. Otras cosas que se deben agregar al autocargador son sus controladores y modelos. Puede registrar directorios donde se buscarán archivos del namespace de la aplicación. If you want to read about other ways that you can use autoloaders head [here](/3.4/en/loader#overview).

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

Debido a que Phalcon esta débilmente acoplado los servicios se registran con el Gestor de Dependencias del framework, por lo que puede ser inyectados automáticamente a componentes y servicios que estén integrados en el contenedor de [IoC](https://en.wikipedia.org/wiki/Inversion_of_control). Con frecuencia se encontrará el término DI que hace referencia a Inyección de Dependencias. La Inyección de Dependencia y la Inversión de Control (IoC) pueden parecer una característica compleja, pero en Phalcon su uso es muy simple y práctico. Contenedor IoC de Phalcon consta de los siguientes conceptos:

- Contenedor de servicio: una bolsa donde almacenamos globalmente los servicios que nuestra aplicación usará para funcionar.
- Servicio o Componente: objeto de procesamiento de datos que será inyectado en los componentes

Cada vez que el marco requiera un componente o servicio, solicitará el contenedor utilizando un nombre acordado para el servicio. No se olvide de incluir `Phalcon\Di` con la configuración del contenedor de servicio.

<div class='alert alert-warning'>
    <p>
        Si sigue interesado en más detalles. por favor, consulte este artículo de [Martin Fowler](https://martinfowler.com/articles/injection.html). Also we have [a great tutorial](/3.4/en/di) covering many use cases.
    </p>
</div>

### Factory por defecto

The [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) is a variant of [Phalcon\Di](api/Phalcon_Di). Para facilitar las cosas, registrará automáticamente la mayoría de los componentes que vienen con Phalcon. Le recomendamos que usted registre sus servicios manualmente pero esto se ha incluido para ayudar a reducir la barrera de entrada al acostumbrarse a la gestión de la dependencia. Más tarde, usted puede especificar una vez que se sienta más cómodo con el concepto.

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

In the last part of this file, we find [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application). Su propósito es inicializar el entorno de la solicitud, rutear la solicitud entrante y luego despachar cualquier acción descubierta; agrega todas las respuestas y las devuelve cuando el proceso se completa.

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

Como se puede ver, el archivo de arranque es muy corto y no necesitamos incluir los archivos adicionales. Felicidades has creado una aplicación MVC flexible en menos de 30 líneas de código.

<a name='controller'></a>

## Creando un controlador

De forma predeterminada, Phalcon buscará un controlador llamado `IndexController`. Es el punto de partida cuando no se ha añadido ningún controlador o acción en la solicitud. Por ejemplo: `http://localhost:8000/`. Un `IndexController` y su `IndexAction` deben parecerse al siguiente ejemplo:

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

Las clases de controlador deben tener el sufijo `Controller` y las acciones del controlador deben tener el sufijo `Action`. Si accede a la aplicación desde su navegador, debería ver algo como esto:

![](/assets/images/content/tutorial-basic-1.png)

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

La salida del navegador debe seguir siendo la misma. El componente estático `Phalcon\Mvc\View` se crea automáticamente cuando haya terminado la ejecución de la acción. Learn more about views usage [here](/3.4/en/views).

<a name='signup-form'></a>

## Diseñar un formulario de registro

Now we will change the `index.phtml` view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

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

A more detailed article regarding HTML generation [can be found here](/3.4/en/tag).

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

![](/assets/images/content/tutorial-basic-3.png)

[Phalcon\Tag](api/Phalcon_Tag) also provides useful methods to build form elements.

El método `Phalcon\Tag::form()` recibe sólo un parámetro, por ejemplo, un URI relativo a un controlador/acción en la aplicación.

Al hacer clic en el botón "Registrar", usted recibirá una excepción del framework, lo que indica que nos falta la acción `register` en el controlador `signup`. Our `public/index.php` file throws this exception:

```bash
Exception: Action "register" was not found on handler "signup"
```

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

Si haces clic en el botón "Registrar" otra vez, verás una página en blanco. El nombre y correo electrónico proporcionados por el usuario deben estar guardados en una base de datos. Según las pautas MVC, las interacciones de la base de datos deben hacerse a través de modelos con el fin de garantizar la limpieza de código orientado a objetos.

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

Para utilizar una conexión de base de datos y, posteriormente, acceder a los datos a través de nuestros modelos, debemos especificarlo en nuestro proceso de arranque. Una conexión de base de datos es justo un servicio mas que tiene nuestra aplicación y que puede ser utilizado para varios componentes:

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

Al principio del `registerAction` creamos un objeto de usuario vacío de la clase de Users, que gestiona el registro de un usuario. La clase mapea de propiedades públicas a los campos de la tabla de `users` en nuestra base de datos. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. El método de `save()` devuelve un valor booleano que indica si el almacenamiento de los datos fue exitoso o no.

El ORM filtra automáticamente la entrada (auto-escape) para evitar inyecciones de SQL así que sólo tenemos que pasar la solicitud al método `save()`.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

![](/assets/images/content/tutorial-basic-4.png)

<a name='list-of-users'></a>

## Lista de usuarios

Ahora veremos como obtener y mostrar los usuarios que tenemos registrados en la base de datos.

Lo primero que tenemos que hacer en nuestra acción `indexAction` del controlador `IndexController` es mostrar el resultado de la búsqueda de todos los usuarios, esto se puede hacer simplemente utilizando `Users::find()`. Veamos como se vería ahora nuestro `indexAction`

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * Bienvenida y lista de usuarios
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
    }
}
```

Ahora, en nuestro archivo `views/index/index.phtml` tendremos acceso a los usuarios encontrados en la base de datos. Estos estarán disponibles en la variable `$users`. Esta variable tiene el mismo nombre al que usamos en `$this->view->users`.

La vista se verá así:

`views/index/index.phtml`

```html
<?php

echo "<h1>Hello!</h1>";

echo $this->tag->linkTo(["signup", "¡Regístrate aquí!", 'class' => 'btn btn-primary']);

if ($users->count() > 0) {
    ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Email</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3">Cantidad de usuarios: <?php echo $users->count(); ?></td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->email; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
```

As you can see our variables `$users` can be iterated and counted, this we will see in depth later on when viewing the [models](/3.4/en/db-models).

![](/images/content/tutorial-basic-5.png)

<a name='adding-style'></a>

## Agregando estilos

Para darle un toque de diseño a nuestra primer aplicación agregaremos bootstrap y una pequeña plantilla que será utilizada en todas las vistas.

Agregamos un archivo `index.phtml` en la carpeta `views`, con el siguiente contenido:

`app/views/index.phtml`

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phalcon Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

The most important thing to highlight in our template is the function `getContent()` which will give us the content generated by the view. Now, our application will be something like this:

![](/images/content/tutorial-basic-6.png)

<a name='conclusion'></a>

## Conclusión

Como se puede ver, es fácil empezar a construir una aplicación usando Phalcon. El hecho de que Phalcon se ejecute desde una extensión reduce significativamente la huella de los proyectos y le da un aumento considerable en el rendimiento.

If you are ready to learn more check out the [Rest Tutorial](/3.4/en/tutorial-rest) next.