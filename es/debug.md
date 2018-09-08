<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Depuración de aplicaciones</a> 
      <ul>
        <li>
          <a href="#catching-exceptions">Capturando excepciones</a>
        </li>
        <li>
          <a href="#debug-component">Componente de depuración</a>
        </li>
        <li>
          <a href="#reflection-introspection">Reflexión e introspección</a>
        </li>
        <li>
          <a href="#using-xdebug">Usando Xdebug</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Depuración de aplicaciones

![](/images/content/xdebug-1.jpg)

PHP ofrece herramientas para depurar aplicaciones con avisos, advertencias, errores y excepciones. La [clase de excepción](http://www.php.net/manual/en/language.exceptions.php) ofrece información como archivo, línea, mensaje, código numérico, backtrace etcétera en donde se produjo un error. Los frameworks orientados a objetos como Phalcon principalmente utilizan esta clase para encapsular esta funcionalidad y proporcionar información al desarrollador o el usuario.

A pesar de estar escrito en C, que Phalcon ejecuta métodos en el espacio de usuario de PHP, proporcionando la capacidad de depuración al igual que cualquier otra aplicación o framework escrito en PHP.

<a name='catching-exceptions'></a>

## Capturando excepciones

A lo largo de los tutoriales y ejemplos de la documentación de Phalcon, hay un elemento común que es la captura de excepciones. Se trata de un bloque try/catch:

```php
<?php

try {

    // ... Algún código Phalcon/PHP

} catch (\Exception $e) {

}
```

Cualquier excepción lanzada dentro del bloque es capturada en la variable `$e`. Una `Phalcon\Exception` extiende de la clase [Exception](http://www.php.net/manual/en/language.exceptions.php) de PHP y se utiliza para entender si la excepción vino de Phalcon o de PHP.

Todas las excepciones generadas por PHP se basan en la clase [Exception](http://www.php.net/manual/en/language.exceptions.php) y tienen, por lo menos, los siguientes elementos:

```php
<?php

class Exception
{
    /* Propiedades */
    protected string $message;
    protected int $code;
    protected string $file;
    protected int $line;

    /* Métodos */
    public __construct ([ string $message = '' [, int $code = 0 [, Exception $previous = NULL ]]])
    final public string getMessage ( void )
    final public Exception getPrevious ( void )
    final public mixed getCode ( void )
    final public string getFile ( void )
    final public int getLine ( void )
    final public array getTrace ( void )
    final public string getTraceAsString ( void )
    public string __toString ( void )
    final private void __clone ( void )
}
```

Recuperar información de `Phalcon\Exception` es lo mismo que en la clase [Exception](http://www.php.net/manual/en/language.exceptions.php) de PHP:

```php
<?php

try {

    // ... Código de la aplicación ...

} catch (\Exception $e) {
    echo get_class($e), ': ', $e->getMessage(), '\n';
    echo ' Archivo=', $e->getFile(), '\n';
    echo ' Linea=', $e->getLine(), '\n';
    echo $e->getTraceAsString();
}
```

Por lo tanto es fácil de encontrar que archivo y línea de código de la aplicación generaron la excepción, así como los componentes implicados en la generación de la misma:

```html
PDOException: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost'
    (using password: NO)
 Archivo=/Applications/MAMP/htdocs/invo/public/index.php
 Linea=74
#0 [internal function]: PDO->__construct('mysql:host=loca...', 'root', '', Array)
#1 [internal function]: Phalcon\Db\Adapter\Pdo->connect(Array)
#2 /Applications/MAMP/htdocs/invo/public/index.php(74):
    Phalcon\Db\Adapter\Pdo->__construct(Array)
#3 [internal function]: {closure}()
#4 [internal function]: call_user_func_array(Object(Closure), Array)
#5 [internal function]: Phalcon\Di->_factory(Object(Closure), Array)
#6 [internal function]: Phalcon\Di->get('db', Array)
#7 [internal function]: Phalcon\Di->getShared('db')
#8 [internal function]: Phalcon\Mvc\Model->getConnection()
#9 [internal function]: Phalcon\Mvc\Model::_getOrCreateResultset('Users', Array, true)
#10 /Applications/MAMP/htdocs/invo/app/controllers/SessionController.php(83):
    Phalcon\Mvc\Model::findFirst('email='demo@pha...')
#11 [internal function]: SessionController->startAction()
#12 [internal function]: call_user_func_array(Array, Array)
#13 [internal function]: Phalcon\Mvc\Dispatcher->dispatch()
#14 /Applications/MAMP/htdocs/invo/public/index.php(114): Phalcon\Mvc\Application->handle()
#15 {main}
```

Como se puede ver en la salida anterior, las clases de Phalcon y los métodos son mostrados al igual que cualquier otro componente e incluso muestra los parámetros que se invocaron en cada llamada. Si es necesario, el método [Exception::getTrace](http://www.php.net/manual/en/exception.gettrace.php) proporciona información adicional.

<a name='debug-component'></a>

## Componente de depuración

Phalcon proporciona un componente de depuración que permite al desarrollador encontrar fácilmente los errores producidos en una aplicación creada con el framework.

El siguiente video tutorial explica cómo funciona:

<div align='center'>
    <iframe src='//player.vimeo.com/video/68893840' width='500' height='313' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

Para habilitarlo, añada lo siguiente a su archivo de arranque:

```php
<?php

$debug = new \Phalcon\Debug();
$debug->listen();
```

Cualquier bloque Try/Catch debe eliminarse o inhabilitarse para que este componente funcione correctamente.

<a name='reflection-introspection'></a>

## Reflexión e introspección

Cualquier instancia de una clase de Phalcon ofrece exactamente el mismo comportamiento que un PHP normal. Es posible usar la [API de reflexión](http://php.net/manual/en/book.reflection.php) o simplemente imprimir cualquier objeto para mostrar cómo es su estado interno:

```php
<?php

$router = new Phalcon\Mvc\Router();
print_r($router);
```

Es fácil conocer el estado interno de un objeto. El ejemplo anterior imprime lo siguiente:

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

<a name='using-xdebug'></a>

## Usando Xdebug

[Xdebug](http://xdebug.org) es una increíble herramienta que complementa la depuración de aplicaciones PHP. También es una extensión de C para PHP, y se puede utilizar junto con Phalcon sin configuración adicional o efectos secundarios.

El siguiente video tutorial muestra una sesión de Xdebug con Phalcon:

<div align='center'>
    <iframe src='//player.vimeo.com/video/69867342' width='500' height='313' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

Una vez que xdebug esta instalado, puede utilizar su API para obtener una información más detallada sobre las excepciones y los mensajes.

<div class="alert alert-warning">
    <p>
        Le recomendamos utilizar la última versión de Xdebug para una mejor compatibilidad con Phalcon.
    </p>
</div>

En el ejemplo siguiente se implementa [xdebug_print_function_stack](http://xdebug.org/docs/stack_trace) para detener la ejecución y generar una traza inversa:

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
        // Obtener variables desde un formulario HTML
        $name  = $this->request->getPost('name', 'string');
        $email = $this->request->getPost('email', 'email');

        // Detener la ejecución y mostrar una traza inversa
        return xdebug_print_function_stack('stop here!');

        $user        = new Users();
        $user->name  = $name;
        $user->email = $email;

        // Almacenar y comprobar errores
        $user->save();
    }
}
```

En este caso, Xdebug también nos mostrará las variables en el ámbito local y una traza inversa como la siguiente:

```html
Xdebug: stop here! in /Applications/MAMP/htdocs/tutorial/app/controllers/SignupController.php
    on line 19

Call Stack:
    0.0383     654600   1. {main}() /Applications/MAMP/htdocs/tutorial/public/index.php:0
    0.0392     663864   2. Phalcon\Mvc\Application->handle()
        /Applications/MAMP/htdocs/tutorial/public/index.php:37
    0.0418     738848   3. SignupController->registerAction()
        /Applications/MAMP/htdocs/tutorial/public/index.php:0
    0.0419     740144   4. xdebug_print_function_stack()
        /Applications/MAMP/htdocs/tutorial/app/controllers/SignupController.php:19
```

Xdebug proporciona varias formas de obtener información de depuración y rastreo con respecto a la ejecución de su aplicación utilizando Phalcon. Puede comprobar la [documentación de XDebug](http://xdebug.org/docs) para obtener más información.