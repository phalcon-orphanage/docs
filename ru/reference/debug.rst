Отладка приложений
==================
PHP предлагает набор инструментов для отладки приложений с выводом уведомлений, предупреждений, ошибок и исключений.
Класс `Exception class`_ передает различную информацию, там где вызывается исключение: файл, линию, сообщение, код ошибки, список вызовов и т.п.
ООП системы, такие как Phalcon, в основном используют этот класс в качестве родительского для добавления различного функционала и предоставления
информации разработчику или пользователю.

Несмотря на то что Phalcon написан на языке C, он вызывает методы из пользовательского уровня PHP, обеспечивая возможность
отладки и совместимость с другими приложениями.

Перехват исключений
-------------------
Существует основной сопсоб перехвата исключений, через конструкцию try/catch:

.. code-block:: php

    <?php

    try {

        //... какой-то код

    } catch(\Phalcon\Exception $e) {

    }

Исключение перехваченное в этом блоке попадает в переменную $e. А :doc:`Phalcon\\Exception <../api/Phalcon_Exception>` унаследован от
PHP класса `Exception class`_ и используется, чтобы понять, является ли исключение из Phalcon или из PHP.

Все исключение сгенерированные в PHP базируются на классе `Exception class`_, и имеют следующий набор элементов:

.. code-block:: php

    <?php

    class Exception
    {

        /* Свойства */
        protected string $message;
        protected int $code;
        protected string $file;
        protected int $line;

        /* Методы */
        public __construct ([ string $message = "" [, int $code = 0 [, Exception $previous = NULL ]]])
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

Получить информацию из :doc:`Phalcon\\Exception <../api/Phalcon_Exception>` можно таким же способом, как из `Exception class`_:

.. code-block:: php

    <?php

    try {

        //... код приложения ...

    } catch(\Phalcon\Exception $e) {
        echo get_class($e), ": ", $e->getMessage(), "\n";
        echo " File=", $e->getFile(), "\n";
        echo " Line=", $e->getLine(), "\n";
        echo $e->getTraceAsString();
    }

Таким образом можно легко узнать, где было сгенерировано исключение (файл, строка) и какие компоненты участвовали в генерации:

.. code-block:: html

    PDOException: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost'
        (using password: NO)
     File=/Applications/MAMP/htdocs/invo/public/index.php
     Line=74
    #0 [internal function]: PDO->__construct('mysql:host=loca...', 'root', '', Array)
    #1 [internal function]: Phalcon\Db\Adapter\Pdo->connect(Array)
    #2 /Applications/MAMP/htdocs/invo/public/index.php(74):
        Phalcon\Db\Adapter\Pdo->__construct(Array)
    #3 [internal function]: {closure}()
    #4 [internal function]: call_user_func_array(Object(Closure), Array)
    #5 [internal function]: Phalcon\DI->_factory(Object(Closure), Array)
    #6 [internal function]: Phalcon\DI->get('db', Array)
    #7 [internal function]: Phalcon\DI->getShared('db')
    #8 [internal function]: Phalcon\Mvc\Model->getConnection()
    #9 [internal function]: Phalcon\Mvc\Model::_getOrCreateResultset('Users', Array, true)
    #10 /Applications/MAMP/htdocs/invo/app/controllers/SessionController.php(83):
        Phalcon\Mvc\Model::findFirst('email='demo@pha...')
    #11 [internal function]: SessionController->startAction()
    #12 [internal function]: call_user_func_array(Array, Array)
    #13 [internal function]: Phalcon\Mvc\Dispatcher->dispatch()
    #14 /Applications/MAMP/htdocs/invo/public/index.php(114): Phalcon\Mvc\Application->handle()
    #15 {main}

Как вы можете увидеть из вывода исключения все методы прозрачны и можно полностью отследить работу приложения, а так же параметры,
которые передавались в методы. Метод `Exception::getTrace`_ предоставляет дополнительную информацию, если необходимо.

Если установить утилиту '`Pretty Exceptions`_' то исключения буду выводится в удобном формате.

Рефлексия (Reflection)
----------------------
Любой экземпляр класса в Phalcon предоставляет тоже поведение, что и во всех экземплярах PHP классов. Можно использовать
`Reflection API`_ или просто вывести любой объект, чтобы увидить его состояние:

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();
    print_r($router);

Таким образом можно узнать всю информацию о любом объекте. Этот пример выводит такую информацию:

.. code-block:: html

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


Использование XDebug
--------------------
XDebug_ великолепный инструмент для отладки PHP приложений. Он так же является дополнением, написанным на языке C, и вы можете использовать
его вместе с Phalcon без дополнительной конфигурации или побочных эффектов.

После установки xdebug вы можете использовать его API для получения детальной информации об исключениях и сообщениях.
Слудующий пример использует xdebug_print_function_stack_ для остановки выполнения программы и вывода стека вызовов:

.. code-block:: php

    <?php

    class SignupController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function registerAction()
        {

            // Запрос переменных из html формы
            $name  = $this->request->getPost("name", "string");
            $email = $this->request->getPost("email", "email");

            // Останавливаем выполнение и выводим стек вызовов
            return xdebug_print_function_stack("stop here!");

            $user        = new Users();
            $user->name  = $name;
            $user->email = $email;

            // Сохраняем и проверяем на ощибки
            $user->save();
        }

    }

Xdebug так же покажет локальные переменные в этом экземпляре:

.. code-block:: html

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

Xdebug предоставляет несколько путей для отладки ваших приложений и получения отладочной информации. Вы можете ознакомиться
с `XDebug документацией`_ для дополнительной информации.

.. _`Pretty Exceptions` : https://github.com/phalcon/pretty-exceptions
.. _`Exception class` : http://www.php.net/manual/ru/language.exceptions.php
.. _`Reflection API` : http://php.net/manual/ru/book.reflection.php
.. _`Exception::getTrace` : http://www.php.net/manual/ru/exception.gettrace.php
.. _`XDebug`: http://xdebug.org
.. _`XDebug документацией`: http://xdebug.org/docs
.. _`xdebug_print_function_stack`: http://xdebug.org/docs/stack_trace