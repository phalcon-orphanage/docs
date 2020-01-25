---
layout: default
language: 'ko-kr'
version: '4.0'
title: '자습서 - INVO'
keywords: 'tutorial, invo tutorial, step by step, mvc, 자습서'
---

# 자습서 - INVO

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg) ![](/assets/images/level-intermediate.svg)

## 개요

[INVO](https://github.com/phalcon/invo) 는 송장(invoices) 생성, 고객과 상품관리 및 회원가입/로그인 을 하도록 해주는 작은 애플리케이션입니다. 이것은 Phalcon이 특정 작업을 어떻게 처리하는지 잘 보여줍니다. 클라이언트 단에서는, UI를 위해 [Bootstrap](https://getbootstrap.com) 을 사용합니다. 이 어플리케이션은 실제 송장을 생성하지는 않지만, 이런 작업들을 Phalcon을 사용해서 어떻게 구현할 수 있는지 잘 보여주는 예제로 생각해 주세요.

> **주의**: 이 자습서를 좀 더 쉽게 따라오실 수 있도록 자주 쓰는 에디터에서 어플리케이션을 여시는 것을 권해 드립니다. 
{: .alert .alert-info }

> 
> **주의**: 아래의 코드는 가독성을 위해 정렬되었음을 알려드립니다
{: .alert .alert-warning }

## 구조

[GitHub](https://github.com/phalcon/invo) 에서 저장소를 머신에 복제(혹은 다운로드) 합니다. 복제(혹은 다운로드 및 zip파일 압축해제) 한 후 보시면 다음과 같은 디렉토리 구조를 확인하실 수 있습니다.

```bash
└── invo
    ├── app
    │   ├── config
    │   ├── controllers
    │   ├── forms
    │   ├── library
    │   ├── logs
    │   ├── models
    │   ├── plugins
    │   └── views
    ├── cache
    │   └── volt
    ├── docs
    │── public
    │   ├── css
    │   ├── img
    │   ├── index.php
    │   └── js
    └── schemas
```

Phalcon은 특정한 디렉토리 구조를 강제하지 않으며, 여기서 보시는 특정 디렉토리 구조는 우리가 그렇게 구현한 것일 뿐입니다. [웹서버 설정](webserver-setup) 페이지의 설명에 따라 웹서버를 준비해 주세요.

어플리케이션이 준비되면, 브라우저에서 다음의 URL `https://localhost/invo` 을 입력해서 실행시킬 수 있습니다. 아래와 비슷한 화면을 보실 수 있습니다:

![](/assets/images/content/tutorial-invo-1.png)

이 어플리케이션은 프론트엔드와 백엔드, 두 부분으로 나뉘어져 있습니다. 프론트엔드는 방문자가 INVO에 대한 정보를 얻고 연락정보를 요청할 수 있는 공개된 영역입니다. 백엔드는 등록된 사용자가 제품과 고객을 관리할 수 있는 관리자 영역입니다.

## 라우팅

INVO는 [Router](routing) 컴포넌트에 내장된 표준 라우트를 사용합니다. 이 라우트는 다음의 패턴을 따릅니다:

    /:controller/:action/:params
    

커스텀 라우트인 `/session/register` 는 `SessionController` 컨트롤러와 그에 속한 `registerAction` 액션을 실행시킵니다.

## 구성

INVO는 어플리케이션에서 사용할 일반적인 파라미터 값들을 설정한 구성파일을 가지고 있습니다. 이 파일은 `app/config/config.ini` 에 위치하며 어플리케이션 시동(`public/index.php`) 과정 중 첫 번째로 로드됩니다:

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

// ...

$config = new ConfigIni(
    APP_PATH . 'app/config/config.ini'
);

```

[Phalcon Config](config) 는 파일을 객체지향적 방식으로 처리할 수 있도록 해 줍니다. 이 예제에서 우리는, 구성을 위해 `ini` 파일을 사용합니다. [Phalcon\Config](config) 객체는 다른 소스에서도 설정파일을 로드할 수 있도록 추가적인 어댑터를 제공하고 있습니다. 구성파일은 다음의 설정을 가지고 있습니다:

```ini
[database]
host     = localhost
username = root
password = secret
name     = invo

[application]
controllersDir = app/controllers/
modelsDir      = app/models/
viewsDir       = app/views/
pluginsDir     = app/plugins/
formsDir       = app/forms/
libraryDir     = app/library/
baseUri        = /invo/
```

Phalcon에서는 설정값들을 정의하는데 있어서 특별한 규칙이 없습니다. 섹션은 어플리케이션에서 의미있는 그룹들을 기반으로 옵션을 정리하는데 도움이 됩니다. 우리의 파일에는 이후에 사용하게 될 두개의 항목이 있습니다: `application` 과 `database`.

## Autoloader

부트스트랩(시동) 파일 (`public/index.php`) 에서 보이는 두번째 부분은 오토로더입니다:

```php
<?php

require APP_PATH . 'app/config/loader.php';
```

오토로더는 우리가 필요한 클래스들을 어플리케이션이 찾아볼 수 있는, 몇개의 디렉토리들을 등록합니다.

```php
<?php

$loader = new Phalcon\Loader();
$loader->registerDirs(
    [
        APP_PATH . $config->application->controllersDir,
        APP_PATH . $config->application->pluginsDir,
        APP_PATH . $config->application->libraryDir,
        APP_PATH . $config->application->modelsDir,
        APP_PATH . $config->application->formsDir,
    ]
);

$loader->register();
```

> **주의**: 위의 코드는 구성 파일에 정의되어 있는 디렉토리를 등록하고 있습니다. 예외로, `viewsDir` 는 클래스가 아닌 HTML + PHP파일들만 존재하기 때문에 별도로 등록하지 않습니다. 
{: .alert .alert-info }

> 
> **주의**: 우리는 `APP_PATH` 라는 상수를 사용하고 있습니다. 이 상수는 프로젝트의 루트 위치를 참조할 수 있도록 부트스트랩(`public/index.php`)에 정의되어 있습니다:
{: .alert .alert-info }

```php
<?php

// ...

define('APP_PATH', realpath('..') . '/');
```

## 서비스

부트스트랩에서 필요한 또 다른 파일은 (`app/config/services.php`)입니다. 이 파일은 INVO가 사용하는 서비스들을 체계화 할 수 있도록 해주고 DI 컨테이너에 등록 해줍니다.

```php
<?php

require APP_PATH . 'app/config/services.php';
```

서비스 등록에서, 필요한 컴포넌트의 지연로딩(lazy loading) 을 위해 클로저를 사용합니다:

```php
<?php

use Phalcon\Url;

$container->set(
    'url',
    function () use ($config) {
        $url = new Url();

        $url->setBaseUri(
            $config->application->baseUri
        );

        return $url;
    }
);
```

## 요청 처리

파일(`public/index.php`)의 제일 아랫쪽으로 가 보면, 어플리케이션이 실행하는데 필요한 모든 서비스를 초기화시키는 [Phalcon\Mvc\Application](application)에 의해 요청(request)이 처리됩니다.

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($container);

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

$response->send();
```

## 의존성 주입(Dependency Injection)

위 코드 블록의 첫줄에서, [Application](application) 클래스 생성자는 `$container` 변수를 인자값으로 받습니다.

Phalcon은 매우 느슨하게 연결(highly decoupled) 되어 있기 때문에, 어플리케이션의 다른 부분에서 컨테이너가 등록된 서비스에 접근할 수 있도록 해줄 필요가 있습니다. 이 부분에 해당하는 컴포넌트는 [Phalcon\Di](di) 입니다. 이 컴포넌트는 서비스 컨테이너이며 동시에 의존성 주입, 서비스 위치확인, 어플리케이션에서 필요한 모든 컴포넌트 의 인스턴스화 등을 담당하고 있습니다.

컨테이너에 서비스를 등록하는 방법은 다양합니다. INVO에서는, 대부분의 서비스는 익명함수/클로저를 이용해서 등록합니다. 덕분에, 객체는 지연 로딩(lazy loaded) 되어 어플리케이션에서 필요한 리소스를 최소화 시켜줍니다.

예를 들어, 다음의 예제코드는 세션 서비스를 등록합니다. 이 익명함수는 어플리케이션에서 세션데이터를 필요로 할때만 호출됩니다:

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$container->set(
    'session',
    function () {
        $session = new Manager();
        $files   = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);

        $session->start();

        return $session;
    }
);
```

여기서, 우리는 어댑터를 자유로이 변경할 수 있으며, 추가적인 초기화 등 다양한 작업을 할 수 있습니다. 이 서비스는 `session` 라는 이름으로 등록되었음을 주의해주세요. 프레임워크가 서비스 컨테이너에서 활성화된 서비스를 구분하기 위한 규약입니다.

요청은 다수의 서비스를 사용할 수 있으며, 이들 서비스를 개별적으로 등록하는 것은 매우 번거로운 작업이 될 가능성이 큽니다. 그런 이유로, 프레임워크는 [Phalcon\Di](di)의 변형인 [Phalcon\Di\FactoryDefault](di#factory-default)를 제공합니다`. 이 클래스는 풀스택 MVC 어플리케이션에 맞춰 필요한 서비스가 사전에 등록되어 있습니다.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

$container = new FactoryDefault();
```

서비스를 덮어 써야하는 경우 일부 서비스의 정의를 재정의해야합니다. `session` 또는 `url`을 사용하여 위에서와 같이 다시 설정하면됩니다. 이것이 `$container`변수가 존재하는 이유입니다.

## 로그인

`로그인` 페이지는 백엔드 컨트롤러와 작업할 수 있도록 해 줍니다. 백엔드 컨트롤러와 프론트엔드 컨트롤러 간의 구분은 사실 좀 임의적입니다. 모든 컨트롤러는 동일한 디렉토리 내에 있거든요 (`app/controllers/`).

![](/assets/images/content/tutorial-invo-2.png)

시스템에 진입하기 위해서, 사용자는 유효한 사용자명과 암호를 가지고 있어야 합니다. 사용자 데이터는 `invo` 데이터베이스의 `users`테이블에 저장되어 있습니다.

이제 데이터베이스 연결을 설정해 봅시다. `db` 서비스는 서비스 컨테이너 내에 연결정보와 함께 설정되어 있습니다. 오토로더와 마찬가지로, 서비스를 구성하기 위해 설정파일에서 다시한번 파라미터 값을 가져 옵니다.

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// ...

$container->set(
    'db',
    function () use ($config) {
        return new DbAdapter(
            [
                'host'     => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname'   => $config->database->name,
            ]
        );
    }
);
```

여기서, MySQL 연결 어댑터의 인스턴스를 반환합니다. [Logger](logger) 를 추가하거나, 쿼리 실행시간 측정을 위한 [profiler](db-models-events#profiling-sql-statements)를 추가 하는 등의 별도 기능을 추가할 수 있으며, 심지어 다른 RDBMS로 어댑터 변경도 가능합니다.

다음의 간단한 form (`app/views/session/index.volt`) 은 사용자가 로그인 정보를 submit 하는데 필요한 HTML을 생성합니다. 가독성을 위해 HTML 코드의 일부를 제거했습니다.

```twig
{% raw %}
{{ form('session/start') }}
    <fieldset>
        <div>
            <label for='email'>
                Username/Email
            </label>

            <div>
                {{ text_field('email') }}
            </div>
        </div>

        <div>
            <label for='password'>
                Password
            </label>

            <div>
                {{ password_field('password') }}
            </div>
        </div>

        <div>
            {{ submit_button('Login') }}
        </div>
    </fieldset>
{{ endForm() }}
{% endraw %}
```

템플릿 엔진으로 PHP 대신에 [Volt](volt)를 사용하고 있습니다. 템플릿을 생성하는데 있어서 간단하고 사용자에게 친숙한 문법을 제공하는 이 템플릿 엔진은 Phalcon에 기본 내장되어 있으며 [Jinja](https://jinja.palletsprojects.com/en/2.10.x/) 에서 영감을 얻었습니다. 과거에 [Jinja](https://jinja.palletsprojects.com/en/2.10.x/) 혹은 [Twig](https://twig.symfony.com/) 을 사용해본 경험이 있다면, 많은 유사성을 알아차리실 것입니다.

`SessionController::startAction` 함수 (`app/controllers/SessionController.php`) 는 form에서 제출된 데이터를 검증하고, 데이터베이스에서 유효한 사용자를 확인합니다:

```php
<?php

class SessionController extends ControllerBase
{
    // ...

    private function _registerSession($user)
    {
        $this->session->set(
            'auth',
            [
                'id'   => $user->id,
                'name' => $user->name,
            ]
        );
    }

    public function startAction()
    {
        if (true === $this->request->isPost()) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

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

            if (false !== $user) {
                $this->_registerSession($user);

                $this->flash->success(
                    'Welcome ' . $user->name
                );

                return $this->dispatcher->forward(
                    [
                        'controller' => 'invoices',
                        'action'     => 'index',
                    ]
                );
            }

            $this->flash->error(
                'Wrong email/password'
            );
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }
}
```

코드를 보는 순간, 컨트롤러 내에서 `$this->flash`, `$this->request` 혹은 `$this->session` 등 몇 개의 퍼블릭 속성 값들을 사용하고 있다는 것을 알아차리실 것입니다. Phalcon에서 [컨트롤러](controllers) 는 자동으로 [Phalcon\Di](di) 컨테이너에 자동으로 연결되기 때문에, 컨테이너에 등록된 모든 서비스들은 각 서비스명과 동일한 이름의 속성으로 각각의 컨트롤러 내에 존재하게 됩니다. 서비스에 처음 접근하는 시점에서 해당서비스는 자동으로 인스턴스화 되어 호출자에게 반환됩니다. 그리고 이 서비스들은 *shared* 로 설정되기 때문에, 동일 요청 내에서 해당 속성/서비스를 몇번 호출했냐와 상관없이 동일한 인스턴스가 반환 됩니다. 이들은 앞에서 나왔던 서비스 컨테이너(`app/config/services.php`) 내에서 정의된 서비스들이며 당연히 서비스 설정 시 이 행동들을 변경할 수 있습니다.

예를 들어, `session` 서비스를 호출해서 사용자정보를 `auth` 변수에 저장한다고 하면:

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

> **주의**: DI 서비스에 대한 더 자세한 정보는, [의존성 주입(Dependency Injection)](di) 문서를 참조해 주세요.
{: .alert .alert-info }

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

> **주의**: '파라미터 연동(bound parameters)' 방법은, `:email:` 과 `:password:` 플레이스홀더를 해당 값이 있어야 할 곳에 위치시킨 후, `bind` 파라미터를 사용해서 값을 *연동* 한다는 점을 주의해 주세요. 이렇게 함으로써 SQL injection의 위험 없이 이들 컬럼을 값으로 대체 할 수 있습니다.

데이터베이스 내의 사용자를 검색할 때, 우리는 바로 평문 텍스트를 사용해서 암호를 찾지 않습니다. 어플리케이션은 [sha1](https://php.net/manual/en/function.sha1.php) 메서드를 이용해서 암호를 해쉬값으로 저장합니다. 이 방법론은 튜토리얼 목적으론 적절하지만, 운영환경의 어플리케이션을 위해서는 다른 알고리즘을 고려하는 것이 더 적절할 수 있습니다. [Phalcon\Security](security) 컴포넌트는 해쉬값을 위해 더 강화된 알고리즘을 적용할 수 있도록 편리한 메서드들을 제공하고 있습니다.

사용자를 찾으면, 해당 사용자를 세션에 등록(사용자를 로그 인) 하고 환영 메시지를 표시하면서 대시보드(`Invoices` 컨트롤러, `index` 액션) 로 이동시킵니다.

```php
<?php

if (false !== $user) {
    $this->_registerSession($user);

    $this->flash->success(
        'Welcome ' . $user->name
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'invoices',
            'action'     => 'index',
        ]
    );
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

백엔드는 등록된 사용자만 접근할 수 있는 비공개 영역입니다. 그러므로, 등록된 사용자만 이들 컨트롤러에 접근가능한지 여부를 확인할 필요가 있습니다. 만약 당신이 로그인 하지 않은 상태에서 *비공개* 영역에 접근하려 한다면 아래와 같은 메시지를 보게 됩니다:

![](/assets/images/content/tutorial-invo-3.png)

사용자가 컨트롤러/액션에 접근하려 할 때 마다, 어플리케이션은 현재의 역할(세션에 저장되어 있음) 로 해당 컨트롤러/액션에 접근할 수 있는지 확인하게 되며, 권한이 없다면 위와 같은 메시지를 뿌리고는 홈페이지로 이동시킵니다.

이렇게 하기 위해서 우리는 [Dispatcher](dispatcher) 컴포넌트를 사용해야 합니다. 사용자가 페이지나 URL을 요청하면, 어플리케이션은 먼저 [Route](routing) 컴포넌트를 이용해서 요청받은 페이지를 확인합니다. 경로(route) 가 확인되고 매치되는 유효한 컨트롤러/액션이 있다면, 이 정보는 [Dispatcher](dispatcher) 로 위임(delegate) 되어 해당 컨트롤러를 로드하고 액션을 실행시킵니다.

보통은 프레임워크가 자동으로 Dispatcher를 생성합니다. 우리의 경우, 해당 경로(route) 로 보내기 전에 먼저 사용자가 로그인 되어있는지 확인할 필요가 있습니다. 그래서 우리는 DI 컨테이너 내의 기본 컴포넌트를 대체할 새 컴포넌트를 끼워 넣어야 합니다. 어플리케이션을 부트스트래핑(초기화) 할 때 이 작업을 수행합니다:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// ...

$container->set(
    'dispatcher',
    function () {
        // ...

        $containerspatcher = new Dispatcher();

        return $containerspatcher;
    }
);
```

Dispatcher가 등록되었으므로, 이제 우리는 *훅(hook)*으로 프로그램 실행 흐름을 중간에서 가로채 검증 과정을 수행 할 수 있습니다. Phalcon에서는 훅(hook) 을 이벤트라고 부르는데, 어플리케이션 내에서 이벤트를 활성화하고 *발생*시키기 위해서는 [이벤트 관리자](events) 컴포넌트를 먼저 등록해야 합니다.

[이벤트 관리자](events) 를 만들고 `dispatcher` 이벤트에 특정 코드를 붙임으로써, 이제 우리는 다양한 상황에 쉽게 대처할 수 있고 dispatch loop 나 동작 과정 중에 필요한 코드를 추가할 수 있습니다.

### 이벤트

[이벤트 관리자](events) 를 사용해서 특정한 형태의 이벤트에 리스너를 붙일 수 있습니다. 현재 우리는 `dispatch` 이벤트 타입에 리스너를 붙이고 있습니다. 아래 코드는 `beforeExecuteRoute` 와 `beforeException` 이벤트에 리스너를 붙입니다. 이 이벤트를 이용해서 404페이지를 체크하고 어플리케이션의 접근허가 여부 확인을 수행합니다.

```php
<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager;

$container->set(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch:beforeExecuteRoute',
            new SecurityPlugin()
        );

        $eventsManager->attach(
            'dispatch:beforeException',
            new NotFoundPlugin()
        );

        $containerspatcher = new Dispatcher();

        $containerspatcher->setEventsManager($eventsManager);

        return $containerspatcher;
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

`beforeException` 이벤트가 발생하면`NotFoundPlugin` 가 알림을 받습니다:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundPlugin()
);
```

`SecurityPlugin` 은 `plugins` 디렉토리에 위치한 클래스입니다(`app/plugins/SecurityPlugin.php`). 이 클래스는 `beforeExecuteRoute` 메서드를 구현합니다. Dispatcher에서 발생시킨 이벤트 이름과 동일합니다.

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

이벤트 메서드는 첫번째 파라미터로 항상 실제 이벤트를 받습니다. This is a [Phalcon\Events\Event](api/phalcon_events#events-event) object which will contain information regarding the event such as its type and other related information. 이 특정 이벤트에서, 두번째 파라미터는 이벤트 자체가 생성한 객체(`$containerspatcher`) 가 될 것입니다. 플러그인이 [Phalcon\Di\Injectable](api/phalcon_di#di-injectable) 클래스를 반드시 상속받아야 할 필요는 없지만, 상속을 받으면 어플리케이션에서 사용가능한 서비스에 더 쉽게 접근할 수 있습니다.

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

        $controller = $containerspatcher->getControllerName();
        $action     = $containerspatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);
        if (true !== $allowed) {
            $this->flash->error(
                "이 모듈에 접근 권한이 없습니다"
            );

            $containerspatcher->forward(
                [
                    'controller' => 'index',
                    'action'     => 'index',
                ]
            );

            return false;
        }
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

$acl->setDefaultAction(
    Enum::DENY
);

$roles = [
    'users'  => new Role('Users'),
    'guests' => new Role('Guests'),
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

foreach ($roles as $role) {
    foreach ($publicComponents as $resource => $actions) {
        $acl->allow(
            $role->getName(),
            $resource,
            '*'
        );
    }
}

foreach ($privateComponents as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow(
            'Users',
            $resource,
            $action
        );
    }
}
```

## CRUD

어플리케이션의 백엔드 부분은 사용자가 데이터를 다룰 수 있도록 form과 로직을 제공하는, 즉 CRUD 작업을 수행하는 코드입니다. INVO 가 이 작업을 어떻게 다루는지, 그리고 form, validater, paginator 등을 사용하는 방법들에 대해 알아보도록 하겠습니다.

INVO에서는 회사(companies), 상품(products), 상품타입(types of products) 데이터를 처리하기 위해 간단한 [CRUD](https://ko.wikipedia.org/wiki/CRUD) (Create, Read, Update and Delete) 작업을 구현했습니다. 상품(products) 데이터를 관리하기 위해 아래와 같은 파일들을 사용합니다:

```bash
└── invo
    └── app
        ├── controllers
        │   └── ProductsController.php
        ├── forms
        │   └── ProductsForm.php
        ├── models
        │   └── Products.php
        └── views
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
    public function indexAction();

    public function searchAction();

    public function newAction();

    public function editAction();

    public function createAction();

    public function saveAction();

    public function deleteAction($id);
}
```

| 액션             | 설명                                                               |
| -------------- | ---------------------------------------------------------------- |
| `createAction` | `new` 액션에서 입력된 데이터에 기초하여 상품을 생성                                  |
| `deleteAction` | 상품 삭제                                                            |
| `editAction`   | 기존의 상품을 편집(`edit`) 할 수 있는 뷰를 표시                                  |
| `indexAction`  | `search` 뷰를 표시하는, 시작 액션                                          |
| `newAction`    | 신규(`new`) 상품을 생성하는 뷰를 표시                                         |
| `saveAction`   | 편집(`edit`) 액션에서 입력된 데이터에 기초하여 상품을 업데이트                           |
| `searchAction` | `index` 에서 보내진 기준조건에 기초하여 검색(`search`) 실행. 결과값에 대한 paginator를 반환 |

## 검색 Form

INVO에서 CRUD 작업은 검색 form에서 시작합니다. 이 form은 상품 테이블(`products`) 에 있는 필드들을 표시해서 사용자가 각각의 항목에 대해 검색어를 입력할 수 있도록 합니다. `products` 테이블은 `products_types` 테이블과 종속관계가 있습니다. In this case, we previously queried the records in the `product_types` table to offer search criteria for this field:

```php
<?php

public function indexAction()
{
    $this->persistent->searchParams = null;

    $this->view->form = new ProductsForm();
}
```

`ProductsForm` form (`app/forms/ProductsForm.php`) 의 인스턴스를 뷰로 넘겨줍니다. 이 form은 사용자에게 보여지는 필드값들을 정의합니다.

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
            $element = new Text('id');
            $element->setLabel('Id');
            $this->add($element);
        } else {
            $this->add(new Hidden('id'));
        }

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

        $type = new Select(
            'profilesId',
            ProductTypes::find(),
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

        $this->add($type);

        $price = new Text('price');
        $price->setLabel('Price');
        $price->setFilters(
            [
                'float',
            ]
        );
        $price->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'Price is required',
                    ]
                ),
                new Numericality(
                    [
                        'message' => 'Price is required',
                    ]
                ),
            ]
        );
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

우선 요소를 생성합니다. 그리고 데이터 보안처리(sanitization) 를 할 수 있도록 요소에 라벨과 필터를 붙입니다. 그리고 요소에 validator를 적용한 후 마지막으로 form에 추가합니다.

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
{{ form('products/search') }}

    <h2>
        Search products
    </h2>

    <fieldset>

        {% for element in form %}
            <div class='control-group'>
                {{ element.label(['class': 'control-label']) }}

                <div class='controls'>
                    {{ element }}
                </div>
            </div>
        {% endfor %}



        <div class='control-group'>
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>

    </fieldset>

{{ endForm() }}
{% endraw %}
```

위의 코드는 아래와 같은 HTML을 생성합니다:

```html
<form action='/invo/products/search' method='post'>

    <h2>
        Search products
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

[Phalcon\Mvc\Model\Criteria](api/phalcon_mvc#mvc-model-criteria)를 사용해서, 데이터타입과 form에서 제출된 값을 기반으로 한 검색조건을 만듭니다:

```php
<?php

$query = Criteria::fromInput(
    $this->di,
    'Products',
    $this->request->getPost()
);
```

이 메서드는 값의 '' (빈 문자열), `null` 여부를 검증하여, 검색조건을 생성할때 고려합니다:

- 필드의 데이터타입이 `text` 혹은 이와 유사한 타입 (`char`, `varchar`, `text`, 등등.) 인 경우 SQL `like` 연산자를 사용해서 결과를 필터링합니다.
- 데이터타입이 `text` 혹은 그 유사형태가 아닌 경우, `=` 연산자를 사용합니다.

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

[paginator](pagination) 객체는 검색결과를 받습니다. 그리고 여기서 현재 페이지번호와 함께 리미트(페이지당 표시 건수) 도 설정합니다. 마지막으로 `paginate()` 를 호출해서 적적한 결과목록의 부분을 다시 넘겨받습니다.

그리고 나서 반환된 페이지를 뷰로 전달합니다.

```php
<?php

$this->view->page = $page;
```

뷰 (`app/views/products/search.volt`) 에서, 현재페이지에 맞는 결과값을 루프를 돌면서 모든 row값들을 하나하나 표시합니다.

```twig
{% raw %}
{% for product in page.items %}
    {% if loop.first %}
        <table>
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

    {% if loop.last %}
            </tbody>
            <tbody>
                <tr>
                    <td colspan='7'>
                        <div>
                            {{ 
                                link_to(
                                    'products/search', 
                                    'First'
                                ) 
                            }}
                            {{ 
                                link_to(
                                    'products/search?page=' ~ page.previous, 
                                    'Previous'
                                ) 
                            }}
                            {{ 
                                link_to(
                                    'products/search?page=' ~ page.next, 
                                    'Next'
                                ) 
                            }}
                            {{ 
                                link_to(
                                    'products/search?page=' ~ page.last, 
                                    'Last'
                                ) 
                            }}
                            <span class='help-inline'>
                                {{ page.current }} of 
                                {{ page.total_pages }}
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
- `3` - 루프 내에서 마지막 product 다음에 실행
- `4` - page.iems 배열 내에 product 가 하나도 없을때 실행

이제 뷰로 돌아가서 각각의 블록이 어떤 역할을 하는지 알아봅시다. `product`안의 모든 필드가 적절히 print 됩니다:

```twig
{% raw %}
<tr>
    <td>
        {{ product.id }}
    </td>

    <td>
        {{ product.productTypes.name }}
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

앞에서 확인한 바와 같이 `product.id` 를 사용하는 것은 PHP 에서: `$product->id` 와 동일하며, `product.name` 등도 같습니다. 다른 형태로 렌더링되는 필드도 있습니다, 예를 들어, `product.productTypes.name` 에 주목해 보세요. 이 부분을 이해하려면, Products 모델을 확인해야 합니다(`app/models/Products.php`):

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

모델은 `initialize()` 메서드를 가질 수 있습니다. 이 메서드는 요청당 한번씩 호출될 수 있으며 ORM이 모델을 초기화 하도록 해 줍니다. 이 경우, `Products`를 초기화 할때 `ProductTypes` 모델과 1: n 관계(one-to-many relationship) 임을 정의합니다.

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

즉, `Products`의 로컬 속성인 `product_types_id`가 `ProductTypes`의 속성 `id`과 1: n 관계라는 의미입니다. 이 관계를 정의함으로써 우리는 다음과 같이 상품타입 명을 액세스 할 수 있게 됩니다:

```twig
{% raw %}
<td>{{ product.productTypes.name }}</td>
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

레코드를 생성하거나 변경할 때, `new` 와 `edit` 뷰를 사용하게 됩니다. 사용자가 입력한 데이터는 상품을 `creating(생성)` `updating(변경)` 작업을 수행하는 `create`와 `save` 액션으로 각각 보내집니다.

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

앞에서 본 것 처럼, form을 생성할 때 관련 요소(elements) 에 할당된 필터들이 있었지요. 데이터가 form으로 전달되면, 이 필터들이 실행되어 입력값에 대해 검증처리(sanitize) 를 하게 됩니다. 이 필터링을 필수로 해야 하는건 아니지만, 언제나 그렇듯이 좋은 습관을 들이는 것이 좋습니다. 하나 더 추가하면, 입력된 데이터에 대해 ORM에서도 이스케이프처리를 하고, 컬럼 타입에 따라 추가적인 형변환(casting) 작업을 수행합니다:

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

데이터를 저장하는 시점에, `ProductsForm` 에 적용된 (`app/forms/ProductsForm.php`) 비즈니스 룰과 유효성 검증(validation)을 통과했는지 알 수 있습니다:

```php
<?php

// ...

$form = new ProductsForm();

$product = new Products();

$data = $this->request->getPost();

if (true !== $form->isValid($data, $product)) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        $this->flash->error($message);
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
        $this->flash->error($message);
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

        if (false !== $product) {
            $this->flash->error(
                '상품을 찾을 수 없습니다'
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

    if (false !== $product) {
        $this->flash->error(
            '상품이 존재하지 않습니다'
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
            $this->flash->error($message);
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
            $this->flash->error($message);
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
        '상품이 성공적으로 업데이트 되었습니다'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

## 컴포넌트

UI는 [Bootstrap](https://getbootstrap.com) 라이브러리를 이용해서 만들었습니다. 네비게이션 바와 같은 일부 요소들은 어플리케이션의 상태에 따라 바뀝니다. 예를 들어, 우상단 코너에 있는 `Log in / Sign Up` 링크는 사용자가 어플리켕션에 로그인 하면 `Log out`로 바뀝니다.

어플리케이션에서 이 부분은 `Elements`컴포넌트에서 구현됩니다.(`app/library/Elements.php`).

```php
<?php

use Phalcon\Di\Injectable;

class Elements extends Injectable
{
    public function getMenu()
    {
        // ...
    }

    public function getTabs()
    {
        // ...
    }
}
```

이 클래스는 [Phalcon\Di\Injectable](api/phalcon_di#di-injectable)를 상속받습니다. 그래야 할 필요는 없지만 이 컴포넌트를 상속 받으면 어플리케이션의 모든 서비스에 접근가능해 집니다. 이 사용자 컴포넌트를 서비스 컨테이너에 등록합니다:

```php
<?php

$container->set(
    'elements',
    function () {
        return new Elements();
    }
);
```

이 컴포넌트가 DI 컨테이너에 등록되었으므로, 서비스 등록시 사용했던 것과 같은 이름의 속성값을 이용해서 뷰에서 바로 접근할 수 있습니다.

```twig
{% raw %}
<div class='navbar navbar-fixed-top'>
    <div class='navbar-inner'>
        <div class='container'>
            <a class='btn btn-navbar' 
               data-toggle='collapse' 
               data-target='.nav-collapse'>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
            </a>

            <a class='brand' href='#'>INVO</a>

            {{ elements.getMenu() }}
        </div>
    </div>
</div>

<div class='container'>
    {{ content() }}

    <hr>

    <footer>
        <p>&copy; Company {{ date('Y') }}</p>
    </footer>
</div>
{% endraw %}
```

중요한 부분은:

```twig
{% raw %}
{{ elements.getMenu() }}
{% endraw %}
```

## 동적인 타이틀

어플리케이션을 돌어다니면서 살펴보다 보면, 우리가 현재 작업중인 위치를 표시하며 타이틀이 동적으로 바뀌는 것을 보실 수 있습니다. 이것은 각각의 컨트롤러에서 수행됩니다 (`initialize()` 메서드):

```php
<?php

class ProductsController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle(
            'Manage your product types'
        );

        parent::initialize();
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
        $this->tag->prependTitle('INVO | ');
    }

    // ...
}
```

위의 코드는 어플리케이션 이름을 타이틀의 앞부분에 추가합니다

마지막으로, 타이틀이 메인 뷰에 출력됩니다(`app/views/index.volt`):

```php
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <!-- ... -->
</html>
```