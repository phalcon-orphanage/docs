---
layout: default
title: '자습서 - INVO'
keywords: 'tutorial, invo tutorial, step by step, mvc, 자습서'
---

# 자습서 - INVO
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## 개요
[INVO][github_invo] is a small application that allows users to generate invoices, manage customers and products as well as sign up and log in. 이것은 Phalcon이 특정 작업을 어떻게 처리하는지 잘 보여줍니다. On the client side, [Bootstrap][bootstrap] is used for the UI. 이 어플리케이션은 실제 송장을 생성하지는 않지만, 이런 작업들을 Phalcon을 사용해서 어떻게 구현할 수 있는지 잘 보여주는 예제로 생각해 주세요.

> **NOTE**: It is recommended that you open the application in your favorite editor so that you can follow this tutorial easier. 
> 
> {: .alert .alert-info }

> **NOTE**: Note the code below has been formatted to increase readability 
> 
> {: .alert .alert-warning }

## Structure
You can clone the repository to your machine (or download it) from [GitHub][github_invo]. 복제(혹은 다운로드 및 zip파일 압축해제) 한 후 보시면 다음과 같은 디렉토리 구조를 확인하실 수 있습니다.

```bash
└── invo
    ├── config
    ├── db
    │   └── migrations
    │       └── 1.0.0
    ├── docker
    │   └── 8.0
    │   └── 8.1
    │── public
    │   ├── index.php
    │   └── js
    ├── src
    │   ├── Controllers
    │   ├── Forms
    │   ├── Models
    │   ├── Plugins
    │   ├── Providers
    ├── themes
    │   ├── about
    │   ├── companies
    │   ├── contact
    │   ├── errors
    │   ├── index
    │   ├── invoices
    │   ├── layouts
    │   ├── products
    │   ├── producttypes
    │   ├── register
    │   └── session
    └── var
        ├── cache
        └── logs
```
Phalcon은 특정한 디렉토리 구조를 강제하지 않으며, 여기서 보시는 특정 디렉토리 구조는 우리가 그렇게 구현한 것일 뿐입니다. [웹서버 설정](webserver-setup) 페이지의 설명에 따라 웹서버를 준비해 주세요.

어플리케이션이 준비되면, 브라우저에서 다음의 URL `https://localhost/invo` 을 입력해서 실행시킬 수 있습니다. 아래와 비슷한 화면을 보실 수 있습니다:

![](/assets/images/content/tutorial-invo-1.png)

이 어플리케이션은 프론트엔드와 백엔드, 두 부분으로 나뉘어져 있습니다. 프론트엔드는 방문자가 INVO에 대한 정보를 얻고 연락정보를 요청할 수 있는 공개된 영역입니다. 백엔드는 등록된 사용자가 제품과 고객을 관리할 수 있는 관리자 영역입니다.

## 라우팅
INVO는 [Router](routing) 컴포넌트에 내장된 표준 라우트를 사용합니다. 이 라우트는 다음의 패턴을 따릅니다:

```
/:controller/:action/:params
```

커스텀 라우트인 `/session/register` 는 `SessionController` 컨트롤러와 그에 속한 `registerAction` 액션을 실행시킵니다.

## 구성
## Autoloader
For this application, we utilize the autoloader that comes with composer. You can easily adjust the code to use the autoloader provided by Phalcon if you wish:

```php
<?php

$rootPath = realpath('..');
require_once $rootPath . '/vendor/autoload.php';
```

### `DotEnv`
INVO uses the `Dotenv\Dotenv` library to retrieve some configuration variables that are unique to each installation.

```php
<?php

/**
 * Load ENV variables
 */
Dotenv::createImmutable($rootPath)
      ->load()
;
```
The above assumes that a `.env` file is present in your root directory. There is a `.env.example` file that you can use as a reference and copy/rename it.

