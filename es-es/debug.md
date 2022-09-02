---
layout: default
language: 'es-es'
version: '4.0'
title: 'Depuración'
keywords: 'debug, debugging, error handling, depuración'
---

# Depuración

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Preámbulo

![](/assets/images/content/xdebug-1.jpg)

PHP ofrece herramientas para depurar aplicaciones con avisos, advertencias, errores y excepciones. La [clase de excepción](https://www.php.net/manual/en/language.exceptions.php) ofrece información como archivo, línea, mensaje, código numérico, traza, etc. en donde se produjo un error. Los *frameworks* orientados a objetos como Phalcon principalmente utilizan esta clase para encapsular esta funcionalidad y proporcionar información al desarrollador o el usuario.

A pesar de estar escrito en C, Phalcon ejecuta métodos en el espacio de usuario de PHP, proporcionando las mismas capacidades de depuración que otros *frameworks* basados en PHP ofrecen.

## Excepciones

Una forma muy común de controlar el flujo de errores en tu aplicación (intencional o de otro tipo) es utilizar un bloque `try`/`catch` para atrapar excepciones. Hay muchos ejemplos en nuestra documentación que demuestran estos bloques.

```php
<?php

try {

    // ... 

} catch (\Exception $ex) {

}
```

Cualquier excepción lanzada dentro del bloque es capturada en la variable `$ex`. [Phalcon\Exception](api/Phalcon_Exception) extiende de la clase PHP [Exception](https://www.php.net/manual/en/language.exceptions.php). El uso de la excepción de Phalcon le permite distinguir si la excepción fue lanzada desde el código relacionado con Phalcon o en otros lugares.

La clase [Exception](https://www.php.net/manual/en/language.exceptions.php), expone lo siguiente:

```php
<?php

class Exception
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $file;
    /**
     * @var int
     */
    protected $line;

    /**
     * @var string
     */
    protected $message;

    public function __construct(
        string $message = '' 
        [, int $code = 0 
        [, Exception $previous = null ]]]
    );

    public function __toString() -> string;

    final public function getCode() -> int;

    final public function getFile() -> string;

    final public function getLine() -> int;

    final public function getMessage() -> string;

    final public function getPrevious() -> Exception;

    final public function getTrace() -> array;

    final public function getTraceAsString() -> string;

    final private function __clone() -> void;
}
```

Puede utilizar las mismas llamadas de método cuando utilice [Phalcon\Exception](api/Phalcon_Exception):

```php
<?php

use Phalcon\Exception;

try {

    // ...

} catch (Exception $ex) {
    echo get_class($ex), ': ', $ex->getMessage(), PHP_EOL;
    echo ' File=', $ex->getFile(), PHP_EOL;
    echo ' Line=', $ex->getLine(), PHP_EOL;
    echo $ex->getTraceAsString();
}
```

Por lo tanto es fácil de encontrar que archivo y línea de código de la aplicación generaron la excepción, así como los componentes implicados en la generación de la misma:

```html
PDOException: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost'
    (using password: NO)
 File=/app/public/index.php
 Line=74
#0 [internal function]: PDO->__construct('mysql:host=loca...', 'root', '', Array)
#1 [internal function]: Phalcon\Db\Adapter\Pdo->connect(Array)
#2 /app/public/index.php(74):
    Phalcon\Db\Adapter\Pdo->__construct(Array)
#3 [internal function]: {closure}()
#4 [internal function]: call_user_func_array(Object(Closure), Array)
#5 [internal function]: Phalcon\Di->_factory(Object(Closure), Array)
#6 [internal function]: Phalcon\Di->get('db', Array)
#7 [internal function]: Phalcon\Di->getShared('db')
#8 [internal function]: Phalcon\Mvc\Model->getConnection()
#9 [internal function]: Phalcon\Mvc\Model::_getOrCreateResultset('Users', Array, true)
#10 /app/app/controllers/SessionController.php(83):
    Phalcon\Mvc\Model::findFirst('email='demo@pha...')
#11 [internal function]: SessionController->startAction()
#12 [internal function]: call_user_func_array(Array, Array)
#13 [internal function]: Phalcon\Mvc\Dispatcher->dispatch()
#14 /app/public/index.php(114): Phalcon\Mvc\Application->handle()
#15 {main}
```

Como se ha demostrado anteriormente, no importa que Phalcon esté compilado como una extensión de PHP. La información de excepción contiene parámetros y llamadas a métodos que participaron en la llamada que generó el fragmento de excepción anterior. [Exception::getTrace()](https://www.php.net/manual/en/exception.gettrace.php) proporciona información adicional si es necesario.

## Constructor

[Phalcon\Debug](api/phalcon_debug#debug) proporciona ayuda visual así como información adicional para que los desarrolladores puedan localizar fácilmente los errores producidos en una aplicación.

> **NOTA** Asegúrese de que este componente no se utiliza en entornos de producción, ya que puede revelar información sobre su servidor a posibles atacantes
{: .alert .alert-danger }

El siguiente video tutorial explica cómo funciona:

<div align='center'>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Mk5ObSQmGpQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

Para habilitarlo, añada lo siguiente a su archivo de arranque:

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen();
```

o usando una sintaxis más corta:

```php
<?php

(new \Phalcon\Debug())->listen();
```

> **NOTA**: Cualquier bloque `try`/`catch` deben ser removidos o deshabilitados para que este componente funcione correctamente.
{: .alert .alert-warning }

Por defecto, el componente escuchará excepciones no capturadas pero no errores de baja gravedad (advertencias, avisos, etc.). Puede modificar este comportamiento pasando parámetros relevantes en `listen()`

- `exceptions` - boolean 
- `lowSeverity` - boolean

En el siguiente ejemplo, se evitará escuchar excepciones no capturadas pero se escucharan avisos o advertencias no silenciosas (baja severidad):

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen(false, true);
```

Si el flujo de su aplicación es diferente, o no desea pasar los parámetros en `listen()`, siempre puedes usar `listenExceptions()` y `listenLowSeverity()`:

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug
    ->listenExceptions()
    ->listenLowSeverity()
    ->listen();
```

> **NOTA**: Los métodos `listenExceptions()` y `listenLowSeverity()` son conmutadores **ON**. Si desea cambiar de escucha a excepciones o errores de baja gravedad a **OFF** necesita pasar `false` en el método `listen()`.
{: .alert .alert-info } 

## *Getters*

Hay algunos *getters* disponibles que ofrecen información sobre el componente. Extender de estos también podría cambiar visualmente el comportamiento del componente.

- `getCssSources()` - `string` Devuelve las hojas de estilo utilizadas para mostrar el contenido en la pantalla
- `getJsSources()` - `string` Devuelve los archivos javascript utilizados para mostrar el contenido en pantalla
- `getVersion()` - `string` Devuelve el enlace a la documentación de la versión actual

Extender del componente y sobrescribir el método `getCssSources()`, por ejemplo, para devolver diferentes directivas HTML CSS cambiará la apariencia de la salida en pantalla. Las clases CSS de salida se basan en [Bootstrap](https://getbootstrap.com/).

## *Setters*

[Phalcon\Debug](api/phalcon_debug#debug) también ofrece algunos *setters* para personalizar mejor la salida cuando ocurre un error en la aplicación.

- `setShowBackTrace(bool $showBackTrace)` - Mostrar/ocultar el backtrace de la excepción
- `setShowFileFragment(bool $showFileFragment)` - Mostrar/Ocultar el fragmento del archivo en la salida (relacionado con la excepción)
- `setShowFiles(bool $showFiles)` - Mostrar/Ocultar los archivos en el backtrace
- `setUri(string $uri)` - La URI base para los recursos estáticos (ver también la sección *Getters* para personalizar el componente)

## Variables

También puede utilizar el método `debugVar()`, para inyectar cualquier variable adicional que desee presentar en la salida. Estas son generalmente variables específicas de aplicación. Un ejemplo podría ser mostrar información de tiempo para su aplicación.

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$time = time();
$debug
    ->debugVar('time', $time)
    ->listen();
```

Para limpiar la pila de variables, puede llamar a `clearVars()`.

Finalmente, puede detener la ejecución de su aplicación y activar la visualización de una traza inversa llamando a `halt()`

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen();

// .....

if (12345 === $password) {
    $debug->halt();
}
```

## Salida de la lista negra

Como se mencionó anteriormente, el componente **no debe** estar habilitado en entornos de producción. Dado que Phalcon no puede controlar este comportamiento, hay una función integrada de lista negra que permite al desarrollador hacer una lista negra de ciertas piezas de información que no se desean que se muestren en la pantalla, por si acaso. Estos son elementos de los arreglos `$_REQUEST` y `$_SERVER`.

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();


$debug
    ->setBlacklist(
        [
            'request' => ['some'],
            'server'  => ['hostname'],
        ]
    )
    ->listen();
```

En el ejemplo anterior, nunca mostraremos el elemento `some` del `$_REQUEST` así como el `hostname` de `$_SERVER`. Siempre se pueden añadir más elementos que no se mostrarán, que existan en estas dos superglobales. Esto es especialmente útil en caso de que olvide desactivar el componente en su entorno de producción. Es una mala práctica dejarlo habilitado, pero si lo olvida, al menos ciertas piezas clave de información sobre su *host* no serán visibles para los potenciales atacantes.

> **NOTA**: Las claves de los elementos de la matriz a ocultar son insensibles en mayúsculas y minúsculas
{: .alert .alert-info }

## Manejadores

Para capturar excepciones y errores de baja gravedad, [Phalcon\Debug](api/phalcon_debug#debug) utiliza `onUncaughtException()` y `onUncaughtLowSeverity()`. La mayoría de los desarrolladores que usan este componente nunca necesitarán extender estos métodos. Sin embargo, si lo desea puede hacerlo extendiendo el componente y sobreescribiendo estos métodos para manipular la excepción y devolver la salida que usted requiera.

Estos dos métodos están siendo definidos como manejadores de excepciones usando el [set_exception_handler](https://www.php.net/manual/en/function.set-exception-handler.php) de PHP. Al llamar a `listenExceptions()` es registrado `onUncaughtException()`, mientras que al llamar a `listenLowSeverity()` es registrado `onUncaughtLowSeverity`.

## Reflexión e introspección

Las clases Phalcon no difieren de ninguna otra clase PHP y por lo tanto puede utilizar la [API de Reflexión](https://php.net/manual/en/book.reflection.php) o simplemente imprimir cualquier objeto para mostrar su contenido y estado:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

print_r($router);
```

El ejemplo anterior imprime lo siguiente:

```html
Phalcon\Mvc\Router Object
(
    [_dependencyInjector:protected] =>
    [_module:protected] =>
    [_controller:protected] =>
    [_action:protected] =>
    [_params:protected] => Array
        (
        )
    [_routes:protected] => Array
        (
            [0] => Phalcon\Mvc\Router\Route Object
                (
                    [_pattern:protected] => #^/([a-zA-Z0-9\_]+)[/]{0,1}$#
                    [_compiledPattern:protected] => #^/([a-zA-Z0-9\_]+)[/]{0,1}$#
                    [_paths:protected] => Array
                        (
                            [controller] => 1
                        )

                    [_methods:protected] =>
                    [_id:protected] => 0
                    [_name:protected] =>
                )

            [1] => Phalcon\Mvc\Router\Route Object
                (
                    [_pattern:protected] => #^/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)(/.*)*$#
                    [_compiledPattern:protected] => #^/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)(/.*)*$#
                    [_paths:protected] => Array
                        (
                            [controller] => 1
                            [action] => 2
                            [params] => 3
                        )
                    [_methods:protected] =>
                    [_id:protected] => 1
                    [_name:protected] =>
                )
        )
    [_matchedRoute:protected] =>
    [_matches:protected] =>
    [_wasMatched:protected] =>
    [_defaultModule:protected] =>
    [_defaultController:protected] =>
    [_defaultAction:protected] =>
    [_defaultParams:protected] => Array
        (
        )
)
```

## Xdebug

[Xdebug](https://xdebug.org) es una increíble herramienta que complementa la depuración de aplicaciones PHP. También es una extensión de C para PHP, y se puede utilizar junto con Phalcon sin configuración adicional o efectos secundarios.

Una vez que Xdebug esta instalado, puede utilizar su API para obtener una información más detallada sobre las excepciones y los mensajes.

> **NOTA**: Recomendamos utilizar la última versión de Xdebug para una mejor compatibilidad con Phalcon
{: .alert .alert-warning }

En el ejemplo siguiente se implementa [xdebug_print_function_stack](https://xdebug.org/docs/stack_trace) para detener la ejecución y generar una traza inversa:

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
        $name  = $this->request->getPost('name', 'string');
        $email = $this->request->getPost('email', 'email');

        // Stop execution and show a backtrace
        return xdebug_print_function_stack('stop here!');

        $user        = new Users();
        $user->name  = $name;
        $user->email = $email;

        // Store and check for errors
        $user->save();
    }
}
```

Para el ejemplo anterior, Xdebug también nos mostrará las variables en el ámbito local, así como un backtrace:

```html
Xdebug: stop here! in /app/app/controllers/SignupController.php
    on line 19

Call Stack:
    0.0383     654600   1. {main}() /app//public/index.php:0
    0.0392     663864   2. Phalcon\Mvc\Application->handle()
        /app/public/index.php:37
    0.0418     738848   3. SignupController->registerAction()
        /app/public/index.php:0
    0.0419     740144   4. xdebug_print_function_stack()
        /app/app/controllers/SignupController.php:19
```

Xdebug proporciona varias formas de obtener información de depuración y rastreo con respecto a la ejecución de su aplicación utilizando Phalcon. Puede comprobar la [documentación de XDebug](https://xdebug.org/docs) para obtener más información.

Puede revisar este articulo para [configurar XDebug en PHPStorm](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html).
