<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Введение</a> <ul>
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

# Установка на WAMP

[WampServer](http://www.wampserver.com/en/) — это платформа для веб-разработки под Windows. Она позволяет создавать веб-приложения с использованием Apache2, PHP и MySQL. Ниже представлена детальная инструкция по установке Phalcon на WampServer для Windows. Крайне рекомендуем использовать последнюю версию WampServer.

<a name='phalcon'></a>

## Скачайте правильную версию Phalcon

WAMP существует в 32- и 64-битных версиях. В разделе скачивания выберите нужную версию Phalcon для Windows в зависимости от имеющейся архитектуры.

После скачивания библиотеки Phalcon у вас будет zip-файл, примерно такой как показано ниже:

![](/images/content/webserver-xampp-1.png)

Распакуйте архив и получите файл библиотеки Phalcon DLL:

![](/images/content/webserver-xampp-2.png)

Скопируйте файл `php_phalcon.dll` в каталог PHP-расширений. Если вы установили WAMP в каталог `C:\wamp`, то расширения будут в `C:\wamp\bin\php\php5.5.12\ext` (если у вас установлена версия WAMP для PHP 5.5.12).

![](/images/content/webserver-wamp-1.png)

Отредактируйте ваш `php.ini` файл, он располагается в `C:\wamp\bin\php\php5.5.12\php.ini`. Для редактирования можно использовать Блокнот или любую подобную программу. Мы рекомендуем использовать Notepad++ для избегания проблем с окончанием и переводом строк. Добавьте в конец файла:

extension=php_phalcon.dll

    <br />и сохраните его.

    ![](/images/content/webserver-wamp-2.png)

    Так же отредактируйте файл `php.ini`, располагающийся в `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Добавьте в самый конец файла:

    extension=php_phalcon.dll

и сохраните его.

Перезапустите Apache. Кликните один раз на значок WampServer в системном трее. Выберите “Restart All Services” из выпадающего меню. Проверьте, что значок в трее снова стал зелёным.

![](/images/content/webserver-wamp-3.png)

Откройте ваш браузер и перейдите на http://localhost. Должна появиться страница приветствия WAMP. Найдите раздел “extensions loaded” и проверьте, что расширение phalcon загружено.

![](/images/content/webserver-wamp-4.png)

Поздравляем! Вы готовы к полёту с Phalcon.

<a name='related'></a>

## Дополнительные руководства

- [Подробная установка на XAMPP](/[[language]]/[[version]]/webserver-xampp)