### Providers
We will need to register all the services we need for the application in a DI container. The framework provides a variant of [Phalcon\Di\Di](di) called [Phalcon\Di\FactoryDefault](di#factory-default). 이 클래스는 풀스택 MVC 어플리케이션에 맞춰 필요한 서비스가 사전에 등록되어 있습니다. We therefore create a new `Phalcon\Di\FactoryDefault` object and then call the provider classes  to load the necessary services including the configuration of the application. They are all under the `Providers` folder.

As an example, the `Providers\ConfigProvider.php` class loads the `config/config.php` file, which contains the configuration of the application:

```php
<?php

namespace Invo\Providers;

use Exception;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

/**
 * Read the configuration
 */
class ConfigProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $configPath = $di->offsetGet('rootPath') . '/config/config.php';
        if (!file_exists($configPath) || !is_readable($configPath)) {
            throw new Exception('Config file does not exist: ' . $configPath);
        }

        $di->setShared('config', function () use ($configPath) {
            return require_once $configPath;
        });
    }
}
```

[Phalcon\Config\Config](config) allows us to manipulate the file in an object-oriented way. 구성파일은 다음의 설정을 가지고 있습니다:

```php
<?php

declare(strict_types=1);

use Phalcon\Config\Config;

return new Config([
    'database' => [
        'adapter'  => $_ENV['DB_ADAPTER'] ?? 'Mysql',
        'host'     => $_ENV['DB_HOST'] ?? 'locahost',
        'username' => $_ENV['DB_USERNAME'] ?? 'phalcon',
        'password' => $_ENV['DB_PASSWORD'] ?? 'secret',
        'dbname'   => $_ENV['DB_DBNAME'] ?? 'phalcon_invo',
        'charset'  => $_ENV['DB_CHARSET'] ?? 'utf8',
    ],
    'application' => [
        'viewsDir' => $_ENV['VIEWS_DIR'] ?? 'themes/invo',
        'baseUri'  => $_ENV['BASE_URI'] ?? '/',
    ],
]);
```

Phalcon에서는 설정값들을 정의하는데 있어서 특별한 규칙이 없습니다. 섹션은 어플리케이션에서 의미있는 그룹들을 기반으로 옵션을 정리하는데 도움이 됩니다. In our file there are two sections that will be used later on: `application` and `database`.


## 요청 처리
At the end of the file (`public/index.php`), the request is finally handled by [Phalcon\Mvc\Application](application), which initializes all the services necessary for the application to run.

```php
<?php

use Phalcon\Mvc\Application;

// ...

/**
 * Init MVC Application and send output to client
 */
(new Application($di))
    ->handle($_SERVER['REQUEST_URI'])
    ->send()
;
```

## 의존성 주입(Dependency Injection)
위 코드 블록의 첫줄에서, [Application](application) 클래스 생성자는 `$container` 변수를 인자값으로 받습니다.

Phalcon은 매우 느슨하게 연결(highly decoupled) 되어 있기 때문에, 어플리케이션의 다른 부분에서 컨테이너가 등록된 서비스에 접근할 수 있도록 해줄 필요가 있습니다. The component in question is [Phalcon\Di\Di](di). 이 컴포넌트는 서비스 컨테이너이며 동시에 의존성 주입, 서비스 위치확인, 어플리케이션에서 필요한 모든 컴포넌트 의 인스턴스화 등을 담당하고 있습니다.

컨테이너에 서비스를 등록하는 방법은 다양합니다. INVO에서는, 대부분의 서비스는 익명함수/클로저를 이용해서 등록합니다. 덕분에, 객체는 지연 로딩(lazy loaded) 되어 어플리케이션에서 필요한 리소스를 최소화 시켜줍니다.

For instance, in the following excerpt the `Providers\SessionProvider` service is registered. 이 익명함수는 어플리케이션에서 세션데이터를 필요로 할때만 호출됩니다:

```php
<?php

use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;

$di->setShared(
    'session', 
    function () {
        $session = new SessionManager();
        $files   = new SessionAdapter(
            [
                'savePath' => sys_get_temp_dir(),
            ]
        );
        $session->setAdapter($files);
        $session->start();

        return $session;
    }
);
```

여기서, 우리는 어댑터를 자유로이 변경할 수 있으며, 추가적인 초기화 등 다양한 작업을 할 수 있습니다. 이 서비스는 `session` 라는 이름으로 등록되었음을 주의해주세요. This is a convention that will allow the framework to identify the active service in the DI container.

## 로그인
`로그인` 페이지는 백엔드 컨트롤러와 작업할 수 있도록 해 줍니다. 백엔드 컨트롤러와 프론트엔드 컨트롤러 간의 구분은 사실 좀 임의적입니다. All controllers are located in the same directory (`src/Controllers/`).

![](/assets/images/content/tutorial-invo-2.png)

시스템에 진입하기 위해서, 사용자는 유효한 사용자명과 암호를 가지고 있어야 합니다. 사용자 데이터는 `invo` 데이터베이스의 `users`테이블에 저장되어 있습니다.

이제 데이터베이스 연결을 설정해 봅시다. `db` 서비스는 서비스 컨테이너 내에 연결정보와 함께 설정되어 있습니다. 오토로더와 마찬가지로, 서비스를 구성하기 위해 설정파일에서 다시한번 파라미터 값을 가져 옵니다.

```php
<?php

// ...

$dbConfig = $di->getShared('config')
               ->get('database')
               ->toArray()
;
$di->setShared('db', function () use ($dbConfig) {
    $dbClass = 'Phalcon\Db\Adapter\Pdo\\' . $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    return new $dbClass($dbConfig);
});
```

Here, we return an instance of the MySQL connection adapter, because the `$dbConfig['adapter']` setting is `Mysql`. [Logger](logger) 를 추가하거나, 쿼리 실행시간 측정을 위한 [profiler](db-models-events#profiling-sql-statements)를 추가 하는 등의 별도 기능을 추가할 수 있으며, 심지어 다른 RDBMS로 어댑터 변경도 가능합니다.

The following simple form (`themes/invo/session/index.volt`) produces the necessary HTML so that users can submit login information. Some HTML code has been removed to improve readability:

```twig
{% raw %}
        <form action="/session/start" role="form" method="post">
            <fieldset>
                <div class="form-group">
                    <label for="email">Username/Email</label>
                    <div class="controls">
                        {{ text_field('email', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="controls">
                        {{ password_field('password', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    {{ submit_button('Login', 'class': 'btn btn-primary btn-large') }}
                </div>
            </fieldset>
        </form>
    </div>

    <div class="col-md-6">
        <div class="clearfix center">
            {{ link_to('register', 'Sign Up', 'class': 'btn btn-primary btn-large btn-success') }}
        </div>
    </div>
</div>
{% endraw %}
```

템플릿 엔진으로 PHP 대신에 [Volt](volt)를 사용하고 있습니다. This is a built-in template engine inspired by [Jinja][jinja] providing a simple and user-friendly syntax to create templates. If you have worked with [Jinja][jinja] or [Twig][twig] in the past, you will see many similarities.

The `SessionController::startAction` function (`src/Controllers/SessionController.php`) validates the data submitted from the form, and also checks for a valid user in the database:

```php
<?php

use Invo\Models\Users;

class SessionController extends ControllerBase
{
    // ...

    /**
     * This action authenticate and logs a user into the application
     */
    public function startAction(): void
    {
        if ($this->request->isPost()) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            /** @var Users|null $user */
            $user = Users::findFirst([
                "(email = :email: OR username = :email:) AND "
                . "password = :password: AND active = 'Y'",
                'bind' => [
                    'email'    => $email,
                    'password' => sha1($password),
                ],
            ]);

            if ($user) {
                $this->registerSession($user);
                $this->flash->success('Welcome ' . $user->name);

                $this->dispatcher->forward(
                    [
                        'controller' => 'invoices',
                        'action'     => 'index',
                    ]
                );

                return;
            }

            $this->flash->error('Wrong email/password');
        }

        $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }

    /**
     * Register an authenticated user into session data
     *
     * @param Users $user
     */
    private function registerSession(Users $user): void
    {
        $this->session->set(
            'auth', 
            [
                'id'   => $user->id,
                'name' => $user->name,
            ]
        );
    }
}
```

코드를 보는 순간, 컨트롤러 내에서 `$this->flash`, `$this->request` 혹은 `$this->session` 등 몇 개의 퍼블릭 속성 값들을 사용하고 있다는 것을 알아차리실 것입니다. [Controllers](controllers) in Phalcon are automatically tied to the [Phalcon\Di\Di](di) container and as a result, all the services registered in the container are present in each controller as properties with the same name as the name of each service. 서비스에 처음 접근하는 시점에서 해당서비스는 자동으로 인스턴스화 되어 호출자에게 반환됩니다. Additionally, these services are set as _shared_ so the same instance will be returned, no matter how many times we access the property/service in the same request. These are services defined in the services container from earlier (`Providers` folder) and you can of course change this behavior when setting up these services.

For instance, here we invoke the `session` service, and then we store the user identity in the variable `auth`:

```php
<?php

$this->session->set(
    'auth',
    [
        'id'   => $user->id,
        'name' => $user->name,
    ]
);
```

> **NOTE**: For more information about Di services, please check the [Dependency Injection](di) document. 
> 
> {: .alert .alert-info }

`startAction` 함수는 처음에 데이터가 `POST` 를 통해 제출되었는지 확인합니다. 아니라면, 사용자는 동일한 form으로 다시 리다이렉트 됩니다. 요청 객체의 `isPost()` 메서드를 사용해서 폼이 `POST` 를 통해 제출되었는지 확인합니다.

```php
<?php

if ($this->request->isPost()) {
    // ...
}
```

그다음에는 요청으로 부터 post된 데이터를 찾습니다. 이들은 사용자가 `Log In`을 클릭해서 폼을 제출 할 때 사용하는 텍스트 박스들입니다. 우리는 `request` 객체와 `getPost()` 메서드를 사용합니다.

```php
<?php

$email    = $this->request->getPost('email');
$password = $this->request->getPost('password');
```

이제, 제출된 이메일과 암호를 가진 활성화된 사용자가 있는지 확인해야겠죠:

```php
<?php

$user = Users::findFirst(
    [
        "(email = :email: OR username = :email:) " .
        "AND password = :password: " .
        "AND active = 'Y'",
        'bind' => [
            'email'    => $email,
            'password' => sha1($password),
        ]
    ]
);
```
> **NOTE**: Note, the use of 'bound parameters', placeholders `:email:` and `:password:` are placed where values should be, then the values are _bound_ using the parameter `bind`. 이렇게 함으로써 SQL injection의 위험 없이 이들 컬럼을 값으로 대체 할 수 있습니다.

데이터베이스 내의 사용자를 검색할 때, 우리는 바로 평문 텍스트를 사용해서 암호를 찾지 않습니다. The application stores passwords as hashes, using the [sha1][sha1] method. 이 방법론은 튜토리얼 목적으론 적절하지만, 운영환경의 어플리케이션을 위해서는 다른 알고리즘을 고려하는 것이 더 적절할 수 있습니다. The [Phalcon\Encryption\Security](encryption-security) component offers convenience methods to strengthen the algorithm used for your hashes.

사용자를 찾으면, 해당 사용자를 세션에 등록(사용자를 로그 인) 하고 환영 메시지를 표시하면서 대시보드(`Invoices` 컨트롤러, `index` 액션) 로 이동시킵니다.

```php
<?php

if ($user) {
    $this->registerSession($user);
    $this->flash->success('Welcome ' . $user->name);

    $this->dispatcher->forward([
        'controller' => 'invoices',
        'action'     => 'index',
    ]);

    return;
}
```

사용자를 찾을 수 없다면, 화면에 `잘못된 이메일/암호` 메시지를 띄우면서 로그인 페이지로 이동시킵니다.

```php
<?php

return $this->dispatcher->forward(
    [
        'controller' => 'session',
        'action'     => 'index',
    ]
);
```

## 백엔드 보안
백엔드는 등록된 사용자만 접근할 수 있는 비공개 영역입니다. 그러므로, 등록된 사용자만 이들 컨트롤러에 접근가능한지 여부를 확인할 필요가 있습니다. If you are not logged in and try to access a _private_ area you will see a message like the one below:

사용자가 컨트롤러/액션에 접근하려 할 때 마다, 어플리케이션은 현재의 역할(세션에 저장되어 있음) 로 해당 컨트롤러/액션에 접근할 수 있는지 확인하게 되며, 권한이 없다면 위와 같은 메시지를 뿌리고는 홈페이지로 이동시킵니다.

이렇게 하기 위해서 우리는 [Dispatcher](dispatcher) 컴포넌트를 사용해야 합니다. 사용자가 페이지나 URL을 요청하면, 어플리케이션은 먼저 [Route](routing) 컴포넌트를 이용해서 요청받은 페이지를 확인합니다. 경로(route) 가 확인되고 매치되는 유효한 컨트롤러/액션이 있다면, 이 정보는 [Dispatcher](dispatcher) 로 위임(delegate) 되어 해당 컨트롤러를 로드하고 액션을 실행시킵니다.

보통은 프레임워크가 자동으로 Dispatcher를 생성합니다. 우리의 경우, 해당 경로(route) 로 보내기 전에 먼저 사용자가 로그인 되어있는지 확인할 필요가 있습니다. As such we need to replace the default component in the DI container and set a new one in (`Providers\DispatchProvider.php`). 어플리케이션을 부트스트래핑(초기화) 할 때 이 작업을 수행합니다:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// ...
$di->setShared(
    'dispatcher', 
    function () {
        // ...
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Invo\Controllers');
        // ...

        return $dispatcher;
    }
);
```
Now that the dispatcher is registered, we need to take advantage of a _hook_ available to intercept the flow of execution and perform our verification checks. Hooks are called Events in Phalcon and in order to access or enable them, we need to register an [Events Manager](events) component in our application so that it can _fire_ those events in our application.

[이벤트 관리자](events) 를 만들고 `dispatcher` 이벤트에 특정 코드를 붙임으로써, 이제 우리는 다양한 상황에 쉽게 대처할 수 있고 dispatch loop 나 동작 과정 중에 필요한 코드를 추가할 수 있습니다.

### 이벤트
[이벤트 관리자](events) 를 사용해서 특정한 형태의 이벤트에 리스너를 붙일 수 있습니다. 현재 우리는 `dispatch` 이벤트 타입에 리스너를 붙이고 있습니다. 아래 코드는 `beforeExecuteRoute` 와 `beforeException` 이벤트에 리스너를 붙입니다. 이 이벤트를 이용해서 404페이지를 체크하고 어플리케이션의 접근허가 여부 확인을 수행합니다.

```php
<?php

use Invo\Plugins\NotFoundPlugin;
use Invo\Plugins\SecurityPlugin;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher;

$di->setShared(
    'dispatcher', 
    function () {
        $eventsManager = new EventsManager();

        /**
         * Check if the user is allowed to access certain action using 
         * the SecurityPlugin
         */
        $eventsManager->attach(
            'dispatch:beforeExecuteRoute', 
            new SecurityPlugin()
        );

        /**
         * Handle exceptions and not-found exceptions using NotFoundPlugin
         */
        $eventsManager->attach(
            'dispatch:beforeException', 
            new NotFoundPlugin()
        );

        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Invo\Controllers');
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

`beforeExecuteRoute` 이벤트가 발생하면`SecurityPlugin` 플러그인이 알림을 받습니다:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeExecuteRoute',
    new SecurityPlugin()
);
```

`beforeException` 이벤트가 발생하면`NotFoundPlugin`  가 알림을 받습니다:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundPlugin()
);
```

`SecurityPlugin` is a class located in the `Plugins` directory (`src/Plugins/SecurityPlugin.php`). 이 클래스는 `beforeExecuteRoute` 메서드를 구현합니다. Dispatcher에서 발생시킨 이벤트 이름과 동일합니다.

```php
<?php

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Injectable
{
    // ...

    public function beforeExecuteRoute(
        Event $event, 
        Dispatcher $containerspatcher
    ) {
        // ...
    }
}
```
이벤트 메서드는 첫번째 파라미터로 항상 실제 이벤트를 받습니다. This is a [Phalcon\Events\Event][events-event] object which will contain information regarding the event such as its type and other related information. 이 특정 이벤트에서, 두번째 파라미터는 이벤트 자체가 생성한 객체(`$containerspatcher`) 가 될 것입니다. It is not mandatory that plugins classes extend the class [Phalcon\Di\Injectable][di-injectable], but by doing this they gain easier access to the services available in the application.

이제 우리는 현재 세션에서 역할(role) 을 검증할 수 있는 구조를 갖추었습니다. 사용자가 [ACL](acl) 사용권한이 있는지 확인할 수 있습니다. 사용자에게 권한이 없으면, 홈 화면으로 리다이렉트 시킵니다.

```php
<?php

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    // ...

    public function beforeExecuteRoute(
        Event $event, 
        Dispatcher $containerspatcher
    ) {
        $auth = $this->session->get('auth');
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        $acl = $this->getAcl();

        if (!$acl->isComponent($controller)) {
            $dispatcher->forward(
                [
                    'controller' => 'errors',
                    'action'     => 'show404',
                ]
            );

            return false;
        }

        $allowed = $acl->isAllowed($role, $controller, $action);
        if (!$allowed) {
            $dispatcher->forward(
                [
                    'controller' => 'errors',
                    'action'     => 'show401',
                ]
            );

            $this->session->destroy();

            return false;
        }

        return true;
    }
}
```
먼저 `session` 서비스로부터 `auth` 값을 얻습니다. 로그인 되어있다면, 로그인 과정 중에 이 값이 이미 설정되어 있을것입니다. 로그인 하지 않은 상태라면, 그냥 손님(guest) 입니다.

그다음은 컨트롤러와 액션의 이름을 가져오고, 접근제어목록(ACL - Access Control List) 또한 조회합니다. `role(역할)` - `controller(컨트롤러)` - `action(액션)` 값을 인수로 사용자의 `isAllowed(접근허용)` 여부를 확인합니다. 값이 참이면, 메서드는 프로세스를 종료하게 됩니다.

권한이 없는 경우, 메서드는 사용자를 홈 페이지로 이동사킨 후 `false` 값을 반환하면서 실행을 멈춥니다.

### ACL
위의 예제에서 우리는 `$this->getAcl()` 메서드를 이용해 ACL 값을 얻었습니다. ACL(접근제어목록) 을 만들려면 다음과 같이 해야 합니다:

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

$acl->setDefaultAction(Enum::DENY);

$roles = [
    'users'  => new Role(
        'Users',
        'Member privileges, granted after sign in.'
    ),
    'guests' => new Role(
        'Guests',
        'Anyone browsing the site who is not signed in is considered to be a "Guest".'
    )
];

foreach ($roles as $role) {
    $acl->addRole($role);
}
```
먼저 새 `Phalcon\Acl\Adapter\Memory` 객체를 생성합니다. 권한의 기본값이 `DENY(거부)` 이기는 하지만 그래도 우리는 `setDefaultAction()` 메서드를 이용해서 기본값을 설정하겠습니다. 그 다음에는 역할을 설정해야 합니다. INVO 자습서에서 역할은 `guests(손님)` (로그인 하지 않은 사용자) 와 `users(사용자)` 로 정의합니다. 목록에 대해 `addRole` 메서드를 사용해서 역할을 등록합니다.

이제 역할이 설정되었으니, 목록을 위한 컴포넌트를 설정할 차례입니다. ACL 컴포넌트를 어플리케이션 영역(컨트롤러/액션) 과 매핑시킵니다. 이렇게 함으로써 어떤 역할이 어느 컴포넌트에 접근가능한지를 제어할 수 있습니다.

```php
<?php

use Phalcon\Acl\Component;

// ...

$privateComponents = [
    'companies'    => [
        'index', 
        'search', 
        'new', 
        'edit', 
        'save', 
        'create', 
        'delete',
    ],
    'products'     => [
        'index', 
        'search', 
        'new', 
        'edit', 
        'save', 
        'create', 
        'delete',
    ],
    'producttypes' => [
        'index', 
        'search', 
        'new', 
        'edit', 
        'save', 
        'create', 
        'delete',
    ],
    'invoices'     => [
        'index', 
        'profile',
    ],
];

foreach ($privateComponents as $componentName => $actions) {
    $acl->addComponent(
        new Component($componentName),
        $actions
    );
}

$publicComponents = [
    'index'    => [
        'index',
        ],
    'about'    => [
        'index',
        ],
    'register' => [
        'index',
        ],
    'errors'   => [
        'show404', 
        'show500',
    ],
    'session'  => [
        'index', 
        'register', 
        'start', 
        'end',
    ],
    'contact'  => [
        'index', 
        'send',
    ],
];

foreach ($publicComponents as $componentName => $actions) {
    $acl->addComponent(
        new Component($componentName),
        $actions
    );
}
```
위에서 보는 바와 같이, 어플리케이션의 비공개영역(백엔드) 을 먼저 등록하고 그 다음에 공개영역(프론트엔드) 을 등록합니다. 생성된 배열은 컨트롤러 명을 key 값으로 가지고 있으며 해당하는 액션 명들을 value로 가지고 있습니다. 공개 컴포넌트도 마찬가지입니다.

역할과 컴포넌트를 등록했으니, 이 둘을 연결시켜 ACL을 완성시켜야겠지요. `Users(사용자)` 역할은 공개(프론트엔드)/비공개(백엔드) 컴포넌트에 접근 가능한 반면, `Guests(손님)` 은 공개(프론트엔드) 컴포넌트에만 접근할 수 있습니다.

```php
<?php

// Grant access to public areas to both users and guests
foreach ($roles as $role) {
    foreach ($publicResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow($role->getName(), $resource, $action);
        }
    }
}

// Grant access to private area to role Users
foreach ($privateResources as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow('Users', $resource, $action);
    }
}
```

## CRUD
어플리케이션의 백엔드 부분은 사용자가 데이터를 다룰 수 있도록 form과 로직을 제공하는, 즉 CRUD 작업을 수행하는 코드입니다. INVO 가 이 작업을 어떻게 다루는지, 그리고 form, validater, paginator 등을 사용하는 방법들에 대해 알아보도록 하겠습니다.

We have a simple [CRUD][crud] (Create, Read, Update and Delete) implementation in INVO, to manipulate data (companies, products, types of products). 상품(products) 데이터를 관리하기 위해 아래와 같은 파일들을 사용합니다:


```bash
└── invo
    └── src
        ├── Controllers
        │   └── ProductsController.php
        ├── Forms
        │   └── ProductsForm.php
        ├── Models
        │   └── Products.php
        └── themes
            └── invo
                └── products
                    ├── edit.volt
                    ├── index.volt
                    ├── new.volt
                    └── search.volt
```
회사(companies) 등의 다른 데이터들의 경우, 관련파일들(접두어로 `Company`를 붙임) 이 위에서와 동일한 디렉토리에 위치합니다.

각 컨트롤러는 모두 다음의 액션을 가지고 있습니다:

```php
<?php

class ProductsController extends ControllerBase
{
    public function createAction();

    public function editAction($id);

    public function deleteAction($id);

    public function indexAction();

    public function newAction();

    public function saveAction();

    public function searchAction();
}
```

| Action         | Description                                                      |
| -------------- | ---------------------------------------------------------------- |
| `createAction` | `new` 액션에서 입력된 데이터에 기초하여 상품을 생성                                  |
| `deleteAction` | 상품 삭제                                                            |
| `editAction`   | 기존의 상품을 편집(`edit`) 할 수 있는 뷰를 표시                                  |
| `indexAction`  | `search` 뷰를 표시하는, 시작 액션                                          |
| `newAction`    | 신규(`new`) 상품을 생성하는 뷰를 표시                                         |
| `saveAction`   | 편집(`edit`) 액션에서 입력된 데이터에 기초하여 상품을 업데이트                           |
| `searchAction` | `index` 에서 보내진 기준조건에 기초하여 검색(`search`) 실행. 결과값에 대한 paginator를 반환 |

## 검색 Form
INVO에서 CRUD 작업은 검색 form에서 시작합니다. 이 form은 상품 테이블(`products`) 에 있는 필드들을 표시해서 사용자가 각각의 항목에 대해 검색어를 입력할 수 있도록 합니다. `products` 테이블은 `products_types` 테이블과 종속관계가 있습니다. 여기서는, 이 필드에 대해 검색어를 제공하기 위해 `product_types` 테이블의 레코드값을 사전에 쿼리 했습니다:

```php
<?php

public function indexAction()
{
    $this->persistent->searchParams = null;

    $this->view->form = new ProductsForm();
}
```
An instance of the `ProductsForm` form (`src/Forms/ProductsForm.php`) is passed to the view. 이 form은 사용자에게 보여지는 필드값들을 정의합니다.

```php
<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;

class ProductsForm extends Form
{
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $this->add((new Text('id'))->setLabel('Id'));
        } else {
            $this->add(new Hidden('id'));
        }

        /**
         * Name text field
         */
        $name = new Text('name');
        $name->setLabel('Name');
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf(
                [
                    'message' => 'Name is required'
                ]
            ),
        ]);

        $this->add($name);

        /**
         * Product Type Id Select
         */
        $type = new Select(
            'product_types_id',
            ProductTypes::find(),
            [
                'using'      => ['id', 'name'],
                'useEmpty'   => true,
                'emptyText'  => '...',
                'emptyValue' => '',
            ]
        );
        $type->setLabel('Type');

        $this->add($type);

        /**
         * Price text field
         */
        $price = new Text('price');
        $price->setLabel('Price');
        $price->setFilters(['float']);
        $price->addValidators([
            new PresenceOf(
                [
                    'message' => 'Price is required'
                ]
            ),
            new Numericality(
                [
                    'message' => 'Price is required'
                ]
            ),
        ]);

        $this->add($price);
     }
}
```

이 form은 [Phalcon\Forms\Form](forms) 컴포넌트에서 제공하는 요소(elements) 에 기반한 객체지향적 체계를 사용하여 선언됩니다. 정의된 각 요소는 거의 동일한 설정을 따릅니다:

```php
<?php

