Understanding How Phalcon Applications Work
===========================================

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

The following replacement of :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` lacks of a view component making it suitable for Rest APIs:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Get the 'router' service
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Pass the processed router parameters to the dispatcher

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    // Dispatch the request
    $dispatcher->dispatch();

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof ResponseInterface) {
        // Send the response
        $response->send();
    }

Yet another alternative that catch exceptions produced in the dispatcher forwarding to other actions consequently:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Get the 'router' service
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Pass the processed router parameters to the dispatcher

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
        // Dispatch the request
        $dispatcher->dispatch();
    } catch (Exception $e) {
        // An exception has occurred, dispatch some controller/action aimed for that

        // Pass the processed router parameters to the dispatcher
        $dispatcher->setControllerName("errors");
        $dispatcher->setActionName("action503");

        // Dispatch the request
        $dispatcher->dispatch();
    }

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof ResponseInterface) {
        // Send the response
        $response->send();
    }

Несмотря на то, что этот код более многословен чем код при использовании :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`,
он предоставляет альтернативу для запуска вашего приложения. В зависимости от своих потребностей, вы, возможно, захотите иметь полный контроль
того будет ли создан ответ или нет, или захотите заменить определённые компоненты на свои, либо расширить их функциональность.
