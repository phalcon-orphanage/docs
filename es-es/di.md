* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='di-service-location'></a>

# Inyector de Dependencias / Localización de Servicios

<a name='di-explained'></a>

## DI explicado

El siguiente ejemplo es un poco largo, pero trata de explicar por qué Phalcon utiliza la inyección de dependencia y la localización de servicios. Primero, supongamos que estamos desarrollando un componente llamado `SomeComponent`. Este realiza algunas tareas. Nuestro componente tiene una dependencia, que es una conexión a base de datos.

En el primer ejemplo, la conexión es creada dentro del componente. Aunque se trata de una implementación perfectamente válida, no es práctica, debido a que no podemos cambiar los parámetros de conexión o el tipo de base de datos, ya que el componente sólo funciona de la forma en que fue creado.

```php
<?php

class SomeComponent
{
    /**
     * La instancia de la conexión está codificada dentro
     * del componente, por lo tanto, es difícil reemplazarla externamente
     * o cambiar su comportamiento
     */
    public function someDbTask()
    {
        $connection = new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );

        // ...
    }
}

$some = new SomeComponent();

$some->someDbTask();
```

Para solucionar esta carencia, hemos creado un setter que inyecta la dependencia externamente antes de usarla. Esto también es una implementación válida pero tiene sus defectos:

```php
<?php

class SomeComponent
{
    private $connection;

    /**
     * Configurar la conexión externamente
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }
}

$some = new SomeComponent();

// Crear la conexión
$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Inyectar la conexión en el componente
$some->setConnection($connection);

$some->someDbTask();
```

Ahora consideremos que utilizamos este componente en diferentes partes de la aplicación; entonces necesitaremos crear la conexión varias veces antes de pasarla al componente. Usando un patrón de registro global, podemos almacenar el objeto de conexión ahí y reutilizarlo siempre que lo necesitemos.

```php
<?php

class Registry
{
    /**
     * Retornar la conexión
     */
    public static function getConnection()
    {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
}

class SomeComponent
{
    protected $connection;

    /**
     * Establecer la conexión externamente
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }
}

$some = new SomeComponent();

// Pasamos la conexión definida en el registro
$some->setConnection(Registry::getConnection());

$some->someDbTask();
```

Ahora, imaginemos que debemos implementar dos métodos en el componente, el primero siempre necesita crear una conexión nueva y el segundo siempre necesita utilizar una conexión compartida:

```php
<?php

class Registry
{
    protected static $connection;

    /**
     * Crea una conexión
     *
     * @return Connection
     */
    protected static function createConnection(): Connection
    {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }

    /**
     * Crea una conexión una sola vez y la devuelve
     *
     * @return Connection
     */
    public static function getSharedConnection(): Connection
    {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    /**
     * Siempre regresa una nueva conexión
     *
     * @return Connection
     */
    public static function getNewConnection(): Connection
    {
        return self::createConnection();
    }
}

class SomeComponent
{
    protected $connection;

    /**
     * Establece una conexión externa
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Este método siempre regresa una conexión compartida
     */
    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }

    /**
     * Este método siempre necesita una nueva conexión
     *
     * @param Connection $connection
     */
    public function someOtherDbTask(Connection $connection)
    {

    }
}

$some = new SomeComponent();

// Esto inyecta una conexión compartida
$some->setConnection(
    Registry::getSharedConnection()
);

$some->someDbTask();

// Siempre pasamos una nueva conexión como parámetro
$some->someOtherDbTask(
    Registry::getNewConnection()
);
```

Hasta ahora hemos visto cómo la inyección de dependencias resolvió nuestros problemas. Pasando las dependencias como argumentos en lugar de crearlas internamente en el código, haciendo a nuestra aplicación más mantenible y desacoplada. Sin embargo, a la larga, esta forma de inyección de dependencias tiene algunas desventajas.

Por ejemplo, si el componente tiene muchas dependencias, necesitaremos crear múltiples argumentos setter para pasar las dependencias o crear un constructor que las pase con muchos argumentos, creando (todas las veces) dependencias adicionales antes de usar el componente, haciendo a nuestro código no sea tan fácil de mantener como nos gustaría:

