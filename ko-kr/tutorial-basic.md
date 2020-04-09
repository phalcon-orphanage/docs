---
layout: default
language: 'ko-kr'
version: '4.0'
title: '지침서 - 기초'
keywords: 'tutorial, basic tutorial, step by step, mvc, 지침서, 기초, 튜토리얼'
---

# 지침서 - 기초

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg) ![](/assets/images/level-beginner.svg)

## 개요

이 지침서 전체에 걸쳐 Phalcon 설계 상의 주요 측면에 대해 소개함과 동시에, 간단한 등록양식이 있는 어플리케이션을 만들어 보겠습니다.

이 지침서에서는 Phalcon 을 이용하면 얼마나 빠르고 쉽게 만들 수 있는지 보여주기 위해 간단한 MVC 어플리케이션의 구현을 다룹니다. 개발이 완료되면, 이 어플리케이션을 필요에 따라 확장시켜 사용하실 수있습니다. 이 지침서에 있는 코드는 다른 Phalcon 특유의 컨셉트와 아이디어를 배우는 놀이터로도 사용될 수 있습니다. <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen mark="crwd-mark"></iframe> 

바로 시작하기를 원하신다면 이 섹션은 건너뛰고 [developer tools](devtools)를 이용해서 자동으로 Phalcon 프로젝트를 생성하세요.

