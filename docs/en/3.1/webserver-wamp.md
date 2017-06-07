<div class='article-menu' markdown='1'>

- [Overview](#overview)
    - [Download the right version of Phalcon](#phalcon)
    - [Related](#related)
    
</div>

<a name='overview'></a>
# Installation on WAMP
[WampServer](http://www.wampserver.com/en/) is a Windows web development environment. It allows you to create web applications with Apache2, PHP and a MySQL database. Below are detailed instructions on how to install Phalcon on WampServer for Windows. Using the latest WampServer version is highly recommended.

<a name='phalcon'></a>
## Download the right version of Phalcon
WAMP has both 32 and 64 bit versions. From the download section, you can download the Phalcon DLL that suits your WAMPP installation.

After downloading the Phalcon library you will have a zip file like the one shown below:

![](/images/content/webserver-xampp-1.png)

Extract the library from the archive to get the Phalcon DLL:

![](/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions folder. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php5.5.12\ext` (assuming your WAMP installation installed PHP 5.5.12).

![](/images/content/webserver-wamp-1.png)

Edit the `php.ini` file, it is located at `C:\wamp\bin\php\php5.5.12\php.ini`. It can be edited with Notepad or a similar program. We recommend Notepad++ to avoid issues with line endings. Append at the end of the file:
 
 ```ini
 extension=php_phalcon.dll
```

and save it.

![](/images/content/webserver-wamp-2.png)

Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Append at the end of the file: 

```ini
extension=php_phalcon.dll 
```

and save it.

Restart the Apache Web Server. Do a single click on the WampServer icon at system tray. Choose `Restart All Services` from the pop-up menu. Check out that tray icon will become green again.

![](/images/content/webserver-wamp-3.png)

Open your browser to navigate to http://localhost. The WAMP welcome page will appear. Check the section `extensions loaded` to ensure that phalcon was loaded.

![](/images/content/webserver-wamp-4.png)

Congratulations! You are now phlying with Phalcon.

<a name='related'></a>
## Related Guides
* [Installation on XAMPP](/[[language]]/[[version]]/webserver-xampp)

