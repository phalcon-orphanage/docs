---
layout: default
title: 'Anotaciones'
keywords: 'anotaciones, enrutado, analizador de anotaciones, docblocks'
---

# Anotaciones
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
Phalcon introdujo el primer componente analizador de anotaciones escrito en C para PHP. The `Phalcon\Annotations` namespace contains general purpose components that offers an easy way to parse and cache annotations in PHP applications.

## Uso
Las anotaciones son leídas desde docblocks en clases, métodos y propiedades. Una anotación puede colocarse en cualquier posición del docblock:

```php
<?php

/**
 * #01
 *
 * @AmazingClass(true)
 */
class Example
{
    /**
     * #02
     *
     * @SpecialFeature
     */
    protected $someProperty;

    /**
     * #03
     *
     * @SpecialFeature
     */
    public function someMethod()
    {
        // ...
    }
}
```

> **Legend**
> 
> 01: This is the class description
> 
> 02: This a property with a special feature
> 
> 03: This is a method 
> 
> {: .alert .alert-info }


Una anotación tiene la siguiente sintaxis:

```php
/**
 * @Annotation-Name
 * @Annotation-Name(param1, param2, ...)
 */
```

También, una anotación se puede colocar en cualquier parte de un docblock:

```php
<?php

/**
 * #01
 *
 * @SpecialFeature
 *
 * #02
 *
 * @AnotherSpecialFeature(true)
 */
```

> **Legend**
> 
> 01: This is a property with a special feature
> 
> 02: More comments 
> 
> {: .alert .alert-info }

El analizador es altamente flexible, el siguiente docblock es válido:

```php
<?php

/**
 * Esta es una propiedad con una característica especial @SpecialFeature({
someParameter='the value', false

 })  Más comentarios @AnotherSpecialFeature(true) @MoreAnnotations
 **/
```

Sin embargo, para hacer el código más mantenible y comprensible se recomienda colocar las anotaciones al final del docblock:

```php
<?php

/**
 * #01
 * #02
 *
 * @SpecialFeature({someParameter='the value', false})
 * @AnotherSpecialFeature(true)
 */
```

> **Legend**
> 
> 01: This is a property with a special feature
> 
> 02: More comments 
> 
> {: .alert .alert-info }

Un ejemplo para un modelo es:

```php
<?php

use Phalcon\Mvc\Model;

/**
 * #01
 *
 * #02
 *
 * @Source('co_customers');
 * @HasMany("cst_id", "Invoices", "inv_cst_id")
 */
class Customers extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false, column="cst_id")
     */
    public $id;

    /**
     * @Column(type="string", nullable=false, column="cst_name_first")
     */
    public $nameFirst;

    /**
     * @Column(type="string", nullable=false, column="cst_name_last")
     */
    public $nameLast;
}
```

> **Legend**
> 
> 01: Customers
> 
> 02: Represents a customer record 
> 
> {: .alert .alert-info }

## Tipos
Las anotaciones pueden tener parámetros o no. Un parámetro podría ser un literal simple (`cadenas`, `número`, `booleano`, `null`), un `vector`, una list codificada u otra anotación:

```php
/**
 * @SomeAnnotation
 */
```
Anotación Simple

```php
/**
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */
```
Anotación con parámetros

```php
/**
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */
```
Anotación con parámetros nombrados

```php
/**
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */
```
Pasando un vector

```php
/**
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */
```
Pasando una codificación como parámetro

```php
/**
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */
```
Vectores/Codificaciones anidadas

```php
/**
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```
Anotaciones Anidadas

## Adaptadores
Este componente hace uso de adaptadores para cachear o no las anotaciones analizadas y procesadas mejorando el rendimiento:

