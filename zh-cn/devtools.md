---
layout: default
language: 'zh-cn'
version: '4.0'
---
# Phalcon Devtools

* * *

## Overview

These tools are a collection of useful scripts to generate skeleton code. Core components of your application can be generated with a simple command, allowing you to easily develop applications using Phalcon.

> If you prefer to use the web version instead of the console, this [blog post](https://blog.phalconphp.com/post/dont-like-command-line-and-consoles-no-problem) offers more information.
{: .alert .alert-danger }

## Installation

### Linux

These steps will guide you through the process of installing Phalcon Developer Tools for Linux. The Phalcon PHP extension is required to run Phalcon Tools. If you haven't installed it yet, please see the [Installation](installation) section for instructions. You can download a cross platform package containing the developer tools from from [GitHub](https://github.com/phalcon/phalcon-devtools). Open a terminal and type the command below:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/assets/images/content/devtools-linux-1.png)

Then enter the folder where the tools were cloned and execute `. ./phalcon.sh`, (don't forget the dot at beginning of the command):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/assets/images/content/devtools-linux-2.png)

Create a symbolic link to the phalcon.php script:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

### macOS

Open a terminal and type the command below:

```bash
git clone git://github.com/phalcon/phalcon-devtools.git
```

![](/assets/images/content/devtools-mac-1.png)

Then enter the folder where the tools were cloned and execute `. ./phalcon.sh`, (don't forget the dot at beginning of the command):

```bash
cd phalcon-devtools/
. ./phalcon.sh
```

![](/assets/images/content/devtools-mac-2.png)

Next, we'll create a symbolic link to the `phalcon.php` script. On El Capitan and newer versions of macOS:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/local/bin/phalcon
chmod ugo+x /usr/local/bin/phalcon
```

if you are running an older version:

```bash
ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon
chmod ugo+x /usr/bin/phalcon
```

### Windows

On the Windows platform, you need to configure the system `PATH` to include Phalcon tools as well as the PHP executable. If you download the Phalcon tools as a zip archive, extract it on any path of your local drive i.e. `c:\phalcon-tools`. You will need this path in the steps below. Edit the file `phalcon.bat` by right clicking on the file and selecting `Edit`:

![](/assets/images/content/devtools-windows-1.png)

Change the path to the one you installed the Phalcon tools (`set PTOOLSPATH=C:\phalcon-tools`):

![](/assets/images/content/devtools-windows-2.png)

Save the changes.

#### Adding PHP and Tools to your system PATH

Because the scripts are written in PHP, you need to install it on your machine. Depending on your PHP installation, the executable can be located in various places. Search for the file `php.exe` and copy its path. For instance, using WAMPP you will locate the PHP executable in a location like this: `C:\wamp\bin\php\<php version>\php.exe` (where `<php version>` is the version of PHP that WAMPP comes bundled with).

From the Windows start menu, right mouse click on the `Computer` icon and select `Properties`:

![](/assets/images/content/devtools-windows-3.png)

Click the `Advanced` tab and then the button `Environment Variables`:

![](/assets/images/content/devtools-windows-4.png)

At the bottom, look for the section `System variables` and edit the variable `Path`:

![](/assets/images/content/devtools-windows-5.png)

Be very careful on this step! You need to append at the end of the long string the path where your `php.exe` was located and the path where Phalcon tools are installed. Use the `;` character to separate the different paths in the variable:

![](/assets/images/content/devtools-windows-6.png)

Accept the changes made by clicking `OK` and close the dialogs opened. From the start menu click on the option `Run`. If you can't find this option, press `Windows Key` + `R`.

![](/assets/images/content/devtools-windows-7.png)

Type `cmd` and press enter to open the windows command line utility:

![](/assets/images/content/devtools-windows-8.png)

Type the commands `php -v` and `phalcon` and you will see something like this:

![](/assets/images/content/devtools-windows-9.png)

Congratulations you now have Phalcon tools installed!

## Usage

### Available Commands

You can get a list of available commands in Phalcon tools by typing: `phalcon commands`

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

### Generating a Project Skeleton

You can use Phalcon tools to generate pre-defined project skeletons for your applications with Phalcon framework. By default the project skeleton generator will use mod_rewrite for Apache. Type the following command on your web server document root:

```bash
$ pwd

/Applications/MAMP/htdocs

$ phalcon create-project store
```

The above recommended project structure was generated:

![](/assets/images/content/devtools-usage-01.png)

You could add the parameter `--help` to get help on the usage of a certain script:

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

Accessing the project from the web server will show you:

![](/assets/images/content/devtools-usage-02.png)

### Generating Controllers

The command `create-controller` generates controller skeleton structures. It's important to invoke this command inside a directory that already has a Phalcon project.

```bash
$ phalcon create-controller --name test
```

The following code is generated by the script:

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

### Preparing Database Settings

When a project is generated using developer tools. A configuration file can be found in `app/config/config.php`. To generate models or scaffold, you will need to change the settings used to connect to your database.

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
        'baseUri'        => preg_replace(
            '/public([\/\\])index.php$/', 
            '', 
            $_SERVER["PHP_SELF"]
        ),
    ]
]);
```

### Generating Models

There are several ways to create models. You can create all models from the default database connection or some selectively. Models can have public attributes for the field representations or setters/getters can be used.

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

### Scaffold a CRUD

Scaffolding is a quick way to generate some of the major pieces of an application. If you want to create the models, views, and controllers for a new resource in a single operation, scaffolding is the tool for the job.

Once the code is generated, it will have to be customized to meet your needs. Many developers avoid scaffolding entirely, opting to write all or most of their source code from scratch. The generated code can serve as a guide to better understand of how the framework works or develop prototypes. The code below shows a scaffold based on the table `products`:

```bash
$ phalcon scaffold --table-name products
```

The scaffold generator will build several files in your application, along with some folders. Here's a quick overview of what will be generated:

| File                                     | 目的             |
| ---------------------------------------- | -------------- |
| `app/controllers/ProductsController.php` | 产品控制器          |
| `app/models/Products.php`                | Products 模型    |
| `app/views/layout/products.phtml`        | 产品的控制器布局       |
| `app/views/products/new.phtml`           | `new`操作的视图     |
| `app/views/products/edit.phtml`          | `edit` 操作的视图   |
| `app/views/products/search.phtml`        | `search` 操作的视图 |

When browsing the recently generated controller, you will see a search form and a link to create a new Product:

![](/assets/images/content/devtools-usage-03.png)

The `create page` allows you to create products applying validations on the Products model. Phalcon will automatically validate not null fields producing warnings if any of them is required.

![](/assets/images/content/devtools-usage-04.png)

After performing a search, a pager component is available to show paged results. Use the "Edit" or "Delete" links in front of each result to perform such actions.

![](/assets/images/content/devtools-usage-05.png)

### Web Interface to Tools

Also, if you prefer, it's possible to use Phalcon Developer Tools from a web interface. Check out the following screencast to figure out how it works:

<div align="center">
<iframe src="https://player.vimeo.com/video/42367665" width="500" height="266" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen mark="crwd-mark"></iframe>
</div>

### Integrating Tools with PhpStorm IDE

The screencast below shows how to integrate developer tools with the [PhpStorm IDE](https://www.jetbrains.com/phpstorm/). The configuration steps could be easily adapted to other IDEs for PHP.

<div align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/UbUx_6Cs6r4" frameborder="0" allowfullscreen mark="crwd-mark"></iframe>
</div>
