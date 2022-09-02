---
layout: default
language: 'es-es'
version: '4.0'
title: 'Inyector de Dependencias / Localizador de Servicios'
keywords: 'inyección de dependencias, di, ioc, localizador servicios'
---

# Inyector de Dependencias / Localizador de Servicios

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Di](api/phalcon_di#di) es un contenedor que almacena servicios o componentes (clases). Estos servicios están disponibles desde la aplicación y facilitan el desarrollo. Supongamos que estamos desarrollando un componente llamado `InvoiceComponent` que realiza algunos cálculos para la factura de un cliente. Requiere una conexión de base de datos para obtener el registro `Invoice` desde la base de datos.

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

Para mejorar la flexibilidad, podríamos crear la conexión a la base de datos fuera del componente, y pasarla a `InvoiceComponent` usando un *setter*. Usando este enfoque, podemos *inyectar* la conexión de base de datos a cualquier componente que lo requiera usando el *setter*. Una vez más, esta implementación es perfectamente válida pero tiene algunas deficiencias. Por ejemplo, necesitaremos construir la conexión a la base de datos cada vez que necesitemos usar cualquiera de nuestros componentes que requieran conectividad con la base de datos.

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

En el ejemplo anterior cambiamos la clase `Registry`, exponiendo `getNewConnection` que crea una nueva conexión con la base de datos. También expone `getSharedConnection` que almacenará la conexión internamente y la reutilizará para cualquier otro componente que la requiera.

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
use Phalcon\Di;
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

[Phalcon\Di](api/phalcon_di#di) es un componente que implementa la Inyección de Dependencias y un Localizador de Servicio. Ya que Phalcon es altamente desacoplado, [Phalcon\Di](api/phalcon_di#di) es esencial para integrar los diferentes componentes del *framework*. El desarrollador puede usar también este componente para inyectar dependencias y gestionar instancias globales de las diferentes clases usadas en la aplicación. También implementa el patrón [Inversión de Control](https://es.wikipedia.org/wiki/Inversi%C3%B3n_de_control). Debido a esto, los objetos no reciben sus dependencias usando *setters* o constructores, sino solicitando un inyector de dependencias de servicio. Esto reduce la complejidad general, ya que sólo hay una manera de obtener las dependencias requeridas desde un componente.

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

Intenta registrar un servicio en el contenedor de servicios. Sólo será correcto si no ha sido registrado previamente ningún servicio con el mismo nombre

```php
public function get(
    string $name, 
    mixed parameters = null
): mixed
```

Resuelve el servicio basado en su configuración

```php
public static function getDefault(): DiInterface | null
```

Devuelve el último *DI* creado

```php
public function getInternalEventsManager(): ManagerInterface
```

Devuelve el Gestor de Eventos interno

```php
public function getRaw(string $name): mixed
```

Devuelve la definición de servicio sin resolver

```php
public function getService(string $name): ServiceInterface
```

Devuelve una instancia `Phalcon\Di\Service`

```php
public function getServices(): ServiceInterface[]
```

Devuelve los servicios registrados en el *DI*

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

Carga servicios desde un fichero de configuración php.

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

Carga servicios desde un fichero yaml.

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

Comprueba si el *DI* contiene un servicio por un nombre

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

Comprueba si un servicio está registrado usando la sintaxis de vector

```php
public function offsetSet(mixed $name, mixed $definition)
```

Permite registrar un servicio compartido usando la sintaxis de vector

```php
$container["request"] = new \Phalcon\Http\Request();
```

```php
public function offsetUnset(mixed $name)
```

Elimina un servicio del contenedor de servicios usando la sintaxis de vector

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

Elimina un servicio del contenedor de servicios. También elimina cualquier instancia compartida creada del servicio

```php
public static function reset()
```

Resetea el *DI* interno por defecto

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

Registra un servicio *siempre compartido* en el contenedor de servicios

## Registro de Servicios

El propio *framework* o el desarrollador puede registrar servicios. Cuando un componente A requiere un componente B (o una instancia de su clase) para operar, puede solicitar el componente B desde el contenedor, en lugar de crear una nueva instancia del componente B.

Este enfoque ofrece las siguientes ventajas: * Podemos reemplazar fácilmente un componente por otro creado por nosotros o un tercero. * Tenemos control total de la inicialización del objeto, lo que nos permite establecer estos objetos como necesitemos antes de entregarlos a los componentes. * Podemos obtener instancias globales de los componentes de una forma estructurada y unificada.

Los servicios se pueden registrar usando varios tipos de definiciones. A continuación exploraremos las diferentes formas en las que se pueden registrar los servicios:

### Cadena

Este tipo espera el nombre de una clase válida, devolviendo un objeto de la clase especificada, si la clase no está cargada será instanciada usando un cargador automático (*auto-loader*). Este tipo de definición no permite especificar argumentos para el constructor de la clase o parámetros:

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

Éste método ofrece mayor libertad para construir la dependencia como se desee, sin embargo, es difícil cambiar alguno de los parámetros externamente sin tener que cambiar completamente la definición de la dependencia:

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

Algunas de las limitaciones se pueden superar pasando variables adicionales al entorno de la función anónima:

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

> NOTA: `$this` se puede usar dentro de una función anónima
{: .alert .alert-info }

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

Además usando la sintaxis de vector puede usar tres tipos de inyección de dependencia:

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

use Phalcon\Di;
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

> **NOTA**: [Phalcon\Di](api/phalcon_di#di) ofrece carga perezosa para cada servicio almacenado. A no ser que el desarrollador decida instanciar un objeto directamente y almacenarlo en el contenedor, cualquier objeto almacenado en él (vía vector, cadena, etc.) se cargará perezosamente, es decir, se instanciará sólo cuando se solicite.
{: .alert .alert-info }

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

use Phalcon\Di;

$container = new Di();
$container->loadFromYaml('services.yml');
$container->get('/app/config/services.yml');
```

> **NOTA**: Este enfoque requiere que esté instalado el módulo Yaml. Por favor, para más información consulte [este documento](https://php.net/manual/book.yaml.php).
{: .alert .alert-danger }


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

use Phalcon\Di;

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

[Phalcon\Di](api/phalcon_di#di) es capaz de enviar eventos a un [EventsManager](events) si está presente. Los eventos se disparan usando el tipo `di`.

| Nombre de Evento       | Disparado                                                                                                                             |
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

> **NOTA**: Si un servicio no está registrado como compartido y se quiere asegurar de que se accederá a una instancia compartida cada vez que se recupere el servicio desde el *DI*, puede usar el método `getShared`
{: .alert .alert-info }

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

En el ejemplo anterior estamos *reemplazando* el `IndexController` con otro componente de nuestra elección. También puede ajustar su código para instanciar siempre sus clases usando el servicio contenedor, incluso si no están registradas como servicios. El contenedor recurrirá al autocargador que ha definido para cargar la propia clase. Al usar esta técnica, puede sustituir cualquier clase en el futuro implementando una definición diferente para ella.

## Inyección Automática

Si una clase o componente necesita el propio DI para localizar servicios, el DI puede inyectarse automáticamente a las instancias que crea. Para aprovechar esto, todo lo que necesita es implementar [Phalcon\Di\InjectionAwareInterface](api/phalcon_di#di-injectionawareinterface) en sus clases:

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

Luego, una vez que el servicio se resuelve, el `$container` se pasará automáticamente a `setDi()`:

```php
<?php

$container->set('inv-component', InvoiceComponent::class);

$invoiceComponent = $container->get('inv-component');
```

> **NOTA** `: $invoiceComponent->setDi($container) se llama automáticamente)
{: .alert .alert-info }

Si le conviene también puede extender la clase [Phalcon\Di\AbstractInjectionAware](api/phalcon_di#di-abstractinjectionaware) que contiene el código anterior y expone la propiedad protegida `$container` para su uso.

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

[Phalcon\Di](api/phalcon_di#di) ofrece el método estático `getDefault()` conveniente, que devuelve el último contenedor creado. Esto le permite acceder al contenedor incluso desde clases estáticas:

```php
<?php

use Phalcon\Di;

class InvoicesComponent
{
    public static function calculate()
    {
        $connection = Di::getDefault()->getDb();
    }
}
```

## Proveedores de Servicio

Otro método de registro de servicios es poniendo cada servicio en su propio fichero, y registrar todos los servicios, uno detrás de otro, con un simple bucle. Cada fichero contendrá una clase o `Provider` que implementa [Phalcon\Di\ServiceProviderInterface](api/phalcon_di#di-serviceproviderinterface). La razón por la que podría querer hacer esto es para tener ficheros pequeños, cada uno gestionando un registro de servicio que ofrecerá una gran flexibilidad, código corto y finalmente la capacidad de añadir/quitar servicios cuando lo desee, sin tener que examinar un fichero grande como el de arranque.

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
use Phalcon\DiInterface;

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
use Phalcon\DiInterface;
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

`app/library/Providers/LoggerProvider.php` ```php <?php

namespace MyApp\Providers;

use Phalcon\Di\ServiceProviderInterface; use Phalcon\DiInterface; use Phalcon\Logger; use Phalcon\Logger\Adapter\Stream;

class LoggerProvider implements ServiceProviderInterface { use LoggerTrait;

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

    <br />Ahora podemos registrar todos los servicios con un simple bucle:
    
    ```php
    <?php
    
    use Phalcon\Di;
    
    $services = include('app/config/providers.php');
    
    $container = new Di();
    
    foreach ($services as $service) {
        $container->register(new $service());
    }
    

## Factory Default

Para comodidad de los desarrolladores, está disponible [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) con varios servicios preestablecidos para usted. Nada le impide registrar todos los servicios que necesite su aplicación uno por uno. Sin embargo, puede usar [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), que contiene una lista de servicios listos para usar. La lista de servicios registrados le permite tener un contenedor adecuado para una aplicación *full stack*.

> **NOTA** Ya que los servicios siempre se cargan perezosamente, instanciar el contenedor [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) no consumirá más memoria que [Phalcon\Di](api/phalcon_di#di).
{: .alert .alert-info }

```php
<?php

use Phalcon\Di\FactoryDefault;

$container = new FactoryDefault();
```

Los servicios registrados en [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) son:

| Nombre               | Objeto                                                              | Compartido | Descripción                              |
| -------------------- | ------------------------------------------------------------------- | ---------- | ---------------------------------------- |
| `annotations`        | [Phalcon\Annotations\Adapter\Memory](annotations)                | Si         | Analizador de anotaciones                |
| `assets`             | [Phalcon\Assets\Manager](assets)                                  | Si         | Gestor de recursos                       |
| `crypt`              | [Phalcon\Crypt](crypt)                                             | Si         | Encriptar/Desencriptar                   |
| `cookies`            | [Phalcon\Http\Response\Cookies](response#cookies)                | Si         | Gestor de Cookies HTTP                   |
| `db`                 | [Phalcon\Db](db-layer)                                             | Si         | Conexión de base de datos                |
| `dispatcher`         | [Phalcon\Mvc\Dispatcher](dispatcher)                              | Si         | Despachador                              |
| `escaper`            | [Phalcon\Escaper](escaper)                                         | Si         | Escapador                                |
| `eventsManager`      | [Phalcon\Events\Manager](events)                                  | Si         | Gestor de Eventos                        |
| `flash`              | [Phalcon\Flash\Direct](flash)                                     | Si         | Mensajería Flash                         |
| `flashSession`       | [Phalcon\Flash\Session](flash)                                    | Si         | Mensajería de Sesión Flash               |
| `filter`             | [Phalcon\Filter](filter)                                           | Si         | Filtrar / Sanear                         |
| `modelsCache`        |                                                                     |            | Motor de caché para modelos              |
| `modelsManager`      | [Phalcon\Mvc\Model\Manager](db-models)                           | Si         | Gestor de Modelos                        |
| `modelsMetadata`     | [Phalcon\Mvc\Model\MetaData\Memory](db-models-metadata)         | No         | MetaDatos de Modelos                     |
| `request`            | [Phalcon\Http\Request](request)                                   | Si         | Petición HTTP                            |
| `response`           | [Phalcon\Http\Response](response)                                 | Si         | Respuesta HTTP                           |
| `router`             | [Phalcon\Mvc\Router](routing)                                     | Si         | Enrutador                                |
| `security`           | [Phalcon\Security](security)                                       | Si         | Seguridad                                |
| `session`            |                                                                     |            | Servicio de Sesiones                     |
| `sessionBag`         | [Phalcon\Session\Bag](session#bag)                                | Si         | Servicio de bolsa de sesión              |
| `tag`                | [Phalcon\Tag](tag)                                                 | Si         | Ayudantes de Etiquetas HTML              |
| `transactionManager` | [Phalcon\Mvc\Model\Transaction\Manager](db-models-transactions) | Si         | Gestor de Transacciones de Base de Datos |
| `url`                | [Phalcon\Url](url)                                                 | Si         | Generación de URL                        |

Los nombres anteriores se usan en todo el *framework*. Por ejemplo, el servicio `db` se usa desde el servicio `transactionManager`. Puede sustituir estos componentes por los que prefiera, simplemente registrando su componente con el mismo nombre que los listados anteriormente.

## Excepciones

Cualquier excepción lanzada en el contenedor DI será [Phalcon\Di\Exception](api/phalcon_di#di-exception) o [Phalcon\Di\ServiceResolutionException](api/phalcon_di#di-exception-serviceresolutionexception). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Di;
use Phalcon\Di\Exception;

try {
    $container = new Di();
    $component = $container->get('unknown-service');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Personalización

Se debe implementar la interfaz [Phalcon\Di\DiInterface](api/phalcon_di#di-diinterface) para crear su propio DI que reemplace el provisto por Phalcon o extienda el actual. También puede utilizar [Phalcon\Di\ServiceInterface](api/phalcon_di#di-serviceinterface) para crear sus propias implementaciones de servicios y cómo se resuelven en el contenedor DI.
