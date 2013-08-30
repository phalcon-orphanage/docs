Тест производительности фреймворков
===================================
Раньше производительность не была главным приоритетом при выборе фреймворка для веб приложений. Это могло компенсироваться соответствующим оборудованием.
Однако, когда в Google `стали`_ учитывать скорость сайта при ранжировании поиска, производителность стала одним из приоритетов, наряду с функциональностью.
Это еще один способ, который улучшение производительности приложения будет положительно влиять на интернет.

Контрольные показатели ниже, показывают, насколько эффективнее Phalcon по сравнению с другими традиционными PHP фреймворками. Эти критерии
обновляются при выходе стабильных версий фреймворков или обновлении Phalcon.

Мы предлагаем всем программистам клонировать наши тесты, которые мы используем для проверок. Если у вас есть предложения по оптимизации или комментарии,
пожалуйста, `напишите нам`_. Скачать `исходники тестов на Github`_

Параметры тестовой среды
------------------------
Для всех фреймворков использовался APC_. Для избежания накладных расходов по возможности был отключен mod-rewrite в Apache.

Среда тестирования выглядит следующим образом:

* Операционная система: Mac OS X Lion 10.7.4
* Веб сервер: Apache httpd 2.2.22
* PHP: 5.3.15
* Процессор: 2.04 Ghz Intel Core i5
* Оперативная память: 4GB 1333 MHz DDR3
* Жесткий диск: 500GB SATA Disk

*Информация о PHP:*

.. figure:: ../_static/img/bench-4.png
    :align: center

*Настройки APC:*

.. figure:: ../_static/img/bench-5.png
    :align: center


Список тестов
-------------
.. toctree::
   :maxdepth: 1

   benchmark/hello-world
   benchmark/micro

Список изменений
----------------
.. versionadded:: 1.0
    Обновление Mar-20-2012: Тесты переделаны с учетом apc.stat установленного в ВЫКЛ. Расширение информации

.. versionchanged:: 1.1
    Обновление May-13-2012: Шаблонизация в Symfony была переделана с Twig на прямое использование PHP. Параметры конфигурации Yii были изменены в соответсвии с рекомндациями.

.. versionchanged:: 1.2
    Обновление May-20-2012: Для сравнения добавлен фреймворк Fuel.

.. versionchanged:: 1.3
    Обновление Jun-4-2012: Для сравнения добавлен фреймворк Cake. Но это не отображено на графике, потому как требует 30 секунд для запуска 10 из 1000.

.. versionchanged:: 1.4
    Обновление Ago-27-2012: PHP обновлён до to 5.3.15, APC обновлён до 3.1.11, Yii обновлён до 1.1.12, Phalcon обновлён до 0.5.0, Добавлен Laravel, операционная система обновлена до Mac OS X Lion. Обновлено железо.

Внешние источники
-----------------
* `For Impatient Web Users, an Eye Blink Is Just Too Long to Wait <http://www.nytimes.com/2012/03/01/technology/impatient-web-users-flee-slow-loading-sites.html?pagewanted=all&_r=0>`_
* `Millionaires performance cases: Impact of performance <https://github.com/zenorocha/browser-diet/wiki/Impact-of-performance>`_
* `How fast are we going now? <http://www.stevesouders.com/blog/2013/05/09/how-fast-are-we-going-now/>`_
* `Speed, performance and human perception <http://chimera.labs.oreilly.com/books/1230000000545/ch10.html#SPEED_PERFORMANCE_HUMAN_PERCEPTION>`_

.. _стали: http://googlewebmastercentral.blogspot.com/2010/04/using-site-speed-in-web-search-ranking.html
.. _напишите нам: https://github.com/phalcon/framework-bench
.. _исходники тестов на Github: https://github.com/phalcon/framework-bench
.. _APC: http://php.net/manual/en/book.apc.php
