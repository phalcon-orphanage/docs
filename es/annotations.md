<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Analizador de anotaciones</a> 
      <ul>
        <li>
          <a href="#factory">Factory</a>
        </li>
        <li>
          <a href="#reading">Leyendo anotaciones</a>
        </li>
        <li>
          <a href="#types">Tipos de anotaciones</a>
        </li>
        <li>
          <a href="#usage">Usos prácticos</a> 
          <ul>
            <li>
              <a href="#usage-cache">Activar cache con anotaciones</a>
            </li>
            <li>
              <a href="#usage-access-management">Áreas privadas y públicas con anotaciones</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters">Adaptadores de anotaciones</a> 
          <ul>
            <li>
              <a href="#adapters-custom">Implementar sus propios adaptadores</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#resources">Recursos externos</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Analizador de anotaciones

Es la primera vez que un analizador de anotaciones está escrito en C para el mundo PHP. `Phalcon\Annotations` es un componente de propósito general que proporciona facilidad de análisis y cacheo con anotaciones en las clases de PHP para ser utilizado en aplicaciones.

Las anotaciones son leídas desde los comentarios (docblocks) de las clases, métodos y propiedades. Una anotación puede ser colocada en cualquier parte de un docblock:

```php
<?php

/**
 * Descripción de la clase
 *
 * @AmazingClass(true)
 */
class Example
{
    /**
     * Esta es una propiedad con una característica especial
     *
     * @SpecialFeature
     */
    protected $someProperty;

    /**
     * Este es un método
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

También, una anotación puede ser colocada en cualquier parte de un docblock:

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

Sin embargo, para hacer el código más mantenible y comprensible se recomienda colocar las anotaciones en el final del docblock:

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

<a name='factory'></a>

## Factory

Hay muchos adaptadores de anotaciones disponibles (ver [adaptadores](#adapters)). El que desee utilizar dependerá de las necesidades de su aplicación. La forma tradicional de crear instancias de un adaptador es la siguiente:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// .....
```

Además puede utilizar el método factory para conseguir el mismo resultado:

```php
<?php


use Phalcon\Annotations\Factory;

$options = [
    'prefix'   => 'annotations',
    'lifetime' => '3600',
    'adapter'  => 'memory',      // Cargar adaptador de memoria
];

$annotations = Factory::load($options);
```

El cargador factory proporciona más flexibilidad cuando se trata de instanciar adaptadores de anotaciones de archivos de configuración.

<a name='reading'></a>

## Leyendo anotaciones