| Adaptador                                                           | Descripción                                                                                 |
| ------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| [Phalcon\Annotations\Adapter\Apcu][annotations-adapter-apcu]     | Usa APCu para almacenar las anotaciones analizadas y procesadas (producción)                |
| [Phalcon\Annotations\Adapter\Memory][annotations-adapter-memory] | Usa la memoria para almacenar anotaciones (desarrollo)                                      |
| [Phalcon\Annotations\Adapter\Stream][annotations-adapter-stream] | Usa un flujo de archivo para almacenar anotaciones. Se debe usar con un caché de byte-code. |

### Apcu
[Phalcon\Annotations\Adapter\Apcu][annotations-adapter-apcu] stores the parsed and processed annotations using the APCu cache. Este adaptador es adecuado para sistemas en producción. Sin embargo, una vez que el servidor se reinicia, el caché se limpiará y tendrá que reconstruirse. The adapter accepts two parameters in the constructor's `options` array:
- `prefix` - the prefix for the key stored
- `lifetime` - the cache lifetime

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$adapter = new Apcu(
    [
        'prefix'   => 'my-prefix',
        'lifetime' => 3600,
    ]
);
```

Internamente, el adaptador almacena los datos prefijando cada clave con `_PHAN`. Este ajuste no se puede cambiar. Sin embargo, esto le da la opción de escanear APCu en busca de claves que tengan el prefijo `_PHAN` y limpiarlas si es necesario.

```php
<?php

use APCuIterator;

$result   = true;
$pattern  = "/^_PHAN/";
$iterator = new APCuIterator($pattern);

if (true === is_object($iterator)) {
    return false;
}

foreach ($iterator as $item) {
    if (true !== apcu_delete($item["key"])) {
        $result = false;
    }
}

return $result;
```

### Memory
[Phalcon\Annotations\Adapter\Memory][annotations-adapter-memory] stores the parsed and processed annotations in memory. Este adaptador es adecuado para sistemas en desarrollo. The cache is rebuilt on every request, and therefore can immediately reflect changes, while developing your application.

```php
<?php

use Phalcon\Annotations\Adapter\Memory;

$adapter = new Memory();
```

### Flujo (Stream)
[Phalcon\Annotations\Adapter\Stream][annotations-adapter-stream] stores the parsed and processed annotations in a file on the server. This adapter can be used in production systems, but it will increase the I/O since for every request the annotations cache files will need to be read from the file system. The adapter accepts one parameter in the constructor's `$options` array:
- `annotationsDir` - the directory to store the annotations cache

```php
<?php

use Phalcon\Annotations\Adapter\Stream;

$adapter = new Stream(
    [
        'annotationsDir' => '/app/storage/cache/annotations',
    ]
);
```

If there is a problem with storing the data in the folder due to permissions or any other reason, a [Phalcon\Annotations\Exception][annotations-exception] will be thrown.

### Personalizado
[Phalcon\Annotations\Adapter\AdapterInterface][annotations-adapter-adapterinterface] is available. Ampliar esta interfaz le permitirá crear sus propios adaptadores.

## Fábrica (Factory)
### `newInstance`
Podemos crear fácilmente una clase adaptador de anotaciones usando la palabra clave `new`. However, Phalcon offers the [Phalcon\Annotations\AnnotationsFactory][annotations-annotationsfactory] class, so that developers can easily instantiate annotations adapters. La fábrica aceptará un vector de opciones que a su vez se usarán para instanciar la clase adaptador necesaria. The factory always returns a new instance that implements the [Phalcon\Annotations\Adapter\AdapterInterface][annotations-adapter-adapterinterface]. Los nombre de los adaptadores preconfigurados son:

| Nombre   | Adaptador                                                           |
| -------- | ------------------------------------------------------------------- |
| `apcu`   | [Phalcon\Annotations\Adapter\Apcu][annotations-adapter-apcu]     |
| `memory` | [Phalcon\Annotations\Adapter\Memory][annotations-adapter-memory] |
| `stream` | [Phalcon\Annotations\Adapter\Stream][annotations-adapter-stream] |

El ejemplo siguiente muestra como puede crear un adaptador de anotaciones Apcu:

```php
<?php

use Phalcon\Annotations\AnnotationsFactory;

