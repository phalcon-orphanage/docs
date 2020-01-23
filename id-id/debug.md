---
layout: default
language: 'id-id'
version: '4.0'
title: 'Debug'
keywords: 'debug, debugging, error handling'
---

# Debug

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

![](/assets/images/content/xdebug-1.jpg)

PHP offers tools to debug applications with notices, warnings, errors and exceptions. The [Exception class](https://secure.php.net/manual/en/language.exceptions.php) offers information such as the file, line, message, numeric code, backtrace etc. of where an error occurred. OOP frameworks like Phalcon mainly use this class to encapsulate this functionality and provide information back to the developer or user.

Despite being written in C, Phalcon executes methods in the PHP userland, providing the same debugging capabilities as other PHP based frameworks offer.

## Exceptions

A very common way to control the flow of errors in your application (intentional or otherwise) is to use a `try`/`catch` block to catch exceptions. There are plenty of examples in our documentation demonstrating such blocks.

```php
<?php

try {

    // ... 

} catch (\Exception $ex) {

}
```

Any exception thrown within the block is captured in the variable `$ex`. A [Phalcon\Exception](api/Phalcon_Exception) extends the PHP [Exception class](https://secure.php.net/manual/en/language.exceptions.php). Using the Phalcon exception allows you to distinguish whether the exception was thrown from Phalcon related code or elsewhere.

The [Exception class](https://secure.php.net/manual/en/language.exceptions.php), exposes the following:

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

You can use the same method calls when using the [Phalcon\Exception](api/Phalcon_Exception):

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

It's therefore easy to find which file and line of the application's code generated the exception, as well as the components involved in generating the exception:

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

As demonstrated above, it does not matter that Phalcon is compiled as a PHP extension. The exception information contains parameters and method calls that were involved in the call that generated the exception fragment above. [Exception::getTrace()](https://secure.php.net/manual/en/exception.gettrace.php) provides additional information if necessary.

## Constructor

[Phalcon\Debug](api/phalcon_debug#debug) provides visual aids as well as additional information for developers to easily locate errors produced in an application.

> **NOTE** Please make sure that this component is not used in production environments, as it can reveal information about your server to attackers
{: .alert .alert-danger }

The following screencast explains how it works:

<div align='center'>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Mk5ObSQmGpQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

To enable it, add the following to your bootstrap:

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen();
```

or using a shorter syntax:

```php
<?php

(new \Phalcon\Debug())->listen();
```

> **NOTE**: Any `try`/`catch` blocks must be removed or disabled to make this component work properly.
{: .alert .alert-warning }

By default the component will listen for uncaught exceptions but not low severity errors (warnings, notices etc.). You can modify this behavior by passing relevant parameters in `listen()`

- `exceptions` - boolean 
- `lowSeverity` - boolean

In the example below, do not listen to uncaught exceptions but listen to non silent notices or warnings (low severity):

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen(false, true);
```

If your application flow is different, or do not wish to pass the parameters on `listen()`, you can always use `listenExceptions()` and `listenLowSeverity()`:

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug
    ->listenExceptions()
    ->listenLowSeverity()
    ->listen();
```

> **NOTE**: The `listenExceptions()` and `listenLowSeverity()` are **ON** switches. If you wish to switch listening to exceptions or low severity errors **OFF** you need to pass `false` in the `listen()` method.
{: .alert .alert-info } 

## Getters

There are a few getters available that offer information about the component. Extending those could also change the behavior of the component visually. - `getCssSources()` - `string` Returns the stylesheets used to display the contents on screen - `getJsSources()` - `string` Returns the javascript files used to display the contents on screen - `getVersion()` - `string` Returns the link to the current version documentation

Extending the component and overriding the `getCssSources()` for instance to return different CSS HTML directives will change the appearance of the output on screen. The output CSS classes are based on [Bootstrap CSS](https://getbootstrap.com/).

## Setters

[Phalcon\Debug](api/phalcon_debug#debug) also offers some setters to better customize the output when an error occurs in your application.

- `setShowBackTrace(bool $showBackTrace)` - Show/hide the exception's backtrace
- `setShowFileFragment(bool $showFileFragment)` - Show/Hide the file fragment in the output (related to the exception)
- `setShowFiles(bool $showFiles)` - Show/Hide the files in the backtrace
- `setUri(string $uri)` - The base URI for static resources (see also the Getters section for customization of the component)

## Variables

You can also use the `debugVar()` method, to inject any additional variables you want to present in the output. These are usually application specific variables. An example might be to show timing information for your application.

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$time = time();
$debug
    ->debugVar('time', $time)
    ->listen();
```

To clear the variable stack, you can call `clearVars()`.

Finally you can halt execution of your application and trigger showing a backtrace by calling `halt()`

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

## Blacklisting Output

As mentioned above, the component **must not** be enabled in production environments. Since Phalcon cannot control this behavior, there is a built-in blacklisting feature that allows the developer to blacklist certain pieces of information that they do not wish to be displayed on screen, just in case. These are elements of the `$_REQUEST` and `$_SERVER` arrays.

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

In the example above, we will never show the element `some` from the `$_REQUEST` as well as the `hostmane` from `$_SERVER`. You can always add more elements not to be displayed, that exist in these two superglobals. This is particularly useful in case you forget to disable the component in your production environment. It is bad practice to leave it enabled but if you forget, at least certain key pieces of information about your host will not be visible to potential hackers.

> **NOTE**: The keys of the array elements to be hidden are case insensitive
{: .alert .alert-info }

## Handlers

In order to catch exceptions and low severity errors, [Phalcon\Debug](api/phalcon_debug#debug) makes use of `onUncaughtException()` and `onUncaughtLowSeverity()`. Most developers that use this component will never need to extend these methods. However, if you wish you can do so by extending the component and overriding these methods to manipulate the exception and return the output you require.

These two methods are being set as exception handlers using PHP's [set_exception_handler](https://www.php.net/manual/en/function.set-exception-handler.php). When calling `listenExceptions()` the `onUncaughtException()` is registered, while when calling `listenLowSeverity()` the `onUncaughtLowSeverity` is registered.

## Reflection and Introspection

Phalcon classes do not differ from any other PHP classes and therefore you can use the [Reflection API](https://php.net/manual/en/book.reflection.php) or simply print any object to display its contents and state:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

print_r($router);
```

The above example prints the following:

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

## XDebug

[XDebug](https://xdebug.org) is an amazing tool that complements the debugging of PHP applications. It is also a C extension for PHP, and you can use it together with Phalcon without additional configuration or side effects.

Once you have xdebug installed, you can use its API to get a more detailed information about exceptions and messages.

> **NOTE**: We highly recommend using the latest version of XDebug for a better compatibility with Phalcon
{: .alert .alert-warning }

The following example implements [xdebug_print_function_stack](https://xdebug.org/docs/stack_trace) to stop the execution and generate a backtrace:

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

For the above example, Xdebug will also show us the variables in the local scope as well as a backtrace:

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

Xdebug offers several ways to get debug and trace information regarding the execution of your application using Phalcon. You can check the [XDebug documentation](https://xdebug.org/docs) for more information.

To set up Xdebug for PHPStorm you can check [this](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html) article.