Un [PHP Reflection](http://php.net/manual/es/book.reflection.php "Más información") es implementado para obtener fácilmente las anotaciones definidas en una clase con una interfaz orientada a objetos:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// Reflejamos las anotaciones en la clase Example
$reflector = $reader->get('Example');

// Leemos las anotaciones de la clase
$annotations = $reflector->getClassAnnotations();

// Iteramos las anotaciones
foreach ($annotations as $annotation) {
    // Imprimir el nombre de la anotación
    echo $annotation->getName(), PHP_EOL;

    // Imprimir número de argumentos
    echo $annotation->numberArguments(), PHP_EOL;

    // Imprimir argumentos
    print_r($annotation->getArguments());
}
```

El proceso de lectura de anotaciones es muy rápido, sin embargo, por razones de rendimiento que se recomienda almacenar las anotaciones analizadas utilizando un adaptador. Los adaptadores de caché para anotaciones, evitan la necesidad de analizar las anotaciones una y otra vez.

`Phalcon\Annotations\Adapter\Memory` fue utilizado en el ejemplo anterior. Este adaptador sólo almacena en caché las anotaciones mientras se ejecuta la petición y por ello es que este adaptador es más conveniente para el desarrollo. Hay otros [adaptadores disponibles](#adapters) para usar cuando la aplicación está en fase de producción.

<a name='types'></a>

## Tipos de anotaciones

Las anotaciones pueden tener parámetros o ninguno. Un parámetro podría ser un simple literal (string, number, boolean, null), un array, una lista hash u otra anotación:

```php
<?php

/**
 * Anotación simple
 *
 * @SomeAnnotation
 */

/**
 * Anotación con parametros
 *
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */

/**
 * Anotación con parámetros con nombres
 *
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */

/**
 * Pasando un array
 *
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */

/**
 * Pasando un hash como parámetro
 *
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */

/**
 * Arrays/hashes anidados
 *
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Anotaciones anidadas
 *
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```

<a name='usage'></a>

## Uso práctico

A continuación explicamos algunos ejemplos prácticos de las anotaciones en las aplicaciones PHP:

<a name='usage-cache'></a>

### Activar cache con anotaciones

Supongamos que hemos creado el controlador siguiente y quieres crear un plugin que inicia automáticamente el caché si la última acción ejecutada es marcada como almacenable en caché. Primero de todo, registramos un plugin en el servicio Dispatcher para que se notifique cuando una ruta se ejecuta:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;

$di['dispatcher'] = function () {
    $eventsManager = new EventsManager();

    // Adjuntamos el plugin al evento 'dispatch' 
    $eventsManager->attach(
        'dispatch',
        new CacheEnablerPlugin()
    );

    $dispatcher = new MvcDispatcher();

    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};
```

`CacheEnablerPlugin` es un plugin que intercepta cada acción ejecutada en el Dispatcher habilitando el caché si es necesario:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

/**
 * Activa el cache para una vista,
 * si la última acción tiene la anotación @Cache
 */
class CacheEnablerPlugin extends Plugin
{
    /**
     * Este evento es ejecutado antes que cada ruta esa ejecutada en el dispatcher
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Analizar las anotaciones en el método actualmente ejecutado
        $annotations = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActiveMethod()
        );

        // Comprobamos si el método tiene la anotación @Cache
        if ($annotations->has('Cache')) {
            // El método tiene la anotación 'Cache'
            $annotation = $annotations->get('Cache');

            // Obtenemos el 'lifetime'
            $lifetime = $annotation->getNamedParameter('lifetime');

            $options = [
                'lifetime' => $lifetime,
            ];

            // Comprobamos si el usuario definio un cache key o clave de cacheo
            if ($annotation->hasNamedParameter('key')) {
                $options['key'] = $annotation->getNamedParameter('key');
            }

            // Activamos el cache en el método actual
            $this->view->cache($options);
        }
    }
}
```

Ahora, podemos usar la anotación en un controlador:

```php
<?php

use Phalcon\Mvc\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {

    }

    /**
     * Este es un comentario
     *
     * @Cache(lifetime=86400)
     */
    public function showAllAction()
    {
        $this->view->article = Articles::find();
    }

    /**
     * Este es un comentario
     *
     * @Cache(key='my-key', lifetime=86400)
     */
    public function showAction($slug)
    {
        $this->view->article = Articles::findFirstByTitle($slug);
    }
}
```

<a name='usage-access-management'></a>

### Áreas privadas y públicas con anotaciones

Puede utilizar las anotaciones para decir al ACL que controladores pertenecen a las áreas administrativas:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * Este es un plugin de seguridad que controla que los usuarios solo tengan acceso a los módulos que están asignados
 */
class SecurityAnnotationsPlugin extends Plugin
{
    /**
     * Eta acción es ejecutada antes de ejecutar cada action en la aplicación
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Posible nombre de clase para el controlador
        $controllerName = $dispatcher->getControllerClass();

        // Posible nombre del método
        $actionName = $dispatcher->getActiveMethod();

        // Obtenemos las anotaciones en la clase controlador
        $annotations = $this->annotations->get($controllerName);

        // El controlador es privado?
        if ($annotations->getClassAnnotations()->has('Private')) {
            // Chequeamos si la variable de sesión está activa?
            if (!$this->session->get('auth')) {

                // El usuario no esta logeado, redirigimos al login
                $dispatcher->forward(
                    [
                        'controller' => 'session',
                        'action'     => 'login',
                    ]
                );

                return false;
            }
        }

        // Continuamos normalmente
        return true;
    }
}
```

<a name='adapters'></a>

## Adaptadores de anotaciones

Este componente hace uso de los adaptadores para cachear las anotaciones analizadas y procesadas, y así mejorar el rendimiento o proveer facilidades para desarrollo y pruebas:

| Clase                                   | Descripción                                                                                                                                                                                            |
| --------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `Phalcon\Annotations\Adapter\Memory` | Las anotaciones son cacheadas solo en memoria. Cuando una consulta termina el cache es limpiado, recargando las anotaciones en cada consulta. Este adaptador es adecuado para las etapas de desarrollo |
| `Phalcon\Annotations\Adapter\Files`  | Analizadas y procesadas las anotaciones son almacenadas permanentemente en archivos PHP, mejorando el desempeño. Este adaptador debe ser utilizado en conjunto con un cache bytecode.                  |
| `Phalcon\Annotations\Adapter\Apc`    | Analizadas y procesadas las anotaciones son almacenadas permanentemente en el cache APC, mejorando el desempeño. Es el adaptador más rápido                                                            |
| `Phalcon\Annotations\Adapter\Xcache` | Analizadas y procesadas las anotaciones son almacenadas permanentemente en el cache XCache, mejorando el desempeño. Es también un adaptador muy rápido                                                 |

<a name='adapters-custom'></a>

### Implementar tus propios adaptadores

Debe implementar la interfaz `Phalcon\Annotations\AdapterInterface` para crear sus propios adaptadores de anotaciones o extender los ya existentes.

<a name='resources'></a>

## Recursos externos

* [Tutorial: Creando el inicializador de modelos personalizado con anotaciones](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)