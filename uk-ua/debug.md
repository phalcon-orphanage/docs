---
layout: default
title: 'Відлагодження'
keywords: 'debug, debugging, error handling, відлагодження'
---

# Відлагодження
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Огляд

![](/assets/images/content/xdebug-1.jpg)

PHP пропонує інструменти для налагодження застосунків зі сповіщеннями, попередженнями, помилками та винятками. The [Exception class][exception] offers information such as the file, line, message, numeric code, backtrace etc. of where an error occurred. Фреймворки об'єктно-орієнтованого програмування на зразок Phalcon головним чином використовують цей клас, щоб прикріпити цю функціональність та надавати інформацію розробнику чи користувачеві.

Незважаючи на те, що він написаний у C, Phalcon виконує методи в PHP, забезпечуючи ті ж можливості, що й інші PHP-фреймворки.

## Exceptions
Дуже поширений спосіб керування потоком помилок у вашому застосунку (навмисне чи інакше) це використання поєднання `try`/`catch`, щоб відловити винятки. У нашій документації достатньо прикладів, що демонструють таке поєднання.

```php
<?php

try {

    // ... 

} catch (\Exception $ex) {

}
```

Будь-який виняток, виявлений завдяки цьому поєднанню, буде записано у змінній `$ex`. A [Phalcon\Exception][phalcon-exception] extends the PHP [Exception class][exception]. Використання винятків Phalcon дозволяє відрізнити чи їх спричинив код Phalcon, чи щось інше.

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

You can use the same method calls when using the [Phalcon\Exception][phalcon-exception]:

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

Досить легко знайти файл і рядок коду програми, що призвели до винятку, а також компоненти, які беруть участь у формуванні винятку:

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

Як продемонстровано вище, не має значення що Phalcon скомпільований як PHP-розширення. Інформація винятка містить параметри та виклики методів, які породжували фрагмент винятка вище. [Exception::getTrace()][exception_gettrace] provides additional information if necessary.

## Constructor
[Phalcon\Debug][debug] provides visual aids as well as additional information for developers to easily locate errors produced in an application.

> **NOTE** Please make sure that this component is not used in production environments, as it can reveal information about your server to attackers 
> 
> {: .alert .alert-danger }

Наступний демонстраційний ролик пояснює, як він працює:

<div align='center'>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Mk5ObSQmGpQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

Щоб активувати його, додайте до вашого bootstrap такий код:

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen();
```

або коротший синтаксис:

```php
<?php

(new \Phalcon\Debug())->listen();
```

> **NOTE**: Any `try`/`catch` blocks must be removed or disabled to make this component work properly. 
> 
> {: .alert .alert-warning }

За замовчуванням компонент буде слухати необроблені винятки, але не з низькою серйозністю помилки (попередження, повідомлення тощо). Ви можете змінити цю поведінку, передаючи відповідні параметри в `listen()`

- `exceptions` - boolean
- `lowSeverity` - boolean

У прикладі нижче не прослуховуються необроблені винятки, але слухаються сповіщення або попередження (низька серйозність):

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$debug->listen(false, true);
```

Якщо ваш потік додатку інший, або не хочете вказувати додаткові параметри у `listen()`, ви завжди можете використовувати `listenExceptions()` і `listenLowSeverity()`:

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
> 
> {: .alert .alert-info }

## Getters
Існує декілька збирачів, які надають інформацію про компонент. Розширюючи їх, можливо також змінити візуальну поведінку цього компонента.

- `getCssSources()` - `стрічка` повертає таблиці стилів, які використовуються для відображення вмісту на екрані`</li>
<li><code>getJsSources()` - `стрічка` повертає файли javascript, які використовуються для відображення вмісту на екрані
- `getVersion()` - `стрічка` повертає посилання на документацію поточної версії

Розширення компонента і перевизначення `getCssSources()`, наприклад, щоб повернути різні директиви CSS HTML, змінять зовнішній вигляд відображення на екрані. The output CSS classes are based on [Bootstrap CSS][bootstrap].

## Сетери (установлювачі)
[Phalcon\Debug][debug] also offers some setters to better customize the output when an error occurs in your application.

