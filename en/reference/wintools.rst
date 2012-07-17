Phalcon Developer Tools on Windows
==================================
These steps will guide you through the process of installing Phalcon Developer Tools for Windows.

Requisites
----------
PHP extension is required to execute Phalcon Tools. Be sure you have installed it previously.

Download
--------
You can download a cross platform package containing the developer tools from the. Also you can clone itfrom  `Github <https://github.com/phalcon/phalcon-devtools>`_ .On the Windows platform, you need to configure the system PATH to include Phalcon tools and the PHP executable as well. If you download the Phalcon tools as a zip archive, extract it on any path of your local drive.By example  *c:\\phalcon-tools* or something like that. You will need this path in the steps below.Edit the file "phalcon.bat" by doing right click and choosing option "Edit":

.. figure:: ../_static/img/path-0.png
   :align: center

Change the path you did installed the Phalcon tools:

.. figure:: ../_static/img/path-01.png
   :align: center

Save the changes on the edited file.

Adding PHP and Tools to your system PATH
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Because the scripts are written in PHP, you need to install it on your machine. Depending of your kind of PHP installation, it can be located at different places. Search the file php.exe and copy the path it was found. For instance, when using the last WAMP stack, PHP is located at: *C:\\wamp\bin\\php\\php5.3.10\\php.exe* From the Windows start menu, do right click on icon "My Computer", a context menu will appear, then choose the option "Properties":

.. figure:: ../_static/img/path-1.png
   :align: center

Now, select the tab "Advanced" and then click on the button "Environment Variables":

.. figure:: ../_static/img/path-2.png
   :align: center

At the bottom, look for the section "System variables" and edit the variable "Path":

.. figure:: ../_static/img/path-3.png
   :align: center

Be careful in this part, append at the end of variable value the path you found the PHP executable and the Path where Phalcon tools was installed. Use the ";" character to separate the differents paths in the variable: 

.. figure:: ../_static/img/path-4.png
   :align: center

Accept the changes made by clicking on the button "OK" and close the dialogs opened. From the start menu clickon the option "Run". If you can't find this option, press "Windows Key" + "R". 

.. figure:: ../_static/img/path-5.png
   :align: center

Type "cmd" and press enter to open the windows command line utility:

.. figure:: ../_static/img/path-6.png
   :align: center

Type the commands "php -v" and "phalcon" you will look something like this:

.. figure:: ../_static/img/path-7.png
   :align: center

Congratulations you now have Phalcon tools installed!

Related Guides
^^^^^^^^^^^^^^

* :doc:`Using Developer Tools <tools>`
* :doc:`Installation on OS X <mactools>`
* :doc:`Installation on Linux <linuxtools>`

