---
layout: default
language: 'es-es'
version: '4.0'
title: 'Anotaciones'
keywords: 'anotaciones, enrutado, analizador de anotaciones, docblocks'
---

# Anotaciones

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Phalcon introdujo el primer componente analizador de anotaciones escrito en C para PHP. El espacio de nombres `Phalcon\Annotations` contiene componentes de propósito general que ofrecen una forma fácil de analizar y cachear anotaciones en las aplicaciones PHP.

## Uso

Las anotaciones son leídas desde docblocks en clases, métodos y propiedades. Una anotación puede colocarse en cualquier posición del docblock:

```php
<?php

/**
 * This is the class description
 *
 * @AmazingClass(true)
 */
class Example
{
    /**
     * This a property with a special feature
     *
     * @SpecialFeature
     */
    protected $someProperty;

    /**
     * This is a method
     *
     * @SpecialFeature
     */
    public function someMethod()
    {
        // ...
    }
}
```

Una anotación tiene la siguiente sintaxis:

```php
/**
 * @NombreAnotacion
 * @NombreAnotacion(parámetro1, parámetro2, ...)
 */
```

También, una anotación se puede colocar en cualquier parte de un docblock:

```php
<?php

/**
 * Esta es una propiedad con una característica especial
 *
 * @SpecialFeature
 *
 * Mas comentarios
 *
 * @AnotherSpecialFeature(true)
 */
```

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
 * Esta es una propiedad con una característica especial
 * Más comentarios
 *
 * @SpecialFeature({someParameter='the value', false})
 * @AnotherSpecialFeature(true)
 */
```

Un ejemplo para un modelo es:

```php
<?php

use Phalcon\Mvc\Model;

