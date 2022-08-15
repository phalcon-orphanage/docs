---
layout: default
language: 'es-es'
version: '5.0'
title: 'Depuración'
upgrade: '#support-debug'
keywords: 'debug, debugging, error handling, depuración'
---

# Depuración
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen

![](/assets/images/content/xdebug-1.jpg)

PHP ofrece herramientas para depurar aplicaciones con avisos, advertencias, errores y excepciones. The [Exception class][exception] offers information such as the file, line, message, numeric code, backtrace etc. of where an error occurred. Los *frameworks* orientados a objetos como Phalcon principalmente utilizan esta clase para encapsular esta funcionalidad y proporcionar información al desarrollador o el usuario.

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

Cualquier excepción lanzada dentro del bloque es capturada en la variable `$ex`. A [Phalcon\Support\Debug\Exception][phalcon-exception] extends the PHP [Exception class][exception]. El uso de la excepción de Phalcon le permite distinguir si la excepción fue lanzada desde el código relacionado con Phalcon o en otros lugares.

The [Exception class][exception], exposes the following:

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

    public function __toString(): string;

    final public function getCode(): int;

    final public function getFile(): string;

    final public function getLine(): int;

    final public function getMessage(): string;

    final public function getPrevious(): Exception;

    final public function getTrace(): array;

    final public function getTraceAsString(): string;

    final private function __clone(): void;
}
```

You can use the same method calls when using the [Phalcon\Support\Debug\Exception][phalcon-exception]:

```php
<?php

use Phalcon\Support\Debug\Exception;

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

Como se ha demostrado anteriormente, no importa que Phalcon esté compilado como una extensión de PHP. La información de excepción contiene parámetros y llamadas a métodos que participaron en la llamada que generó el fragmento de excepción anterior. [Exception::getTrace()][exception_gettrace] provides additional information if necessary.

## Constructor
[Phalcon\Support\Debug][debug] provides visual aids as well as additional information for developers to easily locate errors produced in an application.

> **NOTE** Please make sure that this component is not used in production environments, as it can reveal information about your server to attackers 
> 
> {: .alert .alert-danger }

El siguiente video tutorial explica cómo funciona:

<div align='center'>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Mk5ObSQmGpQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

Para habilitarlo, añada lo siguiente a su archivo de arranque:

```php
<?php

use Phalcon\Support\Debug;

$debug = new Debug();

$debug->listen();
```

o usando una sintaxis más corta:

```php
<?php

(new Phalcon\Support\Debug())->listen();
```

> **NOTE**: Any `try`/`catch` blocks must be removed or disabled to make this component work properly. 
> 
> {: .alert .alert-warning }

By default, the component will listen for uncaught exceptions but not low severity errors (warnings, notices etc.). Puede modificar este comportamiento pasando parámetros relevantes en `listen()`

- `exceptions` - bool
- `lowSeverity` - bool

In the example below, do not listen to uncaught exceptions but listen to non-silent notices or warnings (low severity):

```php
<?php

use Phalcon\Support\Debug;

$debug = new Debug();

$debug->listen(false, true);
```

Si el flujo de su aplicación es diferente, o no desea pasar los parámetros en `listen()`, siempre puedes usar `listenExceptions()` y `listenLowSeverity()`:

```php
<?php

use Phalcon\Support\Debug;

$debug = new Debug();

$debug
    ->listenExceptions()
    ->listenLowSeverity()
    ->listen();
```

> **NOTE**: The `listenExceptions()` and `listenLowSeverity()` are **ON** switches. If you wish to switch listening to exceptions or low severity errors **OFF** you need to pass `false` in the `listen()` method. 
> 
> {: .alert .alert-info }

## Getters
Hay algunos *getters* disponibles que ofrecen información sobre el componente. Extender de estos también podría cambiar visualmente el comportamiento del componente.

| Método            | Devuelve | Descripción                                                         |
| ----------------- | -------- | ------------------------------------------------------------------- |
| `getCssSources()` | `string` | Returns the stylesheets used to display the contents on screen      |
| `getJsSources()`  | `string` | Returns the javascript files used to display the contents on screen |
| `getVersion()`    | `string` | Returns the link to the current version documentation               |

Extender del componente y sobrescribir el método `getCssSources()`, por ejemplo, para devolver diferentes directivas HTML CSS cambiará la apariencia de la salida en pantalla. The output CSS classes are based on [Bootstrap CSS][bootstrap].

## *Setters*
[Phalcon\Support\Debug][debug] also offers some setters to better customize the output when an error occurs in your application.

