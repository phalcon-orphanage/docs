Установка на Cherokee
=====================

Cherokee_ - это высокопроизводительный веб сервер. Он очень быстрый, гибкий и лёгкий в настройке.

Конфигурация Cherokee для Phalcon
---------------------------------
Cherokee имеет удобный графический интерфейс для настройки практически всех параметров, доступных в web-сервере.
Чтобы запустить администрирование сервера, нужно выполнить команду /path-to-cherokee/sbin/cherokee-admin с правами суперадмина (root).

.. figure:: ../_static/img/cherokee-1.jpg
    :align: center

Создайте новый виртуальный хост, для этого кликните на 'vServers', затем добавьте виртуальный сервер:

.. figure:: ../_static/img/cherokee-2.jpg
    :align: center

Добавленный виртуальный хост должен появиться на панели слева. На вкладке 'Behaviors'
вы можете увидеть набор правил для данного сервера. Нажмите кнопку 'Rule Management'.
Снимите выбор (галочки) с 'Directory /cherokee_themes' и 'Directory /icons':

.. figure:: ../_static/img/cherokee-3.jpg
    :align: center

С помощью мастера добавьте обработчик 'PHP Language'. Это позволит запускать PHP приложения:

.. figure:: ../_static/img/cherokee-4.jpg
    :align: center

Обычно такое решение не требует дополнительной настройки. Добавьте еще одно правило (behavior),
на этот раз в разеделе 'Manual Configuration'. В списке 'Rule Type' выберите 'File Exists',
и убедитесь что опция 'Match any file' включена:

.. figure:: ../_static/img/cherokee-55.jpg
    :align: center

На вкладке 'Handler' выберите обработчик (handler) 'List & Send':

.. figure:: ../_static/img/cherokee-7.jpg
    :align: center

Отредактируйте правило 'Default' для включения возможностей URL-rewrite. Выберите 'Redirection',
затем добавьте регулярное выражение ^(.*)$:

.. figure:: ../_static/img/cherokee-6.jpg
    :align: center

Убедитесь, что в "Behaviors" выставлен нужный порядок:

.. figure:: ../_static/img/cherokee-8.jpg
    :align: center

Запустите приложение в браузере:

.. figure:: ../_static/img/cherokee-9.jpg
    :align: center

.. _Cherokee: http://www.cherokee-project.com/
