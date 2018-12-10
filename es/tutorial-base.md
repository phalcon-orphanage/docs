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
          <a href="#list-of-users">Lista de usuarios</a>
        </li>
        <li>
          <a href="#adding-styles">Agregando estilos</a>
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

Este tutorial cubre la implementación de una aplicación MVC simple, que muestra qué tan rápido y fácil se puede hacerla con Phalcon. Este tutorial lo ayudará a comenzar y a crear una aplicación que puede ampliar para satisfacer muchas necesidades. El código en este tutorial también se puede utilizar como área de juegos para aprender otros conceptos e ideas específicas de Phalcon.

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

Si solo desea empezar puede saltarse esto y crear automáticamente un proyecto Phalcon con nuestras [herramientas de desarrollo](/[[language]]/[[version]]/devtools-usage). (Se recomienda que si no han tenido experiencia o te quedas atascado, vuelvas aquí)

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
        Nota: Usted no verá un directorio `vendor` ya que todas las dependencias del núcleo de Phalcon se cargan en la memoria a través de la extensión de Phalcon, que usted debe tener instalada. Si te perdiste esa parte y no has instalado la extensión de Phalcon por favor [vuelve atrás](/[[language]]/[[version]]/installation) y finaliza la instalación antes de continuar.
    </p>
</div>

Si todo esto es nuevo, se recomienda que instale [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation), ya que aprovecha el servidor incorporado de PHP. Para que su aplicación se ejecute sin tener que configurar un servidor web, agregue este [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) a la raíz de su proyecto.

