<div class='article-menu'>
  <ul>
    <li>
      <a href="#di-service-location">Inyector de Dependencias / Localización de Servicios</a> <ul>
        <li>
          <a href="#di-explained">DI explicado</a>
        </li>
        <li>
          <a href="#registering-services">Registrar servicios en el contenedor</a> <ul>
            <li>
              <a href="#simple-registration">Registro simple</a> <ul>
                <li>
                  <a href="#simple-registration-string">Cadena de caracteres (string)</a>
                </li>
                <li>
                  <a href="#class-instances">Instancias de clase</a>
                </li>
                <li>
                  <a href="#closures-anonymous-functions">Closures/Funciones anónimas</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#complex-registration">Registro Complejo</a> <ul>
                <li>
                  <a href="#constructor-injection">Inyección de Contructores</a>
                </li>
                <li>
                  <a href="#setter-injection">Inyección de Configuraciones</a>
                </li>
                <li>
                  <a href="#properties-injection">Inyección de Propiedades</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#array-syntax">Sintaxis de array</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#resolving-services">Resolviendo servicios</a> <ul>
            <li>
              <a href="#events">Eventos</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#shared-services">Servicios compartidos</a>
        </li>
        <li>
          <a href="#manipulating-services-individually">Manipulación Individual de Servicios</a>
        </li>
        <li>
          <a href="#instantiating-classes-service-container">Instanciando clases a través del Contenedor de Servicios</a>
        </li>
        <li>
          <a href="#automatic-injecting-di-itself">Auto inyección del DI</a>
        </li>
        <li>
          <a href="#organizing-services-files">Organizando Servicios en Archivos</a>
        </li>
        <li>
          <a href="#accessing-di-static-way">Accediendo al DI en forma estática</a>
        </li>
        <li>
          <a href="#factory-default-di">Factory por defecto de DI</a>
        </li>
        <li>
          <a href="#service-name-conventions">Convenciones de nombres de servicios</a>
        </li>
        <li>
          <a href="#implementing-your-own-di">Implementando tu propio DI</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

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

`Phalcon\Di` es un componente que implementa la Inyección de Dependencias y Localización de Servicios y es en sí mismo un contenedor para ellos.

Puesto que Phalcon es altamente desacoplado, `Phalcon\Di` es esencial para integrar los distintos componentes del framework. El desarrollador también puede utilizar este componente para inyectar dependencias y administrar instancias globales de las diferentes clases que se utilizan en la aplicación.

