---
layout: default
language: 'ko-kr'
version: '5.0'
title: '디버그'
upgrade: '#support-debug'
keywords: 'debug, debugging, error handling, 디버그, 디버깅, 오류, 오류처리, 에러'
---

# 디버그
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요

![](/assets/images/content/xdebug-1.jpg)

PHP는 알림, 경고, 오류와 예외 등으로 어플리케이션을 디버그 할 수 있는 도구를 제공합니다. The [Exception class][exception] offers information such as the file, line, message, numeric code, backtrace etc. of where an error occurred. Phalcon과 같은 OOP 프레임워크는 이 기능을 캡슐화 하고 개발자나 사용자에게 정보를 제공하기 위해 주로 이 클래스를 사용합니다.

Phalcon은 C 로 작성되어 있지만, 다른 PHP기반의 프레임워크가 제공하는 것과 동일한 디버깅 기능의 메서드를 PHP 사용자 환경 하에서 실행합니다.

## Exceptions
어플리케이션에서 오류의 흐름을 제어하는 가장 일반적인 방법은(의도적이든 아니든) 예외처리를 위해 `try`/`catch` 블록을 이용하는 것입니다. 문서에서는 이러한 블록의 예시를 풍부하게 담고 있습니다.

```php
<?php

try {

    // ... 

} catch (\Exception $ex) {

}
```

블록 내에서 throw 된 모든 예외는 `$ex` 변수에 저장됩니다. A [Phalcon\Support\Debug\Exception][phalcon-exception] extends the PHP [Exception class][exception]. 이 Phalcon 의 exception을 사용하면 Phalcon에서 예외가 발생했는지 혹은 다른곳에서 발생했는지 구분할 수 있도록 해 줍니다.

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

그래서 어느 파일의 몇번째 줄에서 어플리케이션의 코드가 예외를 발생시켰는지, 또한 발생한 예외에 어느 컴포넌트가 관련되어 있는지를 쉽게 찾을 수 있습니다.

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

As demonstrated above, it does not matter that Phalcon is compiled as a PHP extension. 예외에 대한 정보는 예외를 발생시킨 부분과 관련된 파라미터와 메서드 호출에 대한 정보를 포함하고 있습니다. [Exception::getTrace()][exception_gettrace] provides additional information if necessary.

## Constructor
[Phalcon\Support\Debug][debug] provides visual aids as well as additional information for developers to easily locate errors produced in an application.

> **NOTE** Please make sure that this component is not used in production environments, as it can reveal information about your server to attackers 
> 
> {: .alert .alert-danger }

어떻게 동작하는지에 대한 설명은 다음 스크린캐스트를 참고해 주세요:

<div align='center'>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Mk5ObSQmGpQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

활성화 하려면, 부트스트랩 파일에 다음 내용을 추가하세요:

```php
<?php

use Phalcon\Support\Debug;

$debug = new Debug();

$debug->listen();
```

혹은:

```php
<?php

(new Phalcon\Support\Debug())->listen();
```

> **NOTE**: Any `try`/`catch` blocks must be removed or disabled to make this component work properly. 
> 
> {: .alert .alert-warning }

By default, the component will listen for uncaught exceptions but not low severity errors (warnings, notices etc.). 관련 파라미터를 `listen()` 함수에 넘겨줘서 이 동작을 수정할 수 있습니다.

- `exceptions` - bool
- `lowSeverity` - bool

In the example below, do not listen to uncaught exceptions but listen to non-silent notices or warnings (low severity):

```php
<?php

use Phalcon\Support\Debug;

$debug = new Debug();

$debug->listen(false, true);
```

어플리케이션의 흐름이 다르거나 `listen()`에 파라미터를 넘기지 않기를 원하신다면, `listenExceptions()` 와 `listenLowSeverity()`를 이용하실 수 있습니다:

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
컴포넌트에 대한 정보를 제공하는 몇개의 getter 를 사용할 수 있습니다. 이들을 확장해서 컴포넌트의 동작을 시각적으로 변경하실 수도 있습니다.

| Method            | Returns  | Description                                                         |
| ----------------- | -------- | ------------------------------------------------------------------- |
| `getCssSources()` | `string` | Returns the stylesheets used to display the contents on screen      |
| `getJsSources()`  | `string` | Returns the javascript files used to display the contents on screen |
| `getVersion()`    | `string` | Returns the link to the current version documentation               |

