Инструменты разработчика (Developer Tools) в Mac OS X
=====================================================
Эти действия покажут вам процесс установки Инструментов разрабоотчика для OS/X.

Предпосылки
-----------
Для запуска Инструментов разработчика необходимо установленное PHP расширение Phalcon. Если расширение еще не установлено, обратите внимание на
инструкции в разделе :doc:`Установка <install>`.

Скачать
-------
Вы можете скачать кросс-платформенный пакет с инструментами разработчика в разделе `Скачать`_. Можно так же клонировать его с `Github`_. 

Откройте терминал:

.. figure:: ../_static/img/mac-1.png
   :align: center

Скопируйте и вставьте следующие команды в терминал:

.. code-block:: bash

    wget -q --no-check-certificate -O phalcon-tools.zip http://github.com/phalcon/phalcon-devtools/zipball/master
    unzip -q phalcon-tools.zip
    mv phalcon-phalcon-devtools-* phalcon-tools

Проверьте куда будут установлены Инструменты разработчика Phalcon используя команду *pwd*:

.. figure:: ../_static/img/mac-2.png
   :align: center

На платформе Mac, вам необходимо самостоятельно настроить пользовательскую переменную PATH, для включения инструментов Phalcon. Откройте ваш .profile
файл и добавьте путь к инструментам Phalcon в переменную PATH:

.. figure:: ../_static/img/mac-3.png
   :align: center

Вставьте две строки в конец файла:

.. code-block:: bash

    export PATH=$PATH:/Users/scott/phalcon-tools
    export PTOOLSPATH=/Users/scott/phalcon-tools

Файл .profile должен быть примерно таким:

.. figure:: ../_static/img/mac-4.png
   :align: center

Сохраните изменения и закройте файл. Потом в терминале, введите следующие команды для создания символической ссылки на скрипт phalcon.sh:

.. code-block:: bash

    ln -s ~/phalcon-tools/phalcon.sh ~/phalcon-tools/phalcon
    chmod +x ~/phalcon-tools/phalcon

Введите команду "phalcon" и вы должны увидить нечто подобное:

.. figure:: ../_static/img/mac-5.png
   :align: center

Поздравляем, инструменты разработчика Phalcon успешно установлены!

Попутные руководства
^^^^^^^^^^^^^^^^^^^^

* :doc:`Использование инструментов разработчика (Developer Tools) <tools>`
* :doc:`Установка в Windows <wintools>`
* :doc:`Установка в Linux <linuxtools>`

.. _Скачать: http://phalconphp.ru/download>
.. _Github: https://github.com/phalcon/phalcon-devtools