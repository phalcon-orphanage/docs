* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Установка на WAMP

[WampServer](https://www.wampserver.com/en/) is a Windows web development environment. Она позволяет создавать веб-приложения с использованием Apache2, PHP и MySQL. Ниже представлена детальная инструкция по установке Phalcon на WampServer для Windows. Крайне рекомендуем использовать последнюю версию WampServer.

<a name='phalcon'></a>

## Скачайте правильную версию Phalcon

WAMP существует в 32- и 64-битных версиях. В разделе скачивания выберите нужную версию Phalcon для Windows в зависимости от имеющейся архитектуры.

После скачивания библиотеки Phalcon у вас будет zip-файл, примерно такой как показано ниже:

![](/assets/images/content/webserver-xampp-1.png)

Распакуйте архив и получите файл библиотеки Phalcon DLL:

![](/assets/images/content/webserver-xampp-2.png)

Скопируйте файл `php_phalcon.dll` в каталог PHP-расширений. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php5.5.12\ext` (assuming your WAMP installation installed PHP 5.5.12).

![](/assets/images/content/webserver-wamp-1.png)

Отредактируйте ваш `php.ini` файл, он располагается в `C:\wamp\bin\php\php5.5.12\php.ini`. Для редактирования можно использовать Блокнот или любую подобную программу. Мы рекомендуем использовать Notepad++ для избегания проблем с окончанием и переводом строк. Добавьте в конец файла:

```ini extension=php_phalcon.dll

    <br />и сохраните его.
    
    ![](/assets/images/content/webserver-wamp-2.png)
    
    Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Добавьте в самый конец файла:
    
    extension=php_phalcon.dll 
    

и сохраните его.

Restart the Apache Web Server. Do a single click on the WampServer icon at system tray. Choose `Restart All Services` from the pop-up menu. Check out that tray icon will become green again.

![](/assets/images/content/webserver-wamp-3.png)

Open your browser to navigate to https://localhost. The WAMP welcome page will appear. Check the section `extensions loaded` to ensure that phalcon was loaded.

![](/assets/images/content/webserver-wamp-4.png)

Congratulations! You are now phlying with Phalcon.

<a name='related'></a>

## Дополнительные руководства

* [Информация по установке](/4.0/en/installation)
* [Установка на XAMPP](/4.0/en/webserver-xampp)