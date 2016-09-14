Инструменты разработчика Phalcon Developer Tools в Linux
========================================================

Этот шаг поможет вам установить Phalcon Developer Tools в Linux.

Требования
----------
Для запуска инструментов разработчика необходимо установленное расширение Phalcon PHP. Если оно еще не установлено, прочитайте инструкции в разделе :doc:`Installation <install>`.

Скачать
-------
Вы можете скачать кроссплатформенный пакет инструментов разработчиков из раздела Download_. Также вы можете его слить ( git clone ) на Github_.

Введите в терминале следующие команда:

.. code-block:: bash

    git clone git://github.com/phalcon/phalcon-devtools.git

.. figure:: ../_static/img/linux-1.png
   :align: center

Затем откройте папку, в которую были скопированы инструменты, и выполните команду ". ./phalcon.sh", (не забудьте точку в начале команды):

.. code-block:: bash

    cd phalcon-devtools/

    . ./phalcon.sh

.. figure:: ../_static/img/linux-2.png
   :align: center

Create a symbolink link to the phalcon.php script:

.. code-block:: bash

    ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon

    chmod ugo+x /usr/bin/phalcon

Поздравляем, инструменты разработчика Phalcon установлены!

Дополнительные руководства
^^^^^^^^^^^^^^^^^^^^^^^^^^
* :doc:`Использование инструментов разработчика <tools>`
* :doc:`Установка на Windows <wintools>`
* :doc:`Установка на Mac <mactools>`

.. _Download: http://phalconphp.com/download
.. _Github: https://github.com/phalcon/phalcon-devtools
