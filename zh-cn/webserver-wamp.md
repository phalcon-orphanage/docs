---
layout: article
language: 'zh-cn'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# 在WAMP集成环境中安装Phalcon

[WampServer](https://www.wampserver.com/en/) is a Windows web development environment. It allows you to create web applications with Apache2, PHP and a MySQL database. Below are detailed instructions on how to install Phalcon on WampServer for Windows. Using the latest WampServer version is highly recommended.

<a name='phalcon'></a>

## 下载正确版本的Phalcon扩展。

WAMP has both 32 and 64 bit versions. From the download section, you can download the Phalcon DLL that suits your WAMPP installation.

当下载Phalcon扩展完成后，会得到一个如下所示的zip包。

![](/assets/images/content/webserver-xampp-1.png)

解压zip包，会有一个Phalcon DLL文件。

![](/assets/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions folder. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php5.5.12\ext` (assuming your WAMP installation installed PHP 5.5.12).

![](/assets/images/content/webserver-wamp-1.png)

Edit the `php.ini` file, it is located at `C:\wamp\bin\php\php5.5.12\php.ini`. 你可以使用Notepad或者其他类似文件编辑器进行修改。 We recommend Notepad++ to avoid issues with line endings. 在文件末尾追加：

```ini extension=php_phalcon.dll

    <br />保存所修改的。
    
    ![](/assets/images/content/webserver-wamp-2.png)
    
    Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. 在文件末尾添加一行
    
    ```ini
    extension=php_phalcon.dll
    ``` 
    

保存所修改的。

Restart the Apache Web Server. Do a single click on the WampServer icon at system tray. Choose `Restart All Services` from the pop-up menu. Check out that tray icon will become green again.

![](/assets/images/content/webserver-wamp-3.png)

Open your browser to navigate to https://localhost. The WAMP welcome page will appear. Check the section `extensions loaded` to ensure that phalcon was loaded.

![](/assets/images/content/webserver-wamp-4.png)

Congratulations! You are now phlying with Phalcon.

<a name='related'></a>

## 相关指引

* [General Installation](/4.0/en/installation)
* [在XAMPP中安装Phalcon扩展](/4.0/en/webserver-xampp)