```php
<?php

// Crear dependencias u obtenerlas del registro
$connection = new Connection();
$session    = new Session();
$fileSystem = new FileSystem();
$filter     = new Filter();
$selector   = new Selector();

// Pasarlas después como parámetros del constructor
$some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

// ... O utilizando setters
$some->setConnection($connection);
$some->setSession($session);
$some->setFileSystem($fileSystem);
$some->setFilter($filter);
$some->setSelector($selector);
```

Piense ahora, si tuviéramos que crear este objeto en muchas partes de nuestra aplicación. En el futuro, si no requerimos ninguna de las dependencias, tenemos que ir a través de todo el código fuente para quitar el parámetro en cualquier constructor o setter donde inyectamos el código. Para solucionar esto, volvemos otra vez a un registro global para crear el componente. Sin embargo, se añade una nueva capa de abstracción antes de crear el objeto:

```php
<?php

class SomeComponent
{
    // ...

    /**
     * Definir un método factory para crear instancias de SomeComponent e inyectar las dependencias
     */
    public static function factory()
    {
        $connection = new Connection();
        $session    = new Session();
        $fileSystem = new FileSystem();
        $filter     = new Filter();
        $selector   = new Selector();

        return new self($connection, $session, $fileSystem, $filter, $selector);
    }
}
```

Ahora nos encontramos otra vez donde comenzamos, ¡estamos construyendo nuevamente las dependencias dentro del componente! Debemos encontrar una solución que nos aleje de caer repetidamente en malas prácticas.

Una forma práctica y elegante de solucionar estos problemas es utilizando un contenedor para las dependencias. Los contenedores actúan como el registro global que vimos anteriormente. Utilizando el contenedor para las dependencias como un puente para obtenerlas permitiendo reducir la complejidad de nuestro componente:

```php
<?php

use Phalcon\Di;
use Phalcon\DiInterface;

class SomeComponent
{
    protected $di;

    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    public function someDbTask()
    {
        // Obtiene el servicio de conexión
        // Siempre devuelve una conexión nueva 
        $connection = $this->di->get('db');
    }

    public function someOtherDbTask()
    {
        // Obtiene el servicio de conexión compartida
        // Siempre regresa la misma conexión
        $connection = $this->di->getShared('db');

        // Este método requiere el servicio 'filter'
        $filter = $this->di->get('filter');
    }
}

$di = new Di();

// Registrar el servicio 'db' en el contenedor
$di->set(
    'db',
    function () {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
);

// Registrar el servicio 'filter' en el contenedor
$di->set(
    'filter',
    function () {
        return new Filter();
    }
);

// Registrar el servicio 'session' en el contenedor
$di->set(
    'session',
    function () {
        return new Session();
    }
);

// Pasamos al contenedor de servicios como único parámetro
$some = new SomeComponent($di);

$some->someDbTask();
```

El componente ahora puede simplemente acceder al servicio que requiere cuando lo necesita, si no requiere un servicio ni si quiera se inicializa, ahorrando recursos. El componente ahora es altamente desvinculado. Por ejemplo, podemos cambiar la manera en que las conexiones se crean, su comportamiento o cualquier otro aspecto de ellas y no afectaría al componente en si.

[Phalcon\Di](api/Phalcon_Di) is a component implementing Dependency Injection and Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, [Phalcon\Di](api/Phalcon_Di) is essential to integrate the different components of the framework. El desarrollador también puede utilizar este componente para inyectar dependencias y administrar instancias globales de las diferentes clases que se utilizan en la aplicación.

