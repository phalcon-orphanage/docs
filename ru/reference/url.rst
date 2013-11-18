Генерация ссылок (URLs)
=======================
Компонент :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` позволяет генерировать ссылки для приложений Phalcon. Он может формировать ссылки
основываясь на маршрутах.

Указание базового URI
---------------------
В зависимости от корня установленного приложение, может появиться необходимость указания базового URL.

Например, если корневой каталог /var/www/htdocs, а ваше приложение установлено в /var/www/htdocs/invo, базовый URI (baseUri) будет  "/invo/".
При использовании виртуальных хостов, или приложение установлено в корневой каталог, параметр baseUri будет "/".
Для выявления какой адрес Phalcon считает за baseUri можно выполнить такой сценарий:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();
    echo $url->getBaseUri();

По умолчанию Phalcon самостоятельно выявляет необходимый baseUri, но в целях повышения производительности советуем указать его вручную:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    // Относительный URI
    $url->setBaseUri('/invo/');

    // Установка доменного имени
    $url->setBaseUri('//my.domain.com/');

    // Установка корневой полной ссылки
    $url->setBaseUri('http://my.domain.com/my-app/');

Компонент, как правило, регистрируется в DI-контейнере, что позволяет его легко настроить:

.. code-block:: php

    <?php

    $di->set('url', function(){
        $url = new Phalcon\Mvc\Url();
        $url->setBaseUri('/invo/');
        return $url;
    });

Генерация ссылок
----------------
По умолчанию для создания ссылок используется компонент :doc:`Router <routing>`. Ваше приложение может работать используя по умолчанию
такую схему маршрутизации: /:controller/:action/:params. Соответственно, легко создавать ссылки по этому образцу (или другим правилам,
прописанным в маршрутизаторе) передавая параметры в метод "get":

.. code-block:: php

    <?php echo $url->get("products/save") ?>

Обратите внимание: указывать базовый URL нет необходимости. При использовании именованных маршрутов ссылки можно формировать динамически.
Например, у вас есть такой маршрут:

.. code-block:: php

    <?php

    $route->add('/blog/{year}/{month}/{title}', array(
        'controller' => 'posts',
        'action' => 'show'
    ))->setName('show-post');

Ссылку на него можно сформировать таким образом:

.. code-block:: php

    <?php

    // Получится: /blog/2012/01/some-blog-post
    $url->get(array(
        'for' => 'show-post',
        'year' => 2012,
        'month' => '01',
        'title' => 'some-blog-post'
    ));

Создание ссылок без Mod-Rewrite
-------------------------------
Компонент можно использовать для создания ссылок без mod-rewrite:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    // Указание базового адреса из $_GET["_url"]
    $url->setBaseUri('/invo/index.php?_url=/');

    // Получится: /invo/index.php?_url=/products/save
    echo $url->get("products/save");

Вы так же можете использовать $_SERVER["REQUEST_URI"]:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    // Указание базового адреса используя $_GET["_url"]
    $url->setBaseUri('/invo/index.php?_url=/');

    // Передача URI из $_SERVER["REQUEST_URI"]
    $url->setBaseUri('/invo/index.php/');

В таком случае необходимо самостоятельно передать URI для обработки в Router:

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();

    // ... указание правил маршрутизации

    $uri = str_replace($_SERVER["SCRIPT_NAME"], '', $_SERVER["REQUEST_URI"]);
    $router->handle($uri);

Получится маршрут:

.. code-block:: php

    <?php

    // Будет сформировано: /invo/index.php/products/save
    echo $url->get("products/save");

Создание ссылок в Volt
----------------------
Функция "url", доступная в Volt, позволяет формировать ссылки с использованием этого компонента:

.. code-block:: html+jinja

    <a href="{{ url("posts/edit/1002") }}">Редактировать</a>

Generate static routes:

.. code-block:: html+jinja

    <link rel="stylesheet" href="{{ static_url("css/style.css") }}" type="text/css" />

Static vs. Dynamic Uris
-----------------------
This component allow you to set up a different base uri for static resources in the application:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //Dynamic URIs are
    $url->setBaseUri('/');

    //Static resources go through a CDN
    $url->setStaticBaseUri('http://static.example.com/');

:doc:`Phalcon\\Tag <tags>` will request both dynamical and static URIs using this component.

Реализация своего генератора ссылок
-----------------------------------
Для создания собственного генератора необходимо реализовать интерфейс  :doc:`Phalcon\\Mvc\\UrlInterface <../api/Phalcon_Mvc_UrlInterface>`, или использовать наследование и переопределить
стандартный компонент Phalcon.
