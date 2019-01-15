* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='di-service-location'></a>

# 依赖注入 / 服务定位

<a name='di-explained'></a>

## DI 解释

下面的示例是有点长，但它试图解释为什么Phalcon使用服务定位和依赖关系注入。 首先，让我们假设我们正在开发一个称为 `SomeComponent` 的组件。 这个组件执行某一任务。 我们的组件具有依赖项，就是与数据库的连接。

在这第一个示例中，连接是在组件内创建的。 Although this is a perfectly valid implementation, it is impartical, due to the fact that we cannot change the connection parameters or the type of the database system because the component only works as created.

```php
<?php

class SomeComponent
{
    /**
     * The instantiation of the connection is hardcoded inside
     * the component, therefore it's difficult replace it externally
     * or change its behavior
     */
    public function someDbTask()
    {
        $connection = new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );

        // ...
    }
}
    }
}

$some = new SomeComponent();

$some->someDbTask();
```

为了解决这一缺陷，我们在使用它之前先创建这个依赖并且将它注入。这也是一种实现方式，但有其不足之处：

```php
<?php

class SomeComponent
{
    private $connection;

    /**
     * Sets the connection externally
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }
}

$some = new SomeComponent();

// Create the connection
$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Inject the connection in the component
$some->setConnection($connection);

$some->someDbTask();
```

现在考虑，我们使用此组件在应用程序的不同部分，然后我们将需要创建传递给该组件之前几次连接。 使用全局注册表模式，我们可以存储连接对象在那里和重用它，当我们需要它的时候。

```php
<?php

class Registry
{
    /**
     * Returns the connection
     */
    public static function getConnection()
    {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
}

class SomeComponent
{
    protected $connection;

    /**
     * Sets the connection externally
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }
}

$some = new SomeComponent();

// Pass the connection defined in the registry
$some->setConnection(Registry::getConnection());

$some->someDbTask();
```

现在，让我们想象一下，我们必须实现两个方法在该组件上，第一次总是需要创建一个新的连接和第二个总是需要使用一个共享的连接：

```php
<?php

class Registry
{
    protected static $connection;

    /**
     * Creates a connection
     *
     * @return Connection
     */
    protected static function createConnection(): Connection
    {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }

    /**
     * Creates a connection only once and returns it
     *
     * @return Connection
     */
    public static function getSharedConnection(): Connection
    {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    /**
     * Always returns a new connection
     *
     * @return Connection
     */
    public static function getNewConnection(): Connection
    {
        return self::createConnection();
    }
}

class SomeComponent
{
    protected $connection;

    /**
     * Sets the connection externally
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * This method always needs the shared connection
     */
    public function someDbTask()
    {
        $connection = $this->connection;

        // ...
    }

    /**
     * This method always needs a new connection
     *
     * @param Connection $connection
     */
    public function someOtherDbTask(Connection $connection)
    {

    }
}

$some = new SomeComponent();

// This injects the shared connection
$some->setConnection(
    Registry::getSharedConnection()
);

$some->someDbTask();

// Here, we always pass a new connection as parameter
$some->someOtherDbTask(
    Registry::getNewConnection()
);
```

到目前为止我们看到如何依赖注入解决我们的问题。 作为参数而不是在代码中创建内部传递依赖关系使我们的应用程序，更可维护性和去除耦合性。 然而，从长远来看，这种形式的依赖注入有一些缺点。

例如，如果该组件有许多依赖关系，我们将需要创建多个二传手参数传递依赖项或创建一个构造函数，通过他们与许多参数，此外之前使用的组件，每次创建依赖关系，使得我们的代码不容易维护，我们会像：

```php
<?php

// Create the dependencies or retrieve them from the registry
$connection = new Connection();
$session    = new Session();
$fileSystem = new FileSystem();
$filter     = new Filter();
$selector   = new Selector();

// Pass them as constructor parameters
$some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

// ... Or using setters
$some->setConnection($connection);
$some->setSession($session);
$some->setFileSystem($fileSystem);
$some->setFilter($filter);
$some->setSelector($selector);
```

认为是否我们不得不在我们的应用程序的许多部分中创建此对象。 将来，如果我们不需要任何依赖项，我们需要去通过整个代码库的任何构造函数或 setter 中删除参数在那里我们注入的代码。 为了解决这个问题，我们再返回到全局注册表创建的组件。 然而，它会添加一个新创建的对象之前抽象层：