| Método                                        | Descripción                                                                                         |
| --------------------------------------------- | --------------------------------------------------------------------------------------------------- |
| `setShowBackTrace(bool $showBackTrace)`       | Show/hide the exception's backtrace                                                                 |
| `setShowFileFragment(bool $showFileFragment)` | Show/Hide the file fragment in the output (related to the exception)                                |
| `setShowFiles(bool $showFiles)`               | Show/Hide the files in the backtrace                                                                |
| `setUri(string $uri)`                         | The base URI for static resources (see also the Getters section for customization of the component) |

## Variables
También puede utilizar el método `debugVar()`, para inyectar cualquier variable adicional que desee presentar en la salida. Estas son generalmente variables específicas de aplicación. Un ejemplo podría ser mostrar información de tiempo para su aplicación.

```php
<?php

use Phalcon\Support\Debug;

$debug = new Debug();

$time = time();
$debug
    ->debugVar('time', $time)
    ->listen();
```

Para limpiar la pila de variables, puede llamar a `clearVars()`.

Finally, you can halt execution of your application and trigger showing a backtrace by calling `halt()`

```php
<?php

use Phalcon\Support\Debug;

$debug = new Debug();

$debug->listen();

// .....

if (12345 === $password) {
    $debug->halt();
}
```

## Salida de la lista negra
As mentioned above, the component **must not** be enabled in production environments. Dado que Phalcon no puede controlar este comportamiento, hay una función integrada de lista negra que permite al desarrollador hacer una lista negra de ciertas piezas de información que no se desean que se muestren en la pantalla, por si acaso. Estos son elementos de los arreglos `$_REQUEST` y `$_SERVER`.

```php
<?php

use Phalcon\Support\Debug;

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

En el ejemplo anterior, nunca mostraremos el elemento `some` del `$_REQUEST` así como el `hostname` de `$_SERVER`. You can always add more elements not to be displayed, that exist in these two super-globals. Esto es especialmente útil en caso de que olvide desactivar el componente en su entorno de producción. Es una mala práctica dejarlo habilitado, pero si lo olvida, al menos ciertas piezas clave de información sobre su *host* no serán visibles para los potenciales atacantes.

> **NOTE**: The keys of the array elements to be hidden are case-insensitive 
> 
> {: .alert .alert-info }

## Gestores
In order to catch exceptions and low severity errors, [Phalcon\Support\Debug][debug] makes use of `onUncaughtException()` and `onUncaughtLowSeverity()`. La mayoría de los desarrolladores que usan este componente nunca necesitarán extender estos métodos. Sin embargo, si lo desea puede hacerlo extendiendo el componente y sobreescribiendo estos métodos para manipular la excepción y devolver la salida que usted requiera.

These two methods are being set as exception handlers using PHP's [set_exception_handler][set_exception_handler]. Al llamar a `listenExceptions()` es registrado `onUncaughtException()`, mientras que al llamar a `listenLowSeverity()` es registrado `onUncaughtLowSeverity`.

## Reflexión e introspección
Phalcon classes do not differ from any other PHP classes, and therefore you can use the [Reflection API][reflection_api] or simply print any object to display its contents and state:

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
[Xdebug][xdebug] is an amazing tool that complements the debugging of PHP applications. También es una extensión de C para PHP, y se puede utilizar junto con Phalcon sin configuración adicional o efectos secundarios.

Una vez que Xdebug esta instalado, puede utilizar su API para obtener una información más detallada sobre las excepciones y los mensajes.

> **NOTE**: We highly recommend using the latest version of Xdebug for a better compatibility with Phalcon 
> 
> {: .alert .alert-warning }

The following example implements [xdebug_print_function_stack][xdebug_print_function_stack] to stop the execution and generate a backtrace:

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

Xdebug proporciona varias formas de obtener información de depuración y rastreo con respecto a la ejecución de su aplicación utilizando Phalcon. You can check the [XDebug documentation][xdebug_docs] for more information.

To set up Xdebug for PHPStorm you can check [this][phpstorm-xdebug] article.

[bootstrap]: https://getbootstrap.com/
[debug]: api/phalcon_debug#debug
[exception]: https://www.php.net/manual/en/language.exceptions.php
[exception_gettrace]: https://www.php.net/manual/en/exception.gettrace.php
[phalcon-exception]: api/phalcon_support##support-debug-exception
[phpstorm-xdebug]: https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html
[reflection_api]: https://php.net/manual/en/book.reflection.php
[set_exception_handler]: https://www.php.net/manual/en/function.set-exception-handler.php
[xdebug]: https://xdebug.org
[xdebug_print_function_stack]: https://xdebug.org/docs/stack_trace
[xdebug_docs]: https://xdebug.org/docs