$name = new Text('name');
$name->setLabel('Name');
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

$name->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'Name is required',
            ]
        )
    ]
);

$this->add($name);
```
우선 요소를 생성합니다. 그리고 데이터 보안처리(sanitization) 를 할 수 있도록 요소에 라벨과 필터를 붙입니다. Following that we apply a validators on the element and finally add the element to the form.

다른 요소들도 이 form에서 사용됩니다:

```php
<?php

$this->add(
    new Hidden('id')
);

// ...

$productTypes = ProductTypes::find();

$type = new Select(
    'profilesId',
    $productTypes,
    [
        'using'      => [
            'id',
            'name',
        ],
        'useEmpty'   => true,
        'emptyText'  => '...',
        'emptyValue' => '',
    ]
);
```
위의 코드에서, 해당하는 경우 상품의 `id` 값을 숨김속성(hidden) HTML 필드로 추가합니다. 또한 `ProductTypes::find()` 를 이용해 모든 상품타입값을 가져온 후 [Phalcon\Tag](tag) 컴포넌트의 `select()` 메서드를 이용해서 결과값(resultset)들을 HTML `select` 에 채워넣습니다. Form이 뷰로 전달되면, 렌더링되어 사용자의 화면에 표시됩니다:

```twig
{% raw %}
<div class="row mb-3">
    <div class="col-xs-12 col-md-6">
        <h2>Search products</h2>
    </div>
    <div class="col-xs-12 col-md-6 text-right">
        {{ link_to("products/new", "Create Product", "class": "btn btn-primary") }}
    </div>
