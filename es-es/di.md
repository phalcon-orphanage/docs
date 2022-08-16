---
layout: default
language: 'es-es'
version: '5.0'
title: 'Inyector de Dependencias / Localizador de Servicios'
keywords: 'inyección de dependencias, di, ioc, localizador servicios'
---

# Inyector de Dependencias / Localizador de Servicios
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Di\Di][di] is a container that stores services or components (classes). Estos servicios están disponibles desde la aplicación y facilitan el desarrollo. Supongamos que estamos desarrollando un componente llamado `InvoiceComponent` que realiza algunos cálculos para la factura de un cliente. Requiere una conexión de base de datos para obtener el registro `Invoice` desde la base de datos.

Nuestro componente se puede implementar de la siguiente manera:

```php
<?php

use Phalcon\Db\Adapter\Mysql;

class InvoiceComponent
{
    public function calculate()
    {
        $connection = new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );

        $invoice = $connection->exec(
            'SELECT * FROM Invoices WHERE inv_id = 1'
        );

        // ...
    }
}

$invoice = new InvoiceComponent();
$invoice->calculate();
```

Usamos el método `calculate` para obtener nuestros datos. Dentro del método, creamos una nueva conexión de base de datos a MySQL con las credenciales y después ejecutamos la consulta. Aunque esta es una implementación perfectamente válida, no es práctica y dificultará el mantenimiento de nuestra aplicación tarde o temprano, debido al hecho de que nuestros parámetros de conexión o el tipo de base de datos están codificados en el propio componente. Si en el futuro necesitamos cambiarlos, tendremos que cambiarlos en este componente y cualquier otro componente diseñado de esta manera.

```php
<?php

use Phalcon\Db\Adapter\Mysql;

class InvoiceComponent
{
    private $connection;

    public function calculate()
    {
        $invoice = $this
            ->connection
            ->exec(
                'SELECT * FROM Invoices WHERE inv_id = 1'
            )
        ;

        // ...
    }

    public function setConnection(
        Mysql $connection
    ): InvoiceComponent {
        $this->connection = $connection;

        return $this;
    }
}

$connection = new Mysql(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'tutorial',
    ]
);

$invoice = new InvoiceComponent();
$invoice
    ->setConnection($connection)
    ->calculate()
;
```

Para mejorar la flexibilidad, podríamos crear la conexión a la base de datos fuera del componente, y pasarla a `InvoiceComponent` usando un *setter*. Using this approach, we can _inject_ the database connection to any component that requires it, using the setter. Again this is a perfectly valid implementation, but it does have some shortcomings. Por ejemplo, necesitaremos construir la conexión a la base de datos cada vez que necesitemos usar cualquiera de nuestros componentes que requieran conectividad con la base de datos.

Para centralizar esta funcionalidad, podemos implementar una patrón de registro global y almacenar ahí el objeto de la conexión. Después podemos reutilizarlo donde lo necesitemos.

```php
<?php

use Phalcon\Db\Adapter\Mysql;

class Registry
{
    public static function getConnection(): Mysql
    {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
}

class InvoiceComponent
{
    private $connection;

    public function calculate()
    {
        $invoice = $this
            ->connection
            ->exec(
                'SELECT * FROM Invoices WHERE inv_id = 1'
            )
        ;

        // ...
    }

    public function setConnection(
        Mysql $connection
    ): InvoiceComponent {
        $this->connection = $connection;

        return $this;
    }
}

$invoice = new InvoiceComponent();
$invoice
    ->setConnection(Registry::getConnection())
    ->calculate()
;
```

La implementación anterior creará una nueva conexión cada vez que llamemos a `getConnection` del componente `Registry`. Para abordar este problema, podemos modificar nuestra clase `Registry` para almacenar la conexión con la base de datos y reutilizarla.

```php
<?php

use Phalcon\Db\Adapter\Mysql;

class Registry
{
    protected static $connection;

    public static function getNewConnection(): Mysql
    {
        return self::createConnection();
    }

    public static function getSharedConnection(): Mysql
    {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    protected static function createConnection(): Mysql
    {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tuturial',
            ]
        );
    }
}


class InvoiceComponent
{
    private $connection;

    public function calculate()
    {
        $invoice = $this
            ->connection
            ->exec(
                'SELECT * FROM Invoices WHERE inv_id = 1'
            )
        ;

        // ...
    }

    public function setConnection(
        Mysql $connection
    ): InvoiceComponent {
        $this->connection = $connection;

        return $this;
    }
}

$invoice = new InvoiceComponent();
$invoice
    ->setConnection(Registry::getSharedConnection())
    ->calculate()
;

$invoice = new InvoiceComponent();
$invoice
    ->setConnection(Registry::getNewConnection())
    ->calculate()
;
```

