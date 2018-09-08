<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Введение</a>
      <ul>
        <li>
          <a href="#phalcon">Скачайте правильную версию Phalcon</a>
        </li>
        <li>
          <a href="#related">Дополнительные руководства</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Введение

[WampServer](http://www.wampserver.com/en/) — это платформа для веб-разработки под Windows. Она позволяет создавать веб-приложения с использованием Apache2, PHP и MySQL. Ниже представлена детальная инструкция по установке Phalcon на WampServer для Windows. Крайне рекомендуем использовать последнюю версию WampServer.

<a name='phalcon'></a>

## Скачайте правильную версию Phalcon

WAMP has both 32 and 64 bit versions. From the download section, you can download the Phalcon DLL that suits your WAMPP installation.

После скачивания библиотеки Phalcon у вас будет zip-файл, примерно такой как показано ниже:

![](/images/content/webserver-xampp-1.png)

Распакуйте архив и получите файл библиотеки Phalcon DLL:

![](/images/content/webserver-xampp-2.png)

Скопируйте файл `php_phalcon.dll` в каталог PHP-расширений. Если вы установили WAMP в каталог `C:\wamp`, то расширения будут в `C:\wamp\bin\php\php5.5.12\ext` (если у вас установлена версия WAMP для PHP 5.5.12):

![](/images/content/webserver-wamp-1.png)

Отредактируйте ваш `php.ini` файл, он располагается в `C:\wamp\bin\php\php5.5.12\php.ini`. Для редактирования можно использовать Блокнот или любую подобную программу. Мы рекомендуем использовать Notepad++ для избегания проблем с окончанием и переводом строк. Добавьте в конец файла:

```ini
extension=php_phalcon.dll
```

и сохраните его.

![](/images/content/webserver-wamp-2.png)

Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Добавьте в конец файла:

```ini
extension=php_phalcon.dll
```

и сохраните его.

Restart the Apache Web Server. Do a single click on the WampServer icon at system tray. Choose "Restart All Services" from the pop-up menu. Check out that tray icon will become green again.

![](/images/content/webserver-wamp-3.png)

Open your browser to navigate to `http://localhost`. The WAMP welcome page will appear. Check the section "extensions loaded" to ensure that phalcon was loaded.

![](/images/content/webserver-wamp-4.png)

Congratulations! You are now phlying with Phalcon.

<a name='related'></a>

## Дополнительные руководства

* [Информация по установке](/[[language]]/[[version]]/installation)
* [Подробная установка на XAMPP](/[[language]]/[[version]]/webserver-xampp)