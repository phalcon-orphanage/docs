Installation on WAMP
=====================

WampServer_ is a Windows web development environment. It allows you to create web applications with Apache2, PHP and a MySQL database. These are the detailed instructions to install Phalcon on WAMP for Windows. If possible, We recommend you to use the latest WAMP release. 

.. _WampServer: http://www.wampserver.com/en/

Download the right Phalcon
--------------------------
WAMP has both 32 and 64 bits versions. From the download section, you could choose the Phalcon for Windows accordingly to your desired architecture. 

After download the Phalcon library you will have a zip file like this: 

.. figure:: ../_static/img/xampp-1.png
	:align: center

Extract the library from the archive to get the Phalcon DLL: 

.. figure:: ../_static/img/xampp-2.png
	:align: center

Copy the file php_phalcon.dll to the PHP extensions. We have installed WAMP at c:\wamp directory. In our case is located at ﻿C:\\wamp\\bin\\php\\php5.3.10\\ext

.. figure:: ../_static/img/wamp-1.png
	:align: center	

Edit the php.ini file, it is located at ﻿﻿C:\\wamp\\bin\\php\\php5.3.10\\php.ini. It can be edited with Notepad or a similar program. Append at the end of the file: extension=php_phalcon.dll and save it. 

.. figure:: ../_static/img/wamp-2.png
	:align: center	

Also edit another php.ini file, it is located at ﻿﻿﻿C:\\wamp\\bin\\apache\\Apache2.2.21\\bin\\php.ini. Append at the end of the file: extension=php_phalcon.dll and save it.

Now it's time to restart the Apache Web Server. Do a single click on the WampServer icon at system tray. Choose "Restart All Services" from the pop-up menu. Check out that tray icon will become green again. 

.. figure:: ../_static/img/wamp-3.png
	:align: center	

Open your browser to navigate to http://localhost. The WAMP welcome page will appear. Look at the section "extensions loaded" to check if phalcon was loaded. 

.. figure:: ../_static/img/wamp-4.png
	:align: center 	

Congrats!, You are now flying with Phalcon. 

Related Guides
--------------
* :doc:`General Installation </reference/install>`
* :doc:`Detailed Installation on XAMPP for Windows </reference/xampp>`