In the above example we changed the `Registry` class, exposing `getNewConnection` which creates a brand-new database connection. También expone `getSharedConnection` que almacenará la conexión internamente y la reutilizará para cualquier otro componente que la requiera.

Inyectar dependencias a nuestros componentes soluciona los problemas descritos anteriormente. Pasar dependientes como argumento en vez de crearlas internamente en los métodos hace nuestro código más mantenible y desacoplado. Sin embargo, a largo plazo, esta forma de inyección de dependencias tiene algunas desventajas. Si por ejemplo el componente tiene muchas dependencias, necesitaremos crear múltiples argumentos *setter* para pasar las dependencias o crear un constructor que se usará para pasar todas las dependencias requeridas como argumentos. También necesitaríamos crear esas dependencias antes de usar el componente. Esto hace que nuestro código no sea tan mantenible como nos gustaría:

```php
<?php

$connection = new Connection();
$fileSystem = new FileSystem();
$filter     = new Filter();
$selector   = new Selector();
$session    = new Session();

$invoice =  new InvoiceComponent(
    $connection, 
    $session, 
    $fileSystem, 
    $filter, 
    $selector
);

$invoice
    ->setConnection($connection)
    ->setFileSystem($fileSystem)
    ->setFilter($filter)
    ->setSelector($selector)
    ->setSession($session)
;
```

El problema de la mantenibilidad sigue estando. Si tenemos que crear este objeto en muchas partes de la aplicación, necesitamos realizar la misma inicialización, inyectando todas las dependencias. Si en el futuro necesitamos cambiar cualquiera de nuestros componentes para añadir nuevas dependencias tenemos que recorrer todas los sitios donde hayamos usado este componente u otros para ajustar nuestro código. Para solventar este problema, usaremos la clase de registro global para crear el componente. Sin embargo, este enfoque añade una capa más de abstracción antes de crear el objeto:

```php
<?php

class InvoiceComponent
{
    private $connection;
    private $fileSystem;
    private $filter;
    private $selector;
    private $session;

    public function __construct(
        Connection $connection,
        FileSystem $fileSystem,
        Filter $filter,
        Selector $selector,
        Session $session

    ) {
        $this->connection = $connection;
        $this->fileSystem = $fileSystem;
        $this->filter     = $filter;
        $this->selector   = $selector;
        $this->session    = $session;
    }

    public static function factory()
    {
        $connection = new Connection();
        $fileSystem = new FileSystem();
        $filter     = new Filter();
        $selector   = new Selector();
        $session    = new Session();

        return new self(
            $connection, 
            $fileSystem, 
            $filter, 
            $selector,
            $session 
        );
    }
}
```

Ahora volvemos donde empezamos, instanciando las dependencias dentro del componente. Para solucionar este problema usaremos un contenedor que pueda almacenar todas nuestras dependencias. Es una forma práctica y elegante. El contenedor actuará como el registro global que investigamos anteriormente. Usando este contenedor como puente para recuperar cualquier dependencia, nos permite reducir la complejidad de nuestro componente:

```php
<?php

use Phalcon\Db\Adapter\Mysql;
use Phalcon\Di\Di;
use Phalcon\Di\DiInterface;

class InvoiceComponent
{
    protected $container;

    public function __construct(
        DiInterface $container
    ) {
        $this->container = $container;
    }

    public function calculate()
    {
        $connection = $this
            ->container
            ->get('db')
        ;
    }

    public function view($id)
    {
        $filter = $this
            ->container
            ->get('filter')
        ;

        $id = $filter->sanitize($id, null, 'int');

        $connection = $this
            ->container
            ->getShared('db')
        ;
    }
}

$container = new Di();
$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);

$container->set(
    'filter',
    function () {
        return new Filter();
    }
);

$container->set(
    'session',
    function () {
        return new Session();
    }
);

$invoice =  new InvoiceComponent($container);
$invoice->calculate();
```

El componente ahora puede simplemente acceder a las dependencias cuando las necesite, si lo requiere. Si una dependencia no se necesita, no será inicializada asegurando un mínimo uso de memoria. Ahora nuestro componente es altamente desacoplado. Por ejemplo, si cambiamos la conexión con la base de datos de alguna manera, no afectará al componente, en lo que se refiere al mantenimiento, sólo necesitamos cambiar el código en un lugar.

[Phalcon\Di\Di][di] is a component implementing Dependency Injection and a Service Locator. Since Phalcon is highly decoupled, [Phalcon\Di\Di][di] is essential to integrate the different components of the framework. El desarrollador puede usar también este componente para inyectar dependencias y gestionar instancias globales de las diferentes clases usadas en la aplicación. It also implements the [Inversion of Control][ioc] pattern. Debido a esto, los objetos no reciben sus dependencias usando *setters* o constructores, sino solicitando un inyector de dependencias de servicio. Esto reduce la complejidad general, ya que sólo hay una manera de obtener las dependencias requeridas desde un componente.