```php
<?php

class SomeComponent
{
    // ...

    /**
     * Define a factory method to create SomeComponent instances injecting its dependencies
     */
    public static function factory()
    {
        $connection = new Connection();
        $session    = new Session();
        $fileSystem = new FileSystem();
        $filter     = new Filter();
        $selector   = new Selector();

        return new self($connection, $session, $fileSystem, $filter, $selector);
    }
}
```

现在我们发现自己回到我们开始的地方，我们再建立内部组件依赖项 ！我们必须找到一种解决方案，让我们从一再陷入糟糕的实践。

以实际和优雅的方式来解决这些问题使用容器的依赖关系。 容器作为我们前面看到的全局注册表。 使用容器的依赖关系作为桥梁获得依赖关系使我们能够减少我们的组件的复杂性：

```php
<?php

use Phalcon\Di;
use Phalcon\DiInterface;

class SomeComponent
{
    protected $di;

    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    public function someDbTask()
    {
        // Get the connection service
        // Always returns a new connection
        $connection = $this->di->get('db');
    }

    public function someOtherDbTask()
    {
        // Get a shared connection service,
        // this will return the same connection every time
        $connection = $this->di->getShared('db');

        // This method also requires an input filtering service
        $filter = $this->di->get('filter');
    }
}

$di = new Di();

// Register a 'db' service in the container
$di->set(
    'db',
    function () {
        return new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
);

// Register a 'filter' service in the container
$di->set(
    'filter',
    function () {
        return new Filter();
    }
);

// Register a 'session' service in the container
$di->set(
    'session',
    function () {
        return new Session();
    }
);

// Pass the service container as unique parameter
$some = new SomeComponent($di);

$some->someDbTask();
```

组件现在可以简单地访问它需要时需要它，如果它不需要服务它不甚至初始化，节约资源的服务。 现在组件是高度解耦的。 例如，我们可以替换创建连接的方式，他们的行为或任何其他方面的他们，不会影响该组件。

[Phalcon\Di](api/Phalcon_Di) is a component implementing Dependency Injection and Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, [Phalcon\Di](api/Phalcon_Di) is essential to integrate the different components of the framework. 开发人员还可以使用此组件把依赖项注入和管理的应用程序中使用的不同类的全局实例。

Basically, this component implements the [Inversion of Control](https://en.wikipedia.org/wiki/Inversion_of_control) pattern. 应用这个，对象不会收到使用 setter 或构造函数，但请求服务依赖注入器及其依赖项。 这降低了整体的复杂性，因为只有一种方式得到的组件中所需的依赖项。

另外，这种模式会增加可测试性的代码，从而使它不容易出错。

<a name='registering-services'></a>

## 在容器中注册服务

框架本身或开发人员可以注册服务。 当 A 的组件要求组件 B （或其类的一个实例） 操作时，它可以从容器中，而不是创建新的实例组件 B. 请求组件 B

这种工作方式给了我们很多的优点：

* 我们可以轻松地用一个我们自己造的替换组件或第三方。
* 我们可以完全控制的对象初始化，允许我们设置这些对象，根据需要将他们输送到组件之前。
* 我们可以以结构的和统一的方式来管理全局组件实例。

可以使用几种类型的定义注册服务：

<a name='simple-registration'></a>

### 简单的注册

以前见过，有几种方法可以注册服务。这些我们称之为简单：

<a name='simple-registration-string'></a>

#### 字符串

这种类型预计有效类名称，返回指定的类，如果它不加载的类的对象将使用自动加载程序实例化。 这种类型的定义不允许指定的类构造函数或参数的参数：

```php
<?php

// Return new Phalcon\Http\Request();
$di->set(
    'request',
    'Phalcon\Http\Request'
);
```

<a name='class-instances'></a>

#### 类实例

这种期望的对象。 由于事实对象不需要解决的它已经是一个对象，可以说，并非真正的依赖注入，然而它是有用的如果你想强制返回的依赖关系，以永远是相同的对象值：

```php
<?php

use Phalcon\Http\Request;

// Return new Phalcon\Http\Request();
$di->set(
    'request',
    new Request()
);
```

<a name='closures-anonymous-functions'></a>

#### 闭包/匿名函数

此方法提供了更大的自由来生成所需的依赖，然而，它是难以改变的一些参数外部而不必完全更改依赖项的定义：

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$di->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'blog',
            ]
        );
    }
);
```

将额外的变量传递给封闭的环境，可以克服的一些限制：

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$config = new Config(
    [
        'host'     => '127.0.0.1',
        'username' => 'user',
        'password' => 'pass',
        'dbname'   => 'my_database',
    ]
);

// Using the $config variable in the current scope
$di->set(
    'db',
    function () use ($config) {
        return new PdoMysql(
            [
                'host'     => $config->host,
                'username' => $config->username,
                'password' => $config->password,
                'dbname'   => $config->name,
            ]
        );
    }
);
```