Básicamente, este componente implementa el patrón de [Inversión de Control](http://en.wikipedia.org/wiki/Inversion_of_control). Aplicando esto, los objetos no reciben sus dependencias usando configuradores o constructores, sino solicitando un servicios de inyección de dependencias. Esto reduce la complejidad total, puesto que hay solamente una manera de conseguir las dependencias necesarias dentro de un componente.

Además, este patrón aumenta la posibilidad de pruebas con el código, por lo que es menos propenso a errores.

<a name='registering-services'></a>

## Registrando Servicios en el Contenedor

El framework mismo o el desarrollador pueden registrar servicios. Cuando un componente A requiere del componente B (o una instancia de su clase) para funcionar, puede solicitar el componente B desde el contenedor, en lugar de crear un nuevo componente de la instancia B.

Esta forma de trabajar nos da muchas ventajas:

- Podemos fácilmente reemplazar un componente con uno creado por nosotros mismos o por un tercero.
- Tenemos control total de la inicialización del objeto, lo que nos permite definir estos objetos según sea necesario antes de entregarlos a los componentes.
- Podemos obtener instancias globales de los componentes en forma estructurada y unificada.

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

El servicio 'response' (`Phalcon\Http\Response`) se resuelve para pasar como el primer argumento del constructor, mientras que el segundo es un valor booleano (verdadero) que se pasa como tal.

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

`Phalcon\Di` ofrece la carga perezosa para cada servicio que se almacena. A menos que el desarrollador decida instanciar un objeto directamente y guardarlo en el contenedor, cualquier objeto almacenado en él (a través de array, cadena, etc.) será con carga perezosa, es decir, instanciado sólo cuando se solicite.

<a name='resolving-services'></a>

## Resolviendo Servicios

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

`Phalcon\Di` es capaz de enviar eventos al `EventsManager` si está presente. Los eventos son disparados usando el tipo 'di'. Si algún evento devuelve `false` podría detener la operación activa. Son soportados los siguientes eventos:

| Nombre de Evento     | Activador                                                                                                                          | ¿Puede detener la operación? | Activa en |
| -------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |:----------------------------:|:---------:|
| beforeServiceResolve | Se dispara antes del servicio de resolución. Los oyentes reciben el nombre del servicio y los parámetros pasados a él.             |              No              |  Oyentes  |
| afterServiceResolve  | Se activa después del servicio de resolución. Los oyentes reciben el nombre de servicio, instancia, y los parámetros pasados a él. |              No              |  Oyentes  |

<a name='shared-services'></a>

## Servicios Compartidos

Los servicios pueden ser registrados como servicios 'compartidos' esto significa que siempre actuarán como [singletons](http://en.wikipedia.org/wiki/Singleton_pattern). Una vez que el servicio se resuelve por primera vez, la misma instancia del mismo, se devuelve cada vez que un consumidor solicita el servicio del contenedor:

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

## Manipulación individual de servicios

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

Si una clase o componente requiere el DI en sí mismo para localizar servicios, el DI se puede inyectar automáticamente a las instancias que crean, para ello, deberá implementar la interfaz `Phalcon\Di\InjectionAwareInterface` en sus clases:

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

<a name='factory-default-di'></a>

## Factory por defecto de DI

Aunque el carácter desacoplado de Phalcon nos ofrece gran libertad y flexibilidad, quizás simplemente queremos utilizarlo como un framework completo. Para lograr esto, el framework ofrece una variante de `Phalcon\Di` llamada `Phalcon\Di\FactoryDefault`. Esta clase automáticamente registra los servicios adecuados con el framework para actuar como full-stack.

```php
<?php

use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();
```

<a name='service-name-conventions'></a>

## Convenciones de nombres de servicios

Aunque puede registrar servicios con los nombres que desee, Phalcon tiene unas cuantas convenciones de nomenclatura que permitan que se la el servicio correcto (pre integrados) cuando lo necesite.

| Nombre del servicio | Descripción                                           | Por defecto                                 | Compartido |
| ------------------- | ----------------------------------------------------- | ------------------------------------------- |:----------:|
| assets              | Gestión de Activos (Assets)                           | `Phalcon\Assets\Manager`                  |     Sí     |
| annotations         | Analizador de anotaciones                             | `Phalcon\Annotations\Adapter\Memory`     |     Sí     |
| cookies             | Servicio de gestión de Cookies HTTP                   | `Phalcon\Http\Response\Cookies`          |     Sí     |
| crypt               | Encriptar/Desencriptar datos                          | `Phalcon\Crypt`                            |     Sí     |
| db                  | Servicio de conexión de base de datos de bajo nivel   | `Phalcon\Db`                               |     Sí     |
| dispatcher          | Servicio de despacho de controladores                 | `Phalcon\Mvc\Dispatcher`                  |     Sí     |
| eventsManager       | Servicio de gestión de eventos                        | `Phalcon\Events\Manager`                  |     Sí     |
| escaper             | Escapado contextual                                   | `Phalcon\Escaper`                          |     Sí     |
| flash               | Servicio de mensajería Flash                          | `Phalcon\Flash\Direct`                    |     Sí     |
| flashSession        | Servicio de mensajería Flash en sesión                | `Phalcon\Flash\Session`                   |     Sí     |
| filter              | Servicio de filtrado de entrada                       | `Phalcon\Filter`                           |     Sí     |
| modelsCache         | Cache de modelos para cacheos en Backend              | Nada                                        |     No     |
| modelsManager       | Servicio de gestión de modelos                        | `Phalcon\Mvc\Model\Manager`              |     Sí     |
| modelsMetadata      | Servicio de metadatos de modelos                      | `Phalcon\Mvc\Model\MetaData\Memory`     |     Sí     |
| request             | Servicio de entorno de solicitud HTTP                 | `Phalcon\Http\Request`                    |     Sí     |
| response            | Servicio de entorno de respuesta HTTP                 | `Phalcon\Http\Response`                   |     Sí     |
| router              | Servicio de enrutamiento                              | `Phalcon\Mvc\Router`                      |     Sí     |
| security            | Ayudantes de seguridad                                | `Phalcon\Security`                         |     Sí     |
| session             | Servicio de sesión                                    | `Phalcon\Session\Adapter\Files`          |     Sí     |
| sessionBag          | Servicio de bolsa de sesión                           | `Phalcon\Session\Bag`                     |     Sí     |
| tag                 | Ayudantes de generación de HTML                       | `Phalcon\Tag`                              |     Sí     |
| transactionManager  | Servicio de administrador de transacciones de modelos | `Phalcon\Mvc\Model\Transaction\Manager` |     Sí     |
| url                 | Servicio de generador de URL                          | `Phalcon\Mvc\Url`                         |     Sí     |
| viewsCache          | Backend de cache para cache de fragmentos de vista    | Nada                                        |     No     |

<a name='implementing-your-own-di'></a>

## Implementando tu propio DI

La interfaz `Phalcon\DiInterface` debe aplicarse para crear su propio DI y reemplazar uno proporcionado por Phalcon o extender uno actual.