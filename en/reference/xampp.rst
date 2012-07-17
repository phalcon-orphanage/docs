Installation on XAMPP
=====================

XAMPP_ is an easy to install Apache distribution containing MySQL, PHP and Perl. XAMPP is really very easy to install and to use - just download, extract and start. These are the detailed instructions to install Phalcon on XAMPP for Windows. If possible, We recommend you to use the latest `XAMPP release <http://www.apachefriends.org/en/xampp-windows.html>`_. 

.. _XAMPP: http://www.apachefriends.org/en/xampp-windows.html

Download the right Phalcon
--------------------------
XAMPP is always releasing 32 bits versions of Apache and PHP. From the `download section <http://www.phalconphp.com/download>`_, you should to download the x86 version of Phalcon for Windows. 

After download the Phalcon library you will have a zip file like this: 

.. figure:: ../_static/img/xampp-1.png
	:align: center

Extract the library from the archive to get the Phalcon DLL: 

.. figure:: ../_static/img/xampp-2.png
	:align: center

Copy the file php_phalcon.dll to the PHP extensions. We have installed XAMPP at c:\\xampp directory. In our case is located at c:\\xampp\\php\\ext

.. figure:: ../_static/img/xampp-3.png
	:align: center

Edit the php.ini file, it is located at ﻿C:\\xampp\\php\\php.ini. It can be edited with Notepad or a similar program. Append at the end of the file: extension=php_phalcon.dll and save it. 

.. figure:: ../_static/img/xampp-4.png
	:align: center	

Now it's time to restart the Apache Web Server from the XAMPP Control Center. This will load the new PHP configuration. 

.. figure:: ../_static/img/xampp-5.png
	:align: center	

Open your browser to navigate to http://localhost. The XAMPP welcome page will appear. Look and click on the link phpinfo().

.. figure:: ../_static/img/xampp-6.png
	:align: center 	

phpinfo() will output a large amount of information about the current state of PHP. Scroll down to check if the phalcon extension has been loaded correctly. 

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