Basically, this component implements the [Inversion of Control](https://en.wikipedia.org/wiki/Inversion_of_control) pattern. Aplicando esto, los objetos no reciben sus dependencias usando configuradores o constructores, sino solicitando un servicios de inyección de dependencias. Esto reduce la complejidad total, puesto que hay solamente una manera de conseguir las dependencias necesarias dentro de un componente.

Además, este patrón aumenta la posibilidad de pruebas con el código, por lo que es menos propenso a errores.

<a name='registering-services'></a>

## Registrar servicios en el contenedor

El framework mismo o el desarrollador pueden registrar servicios. Cuando un componente A requiere del componente B (o una instancia de su clase) para funcionar, puede solicitar el componente B desde el contenedor, en lugar de crear un nuevo componente de la instancia B.

Esta forma de trabajar nos da muchas ventajas:

* Podemos fácilmente reemplazar un componente con uno creado por nosotros mismos o por un tercero.
* Tenemos control total de la inicialización del objeto, lo que nos permite definir estos objetos según sea necesario antes de entregarlos a los componentes.
* Podemos obtener instancias globales de los componentes en forma estructurada y unificada.

Los servicios pueden ser registrados utilizando varios tipos de definiciones:

<a name='simple-registration'></a>

### Registro simple

Como se ha visto antes, hay varias formas de registro de servicios. A estos los llamamos simples:

<a name='simple-registration-string'></a>

#### Cadena de caracteres (string)

Este tipo espera el nombre de una clase válida, retornando un objecto de la clase especificada, si la clase no esta cargada, será instanciada utilizando un cargador automático. Este tipo de definición no permite para especificar argumentos o parámetros para el constructor de la clase:

```php
<?php

// Retorna new Phalcon\Http\Request();
$di->set(
    'request',
    'Phalcon\Http\Request'
);
```

<a name='class-instances'></a>

#### Instancias de clase

Este tipo espera un objeto. Como el objeto no necesita ser resuelto debido a que ya es un objeto, se podría decir que en realidad no es una inyección de dependencia, sin embargo, es útil si desea forzar la dependencia de retorno a ser siempre el mismo valor u objeto:

```php
<?php

use Phalcon\Http\Request;

// Retorna new Phalcon\Http\Request();
$di->set(
    'request',
    new Request()
);
```

<a name='closures-anonymous-functions'></a>

#### Closures/Funciones anónimas

Este método ofrece una mayor libertad para construir la dependencia como se desee, sin embargo, es difícil cambiar algunos de los parámetros desde el exterior sin tener que cambiar por completo la definición de dependencia:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$di->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'blog',
            ]
        );
    }
);
```

Algunas de las limitaciones pueden superarse pasando variables adicionales al entorno del cierre:

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$config = new Config(
    [
        'host'     => '127.0.0.1',
        'username' => 'user',
        'password' => 'pass',
        'dbname'   => 'my_database',
    ]
);

// Utilizando la variable $config en el ámbito actual
$di->set(
    'db',
    function () use ($config) {
        return new PdoMysql(
            [
                'host'     => $config->host,
                'username' => $config->username,
                'password' => $config->password,
                'dbname'   => $config->name,
            ]
        );
    }
);
```

También puede acceder a otros servicios del DI con el método `get()`:

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$di->set(
    'config',
    function () {
        return new Config(
            [
                'host'     => '127.0.0.1',
                'username' => 'user',
                'password' => 'pass',
                'dbname'   => 'my_database',
            ]
        );
    }
);

// Usando el servicio 'config' desde el DI
$di->set(
    'db',
    function () {
        $config = $this->get('config');

        return new PdoMysql(
            [
                'host'     => $config->host,
                'username' => $config->username,
                'password' => $config->password,
                'dbname'   => $config->name,
            ]
        );
    }
);
```

<a name='complex-registration'></a>

### Registro Complejo

Si es necesario cambiar la definición de un servicio sin crear instancias/resolver el servicio, entonces, necesitamos definir los servicios utilizando la sintaxis de matriz. Definir un servicio utilizando una definición de matriz puede ser un poco más detallado:

```php
<?php

use Phalcon\Logger\Adapter\File as LoggerFile;

// Registrar un servicio 'logger' con nombre de clase y sus parámetros
$di->set(
    'logger',
    [
        'className' => 'Phalcon\Logger\Adapter\File',
        'arguments' => [
            [
                'type'  => 'parameter',
                'value' => '../apps/logs/error.log',
            ]
        ]
    ]
);

// Utilizando una función anónima
$di->set(
    'logger',
    function () {
        return new LoggerFile('../apps/logs/error.log');
    }
);
```

Ambos registros de servicio producen el mismo resultado. La definición de matriz permite sin embargo, la alteración de los parámetros de servicio si es necesario:

```php
<?php

// Cambiar el nombre de clase del servicio
$di
    ->getService('logger')
    ->setClassName('MyCustomLogger');

// Cambiar el primer parámetro sin instanciar al logger
$di
    ->getService('logger')
    ->setParameter(
        0,
        [
            'type'  => 'parameter',
            'value' => '../apps/logs/error.log',
        ]
    );
