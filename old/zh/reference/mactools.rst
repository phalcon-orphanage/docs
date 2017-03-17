Mac OS X 系统下使用 Phalcon 开发工具（Phalcon Developer Tools on Mac OS X）
===========================================================================

These steps will guide you through the process of installing Phalcon Developer Tools for OS/X.

预备知识（Prerequisites）
-------------------------
The Phalcon PHP extension is required to run Phalcon Tools. If you haven't installed it yet, please see the :doc:`Installation <install>` section for instructions.

下载（Download）
----------------
You can download a cross platform package containing the developer tools from the `Download`_ section. You can also clone it from `Github`_.

Open the terminal application:

.. figure:: ../_static/img/mac-1.png
   :align: center

Copy & Paste the commands below in your terminal:

.. code-block:: bash

    git clone git://github.com/phalcon/phalcon-devtools.git

Then enter the folder where the tools were cloned and execute ". ./phalcon.sh", (don't forget the dot at beginning of the command):

.. code-block:: bash

    cd phalcon-devtools/

    . ./phalcon.sh

In the terminal window, type the following commands to create a symbolic link to the phalcon.php script:

.. code-block:: bash

    ln -s ~/phalcon-tools/phalcon.php ~/phalcon-tools/phalcon

    chmod +x ~/phalcon-tools/phalcon

Type the command "phalcon" and you will see something like this:

.. figure:: ../_static/img/mac-5.png
   :align: center

Congratulations you now have Phalcon tools installed!

相关指南（Related Guides）
^^^^^^^^^^^^^^^^^^^^^^^^^^
* :doc:`Using Developer Tools <tools>`
* :doc:`Installation on Windows <wintools>`
* :doc:`Installation on Linux <linuxtools>`

.. _Download: http://phalconphp.com/download
.. _Github: https://github.com/phalcon/phalcon-devtools