이 가이드를 사용하는 최고의 방법은 찬찬히 따라 오시면서 즐기려고 노력하시는 겁니다. 전체 코드는 [여기](https://github.com/phalcon/tutorial) 있습니다. 난관에 봉착했거나 궁금한게 있으시면, [Discord](https://phalcon.io/discord) 나 [포럼](https://phalcon.io/forum)으로 오시면 됩니다.

## 파일 구조

Phalcon의 핵심기능 중 하나는 느슨하게 연결(loosely coupled) 되어 있다는 부분입니다. 그런 이유로, 어떤 형태든 본인이 편한대로 디렉토리 구조를 만드실 수 있습니다. 이 지침서에서는 MVC 어플리케이션에서 일반적으로 사용되는 *표준* 디렉토리 구조를 사용하겠습니다.

```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

> **주의**: Phalcon이 노출하는 모든 코드는 (웹서버에서 로드한) 익스텐션 내에 캡슐화 되어있으므로, Phalcon 코드를 포함하고 있는 `vendor` 디렉토리는 여기에 없습니다. 필요한 모든 것이 메모리에 로드되어 있습니다. 아직 어플리케이션 설치 전이시라면, 이 자습서를 더 진행하시기 전에 [설치](installation) 페이지로 가셔서 설치과정을 완료해주시기 바랍니다
{: .alert .alert-warning }

모든 것이 처음이시라면 [Phalcon Devtools](devtools) 또한 설치하시기를 권장합니다. DevTools는 어플리케이션을 즉시 실행해 보실 수 있도록, PHP에 내장되어 있는 웹서버를 활용합니다. 이 옵션을 선택하신다면, 프로젝트 루트폴더에 `.htrouter.php` 파일을 아래와 같은 내용으로 생성해주세요:

```php
<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

$_GET['_url'] = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/public/index.php';
```

이 자습서의 경우에, 이 파일은 `tutorial` 디렉토리에 위치해야 합니다.

NginX, apache, cherokee 혹은 다른 웹서버를 사용하시는 것도 물론 가능합니다. [웹서버 준비](webserver-setup) 페이지게 가시면 자세한 설명을 확인하실 수 있습니다.

## Bootstrap

제일 처음에 bootstrap 파일을 생성해야 합니다. 이 파일은 어플리케이션의 실행시 최초 진입점과 어플리케이션 설정의 역할을 합니다. 이 파일에서, 컴포넌트 초기화를 적용하고 어플리케이션의 동작(behavior) 을 정의할 수 있습니다.

이 파일은 세가지를 처리합니다:

- 컴포넌트 오토로더의 등록
- 서비스 설정 및 의존성 주입 컨텍스트와 함께 서비스 등록
- 어플리케이션의 HTTP 요청을 처리

### Autoloader

우리는 [PSR-4](https://www.php-fig.org/psr/psr-4/) 규칙을 따르는 [Phalcon\Loader](loader) 파일로더를 사용합니다. 일반적으로 오토로더에 추가해야 할 것들은 컨트롤러와 모델 입니다. 어플리케이션이 요청하는 파일을 스캔할 디렉토리들도 등록할 수 있습니다.

자 그럼, [Phalcon\Loader](loader)를 이용해서 `컨트롤러` 와 `모델` 디렉토리를 등록해 봅시다:

`public/index.php`

```php
<?php

use Phalcon\Loader;

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

### 의존성 관리

Phalcon은 느슨히 결합된 형태이기 때문에, 서비스를 프레임워크 의존성관리자에 등록해서 [IoC](https://en.wikipedia.org/wiki/Inversion_of_control) 컨테이너 내부에 있는 컴포넌트와 서비스에 자동으로 주입(inject) 시킬 수 있도록 합니다. 앞으로 DI (Dependency Injection - 의존성 주입) 라는 단어를 자주 접하게 될것입니다. 의존성 주입과 역제어(IoC: Inversion of Control) 는 뭔가 복잡하게 들릴 수 있겠지만, Phalcon에서 이들의 사용은 간단하고 실질적이며 효과적입니다. Phalcon의 IoC 컨테이너는 다음과 같은 컨셉으로 이루어져 있습니다:

- 서비스 컨테이너: 어플리케이션이 동작하기 위해 필요한 서비스를 전역참조로 저장하는 "가방"
- 서비스/컴포넌트: 컴포넌트에 주입될 데이터처리 객체

컴포넌트나 서비스가 필요할 때마다 프레임워크는 컨테이너에게 해당 서비스를 미리 약속해둔 이름으로 요청을 하게 됩니다. 이 방법으로 로거, 데이터베이스 연결 등 어플리케이션에 필요한 객체를 쉽게 가져올 수 있게 됩니다.

> **주의**: 자세한 내용이 궁금하시면 [Martin Fowler](https://martinfowler.com/articles/injection.html) 의 글을 참조해주세요. 그리고 많은 유스 케이스(use cases) 를 다루고 있는 [멋진 자습서](di)도 있습니다.
{: .alert .alert-warning }

### Factory Default

[Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) 는 [Phalcon\Di](api/Phalcon_Di)의 변종입니다. 이 클래스는 보다 쉬운 사용을 위해 어플리케이션에서 필요로 하는 대부분의 컴포넌트를 자동으로 등록하며, 표준으로 Phalcon과 함께 제공됩니다. 서비스 설정은 수동으로 하기를 권하지만, 처음에는 [Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) 를 사용하고 이후 필요에 따라 맞춤 설정하실 수도 있습니다.

서비스를 등록하는 방법은 여러가지가 있지만, 이 자습서에서는 [anonymous function](https://php.net/manual/en/functions.anonymous.php)을 이용하겠습니다:

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// Create a DI
$container = new FactoryDefault();
```

이제 프레임워크가 뷰 파일들을 찾을 디렉토리를 설정하여 *view* 서비스를 등록해야 합니다. 뷰와 클래스는 동일하지 않기 때문에, 오토로더가 자동으로 로드할 수 없기 때문입니다.

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');

        return $view;
    }
);
```

이제 Phalcon이 필요한 모든 URI 를 생성할 수 있는 기능을 제공해 줄 base URI를 등록할 차례입니다. 이 컴포넌트는 어플리케이션을 최상위 디렉토리에서 실행하던 하위 디렉토리에서 실행하던 상관없이 모든 URI가 정확하도록 보장해 줍니다. 이 자습서에서는 `/` 가 base 경로입니다. 자습서의 뒷부분에서 하이퍼링크를 생성하기 위해 `Phalcon\Tag` 를 사용하게 되면 이 base경로가 중요해질것입니다.

`public/index.php`

```php
<?php

use Phalcon\Url;

// ...

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');

        return $url;
    }
);
```

### 어플리케이션 요청 처리하기

요청을 처리하기 위해 필요한 모든 힘든 작업을 [Phalcon\Mvc\Application](application) 객체가 대신해 줍니다. 이 컴포넌트는 사용자로부터의 요청 수락, 경로(route) 감지, 컨트롤러에 전달하고, 결과를 반환하여 뷰를 렌더링합니다.

`public/index.php`

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

### 지금까지 내용을 다 합쳐보면

`tutorial/public/index.php` 파일은 다음과 같습니다:

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;

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

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

보시는 바와 같이, 이 부트스트랩파일은 아주 짧고 추가적인 파일을 include 할 필요가 없습니다. 이제 여러분은 30줄 미만의 코드로 유연한 MVC 어플리케이션을 잘 만들 수 있게 되었습니다.

## 컨트롤러 생성

Phalcon 은 기본적으로 `IndexController` 라는 컨트롤러를 찾습니다. 이곳은 요청에 컨트롤러나 액션이 없을 경우의 시작점이 됩니다 (예를들어 `https://localhost/`). `IndexController` 와 `IndexAction` 는 다음의 예제코드와 비슷해야 합니다:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return '<h1>Hello!</h1>';
    }
}
```

컨트롤러 클래스이름은 `Controller`로 끝나야 하며 컨트롤러 액션은 `Action`으로 끝나야 합니다. 더 자세한 내용은 [컨트롤러](controllers) 문서를 확인해 주세요. 브라우저에서 어플리케이션에 접근하시는 경우, 아래와 같은 화면이 보여야 합니다:

![](/assets/images/content/tutorial-basic-1.png)

> **축하합니다, 이제 Phalcon과 함께 Phlying 을 성공하셨습니다!**
{: .alert .alert-info }

## 뷰로 출력 보내기

컨트롤러에서 화면으로 직접 출력하는 것이 가끔 필요한 경우도 있지만 MVC커뮤니티에 있는 대부분의 순수주의자들이 증언하는 바와 같이, 썩 바람직하지는 앖습니다. 모든 결과는 화면에 데이터를 출력하는 책임을 가진, 뷰에 전달되어야 합니다. Phalcon은 가장 나중에 실행된 컨트롤러의 이름과 같은 디렉토리 내에 있는 가장 나중에 실행된 액션과 동일한 이름의 뷰를 찾습니다.

그러므로 우리의 경우 URL이 다음과 같다면:

```php
http://localhost/
```

`IndexController` 컨트롤러와 `indexAction` 액션을 실행하고, 다음과 같은 뷰를 찾게 됩니다:

```php
/views/index/index.phtml
```

찾는데 성공하면 해당파일을 파싱해서결과물을 화면으로 보냅니다. 뷰의 내용은 다음과 같습니다:

`app/views/index/index.phtml`

```php
<?php echo "<h1>Hello!</h1>";
```

컨트롤러 액션에 있던 `echo` 부분을 뷰로 이동시켰기 때문에, 현재 액션은 비어있겠지요:

`app/controllers/IndexController.php`

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

하지만 브라우저에 출력되는 결과물은 이전과 동일합니다. `Phalcon\Mvc\View` 컴포넌트는 액션의 실행이 종료되면 자동으로 생성됩니다.. Phalcon의 뷰에 관해 좀 더 자세한 내용을 보시려면 [여기](views)를 참조해 주세요.

## 회원가입 Form 설계하기

이제 *signup* 이라는 이름의 새로운 컨트롤러에 링크를 추가하기 위해, `index.phtml` 뷰 파일을 변경해 보겠습니다.. 사용자들이 어플리케이션에서 회원가입 할 수 있도록 만드는 것이 우리의 목표입니다.

`app/views/index/index.phtml`

```php
<?php

echo "<h1>Hello!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    'signup',
    'Sign Up Here!'
);
```

생성된 HTML코드는 새로운 컨트롤러에 링크시키는 앵커(`<a>`) HTML 태그를 표시합니다.

`app/views/index/index.phtml` (실제 렌더링결과)

```html
<h1>Hello!</h1>

<a href="/signup">Sign Up Here!</a>
```

`<a>` 태그로 링크를 만들기 위해, [Phalcon\Tag](tag) 컴포넌트를 사용합니다. 이것은 프레임워크에서 정한 규약에 맞춰 HTML태그를 쉽게 만드는 방법을 제공하는 유틸리티 클래스입니다. 이 클래스는 또한 의존성 주입기(Dependency Injector)에 등록된 서비스이기도 하므로, `$this->tag` 를 사용해서 기능에 접근할 수 있습니다.

> **주의**: 우리는 `Phalcon\Di\FactoryDefault` 컨테이너를 사용하므로 `Phalcon\Tag` 는 DI 컨테이너에 이미 등록되어 있습니다. 모든 서비스를 직접 수동으로 등록하신 경우라면, 이 컴포넌트를 컨테이너에 등록하셔야 어플리케이션에서 사용하실 수 있습니다.
{: .alert .alert-info }

[Phalcon\Tag](tag) 컴포넌트는 정확한 URI를 생성하기 위해 [Phalcon\Uri](uri) 컴포넌트도 또한 사용합니다. HTML 생성에 관한 자세한 내용은 [이 문서를 참조해 주세요](tag).

![](/assets/images/content/tutorial-basic-2.png)

다음으로 회원가입 컨트롤러는 (`app/controllers/SignupController.php`):

`app/controllers/SignupController.php`

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

Index 액션에 아무 내용이 없으면 파라미터 없이 바로 form이 정의되어있는 뷰를 호출합니다. (`app/views/signup/index.phtml`):

`app/views/signup/index.phtml`

```html
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

브라우저에서 이 form을 확인하면 아래와 같이 표시됩니다:

![](/assets/images/content/tutorial-basic-3.png)

위에서 언급한것 처럼, [Phalcon\Tag](tag) 유틸리티 클래스는 form HTML 요소를 쉽게 만들 수 있는 유용한 메서드들을 제공합니다. 예를 들어 `Phalcon\Tag::form()` 메서드는 어플리케이션의 컨트롤러/액션에 대한 상대적 URI 값 하나만 파라미터로 받습니다. `Phalcon\Tag::textField()` 는 넘겨받은 파라미터 값을 이름으로 하는 텍스트 HTML요소를 생성하고, `Phalcon\Tag::submitButton()` 은 submit HTML 버튼을 생성합니다.

*Register* 버튼을 클릭하면, `signup` 컨트롤러에 `register`액션이 없다는 메시지의 예외가 발생할 것입니다. `public/index.php` 파일은 다음과 같은 예외를 발생시킵니다:

```bash
Exception: Action "register" was not found on handler "signup"
```

메서드를 구현해주면 이 예외는 없어집니다:

`app/controllers/SignupController.php`

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

다시 *Register* 버튼을 클릭하면, 이젠 빈 페이지가 보일겁니다.

사용자가 입력한 이름과 이메일은 데이터베이스에 저장되어야 합니다. MVC 가이드라인에 따르면, 깔끔한 객체지향적 코드가 될 수 있도록 데이터베이스와의 상호작용은 모델을 통해서 이루어져야 합니다.

## 모델 생성

Phalcon은 100% C 언어로 만들어진 최초의 PHP용 ORM을 제공합니다. 개발의 복잡성을 증가시키지 않고, 오히려 단순화 시킵니다.

첫번째 모델을 만들기 전에 우선, 데이터베이스 관리 도구나 커맨드라인 유틸리티를 이용해서 데이터베이스 테이블을 만들어야 합니다. 이 자습서에서는 MYSQL 데이터베이스를 사용해서, 가입한 사용자정보를 저장할 간단한 테이블을 다음과 같이 생성합니다:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

모델은 `app/models` 디렉토리에 위치해야 합니다 (`app/models/Users.php`). 이 모델파일은 *users* 테이블 구조와 매칭됩니다:

`app/models/Users.php`

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

> **주의**: 모델의 public 속성들은 만들어진 테이블의 필드명과 동일하다는 부분을 주의해주세요. 
{: .alert .alert-info }

## 데이터베이스 연결 설정

데이터베이스 연결을 사용하고 이후 모델을 통해서 데이터에 접근하기 위해서는 부트스트랩 과정에서 이 부분을 정의해줘야 합니다. 데이터베이스 연결은 어플리케이션 전체에서 사용할 수 있는 많은 서비스 중에 하나입니다.

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);
```

데이터베이스 매개변수가 올바르다면 모델들은 어플리케이션의 다른 부분들과 상호작용할 준비가 끝난겁니다. 만약 사용중인 데이터베이스 정보나 인증정보가 다르다면, 위의 코드를 수정해서 사용해주세요.

## 모델을 이용해서 데이터 저장하기

`app/controllers/SignupController.php`

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

        //form에서 넘어온 값을 $user에 할당
        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        // 저장하고 오류 확인
        $success = $user->save();

        // 뷰에 결과를 전달
        $this->view->success = $success;

        if ($success) {
            $message = "등록되었습니다";
        } else {
            $message = "죄송합니다, 다음과 같은 오류가 발생했습니다:<br>"
                     . implode('<br>', $user->getMessages());
        }

        // message를 뷰로 전달
        $this->view->message = $message;
    }
}
```

