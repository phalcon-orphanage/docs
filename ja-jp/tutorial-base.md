* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='basic'></a>

# チュートリアル - 基本

この最初のチュートリアルでは、簡単な登録フォームのアプリケーションの作成を、基礎から一歩ずつ進めます。 次のガイドでは、Phalconフレームワークの設計面をご紹介します。

このチュートリアルでは、単純なMVCアプリケーションの実装について説明し、Phalconを使用してどのように迅速かつ簡単に実行できるかを示します。 このチュートリアルでは、多くのニーズに対応できるように、拡張可能なアプリケーションを作成するのに役立ちます。 このチュートリアルのコードは、他のPhalcon固有の概念やアイデアを学ぶための遊び場としても使用できます。

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

If you just want to get started you can skip this and create a Phalcon project automatically with our [developer tools](/3.4/en/devtools-usage). (あなたが立ち往生した場合、ここに戻って来ると良いでしょう)

このガイドを使用する最善の方法は、一緒に楽しく進めることです。 完全なコードは[ここ](https://github.com/phalcon/tutorial)で取得できます。 どうすることもできない場合は、[Discord](https://phalcon.link/discord)または[Forum](https://phalcon.link/forum)にアクセスしてください。

<a name='file-structure'></a>

## ファイル構成

Phalcon の主な特徴である 疎結合 により、開発したいアプリケーションに応じて最適なディレクトリ構成を持つ Phalcon プロジェクトを構築することができます。 他の人と共同作業するときに、ある種の統一性が役立ちます。このチュートリアルでは、過去に他のMVCを使っていた場合に親近感を覚えるはずの "Standard" な構造を使用します。   


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

<div class='alert alert-warning'>
    <p>
        注：Phalconのコア依存関係のすべてが、Phalcon extensionとしてメモリにロードされているため、 `vendor`ディレクトリは表示していません。 If you missed that part have not installed the Phalcon extension [please go back](/3.4/en/installation) and finish the installation before continuing.
    </p>
</div>

If this is all brand new it is recommended that you install the [Phalcon Devtools](/3.4/en/devtools-installation) since it leverages PHP's built-in server you to get your app running without having to configure a web server by adding this [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) to the root of your project.

Otherwise if you want to use Nginx here are some additional setup [here](/3.4/en/webserver-setup#nginx).

Apache can also be used with these additional setup [here](/3.4/en/webserver-setup#apache).

Finally, if you flavor is Cherokee use the setup [here](/3.4/en/webserver-setup#cherokee).

<a name='bootstrap'></a>

## Bootstrap

はじめに作成する必要があるファイルは bootstrap ファイルです。 このファイルは、アプリケーションのエントリポイント、そして設定ファイルとして機能します。 このファイルでは、アプリケーションの動作と同様に、コンポーネントの初期化を実装できます。

このファイルは3つのことを処理します:

- オートローダーコンポーネントの登録
- サービスの設定とDependency Injectionへの登録
- アプリケーションのHTTPリクエストの処理

<a name='autoloaders'></a>

### オートローダー

オートローダーはPhalconの実行中に[PSR-4](http://www.php-fig.org/psr/psr-4/)準拠のファイルローダーを提供します。 通常、オートローダーに追加する必要があるのはControllerとModelです。 アプリケーションの名前空間内で、ファイルを検索するディレクトリを登録できます。 If you want to read about other ways that you can use autoloaders head [here](/3.4/en/loader#overview).

To start, lets register our app's `controllers` and `models` directories. Don't forget to include the loader from `Phalcon\Loader`.

`public/index.php`

```php
<?php

use Phalcon\Loader;

// リソースの特定に役立つ絶対パス定数を定義する
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

### 依存関係の管理

Phalconは疎結合で実装されており、サービスはDependency Managerに登録されているため、[IoC](https://en.wikipedia.org/wiki/Inversion_of_control)コンテナにラップされたコンポーネントやサービスに自動的に挿入できます。 Dependency Injectionの略語であるDIが出てくることがよくあります。 Dependency InjectionとInversion of Control(IoC) は複雑な機能のような聞こえるかもしれませんが、ファルコンでの使用は非常にシンプルで実用的です。 PhalconのIoCコンテナは、以下の概念で構成されています。

- サービスコンテナ: アプリケーションから使用する関数を実装したサービスをグローバルに格納するための大きなバッグ。
- サービスまたはコンポーネント: コンポーネントに注入されるデータ処理オブジェクト

フレームワークがコンポーネントやサービスを必要とするたびに、サービスに紐づけられた名前を使用してコンテナに問い合わせます。 `Phalcon\Di`をサービスコンテナの設定に含めることを忘れないでください。

<div class='alert alert-warning'>
    <p>
        あなたがまだ詳細に興味があるなら、[Martin Fowler](https://martinfowler.com/articles/injection.html) のこの記事をご覧ください。 Also we have [a great tutorial](/3.4/en/di) covering many use cases.
    </p>
</div>

### Factory Default

The [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) is a variant of [Phalcon\Di](api/Phalcon_Di). 実装を簡単にするために、Phalconに付属するほとんどのコンポーネントは自動的に登録されます。 Dependency Managementに慣れやすくする為にも、サービスを手動で登録することをお勧めします。 後で、このコンセプトに慣れたらいつでも指定できます。

サービスはいくつかの方法で登録することができますが、このチュートリアルでは[無名関数](http://php.net/manual/en/functions.anonymous.php)を使用します。

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// DIの生成
$di = new FactoryDefault();
```

次のパートでは、フレームワークがビューファイルを見つけるディレクトリを指し示した "view" サービスを登録します。 ビューはクラスに対応していないため、オートローダを利用することができません。

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

// viewコンポーネントを設定します
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);
```

次に、Phalconによって生成されたすべてのURIがアプリケーションのベースパス "/"と一致するようにベースURIを登録します。 `Phalcon\Tag` クラスを使用してハイパーリンクを生成する場合、この設定はチュートリアルの後半で重要になります。

`public/index.php`

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// ベースURIの設定
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

### アプリケーションのリクエストを処理する

In the last part of this file, we find [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application). その目的は、リクエスト環境変数を初期化し、受け取ったリクエストをルーティング、検出されたアクションにディスパッチすることです。レスポンスを集約し、処理が完了したときにそれを返却します。

`public/index.php`

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);
$response = $application->handle();
$response->send();
```

<a name='full-example'></a>

### 全てを配置

`tutorial/public/index.php` ファイルは、次のようになります。

`public/index.php`

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;

// リソースの特定に役立つ絶対パス定数を定義する
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// オートローダーの登録
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

// DIの生成
$di = new FactoryDefault();

// ビューコンポーネントの設定
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

// ベースURIの設定
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
    // リクエストのハンドリング
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

ご覧のように、ブートストラップファイルは非常に短く、追加のファイルを含める必要はありません。 おめでとうございます、30行以下のコードで柔軟なMVCアプリケーションを作成できました。

<a name='controller'></a>

## Controllerの作成

デフォルトでは、Phalconは`IndexController`という名前のコントローラを探します。 これは、リクエストでコントローラまたはアクションが渡されていないときの開始点です。 (例えば `http://localhost:8000/`). `IndexController`と`IndexAction`は、次の例のようになります:

`app/controllers/IndexController.php`

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

コントローラクラスには後ろに`Controller`が必要であり、コントローラのアクションには後ろに`Action`をつける必要があります。 ブラウザからアプリケーションにアクセスすると、次のように表示されます。

![](/assets/images/content/tutorial-basic-1.png)

おめでとう、あなたはPhalconで飛び立つことができました！

<a name='view'></a>

## View に出力を送る

コントローラーから画面に出力を送信することは時に必要ですが、MVCコミュニティの多くの純粋主義者が証明する様に、望ましくはありません。 すべてを画面上の出力データとしてビューに渡す必要があります。 Phalconは、最後に実行されたコントローラーと同じ名前のディレクトリー配下にある、最後に実行されたアクションと同じ名前のビューを探します。 今回の場合は (`app/views/index/index.phtml`) です。

`app/views/index/index.phtml`

```php
<?php echo "<h1>Hello!</h1>";
```

私たちのコントローラー (`app/controllers/IndexController.php`) は空のアクションが定義されています:

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

ブラウザの出力は変わらないはずです。 静的コンポーネントの `Phalcon\Mvc\View` は、アクションの実行が終了すると自動的に作成されます。 Learn more about views usage [here](/3.4/en/views).

<a name='signup-form'></a>

## サインアップフォームのデザイン

Now we will change the `index.phtml` view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

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

生成されたHTMLコードでは、新しいコントローラにリンクするアンカータグ (`<a>`) を表示します:

`app/views/index/index.phtml` (レンダリング後)

```html
<h1>Hello!</h1>

<a href="/signup">Sign Up Here!</a>
```

タグを生成するには`Phalcon\Tag`クラスを使用します。 これは、フレームワークの規約に従ったHTMLタグを生成することを可能にするユーティリティクラスです。 このクラスはDIに登録されたサービスでもあるため、`$this->tag`を使用してアクセスします。

A more detailed article regarding HTML generation [can be found here](/3.4/en/tag).

![](/images/content/tutorial-basic-2.png)

Signupコントローラは次のとおりです (`app/controllers/SignupController.php`):

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

空のindexアクションは、フォーム定義を持つビューに対して何も渡しません (`app/views/signup/index.phtml`):

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

ブラウザでフォームを確認すると、次のように表示されます:

![](/assets/images/content/tutorial-basic-3.png)

[Phalcon\Tag](api/Phalcon_Tag) also provides useful methods to build form elements.

`Phalcon\Tag::form()`メソッドは、例えばアプリケーション内の controller/action に対する相対URIを唯一のパラメータとして受け取ります。

「送信」ボタンをクリックすると、フレームワークから例外がスローされ、`signup`コントローラーの`register`アクションが無いことがわかります。 `public/index.php`ファイルは以下の例外を投げます:

```bash
Exception: Action "register" was not found on handler "signup"
```

このメソッドを実装すると、例外が無くなります:

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

もう一度 "Send" ボタンをクリックすると、空白のページが表示されます。 ユーザーが入力したnameとemailはデータベースに保存する必要があります。 MVCのガイドラインによれば、オブジェクト指向のきれいなコードを確保するために、データベースのやりとりをモデルを通じて行う必要があります。

<a name='model'></a>

## Modelの作成

Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Before creating our first model, we need to create a database table outside of Phalcon to map it to. A simple table to store registered users can be created like this:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

A model should be located in the `app/models` directory (`app/models/Users.php`). The model maps to the "users" table:

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

<a name='database-connection'></a>

## データベース接続の設定

モデルからデータベース接続を使用してデータにアクセスできるようにするには、ブートストラップの処理中にデータベースの接続を設定する必要があります。 データベース接続は、アプリケーションの他のコンポーネントから利用できるサービスです:

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// データベースの設定
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

適切なデータベースのパラメータを設定することでモデルは利用可能になり、アプリケーションの他の部分とやりとりできるようになります。

<a name='storing-data'></a>

## モデルを使ったデータの保存

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

        // 保存とエラーのチェック
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

`registerAction`の最初にユーザーのレコードを管理するUsersクラスから空のユーザーオブジェクトを作成しています。 クラスのパブリックプロパティは、データベースの`users`テーブルのフィールドにマッピングされます。 新しいレコードに関連する値を設定し`save()`を呼び出すと、そのレコードのデータがデータベースに保存されます。 `save()`メソッドは、データの格納が成功したかどうかを示すブール値を返します。

ORMは自動的に入力をエスケープしてSQLインジェクションを防ぐので、私たちはリクエストを`save()`メソッドに渡すだけ良いです。

Additional validation happens automatically on fields that are defined as not null (required). If we don't enter any of the required fields in the sign-up form our screen will look like this:

![](/assets/images/content/tutorial-basic-4.png)

<a name='list-of-users'></a>

## List of users

Now let's see how to obtain and see the users that we have registered in the database.

The first thing that we are going to do in our `indexAction` of the`IndexController` is to show the result of the search of all the users, which is done simply in the following way `Users::find()`. Let's see how our `indexAction` would look

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

Now, in our view file `views/index/index.phtml` we will have access to the users found in the database. These will be available in the variable `$users`. This variable has the same name as the one we use in `$this->view->users`.

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

As you can see our variables `$users` can be iterated and counted, this we will see in depth later on when viewing the [models](/3.4/en/db-models).

![](/images/content/tutorial-basic-5.png)

<a name='adding-style'></a>

## Adding Style

To give a design touch to our first application we will add bootstrap and a small template that will be used in all views.

We will add an `index.phtml` file in the`views` folder, with the following content:

`app/views/index.phtml`

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phalcon Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

The most important thing to highlight in our template is the function `getContent()` which will give us the content generated by the view. Now, our application will be something like this:

![](/images/content/tutorial-basic-6.png)

<a name='conclusion'></a>

## まとめ

ご覧のとおり、Phalconを使用してアプリケーションを構築するのは簡単です。 Phalconがextensionから実行されているという事実は、プロジェクトのフットプリントを大幅に減らし、パフォーマンスを大幅に向上させます。

If you are ready to learn more check out the [Rest Tutorial](/3.4/en/tutorial-rest) next.