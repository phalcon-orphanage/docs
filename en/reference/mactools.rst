Phalcon Developer Tools on Mac OS X
===================================
These steps will guide you through the process of installing Phalcon Developer Tools for OS/X.

Requisites
----------
PHP extension is required to execute Phalcon Tools. Be sure you have installed it previously.

Download
--------
You can download a cross platform package containing the developer tools from the. Also you can clone itfrom  `Github <https://github.com/phalcon/phalcon-devtools>`_ . Open your terminal and execute the commands as follows to get a rapid installation:

.. figure:: ../_static/img/mac-1.png
   :align: center

Copy & Paste the below commands in your terminal:

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

Save modifications, close and open again your Terminal. The last step is to create a symbolic link to the phalcon.sh script. You can do that typing the next command in your terminal:

.. code-block:: bash

    ln -s ~/phalcon-tools/phalcon.sh ~/phalcon-tools/phalcon
    chmod +x ~/phalcon-tools/phalcon

Type the command "phalcon" and you will look something like this:

.. figure:: ../_static/img/mac-5.png
   :align: center

Congratulations you now have Phalcon tools installed!

Related Guides
^^^^^^^^^^^^^^

* :doc:`Using Developer Tools <tools>`
* :doc:`Installation on Windows <wintools>`
* :doc:`Installation on Linux <linuxtools>`