/**
 * Customers
 *
 * Represents a customer record
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

| Adaptador                                                                                   | Descripción                                                                                 |
| ------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| [Phalcon\Annotations\Adapter\Apcu](api/phalcon_annotations#annotations-adapter-apcu)     | Usa APCu para almacenar las anotaciones analizadas y procesadas (producción)                |
| [Phalcon\Annotations\Adapter\Memory](api/phalcon_annotations#annotations-adapter-memory) | Usa la memoria para almacenar anotaciones (desarrollo)                                      |
| [Phalcon\Annotations\Adapter\Stream](api/phalcon_annotations#annotations-adapter-stream) | Usa un flujo de archivo para almacenar anotaciones. Se debe usar con un caché de byte-code. |

### Apcu

[Phalcon\Annotations\Adapter\Apcu](api/phalcon_annotations#annotations-adapter-apcu) almacena las anotaciones analizadas y procesadas usando el caché APCu. Este adaptador es adecuado para sistemas en producción. Sin embargo, una vez que el servidor se reinicia, el caché se limpiará y tendrá que reconstruirse. El adaptador acepta dos parámetros en el vector de `opciones` del constructor: - `prefix` - el prefijo para la clave almacenada - `lifetime` - el tiempo de vida del caché

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

### Memoria

[Phalcon\Annotations\Adapter\Memory](api/phalcon_annotations#annotations-adapter-memory) almacena las anotaciones analizadas y procesadas en memoria. Este adaptador es adecuado para sistemas en desarrollo. El caché es reconstruido en cada petición, y por lo tanto puede reflejar cambios inmediatamente mientras se desarrolla la aplicación.

```php
<?php

use Phalcon\Annotations\Adapter\Memory;

$adapter = new Memory();
```

### Flujo (Stream)

[Phalcon\Annotations\Adapter\Stream](api/phalcon_annotations#annotations-adapter-stream) almacena las anotaciones analizadas y procesadas en un fichero del servidor. Este adaptador se puede usar en sistemas de producción pero incrementará las E/S ya que para cada petición se necesita leer los ficheros de caché de las anotaciones desde el sistema de ficheros. El adaptador acepta un parámetro en el vector de `opciones` del constructor: - `annotationsDir` - directorio donde almacenar el caché de anotaciones

```php
<?php

use Phalcon\Annotations\Adapter\Stream;

$adapter = new Stream(
    [
        'annotationsDir' => '/app/storage/cache/annotations',
    ]
);
```

Si hay un problema en el almacenaje de los datos en la carpeta debido a permisos o cualquier otra razón, se lanzará una [Phalcon\Annotations\Exception](api/phalcon_annotations#annotations-exception).

### Personalizado

[Phalcon\Annotations\Adapter\AdapterInterface](api/phalcon_annotations#annotations-adapter-adapterinterface) está disponible. Ampliar esta interfaz le permitirá crear sus propios adaptadores.

## Fábrica (Factory)

### `newInstance`

Podemos crear fácilmente una clase adaptador de anotaciones usando la palabra clave `new`. Sin embargo Phalcon ofrece la clase [Phalcon\Annotations\AnnotationsFactory](api/phalcon_annotations#annotations-annotationsfactory), para que los desarrolladores puedan instanciar fácilmente adaptadores de anotaciones. La fábrica aceptará un vector de opciones que a su vez se usarán para instanciar la clase adaptador necesaria. La fábrica siempre devuelve una nueva instancia que implementa [Phalcon\Annotations\Adapter\AdapterInterface](api/phalcon_annotations#annotations-adapter-adapterinterface). Los nombre de los adaptadores preconfigurados son:

| Nombre   | Adaptador                                                                                   |
| -------- | ------------------------------------------------------------------------------------------- |
| `apcu`   | [Phalcon\Annotations\Adapter\Apcu](api/phalcon_annotations#annotations-adapter-apcu)     |
| `memory` | [Phalcon\Annotations\Adapter\Memory](api/phalcon_annotations#annotations-adapter-memory) |
| `stream` | [Phalcon\Annotations\Adapter\Stream](api/phalcon_annotations#annotations-adapter-stream) |

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

[Phalcon\Annotations\AnnotationsFactory](api/phalcon_annotations#annotations-annotationsfactory) también ofrece el método `load`, que acepta un objeto de configuración. Este objeto puede ser un vector o un objeto [Phalcon\Config](config), con directivas que se usarán para configurar el adaptador. El objeto requiere el elemento `adapter`, así como el elemento `options` con las directivas necesarias.

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

Se implementa un reflector para obtener fácilmente las anotaciones definidas en una clase usando una interfaz orientada a objetos. [Phalcon\Annotations\Reader](api/phalcon_annotations#annotations-reader) se usa junto con [Phalcon\Annotations\Reflection](api/phalcon_annotations#annotations-reflection). También utilizan la colección [Phalcon\Annotations\Collection](api/phalcon_annotations#annotations-collection) que contiene objetos [Phalcon\Annotations\Annotation](api/phalcon_annotations#annotations-annotation) una vez que se han analizado las anotaciones.

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

En el ejemplo anterior primero creamos el adaptador de anotaciones de memoria. Luego se llama a `get` para cargar las anotaciones de la clase `Invoices`. `getClassAnnotations` devolverá una clase [Phalcon\Annotations\Collection](api/phalcon_annotations#annotations-collection). Iteramos sobre la colección e imprimimos el nombre (`getName`), el número de argumentos (`numberArguments`) y luego imprimimos todos los argumentos (`getArguments`) por pantalla.

El proceso de lectura de anotaciones es muy rápido, sin embargo, por razones de rendimiento se recomienda almacenar las anotaciones analizadas usando un adaptador para reducir ciclos de CPU innecesarios para su análisis.

## Excepciones

Cualquier excepción lanzada en el espacio de nombres `Phalcon\Annotations` será del tipo [Phalcon\Annotations\Exception](api/phalcon_annotations#annotations-exception). Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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

> **NOTA** También puede implementar lo anterior sobre un oyente y usar el evento `beforeDispatch` si lo desea.
{: .alert .alert-info }

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

Podría querer ampliar lo anterior y ofrecer un control de acceso más granular para su aplicación. Para esto, también usaremos `beforeExecuteRoute` en el controlador pero añadiremos los metadatos de acceso en cada acción. Si necesitamos que un controlador específico sea *bloqueado* también podemos usar el método `initialize`.

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