```

Además mediante la sintaxis de matriz, puede utilizar tres tipos de inyección de dependencias:

<a name='constructor-injection'></a>

#### Inyección de Contructores

Este tipo de inyección pasa las dependencias/argumentos al constructor de la clase. Supongamos que tenemos los siguientes componentes:

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    protected $response;

    protected $someFlag;



    public function __construct(Response $response, $someFlag)
    {
        $this->response = $response;
        $this->someFlag = $someFlag;
    }
}
```

El servicio puede registrarse de esta manera:

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response'
    ]
);

$di->set(
    'someComponent',
    [
        'className' => 'SomeApp\SomeComponent',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'response',
            ],
            [
                'type'  => 'parameter',
                'value' => true,
            ],
        ]
    ]
);
```

The service 'response' ([Phalcon\Http\Response](api/Phalcon_Http_Response)) is resolved to be passed as the first argument of the constructor, while the second is a boolean value (true) that is passed as it is.

<a name='setter-injection'></a>

#### Inyección de Configuraciones

Las clases pueden tener setters para inyectar dependencias opcionales, nuestra clase anterior, puede modificarse para aceptar las dependencias con setters:

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    protected $response;

    protected $someFlag;

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function setFlag($someFlag)
    {
        $this->someFlag = $someFlag;
    }
}
```

Un servicio con setter de inyección puede ser registrado de la siguiente manera:

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response',
    ]
);

$di->set(
    'someComponent',
    [
        'className' => 'SomeApp\SomeComponent',
        'calls'     => [
            [
                'method'    => 'setResponse',
                'arguments' => [
                    [
                        'type' => 'service',
                        'name' => 'response',
                    ]
                ]
            ],
            [
                'method'    => 'setFlag',
                'arguments' => [
                    [
                        'type'  => 'parameter',
                        'value' => true,
                    ]
                ]
            ]
        ]
    ]
);
```

<a name='properties-injection'></a>

#### Inyección de Propiedades

Una estrategia menos común es inyectar dependencias o parámetros en atributos públicos de la clase:

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    public $response;

    public $someFlag;
}
```

Un servicio con propiedades de inyección puede ser registrado de la siguiente manera:

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response',
    ]
);

$di->set(
    'someComponent',
    [
        'className'  => 'SomeApp\SomeComponent',
        'properties' => [
            [
                'name'  => 'response',
                'value' => [
                    'type' => 'service',
                    'name' => 'response',
                ],
            ],
            [
                'name'  => 'someFlag',
                'value' => [
                    'type'  => 'parameter',
                    'value' => true,
                ],
            ]
        ]
    ]
);
```

Los tipos de parámetros soportados son los siguientes:

<table>
  <tr>
    <th>
      Tipo
    </th>
    
    <th>
      Descripción
    </th>
    
    <th>
      Ejemplo
    </th>
  </tr>
  
  <tr>
    <td>
      parameter
    </td>
    
    <td>
      Representa un valor literal que se pasa como parámetro
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'parameter', 'value' =&gt; 1234]</code></pre>
    </td>
  </tr>
  
  <tr>
    <td>
      service
    </td>
    
    <td>
      Representa otro servicio en el contenedor de servicio
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'service', 'name' =&gt; 'request']</code></pre>
    </td>
  </tr>
  
  <tr>
    <td>
      instance
    </td>
    
    <td>
      Representa un objeto que debe ser construido de forma dinámica
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'instance', 'className' =&gt; 'DateTime', 'arguments' =&gt; ['now']]</code></pre>
    </td>
  </tr>
</table>

La resolución de un servicio cuya definición es compleja puede ser ligeramente más lento que las definiciones simples vistas anteriormente. Sin embargo, estos ofrecen un enfoque más robusto para definir e inyectar servicios.

Es posible mezclar de diferentes tipos de definiciones, cada uno puede decidir cuál es la manera más apropiada para registrar los servicios según las necesidades de su aplicación.

<a name='array-syntax'></a>

### Sintaxis de array

Con la sintaxis de array o matriz también se puede registrar servicios:

```php
<?php

use Phalcon\Di;
use Phalcon\Http\Request;

// Crear un contenedor de inyección de dependencias
$di = new Di();

// Por su nombre de clase
$di['request'] = 'Phalcon\Http\Request';

// Usando una función anónima, la instancia será con carga peresoza
$di['request'] = function () {
    return new Request();
};

// Registrando una instancia directamente
$di['request'] = new Request();

