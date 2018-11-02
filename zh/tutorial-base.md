<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">教程-基本</a> 
      <ul>
        <li>
          <a href="#file-structure">文件结构</a>
        </li>
        <li>
          <a href="#bootstrap">启动</a> 
          <ul>
            <li>
              <a href="#autoloaders">自动加载</a>
            </li>
            <li>
              <a href="#dependency-management">依赖关系管理</a>
            </li>
            <li>
              <a href="#request">处理应用程序请求</a>
            </li>
            <li>
              <a href="#full-example">把一切都放在一起</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#controller">创建控制器</a>
        </li>
        <li>
          <a href="#view">将输出发送到一个视图</a>
        </li>
        <li>
          <a href="#signup-form">设计注册表单</a>
        </li>
        <li>
          <a href="#model">创建模型</a>
        </li>
        <li>
          <a href="#database-connection">设置数据库连接</a>
        </li>
        <li>
          <a href="#storing-data">使用模型存储数据</a>
        </li>
        <li>
          <a href="#conclusion">结论</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# 教程-基本

Throughout this tutorial, we'll walk you through the creation of an application with a simple registration form from the ground up. The following guide is to provided to introduce you to Phalcon framework's design aspects.

If you just want to get started you can skip this and create a Phalcon project automatically with our [developer tools](/[[language]]/[[version]]/devtools-usage). (It is recommended that if you have not had experience with to come back here if you get stuck)

