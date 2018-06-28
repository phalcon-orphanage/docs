<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Инструменты разработчика Phalcon</a> 
      <ul>
        <li>
          <a href="#download">Скачать</a>
        </li>
        <li>
          <a href="#installation">Установка</a>
        </li>
        <li>
          <a href="#available-commands">Доступные команды</a>
        </li>
        <li>
          <a href="#project-skeleton">Создание скелета проекта</a>
        </li>
        <li>
          <a href="#generating-controllers">Создание контроллеров</a>
        </li>
        <li>
          <a href="#database-settings">Настройка базы данных</a>
        </li>
        <li>
          <a href="#generating-models">Создание моделей</a>
        </li>
        <li>
          <a href="#crud">Автоматическая генерация CRUD</a>
        </li>
        <li>
          <a href="#web-interface">Веб интерфейс инструментов</a>
        </li>
        <li>
          <a href="#phpstorm-ide">Интеграция в PhpStorm IDE</a>
        </li>
        <li>
          <a href="#conclusion">Заключение</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Инструменты разработчика Phalcon

Эти инструменты представляют собой набор полезных скриптов для генерации основы приложения. Основные компоненты приложения могут быть созданы простыми командами, позволяющими легко разрабатывать приложения с использованием Phalcon.

<div class="alert alert-danger">
    <p>
        If you prefer to use the web version instead of the console, this <a href="https://blog.phalconphp.com/post/dont-like-command-line-and-consoles-no-problem">blog post</a> offers more information.
    </p>
</div>

<a name='download'></a>

## Скачать

