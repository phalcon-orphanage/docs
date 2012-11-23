Installation on XAMPP
=====================

XAMPP_ is an easy to install Apache distribution containing MySQL, PHP and Perl. Once you download XAMPP, all you have to do is extract it and start using it. Below are detailed instructions on how to install Phalcon on XAMPP for Windows. Using the latest XAMPP version is highly recommended. 

Download the right version of Phalcon
-------------------------------------
XAMPP is always releasing 32 bit versions of Apache and PHP. You will need to download the x86 version of Phalcon for Windows from the download section. 

After downloading the Phalcon library you will have a zip file like the one shown below: 

.. figure:: ../_static/img/xampp-1.png
    :align: center

Extract the library from the archive to get the Phalcon DLL: 

.. figure:: ../_static/img/xampp-2.png
    :align: center

Copy the file php_phalcon.dll to the PHP extensions. If you have installed XAMPP in the c:\\xampp folder, the extension needs to be in c:\\xampp\\php\\ext

.. figure:: ../_static/img/xampp-3.png
    :align: center

Edit the php.ini file, it is located at ﻿C:\\xampp\\php\\php.ini. It can be edited with Notepad or a similar program. We recommend Notepad++ to avoid issues with line endings. Append at the end of the file: extension=php_phalcon.dll and save it. 

.. figure:: ../_static/img/xampp-4.png
    :align: center  

Restart the Apache Web Server from the XAMPP Control Center. This will load the new PHP configuration. 

.. figure:: ../_static/img/xampp-5.png
    :align: center  

Open your browser to navigate to http://localhost. The XAMPP welcome page will appear. Click on the link phpinfo().

.. figure:: ../_static/img/xampp-6.png
    :align: center  

phpinfo() will output a significant amount of information on screen about the current state of PHP. Scroll down to check if the phalcon extension has been loaded correctly. 

.. figure:: ../_static/img/xampp-7.png
    :align: center

If you can see the phalcon version in the phpinfo() output, congrats!, You are now flying with Phalcon. 

Screencast
----------
The following screencast is a step by step guide to install Phalcon on Windows:     

.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Related Guides
--------------
* :doc:`General Installation </reference/install>`
* :doc:`Detailed Installation on WAMP for Windows </reference/wamp>`

.. _XAMPP: http://www.apachefriends.org/en/xampp-windows.html
