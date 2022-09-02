---
layout: default
language: 'es-es'
version: '4.0'
title: 'Tutorial - Básico'
keywords: 'tutorial, tutorial básico, paso a paso, mvc'
---

# Tutorial - Básico

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg) ![](/assets/images/level-beginner.svg)

## Resumen

A lo largo de este tutorial, crearemos una aplicación con un simple formulario de registro, mientras introducimos los principales aspectos de diseños de Phalcon.

Este tutorial cubre la implementación de una aplicación MVC simple, mostrando cuán rápido y fácil se puede hacer con Phalcon. Una vez desarrollado, puede usar esta aplicación y extenderla para satisfacer sus necesidades. El código en este tutorial también se puede usar como campo de juego para aprender otros conceptos e ideas específicas de Phalcon. <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe> 

Si sólo quiere empezar, puede saltarse esto y crear automáticamente un proyecto Phalcon con nuestras [herramientas de desarrollador](devtools).

La mejor manera de usar esta guía es seguirla y tratar de divertirse. Puede obtener el código completo [aquí](https://github.com/phalcon/tutorial). Si se queda bloqueado o tiene preguntas, por favor visítenos en [Discord](https://phalcon.io/discord) o en nuestro [Foro](https://phalcon.io/forum).

## Estructura de Ficheros

Una de las características clave de Phalcon es que está débilmente acoplado. Por eso, puede usar cualquier estructura de directorios que le convenga. En este tutorial usaremos una estructura de directorios *estándar*, usada normalmente en aplicaciones MVC.

```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

> **NOTA**: Ya que todo el código que expone Phalcon está encapsulado en la extensión (que ha cargado en su servidor web), no verá un directorio `vendor` conteniendo el código Phalcon. Todo lo que necesita está en memoria. Si todavía no ha instalado la aplicación, vaya a la página [instalación](installation) y complete la instalación antes de continuar con este tutorial.
{: .alert .alert-warning }

Si todo esto es nuevo, se recomienda que instale también las [Phalcon Devtools](devtools). Las DevTools aprovechan el servidor web integrado de PHP, lo que le permite ejecutar su aplicación casi inmediatamente. Si elige esta opción, necesitará un fichero `.htrouter.php` en la raíz de su proyecto con los siguientes contenidos:

```php
<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

$_GET['_url'] = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/public/index.php';
```

En el caso de nuestro tutorial, este fichero debe ubicarse en el directorio `tutorial`.

También puede usar nginX, apache, cherokee u otros servidores web. Puede consultar la página [configuración del servidor web](webserver-setup) para las instrucciones.

## Manos a la obra

El primer fichero que necesita crear es el fichero de arranque. Este fichero actúa como punto de entrada y configuración de su aplicación. En este fichero, puede implementar la inicialización de componentes, así como definir el comportamiento de la aplicación.

Este fichero gestiona 3 cosas:

- Registro de autocargadores de componentes
- Configurar Servicios y registrarlos en el contexto de la Inyección de Dependencias
- Resolver las peticiones HTTP de la aplicación

### Autocargador

Vamos a usar [Phalcon\Loader](loader), un cargador de ficheros compatible con [PSR-4](https://www.php-fig.org/psr/psr-4/). Cosas comunes que se deberían añadir al autocargador son sus controladores y modelos. También puede registrar directorios, que serán escaneados por los ficheros requeridos por la aplicación.

Para empezar, vamos a registrar nuestros directorios de la aplicación `controllers` y `models` usando [Phalcon\Loader](loader):

`public/index.php`

```php
<?php

use Phalcon\Loader;

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

### Gestión de Dependencias

Ya que Phalcon está débilmente acoplado, los servicios se registran con el Gestor de Dependencias del framework, por lo que se pueden inyectar automáticamente en los componentes y servicios integrados en el contenedor [IoC](https://en.wikipedia.org/wiki/Inversion_of_control). Frecuentemente, encontrará el término DI que significa Inyección de Dependencias. Inyección de Dependencias e Inversión de Control (IoC) puede sonar complejo pero Phalcon asegura que su uso sea simple, práctico y eficiente. El contenedor IoC de Phalcon consiste en los siguientes conceptos:

- Contenedor de Servicios: una "bolsa" donde globalmente almacenamos los servicios que nuestra aplicación necesita para funcionar.
- Servicio o Componente: Objeto de procesamiento de datos que se inyectará en los componentes

Cada vez que el framework requiere un componente o servicio, lo solicitará al contenedor usando un nombre acordado para el servicio. De esta manera tenemos una forma fácil de recuperar objetos necesarios para nuestra aplicación, como el registrador, conexión a base de datos, etc.

> **NOTA**: Si todavía está interesado en los detalles, por favor vea este artículo de [Martin Fowler](https://martinfowler.com/articles/injection.html). También tenemos [un gran tutorial](di) que cubre muchos casos de uso.
{: .alert .alert-warning }

### Factory por defecto

[Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) es una variante de [Phalcon\Di](api/Phalcon_Di). Para hacer las cosas más fáciles, automáticamente registrará la mayoría de los componentes que requiere una aplicación y vienen con Phalcon como estándar. Aunque se recomienda configurar los servicios manualmente, puede usar el contenedor [Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) inicialmente y más tarde personalizarlo para adaptarse a sus necesidades.

Los servicios se pueden registrar de varias maneras, pero para nuestro tutorial, usaremos [funciones anónimas](https://php.net/manual/en/functions.anonymous.php):

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// Create a DI
$container = new FactoryDefault();
```

Ahora necesitamos registrar el servicio *view*, estableciendo el directorio donde el framework encontrará los ficheros de la vista. Ya que las vistas no corresponden a clases, no se pueden cargar automáticamente por nuestro autocargador.

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');

        return $view;
    }
);
```

Ahora necesitamos registrar una URI base, que ofrecerá la funcionalidad para crear todas las URIs por Phalcon. El componente se asegurará de que tanto si ejecuta su aplicación a través del directorio superior como un subdirectorio, todas las URIs serán correctas. Para este tutorial, nuestra ruta base es `/`. Esto será importante más tarde en este tutorial cuando usemos la clase `Phalcon\Tag` para generar hiperenlaces.

`public/index.php`

```php
<?php

use Phalcon\Url;

// ...

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');

        return $url;
    }
);
```

### Gestionando las Peticiones de la Aplicación

Para poder gestionar cualquier petición, se usa el objeto [Phalcon\Mvc\Application](application) para hacer todo el trabajo pesado por nosotros. El componente aceptará la petición del usuario, detecta las rutas, despacha el controlador y renderiza la vista devolviendo los resultados.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($container);

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

$response->send();
```

### Poniendo Todo Junto

El fichero `tutorial/public/index.php` debería verse como:

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

Como puede ver, el fichero de arranque es muy corto y no necesitamos incluir ningún fichero adicional. Estás de camino a crear una aplicación MVC flexible en menos de 30 líneas de código.

## Creando un controlador

Por defecto, Phalcon buscará un controlador llamado `IndexController`. Es el punto de partida cuando no se ha añadido ningún controlador o acción en la petición (ej. `https://localhost/`). Un `IndexController` y su `IndexAction` deberían parecerse al siguiente ejemplo:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return '<h1>Hello!</h1>';
    }
}
```

Las clases controlador deben tener el sufijo `Controller` y las acciones del controlador deben tener el sufijo `Action`. Para más información puede leer nuestro documento sobre [controladores](controllers). Si accede a la aplicación desde su navegador, debería ver algo similar a:

![](/assets/images/content/tutorial-basic-1.png)

> **Congratulations, you are Phlying with Phalcon!**
{: .alert .alert-info }

## Enviando la Salida a una Vista

A veces es necesario enviar la salida por pantalla desde el controlador, pero no deseable como confirmarán la mayoría de puristas de la comunidad MVC. Todo debe pasarse a la vista, que es responsable de la salida de datos en pantalla. Phalcon buscará una vista con el mismo nombre que la última acción ejecutada dentro de un directorio llamado como el último controlador ejecutado.

Por lo tanto, en nuestro caso la URL es:

```php
http://localhost/
```

invocará `IndexController` y `indexAction`, y buscará la vista:

```php
/views/index/index.phtml
```

Si la encuentra, la analizará y enviará la salida a la pantalla. Nuestra vista tendrá entonces el siguiente contenido:

`app/views/index/index.phtml`

```php
<?php echo "<h1>Hello!</h1>";
```

y ya que movimos el `echo` de nuestra acción del controlador a la vista, estará vacía ahora:

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

La salida del navegador seguirá siendo la misma. El componente `Phalcon\Mvc\View` se crea automáticamente cuando la ejecución de la acción ha finalizado. Puede leer más sobre vistas en Phalcon [aquí](views).

## Diseñando un Formulario de Registro

Ahora cambiaremos el fichero de vista `index.phtml`, para añadir un enlace a un nuevo controlador llamado *signup*. El objeto es permitir a los usuarios registrarse en nuestra aplicación.

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

El código HTML generado muestra un etiqueta HTML ancla (`<a>`) enlazando a un nuevo controlador:

`app/views/index/index.phtml` (renderizado)

```html
<h1>Hola!</h1>

<a href="/signup">Regístrese aquí!</a>
```

Para generar el enlace para la etiqueta `<a>`, usamos el componente [Phalcon\Tag](tag). Es una clase de utilidad que ofrece una forma fácil de construir etiquetas HTML con las convenciones del framework en mente. Esta clase también es un servicio registrado en el Inyector de Dependencias por lo que podemos usar `$this->tag` para acceder a su funcionalidad.

> **NOTA**: `Phalcon\Tag` ya está registrado en el contenedor DI ya que hemos usado el contenedor `Phalcon\Di\FactoryDefault`. Si registra todos los registros por su cuenta, necesitará registrar este componente en su contenedor para que esté disponible en su aplicación.
{: .alert .alert-info }

El componente [Phalcon\Tag](tag) también usa el componente [Phalcon\Uri](uri) previamente registrado para generar correctamente URIs. Un artículo más detallado sobre generación de HTML [se puede encontrar aquí](tag).

![](/assets/images/content/tutorial-basic-2.png)

Y el controlador *Signup* es (`app/controllers/SignupController.php`):

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

La acción index vacía da el paso limpio a una vista con la definición del formulario (`app/views/signup/index.phtml`):

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

Viendo el formulario en su navegador mostrará lo siguiente:

![](/assets/images/content/tutorial-basic-3.png)

Como se ha mencionado antes, la clase de utilidad [Phalcon\Tag](tag), expone métodos útiles que le permiten construir elementos HTML de formulario con facilidad. El método `Phalcon\Tag::form()` recibe sólo un parámetro por instancia, una URI relativa al controlador/acción en la aplicación. `Phalcon\Tag::textField()` crea un elemento HTML de texto con el nombre como parámetro pasado, mientras que `Phalcon\Tag::submitButton()` crea un botón de envío HTML.

Al hacer click en el botón *Registro*, recibirá una excepción lanzada desde el framework, indicando que nos falta la acción `register` en el controlador `signup`. Nuestro fichero `public/index.php` lanza esta excepción:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementar ese método eliminará la excepción:

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

Si hace click otra vez en el botón *Registrar*, verá una página en blanco. Vamos a añadir una vista un poco más tarde que proporciona retroalimentación útil. Pero primero, deberíamos trabajar en el código para almacenar la entrada del usuario en una base de datos.

Según las directrices MVC, las interacciones de base de datos se deben hacer a través de modelos para asegurar un código limpio y orientado a objetos.

## Creando un modelo

Phalcon ofrece el primer ORM para PHP escrito completamente en lenguaje C. En vez de incrementar la complejidad de desarrollo, la simplifica.

Antes de crear nuestro primer modelo, necesitamos crear una tabla de base de datos usando una herramienta de acceso a base de datos o la utilidad de línea de comandos de la base de datos. Para este tutorial usamos MySQL como nuestra base de datos, una única tabla para almacenar usuarios registrados se puede crear como sigue:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

Un modelo debería ubicarse en el directorio `app/models` (`app/models/Users.php`). El modelo mapea a la tabla *users*:

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

> **NOTA**: Tenga en cuenta que las propiedades públicas del modelo corresponden a los nombres de los campos en nuestra tabla. 
{: .alert .alert-info }

## Establecer una conexión de base de datos

Para usar una conexión de base de datos y posteriormente acceder a los datos a través de nuestros modelos, necesitamos especificarlo en nuestro proceso de arranque. Una conexión de base de datos sólo es otro servicio que nuestra aplicación tiene, que se puede usar a lo largo de nuestra aplicación:

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);
```

Ajuste el fragmento de código anterior apropiadamente para su base de datos.

Con los parámetros de base de datos correctos, nuestro modelo está listo para interactuar con el resto de la aplicación, con lo que podemos guardar la entrada del usuario. Primero, vamos a tomarnos un momento y crear una vista para `SignupController::registerAction()` que mostrará un mensaje que permitirá al usuario conocer el resultado de la operación *save*.

`app/views/signup/register.phtml`

```php
<div class="alert alert-<?php echo $success === true ? 'success' : 'danger'; ?>">
    <?php echo $message; ?>
</div>

<?php echo $this->tag->linkTo(['/', 'Go back', 'class' => 'btn btn-primary']); ?>
```

Tenga en cuenta que hemos añadido algunos estilos css en el código anterior. Cubriremos incluyendo la hoja de estilos en la sección [Estilo](#styling) a continuación.

## Almacenando Datos usando Modelos

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

        //assign value from the form to $user
        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        // Store and check for errors
        $success = $user->save();

        // passing the result to the view
        $this->view->success = $success;

        if ($success) {
            $message = "Thanks for registering!";
        } else {
            $message = "Sorry, the following problems were generated:<br>"
                     . implode('<br>', $user->getMessages());
        }

        // passing a message to the view
        $this->view->message = $message;
    }
}
```

Al principio de `registerAction` creamos un objeto usuario vacío, usando la clase `Users` que creamos anteriormente. Usaremos esta clase para gestionar el registro de un usuario. Como hemos mencionado antes, las propiedades públicas de la clase mapean a los campos de la tabla `users` de nuestra base de datos. Establecer los valores relevantes en el registro nuevo y llamar a `save()` almacenará los datos en la base de datos para ese registro. El método `save()` devuelve un valor `booleano` que indica si el guardado ha ido bien o no.

El ORM escapará automáticamente la entrada evitando inyecciones SQL, por lo que sólo necesitamos pasar la petición al método `save()`.

Hay validaciones adicionales que ocurren automáticamente sobre los campos que están definidos como no nulos (requeridos). Si no hemos introducido alguno de los campos requeridos en el formulario de registro nuestra pantalla se parecerá a esta:

![](/assets/images/content/tutorial-basic-4.png)

## Listar los Usuarios Registrados

Ahora necesitaremos obtener y mostrar todos los usuarios registrados en nuestra base de datos

Lo primero que vamos a hacer en nuestro `indexAction` de `IndexController` es mostrar el resultado de la búsqueda de todos los usuarios, que se hace básicamente llamando al método estático `find()` de nuestro modelo (`Users::find()`).

`indexAction` cambiaría como sigue:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * Welcome and user list
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
    }
}
```

> **NOTA**: Asignamos los resultados de `find` a una propiedad mágica en el objeto `view`. Esto establece esta variable con los datos asignados y la hace disponible en nuestra vista
{: .alert .alert-info } 

En nuestro fichero de vista `views/index/index.phtml` podemos usar la variable `$users` como sigue:

La vista se parecerá a esto:

`views/index/index.phtml`

```html
<?php

echo "<h1>Hello!</h1>";

echo $this->tag->linkTo(["signup", "Sign Up Here!", 'class' => 'btn btn-primary']);

if ($users->count() > 0) {
    ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3">Users quantity: <?php echo $users->count(); ?></td>
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

Como puede ver, nuestra variable `$users` se puede iterar y contar. Puede obtener más información de cómo operar con modelos en nuestro documento sobre [modelos](db-models).

![](/assets/images/content/tutorial-basic-5.png)

## Estilo

Ahora podemos añadir un pequeño toque de diseño a nuestra aplicación. Podemos añadir el [CSS de Bootstrap](https://getbootstrap.com/) a nuestro código para que se pueda usar en nuestras vistas. Añadiremos un fichero `index.phtml` en la carpeta `views`, con el siguiente contenido:

`app/views/index.phtml`

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phalcon Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

En la plantilla anterior, la línea más importante es la llamada al método `getContent()`. Este método devuelve todo el contenido que se ha generado desde nuestra vista. Nuestra aplicación ahora mostrará:

![](/assets/images/content/tutorial-basic-6.png)

## Conclusión

Como puede ver, es fácil empezar a construir una aplicación usando Phalcon. Dado que Phalcon es una extensión cargada en memoria, la huella de su proyecto será mínima, mientras que al mismo tiempo disfrutará de un buen aumento del rendimiento.

Si está listo para aprender más, consulte el [Tutorial Vökuró](tutorial-vokuro) siguiente.