Вы можете скачать кроссплатформенный пакет инструментов разработчиков используя [публичный репозиторий на GitHub](https://github.com/phalcon/phalcon-devtools).

<a name='installation'></a>

## Установка

Существуют подробные инструкции о том, как установить средства разработки на различные платформы:

[Linux](/[[language]]/[[version]]/devtools-installation#installation-linux) : [macOS](/[[language]]/[[version]]/devtools-installation#installation-macos) : [Windows](/[[language]]/[[version]]/devtools-installation#installation-windows)

<a name='available-commands'></a>

## Доступные команды

Для получения списка имеющихся команд введите: `phalcon commands`

```bash
$ phalcon commands

Phalcon DevTools (3.0.0)

Available commands:
  commands         (alias of: list, enumerate)
  controller       (alias of: create-controller)
  module           (alias of: create-module)
  model            (alias of: create-model)
  all-models       (alias of: create-all-models)
  project          (alias of: create-project)
  scaffold         (alias of: create-scaffold)
  migration        (alias of: create-migration)
  webtools         (alias of: create-webtools)
```

<a name='project-skeleton'></a>

## Создание скелета проекта

Вы можете использовать инструменты для создания скелета проекта на Phalcon. По умолчанию созданный проект будет использовать mod_rewrite для Apache. Введите следующие команды в корне сайта вашего веб-сервера:

```bash
$ pwd

/Applications/MAMP/htdocs

$ phalcon create-project store
```

Проект создастся с полной рекомендованной структурой:

![](/images/content/devtools-usage-01.png)

Для получения подробной информации по командам стоит использовать параметр `--help`:

```bash
$ phalcon project --help

Phalcon DevTools (3.0.0)

Help:
  Creates a project

Usage:
  project [name] [type] [directory] [enable-webtools]

Arguments:
  help    Shows this help text

Example
  phalcon project store simple

Options:
 --name               Name of the new project
 --enable-webtools    Determines if webtools should be enabled [optional]
 --directory=s        Base path on which project will be created [optional]
 --type=s             Type of the application to be generated (cli, micro, simple, modules)
 --template-path=s    Specify a template path [optional]
 --use-config-ini     Use a ini file as configuration file [optional]
 --trace              Shows the trace of the framework in case of exception. [optional]
 --help               Shows this help
```

Созданный проект можно сразу запустить в браузере:

![](/images/content/devtools-usage-02.png)

<a name='generating-controllers'></a>

## Создание контроллеров

Команда `create-controller` генерирует заготовку контроллера. Её необходимо выполнять в корне существующего проекта Phalcon.

```bash
$ phalcon create-controller --name test
```

Команда выше сформирует следующий код:

```php
<?php

use Phalcon\Mvc\Controller;

class TestController extends Controller
{
    public function indexAction()
    {

    }
}
```

<a name='database-settings'></a>

## Настройка базы данных

В проектах, созданных с использованием инструментов разработчика файл конфигурации будет искаться в `app/config/config.ini`. Для генерации моделей, вам потребуется изменить настройки, используемые для подключения к вашей базе данных.

При использовании конфигурации в файле config.ini:

```ini
[database]
adapter  = Mysql
host     = "127.0.0.1"
username = "root"
password = "secret"
dbname   = "store_db"

[phalcon]
controllersDir = "../app/controllers/"
modelsDir      = "../app/models/"
viewsDir       = "../app/views/"
baseUri        = "/store/"
```

<a name='generating-models'></a>

## Создание моделей

Существует несколько способов генерации моделей. Вы можете создать все модели по таблицам текущей базы данных или для любой таблицы выборочно. Модели может содержать публичные атрибуты или работу через сеттеры и геттеры.

```bash
Options:
 --name=s             Table name
 --schema=s           Name of the schema. [optional]
 --namespace=s        Model's namespace [optional]
 --get-set            Attributes will be protected and have setters/getters. [optional]
 --extends=s          Model extends the class name supplied [optional]
 --excludefields=l    Excludes fields defined in a comma separated list [optional]
 --doc                Helps to improve code completion on IDEs [optional]
 --directory=s        Base path on which project will be created [optional]
 --force              Rewrite the model. [optional]
 --trace              Shows the trace of the framework in case of exception. [optional]
 --mapcolumn          Get some code for map columns. [optional]
 --abstract           Abstract Model [optional]
```

Самый простой способ для создания модели:

```bash
$ phalcon model products
```

```bash
$ phalcon model --name tablename
```

Созданная модель содержит публичные атрибуты для прямого доступа.

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $typesId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $price;

    /**
     * @var integer
     */
    public $quantity;

    /**
     * @var string
     */
    public $status;
}
```

При использовании `--get-set` атрибуты модели будут закрыты для прямого изменения, работа с ними будет только через соответствующие сеттеры и геттеры. Такое поведение позволит изменить бизнес-логику работы модели внутри соответствующих методов.

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $typesId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $price;

    /**
     * @var integer
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $status;


    /**
     * Метод установки значения для поля id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Метод установки значения для поля typesId
     *
     * @param integer $typesId
     */
    public function setTypesId($typesId)
    {
        $this->typesId = $typesId;
    }

    // ...

    /**
     * Возвращает значение статуса поля
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
```

Приятной особенностью генератора моделей является то, что он сохраняет изменения, сделанные разработчиком. Это позволяет добавлять или удалять поля и свойства, не беспокоясь о потере изменений, внесенных в модель вручную. Следующий демо-ролик показывает как это работает:

<div align="center">
    <iframe src="https://player.vimeo.com/video/39213020" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

<a name='crud'></a>

## Автоматическая генерация CRUD

Скаффолдинг (scaffolding; в переводе с англ. "строительные леса") — метод метапрограммирования для создания веб-приложений, взаимодействующих с БД. Это достаточны быстрый способ для получения основных элементов приложения. Если вы хотите быстро создать модели, представления, и контроллеры для нового ресурса приложения — использование автоматической генерации кода является отличным инструментом для этих задач.

После того, как код сгенерирован, его можно настроить под себя. Многие разработчики не используют scaffolding, предпочитая писать весь код самостоятельно. Сгенерированный код может служить в качестве руководства, чтобы лучше понять основы работы или разработки прототипов. Пример ниже показывает генерацию интерфейса для таблицы `products`:

```bash
$ phalcon scaffold --table-name products
```

Генератор создаст несколько файлов в вашем приложении, и каталоги для них. Вот краткий обзор того, что будет сгенерировано:

| Файл                                     | Предназначение                      |
| ---------------------------------------- | ----------------------------------- |
| `app/controllers/ProductsController.php` | Контроллер продуктов                |
| `app/models/Products.php`                | Модель продуктов                    |
| `app/views/layout/products.phtml`        | Макет для контроллера продуктов     |
| `app/views/products/new.phtml`           | Представление для действия `new`    |
| `app/views/products/edit.phtml`          | Представление для действия `edit`   |
| `app/views/products/search.phtml`        | Представление для действия `search` |

На главной странице созданного таким образом контроллер вы увидите форму поиска, и ссылку на создание нового продукта:

![](/images/content/devtools-usage-03.png)

Страница создания продукта позволяет добавить в таблицу `products` новую запись, при этом будут использованы проверки по правилам модели Products. Phalcon будет автоматически проверять not null поля и выдавать требования о их заполнении.

![](/images/content/devtools-usage-04.png)

После выполнения поиска будут выведены результаты с постраничной навигацией. Используйте ссылки меню "Edit" или "Delete" возле каждого результата поиска, для выполнения требуемых действий.

![](/images/content/devtools-usage-05.png)

<a name='web-interface'></a>

## Веб интерфейс инструментов

Кроме того, можно использовать инструменты разработчика Phalcon используя веб-интерфейс. Подробности его работы показаны на следующем скринкасте:

<div align="center">
<iframe src="https://player.vimeo.com/video/42367665" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen mark="crwd-mark"></iframe>
</div>

<a name='phpstorm-ide'></a>

## Интеграция в PhpStorm IDE

Скринкаст показывает, как интегрировать инструменты для разработчиков с [PhpStorm IDE](http://www.jetbrains.com/phpstorm/). Аналогично можно интегрировать дополнения в любой другой PHP редактор или IDE.

<div align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/UbUx_6Cs6r4" frameborder="0" allowfullscreen mark="crwd-mark"></iframe>
</div>

<a name='conclusion'></a>

## Заключение

Инструменты разработчика Phalcon предоставляют простой способ генерации кода для ваших приложений, тем самым сокращая время разработки и количества потенциальных ошибок в коде.