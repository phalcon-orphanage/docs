Инструменты разработчика (Developer Tools) в Mac OS X
=====================================================

Эти действия покажут вам процесс установки Инструментов разработчика для OS/X.

Предпосылки
-----------
Для запуска Инструментов разработчика необходимо установленное PHP расширение Phalcon. Если расширение еще не установлено, обратите внимание на инструкции в разделе :doc:`Установка <install>`.

Скачать
-------
Вы можете скачать кросс-платформенный пакет с инструментами разработчика в разделе `Скачать`_. Можно так же клонировать его с `Github`_.

Откройте терминал:

.. figure:: ../_static/img/mac-1.png
   :align: center

Скопируйте и вставьте следующие команды в терминал:

.. code-block:: bash

    git clone git://github.com/phalcon/phalcon-devtools.git

Then enter the folder where the tools were cloned and execute ". ./phalcon.sh", (don't forget the dot at beginning of the command):

.. code-block:: bash

    cd phalcon-devtools/

    . ./phalcon.sh

Потом в терминале, введите следующие команды для создания символической ссылки на скрипт phalcon.php:

.. code-block:: bash

    ln -s ~/phalcon-tools/phalcon.php ~/phalcon-tools/phalcon

    chmod +x ~/phalcon-tools/phalcon

Введите команду "phalcon" и вы должны увидеть нечто подобное:

.. figure:: ../_static/img/mac-5.png
   :align: center

Поздравляем, инструменты разработчика Phalcon успешно установлены!

Дополнительные руководства
^^^^^^^^^^^^^^^^^^^^^^^^^^
* :doc:`Использование инструментов разработчика (Developer Tools) <tools>`
* :doc:`Установка в Windows <wintools>`
* :doc:`Установка в Linux <linuxtools>`

.. _Скачать: http://phalconphp.ru/download
.. _Github: https://github.com/phalcon/phalcon-devtools