</div>

<form action="/products/search" role="form" method="get">
    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group">
                {{ element.label() }}
                <div class="controls">
                    {{ element.setAttribute("class", "form-control") }}
                </div>
            </div>
        {% endif %}
    {% endfor %}

    {{ submit_button("Search", "class": "btn btn-primary") }}
</form>
{% endraw %}
```

위의 코드는 아래와 같은 HTML을 생성합니다:

```html
<form action='/invo/products/search' method='post'>

    <h2>
        Search products
        <div class="col-xs-12 col-md-6 text-right">
            <a href="products/new" "class=btn btn-primary">Create Product</a>
        </div>
    </h2>

    <fieldset>

        <div class='control-group'>
            <label for='id' class='control-label'>Id</label>

            <div class='controls'>
                <input type='text' id='id' name='id' />
            </div>
        </div>

        <div class='control-group'>
            <label for='name' class='control-label'>Name</label>

            <div class='controls'>
                <input type='text' id='name' name='name' />
            </div>
        </div>

        <div class='control-group'>
            <label for='profilesId' class='control-label'>
                profilesId
            </label>

            <div class='controls'>
                <select id='profilesId' name='profilesId'>
                    <option value=''>...</option>
                    <option value='1'>Vegetables</option>
                    <option value='2'>Fruits</option>
                </select>
            </div>
        </div>

        <div class='control-group'>
            <label for='price' class='control-label'>Price</label>

            <div class='controls'>
                <input type='text' id='price' name='price' />
            </div>
        </div>

        <div class='control-group'>
            <input type='submit' 
                   value='Search' 
                   class='btn btn-primary' />
        </div>

    </fieldset>