Además, este patrón incrementa la testabilidad en el código, ya que lo hace menos propenso a errores.

## Métodos

```php
public function __call(
    string $method, 
    array $arguments = []
): mixed | null
```
Método mágico para obtener o establecer servicios usando *setters*/*getters*

```php
public function attempt(
    string $name, 
    mixed definition, 
    bool shared = false
): ServiceInterface | bool
```
Attempts to register a service in the services' container. Sólo será correcto si no ha sido registrado previamente ningún servicio con el mismo nombre

```php
public function get(
    string $name, 
    mixed parameters = null
): mixed
```
Resuelve el servicio según su configuración

```php
public static function getDefault(): DiInterface | null
```
Devuelve el último DI creado

```php
public function getInternalEventsManager(): ManagerInterface
```
Devuelve el Gestor de Eventos interno

```php
public function getRaw(string $name): mixed
```
Devuelve una definición de servicio sin resolver

```php
public function getService(string $name): ServiceInterface
```
Devuelve una instancia `Phalcon\Di\Service`

```php
public function getServices(): ServiceInterface[]
```
Devuelve los servicios registrados en el DI

```php
public function getShared( 
    string $name, 
    mixed parameters = null
): mixed
```
Devuelve un servicio compartido. El servicio primero se resuelve, luego el servicio resuelto se almacena en el DI. Las siguientes peticiones de este servicio devolverán la misma instancia

```php
public function loadFromPhp(string $filePath)
```
Load services from a php config file.

```php
// /app/config/services.php
return [
     'myComponent' => [
         'className' => '\Acme\Components\MyComponent',
         'shared'    => true,
     ],
     'group'       => [
         'className' => '\Acme\Group',
         'arguments' => [
             [
                 'type'    => 'service',
                 'service' => 'myComponent',
             ],
         ],
     ],
     'user'        => [
         'className' => '\Acme\User',
     ],
];

$container->loadFromPhp("/app/config/services.php");
```


```php
public function loadFromYaml(
    string $filePath, 
    array $callbacks = null
)
```
Load services from a yaml file.

```php
// /app/config/services.yml
myComponent:
    className: \Acme\Components\MyComponent
    shared: true

group:
    className: \Acme\Group
    arguments:
        - type: service
          name: myComponent

user:
   className: \Acme\User


$container->loadFromYaml(
    "/app/config/services.yaml",
    [
        "!approot" => function ($value) {
            return dirname(__DIR__) . $value;
        }
    ]
);
```

```php
public function has(string $name): bool
```
Comprueba si el DI contiene un servicio por un nombre

```php
public function offsetGet(mixed $name): mixed
```
Obtiene un servicio compartido usando la sintaxis vector

```php
var_dump($container["request"]);
```

```php
public function offsetExists(mixed $name): bool
```
Comprueba si un servicio está registrando usando la sintaxis vector

```php
public function offsetSet(mixed $name, mixed $definition)
```
Permite registrar un servicio compartido usando la sintaxis vector

```php
$container["request"] = new \Phalcon\Http\Request();
```

```php
public function offsetUnset(mixed $name)
```
Elimina un servicio del contenedor de servicios usando la sintaxis vector

```php
public function register(ServiceProviderInterface $provider)
```
Registra un proveedor de servicios.

```php
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $container)
    {
        $container->setShared(
            'service',
            function () {
                // ...
            }
        );
    }
}
```

```php
public function remove(string $name)
```
Removes a service in the services' container. También elimina cualquier instancia compartida creada del servicio

```php
public static function reset()
```
Resetea el *DI* interno predeterminado

```php
public function set(
    string $name, 
    mixed $definition, 
    bool $shared = false
): ServiceInterface
```
Registra un servicio en el contenedor de servicios

```php
public static function setDefault(<DiInterface> container)
* Establece un contenedor de inyección de dependencias por defecto para ser obtenido estáticamente
* métodos
```

```php
public function setInternalEventsManager(
    ManagerInterface $eventsManager
)
```
Establece el gestor de eventos interno

```php
public function setService(
    string $name, 
    ServiceInterface $rawDefinition
): ServiceInterface
```
Establece un servicio usando una definición `Phalcon\Di\Service` sin procesar

```php
public function setShared(
    string $name, 
    mixed $definition
): ServiceInterface
```
Registers an _always shared_ service in the services container

## Registro de Servicios
El propio *framework* o el desarrollador puede registrar servicios. Cuando un componente A requiere un componente B (o una instancia de su clase) para operar, puede solicitar el componente B desde el contenedor, en lugar de crear una nueva instancia del componente B.

This approach offers the following advantages:
* We can easily replace a component with one created by ourselves or a third party.
* We have full control of the object initialization, allowing us to set these objects as needed before delivering them to components.
* We can get global instances of components in a structured and unified way.

Los servicios se pueden registrar usando varios tipos de definiciones. A continuación exploraremos las diferentes formas en las que se pueden registrar los servicios:

### Cadena
This type expects the name of a valid class, returning an object of the specified class, if the class is not loaded it will be instantiated using an autoloader. Este tipo de definición no permite especificar argumentos para el constructor de la clase o parámetros:

```php
<?php

use Phalcon\Http\Request;

$container->set(
    'request',
    Request::class
);
```

### Instancias de Clase
Este tipo espera un objeto. Debido al hecho de que el objeto no necesita ser resuelto ya que ya es un objeto, podríamos decir que no es realmente una inyección de dependencias, sin embargo es útil si quiere forzar la dependencia devuelta para que siempre sea el mismo objeto/valor:

```php
<?php

use Phalcon\Http\Request;

$container->set(
    'request',
    new Request()
);
```

### Funciones Anónimas
This method offers greater freedom to build the dependency as desired, however, it is difficult to change some parameters externally without having to completely change the definition of dependency:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);
```

Some limitations can be overcome by passing additional variables to the closure's environment:

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;

$config = new Config(
    [
        'host'     => 'localhost',
        'username' => 'user',
        'password' => 'pass',
        'dbname'   => 'tutorial',
    ]
);

$container->set(
    'db',
    function () use ($config) {
        return new Mysql(
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

También puede acceder a otros servicios del *DI* usando el método `get()`:

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;

$container->set(
    'config',
    function () {
        return new Config(
            [
                'host'     => 'localhost',
                'username' => 'user',
                'password' => 'pass',
                'dbname'   => 'tutorial',
            ]
        );
    }
);

$container->set(
    'db',
    function () {
        $config = $this->get('config');

        return new Mysql(
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

> NOTE: `$this` can be used inside a closure 
> 
> {: .alert .alert-info }

### Registro Complejo
Si es necesario cambiar la definición de un servicio sin instanciar/resolver el servicio, entonces, necesitamos definir los servicios usando la sintaxis de vector. Definir un servicio usando la definición de vector puede ser un poco más detallado:

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$container->set(
    'annotations',
    [
        'className' => Apcu::class,
        'arguments' => [
            [
                'type'  => 'parameter',
                'name'  => 'prefix',
                'value' => 'my-prefix',
            ],
            [
                'type'  => 'parameter',
                'name'  => 'lifetime',
                'value' => 3600,
            ],
        ],
    ]
);


$container->set(
    'annotations',
    function () {
        return new Apcu(
            [
                'prefix'   => 'my-prefix',
                'lifetime' => 3600,
            ]
        );
    }
);
```

Ambos registros de servicio anteriores producen el mismo resultado. Sin embargo, la definición de vector permite cambiar los parámetros del servicio si se necesita:

```php
<?php

use Phalcon\Annotations\Adapter\Memory;

$container
    ->getService('annotations')
    ->setClassName(Memory::class)
;

$container
    ->getService('annotations')
    ->setParameter(
        1,
        [
            'type'  => 'parameter',
            'name'  => 'lifetime',
            'value' => 7200,
        ]
    );
```

### Inyecciones
In addition, by using the array syntax you can use three types of dependency injection:

#### Inyección de Constructor
Este tipo de inyección pasa las dependencias/argumentos a la clase constructor. Supongamos que tenemos el siguiente componente:

```php
<?php

namespace MyApp\Http;

use Phalcon\Http\Response;

class Responder
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $contentType;

    public function __construct(Response $response, string $contentType)
    {
        $this->response    = $response;
        $this->contentType = $contentType;
    }
}
```

El servicio se puede registrar de la siguiente manera:

```php
<?php

use MyApp\Http\Responder;
use Phalcon\Http\Response;

$container->set(
    'response',
    [
        'className' => Response::class
    ]
);

$container->set(
    'my-responder',
    [
        'className' => Responder::class,
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'response',
            ],
            [
                'type'  => 'parameter',
                'value' => 'application/json',
            ],
        ]
    ]
);
```

El servicio `response` ([Phalcon\Http\Response](response) se resuelve para pasarlo como primer argumento del constructor, mientras que el segundo es un valor `string` que se pasa tal cual.

#### Inyección de *Setters*
Las clases pueden tener *setters* para inyectar dependencias opcionales, nuestra clase previa se puede cambiar para aceptar las dependencias con *setters*:

```php
<?php

namespace MyApp\Http;

use Phalcon\Http\Response;

class Responder
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $contentType;

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }
}
```

La clase anterior se puede registrar como un servicio usando el *getter* y *setter*:

```php
<?php

use MyApp\Http\Responder;
use Phalcon\Http\Response;

$container->set(
    'response',
    [
        'className' => Response::class,
    ]
);

$container->set(
    'my-responder',
    [
        'className' => Responder::class,
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
                'method'    => 'setContentType',
                'arguments' => [
                    [
                        'type'  => 'parameter',
                        'value' => 'application/json',
                    ]
                ]
            ]
        ]
    ]
);
```

#### Inyección de Propiedades
Una estrategia menos común es inyectar dependencias o parámetros directamente en atributos públicos de la clase:

```php
<?php

namespace MyApp\Http;

use Phalcon\Http\Response;

class Responder
{
    /**
     * @var Response
     */
    public $response;

    /**
     * @var string
     */
    public $contentType;
}
```

Un servicio con inyección de propiedades se pueden registrar de la siguiente manera:

```php
<?php