예를 들어 이 컴포넌트를 확장해서 다른 CSS HTML 지시자를 반환하도록 `getCssSources()` 를 재정의(overriding) 하면 화면에 표시되는 모습이 바뀌게 되겠지요. The output CSS classes are based on [Bootstrap CSS][bootstrap].

## Setters
[Phalcon\Support\Debug][debug] also offers some setters to better customize the output when an error occurs in your application.

| Method                                        | Description                                                                                         |
| --------------------------------------------- | --------------------------------------------------------------------------------------------------- |
| `setShowBackTrace(bool $showBackTrace)`       | Show/hide the exception's backtrace                                                                 |
| `setShowFileFragment(bool $showFileFragment)` | Show/Hide the file fragment in the output (related to the exception)                                |
| `setShowFiles(bool $showFiles)`               | Show/Hide the files in the backtrace                                                                |
| `setUri(string $uri)`                         | The base URI for static resources (see also the Getters section for customization of the component) |

## 변수
`debugVar()` 메서드를 이용하면, 출력 시 같이 표시하고 싶은 추가적인 변수들을 지정할 수도 있습니다. 이 변수들은 주로 어플리케이션에 특정된 변수들입니다. 다음 예제는 어플리케이션에서 동작시간 관련정보를 보여줄 수 있습니다.

```php
<?php

use Phalcon\Support\Debug;

$debug = new Debug();

$time = time();
$debug
    ->debugVar('time', $time)
    ->listen();
```

`clearVars()` 를 호출해서 변수 스택을 초기화 할 수 있습니다.

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

## 출력내용 선별제외(블랙리스트)
As mentioned above, the component **must not** be enabled in production environments. 이 동작을 제어할 수 없기 때문에 Phalcon은, 만일의 상황을 대비해서, 화면에 표시되면 안되는 특정 정보를 개발자가 지정해서 최종출력시 제외하는 블랙리스팅 기능이 기본적으로 내장되어 있습니다. 이들은 주로 `$_REQUEST` 와 `$_SERVER` 배열값이 대상이 되겠지요.

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

In the example above, we will never show the element `some` from the `$_REQUEST` as well as the `hostname` from `$_SERVER`. You can always add more elements not to be displayed, that exist in these two super-globals. 운영환경에서 컴포넌트 비활성화 하는것을 깜빡한 경우 특히 유용한 사례가 되겠습니다. 하지만 이런걸 깜빡하는 것은 좋지 않은 습관이므로, 최소한 호스트에서 특정 주요 정보는 잠재적 해커에게 결코 노출되지 않도록 하는것이 필요합니다.

> **NOTE**: The keys of the array elements to be hidden are case-insensitive 
> 
> {: .alert .alert-info }

## Handlers
In order to catch exceptions and low severity errors, [Phalcon\Support\Debug][debug] makes use of `onUncaughtException()` and `onUncaughtLowSeverity()`. 이 컴포넌트를 사용하는 대부분의 개발자는 이 메서드들을 확장시킬 필요가 없을 것입니다. 하지만, 필요한 경우 컴포넌트를 상속받아 이 메서드들을 재정의 해서 예외를 처리하고 원하는 출력을 반환할 수 있습니다.

These two methods are being set as exception handlers using PHP's [set_exception_handler][set_exception_handler]. `listenExceptions()`를 호출 시, `onUncaughtException()` 이벤트가 등록되고, `listenLowSeverity()` 호출하면 `onUncaughtLowSeverity` 이벤트가 등록됩니다..

## Reflection과 Introspection
Phalcon classes do not differ from any other PHP classes, and therefore you can use the [Reflection API][reflection_api] or simply print any object to display its contents and state:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

print_r($router);
```

위의 예제는 다음과 같은 내용을 출력합니다:

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
[Xdebug][xdebug] is an amazing tool that complements the debugging of PHP applications. Xdebug 도 PHP의 C 익스텐션이며, 별도의 설정이나 부작용 없이 Phalcon과 함께 사용할 수 있습니다.

Once you have Xdebug installed, you can use its API to get a more detailed information about exceptions and messages.

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

위의 예제에서 Xdebug는, 백트레이스와 함께 로컬범위의 변수도 보여줍니다.

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

Xdebug는 Phalcon을 이용한 어플리케이션 실행 시, 디버깅 및 트레이스 정보를 얻는 몇가지 방법을 제공합니다. You can check the [XDebug documentation][xdebug_docs] for more information.

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
