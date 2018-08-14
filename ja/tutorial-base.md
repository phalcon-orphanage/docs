<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">チュートリアル - 基本</a> <ul>
        <li>
          <a href="#file-structure">ファイル構造</a>
        </li>
        <li>
          <a href="#bootstrap">Bootstrap</a> <ul>
            <li>
              <a href="#autoloaders">オートローダ</a>
            </li>
            <li>
              <a href="#dependency-management">依存関係の管理</a>
            </li>
            <li>
              <a href="#request">アプリケーションのリクエストを処理する</a>
            </li>
            <li>
              <a href="#full-example">Putting everything together</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#controller">Creating a Controller</a>
        </li>
        <li>
          <a href="#view">Sending output to a view</a>
        </li>
        <li>
          <a href="#signup-form">Designing a sign up form</a>
        </li>
        <li>
          <a href="#model">Creating a Model</a>
        </li>
        <li>
          <a href="#database-connection">Setting a Database Connection</a>
        </li>
        <li>
          <a href="#storing-data">Storing data using models</a>
        </li>
        <li>
          <a href="#conclusion">Conclusion</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# Tutorial - basic

この最初のチュートリアルでは、簡単な登録フォームのアプリケーションの作成を、基礎から一歩づつ進めます。 また、フレームワークの動作の基本的な側面を説明します。 Phalconの自動コード生成ツールに興味がある場合は、[developer tools](/[[language]]/[[version]]/developer-tools)を確認してください。

