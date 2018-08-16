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
              <a href="#full-example">全てを配置</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#controller">Controllerの作成</a>
        </li>
        <li>
          <a href="#view">Viewに出力を送る</a>
        </li>
        <li>
          <a href="#signup-form">サインアップフォームのデザイン</a>
        </li>
        <li>
          <a href="#model">Modelの作成</a>
        </li>
        <li>
          <a href="#database-connection">データベース接続の設定</a>
        </li>
        <li>
          <a href="#storing-data">Modelを使ったデータの保存</a>
        </li>
        <li>
          <a href="#conclusion">まとめ</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# チュートリアル - 基本

この最初のチュートリアルでは、簡単な登録フォームのアプリケーションの作成を、基礎から一歩づつ進めます。 また、フレームワークの動作の基本的な側面を説明します。 Phalconの自動コード生成ツールに興味がある場合は、[developer tools](/[[language]]/[[version]]/developer-tools)を確認してください。

このガイドを使用する最善の方法は、順番に各ステップを実行することです。完全なコードは[ここ](https://github.com/phalcon/tutorial)で取得できます。

<a name='file-structure'></a>

## ファイル構成

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

### オートローダー

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

### 依存関係の管理

Phalconを動作させる上で、必ず理解する必要のある非常に重要な概念は、`dependency injection container <di>` です。 これは一見複雑な仕組みに見えますが、実際には非常に単純で実用的な機能です。

サービスコンテナは、アプリケーションから使用する関数を実装したサービスを、グローバルに格納するための大きなバッグです。 フレームワークがコンポーネントを必要とするたびに、サービスに紐づけられた名前を使用してコンテナに問い合わせます。 Phalcon は非常に疎結合なフレームワークです。このため、`Phalcon\Di` は接着剤として機能し、透過的にさまざまなコンポーネントを統合し、協調して動作できるように機能します。

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// DIの生成
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

### 全てを配置

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

## Controllerの作成

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

## View に出力を送る

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

## サインアップフォームのデザイン

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

ブラウザでフォームを確認すると、次のように表示されます:

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag`は、フォーム要素を構築するための便利なメソッドも提供します。

:code:`Phalcon\Tag::form()`メソッドは、例えばアプリケーション内の controller/action に対する相対URIを唯一のパラメータとして受け取ります。

「送信」ボタンをクリックすると、フレームワークから例外がスローされ、"signup" コントローラーの "register" アクションが無いことがわかります。 `public/index.php`ファイルは以下の例外を投げます:

```bash
Exception: Action "register" was not found on handler "signup"
```

このメソッドを実装すると、例外が無くなります:

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

Phalconは、C言語で書かれた初めてのPHP用ORMを提供します。これは、開発の複雑さを増す事なく単純化します。

最初のモデルを作る前に、Phalconがマッピングできるようデータベースのテーブルを作る必要があります。登録ユーザーを格納するための単純なテーブルは、次のように定義できます:

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

モデルは、`app/models`ディレクトリに配置する必要があります (`app/models/Users.php`)。このモデルは "users" テーブルにマッピングされます。

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

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// データベースのサービスをセットアップ
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

適切なデータベースのパラメータを設定することでモデルは利用可能になり、アプリケーションの他の部分とやりとりできるようになります。

<a name='storing-data'></a>

## モデルを使ったデータの保存

次のステップでは、フォームからデータを受け取り、それらをテーブルに保存します。

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

まず、ユーザー情報に対応するUsersクラスをインスタンス化します。 このクラスのpublicプロパティはusersテーブルのレコードのフィールドにマッピングされます。 新しいレコードに関連する値を設定し`save()`を呼び出すと、そのレコードのデータがデータベースに保存されます。 `save()`メソッドは、データの格納が成功したかどうかを示すブール値を返します。

ORMは自動的に入力をエスケープしてSQLインジェクションを防ぐので、私たちはリクエストを`save()`メソッドに渡すだけ良いです。

not null (required) として定義されているフィールドに対しては、追加のバリデーションが自動的に実行されます。サインアップフォームに必要なフィールドを入力しないと、画面は次のようになります:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## まとめ

これはとてもシンプルなチュートリアルです。ご覧のとおり、Phalconを使用してアプリケーションを構築するのは簡単です。 PhalconがWebサーバーのextentionであるという事実は、開発の容易さや機能の使いやすさを妨げていません。 Phalconが提供する追加機能を発見できるように、このマニュアルを読み進めてください！