`registerAction` 시작부분에 앞에서 만들었던 `Users` 클래스를 사용해서 비어있는 사용자 객체를 만듭니다. 우리는 이 클래스를 이용해서 사용자의 레코드를 관리하겠습니다. 위에서 말한 것처럼, 이 클래스의 퍼블릭 속성은 데이터베이스에 만들어진 `users` 테이블의 필드와 매칭됩니다. 새로운 레코드에 적절한 값을 집어 넣고 `save()` 를 호출하면 해당 레코드에 대한 데이터를 데이터베이스에 저장하게 됩니다. `save()` 메서드는 저장에 대한 성공여부를 나타내는 `boolean` 값을 반환합니다.

ORM은 SQL 인젝션을 방지하기 위해 자동으로 입력값을 이스케이프 시켜주기 때문에, 우리는 그냥 `save()` 메서드로 요청을 넘겨주기만 하면 됩니다.

Not null (필수) 로 정의된 필드들에 대해 추가 검증이 자동으로 행해집니다. 우리가 만든 회원가입 form에서 필수입력 필드 중 하나라도 입력하지 않으면 화면은 다음과 같이 표시됩니다:

![](/assets/images/content/tutorial-basic-4.png)

## 등록된 사용자 목록표시

이제 데이터베이스에 있는 모든 등록된 사용자들을 가져와서 표시 해보겠습니다