The best way to use this guide is to follow along and try to have fun. You can get the complete code [here](https://github.com/phalcon/tutorial). If you get hung-up on something please visit us on [Discord](https://phalcon.link/discord) or in our [Forum](https://phalcon.link/forum)

<a name='file-structure'></a>

## 文件结构

A key feature of Phalcon is it's **loosely coupled**, you can build a Phalcon project with a directory structure that is convenient for your specific application. That said some uniformity is helpful when collaborating with others, so this tutorial will use a "Standard" structure where you should feel at home if you have worked with other MVC's in the past.   


```text
┗ tutorial
   ┣ app
   ┇ ┣ controllers
   ┇ ┇ ┣ IndexController.php
   ┇ ┇ ┗ SignupController.php
   ┇ ┣ models
   ┇ ┇ ┗ Users.php
   ┇ ┗ views
   ┗ public
      ┣ css
      ┣ img
      ┣ js
      ┗ index.php
```

Note: You will not see a **vendor** directory as all of Phalcon's core dependencies are loaded into memory via the Phalcon extension you should have installed. If you missed that part have not installed the Phalcon extension [please go back](/[[language]]/[[version]]/installation) and finish the installation before continuing.

If this is all brand new it is recommended that you install the [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation) since it leverages PHP's built-in server you to get your app running without having to configure a web server by adding this [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) to the root of your project.

Otherwise if you want to use Nginx here are some additional setup [here](/[[language]]/[[version]]/webserver-setup#nginx)

Apache can also be used with these additional setup [here](/[[language]]/[[version]]/webserver-setup#apache)

Finally, if you flavor is Cherokee use the setup [here](/[[language]]/[[version]]/webserver-setup#cherokee)

<a name='bootstrap'></a>

## 启动

您需要创建的第一个文件是引导文件。 This file acts as the entry-point and configuration for your application. In this file, you can implement initialization of components as well as application behavior.

This file handles 3 things: - Registration of component autoloaders. - Configuring **Services** and registering them with the **Dependency Injection** context. - Resolving the application's HTTP requests.

<a name='autoloaders'></a>

### 自动加载

Autoloaders leverage a [PSR-4](http://www.php-fig.org/psr/psr-4/) compliant file loader running through the Phalcon C extension. Common things that should be added to the Autoloader are your **Controllers** and **Models**. You can register **directories** which will search for files within the application's namespace. (If you want to read about other ways that you can use Autoloaders head [here](/[[language]]/[[version]]/loader#overview))

To start, lets register our app's **controllers** and **models** directories. Don't forget to include the loader from `Phalcon\Loader`.

  
**public/index.php**

```php
<?php

use Phalcon\Loader;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();
```

  

<a name='dependency-management'></a>

### 依赖关系管理

Since Phalcon is **loosely coupled** services are registered with the frameworks Dependency Manager so they can be injected automatically to components and services wrapped in the **IoC** container. Frequently you will encounter the term **DI** which stands for Dependency Injection. Dependency Injection and Inversion of Control(IoC) may sound like a complex feature but in Phalcon their use is very simple and practical. Phalcon's IoC container consists of the following concepts: - Service Container: a "bag" where we globally store the services that our application needs to function. - Service or Component: Data processing object which will be injected into components

If you are still interested in the details please see this article by [Martin Fowler](https://martinfowler.com/articles/injection.html)

Each time the framework requires a component or service, it will ask the container using an agreed upon name for the service. Don't forget to include `Phalcon\Di` with setting up the service container.

Services can be registered in several ways, but for our tutorial, we'll use an [anonymous function](http://php.net/manual/en/functions.anonymous.php):

### Factory Default

`Phalcon\Di\FactoryDefault` 是 `Phalcon\Di` 的变体。 To make things easier, it will automatically register most of the components that come with Phalcon. We recommend that you register your services manually but this has been included to help lower the barrier of entry when getting used to Dependency Management. Later, you can always specify once you become more comfortable with the concept.

  
**public/index.php**

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

  


在下一部分中，我们注册表示框架在这里可以品尝意见文件的目录的"view"服务。 如意见不对应的类，它们不能自动加载。

  
**public/index.php**

```php
<?php

use Phalcon\Mvc\View;

// ...

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);
```

  


Next, we register a base URI so that all URIs generated by Phalcon include the "tutorial" folder we setup earlier. 当我们使用 `Phalcon\Tag` 类来生成超链接，这将成为重要稍后在本教程中。

  
**public/index.php**

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);
```

  

<a name='request'></a>

### Handling the application request

在该文件的最后一部分，我们发现 `Phalcon\Mvc\Application`。 其目的是以初始化请求环境，路由传入的请求，然后派遣任何发现的行动; 它聚合了任何响应，并将它们返回过程完成后。

  
**public/index.php**

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);
$response = $application->handle();
$response->send();
```

  

<a name='full-example'></a>

### Putting everything together

`Tutorial/public/index.php` 文件应该看起来像：

  
**public/index.php**

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

// Create a DI
$di = new FactoryDefault();

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

  
As you can see, the bootstrap file is very short and we do not need to include any additional files. **Congratulations** you are well on your to having created a flexible MVC application in less than 30 lines of code.

<a name='controller'></a>

## 创建控制器

By default Phalcon will look for a controller named **IndexController**. It is the starting point when no controller or action has been added in the request. (eg. http://localhost:8000/) An **IndexController** and its **IndexAction** should resemble the following example:

  
**app/controllers/IndexController.php**

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        echo '<h1>Hello!</h1>';
    }
}
```

控制器类必须有后缀"Controller"和控制器操作必须有后缀"Action"。如果您从您的浏览器访问该应用程序，您应该看到这样的事情：

  
![](/images/content/tutorial-basic-1.png)

  
Congratulations, you're phlying with Phalcon!

<a name='view'></a>

## 将输出发送到一个视图

将输出发送到屏幕从控制器有时是必要的但不是可取大多数纯粹主义者在 MVC 社区将证明这一点。 一切必须传递给视图，它负责输出屏幕上的数据。 Phalcon将查找具有相同名称的最后一个视图执行行动作为最后一个执行控制器命名的目录里面。 在我们的例子 (`app/views/index/index.phtml`):

  
**app/views/index/index.phtml**

```php
<?php echo "<h1>Hello!</h1>";
```

  


我们的控制器 (`app/controllers/IndexController.php`) 现在有一个空操作定义：

  
**app/controllers/IndexController.php**

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {

    }
}
```

  


浏览器输出应保持不变。 `Phalcon\Mvc\View` 静态组件操作执行结束时自动创建。 Learn more about `views usage here <views>`.

<a name='signup-form'></a>

## Designing a sign-up form

现在我们将改变 `index.phtml` 视图文件，将链接添加到新的控制器命名为"signup"。目标是允许用户在我们的应用程序内报名。

  
**app/views/index/index.phtml**

```php
<?php

echo "<h1>Hello!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    "signup",
    "Sign Up Here!"
);
```

  


生成的 HTML 代码显示链接到一个新的控制器 ("a") 的 HTML 锚标记：

  
**app/views/index/index.phtml Rendered**

```html
<h1>Hello!</h1>

<a href="/signup">Sign Up Here!</a>
```

  


若要生成标记我们使用 `Phalcon\Tag` 类。 这是一个实用程序类，使我们能够构建与框架公约在头脑中的 HTML 标记。 As this class is also a service registered in the DI we use `$this->tag` to access it.

A more detailed article regarding HTML generation can be found [here <tags>](/[[language]]/[[version]]/tag).

  
![](/images/content/tutorial-basic-2.png)

  
这里是注册控制器 (`app/controllers/SignupController.php`):

  
**app/controllers/SignupController.php**

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }
}
```

  


空索引行动给清洁通的视图中，窗体定义 (`app/views/signup/index.phtml`):

  
**app/views/signup/index.phtml**

```php
<h2>Sign up using this form</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">Name</label>
        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">E-Mail</label>
        <?php echo $this->tag->textField("email"); ?>
    </p>

    <p>
        <?php echo $this->tag->submitButton("Register"); ?>
    </p>

</form>
```

  


在您的浏览器中查看窗体将显示这样的事情：

  
![](/images/content/tutorial-basic-3.png)

  
`Phalcon\Tag` 还提供了有用的方法，以生成窗体元素。

:code: `Phalcon\Tag::form()` 方法在应用程序中接收只有一个参数为例，相对 URI 的控制器操作。

通过单击"Send"按钮，你会发现从框架，引发的异常指示我们缺少控制器"register"中的"signup"操作。 我们的 `public/index.php` 文件会引发此异常：

```bash
例外： 行动"register"中找不到处理程序"signup"
```

实施这种方法将删除该异常：

  
**app/controllers/SignupController.php**

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {

    }
}
```

  


如果您再次单击"Send"按钮，您将看到一个空白页面。 The name and email input provided by the user should be stored in a database. 根据 MVC 的指引，必须通过模型完成数据库交互以确保干净的面向对象的代码。

<a name='model'></a>

## 创建模型

Phalcon为完全用 C 语言编写的 PHP 带来第一个 ORM。而不是增加发展的复杂性，它简化了它。

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be created like this:

  
**create_users_table.sql**

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

  


模型应该位于 `app/models` 目录 (`app/models/Users.php`)。该模型将映射到"users"表：

  
**app/models/Users.php**

```php
<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $name;
    public $email;
}
```

  

<a name='database-connection'></a>

## 设置数据库连接

In order to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. 数据库连接是我们应用程序的另一个服务可以用于几个组件：

  
**public/index.php**

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Setup the database service
$di->set(
    'db',
    function () {
        return new DbAdapter(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial1',
            ]
        );
    }
);
```

  


使用正确的数据库的参数，我们的模型已作好准备工作，并与其余的应用程序进行交互。

<a name='storing-data'></a>

## 使用模型存储数据

  
**app/controllers/SignupController.php**

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        $user = new Users();

        // Store and check for errors
        $success = $user->save(
            $this->request->getPost(),
            [
                "name",
                "email",
            ]
        );

        if ($success) {
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
```

  


At the beginning of the **registerAction** we create an empty user object from the Users class, which manages a User's record. The class's public properties map to the fields of the `users` table in our database. 设置新记录中的相关值以及调用 `save （）` 会将数据存储在数据库中为该记录。 `Save （）` 方法返回一个布尔值，该值指示存储的数据是否成功或不。

ORM 自动逃脱防止 SQL 注入，所以我们只需要将请求传递到 `save()` 方法的输入。

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

  
![](/images/content/tutorial-basic-4.png)

  
<a name='conclusion'></a>

## 结论

As you can see, it's easy to start building an application using Phalcon. The fact that Phalcon runs from an extension significantly reduces the footprint of projects as well as giving it a considerable performance boost.

If you are ready to learn more check out the [Rest Tutorial](/[[language]]/[[version]]/tutorial-rest) next.