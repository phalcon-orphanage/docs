---
layout: default
language: 'ko-kr'
version: '4.0'
title: '디버그'
keywords: 'debug, debugging, error handling, 디버그, 디버깅, 오류, 오류처리, 에러'
---

# 디버그

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요

![](/assets/images/content/xdebug-1.jpg)

PHP는 알림, 경고, 오류와 예외 등으로 어플리케이션을 디버그 할 수 있는 도구를 제공합니다. [Exception 클래스](https://secure.php.net/manual/en/language.exceptions.php) 는 파일, 라인, 메시지, 숫자로된 코드, 백트레이스 등 오류가 발생한 곳의 정보를 제공합니다. Phalcon과 같은 OOP 프레임워크는 이 기능을 캡슐화 하고 개발자나 사용자에게 정보를 제공하기 위해 주로 이 클래스를 사용합니다.

Phalcon은 C 로 작성되어 있지만, 다른 PHP기반의 프레임워크가 제공하는 것과 동일한 디버깅 기능의 메서드를 PHP 사용자 환경 하에서 실행합니다.

## 예외처리

어플리케이션에서 오류의 흐름을 제어하는 가장 일반적인 방법은(의도적이든 아니든) 예외처리를 위해 `try`/`catch` 블록을 이용하는 것입니다. 문서에서는 이러한 블록의 예시를 풍부하게 담고 있습니다.

```php
<?php

try {

    // ... 

} catch (\Exception $ex) {

}
```

블록 내에서 throw 된 모든 예외는 `$ex` 변수에 저장됩니다. [Phalcon\Exception](api/Phalcon_Exception) 은 [Exception 클래스](https://secure.php.net/manual/en/language.exceptions.php)를 확장시킨 클래스입니다. 이 Phalcon 의 exception을 사용하면 Phalcon에서 예외가 발생했는지 혹은 다른곳에서 발생했는지 구분할 수 있도록 해 줍니다.

[Exception 클래스는](https://secure.php.net/manual/en/language.exceptions.php) 다음의 메서드를 사용할 수 있습니다:

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

[Phalcon\Exception](api/Phalcon_Exception) 을 사용해서 동일한 메서드를 호출 할 수 있습니다:

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

As demonstrated above, it does not matter that Phalcon is compiled as a PHP extension. 예외에 대한 정보는 예외를 발생시킨 부분과 관련된 파라미터와 메서드 호출에 대한 정보를 포함하고 있습니다. 필요한 경우 [Exception::getTrace()](https://secure.php.net/manual/en/exception.gettrace.php) 가 추가적인 정보를 제공합니다.

## 생성자

[Phalcon\Debug](api/phalcon_debug#debug) 클래스는 개발자가 어플리케이션에서 발생한 오류를 쉽게 찾을 수 있도록 추가 정보를 제공할 뿐만 아니라 시각적인 보조도구도 제공합니다..

> **주의** 해커들에게 서버에 대한 정보를 노출할 수 있기 때문에 운영(production)환경에서는 이 컴포넌트를 사용하지 않도록 주의 해주시기 바랍니다.
{: .alert .alert-danger }

어떻게 동작하는지에 대한 설명은 다음 스크린캐스트를 참고해 주세요:

<div align='center'>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Mk5ObSQmGpQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

활성화 하려면, 부트스트랩 파일에 다음 내용을 추가하세요:

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen();
```

혹은:

```php
<?php

(new \Phalcon\Debug())->listen();
```

> **주의**: 이 컴포넌트가 정상적으로 동작하기 위해서는 모든 `try`/`catch` 블록을 제거하거나 비활성화 시켜야 합니다.
{: .alert .alert-warning }

심각도가 낮은 오류(경고, 알림 등) 를 제외한 처리되지 않은 예외를 컴포넌트가 감지하는 것이 기본값입니다. 관련 파라미터를 `listen()` 함수에 넘겨줘서 이 동작을 수정할 수 있습니다.

- `exceptions` - boolean 
- `lowSeverity` - boolean

아래의 예제는, 처리되지 않은 예외를 감지하는 것 대신에 (심각도가 낮은) 알림/경고를 감지하도록 수정한 예입니다.

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen(false, true);
```

어플리케이션의 흐름이 다르거나 `listen()`에 파라미터를 넘기지 않기를 원하신다면, `listenExceptions()` 와 `listenLowSeverity()`를 이용하실 수 있습니다:

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug
    ->listenExceptions()
    ->listenLowSeverity()
    ->listen();
```

> **주의**: `listenExceptions()` 와 `listenLowSeverity()` 는 **ON** 스위치입니다. 예외나 저심각도 오류에 대한 감지를 **OFF** 하고자 하신다면 `listen()` 메서드에 `false` 값을 넘겨주셔야 합니다.
{: .alert .alert-info } 

## Getters

컴포넌트에 대한 정보를 제공하는 몇개의 getter 를 사용할 수 있습니다. 이들을 확장해서 컴포넌트의 동작을 시각적으로 변경하실 수도 있습니다. - `getCssSources()` - `string` 화면에 컨텐츠를 표시하는데 사용되는 스타일시트를 반환 - `getJsSources()` - `string` 화면에 컨텐츠를 표시하는데 사용되는 자바스크립트를 반환 - `getVersion()` - `string` 현재 버전문서의 링크를 반환

예를 들어 이 컴포넌트를 확장해서 다른 CSS HTML 지시자를 반환하도록 `getCssSources()` 를 재정의(overriding) 하면 화면에 표시되는 모습이 바뀌게 되겠지요. 출력되는 CSS클래스는 [Bootstrap CSS](https://getbootstrap.com/) 기반입니다.

## Setters

또한 [Phalcon\Debug](api/phalcon_debug#debug) 클래스는 어플리케이션에서 오류가 발생했을 때, 출력되는 내용을 입맛에 맞게 개선할 수 있도록 몇개의 setter를 제공합니다..

- `setShowBackTrace(bool $showBackTrace)` - 예외의 백트레이스 표시여부 제어
- `setShowFileFragment(bool $showFileFragment)` - 파일의 내용(예외와 관련된) 의 화면출력여부 제어
- `setShowFiles(bool $showFiles)` - 백트레이스에서 파일 표시여부 제어
- `setUri(string $uri)` - 정적 리소스들에 대한 base URI (컴포넌트의 커스터마이즈는 Getters 섹션을 참조)

## 변수

`debugVar()` 메서드를 이용하면, 출력 시 같이 표시하고 싶은 추가적인 변수들을 지정할 수도 있습니다. 이 변수들은 주로 어플리케이션에 특정된 변수들입니다. 다음 예제는 어플리케이션에서 동작시간 관련정보를 보여줄 수 있습니다.

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$time = time();
$debug
    ->debugVar('time', $time)
    ->listen();
```

`clearVars()` 를 호출해서 변수 스택을 초기화 할 수 있습니다.

마지막으로 `halt()` 를 호출함으로써 어플리케이션의 실행을 멈추고 백트레이스를 표시하도록 할 수 있습니다.

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

## 출력내용 선별제외(블랙리스트)

위에서 언급한 바와 같이, 이 컴포넌트는 **절대** 운영환경에서는 활성화 하시면 안됩니다. 이 동작을 제어할 수 없기 때문에 Phalcon은, 만일의 상황을 대비해서, 화면에 표시되면 안되는 특정 정보를 개발자가 지정해서 최종출력시 제외하는 블랙리스팅 기능이 기본적으로 내장되어 있습니다. 이들은 주로 `$_REQUEST` 와 `$_SERVER` 배열값이 대상이 되겠지요.

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

위의 예시에서는, `$_REQUEST`에서 `some` 값 과 `$_SERVER` 의 `hostmane` 값을 보여주지 않도록 합니다. 당연히 이 두 전역변수 배열 내에 존재하는 값이 출력되지 않도록 얼마든지 추가할 수 있습니다. 운영환경에서 컴포넌트 비활성화 하는것을 깜빡한 경우 특히 유용한 사례가 되겠습니다. 하지만 이런걸 깜빡하는 것은 좋지 않은 습관이므로, 최소한 호스트에서 특정 주요 정보는 잠재적 해커에게 결코 노출되지 않도록 하는것이 필요합니다.

> **주의**: 감추고자 하는 배열 요소의 키 값은 대소문자를 구분함
{: .alert .alert-info }

## 핸들러

예외와 심각도 낮은 오류를 처리하기 위해, [Phalcon\Debug](api/phalcon_debug#debug) 클래스는 `onUncaughtException()` 과 `onUncaughtLowSeverity()` 를 사용합니다. 이 컴포넌트를 사용하는 대부분의 개발자는 이 메서드들을 확장시킬 필요가 없을 것입니다. 하지만, 필요한 경우 컴포넌트를 상속받아 이 메서드들을 재정의 해서 예외를 처리하고 원하는 출력을 반환할 수 있습니다.

이 두개의 메서드는 PHP의 [set_exception_handler](https://www.php.net/manual/en/function.set-exception-handler.php) 를 사용해서 예외처리기(exception handlers)로 설정하게 됩니다. `listenExceptions()`를 호출 시, `onUncaughtException()` 이벤트가 등록되고, `listenLowSeverity()` 호출하면 `onUncaughtLowSeverity` 이벤트가 등록됩니다..

## Reflection과 Introspection

Phalcon 클래스는 일반적인 PHP 클래스와 다르지 않기 때문에 [Reflection API](https://php.net/manual/en/book.reflection.php) 의 사용 혹은 단순한 출력 명령으로도 어떤 객체든 그 내용과 상태를 알 수 있습니다:

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

## XDebug

[XDebug](https://xdebug.org) 는 PHP 어플리케이션 디버깅의 불편한 점들을 보완해 주는 놀라운 도구입니다. Xdebug 도 PHP의 C 익스텐션이며, 별도의 설정이나 부작용 없이 Phalcon과 함께 사용할 수 있습니다.

Xdebug를 설치하고 나면, 제공하는 API를 통해 예외와 메시지에 대한 더 자세한 정보를 확인할 수 있습니다.

> **주의**: Phalcon과의 더 나은 호환성을 위해 가장 최신 버전의 Xdebug 사용을 강력히 권합니다.
{: .alert .alert-warning }

아래의 코드는 실행을 중단하고 백트레이스를 생성할 수 있는 [xdebug_print_function_stack](https://xdebug.org/docs/stack_trace) 기능을 적용한 예입니다:

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

Xdebug는 Phalcon을 이용한 어플리케이션 실행 시, 디버깅 및 트레이스 정보를 얻는 몇가지 방법을 제공합니다. 더 자세한 정보는 [XDebug 문서](https://xdebug.org/docs) 를 참조하세요.

PHPStorm 에서 Xdebug를 사용하시려면 [여기](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html) 글을 참조하세요.