您还可以访问其他 DI 服务使用 `get()` 方法：

```php
<?php

use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$di->set(
    'config',
    function () {
        return new Config(
            [
                'host'     => '127.0.0.1',
                'username' => 'user',
                'password' => 'pass',
                'dbname'   => 'my_database',
            ]
        );
    }
);

// Using the 'config' service from the DI
$di->set(
    'db',
    function () {
        $config = $this->get('config');

        return new PdoMysql(
            [
                'host'     => $config->host,
                'username' => $config->username,
                'password' => $config->password,
                'dbname'   => $config->name,
            ]
        );
    }
);
```

<a name='complex-registration'></a>

### 复杂的注册

如果需要更改服务的定义，而无需实例化解析服务，然后，我们需要定义使用数组语法的服务。 定义了一个服务使用数组定义可以更详细：

```php
<?php

use Phalcon\Logger\Adapter\File as LoggerFile;

// Register a service 'logger' with a class name and its parameters
$di->set(
    'logger',
    [
        'className' => 'Phalcon\Logger\Adapter\File',
        'arguments' => [
            [
                'type'  => 'parameter',
                'value' => '../apps/logs/error.log',
            ]
        ]
    ]
);

// Using an anonymous function
$di->set(
    'logger',
    function () {
        return new LoggerFile('../apps/logs/error.log');
    }
);
```

上述两个服务注册产生相同的结果。如果需要数组定义然而，允许服务参数的修改：

```php
<?php

// Change the service class name
$di
    ->getService('logger')
    ->setClassName('MyCustomLogger');

// Change the first parameter without instantiating the logger
$di
    ->getService('logger')
    ->setParameter(
        0,
        [
            'type'  => 'parameter',
            'value' => '../apps/logs/error.log',
        ]
    );
```

另外通过使用数组语法你可以使用三种类型的依赖注入：

<a name='constructor-injection'></a>

#### 构造函数注入

这种注入类型将之前依赖项的参数传递给类的构造函数。让我们假设我们有以下组件：

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    protected $response;

    protected $someFlag;



    public function __construct(Response $response, $someFlag)
    {
        $this->response = $response;
        $this->someFlag = $someFlag;
    }
}
```

这种方式，可以注册服务：

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response'
    ]
);

$di->set(
    'someComponent',
    [
        'className' => 'SomeApp\SomeComponent',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'response',
            ],
            [
                'type'  => 'parameter',
                'value' => true,
            ],
        ]
    ]
);
```

The service 'response' ([Phalcon\Http\Response](api/Phalcon_Http_Response)) is resolved to be passed as the first argument of the constructor, while the second is a boolean value (true) that is passed as it is.

<a name='setter-injection'></a>

#### 设置注入

类可能有设置器注入可选依赖项，我们的前一个类可以改变接受依赖与设置:

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    protected $response;

    protected $someFlag;



    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function setFlag($someFlag)
    {
        $this->someFlag = $someFlag;
    }
}
```

Setter 注入可以被注册的服务，如下所示：

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response',
    ]
);

$di->set(
    'someComponent',
    [
        'className' => 'SomeApp\SomeComponent',
        'calls'     => [
            [
                'method'    => 'setResponse',
                'arguments' => [
                    [
                        'type' => 'service',
                        'name' => 'response',
                    ]
                ]
            ],
            [
                'method'    => 'setFlag',
                'arguments' => [
                    [
                        'type'  => 'parameter',
                        'value' => true,
                    ]
                ]
            ]
        ]
    ]
);
```

<a name='properties-injection'></a>

#### 采用属性的方式注入

一个不太常见的策略是依赖关系或参数直接注入的类的公共属性：

```php
<?php

namespace SomeApp;

use Phalcon\Http\Response;

class SomeComponent
{
    /**
     * @var Response
     */
    public $response;

    public $someFlag;
}
```

Setter 注入可以被注册的服务，如下所示：