$options = [
    'prefix'   => 'my-prefix',
    'lifetime' => 3600,
];

$factory = new AdapterFactory();
$apcu    = $factory->newInstance('apcu', $options);
```

### `load`
The [Phalcon\Annotations\AnnotationsFactory][annotations-annotationsfactory] also offers the `load` method, which accepts a configuration object. Este objeto puede ser un vector o un objeto [Phalcon\Config](config), con directivas que se usarán para configurar el adaptador. El objeto requiere el elemento `adapter`, así como el elemento `options` con las directivas necesarias.

```php
<?php

use Phalcon\Annotations\AnnotationsFactory;

$options = [
    'adapter' => 'apcu',
    'options' => [
        'prefix'   => 'my-prefix',
        'lifetime' => 3600,
    ]
];

$factory = new AdapterFactory();
$apcu    = $factory->load($options);
```

## Leyendo anotaciones
Se implementa un reflector para obtener fácilmente las anotaciones definidas en una clase usando una interfaz orientada a objetos. [Phalcon\Annotations\Reader][annotations-reader] is used along with [Phalcon\Annotations\Reflection][annotations-reflection]. They also utilize the collection [Phalcon\Annotations\Collection][annotations-collection] that contains [Phalcon\Annotations\Annotation][annotations-annotation] objects once the annotations are parsed.

```php
<?php

use Phalcon\Annotations\Adapter\Memory;

$adapter = new Memory();

$reflector   = $adapter->get('Invoices');
$annotations = $reflector->getClassAnnotations();

foreach ($annotations as $annotation) {
    echo $annotation->getName(), PHP_EOL;
    echo $annotation->numberArguments(), PHP_EOL;

    print_r($annotation->getArguments());
}
```
En el ejemplo anterior primero creamos el adaptador de anotaciones de memoria. Luego se llama a `get` para cargar las anotaciones de la clase `Invoices`. The `getClassAnnotations` will return a [Phalcon\Annotations\Collection][annotations-collection] class. Iteramos sobre la colección e imprimimos el nombre (`getName`), el número de argumentos (`numberArguments`) y luego imprimimos todos los argumentos (`getArguments`) por pantalla.

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter to reduce unnecessary CPU cycles for parsing.

## Excepciones
Any exceptions thrown in the `Phalcon\Annotations` namespace will be of type [Phalcon\Annotations\Exception][annotations-exception]. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Annotations\Adapter\Memory;
use Phalcon\Annotations\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $adapter = new Memory();

            $reflector   = $adapter->get('Invoices');
            $annotations = $reflector->getClassAnnotations();

            foreach ($annotations as $annotation) {
                echo $annotation->getExpression('unknown-expression');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Ejemplos

**Acceso basado en controlador**

Puede usar anotaciones para definir qué áreas se controlan por la ACL. Podemos hacer esto registrando un plugin en el gestor de eventos que escucha el evento `beforeExceuteRoute`, o simplemente implementar el método en nuestro controlador base.

Primero necesitamos configurar el gestor de anotaciones en nuestro contenedor DI:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Annotations\Adapter\Apcu;

$container = new FactoryDefault();

$container->set(
    'annotations',
    function () {
        return new Apcu(
            [
                'lifetime' => 86400
            ]
        );
    }
);
```

y ahora en el controlador base implementamos el método `beforeExceuteRoute`:

```php
<?php

namespace MyApp\Controllers;

use Phalcon\Annotations\Adapter\Apcu;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Controller
use MyApp\Components\Auth;

/**
 * @property Apcu $annotations
 * @property Auth $auth 
 */
class BaseController extends Controller
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeExceuteRoute(
        Dispatcher $dispatcher
    ) {
        $controllerName = $dispatcher->getControllerClass();

        $annotations = $this
            ->annotations
            ->get($controllerName)
        ;

        $exists = $annotations
            ->getClassAnnotations()
            ->has('Private')
        ;

        if (true !== $exists) {
            return true;
        }

        if (true === $this->auth->isLoggedIn()) {
            return true;
        }

        $dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'login',
            ]
        );

        return false;
    }
}
```

