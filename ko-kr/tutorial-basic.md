---
layout: default
language: 'ko-kr'
version: '5.0'
title: '지침서 - 기초'
keywords: 'tutorial, basic tutorial, step by step, mvc, 지침서, 기초, 튜토리얼'
---

# 지침서 - 기초
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요
이 지침서 전체에 걸쳐 Phalcon 설계 상의 주요 측면에 대해 소개함과 동시에, 간단한 등록양식이 있는 어플리케이션을 만들어 보겠습니다.

이 지침서에서는 Phalcon 을 이용하면 얼마나 빠르고 쉽게 만들 수 있는지 보여주기 위해 간단한 MVC 어플리케이션의 구현을 다룹니다. 개발이 완료되면, 이 어플리케이션을 필요에 따라 확장시켜 사용하실 수있습니다. 이 지침서에 있는 코드는 다른 Phalcon 특유의 컨셉트와 아이디어를 배우는 놀이터로도 사용될 수 있습니다.

<iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>

바로 시작하기를 원하신다면 이 섹션은 건너뛰고 [developer tools](devtools)를 이용해서 자동으로 Phalcon 프로젝트를 생성하세요.

이 가이드를 사용하는 최고의 방법은 찬찬히 따라 오시면서 즐기려고 노력하시는 겁니다. You can get the complete code [here][github_tutorial]. If you get stuck or have questions, please visit us on [Discord][discord] or in our [Discussions][discussions].

## 파일 구조
Phalcon의 핵심기능 중 하나는 느슨하게 연결(loosely coupled) 되어 있다는 부분입니다. 그런 이유로, 어떤 형태든 본인이 편한대로 디렉토리 구조를 만드실 수 있습니다. In this tutorial we will use a _standard_ directory structure, commonly used in MVC applications.

```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

> **NOTE**: Since all the code that Phalcon exposes is encapsulated in the extension (that you have loaded on your web server), you will not see `vendor` directory containing Phalcon code. 필요한 모든 것이 메모리에 로드되어 있습니다. 아직 어플리케이션 설치 전이시라면, 이 자습서를 더 진행하시기 전에 [설치](installation) 페이지로 가셔서 설치과정을 완료해주시기 바랍니다 
> 
> {: .alert .alert-warning }

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
We are going to use [Phalcon\Autoload\Loader](autoload) a [PSR-4][psr-4] compliant file loader. 일반적으로 오토로더에 추가해야 할 것들은 컨트롤러와 모델 입니다. 어플리케이션이 요청하는 파일을 스캔할 디렉토리들도 등록할 수 있습니다.

To start, lets register our app's `controllers` and `models` directories using [Phalcon\Autoload\Loader](autoload):

`public/index.php`
```php
<?php

use Phalcon\Autoload\Loader;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...

$loader = new Loader();
$loader->setDirectories(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);


$loader->register();
```

### 의존성 관리
Since Phalcon is loosely coupled, services are registered with the frameworks Dependency Manager, so they can be injected automatically to components and services wrapped in the [IoC][ioc] container. 앞으로 DI (Dependency Injection - 의존성 주입) 라는 단어를 자주 접하게 될것입니다. 의존성 주입과 역제어(IoC: Inversion of Control) 는 뭔가 복잡하게 들릴 수 있겠지만, Phalcon에서 이들의 사용은 간단하고 실질적이며 효과적입니다. Phalcon의 IoC 컨테이너는 다음과 같은 컨셉으로 이루어져 있습니다:
- 서비스 컨테이너: 어플리케이션이 동작하기 위해 필요한 서비스를 전역참조로 저장하는 "가방"
- 서비스/컴포넌트: 컴포넌트에 주입될 데이터처리 객체

컴포넌트나 서비스가 필요할 때마다 프레임워크는 컨테이너에게 해당 서비스를 미리 약속해둔 이름으로 요청을 하게 됩니다. 이 방법으로 로거, 데이터베이스 연결 등 어플리케이션에 필요한 객체를 쉽게 가져올 수 있게 됩니다.

> **NOTE**: If you are still interested in the details please see this article by [Martin Fowler][injection]. Also, we have [a great tutorial](di) covering many use cases. 
> 
> {: .alert .alert-warning }

### Factory Default
The [Phalcon\Di\FactoryDefault][di-factorydefault] is a variant of [Phalcon\Di\Di][di]. 이 클래스는 보다 쉬운 사용을 위해 어플리케이션에서 필요로 하는 대부분의 컴포넌트를 자동으로 등록하며, 표준으로 Phalcon과 함께 제공됩니다. Although it is recommended to set up services manually, you can use the [Phalcon\Di\FactoryDefault][di-factorydefault] container initially and later on customize it to fit your needs.

Services can be registered in several ways, but for our tutorial, we will use an [anonymous function][anonymous_function]:

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

$container = new FactoryDefault();
```