</form>
```

Form이 제출(submit) 되면, 컨트롤러의 `search` 액션이 실행되어 사용자가 입력한 데이터에 기반하여 검색기능이 수행됩니다.

## 검색(Search)
`search`액션은 두 가지의 작업을 수행합니다. `POST` HTTP 메서드를 사용해서 접근하면, form에서 제출한 데이터에 근거하여 검색을 수행합니다. `GET` HTTP메서드를 사용해서 접근하는 경우, 페이지네이터(paginator) 내의 현재 페이지 값을 이동시킵니다. 어떤 HTTP 메서드를 사용했는지 확인하기 위해, [Request](request) 컴포넌트를 사용합니다:

```php
<?php

public function searchAction()
{
    if ($this->request->isPost()) {
        // POST
    } else {
        // GET
    }

    // ...
}
```

With the help of [Phalcon\Mvc\Model\Criteria][mvc-model-criteria], we can create the search conditions based on the data types and values sent from the form:

```php
<?php

$query = Criteria::fromInput(
    $this->di,
    'Products',
    $this->request->getPost()
);
```

이 메서드는 값의 '' (빈 문자열), `null` 여부를 검증하여, 검색조건을 생성할때 고려합니다:

* If the field data type is `text` or similar (`char`, `varchar`, `text`, etc.) It uses an SQL `like` operator to filter the results.
* 데이터타입이 `text` 혹은 그 유사형태가 아닌 경우, `=` 연산자를 사용합니다.

추가적으로, `Criteria`는 테이블에 있는 필드와 매치되지 않는 모든 `$_POST` 변수값들은 무시합니다. 값들은 `bound parameters` 를 사용해서 자동으로 이스케이프됩니다.

이제, 생성된 파라미터들을 컨트롤러의 세션배에 저장합니다:

```php
<?php

