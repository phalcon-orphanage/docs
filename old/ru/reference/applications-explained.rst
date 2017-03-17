Понимание работы Phalcon приложения
===================================

Если вы смотрели :doc:`руководство <tutorial>` или сгенерировали код используя :doc:`Инструменты разработчика <tools>`,
вы можете узнать следующий код:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // Регистрация автозагрузчика
    // ...

    // Регистрация сервисов
    // ...

    // Обработка запроса
    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

Ядро выполняет основную работу по запуску контроллера, при вызове handle():

.. code-block:: php

    <?php

    $response = $application->handle();

Ручная начальная загрузка
-------------------------
Если вы не хотите использовать :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`, код выше можно изменить вот так:

.. code-block:: php

    <?php

    // Получаем  сервис из контейнера сервисов
    $router = $di["router"];

    $router->handle();

    $view = $di["view"];

    $dispatcher = $di["dispatcher"];

    // Передаём обработанные параметры маршрутизатора в диспетчер

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    // Запускаем представление
    $view->start();

    // Выполняем запрос
    $dispatcher->dispatch();

    // Выводим необходимое представление
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // Завершаем работу представления
    $view->finish();

    $response = $di["response"];

    // Передаём результат для ответа
    $response->setContent(
        $view->getContent()
    );

    // Send the response
    $response->send();

В этой замене :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` отсутствует компонент представления, что делает данный вариант подходящим для Rest API:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Получаем сервис 'router'
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Передаем обработанные параметры роутера в диспетчер

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    // Обрабатываем запрос
    $dispatcher->dispatch();

    // Получаем результат последнего выполненного действия
    $response = $dispatcher->getReturnedValue();

    // Проверяем, что результат является 'response' объектом
    if ($response instanceof ResponseInterface) {
        // Send the response
        $response->send();
    }

Или вот еще один способ, в котором отлавливаются исключения, сгенерированные в диспетчере, и последовательно передаются в другие действия:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Получаем сервис 'router'
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Передаем обработанные параметры роутера в диспетчер

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    try {
        // Обрабатываем запрос
        $dispatcher->dispatch();
    } catch (Exception $e) {
        // Возникло исключение, поэтому специально для этого случая выполняем controller/action

        // Передаем обработанные параметры роутера в диспетчер
        $dispatcher->setControllerName("errors");
        $dispatcher->setActionName("action503");

        // Обрабатываем запрос
        $dispatcher->dispatch();
    }

    // Получаем результат последнего выполненного действия
    $response = $dispatcher->getReturnedValue();

    // Проверяем, что результат является 'response' объектом
    if ($response instanceof ResponseInterface) {
        // Send the response
        $response->send();
    }

Несмотря на то, что этот код более многословен чем код при использовании :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`,
он предоставляет альтернативу для запуска вашего приложения. В зависимости от своих потребностей, вы, возможно, захотите иметь полный контроль
того будет ли создан ответ или нет, или захотите заменить определённые компоненты на свои, либо расширить их функциональность.