> **NOTE** You can also implement the above to a listener and use the `beforeDispatch` event if you wish. 
> 
> {: .alert .alert-info }

y en nuestros controladores podemos especificar:

```php
<?php

namespace MyApp\Controllers;

use MyApp\Controllers\BaseController;

/**
 * @Private(true) 
 */
class Invoices extends BaseController
{
    public function indexAction()
    {
    }
}
```

**Acceso basado en grupo**

Podría querer ampliar lo anterior y ofrecer un control de acceso más granular para su aplicación. Para esto, también usaremos `beforeExecuteRoute` en el controlador pero añadiremos los metadatos de acceso en cada acción. If we need a specific controller to be _locked_ we can also use the `initialize` method.

Primero necesitamos configurar el gestor de anotaciones en nuestro contenedor DI:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Annotations\Adapter\Apcu;

$container = new FactoryDefault();

$container->set(
    'annotations',
    function () {
        return new Apcu(
            [
                'lifetime' => 86400
            ]
        );
    }
);
```

y ahora en el controlador base implementamos el método `beforeExceuteRoute`:

```php
<?php

namespace MyApp\Controllers;

use Phalcon\Annotations\Adapter\Apcu;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Controller;
use MyApp\Components\Auth;

/**
 * @property Apcu $annotations
 * @property Auth $auth 
 */
class BaseController extends Controller
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeExceuteRoute(
        Dispatcher $dispatcher
    ) {
        $controllerName = $dispatcher->getControllerClass();
        $actionName     = $dispatcher->getActionName()
                        . 'Action';

        $data = $this
            ->annotations
            ->getMethod($controllerName, $actionName)
        ;
        $access    = $data->get('Access');
        $aclGroups = $access->getArguments();

        $user   = $this->acl->getUser();
        $groups = $user->getRelated('groups');

        $userGroups = [];
        foreach ($groups as $group) {
            $userGroups[] = $group->grp_name;
        }

        $allowed = array_intersect($userGroups, $aclGroups);
        $allowed = (count($allowed) > 0);

        if (true === $allowed) {
            return true;
        }

        $dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'login',
            ]
        );

        return false;
    }
}
```

y en nuestros controladores:

```php
<?php

namespace MyApp\Controllers;

use MyApp\Controllers\BaseController;

/**
 * @Private(true) 
 */
class Invoices extends BaseController
{
    /**
     * @Access(
     *     'Administrators',
     *     'Accounting',
     *     'Users',
     *     'Guests'
     * )
     */
    public function indexAction()
    {
    }

    /**
     * @Access(
     *     'Administrators',
     *     'Accounting',
     * )
     */
    public function listAction()
    {
    }

    /**
     * @Access(
     *     'Administrators',
     *     'Accounting',
     * )
     */
    public function viewAction()
    {
    }
}
```

## Recursos Adicionales
* [Tutorial: Creando el inicializador de modelos personalizado con anotaciones](https://blog.phalcon.io/post/tutorial-creating-a-custom-models-initializer)

[annotations-adapter-adapterinterface]: api/phalcon_annotations#annotations-adapter-adapterinterface
[annotations-adapter-apcu]: api/phalcon_annotations#annotations-adapter-apcu
[annotations-adapter-memory]: api/phalcon_annotations#annotations-adapter-memory
[annotations-adapter-stream]: api/phalcon_annotations#annotations-adapter-stream
[annotations-annotation]: api/phalcon_annotations#annotations-annotation
[annotations-annotationsfactory]: api/phalcon_annotations#annotations-annotationsfactory
[annotations-collection]: api/phalcon_annotations#annotations-collection
[annotations-exception]: api/phalcon_annotations#annotations-exception
[annotations-reader]: api/phalcon_annotations#annotations-reader
[annotations-reflection]: api/phalcon_annotations#annotations-reflection
