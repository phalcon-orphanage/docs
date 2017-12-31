<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Введение</a> <ul>
        <li>
          <a href="#phalcon">Скачайте правильную версию Phalcon</a>
        </li>
        <li>
          <a href="#screencast">Скринкаст</a>
        </li>
        <li>
          <a href="#related">Дополнительные руководства</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Установка на XAMPP

[XAMPP](https://www.apachefriends.org/download.html) представляет собой лёгкий вариант установки Apache в комплекте с MySQL, PHP и Perl. Просто скачав XAMPP его сразу можно использовать. Ниже представлена детальная инструкция по установке Phalcon на XAMPP для Windows. Крайне рекомендуем использовать последнюю версию XAMPP.

<a name='phalcon'></a>

## Скачайте правильную версию Phalcon

XAMPP всегда выпускается с 32-битными версиями Apache и PHP. Вам также необходимо скачать x86 версию Phalcon для Windows в разделе скачиваний.

После скачивания библиотеки Phalcon у вас будет zip-файл, примерно такой, как показано ниже:

![](/images/content/webserver-xampp-1.png)

Распакуйте архив и получите файл библиотеки Phalcon DLL:

![](/images/content/webserver-xampp-2.png)

Скопируйте файл `php_phalcon.dll` в каталог PHP-расширений. Если вы установили XAMPP в каталог `C:\xampp`, то расширения будут в `C:\xampp\php\ext`.

![](/images/content/webserver-xampp-3.png)

Отредактируйте ваш файл php.ini, он располагается в `C:\xampp\php\php.ini`. Для редактирования можно использовать Блокнот или любую подобную программу. Мы рекомендуем использовать Notepad++ для избегания проблем с окончанием и переводом строк. Добавьте в конец файла:

```ini
extension=php_phalcon.dll
```

и сохраните его.

![](/images/content/webserver-xampp-4.png)

Перезапустите сервер Apache из контрольной панели XAMPP. PHP должен загрузиться с новой конфигурацией.

![](/images/content/webserver-xampp-5.png)

Откройте ваш браузер и перейдите на `http://localhost`. Должна появиться страница приветствия XAMPP. Нажмите на ссылку `phpinfo()`.

![](/images/content/webserver-xampp-6.png)

`phpinfo()` выводит обширную информацию о текущем состоянии PHP. Прокрутите страницу ниже и убедитесь, что расширение phalcon загружено корректно.

![](/images/content/webserver-xampp-7.png)

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

- [Установка на WAMP](/[[language]]/[[version]]/webserver-wamp)