- `setShowBackTrace(bool $showBackTrace)` - показати/приховати зворотнє трасування винятку
- `setShowFileFragment(bool $showFileFragment)` - показати/приховати фрагмент файлу при відображенні (пов'язаний із винятком)
- `setShowFiles(bool $showFiles)` - показати/приховати файли у даних зворотного трасування
- `setUri(string $uri)` - базова URI для статичних ресурсів (також див. розділ Геттери (збирачі) для налаштування компонента)

## Змінні
Ви також можете використовувати метод `debugVar()` для внесення будь-яких додаткових змінних, які ви хочете показати у відображенні. Це зазвичай власні змінні додатка. Прикладом може бути показ часової інформації для вашого додатку.

```php
<?php

use \Phalcon\Debug;

$debug = new Debug();

$time = time();
$debug
    ->debugVar('time', $time)
    ->listen();
```

Щоб очистити стек змінних, можна викликати `clearVars()`.

Нарешті ви можете зупинити виконання вашого додатку і запустити показ інформації зворотного трасування викликом `halt()`

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

## Результат додавання до чорного списку
As mentioned above, the component **must not** be enabled in production environments. Оскільки Phalcon не може контролювати таку поведінку, є вбудована функція додавання у чорний список, яка дозволяє розробнику додавати до нього деякі частини інформації, які він не бажає, щоб відображались на екрані, про всяк випадок. Це елементи масивів `$_REQUEST` і `$_SERVER`.

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

У наведеному вище прикладі ми ніколи не показуватимемо змінну `some` із `$_REQUEST`, а також `hostname` з `$_SERVER`. Ви завжди можете додати більше елементів, які не повинні відображатись та існують у цих двох глобальних змінних. Це особливо корисно, якщо ви забудете відключити компонент у вашому виробничому середовищі. Погана практика - залишати її увімкненою, але якщо ви забули, то принаймні певні ключові фрагменти інформації про ваш хост не будуть видимі для потенційних хакерів.

> **NOTE**: The keys of the array elements to be hidden are case insensitive 
> 
> {: .alert .alert-info }

## Handlers
In order to catch exceptions and low severity errors, [Phalcon\Debug][debug] makes use of `onUncaughtException()` and `onUncaughtLowSeverity()`. Більшість розробників, які використовують цей компонент, ніколи не потребують розширення цих методів. Проте, якщо ви хочете, то можете це зробити, розширивши компонент і перевизначивши ці методи, щоб маніпулювати винятком та отримати потрібний результат.

These two methods are being set as exception handlers using PHP's [set_exception_handler][set_exception_handler]. При виклику `listenExceptions()` зареєструється `oncaughtException()`, тоді як виклик `listenLowSeverity()` зареєструє `oncaughtLowSeverity`.

## Відображення та самоаналіз
Phalcon classes do not differ from any other PHP classes and therefore you can use the [Reflection API][reflection_api] or simply print any object to display its contents and state:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

print_r($router);
```

Наведений вище приклад покаже наступне:

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
[Xdebug][xdebug] is an amazing tool that complements the debugging of PHP applications. Це також розширення C для PHP, і ви можете використовувати його разом з Phalcon без додаткової конфігурації чи побічних ефектів.

Після встановлення Xdebug ви можете використовувати його API, щоб отримати більш детальну інформацію про винятки і повідомлення.

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

Xdebug у вище наведеному прикладі покаже нам змінні в локальній області, а також дані зворотного трасування:

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

Xdebug пропонує декілька способів для отримання інформації налагодження та зворотного трасування стосовно виконання вашої програми за допомогою Phalcon. You can check the [XDebug documentation][xdebug_docs] for more information.

To set up Xdebug for PHPStorm you can check [this][phpstorm-xdebug] article.

[bootstrap]: https://getbootstrap.com/
[debug]: api/phalcon_debug#debug
[exception]: https://www.php.net/manual/en/language.exceptions.php
[exception_gettrace]: https://www.php.net/manual/en/exception.gettrace.php
[phalcon-exception]: api/Phalcon_Exception
[phpstorm-xdebug]: https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html
[reflection_api]: https://php.net/manual/en/book.reflection.php
[set_exception_handler]: https://www.php.net/manual/en/function.set-exception-handler.php
[xdebug]: https://xdebug.org
[xdebug_print_function_stack]: https://xdebug.org/docs/stack_trace
[xdebug_docs]: https://xdebug.org/docs