use MyApp\Http\Responder;
use Phalcon\Http\Response;

$container->set(
    'response',
    [
        'className' => Response::class,
    ]
);

$container->set(
    'my-responder',
    [
        'className'  => Responder::class,
        'properties' => [
            [
                'name'  => 'response',
                'value' => [
                    'type' => 'service',
                    'name' => 'response',
                ],
            ],
            [
                'name'  => 'contentType',
                'value' => [
                    'type'  => 'parameter',
                    'value' => 'application/json',
                ],
            ]
        ]
    ]
);
```

Los tipos de parámetros soportados incluyen los siguientes:

| Tipo        | Descripción                                              | Ejemplo                                                                                     |
| ----------- | -------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| `instancia` | Representa un objeto que se debe construir dinámicamente | `['type' => 'instance', 'className' => \DateTime::class, 'arguments' => ['now']]` |
| `parámetro` | Representa un valor literal pasado como parámetro        | `['type' => 'parameter', 'value' => 1234]`                                            |
| `servicio`  | Representa otro servicio en el contenedor de servicios   | `['type' => 'service', 'name' => 'request']`                                          |

Resolver un servicio cuya definición es compleja puede ser un poco más lento que las definiciones simples vistas previamente. Sin embargo, proporcionan un enfoque más robusto para definir e inyectar servicios. Se permite mezclar diferentes tipos de definiciones, y puede decidir que forma es la más apropiada para registrar los servicios de acuerdo a las necesidades de la aplicación.

### Sintaxis de Vector
La sintaxis de vector también está disponible para registrar servicios:

```php
<?php