// Utilizando un array como definición
$di['request'] = [
    'className' => 'Phalcon\Http\Request',
];
```

En los ejemplos anteriores, cuando el framework necesite acceder a los datos de la solicitud, pedirá el servicio identificado como 'request' en el contenedor. El contenedor a su vez devolverá una instancia del servicio requerido. Un desarrollador puede eventualmente reemplazar un componente cuando lo necesite.

Cada uno de los métodos (demostrados en los ejemplos anteriores) utilizados para el sistema el registro de un servicio tienen ventajas y desventajas. Es el desarrollador y los requisitos particulares que se designan cual debe ser utilizado.

Establecer un servicio por una cadena de texto es simple, pero carece de flexibilidad. La configuración de servicios mediante una matriz ofrece mucho más flexibilidad, pero hace al código más complicado. La función lambda es un buen equilibrio entre ambos, pero podría conducir a más mantenimiento del que uno esperaría.

[Phalcon\Di](api/Phalcon_Di) offers lazy loading for every service it stores. A menos que el desarrollador decida instanciar un objeto directamente y guardarlo en el contenedor, cualquier objeto almacenado en él (a través de array, cadena, etc.) será con carga perezosa, es decir, instanciado sólo cuando se solicite.

<a name='loading-from-yaml'></a>

### Cargando servicios desde archivos YAML

Esta característica le permitirá establecer sus servicios en archivos `yaml` o en simples archivos php. Por ejemplo puede cargar servicios usando un archivo `yaml`:

```yaml
config:
  className: \Phalcon\Config
  shared: true
```

```php
<?php

use Phalcon\Di;

$di = new Di();
$di->loadFromYaml('services.yml');
$di->get('config'); // Se obtendrá el servicio config
```

<div class="alert alert-danger">
    <p>
        This approach requires that the module Yaml be installed. Please refer to <a href="https://php.net/manual/book.yaml.php">this</a> for more information.
    </p>
</div>

<a name='resolving-services'></a>

## Resolviendo servicios

Obtener un servicio del contenedor es una cuestión sencilla, simplemente llamando al método `get()`, se devuelve una nueva instancia del servicio:

```php
$request = $di->get('request');
```

O llamando a través del método mágico:

```php
$request = $di->getRequest();
```

O usando la sintaxis de matriz de acceso:

```php
$request = $di['request'];
```

Se pueden pasar argumentos al constructor mediante la adición de un parámetro de matriz al método `get()`:

```php
<?php

// new MyComponent('some-parameter', 'other')
$component = $di->get(
    'MyComponent',
    [
        'some-parameter',
        'other',
    ]
);
```

<a name='envents'></a>

### Eventos

[Phalcon\Di](api/Phalcon_Di) is able to send events to an [EventsManager](/4.0/en/events) if it is present. Los eventos son disparados usando el tipo 'di'. Algunos eventos cuando se devuelva `false` podrían detener la operación activa. Son soportados los siguientes eventos:

| Nombre de evento     | Disparado                                                                                                                          | ¿Detiene la operación? | Activa en |
| -------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |:----------------------:|:---------:|
| beforeServiceResolve | Se dispara antes del servicio de resolución. Los oyentes reciben el nombre del servicio y los parámetros pasados a él.             |           No           |  Oyentes  |
| afterServiceResolve  | Se activa después del servicio de resolución. Los oyentes reciben el nombre de servicio, instancia, y los parámetros pasados a él. |           No           |  Oyentes  |

<a name='shared-services'></a>

## Servicios compartidos

Services can be registered as 'shared' services this means that they always will act as [singletons](https://en.wikipedia.org/wiki/Singleton_pattern). Una vez que el servicio se resuelve por primera vez, la misma instancia del mismo, se devuelve cada vez que un consumidor solicita el servicio del contenedor:

```php
<?php

use Phalcon\Session\Adapter\Files as SessionFiles;

// Registrar el servicio de sesión como 'siempre compartido'
$di->setShared(
    'session',
    function () {
        $session = new SessionFiles();

        $session->start();

        return $session;
    }
);

// Obtenemos el servicio por primera vez
$session = $di->get('session');

// Retorna el primer objecto instanciado
$session = $di->getSession();
```

Una forma alternativa para registrar servicios compartidos, es pasar el valor `true` como tercer parámetro del método `set()`:

```php
<?php