このガイドを使用する最善の方法は、順番に各ステップを実行することです。完全なコードは[ここ](https://github.com/phalcon/tutorial)で取得できます。

<a name='file-structure'></a>

## File structure

Phalconはアプリケーション開発において特定のファイル構造を強制しません。 Phalconは疎結合になっているため、あなたのやりやすいファイル構造でアプリケーションを実装することができます。

このチュートリアルの目的と出発点として、次のようなシンプルな構造を提案します。

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

Phalconに関連した “library” ディレクトリが必要ないことに注意してください。フレームワークはメモリ上で有効になっており、すでに使う準備ができています。

このチュートリアルを続ける前に、[Phalcon のインストール](/[[language]]/[[version]]/installation)を完了させ、[Nginx](/[[language]]/[[version]]/setup#nginx)、[Apache](/[[language]]/[[version]]/setup#apache)または[Cherokee](/[[language]]/[[version]]/setup#cherokee)の設定を完了させてください。

<a name='bootstrap'></a>

## Bootstrap

はじめに作成する必要があるファイルは bootstrap ファイルです。 このファイルは非常に重要です。これはアプリケーションの全てをコントロールする基盤として機能します。 このファイルでは、アプリケーションの動作と同様に、コンポーネントの初期化を実装できます。

結局のところ、下記の３つを行う事になります:

- オートローダの設定
- 依存関係の注入 (Dependency Injector) の設定を行う。
- アプリケーションのリクエストを処理する。

<a name='autoloaders'></a>

### Autoloaders

ブートストラップで最初に見つける部分は、オートローダを登録していることです。 これはコントローラやモデルなどのクラスをロードするために使われます。 例えば、コントローラのディレクトリを一つ以上登録して、アプリケーションの柔軟性を高めることができます。 次の例では、`Phalcon\Loader` コンポーネントを使用しています。

様々な方法を使用してクラスを読み込むことができますが、この例ではあらかじめ定義されたディレクトリに基づいてクラスを配置する方法を選択しました。

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

### Dependency Management

Phalconを動作させる上で、必ず理解する必要のある非常に重要な概念は、`dependency injection container <di>` です。 これは一見複雑な仕組みに見えますが、実際には非常に単純で実用的な機能です。

サービスコンテナは、アプリケーションから使用する関数を実装したサービスを、グローバルに格納するための大きなバッグです。 フレームワークがコンポーネントを必要とするたびに、サービスに紐づけられた名前を使用してコンテナに問い合わせます。 Phalcon は非常に疎結合なフレームワークです。このため、`Phalcon\Di` は接着剤として機能し、透過的にさまざまなコンポーネントを統合し、協調して動作できるように機能します。

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

`Phalcon\Di\FactoryDefault` は `Phalcon\Di` の一種です。 実装を簡単にするため、Phalcon に付属するほとんどのコンポーネントを登録しています。 このため、それらをひとつひとつ登録する必要はありません。 後からファクトリサービスを置き換えることは問題ないです。

次のパートでは、フレームワークがビューファイルを見つけるディレクトリを指し示した "view" サービスを登録します。 ビューはクラスに対応していないため、オートローダを利用することができません。

サービスはいくつかの方法で登録することができますが、このチュートリアルでは[無名関数](http://php.net/manual/en/functions.anonymous.php)を使用します。

```php
<?php

use Phalcon\Mvc\View;

// ...

// ビューコンポーネントを設定します
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);
```

次に、Phalcon によって生成された全ての URI が、以前設定した "tutorial" フォルダを含めるように、ベース URI を登録します。 `Phalcon\Tag` クラスを使用してハイパーリンクを生成する場合、この設定はチュートリアルの後半で重要になります。

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// 生成されるすべての URI が「tutorial」フォルダを含めるように、ベース URI を設定します
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

### アプリケーションのリクエストを処理する

このファイルの最後の部分には、`Phalcon\Mvc\Application` があります。 その目的は、リクエスト環境変数を初期化し、受け取ったリクエストをルーティング、検出されたアクションにディスパッチすることです。レスポンスを集約し、処理が完了したときにそれを返却します。

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

`tutorial/public/index.php` ファイルは、次のようになります。

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// オートローダを登録
$loader = new Loader();

$loader->registerDirs(
    [
        '../app/controllers/',
        '../app/models/',
    ]
);

$loader->register();

// DI を生成
$di = new FactoryDefault();

// ビューコンポーネントを設定
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);

// 生成されるすべての URI が「tutorial」フォルダを含めるようにベース URI を設定
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
    // リクエストを処理
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

見ての通り、ブートストラップファイルは非常に短く、追加のファイルを含める必要はありません。 私たちは、30行未満のコードで柔軟な MVC アプリケーションを用意しました。

<a name='controller'></a>

## Creating a Controller

デフォルトで Phalcon は "Index" という名前のコントローラを探します。 これは、リクエストでコントローラまたはアクションが渡されていないときの開始点です。 indexコントローラ (`app/controllers/IndexController.php`) はこのようになります。

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

コントローラクラスの名前は必ず "Controller" で終わる必要があり、コントローラのアクションの名前は必ず "Action" で終わる必要があります。ブラウザからアプリケーションにアクセスすると、次のように表示されます。

![](/images/content/tutorial-basic-1.png)

おめでとう、あなたはPhalconで飛び立つことができました！

<a name='view'></a>

## Sending output to a view

コントローラーから画面に出力を送信することは時に必要ですが、MVCコミュニティの多くの純粋主義者が証明する様に、望ましくはありません。 すべてを画面上の出力データとしてビューに渡す必要があります。 Phalconは、最後に実行されたコントローラーと同じ名前のディレクトリー配下にある、最後に実行されたアクションと同じ名前のビューを探します。 今回の場合は (`app/views/index/index.phtml`) です。

```php
<?php echo "<h1>Hello!</h1>";
```

私たちのコントローラー (`app/controllers/IndexController.php`) は空のアクションが定義されています:

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

ブラウザの出力は変わらないはずです。 静的コンポーネントの `Phalcon\Mvc\View` は、アクションの実行が終了すると自動的に作成されます。 詳しくは `ビューの使い方<views>` を参照してください。

<a name='signup-form'></a>

## Designing a sign up form

今度は`index.phtml`ビューファイルを変更して、 "signup"という名前の新しいコントローラへのリンクを追加します。 目標は、ユーザーがアプリケーション内でサインアップできるようにすることです。

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

生成されたHTMLコードは、新しいコントローラにリンクするアンカー ("a") HTMLタグを表示します:

```html
<h1>Hello!</h1>

<a href="/tutorial/signup">Sign Up Here!</a>
```

タグを生成するには`Phalcon\Tag`クラスを使用します。 これは、フレームワークの規約に従ったHTMLタグを生成することを可能にするユーティリティクラスです。 このクラスはDIに登録されたサービスでもあるため、`$this->tag`を使用してアクセスします。

HTML生成に関するより詳細な記事は、次のとおりです。 :doc: `ここで見つかります<tags>`

![](/images/content/tutorial-basic-2.png)

Signupコントローラは次のとおりです (`app/controllers/SignupController.php`):

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

Viewing the form in your browser will show something like this:

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag` also provides useful methods to build form elements.

The :code:`Phalcon\Tag::form()` method receives only one parameter for instance, a relative URI to a controller/action in the application.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our `public/index.php` file throws this exception:

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