De lo contrario si desea utilizar Nginx [aquí](/[[language]]/[[version]]/webserver-setup#nginx) hay alguna configuración adicional.

Apache también puede utilizarse con [esta configuración adicional](/[[language]]/[[version]]/webserver-setup#apache).

Por último, si usted desea usar Cherokee la configuración [esta aquí](/[[language]]/[[version]]/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Manos a la obra

El primer archivo que necesitas crear es el archivo bootstrap. Este archivo actúa como el punto de entrada y configuración de la aplicación. En este archivo puedes implementar la inicialización de componentes, así como el comportamiento de la aplicación.

Este archivo gestiona 3 cosas:

- Registro de componente cargadores automáticos
- Configuración de servicios y luego registrarlos en el contenedor de Inyección de dependencias
- Resolución de las solicitudes HTTP de la aplicación

<a name='autoloaders'></a>

### Cargadores automáticos

Los Cargadores Automáticos utilizan un cargador de archivos compatible con [PSR-4](http://www.php-fig.org/psr/psr-4/) a través de Phalcon. Otras cosas que se deben agregar al autocargador son sus controladores y modelos. Puede registrar directorios donde se buscarán archivos del namespace de la aplicación. Si quiere leer sobre otras maneras en que usted puede utilizar el Autocargador (Autoloader) puede dar un vistazo [aquí](/[[language]]/[[version]]/loader#overview).

Para comenzar, registramos los directorios `controllers` y `models` de nuestra aplicación. No se olvide de incluir el cargador `Phalcon\Loader`.

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
        Si sigue interesado en más detalles. por favor, consulte este artículo de [Martin Fowler](https://martinfowler.com/articles/injection.html). También tenemos [un gran tutorial](/[[language]]/[[version]]/di) que aborda muchos casos y situaciones.
    </p>
</div>

### Factory por defecto

El inyector `Phalcon\Di\FactoryDefault` es una variante de `Phalcon\Di`. Para facilitar las cosas, registrará automáticamente la mayoría de los componentes que vienen con Phalcon. Le recomendamos que usted registre sus servicios manualmente pero esto se ha incluido para ayudar a reducir la barrera de entrada al acostumbrarse a la gestión de la dependencia. Más tarde, usted puede especificar una vez que se sienta más cómodo con el concepto.

Los servicios se pueden registrar de varias formas, pero para nuestro tutorial usaremos una [función anónima](http://php.net/manual/en/functions.anonymous.php):

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

Como puede ver, el archivo de arranque es muy corto y no necesitamos incluir ningún archivo adicional. Felicidades has creado una aplicación MVC flexible en menos de 30 líneas de código.

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

Ahora cambiaremos el archivo de vista `index.phtml`, para agregar un enlace a un nuevo controlador llamado "signup". El objetivo es permitir a los usuarios registrarse dentro de nuestra aplicación.

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

Si haces clic en el botón "Registrar" otra vez, verás una página en blanco. El nombre y correo electrónico proporcionados por el usuario deben estar guardados en una base de datos. Según las pautas MVC, las interacciones de la base de datos deben hacerse a través de modelos con el fin de garantizar la limpieza de código orientado a objetos.

<a name='model'></a>

## Creando un modelo

Phalcon ofrece el primer ORM para PHP escrito enteramente en el lenguaje C. En lugar de aumentar la complejidad del desarrollo, lo simplifica.

Antes de crear nuestro primero modelo, necesitamos crear una tabla en la base de datos, desde donde Phalcon se mapea. Una tabla simple para almacenar usuarios registrado, puede ser creada de la siguiente manera:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,
    PRIMARY KEY (`id`)
);
```

Un modelo debe ubicarse en el directorio `app/models` (en este caso `app/models/Users.php`). El modelo se asigna a la tabla "users":

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

Con los parámetros correctos de base de datos, nuestros modelos están listos para trabajar e interactuar con el resto de la aplicación.

<a name='storing-data'></a>

## Almacenando datos utilizando modelos

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    /**
     * Mostrar formulario para registrar un nuevo usuario
     */
    public function indexAction()
    {
    }

    /**
     * Registrar nuevo usuario y mostrar un mensaje
     */
    public function registerAction()
    {
        $user = new Users();

        // Almacenar y comprobar errores
        $success = $user->save(
            $this->request->getPost(),
            ['name', 'email']
        );

        // pasando el resultado a la vista
        $this->view->success = $success;

        if ($success) {
            $message = "¡Gracias por registrarte!";
        } else {
            $message = "Lo sentimos, se generaron los siguiente problemas:<br>" . implode('<br>', $user->getMessages());
        }

        // pasando un mensaje a la vista
        $this->view->message = $message;
    }
}
```

Al principio del `registerAction` creamos un objeto de usuario vacío de la clase `Users`, que gestiona el registro de un usuario. La clase asigna las propiedades públicas a los campos de la tabla `users` en nuestra base de datos. Al establecer los valores correspondientes del nuevo registro y llamar a `save()`, almacenará los datos en la base de datos para ese registro. El método de `save()` devuelve un valor booleano que indica si el almacenamiento de los datos fue exitoso o no.

El ORM filtra automáticamente la entrada (auto-escape) para evitar inyecciones de SQL así que sólo tenemos que pasar la solicitud al método `save()`.

La validación adicional ocurre automáticamente en los campos que se definen como no nulos (obligatorios). Si no ingresamos ninguno de los campos obligatorios en el formulario de registro, nuestra pantalla se verá así:

![](/images/content/tutorial-basic-4.png)

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

Como puede ver nuestra variable `$users` puede ser iterada y contada, esto lo veremos luego en profundidad cuando veamos los [modelos](/[[language]]/[[version]]/db-models).

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

Lo más importante para destacar de nuestra plantilla es la función `getContent()` la cual nos entregará el contenido generado por la vista. Ahora, nuestra aplicación se verá así:

![](/images/content/tutorial-basic-6.png)

<a name='conclusion'></a>

## Conclusión

Como puede ver, es fácil comenzar a construir una aplicación usando Phalcon. El hecho de que Phalcon se ejecute desde una extensión reduce significativamente la huella de los proyectos y le da un aumento considerable en el rendimiento.

Si está listo para obtener más información, consulte el [Rest Tutorial](/[[language]]/[[version]]/tutorial-rest) siguiente.