// Registrar el servicio de sesión como 'siempre compartido'
$di->set(
    'session',
    function () {
        // ...
    },
    true
);
```

Si un servicio no está registrado como compartido y usted quiere estar seguro de que una instancia compartida se accederá cada vez que el servicio se obtiene desde el DI, se puede utilizar el método `getShared()`:

```php
$request = $di->getShared('request');
```

<a name='manipulating-services-individually'></a>

## Manipulación Individual de Servicios

Una vez que un servicio está registrado en el contenedor de servicios, se puede acceder para manipularlo individualmente:

```php
    <?php

    use Phalcon\Http\Request;

    // Registrar el servicio 'request'
    $di->set('request', 'Phalcon\Http\Request');

    // Obtener el servicio
    $requestService = $di->getService('request');

    // Cambiar la definición
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

    // Compartir el servicio
    $requestService->setShared(true);

    // Resolver el servicio(retorna una instancia de Phalcon\Http\Request)
    $request = $requestService->resolve();
```

<a name='instantiating-classes-service-container'></a>

## Instanciando clases a través del Contenedor de Servicios

Cuando usted solicita un servicio al contenedor de servicios, si no se puede encontrar un servicio con el mismo nombre, se intentará cargar una clase con el mismo nombre. Con este comportamiento podemos reemplazar cualquier clase por otra, simplemente registrándo un servicio con su nombre:

```php
<?php

// Registrar un controlador como un servicio
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    },
    true
);

// Registrar un controlador como un servicio
$di->set(
    'MyOtherComponent',
    function () {
        // Actualmente retorna otro componente
        $component = new AnotherComponent();

        return $component;
    }
);

// Crear una instancia a través del contenedor de servicios
$myComponent = $di->get('MyOtherComponent');
```

Usted puede tomar ventaja de esto, siempre instanciando sus clases mediante el contenedor de servicio (incluso si no están registradas como servicios). Finalmente el DI recurrirá a un autocargador válido para cargar la clase. Haciendo esto, puede substituir fácilmente cualquier clase en el futuro mediante la aplicación de una definición para ella.

<a name='automatic-injecting-di-itself'></a>

## Auto inyección del DI

If a class or component requires the DI itself to locate services, the DI can automatically inject itself to the instances it creates, to do this, you need to implement the [Phalcon\Di\InjectionAwareInterface](api/Phalcon_Di_InjectionAwareInterface) in your classes:

```php
<?php

use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

class MyClass implements InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $di;


    public function setDi(DiInterface $di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }
}
```

Entonces una vez que el servicio es resuelto, el `$di` se pasará a `setDi()` automáticamente:

```php
<?php

// Registrar el servicio
$di->set('myClass', 'MyClass');

// Resolver el servicio (NOTA: $myClass->setDi($di) es llamado automáticamente)
$myClass = $di->get('myClass');
```

<a name='organizing-services-files'></a>

## Organizando Servicios en Archivos

Puede organizar mejor su aplicación moviendo el registro de servicios a archivo individuales, en lugar de hacer todo en el arranque de la aplicación:

```php
<?php

$di->set(
    'router',
    function () {
        return include '../app/config/routes.php';
    }
);
```

Entonces en el archivo (`'../app/config/routes.php'`) devolvera el objeto resuelto:

```php
<?php

$router = new MyRouter();

$router->post('/login');

return $router;
```

<a name='accessing-di-static-way'></a>

## Accediendo al DI en forma estática

Si es necesario, puede acceder a la última DI creada en una función estática de la siguiente manera:

```php
<?php

use Phalcon\Di;

class SomeComponent
{
    public static function someMethod()
    {
        // Obtener el servicio de sesión
        $session = Di::getDefault()->getSession();
    }
}
```

<a name='service-providers'></a>

## Proveedores de Servicio

Utilizando el `ServiceProviderInterface` puede registrar servicios por contexto. Puede mover todas sus llamadas `$di->set()` a clases como esta:

```php
<?php

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Di;
use Phalcon\Config\Adapter\Ini;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->set(
            'config', 
            function () {
                return new Ini('config.ini');
            }
        );
    }
}

$di = new Di();
$di->register(new SomeServiceProvider());
var_dump($di->get('config')); // Retornará nuestro config
```

<a name='factory-default-di'></a>

## Factory por defecto de DI

Aunque el carácter desacoplado de Phalcon nos ofrece gran libertad y flexibilidad, quizás simplemente queremos utilizarlo como un framework completo. To achieve this, the framework provides a variant of [Phalcon\Di](api/Phalcon_Di) called [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault). Esta clase automáticamente registra los servicios adecuados con el framework para actuar como full-stack.

```php
<?php