`IndexController`의 `indexAction` 내에서 할 첫 번째 작업은 전체 사용자 검색에 대한 결과를 표시하는 건데요, 이 부분은 우리가 앞서 만든 모델의 static 메서드 `find()` 를 호출함으로써 간단히 해결됩니다(`Users::find()`).

`indexAction` 메서드는 다음과 같이 변경됩니다:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * Welcome and user list
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
    }
}
```

> **주의**: `view` 객체의 magic 속성에 `find` 의 결과값을 할당합니다. 이렇게 하면 이 변수에 주어진 데이터 값이 설정되어 뷰에서 사용할 수 있게 되는 것입니다
{: .alert .alert-info } 

`views/index/index.phtml` 뷰 파일에서 `$users` 변수를 아래처럼 사용할 수 있습니다:

뷰는 다음과 비슷한 형태가 될것입니다:

`views/index/index.phtml`

```html
<?php

echo "<h1>Hello!</h1>";

echo $this->tag->linkTo(["signup", "Sign Up Here!", 'class' => 'btn btn-primary']);

if ($users->count() > 0) {
    ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3">Users quantity: <?php echo $users->count(); ?></td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->email; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
```

보신 바와 같이 `$users` 변수는 루핑을 돌 수 있고 카운트 할 수 있습니다. [models](db-models) 문서를 참고하시면 모델이 어떻게 동작하는 지에 대한 더 많은 정보를 확인하실 수 있습니다.

![](/assets/images/content/tutorial-basic-5.png)

## 스타일 입히기

이제 만들어진 어플리케이션에 디자인을 살짝 입혀봅시다. 코드에 [Bootstrap CSS](https://getbootstrap.com/) 를 추가해서 전체 뷰에서 사용될 수 있도록 합니다. `views` 폴더에 아래의 내용으로 `index.phtml` 파일을 추가합니다:

`app/views/index.phtml`

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phalcon Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

위의 템플릿에서, 가장 중요한 곳은 `getContent()` 메서드를 호출하는 부분입니다. 이 메서드는 뷰에서 생성된 모든 컨텐츠를 반환합니다. 자 이제 우리의 어플리케이션은 다음과 같이 표시됩니다:

![](/assets/images/content/tutorial-basic-6.png)

## 결론

보시는 바와 같이, Phalcon을 이용해서 어플리케이션을 만드는 것은 매우 쉽습니다. Phalcon은 메모리에 로드되는 익스텐션이기 때문에, 멋진 성능향상을 즐기면서도 프로젝트가 받는 영향은 최소화 됩니다.

더 공부하실 준비가 되셨다면 다음으로 [Vökuró 자습서](tutorial-vokuro)를 확인 해주세요.