* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Установка на XAMPP

[XAMPP](https://www.apachefriends.org/download.html) is an easy to install Apache distribution containing MySQL, PHP and Perl. Once you download XAMPP, all you have to do is extract it and start using it. Below are detailed instructions on how to install Phalcon on XAMPP for Windows. Using the latest XAMPP version is highly recommended.

<a name='phalcon'></a>

## Скачайте правильную версию Phalcon

XAMPP is always releasing 32 bit versions of Apache and PHP. You will need to download the x86 version of Phalcon for Windows from the download section.

После скачивания библиотеки Phalcon у вас будет zip-файл, примерно такой как показано ниже:

![](/assets/images/content/webserver-xampp-1.png)

Распакуйте архив и получите файл библиотеки Phalcon DLL:

![](/assets/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-3.png)

Edit the `php.ini` file, it is located at `C:\xampp\php\php.ini`. Для редактирования можно использовать Блокнот или любую подобную программу. We recommend [Notepad++](https://notepad-plus-plus.org/) to avoid issues with line endings. Добавьте в конец файла:

```ini
extension=php_phalcon.dll
```

и сохраните его.

![](/assets/images/content/webserver-xampp-4.png)

Restart the Apache Web Server from the XAMPP Control Center. This will load the new PHP configuration.

![](/assets/images/content/webserver-xampp-5.png)

Open your browser to navigate to `https://localhost`. The XAMPP welcome page will appear. Click on the link `phpinfo()`.

![](/assets/images/content/webserver-xampp-6.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) will output a significant amount of information on screen about the current state of PHP. Scroll down to check if the phalcon extension has been loaded correctly.

![](/assets/images/content/webserver-xampp-7.png)

If you can see the phalcon version in the `phpinfo()` output, congratulations!, You are now phlying with Phalcon.

<a name='screencast'></a>

## Скринкаст

The following screencast is a step by step guide to install Phalcon on Windows:

<div align="center">
  <iframe src="https://player.vimeo.com/video/40265988" 
          width="500" 
          height="266" 
          frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
  </iframe>
</div>

<a name='related'></a>

## Дополнительные руководства

* [Информация по установке](/4.0/en/installation)
* [Установка на WAMP](/4.0/en/webserver-wamp)