use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();
```

<a name='service-name-conventions'></a>

## Convenciones de nombres de servicios

Aunque puede registrar servicios con los nombres que desee, Phalcon tiene unas cuantas convenciones de nomenclatura que permitan que se la el servicio correcto (pre integrados) cuando lo necesite.

| Nombre del servicio | Descripción                                           | Predeterminado                                                                         | Compartido |
| ------------------- | ----------------------------------------------------- | -------------------------------------------------------------------------------------- |:----------:|
| assets              | Gestión de Activos (Assets)                           | [Phalcon\Assets\Manager](api/Phalcon_Assets_Manager)                                 |     Si     |
| annotations         | Analizador de anotaciones                             | [Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory)        |     Si     |
| cookies             | Servicio de gestión de Cookies HTTP                   | [Phalcon\Http\Response\Cookies](api/Phalcon_Http_Response_Cookies)                  |     Si     |
| crypt               | Encriptar/Desencriptar datos                          | [Phalcon\Crypt](api/Phalcon_Crypt)                                                    |     Si     |
| db                  | Servicio de conexión de base de datos de bajo nivel   | [Phalcon\Db](api/Phalcon_Db)                                                          |     Si     |
| dispatcher          | Servicio de despacho de controladores                 | [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher)                                 |     Si     |
| eventsManager       | Servicio de gestión de eventos                        | [Phalcon\Events\Manager](api/Phalcon_Events_Manager)                                 |     Si     |
| escaper             | Escapado contextual                                   | [Phalcon\Escaper](api/Phalcon_Escaper)                                                |     Si     |
| flash               | Servicio de mensajería Flash                          | [Phalcon\Flash\Direct](api/Phalcon_Flash_Direct)                                     |     Si     |
| flashSession        | Servicio de mensajería Flash en sesión                | [Phalcon\Flash\Session](api/Phalcon_Flash_Session)                                   |     Si     |
| filter              | Servicio de filtrado de entrada                       | [Phalcon\Filter](api/Phalcon_Filter)                                                  |     Si     |
| modelsCache         | Cache de modelos para cacheos en Backend              | Nada                                                                                   |     No     |
| modelsManager       | Servicio de gestión de modelos                        | [Phalcon\Mvc\Model\Manager](api/Phalcon_Mvc_Model_Manager)                          |     Si     |
| modelsMetadata      | Servicio de metadatos de modelos                      | [Phalcon\Mvc\Model\MetaData\Memory](api/Phalcon_Mvc_Model_MetaData_Memory)         |     Si     |
| request             | Servicio de entorno de solicitud HTTP                 | [Phalcon\Http\Request](api/Phalcon_Http_Request)                                     |     Si     |
| response            | Servicio de entorno de respuesta HTTP                 | [Phalcon\Http\Response](api/Phalcon_Http_Response)                                   |     Si     |
| router              | Servicio de enrutamiento                              | [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router)                                         |     Si     |
| security            | Ayudantes de seguridad                                | [Phalcon\Security](api/Phalcon_Security)                                              |     Si     |
| session             | Servicio de sesión                                    | [Phalcon\Session\Adapter\Files](api/Phalcon_Session_Adapter_Files)                  |     Si     |
| sessionBag          | Servicio de bolsa de sesión                           | [Phalcon\Session\Bag](api/Phalcon_Session_Bag)                                       |     Si     |
| tag                 | Ayudantes de generación de HTML                       | [Phalcon\Tag](api/Phalcon_Tag)                                                        |     Si     |
| transactionManager  | Servicio de administrador de transacciones de modelos | [Phalcon\Mvc\Model\Transaction\Manager](api/Phalcon_Mvc_Model_Transaction_Manager) |     Si     |
| url                 | Servicio de generador de URL                          | [Phalcon\Mvc\Url](api/Phalcon_Mvc_Url)                                               |     Si     |
| viewsCache          | Backend de cache para cache de fragmentos de vista    | Nada                                                                                   |     No     |

<a name='implementing-your-own-di'></a>

## Implementando tu propio DI

The [Phalcon\DiInterface](api/Phalcon_DiInterface) interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one.