```php
<?php

$di->set(
    'response',
    [
        'className' => 'Phalcon\Http\Response',
    ]
);

$di->set(
    'someComponent',
    [
        'className'  => 'SomeApp\SomeComponent',
        'properties' => [
            [
                'name'  => 'response',
                'value' => [
                    'type' => 'service',
                    'name' => 'response',
                ],
            ],
            [
                'name'  => 'someFlag',
                'value' => [
                    'type'  => 'parameter',
                    'value' => true,
                ],
            ]
        ]
    ]
);
```

支持的参数类型包括以下内容：

<table>
  <tr>
    <th>
      Type
    </th>
    
    <th>
      描述
    </th>
    
    <th>
      示例
    </th>
  </tr>
  
  <tr>
    <td>
      参数
    </td>
    
    <td>
      表示要作为参数传递的文本值
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'parameter', 'value' =&gt; 1234]</code></pre>
    </td>
  </tr>
  
  <tr>
    <td>
      service
    </td>
    
    <td>
      表示在服务容器中的另一个服务
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'service', 'name' =&gt; 'request']</code></pre>
    </td>
  </tr>
  
  <tr>
    <td>
      instance
    </td>
    
    <td>
      表示必须动态构建的对象
    </td>
    
    <td>
      <pre><code>php['type' =&gt; 'instance', 'className' =&gt; 'DateTime', 'arguments' =&gt; ['now']]</code></pre>
    </td>
  </tr>
</table>

解决其定义是复杂的服务可能会比以前见过的简单定义稍慢。然而，这些提供更可靠的方法，定义和将服务注入。

混合使用不同类型的定义，允许，每个人都可以决定什么是最适当的方法来注册服务根据应用的需要。

<a name='array-syntax'></a>

### 数组方式

数组语法也可以获取已经注册的服务：

```php
<?php

use Phalcon\Di;
use Phalcon\Http\Request;

// 创建一个依赖注入容器
$di = new Di();

// 通过类名注册
$di['request'] = 'Phalcon\Http\Request';

// 使用匿名函数，该实例将被延迟加载
$di['request'] = function () {
    return new Request();
};

// 直接注册实例
$di['request'] = new Request();

// 使用数组定义
$di['request'] = [
    'className' => 'Phalcon\Http\Request',
];
```

在上面的例子中，当框架需要访问请求数据，它会要求输入标识作为 'request' 在容器中的服务。 容器反过来将返回所需的服务的一个实例。 他/她需要的时候，开发人员可能最终替换元件。

每个方法 （如上面的例子所示） 用于set/register(设置/注册) 服务有优点和缺点。 它是由开发人员和将指定使用哪一个的特定要求。

将服务设置为一个字符串是简单，但缺乏灵活性。 设置服务使用数组提供了更多的灵活性，但使得代码更复杂。 Lambda 函数是一个好的平衡这两者之间，但可能会导致更多的维护比人们想象。

[Phalcon\Di](api/Phalcon_Di) offers lazy loading for every service it stores. 除非开发人员选择直接实例化一个对象并将其存储在容器中，任何对象 （通过数组、 字符串等） 存储在它将懒加载即实例化只在请求时。

<a name='loading-from-yaml'></a>

### 从 YAML 文件加载服务

此功能会让你在 `yaml` 文件或只是在普通的 php 设置您的服务。例如，您可以加载使用 `yaml` 文件中的像这样的服务：

```yaml
config:
  className: \Phalcon\Config
  shared: true
```

```php
<?php

use Phalcon\Di;

$di = new Di();
$di->loadFromYaml('services.yml');
$di->get('config'); // will properly return config service
```

<div class="alert alert-danger">
    <p>
        This approach requires that the module Yaml be installed. Please refer to <a href="https://php.net/manual/book.yaml.php">this</a> for more information.
    </p>
</div>

<a name='resolving-services'></a>

## 解析服务

调用 get 方法，是一种简单地方法从容器中获取服务。将返回一个新的服务的实例：

```php
$request = $di->get('request');
```

或通过魔术方法调用：

```php
$request = $di->getRequest();
```

或使用数组访问语法：

```php
$request = $di['request'];
```

通过将一个数组参数添加到 get 方法，可以给构造函数传递参数：

```php
<?php

// new MyComponent('some-parameter', 'other')
$component = $di->get(
    'MyComponent',
    [
        'some-parameter',
        'other',
    ]
);
```

<a name='envents'></a>

### 事件