use Phalcon\Di\Di;
use Phalcon\Http\Request;

$container = new Di();

$container['request'] = Request::class;

$container['request'] = function () {
    return new Request();
};

$container['request'] = new Request();

$container['request'] = [
    'className' => Request::class,
];
```

En los ejemplos anteriores, cuando el *framework* necesita acceder a los datos de la petición, preguntará por el servicio identificado como `request` en el contenedor. El contenedor devolverá como respuesta una instancia del servicio solicitado. El componente se puede reemplazar fácilmente con una clase diferente si surge la necesidad.

Como se muestra en los ejemplos anteriores, cada una de las formas usadas para establecer/registrar un servicio tiene ventajas e inconvenientes. El desarrollador y los requisitos particulares son los que determinarán qué opción usar. Establecer un servicio mediante una cadena es simple, pero carece de flexibilidad. Establecer servicios usando un vector ofrece mucha más flexibilidad, pero hace el código más complicado. La función lambda es un buen equilibrio entre los dos, pero podría conducir a un mantenimiento mayor del que uno podría esperar.

> **NOTE**: [Phalcon\Di\Di][di] offers lazy loading for every service it stores. A no ser que el desarrollador decida instanciar un objeto directamente y almacenarlo en el contenedor, cualquier objeto almacenado en él (vía vector, cadena, etc.) se cargará perezosamente, es decir, se instanciará sólo cuando se solicite. 
> 
> {: .alert .alert-info }

### Carga Desde Configuración

**YAML**

Esta característica cargará los servicios analizando un fichero YAML:

```yaml
; /app/config/services.yml
config:
  className: \Phalcon\Config
  shared: true
```

```php
<?php

use Phalcon\Di\Di;

$container = new Di();
$container->loadFromYaml('services.yml');
$container->get('/app/config/services.yml');
```

> **NOTE**: This approach requires that the module Yaml be installed. Please refer to [this document][yaml] for more information. 
> 
> {: .alert .alert-danger }


**PHP**

También puede cargar servicios usando un vector PHP:

```php
// /app/config/services.php