Now we need to register the _view_ service, setting the directory where the framework will find the view files. 뷰와 클래스는 동일하지 않기 때문에, 오토로더가 자동으로 로드할 수 없기 때문입니다.

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

use Phalcon\Mvc\Url;

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
요청을 처리하기 위해 필요한 모든 힘든 작업을 [Phalcon\Mvc\Application](application) 객체가 대신해 줍니다. The component will accept the request by the user, detect the routes and dispatch the controller and render the view returning the results.

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
use Phalcon\Loader\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

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

> **NOTE** In the tutorial files from our [GitHub][github_tutorial] repository, to register services in the `DI` container, we use the array notation i.e. `$container['url'] = ....`. 
> 
> {: .alert .alert-info }

As you can see, the bootstrap file is very short, and we do not need to include any additional files. 이제 여러분은 30줄 미만의 코드로 유연한 MVC 어플리케이션을 잘 만들 수 있게 되었습니다.

## 컨트롤러 생성
By default, Phalcon will look for a controller named `IndexController`. It is the starting point when no controller or action has been added in the request (e.g. `https://localhost/`). `IndexController` 와 `IndexAction` 는 다음의 예제코드와 비슷해야 합니다:

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

> **Congratulations, you are Phlying with Phalcon!** 
> 
> {: .alert .alert-info }

## 뷰로 출력 보내기
컨트롤러에서 화면으로 직접 출력하는 것이 가끔 필요한 경우도 있지만 MVC커뮤니티에 있는 대부분의 순수주의자들이 증언하는 바와 같이, 썩 바람직하지는 앖습니다. 모든 결과는 화면에 데이터를 출력하는 책임을 가진, 뷰에 전달되어야 합니다. Phalcon은 가장 나중에 실행된 컨트롤러의 이름과 같은 디렉토리 내에 있는 가장 나중에 실행된 액션과 동일한 이름의 뷰를 찾습니다.

Therefore, in our case if the URL is:

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
Now we will change the `index.phtml` view file, to add a link to a new controller named _signup_. 사용자들이 어플리케이션에서 회원가입 할 수 있도록 만드는 것이 우리의 목표입니다.

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

To generate the link for the `<a>` tag, we use the [Phalcon\Html\TagFactory](html-tagfactory) component. 이것은 프레임워크에서 정한 규약에 맞춰 HTML태그를 쉽게 만드는 방법을 제공하는 유틸리티 클래스입니다. This class is also a service registered in the Dependency Injector, so we can use `$this->tag` to access its functionality.

> **NOTE**: `Phalcon\Html\TagFactory` is already registered in the DI container since we have used the `Phalcon\Di\FactoryDefault` container. 모든 서비스를 직접 수동으로 등록하신 경우라면, 이 컴포넌트를 컨테이너에 등록하셔야 어플리케이션에서 사용하실 수 있습니다. 
> 
> {: .alert .alert-info }

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

As mentioned above, the [Phalcon\Html\TagFactory](html-tagfactory) utility class, exposes useful methods allowing you to build form HTML elements with ease. The `form()` method receives an array of key/value pairs that set up the form, for example a relative URI to a controller/action in the application. The `inputText()` creates a text HTML element with the name as the passed parameter, while the `inputSubmit()` creates a submit HTML button. Finally, a call to `close()` will close our `<form>` tag.

By clicking the _Register_ button, you will notice an exception thrown from the framework, indicating that we are missing the `register` action in the controller `signup`. `public/index.php` 파일은 다음과 같은 예외를 발생시킵니다:

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

If you click the _Register_ button again, you will see a blank page. We will be adding a view a little later that provides useful feedback. But first, we should work on the code to store the user's inputs in a database.

According to MVC guidelines, database interactions must be done through models to ensure clean, object-oriented code.

## 모델 생성
Phalcon은 100% C 언어로 만들어진 최초의 PHP용 ORM을 제공합니다. 개발의 복잡성을 증가시키지 않고, 오히려 단순화 시킵니다.

첫번째 모델을 만들기 전에 우선, 데이터베이스 관리 도구나 커맨드라인 유틸리티를 이용해서 데이터베이스 테이블을 만들어야 합니다. 이 자습서에서는 MYSQL 데이터베이스를 사용해서, 가입한 사용자정보를 저장할 간단한 테이블을 다음과 같이 생성합니다:

`create_users_table.sql`
```sql
CREATE TABLE `users`
(
    `id`    int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Record ID',
    `name`  varchar(255) NOT NULL COMMENT 'User Name',
    `email` varchar(255) NOT NULL COMMENT 'User Email Address',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

모델은 `app/models` 디렉토리에 위치해야 합니다 (`app/models/Users.php`). The model maps to the _users_ table:

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

> **NOTE**: Note that the public properties of the model correspond to the names of the fields in our table. 
> 
> {: .alert .alert-info }

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

Adjust the code snippet above as appropriate for your database.

With the correct database parameters, our model is ready to interact with the rest of the application, so we can save the user's input. First, let's take a moment and create a view for `SignupController::registerAction()` that will display a message letting the user know the outcome of the _save_ operation.

`app/views/signup/register.phtml`
```php
<div class="alert alert-<?php echo $success === true ? 'success' : 'danger'; ?>">
    <?php echo $message; ?>
</div>

<?php echo $this->tag->linkTo(['/', 'Go back', 'class' => 'btn btn-primary']); ?>
```
Note that we have added some css styling in the code above. We will cover including the stylesheet in the [Styling](#styling) section below.

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
        $post = $this->request->getPost();

        // Store and check for errors
        $user        = new Users();
        $user->name  = $post['name'];
        $user->email = $post['email'];
        // Store and check for errors
        $success = $user->save();

        // passing the result to the view
        $this->view->success = $success;

        if ($success) {
            $message = "Thanks for registering!";
        } else {
            $message = "Sorry, the following problems were generated:<br>"
                . implode('<br>', $user->getMessages());
        }

        // passing a message to the view
        $this->view->message = $message;
    }
}
```

At the beginning of the `registerAction` we create an empty user object using the `Users` class we created earlier. We will use this class to manage the record of a user. As mentioned above, the class's public properties map to the fields of the `users` table in our database. Setting the relevant values in the new record and calling `save()` will store the data in the database for that record. The `save()` method returns a `boolean` value which indicates whether the save was successful or not.

The ORM will automatically escape the input preventing SQL injections, so we only need to pass the request to the `save()` method.

Additional validation happens automatically on fields that are defined as not null (required). If we do not enter any of the required fields in the sign-up form our screen will look like this:

![](/assets/images/content/tutorial-basic-4.png)

## 등록된 사용자 목록표시
Now we will need to get and display all the registered users in our database

The first thing that we are going to do in our `indexAction` of the`IndexController` is to show the result of the search of all the users, which is done simply by calling the static method `find()` on our model (`Users::find()`).

`indexAction` would change as follows:

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

> **NOTE**: We assign the results of the `find` to a magic property on the `view` object. This sets this variable with the assigned data and makes it available in our view 
> 
> {: .alert .alert-info }

In our view file `views/index/index.phtml` we can use the `$users` variable as follows:

The view will look like this:

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

As you can see our variable `$users` can be iterated and counted. You can get more information on how models operate in our document about [models](db-models).

![](/assets/images/content/tutorial-basic-5.png)

## Styling
We can now add small design touches to our application. We can add the [Bootstrap CSS][bootstrap] in our code so that it is used throughout our views. We will add an `index.phtml` file in the`views` folder, with the following content:

`app/views/index.phtml`
```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phalcon Tutorial</title>
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

In the above template, the most important line is the call to the `getContent()` method. This method returns all the content that has been generated from our view. Our application will now show:

![](/assets/images/content/tutorial-basic-6.png)

## 결론
As you can see, it is easy to start building an application using Phalcon. Because Phalcon is an extension loaded in memory, the footprint of your project will be minimal, while at the same time you will enjoy a nice performance boost.

If you are ready to learn more check out the [Vökuró Tutorial](tutorial-vokuro) next.

[anonymous_function]: https://php.net/manual/en/functions.anonymous.php
[discord]: https://phalcon.io/discord
[discussions]: https://phalcon.io/discussions
[github_tutorial]: https://github.com/phalcon/tutorial
[github_tutorial]: https://github.com/phalcon/tutorial
[injection]: https://martinfowler.com/articles/injection.html
[ioc]: https://en.wikipedia.org/wiki/Inversion_of_control
[psr-4]: https://www.php-fig.org/psr/psr-4/
[di]: api/phalcon_di
[di-factorydefault]: api/phalcon_di#di-factorydefault
[bootstrap]: https://getbootstrap.com/