$this->persistent->searchParams = $query->getParams();
```

세션백 (`persistent` 속성) 은 요청 간의 데이터를 세션 서비스를 이용해서 유지시켜주는 컨트롤러 내의 특수 속성입니다. 액세스 하면, 이 속성은 각각의 컨트롤러에 대해 독립적인 [Phalcon\Session\Bag](session#persistent-data) 인스턴스를 주입(inject) 합니다.

그 다음에, 빌드된 파라미터에 기반해서 쿼리를 수행합니다:

```php
<?php

$products = Products::find($parameters);

if (count($products) === 0) {
    $this->flash->notice(
        '검색하신 조건에 해당하는 제품을 찾을 수 없습니다'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

검색조건에 해당하는 제품이 없는 경우, 사용자를 다시한번 `index` 액션으로 포워드시킵니다. 검색 결과가 존재한다면, 전체 결과목록의 부분들을 페이지를 통해 탐색할 수 있도록 paginator 객체에 검색결과를 넘겨줍니다.

```php
<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

// ...

$paginator = new Paginator(
    [
        'data'  => $products,
        'limit' => 5,
        'page'  => $numberPage,
    ]
);

$page = $paginator->paginate();
```
[paginator](pagination) 객체는 검색결과를 받습니다. 그리고 여기서 현재 페이지번호와 함께 리미트(페이지당 표시 건수) 도 설정합니다. Finally, we call `paginate()` to get the appropriate chunk of the resultset back.

그리고 나서 반환된 페이지를 뷰로 전달합니다.

```php
<?php

$this->view->page = $page;
```

In the view (`themes/invo/products/search.volt`), we traverse the results corresponding to the current page, showing every row in the current page to the user:

```twig
{% raw %}
{% for product in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th>Product Type</th>
            <th>Name</th>
            <th>Price</th>
            <th>Active</th>
        </tr>
        </thead>
        <tbody>
    {% endif %}
    <tr>
        <td>{{ product.id }}</td>
        <td>{{ product.getProductTypes().name }}</td>
        <td>{{ product.name }}</td>
        <td>${{ "%.2f"|format(product.price) }}</td>
        <td>{{ product.getActiveDetail() }}</td>
        <td width="7%">
            {{ 
                link_to(
                    "products/edit/" ~ product.id, 
                    '<i class="glyphicon glyphicon-edit"></i> Edit', 
                    "class": "btn btn-default"
                ) 
            }}
        </td>
        <td width="7%">
            {{ 
                link_to(
                    "products/delete/" ~ product.id, 
                    '<i class="glyphicon glyphicon-remove"></i> Delete', 
                    "class": "btn btn-default"
                ) 
            }}
        </td>
    </tr>
    {% if loop.last %}
        </tbody>
        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ 
                        link_to(
                            "products/search", 
                            '<i class="icon-fast-backward"></i> First', 
                            "class": "btn"
                        ) 
                    }}
                    {{ 
                        link_to(
                            "products/search?page=" ~ page.before, 
                            '<i class="icon-step-backward"></i> Previous', 
                            "class": "btn"
                        ) 
                    }}
                    {{ 
                        link_to(
                            "products/search?page=" ~ page.next, 
                            '<i class="icon-step-forward"></i> Next', 
                            "class": "btn"
                        ) 
                    }}
                    {{ 
                        link_to(
                            "products/search?page=" ~ page.last, 
                            '<i class="icon-fast-forward"></i> Last', 
                            "class": "btn"
                        ) 
                    }}
                    <span class="help-inline">
                        {{ page.current }} of {{ page.total_pages }}
                    </span>
                </div>
            </td>
        </tr>
        </tbody>
        </table>
    {% endif %}
{% else %}
    No products are recorded
{% endfor %}
{% endraw %}
```

위의 코드에 대해 한가지 설명을 덧붙이자면:

현재 페이지 내의 아이템들은 Volt의 `for`를 사용해서 루프를 돌립니다. Volt는 PHP 의`foreach` 를 좀 더 심플하게 사용할 수 있는 문법을 제공합니다.

```twig
{% raw %}
{% for product in page.items %}
{% endraw %}
```

동일한 내용을 PHP에서는 아래와 같이 표현합니다:

```php
<?php foreach ($page->items as $product) { ?>
```

전체 `for` 블록은 다음과 같습니다:

```twig
{% raw %}
{% for product in page.items %}
    {% if loop.first %}
        // 1
    {% endif %}

    // 2

    {% if loop.last %}
        // 3
    {% endif %}
{% else %}
    // 4
{% endfor %}
{% endraw %}
```

- `1` - 루프(loop) 내에서 첫번째 product 값 이전에 실행
- `2` - page.items 의 모든 product에 대해 실행
- `3` - Executed after the last product in the loop
- `4` - page.iems 배열 내에 product 가 하나도 없을때 실행


이제 뷰로 돌아가서 각각의 블록이 어떤 역할을 하는지 알아봅시다. `product`안의 모든 필드가 적절히 print 됩니다:

```twig
{% raw %}
<tr>
    <td>
        {{ product.id }}
    </td>

    <td>
        {{ product.getProductTypes().name }}
    </td>

    <td>
        {{ product.name }}
    </td>

    <td>
        {{ '%.2f'|format(product.price) }}
    </td>

    <td>
        {{ product.getActiveDetail() }}
    </td>

    <td width='7%'>
        {{ link_to('products/edit/' ~ product.id, 'Edit') }}
    </td>

    <td width='7%'>
        {{ link_to('products/delete/' ~ product.id, 'Delete') }}
    </td>
</tr>
{% endraw %}
```

As we have seen before using `product.id` is the same as in PHP as doing: `$product->id`, we made the same with `product.name` and so on. Other fields are rendered differently, for instance, let's focus in `product.getProductTypes().name`. 이 부분을 이해하려면, Products 모델을 확인해야 합니다(`app/models/Products.php`):

```php
<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Products extends Model
{
    // ...

    public function initialize()
    {
        $this->belongsTo(
            'product_types_id',
            'ProductTypes',
            'id',
            [
                'reusable' => true,
            ]
        );
    }

    // ...
}
```

A model can have a method called `initialize()`, this method is called once per request, and it serves the ORM to initialize a model. 이 경우, `Products`를 초기화 할때 `ProductTypes` 모델과 1: n 관계(one-to-many relationship) 임을 정의합니다.

```php
<?php

$this->belongsTo(
    'product_types_id',
    'ProductTypes',
    'id',
    [
        'reusable' => true,
    ]
);
```
Which means, the local attribute `product_types_id` in `Products` has a one-to-many relation to the `ProductTypes` model in its attribute `id`. 이 관계를 정의함으로써 우리는 다음과 같이 상품타입 명을 액세스 할 수 있게 됩니다:

```twig
{% raw %}
<td>{{ product.getProductTypes().name }}</td>
{% endraw %}
```

`price` 값은 Volt 필터로 포맷되어 출력됩니다:

```twig
{% raw %}
<td>{{ '%.2f' | format(product.price) }}</td>
{% endraw %}
```

일반 PHP에서는 다음과 같이 표현할 수 있겠지요:

```php
<?php echo sprintf('%.2f', $product->price) ?>
```

상품의 사용/비사용 여부는 헬퍼 메서드를 사용해서 출력합니다:

```php
{% raw %}
<td>{{ product.getActiveDetail() }}</td>
{% endraw %}
```

이 메서드는 모델에서 구현되어 있습니다.

## 생성/변경
레코드를 생성하거나 변경할 때, `new` 와 `edit` 뷰를 사용하게 됩니다. The data entered by the user is sent to the `create` and `save` actions that perform actions of _creating_ and _updating_ products, respectively.

레코드 생성의 경우, 제출된 데이터를 받아서 새로운 `Products`인스턴스에 할당합니다:

```php
<?php

public function createAction()
{
    if (true !== $this->request->isPost()) {
        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $form    = new ProductsForm();
    $product = new Products();

    $product->id = $this
        ->request
        ->getPost('id', 'int')
    ;

    $product->product_types_id = $this
        ->request
        ->getPost('product_types_id', 'int')
    ;

    $product->name = $this
        ->request
        ->getPost('name', 'striptags')
    ;

    $product->price = $this
        ->request
        ->getPost('price', 'double')
    ;

    $product->active = $this
        ->request
        ->getPost('active')
    ;

    // ...
}
```
앞에서 본 것 처럼, form을 생성할 때 관련 요소(elements) 에 할당된 필터들이 있었지요. When the data is passed to the form, these filters are invoked, and they sanitize the supplied input. 이 필터링을 필수로 해야 하는건 아니지만, 언제나 그렇듯이 좋은 습관을 들이는 것이 좋습니다. 하나 더 추가하면, 입력된 데이터에 대해 ORM에서도 이스케이프처리를 하고, 컬럼 타입에 따라 추가적인 형변환(casting) 작업을 수행합니다:

```php
<?php

// ...

$name = new Text('name');
$name->setLabel('Name');
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

$name->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'Name is required',
            ]
        )
    ]
);

$this->add($name);
```

Upon saving the data, we will know whether the business rules and validations implemented in the `ProductsForm` pass (`src/Forms/ProductsForm.php`):

```php
<?php

// ...

$form = new ProductsForm();

$product = new Products();

$data = $this->request->getPost();

if (true !== $form->isValid($data, $product)) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        $this->flash->error($message->getMessage());
    }

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'new',
        ]
    );
}
```

`$form->isValid()` 를 호출하면 form에 설정된 모든 검증을 실시합니다. 유효성 검증을 통과하지 못하면, 실패한 검증자의 관련메시지를 `$messages` 변수에 저장합니다.

검증시 오류가 없다면, 레코드를 저장할 수 있습니다:

```php
<?php

// ...

if ($product->save() === false) {
    $messages = $product->getMessages();

    foreach ($messages as $message) {
        $this->flash->error($message->getMessage());
    }

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'new',
        ]
    );
}

$form->clear();

$this->flash->success(
    'Product was created successfully'
);

return $this->dispatcher->forward(
    [
        'controller' => 'products',
        'action'     => 'index',
    ]
);
```

모델의 `save()`메서드 결과값을 확인해서 만약 에러가 발생했다면, `$messages`변수에 나타나며 사용자는 에러메시지와 함께 `products/new` 액션으로 돌려 보내집니다. 모든 것이 문제 없으면, form은 clear되고 사용자는 저장성공 메시지와 함께`products/index` 페이지로 리다이렉트 됩니다.

상품을 변경하는 경우, 우선 데이터베이스에서 관련된 레코드를 가져 온 후 해당 데이터를 form에 띄워야 합니다:

```php
<?php

public function editAction($id)
{
    if (true !== $this->request->isPost()) {
        $product = Products::findFirstById($id);

        if (null !== $product) {
            $this->flash->error(
                'Product was not found'
            );

            return $this->dispatcher->forward(
                [
                    'controller' => 'products',
                    'action'     => 'index',
                ]
            );
        }

        $this->view->form = new ProductsForm(
            $product,
            [
                'edit' => true,
            ]
        );
    }
}
```

첫번째 파라미터로 모델을 넘겨줌으로써 form에 검색된 데이터가 바인드(bound) 됩니다. 이것 때문에, 사용자는 어떤 값이든 변경한 후 `save`액션을 통해 데이터베이스에 돌려 보낼 수 있게 됩니다.

```php
<?php

public function saveAction()
{
    if (true !== $this->request->isPost()) {
        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $id      = $this->request->getPost('id', 'int');
    $product = Products::findFirstById($id);

    if (null !== $product) {
        $this->flash->error(
            'Product does not exist'
        );

        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $form = new ProductsForm();
    $data = $this->request->getPost();

    if (true !== $form->isValid($data, $product)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            $this->flash->error($message->getMessage());
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'new',
            ]
        );
    }

    if (false === $product->save()) {
        $messages = $product->getMessages();

        foreach ($messages as $message) {
            $this->flash->error($message->getMessage());
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'new',
            ]
        );
    }

    $form->clear();

    $this->flash->success(
        'Product was updated successfully'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

## 동적인 타이틀
어플리케이션을 돌어다니면서 살펴보다 보면, 우리가 현재 작업중인 위치를 표시하며 타이틀이 동적으로 바뀌는 것을 보실 수 있습니다. 이것은 각각의 컨트롤러에서 수행됩니다 (`initialize()` 메서드):

```php
<?php

class ProductsController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->tag->title()
                  ->set('Manage your products')
        ;
    }

    // ...
}
```

주의하실 부분은, `parent::initialize()` 메서드 또한 호출되어, 타이틀에 더 많은 데이터를 추가합니다:

```php
<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->title()
                  ->prepend('INVO | ')
        ;
        $this->view->setTemplateAfter('main');
    }

    // ...
}
```
위의 코드는 어플리케이션 이름을 타이틀의 앞부분에 추가합니다

Finally, the title is printed in the main view (`themes/invo/views/index.volt`):

```php
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <!-- ... -->
</html>
```

[github_invo]: https://github.com/phalcon/invo

[github_invo]: https://github.com/phalcon/invo
[bootstrap]: https://getbootstrap.com
[sha1]: https://php.net/manual/en/function.sha1.php
[crud]: https://en.wikipedia.org/wiki/Create,_read,_update_and_delete
[jinja]: https://jinja.palletsprojects.com/en/2.10.x/
[twig]: https://twig.symfony.com/
[events-event]: api/phalcon_events#events-event
[di-injectable]: api/phalcon_di#di-injectable
[mvc-model-criteria]: api/phalcon_mvc#mvc-model-criteria