use Phalcon\Config;

return [
    'config' => [
        'className' => Config::class,
        'shared'    => true,
    ],
];
```

```php
<?php

use Phalcon\Di\Di;

$container = new Di();
$container->loadFromPhp('/app/config/services.php');
$container->get('config');
```

## Resolución de Servicios
Obtener un servicio del contenedor es una cuestión de llamar simplemente al método `get`. Se devolverá una nueva instancia del servicio:

```php
$request = $container->get('request');
```

O llamando a través del método mágico:

```php
$request = $container->getRequest();
```

O usando la sintaxis de acceso de vector:

```php
$request = $container['request'];
```

Los argumentos se pueden pasar al constructor añadiendo un vector de parámetros al método `get`:

```php
<?php

use Phalcon\Annotations\Adapter\Stream;

$annotations = $container->get(
    Stream::class,
    [
        ['annotationsDir' => 'storage/cache/annotations'],
    ]
);
```

## Eventos
[Phalcon\Di\Di][di] is able to send events to an [EventsManager](events) if it is present. Los eventos se disparan usando el tipo `di`.

| Nombre de evento       | Disparado                                                                                                                             |
| ---------------------- | ------------------------------------------------------------------------------------------------------------------------------------- |
| `afterServiceResolve`  | Disparado después de resolver el servicio. Los oyentes reciben el nombre del servicio, la instancia y los parámetros que se les pasa. |
| `beforeServiceResolve` | Disparado antes de resolver el servicio. Los oyentes reciben el nombre del servicio y los parámetros que se les pasa.                 |

## Servicios Compartidos
Los servicios se pueden registrar como servicios `compartidos` lo que significa que siempre actuarán como \[singletons\]\[singletons\]. Una vez que el servicio se resuelve por primera vez se devolverá la misma instancia de él cada vez que se recupere este servicio desde el contenedor:

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$container->setShared(
    'session',
    function () {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        $session->start();

        return $session;
    }
);

$session = $container->get('session');

$session = $container->getSession();
```

La primera llamada a `get` en el contenedor resuelve el servicio y devuelve el objeto de vuelta. La llamada posterior a `getSession` devolverá el mismo objeto.

Una forma alternativa de registrar servicios compartidos es pasar `true` como tercer parámetro de `set`:

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$container->set(
    'session',
    function () {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        $session->start();

        return $session;
    },
    true
);

$session = $container->get('session');

$session = $container->getSession();
```

> **NOTE**: If a service is not registered as shared, and you want to ensure that a shared instance will be accessed every time the service is retrieved from the DI, you can use the `getShared` method 
> 
> {: .alert .alert-info }

```php
$request = $container->getShared('request');
```

## Manipulación de Servicios
Una vez que se registra un servicio en el contenedor de servicios, lo puede recuperar para manipularlo individualmente:

```php
    <?php

    use Phalcon\Http\Request;

    // Register the 'request' service
    $container->set('request', 'Phalcon\Http\Request');

    // Get the service
    $requestService = $container->getService('request');

    // Change its definition
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

    // Change it to shared
    $requestService->setShared(true);

    // Resolve the service (return a Phalcon\Http\Request instance)
    $request = $requestService->resolve();
```

## Instanciado de Clases
Cuando solicita un servicio del contenedor, si no se puede encontrar usando el mismo nombre, intentará cargar una clase con el mismo nombre. Este comportamiento le permite reemplazar cualquier servicio por otro, simplemente registrando un servicio con el nombre común:

```php
<?php

$container->set(
    'IndexController',
    function () {
        return new Component();
    },
    true
);

$container->set(
    'IndexController',
    function () {
        return new AnotherComponent();
    }
);

$component = $container->get('IndexController');
```
In the above example we are _replacing_ the `IndexController` with another component of our choosing. Also, you can adjust your code to always instantiate your classes using the service container, even if they are not registered as services. El contenedor recurrirá al autocargador que ha definido para cargar la propia clase. Al usar esta técnica, puede sustituir cualquier clase en el futuro implementando una definición diferente para ella.

## Inyección Automática
Si una clase o componente necesita el propio DI para localizar servicios, el DI puede inyectarse automáticamente a las instancias que crea. To take advantage of this, all you need is to implement the [Phalcon\Di\InjectionAwareInterface][di-injectionawareinterface] in your classes:

```php
<?php

use Phalcon\Di\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

class InvoiceComponent implements InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $container;

    public function setDi(DiInterface $container)
    {
        $this->container = $container;
    }

    public function getDi(): DiInterface
    {
        return $this->container;
    }
}
```

Then, once the service is resolved, the `$container` will be passed to `setDi()` automatically:

```php
<?php

