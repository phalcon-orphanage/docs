Phalcon Developer Tools on Mac OS X
===================================
These steps will guide you through the process of installing Phalcon Developer Tools for OS/X.

Prerequisites
----------
The Phalcon PHP extension is required to run Phalcon Tools. If you haven't installed it yet, please see the :doc:`Installation <install>` section for instructions.

Download
--------
You can download a cross platform package containing the developer tools from the `Download`_ section. You can also clone it from `Github`_. 

Open the terminal application:

.. figure:: ../_static/img/mac-1.png
   :align: center

Copy & Paste the commands below in your terminal:

.. code-block:: bash

    wget -q --no-check-certificate -O phalcon-tools.zip http://github.com/phalcon/phalcon-devtools/zipball/master
    unzip -q phalcon-tools.zip
    mv phalcon-phalcon-devtools-* phalcon-tools

Check where the phalcon-tools directory was installed using a *pwd* command in your terminal:

.. figure:: ../_static/img/mac-2.png
   :align: center

On the Mac platform, you need to configure your user PATH to include Phalcon tools. Edit your .profile and append the Phalcon tools path to the environment variable PATH: 

.. figure:: ../_static/img/mac-3.png
   :align: center

Insert these two lines at the end of the file:

.. code-block:: bash

    export PATH=$PATH:/Users/scott/phalcon-tools
    export PTOOLSPATH=/Users/scott/phalcon-tools

The .profile should look like this:

.. figure:: ../_static/img/mac-4.png
   :align: center

Save your changes and close the editor. In the terminal window, type the following commands to create a symbolic link to the phalcon.sh script:

.. code-block:: bash

    ln -s ~/phalcon-tools/phalcon.sh ~/phalcon-tools/phalcon
    chmod +x ~/phalcon-tools/phalcon

Type the command "phalcon" and you will see something like this:

.. figure:: ../_static/img/mac-5.png
   :align: center

Congratulations you now have Phalcon tools installed!

Related Guides
^^^^^^^^^^^^^^

* :doc:`Using Developer Tools <tools>`
* :doc:`Installation on Windows <wintools>`
* :doc:`Installation on Linux <linuxtools>`

.. _Download: http://phalconphp.com/download>
.. _Github: https://github.com/phalcon/phalcon-devtools