[Phalcon\Di](api/Phalcon_Di) is able to send events to an [EventsManager](/4.0/en/events) if it is present. 事件被触发使用类型 'di'。 一些事件可以停止操作，当返回布尔值 false 时。 以下事件被支持︰

| 事件名称                 | 触发器                            | 可以停止操作吗？ |   触发条件    |
| -------------------- | ------------------------------ |:--------:|:---------:|
| beforeServiceResolve | 触发之前解决服务。侦听器接收服务名称和传递给它的参数。    |    否     | Listeners |
| afterServiceResolve  | 触发后决心服务。侦听器接收服务名称、 实例和传递给它的参数。 |    否     | Listeners |

<a name='shared-services'></a>

## 共享的服务

Services can be registered as 'shared' services this means that they always will act as [singletons](https://en.wikipedia.org/wiki/Singleton_pattern). Once the service is resolved for the first time the same instance of it is returned every time a consumer retrieve the service from the container:

```php
<?php

use Phalcon\Session\Adapter\Files as SessionFiles;

// Register the session service as 'always shared'
$di->setShared(
    'session',
    function () {
        $session = new SessionFiles();

        $session->start();

        return $session;
    }
);

// Locates the service for the first time
$session = $di->get('session');

// Returns the first instantiated object
$session = $di->getSession();
```

An alternative way to register shared services is to pass 'true' as third parameter of 'set':

```php
<?php

// Register the session service as 'always shared'
$di->set(
    'session',
    function () {
        // ...
    },
    true
);
```

If a service isn't registered as shared and you want to be sure that a shared instance will be accessed every time the service is obtained from the DI, you can use the 'getShared' method:

```php
$request = $di->getShared('request');
```

<a name='manipulating-services-individually'></a>

## 单独操纵服务

Once a service is registered in the service container, you can retrieve it to manipulate it individually:

```php
    <?php

    use Phalcon\Http\Request;

    // Register the 'request' service
    $di->set('request', 'Phalcon\Http\Request');

    // Get the service
    $requestService = $di->getService('request');

    // Change its definition
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

    // Change it to shared
    $requestService->setShared(true);

    // Resolve the service (return a Phalcon\Http\Request instance)
    $request = $requestService->resolve();
```

<a name='instantiating-classes-service-container'></a>

## 通过服务容器实例化类

When you request a service to the service container, if it can't find out a service with the same name it'll try to load a class with the same name. With this behavior we can replace any class by another simply by registering a service with its name:

```php
<?php

// Register a controller as a service
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    },
    true
);

// Register a controller as a service
$di->set(
    'MyOtherComponent',
    function () {
        // Actually returns another component
        $component = new AnotherComponent();

        return $component;
    }
);

// Create an instance via the service container
$myComponent = $di->get('MyOtherComponent');
```

You can take advantage of this, always instantiating your classes via the service container (even if they aren't registered as services). The DI will fallback to a valid autoloader to finally load the class. By doing this, you can easily replace any class in the future by implementing a definition for it.

<a name='automatic-injecting-di-itself'></a>

## 从DI本身自动注入

If a class or component requires the DI itself to locate services, the DI can automatically inject itself to the instances it creates, to do this, you need to implement the [Phalcon\Di\InjectionAwareInterface](api/Phalcon_Di_InjectionAwareInterface) in your classes:

```php
<?php

use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

class MyClass implements InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $di;


    public function setDi(DiInterface $di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }
}
```

Then once the service is resolved, the `$di` will be passed to `setDi()` automatically:

```php
<?php

// Register the service
$di->set('myClass', 'MyClass');

// Resolve the service (NOTE: $myClass->setDi($di) is automatically called)
$myClass = $di->get('myClass');
```

<a name='organizing-services-files'></a>

## 在文件中组织服务

You can better organize your application by moving the service registration to individual files instead of doing everything in the application's bootstrap:

```php
<?php

$di->set(
    'router',
    function () {
        return include '../app/config/routes.php';
    }
);
```

Then in the file (`'../app/config/routes.php'`) return the object resolved:

```php
<?php

$router = new MyRouter();

$router->post('/login');

return $router;
```

<a name='accessing-di-static-way'></a>

## 以静态的方式访问DI

If needed you can access the latest DI created in a static function in the following way:

```php
<?php

use Phalcon\Di;

class SomeComponent
{
    public static function someMethod()
    {
        // Get the session service
        $session = Di::getDefault()->getSession();
    }
}
```

<a name='service-providers'></a>

## 服务提供商

Using the `ServiceProviderInterface` you now register services by context. You can move all your `$di->set()` calls to classes like this:

```php
<?php

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Di;
use Phalcon\Config\Adapter\Ini;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->set(
            'config', 
            function () {
                return new Ini('config.ini');
            }
        );
    }
}

$di = new Di();
$di->register(new SomeServiceProvider());
var_dump($di->get('config')); // will return properly our config
```

<a name='factory-default-di'></a>

## 默认的Di注入器

Although the decoupled character of Phalcon offers us great freedom and flexibility, maybe we just simply want to use it as a full-stack framework. To achieve this, the framework provides a variant of [Phalcon\Di](api/Phalcon_Di) called [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault). This class automatically registers the appropriate services bundled with the framework to act as full-stack.

```php
<?php

use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();
```

<a name='service-name-conventions'></a>

## 服务名称约定

Although you can register services with the names you want, Phalcon has a several naming conventions that allow it to get the the correct (built-in) service when you need it.

| 服务名称               | 描述               | 默认                                                                                     | 是否共享 |
| ------------------ | ---------------- | -------------------------------------------------------------------------------------- |:----:|
| assets             | 资源管理器            | [Phalcon\Assets\Manager](api/Phalcon_Assets_Manager)                                 |  是的  |
| annotations        | 注释语法分析器          | [Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory)        |  是的  |
| cookies            | HTTP Cookie 管理服务 | [Phalcon\Http\Response\Cookies](api/Phalcon_Http_Response_Cookies)                  |  是的  |
| crypt              | 加密解密数据           | [Phalcon\Crypt](api/Phalcon_Crypt)                                                    |  是的  |
| db                 | 低级数据库连接服务        | [Phalcon\Db](api/Phalcon_Db)                                                          |  是的  |
| dispatcher         | 调度服务控制器          | [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher)                                 |  是的  |
| eventsManager      | 事件管理服务           | [Phalcon\Events\Manager](api/Phalcon_Events_Manager)                                 |  是的  |
| escaper            | 内容的过滤筛选          | [Phalcon\Escaper](api/Phalcon_Escaper)                                                |  是的  |
| flash              | 闪存的消息传递服务        | [Phalcon\Flash\Direct](api/Phalcon_Flash_Direct)                                     |  是的  |
| flashSession       | Flash 会话消息服务     | [Phalcon\Flash\Session](api/Phalcon_Flash_Session)                                   |  是的  |
| filter             | 输入过滤服务           | [Phalcon\Filter](api/Phalcon_Filter)                                                  |  是的  |
| modelsCache        | 模型缓存的缓存后端        | 无                                                                                      |  否   |
| modelsManager      | 模型管理服务           | [Phalcon\Mvc\Model\Manager](api/Phalcon_Mvc_Model_Manager)                          |  是的  |
| modelsMetadata     | 模型元数据服务          | [Phalcon\Mvc\Model\MetaData\Memory](api/Phalcon_Mvc_Model_MetaData_Memory)         |  是的  |
| request            | HTTP 请求环境服务      | [Phalcon\Http\Request](api/Phalcon_Http_Request)                                     |  是的  |
| response           | HTTP 响应环境服务      | [Phalcon\Http\Response](api/Phalcon_Http_Response)                                   |  是的  |
| router             | 路由服务             | [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router)                                         |  是的  |
| security           | 安全助手             | [Phalcon\Security](api/Phalcon_Security)                                              |  是的  |
| session            | 会话服务             | [Phalcon\Session\Adapter\Files](api/Phalcon_Session_Adapter_Files)                  |  是的  |
| sessionBag         | 会话包服务            | [Phalcon\Session\Bag](api/Phalcon_Session_Bag)                                       |  是的  |
| tag                | 生成的 HTML 助手      | [Phalcon\Tag](api/Phalcon_Tag)                                                        |  是的  |
| transactionManager | 模型事务管理器服务        | [Phalcon\Mvc\Model\Transaction\Manager](api/Phalcon_Mvc_Model_Transaction_Manager) |  是的  |
| url                | URL 生成器服务        | [Phalcon\Mvc\Url](api/Phalcon_Mvc_Url)                                               |  是的  |
| viewsCache         | 视图片段缓存后端         | 无                                                                                      |  否   |

<a name='implementing-your-own-di'></a>

## 实现你自己的DI

The [Phalcon\DiInterface](api/Phalcon_DiInterface) interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one.