$container->set('inv-component', InvoiceComponent::class);

$invoiceComponent = $container->get('inv-component');
```

> **NOTE** `: $invoiceComponent->setDi($container) is automatically called) 
> 
> {: .alert .alert-info }

For your convenience you can also extend the [Phalcon\Di\AbstractInjectionAware][di-abstractinjectionaware] class which contains the above code and exposes the protected `$container` property for you to use.

```php
<?php

use Phalcon\Di\DiInterface;
use Phalcon\Di\AbstractInjectionAware;

class InvoiceComponent extends AbstractInjectionAware
{

}
```

## Organización de Servicios en Ficheros
Puede organizar mejor su aplicación moviendo el registro de servicio a ficheros individuales en lugar de registrar todo en el arranque de la aplicación:

```php
<?php

$container->set(
    'router',
    function () {
        return include '/app/config/routes.php';
    }
);
```

Entonces en el fichero (`'/app/config/routes.php'`) devuelve el objeto resuelto:

```php
<?php

use Phalcon\Mvc\Router();

$router = new Router(false);

$router->post('/login');

return $router;
```

## Acceso Estático
The [Phalcon\Di\Di][di] offers the convenient `getDefault()` static method, which returns the latest container created. Esto le permite acceder al contenedor incluso desde clases estáticas:

```php
<?php

use Phalcon\Di\Di;

class InvoicesComponent
{
    public static function calculate()
    {
        $connection = Di::getDefault()->getDb();
    }
}
```

## Proveedores de Servicio
Otro método de registro de servicios es poniendo cada servicio en su propio fichero, y registrar todos los servicios, uno detrás de otro, con un simple bucle. Each file will contain a class or `Provider` that implements the [Phalcon\Di\ServiceProviderInterface][di-serviceproviderinterface]. La razón por la que podría querer hacer esto es para tener ficheros pequeños, cada uno gestionando un registro de servicio que ofrecerá una gran flexibilidad, código corto y finalmente la capacidad de añadir/quitar servicios cuando lo desee, sin tener que examinar un fichero grande como el de arranque.

**Ejemplo**

`app/config/providers.php`
```php
<?php

return [
    MyApp\Providers\ConfigProvider::class,
    MyApp\Providers\RegistryProvider::class,
    MyApp\Providers\LoggerProvider::class,
];    
```

`app/library/Providers/ConfigProvider.php`
```php
<?php

namespace MyApp\Providers;

use Phalcon\Config;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Di\DiInterface;

class ConfigProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container)
    {
        $container->setShared(
            'config',
            function () {
                $data = require 'app/config/config.php';

                return new Config($data);
            }
        );
    }
}
```

`app/library/Providers/RegistryProvider.php`
```php
<?php

namespace MyApp\Providers;

use Phalcon\Config;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Di\DiInterface;
use Phalcon\Registry;

use function microtime;

class RegistryProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $container
     */
    public function register(DiInterface $container)
    {
        /** @var Config $config */
        $config  = $container->getShared('config');
        $devMode = $config->path('app.devMode', false);

        $container->setShared(
            'registry',
            function () use ($devMode) {
                $registry = new Registry();
                $registry->offsetSet('devMode', $devMode);
                $registry->offsetSet('execution', microtime(true));

                return $registry;
            }
        );
    }
}
```

`app/library/Providers/LoggerProvider.php`
 ```php
<?php

namespace MyApp\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

class LoggerProvider implements ServiceProviderInterface
{
    use LoggerTrait;

    /**
     * @param DiInterface $container
     *
     * @throws \Exception
     */
    public function register(DiInterface $container)
    {
        $container->setShared(
            'logger', 
            function () {
                $adapter = new Stream('/storage/logs/main.log');

                return new Logger(
                    'messages',
                    [
                        'main' => $adapter,
                    ]
                );
            }
        );
    }
}

```

Now we can register all the services with a simple loop:

```php
<?php

use Phalcon\Di\Di;

$services = include('app/config/providers.php');

$container = new Di();

foreach ($services as $service) {
    $container->register(new $service());
}
```

## Factory por defecto
For convenience to developers, the [Phalcon\Di\FactoryDefault][di-factorydefault] is available with several preset services for you. Nada le impide registrar todos los servicios que necesite su aplicación uno por uno. However, you can use the [Phalcon\Di\FactoryDefault][di-factorydefault], which contains a list of services ready to be used. La lista de servicios registrados le permite tener un contenedor adecuado para una aplicación *full stack*.

> **NOTE** Since the services are always lazy loaded, instantiating the [Phalcon\Di\FactoryDefault][di-factorydefault] container will not consume more memory than a [Phalcon\Di\Di][di] one. 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Di\FactoryDefault;

