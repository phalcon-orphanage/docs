Understanding How Phalcon Applications Work
===========================================

Jika anda mengikuti :doc:`tutorial <tutorial>` atau membuat kode menggunakan :doc:`Phalcon Devtools <tools>`,
anda mungkin mengenali file bootstrap berikut:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // Register autoloaders
    // ...

    // Register services
    // ...

    // Handle the request
    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

Inti semua kerja kontroller terjadi ketika handle() dipanggil:

.. code-block:: php

    <?php

    $response = $application->handle();

Bootstrap manual
----------------
Jika anda ingin menggunakan :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`, kode di atas dapat diubah seperti berikut:

.. code-block:: php

    <?php

    // Get the 'router' service
    $router = $di["router"];

    $router->handle();

    $view = $di["view"];

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

    // Start the view
    $view->start();

    // Dispatch the request
    $dispatcher->dispatch();

    // Render the related views
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // Finish the view
    $view->finish();

    $response = $di["response"];

    // Pass the output of the view to the response
    $response->setContent(
        $view->getContent()
    );

    // Send the response
    $response->send();

Pengganti :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` berikut tidak memiliki komponen view membuatnya cocok untuk Rest API:

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

Alternatif lain adalah menangkap eksepsi yang dihasilkan oleh dispatcher dan mengarahkan ke aksi lain:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Dapatkan service 'router'
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Lewatkan parameter router yang telah diproses ke dispatcher

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
        // Kirim request
        $dispatcher->dispatch();
    } catch (Exception $e) {
        // An exception has occurred, dispatch some controller/action aimed for that

        // Lewatkan parameter router yang telah diproses ke dispatcher
        $dispatcher->setControllerName("errors");
        $dispatcher->setActionName("action503");

        // Kirim request
        $dispatcher->dispatch();
    }

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof ResponseInterface) {
        // Send the response
        $response->send();
    }

Meski implementasi di atas lebih banyak kodenya dibanding menggunakan :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`,
ia menawarkan alternatif bootstraping aplikasi anda. Tergantung kebutuhan anda, anda mungkin ingin memiliki kendali penuh
terhadap apa yang harus diciptakan dan yang tidak, atau mengganti komponen tertentu dengan milik anda sendiri untuk memperluas fungsionalitas defaultnya.
