* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Установка на XAMPP

[XAMPP](https://www.apachefriends.org/download.html) представляет собой лёгкий вариант установки Apache в комплекте с MySQL, PHP и Perl. Просто скачав XAMPP его сразу можно использовать. Ниже представлена детальная инструкция по установке Phalcon на XAMPP для Windows. Крайне рекомендуем использовать последнюю версию XAMPP.

<a name='phalcon'></a>

## Скачайте правильную версию Phalcon

XAMPP всегда выпускается с 32-битными версиями Apache и PHP. Вам также необходимо скачать x86 версию Phalcon для Windows в разделе скачиваний.

После скачивания библиотеки Phalcon у вас будет zip-файл, примерно такой как показано ниже:

![](/assets/images/content/webserver-xampp-1.png)

Распакуйте архив и получите файл библиотеки Phalcon DLL:

![](/assets/images/content/webserver-xampp-2.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-3.png)

Отредактируйте ваш файл `php.ini`, он располагается в `C:\xampp\php\php.ini`. Для редактирования можно использовать Блокнот или любую подобную программу. Мы рекомендуем использовать [Notepad++](https://notepad-plus-plus.org/) для избегания проблем с окончанием и переводом строк. Добавьте в конец файла:

```ini
extension=php_phalcon.dll
```

и сохраните его.

![](/assets/images/content/webserver-xampp-4.png)

Перезапустите сервер Apache из контрольной панели XAMPP. PHP должен загрузиться с новой конфигурацией.

![](/assets/images/content/webserver-xampp-5.png)

Open your browser to navigate to `https://localhost`. The XAMPP welcome page will appear. Click on the link `phpinfo()`.

![](/assets/images/content/webserver-xampp-6.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) will output a significant amount of information on screen about the current state of PHP. Прокрутите страницу ниже и убедитесь, что расширение phalcon загружено корректно.

![](/assets/images/content/webserver-xampp-7.png)

Если вы увидели версию phalcon в выдаче `phpinfo()` — поздравляем! Вы готовы к полёту с Phalcon.

<a name='screencast'></a>

## Скринкаст

Нижеприведённый скринкаст отображает пошаговую установку Phalcon на Windows:

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