$container = new FactoryDefault();
```

The services registered in the [Phalcon\Di\FactoryDefault][di-factorydefault] are:

| Nombre               | Objeto                                                              | Compartido | Descripción                              |
| -------------------- | ------------------------------------------------------------------- | ---------- | ---------------------------------------- |
| `annotations`        | [Phalcon\Annotations\Adapter\Memory](annotations)                | Si         | Analizador de anotaciones                |
| `assets`             | [Phalcon\Assets\Manager](assets)                                  | Si         | Gestor de recursos                       |
| `crypt`              | [Phalcon\Encryption\Crypt](encryption-crypt)                      | Si         | Encriptar/Desencriptar                   |
| `cookies`            | [Phalcon\Http\Response\Cookies](response#cookies)                | Si         | Gestor de Cookies HTTP                   |
| `db`                 | [Phalcon\Db](db-layer)                                             | Si         | Conexión de base de datos                |
| `dispatcher`         | [Phalcon\Mvc\Dispatcher](dispatcher)                              | Si         | Dispatcher                               |
| `escaper`            | [Phalcon\Html\Escaper](html-escaper)                              | Si         | Escaper                                  |
| `eventsManager`      | [Phalcon\Events\Manager](events)                                  | Si         | Gestor de Eventos                        |
| `flash`              | [Phalcon\Flash\Direct](flash)                                     | Si         | Mensajería Flash                         |
| `flashSession`       | [Phalcon\Flash\Session](flash)                                    | Si         | Mensajería de Sesión Flash               |
| `filter`             | [Phalcon\Filter\Filter](filter-filter)                            | Si         | Filtrar / Sanear                         |
| `helper`             | [Phalcon\Support\HelperFactory](support-helper)                   | Si         | String, array etc. helpers               |
| `modelsCache`        |                                                                     |            | Motor de caché para modelos              |
| `modelsManager`      | [Phalcon\Mvc\Model\Manager](db-models)                           | Si         | Gestor de Modelos                        |
| `modelsMetadata`     | [Phalcon\Mvc\Model\MetaData\Memory](db-models-metadata)         | No         | MetaDatos de Modelos                     |
| `request`            | [Phalcon\Http\Request](request)                                   | Si         | Petición HTTP                            |
| `response`           | [Phalcon\Http\Response](response)                                 | Si         | Respuesta HTTP                           |
| `router`             | [Phalcon\Mvc\Router](routing)                                     | Si         | Router                                   |
| `security`           | [Phalcon\Security](encryption-security)                            | Si         | Seguridad                                |
| `session`            |                                                                     |            | Servicio de Sesiones                     |
| `sessionBag`         | [Phalcon\Session\Bag](session#bag)                                | Si         | Servicio de bolsa de sesión              |
| `tag`                | [Phalcon\Html\TagFactory](tag)                                    | Si         | Ayudantes de Etiquetas HTML              |
| `transactionManager` | [Phalcon\Mvc\Model\Transaction\Manager](db-models-transactions) | Si         | Gestor de Transacciones de Base de Datos |
| `url`                | [Phalcon\Mvc\Url](mvc-url)                                        | Si         | Generación de URL                        |

Los nombres anteriores se usan en todo el *framework*. Por ejemplo, el servicio `db` se usa desde el servicio `transactionManager`. Puede sustituir estos componentes por los que prefiera, simplemente registrando su componente con el mismo nombre que los listados anteriormente.

## Excepciones
Any exceptions thrown in the DI container will be either [Phalcon\Di\Exception][di-exception] or [Phalcon\Di\ServiceResolutionException][di-exception-serviceresolutionexception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Di\Di;
use Phalcon\Di\Exception;

try {
    $container = new Di();
    $component = $container->get('unknown-service');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Personalizado
The [Phalcon\Di\DiInterface][di-diinterface] interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one. You can also utilize the [Phalcon\Di\ServiceInterface][di-serviceinterface] to create your own implementations of services and how they resolve in the DI container.

[di]: api/phalcon_di#di
[di-abstractinjectionaware]: api/phalcon_di#di-abstractinjectionaware
[di-diinterface]: api/phalcon_di#di-diinterface
[di-exception]: api/phalcon_di#di-exception
[di-exception-serviceresolutionexception]: api/phalcon_di#di-exception-serviceresolutionexception
[di-factorydefault]: api/phalcon_di#di-factorydefault
[di-injectionawareinterface]: api/phalcon_di#di-injectionawareinterface
[di-serviceinterface]: api/phalcon_di#di-serviceinterface
[di-serviceproviderinterface]: api/phalcon_di#di-serviceproviderinterface
[ioc]: https://en.wikipedia.org/wiki/Inversion_of_control
[yaml]: https://php.net/manual/book.yaml.php
