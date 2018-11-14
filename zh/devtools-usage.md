<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Phalcon开发人员工具</a> <ul>
        <li>
          <a href="#download">下载</a>
        </li>
        <li>
          <a href="#installation">安装</a>
        </li>
        <li>
          <a href="#available-commands">可用的命令</a>
        </li>
        <li>
          <a href="#project-skeleton">生成一个项目骨架</a>
        </li>
        <li>
          <a href="#generating-controllers">生成控制器</a>
        </li>
        <li>
          <a href="#database-settings">准备数据库设置</a>
        </li>
        <li>
          <a href="#generating-models">生成模型</a>
        </li>
        <li>
          <a href="#crud">CURD 脚手架</a>
        </li>
        <li>
          <a href="#web-interface">工具的 web 接口</a>
        </li>
        <li>
          <a href="#phpstorm-ide">Integrating Tools with PhpStorm IDE</a>
        </li>
        <li>
          <a href="#conclusion">结语</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Phalcon开发人员工具

这些工具是生成骨架代码的有用脚本的集合。 应用程序的核心组件可以通过简单的命令生成, 使您可以轻松地使用 Phalcon开发应用程序。

<h5 class='alert alert-danger'>如果您更喜欢使用 web 版本而不是控制台, 则此 < 0>blog post</0 > 提供更多信息。 </h5>

<a name='download'></a>

## 下载

你可以从[Github](https://github.com/phalcon/phalcon-devtools)下载或克隆一个跨平台的开发者工具包。

<a name='installation'></a>

## 安装

以下是有关如何在不同平台上安装开发人员工具的详细说明:

[Linux](/[[language]]/[[version]]devtools-installation#installation-linux) : [MacOS](/[[language]]/[[version]]devtools-installation#installation-macos) : [Windows](/[[language]]/[[version]]devtools-installation#installation-windows)

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

![](/images/content/devtools-usage-01.png)

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

![](/images/content/devtools-usage-02.png)

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

使用开发人员工具生成项目时。 配置文件可以在`app/config/config.ini`中找到。 要生成模型或脚手架，需要更改连接到数据库的设置。

更改配(config.ini)中的数据库部分文件:

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

## Generating Models

创建模型有几种方法。 您可以从默认数据库连接或有选择地创建所有模型。 Models can have public attributes for the field representations or setters/getters can be used.

```bash
Options:
 --name=s             表名
 --schema=s           数据库名 [optional]
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

The simplest way to generate a model is:

```bash
$ phalcon model products
```

```bash
$ phalcon model --name tablename
```

All table fields are declared public for direct access.

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

By adding the `--get-set` you can generate the fields with protected variables and public setter/getter methods. Those methods can help in business logic implementation within the setter/getter methods.

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

A nice feature of the model generator is that it keeps changes made by the developer between code generations. This allows the addition or removal of fields and properties, without worrying about losing changes made to the model itself. The following screencast shows you how it works:

<div align="center">
    <iframe src="https://player.vimeo.com/video/39213020" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

<a name='crud'></a>

## Scaffold a CRUD

Scaffolding is a quick way to generate some of the major pieces of an application. If you want to create the models, views, and controllers for a new resource in a single operation, scaffolding is the tool for the job.

Once the code is generated, it will have to be customized to meet your needs. Many developers avoid scaffolding entirely, opting to write all or most of their source code from scratch. The generated code can serve as a guide to better understand of how the framework works or develop prototypes. The code below shows a scaffold based on the table `products`:

```bash
$ phalcon scaffold --table-name products
```

The scaffold generator will build several files in your application, along with some folders. Here's a quick overview of what will be generated:

| File                                     | Purpose                        |
| ---------------------------------------- | ------------------------------ |
| `app/controllers/ProductsController.php` | The Products controller        |
| `app/models/Products.php`                | The Products model             |
| `app/views/layout/products.phtml`        | Controller layout for Products |
| `app/views/products/new.phtml`           | View for the action `new`      |
| `app/views/products/edit.phtml`          | View for the action `edit`     |
| `app/views/products/search.phtml`        | View for the action `search`   |

When browsing the recently generated controller, you will see a search form and a link to create a new Product:

![](/images/content/devtools-usage-03.png)

The `create page` allows you to create products applying validations on the Products model. Phalcon will automatically validate not null fields producing warnings if any of them is required.

![](/images/content/devtools-usage-04.png)

After performing a search, a pager component is available to show paged results. Use the "Edit" or "Delete" links in front of each result to perform such actions.

![](/images/content/devtools-usage-05.png)

<a name='web-interface'></a>

## Web Interface to Tools

Also, if you prefer, it's possible to use Phalcon Developer Tools from a web interface. Check out the following screencast to figure out how it works:

<div align="center">
<iframe src="https://player.vimeo.com/video/42367665" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen mark="crwd-mark"></iframe>
</div>

<a name='phpstorm-ide'></a>

## Integrating Tools with PhpStorm IDE

The screencast below shows how to integrate developer tools with the [PhpStorm IDE](http://www.jetbrains.com/phpstorm/). The configuration steps could be easily adapted to other IDEs for PHP.

<div align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/UbUx_6Cs6r4" frameborder="0" allowfullscreen mark="crwd-mark"></iframe>
</div>

<a name='conclusion'></a>

## Conclusion

Phalcon Developer Tools provides an easy way to generate code for your application, reducing development time and potential coding errors.