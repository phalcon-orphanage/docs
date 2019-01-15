* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Phalcon开发人员工具

这些工具是生成骨架代码的有用脚本的集合。 应用程序的核心组件可以通过简单的命令生成, 使您可以轻松地使用 Phalcon开发应用程序。

<h5 class='alert alert-danger'>If you prefer to use the web version instead of the console, this <a href="https://blog.phalconphp.com/post/dont-like-command-line-and-consoles-no-problem">blog post</a> offers more information. </h5>

<a name='download'></a>

## 下载

你可以从[Github](https://github.com/phalcon/phalcon-devtools)下载或克隆一个跨平台的开发者工具包。

<a name='installation'></a>

## Installation

以下是有关如何在不同平台上安装开发人员工具的详细说明:

[Linux](/[/4.0/en/devtools-installation#installation-linux) : [MacOS](/4.0/en/devtools-installation#installation-macos) : [Windows](/4.0/en/devtools-installation#installation-windows)

<a name='available-commands'></a>

## 可用的命令

通过输入 typing::code:` Phalcon commands`，您可以在Phalcon工具中获得一组可用的命令

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

## 生成一个项目骨架

您可以使用Phalcon工具为您的应用程序生成预定义的项目框架。 默认情况下，项目框架生成器将生成Apache使用的mod_rewrite。 在web服务器文档根上键入以下命令:

```bash
$ pwd

/Applications/MAMP/htdocs

$ phalcon create-project store
```

产生以上推荐的项目结构:

![](/assets/images/content/devtools-usage-01.png)

您可以添加参数`--help`来获得关于某个脚本使用的帮助:

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

从web服务器访问项目将显示:

![](/assets/images/content/devtools-usage-02.png)

<a name='generating-controllers'></a>

## 生成控制器

命令` create-controller `生成控制器骨架结构。 在已经有一个Phalcon项目的目录中调用这个命令是很重要的。

```bash
$ phalcon create-controller --name test
```

以下代码由脚本生成:

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

## 准备数据库设置

使用开发人员工具生成项目时。 A configuration file can be found in `app/config/config.php`. 要生成模型或脚手架，需要更改连接到数据库的设置。

Change the database section in your config.php file:

```php
<?php
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'secret',
        'dbname'      => 'test',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ]
]);
```

<a name='generating-models'></a>

## 生成模型

创建模型有几种方法。 您可以从默认数据库连接或有选择地创建所有模型。 Models can have public attributes for the field representations or setters/getters can be used.

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

生成模型的最简单方法是:

```bash
$ phalcon model products
```

```bash
$ phalcon model --name tablename
```

所有表字段都声明为公共以便直接访问。

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

通过添加`--get-set`，您可以使用受保护的变量和公共setter/getter方法生成字段。 这些方法可以帮助在setter/getter方法中实现业务逻辑。

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
     * Method to set the value of field id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Method to set the value of field typesId
     *
     * @param integer $typesId
     */
    public function setTypesId($typesId)
    {
        $this->typesId = $typesId;
    }

    // ...

    /**
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
```

模型生成器的一个很好的特性是，它可以在代码生成之间保持开发人员所做的更改。 这允许添加或删除字段和属性，而不必担心会丢失对模型本身所做的更改。 下面的视频展示了它的工作原理:

<div align="center">
    <iframe src="https://player.vimeo.com/video/39213020" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

<a name='crud'></a>

## CURD 脚手架

脚手架是生成应用程序主要部分的一种快速方法。 如果您希望在单个操作中为新资源创建模型、视图和控制器，那么脚手架就是这项工作的工具。

一旦生成了代码，就必须对其进行定制，以满足您的需求。 许多开发人员完全避免搭建代码，而是选择从头开始编写全部或大部分源代码。 生成的代码可以作为指导，更好地理解框架如何工作或开发原型。 下面的代码显示了基于表`products`的脚手架:

```bash
$ phalcon scaffold --table-name products
```

脚手架生成器将在应用程序中生成多个文件, 以及一些文件夹。下面是将生成的内容的快速概述:

| File                                     | 目的             |
| ---------------------------------------- | -------------- |
| `app/controllers/ProductsController.php` | 产品控制器          |
| `app/models/Products.php`                | Products 模型    |
| `app/views/layout/products.phtml`        | 产品的控制器布局       |
| `app/views/products/new.phtml`           | `new`操作的视图     |
| `app/views/products/edit.phtml`          | `edit` 操作的视图   |
| `app/views/products/search.phtml`        | `search` 操作的视图 |

浏览最近生成的控制器时, 您将看到一个搜索窗体和一个用于创建新产品的链接:

![](/assets/images/content/devtools-usage-03.png)

"0>create 页 </0 > 允许您在" 产品 "模型上创建应用验证的产品。 如果需要其中任何一个, phalcon 将自动验证非空字段并生成警告。

![](/assets/images/content/devtools-usage-04.png)

执行搜索后, 分页组件可用于显示分页结果。使用每个结果前面的 "编辑" 或 "删除" 链接执行此类操作。

![](/assets/images/content/devtools-usage-05.png)

<a name='web-interface'></a>

## 工具的 web 接口

此外, 如果您愿意, 可以从 web 界面使用 phalcon 开发人员工具。查看下面的屏幕截图, 了解其工作原理:

<div align="center">
<iframe src="https://player.vimeo.com/video/42367665" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen mark="crwd-mark"></iframe>
</div>

<a name='phpstorm-ide'></a>

## Integrating Tools with PhpStorm IDE

The screencast below shows how to integrate developer tools with the [PhpStorm IDE](https://www.jetbrains.com/phpstorm/). 配置步骤可以很容易地适应 php 的其他 ide。

<div align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/UbUx_6Cs6r4" frameborder="0" allowfullscreen mark="crwd-mark"></iframe>
</div>

<a name='conclusion'></a>

## 结语

Phalcon开发人员工具提供了一种为应用程序生成代码的简单方法, 从而减少了开发时间和潜在的编码错误。