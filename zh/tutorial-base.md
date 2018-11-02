<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">教程-基本</a> <ul>
        <li>
          <a href="#file-structure">文件结构</a>
        </li>
        <li>
          <a href="#bootstrap">启动</a> <ul>
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

在第一个教程中，我们将从头到尾带您从头到尾创建一个带有简单注册表单的应用程序。 我们还将解释框架的行为的基本方面。 如果你有兴趣在Phalcon的自动代码生成工具，你可以检查我们的 [开发人员工具](/[[language]]/[[version]]/developer-tools)。

使用本指南的最佳方法是依次执行每个步骤。你可以获得完整的代码 [在这里](https://github.com/phalcon/tutorial)。

<a name='file-structure'></a>

## 文件结构

Phalcon没有为应用程序开发强加特定的文件结构。 Due to the fact that it is loosely coupled, you can implement Phalcon powered applications with a file structure you are most comfortable using.

出于本教程的和作为一个起点，我们建议这个非常简单的结构：

```bash
tutorial/
  app/
    controllers/
    models/
    views/
  public/
    css/
    img/
    js/
```

注意，您不需要任何有关 Phalcon的"library"目录。框架是可在内存中，随时供您使用。

在继续之前，请务必您已经成功地 [安装Phalcon](/[[language]]/[[version]]/installation) 和已安装程序要么 [nginX](/[[language]]/[[version]]/setup#nginx)，[Apache](/[[language]]/[[version]]/setup#apache) 或 [Cherokee](/[[language]]/[[version]]/setup#cherokee)。

<a name='bootstrap'></a>

## 启动

您需要创建的第一个文件是引导文件。 此文件是非常重要的; 因为它作为您的应用程序，使您能够控制它的各个方面的基础。 在此文件中，您可以实现初始化组件以及应用程序的行为。

最终，它是负责做 3 件事：

- 设置自动加载。
- 配置依赖注入器。
- 处理应用程序请求

<a name='autoloaders'></a>

### 自动加载

第一部分，我们发现在引导正在注册自动加载。 这将用于作为控制器和模型在应用程序中加载的类。 例如我们可以注册一个或多个目录的控制器增加应用程序的灵活性。 在我们的例子中我们使用 `Phalcon\Loader` 组件。

有了它，我们可以加载类使用各种策略，但本例中我们选择定位基于预定义目录类：

```php
<?php

use Phalcon\Loader;

// ...

$loader = new Loader();

$loader->registerDirs(
    [
        '../app/controllers/',
        '../app/models/',
    ]
);

$loader->register();
```

<a name='dependency-management'></a>

### 依赖关系管理

当工作与Phalcon是其 `依赖注入容器 1` 必须理解的非常重要的概念。 这可能听起来复杂，但实际上是非常简单和实用。

服务容器就是一袋在哪里我们全球存储我们的应用程序将使用的服务功能。 每个时间框架所需的组件，它会询问容器使用商定后服务的名称。 因为Phalcon是一个高度解耦的框架，`Phalcon\Di` 作为胶促进实现他们的工作在一起以透明的方式的不同组件的集成。

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

`Phalcon\Di\FactoryDefault` 是 `Phalcon\Di` 的变体。 为了使事情更容易，它已注册的大部分组件附带Phalcon。 因此我们不应注册逐一进行。 后来将取代工厂服务没有问题。

在下一部分中，我们注册表示框架在这里可以品尝意见文件的目录的"view"服务。 如意见不对应的类，它们不能自动加载。

服务可以注册几个方面，但对于我们的教程中，我们将使用 [匿名函数](http://php.net/manual/en/functions.anonymous.php)：

```php
<?php

use Phalcon\Mvc\View;

// ...

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);
```

接下来我们注册的基 URI，以便所有 Uri 由Phalcon生成都包括我们刚才设置的"教程"文件夹。 当我们使用 `Phalcon\Tag` 类来生成超链接，这将成为重要稍后在本教程中。

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $url = new UrlProvider();

        $url->setBaseUri('/tutorial/');

        return $url;
    }
);
```

<a name='request'></a>

### 处理应用程序请求

在该文件的最后一部分，我们发现 `Phalcon\Mvc\Application`。 其目的是以初始化请求环境，路由传入的请求，然后派遣任何发现的行动; 它聚合了任何响应，并将它们返回过程完成后。

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);

$response = $application->handle();

$response->send();
```

<a name='full-example'></a>

### 把一切都放在一起

`Tutorial/public/index.php` 文件应该看起来像：

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        '../app/controllers/',
        '../app/models/',
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

        $view->setViewsDir('../app/views/');

        return $view;
    }
);

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $url = new UrlProvider();

        $url->setBaseUri('/tutorial/');

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

正如你所看到的引导文件是很短，我们不需要包括任何其他文件。我们有少于 30 行代码设置自己灵活的 MVC 应用程序。

<a name='controller'></a>

## 创建控制器

By default Phalcon will look for a controller named "Index". It is the starting point when no controller or action has been passed in the request. 索引控制器 (`app/controllers/IndexController.php`) 看起来像：

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

```php
<?php echo "<h1>Hello!</h1>";
```

我们的控制器 (`app/controllers/IndexController.php`) 现在有一个空操作定义：

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

## 设计注册表单

现在我们将改变 `index.phtml` 视图文件，将链接添加到新的控制器命名为"signup"。目标是允许用户在我们的应用程序内报名。

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

```html
<h1>Hello!</h1>

<a href="/tutorial/signup">Sign Up Here!</a>
```

若要生成标记我们使用 `Phalcon\Tag` 类。 这是一个实用程序类，使我们能够构建与框架公约在头脑中的 HTML 标记。 由于此类也是在 DI 中注册的服务, 因此我们使用 `$this->tag ` 来访问它。

关于 HTML 生成更详细的文章可以是 :doc: `发现这里 <tags> `。

![](/images/content/tutorial-basic-2.png)

这里是注册控制器 (`app/controllers/SignupController.php`):

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

```php
<h2>
    Sign up using this form
</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">
            Name
        </label>

        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">
            E-Mail
        </label>

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

通过单击"Send"按钮，你会发现从框架，引发的异常指示我们缺少控制器"register"中的"signup"操作。 Our `public/index.php` file throws this exception:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementing that method will remove the exception:

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

If you click the "Send" button again, you will see a blank page. The name and email input provided by the user should be stored in a database. According to MVC guidelines, database interactions must be done through models so as to ensure clean object-oriented code.

<a name='model'></a>

## Creating a Model

Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be defined like this:

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

A model should be located in the `app/models` directory (`app/models/Users.php`). The model maps to the "users" table:

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

## Setting a Database Connection

In order to be able to use a database connection and subsequently access data through our models, we need to specify it in our bootstrap process. A database connection is just another service that our application has that can be used for several components:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Setup the database service
$di->set(
    'db',
    function () {
        return new DbAdapter(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'test_db',
            ]
        );
    }
);
```

With the correct database parameters, our models are ready to work and interact with the rest of the application.

<a name='storing-data'></a>

## Storing data using models

Receiving data from the form and storing them in the table is the next step.

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

We then instantiate the Users class, which corresponds to a User record. The class public properties map to the fields of the record in the users table. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

The ORM automatically escapes the input preventing SQL injections so we only need to pass the request to the `save()` method.

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign up form our screen will look like this:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusion

This is a very simple tutorial and as you can see, it's easy to start building an application using Phalcon. The fact that Phalcon is an extension on your web server has not interfered with the ease of development or features available. We invite you to continue reading the manual so that you can discover additional features offered by Phalcon!