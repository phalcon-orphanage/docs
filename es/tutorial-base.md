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

El primer archivo que necesitas crear es el archivo bootstrap. Este archivo actúa como el punto de entrada y configuración de la aplicación. En este archivo puedes implementar la inicialización de componentes, así como el comportamiento de la aplicación.

Este archivo gestiona 3 cosas:

- Registro de componente cargadores automáticos.
- Configuración de **servicios** y registrarlos en el contenedor de **Inyección de dependencias**.
- Resolución de las solicitudes HTTP de la aplicación.

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

Debido a que Phalcon esta **débilmente acoplado** los servicios se registran con el Gestor de Dependencias del framework, por lo que puede ser inyectados automáticamente a componentes y servicios envueltos en el contenedor de **IoC**. Con frecuencia se encontrará el término **DI** que hace referencia al Inyección de Dependencias. La Inyección de dependencias y la Inversión de Control (IoC) pueden sonar como una característica compleja, pero en Phalcon su uso es muy sencillo y práctico. Contenedor IoC de Phalcon consta de los siguientes conceptos:

- Contenedor de servicio: una bolsa donde almacenamos globalmente los servicios que nuestra aplicación usará para funcionar.
- Servicio o Componente: objeto de procesamiento de datos que será inyectado en los componentes

Si siguen interesados en más detalles. por favor, consulte este artículo de [Martin Fowler](https://martinfowler.com/articles/injection.html) sobre el patrón de diseño DI e IoC

Cada vez que el framework requiere de un componente o un servicio, le pedirá al contenedor mediante un nombre acordado para el servicio. No se olvide de incluir `Phalcon\Di` con la configuración del contenedor de servicio.

Los servicios se pueden registrar de varias formas, pero para nuestro tutorial usaremos una [función anónima](http://php.net/manual/en/functions.anonymous.php):

### Factory por defecto

`Phalcon\Di\FactoryDefault` es una variante de `Phalcon\Di`. Para facilitar las cosas, registrará automáticamente la mayoría de los componentes que vienen con Phalcon. Le recomendamos que usted registre sus servicios manualmente pero esto se ha incluido para ayudar a reducir la barrera de entrada al acostumbrarse a la gestión de la dependencia. Más tarde, usted puede especificar una vez que se sienta más cómodo con el concepto.

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

Next, we register a base URI so that all URIs generated by Phalcon match the application's base path of "/". Esto será importante más adelante en este tutorial cuando usemos la clase `Phalcon\Tag` para generar un hipervínculo.

**public/index.php**

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Setup a base URI
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

// Setup a base URI
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
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

Como se puede ver, el archivo de arranque es muy corto y no necesitamos incluir los archivos adicionales. **Felicidades** has creado una aplicación MVC flexible en menos de 30 líneas de código.

<a name='controller'></a>

## Creando un controlador

De forma predeterminada, Phalcon buscará un controlador llamado **IndexController**. Es el punto de partida cuando no se ha añadido ningún controlador o acción en la solicitud. (por ejemplo. http://localhost:8000/) un **IndexController** y su **IndexAction** deben parecerse al siguiente ejemplo:

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

La salida del navegador debe seguir siendo la misma. El componente estático `Phalcon\Mvc\View` se crea automáticamente cuando haya terminado la ejecución de la acción. Más información sobre el uso de las vistas [aquí](/[[language]]/[[version]]/views).

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

**app/views/index/index.phtml Procesado**

```html
<h1>Hola!</h1>

<a href="/signup">Regístrese aquí!</a>
```

Para generar la etiqueta usamos la clase `Phalcon\Tag`. Esta es una clase utilitaria que nos permite crear etiquetas HTML con los convenios del framework en mente. Como esta clase es también un servicio registrado en el DI, utilizamos `$this->tag` para acceder a él.

Un artículo más detallado en cuanto a generación de HTML se puede encontrar [aquí](/[[language]]/[[version]]/tag).

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

La acción de index vacía da el pase limpio a una vista con la definición de formulario (`app/views/signup/index.phtml`):

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

`Phalcon\Tag` proporciona métodos útiles para construir elementos de formulario.

El método `Phalcon\Tag::form()` recibe sólo un parámetro, por ejemplo, un URI relativo a una acción de control en la aplicación.

Haciendo clic en el botón "Registrar", usted recibirá una excepción desde el framework, lo que indica que nos falta la acción "register" en el controlador "signup". Nuestro archivo `public/index.php` lanza esta excepción:

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

Si haces clic en el botón "Registrar" otra vez, verás una página en blanco. El nombre y correo electrónico proporcionados por el usuario deben guardarse en una base de datos. Según las pautas MVC, las interacciones de la base de datos deben hacerse a través de modelos con el fin de garantizar la limpieza de código orientado a objetos.

<a name='model'></a>

## Creando un modelo

Phalcon trae el primer ORM PHP escrito enteramente en lenguaje C. En lugar de aumentar la complejidad del desarrollo, lo simplifica.

Antes de crear nuestro primer modelo, tenemos que crear una tabla en la base de datos fuera de Phalcon para luego mapearla. Puede crear una tabla simple para almacenar los usuarios registrados como la siguiente:

**create_users_table.sql**

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,
    PRIMARY KEY (`id`)
);
```

Un modelo debe ubicarse en el directorio `app/models` (`app/models/Users.php`). El modelo se asigna a la tabla "users":

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

Para utilizar una conexión de base de datos y posteriormente acceder a datos a través de nuestros modelos, tenemos que especificarlo en nuestro proceso de bootstrap. Una conexión de base de datos es un servicio que tiene nuestra aplicación que puede ser utilizado por distintos componentes:

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

Con los parámetros correctos de base de datos, nuestros modelos están listos para trabajar e interactuar con el resto de la aplicación.

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

Al principio del **registerAction** creamos un objeto de usuario vacío de la clase de Users, que gestiona el registro de un usuario. La clase mapea de propiedades públicas a los campos de la tabla de `users` en nuestra base de datos. Al establecer los valores correspondientes del nuevo registro y llamar a `save()`, almacenará los datos en la base de datos para ese registro. El método de `save()` devuelve un valor booleano que indica si el almacenamiento de los datos fue exitoso o no.

El ORM escapa automáticamente la entrada evitar inyecciones de SQL así que sólo tenemos que pasar la solicitud al método `save()`.

Una validación adicional se produce automáticamente en los campos que se definen como no nulos (obligatorio). Si no entramos ninguno de los campos requeridos en el formulario de inscripción, nuestra pantalla se verá así:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusión

Como se puede ver, es fácil empezar a construir una aplicación usando Phalcon. El hecho de que Phalcon corre como una extensión reduce significativamente la huella de los proyectos y le da un aumento considerable en el rendimiento.

Si estás listo para saber más, consultar el siguiente [Tutorial de REST](/[[language]]/[[version]]/tutorial-rest).