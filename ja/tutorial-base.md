<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">チュートリアル - 基本</a> 
      <ul>
        <li>
          <a href="#file-structure">ファイル構造</a>
        </li>
        <li>
          <a href="#bootstrap">Bootstrap</a> 
          <ul>
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

この最初のチュートリアルでは、簡単な登録フォームのアプリケーションの作成を、基礎から一歩ずつ進めます。 次のガイドでは、Phalconフレームワークの設計面をご紹介します。

このチュートリアルでは、単純なMVCアプリケーションの実装について説明し、Phalconを使用してどのように迅速かつ簡単に実行できるかを示します。 このチュートリアルでは、多くのニーズに対応できるように、拡張可能なアプリケーションを作成するのに役立ちます。 このチュートリアルのコードは、他のPhalcon固有の概念やアイデアを学ぶための遊び場としても使用できます。

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

とにかく始めたいのであれば、このガイドをスキップして、[developer tools](/[[language]]/[[version]]/devtools-usage) を使ってPhalconプロジェクトを自動的に作成することができます。 (あなたが立ち往生した場合、ここに戻って来ると良いでしょう)

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
        注：Phalconのコア依存関係のすべてが、Phalcon extensionとしてメモリにロードされているため、 `vendor`ディレクトリは表示していません。 Phalcon拡張機能の [インストール](/[[language]]/[[version]]/installation) をしていない場合は、インストールを済ませてからにしてください。
    </p>
</div>

全く初めて作る場合いは、[Phalcon Devtools](/[[language]]/[[version]]/devtools-installation)をインストールすることをお勧めします。[.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php)をプロジェクトのルートに追加してPHPのビルトインサーバーを利用すれば、Webサーバーの設定をしなくてもアプリケーションを稼働させることができます。

それ以外に、Nginxを使用したい場合は、[ここに](/[[language]]/[[version]]/webserver-setup#nginx)いくつかの追加設定があります。

もしApacheを使いたい場合は、[こちらで](/[[language]]/[[version]]/webserver-setup#apache)追加設定をしてください。

最後に、もしCherokeeがお好みの場合は[ここで](/[[language]]/[[version]]/webserver-setup#cherokee)設定してください。

<a name='bootstrap'></a>

## Bootstrap

はじめに作成する必要があるファイルは bootstrap ファイルです。 このファイルは、アプリケーションのエントリポイント、そして設定ファイルとして機能します。 このファイルでは、アプリケーションの動作と同様に、コンポーネントの初期化を実装できます。

このファイルは3つのことを処理します: - コンポーネントのオートローダーの登録 - サービスの設定とDependency Injectionへの登録 - アプリケーションのHTTPリクエストの処理

<a name='autoloaders'></a>

### オートローダー

オートローダーはPhalconの実行中に[PSR-4](http://www.php-fig.org/psr/psr-4/)準拠のファイルローダーを提供します。 通常、オートローダーに追加する必要があるのはControllerとModelです。 アプリケーションの名前空間内で、ファイルを検索するディレクトリを登録できます。 他の方法でオートローダーを使いたい場合、[こちら](/[[language]]/[[version]]/loader#overview)をご覧ください。

まず、アプリケーションの`controllers`と`models`ディレクトリを登録します。`Phalcon\Loader`のローダーを含めることを忘れないでください。

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

Phalconは疎結合で実装されており、サービスはDependency Managerに登録されているため、[IoC](https://en.wikipedia.org/wiki/Inversion_of_control)コンテナにラップされたコンポーネントやサービスに自動的に挿入できます。 Dependency Injectionの略語であるDIが出てくることがよくあります。 Dependency InjectionとInversion of Control(IoC) は複雑な機能のような聞こえるかもしれませんが、ファルコンでの使用は非常にシンプルで実用的です。 PhalconのIoCコンテナは、以下の概念で構成されています。 - Serviceコンテナ: アプリケーションが機能するために必要なサービスをグローバルに格納する "バッグ"。 - ServiceまたはComponent: コンポーネントに注入されるデータ処理オブジェクト

フレームワークがコンポーネントやサービスを必要とするたびに、サービスに紐づけられた名前を使用してコンテナに問い合わせます。 `Phalcon\Di`をサービスコンテナの設定に含めることを忘れないでください。

<div class='alert alert-warning'>
    <p>
        あなたがまだ詳細に興味があるなら、[Martin Fowler](https://martinfowler.com/articles/injection.html) のこの記事をご覧ください。 また、多くのユースケースをカバーする [素晴らしいチュートリアル](/[[language]]/[[version]]/di) もあります。
    </p>
</div>

### Factory Default

`Phalcon\Di\FactoryDefault` は `Phalcon\Di` の一種です。 実装を簡単にするために、Phalconに付属するほとんどのコンポーネントは自動的に登録されます。 Dependency Managementに慣れやすくする為にも、サービスを手動で登録することをお勧めします。 後で、このコンセプトに慣れたらいつでも指定できます。

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

このファイルの最後の部分には、`Phalcon\Mvc\Application` があります。 その目的は、リクエスト環境変数を初期化し、受け取ったリクエストをルーティング、検出されたアクションにディスパッチすることです。レスポンスを集約し、処理が完了したときにそれを返却します。

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

![](/images/content/tutorial-basic-1.png)

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

ブラウザの出力は変わらないはずです。 静的コンポーネントの `Phalcon\Mvc\View` は、アクションの実行が終了すると自動的に作成されます。 ビューの詳しい使い方は[こちら](/[[language]]/[[version]]/views)。

<a name='signup-form'></a>

## サインアップフォームのデザイン

今度は`index.phtml`ビューファイルを変更して、 "signup"という名前の新しいコントローラへのリンクを追加します。 目標は、ユーザーがアプリケーション内でサインアップできるようにすることです。

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

HTML生成に関するより詳細な記事は[ここにあります](/[[language]]/[[version]]/tag)。

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

![](/images/content/tutorial-basic-3.png)

`Phalcon\Tag`は、フォーム要素を構築するための便利なメソッドも提供します。

`Phalcon\Tag::form()`メソッドは、例えばアプリケーション内の controller/action に対する相対URIを唯一のパラメータとして受け取ります。

「送信」ボタンをクリックすると、フレームワークから例外がスローされ、`signup`コントローラーの`register`アクションが無いことがわかります。 `public/index.php`ファイルは以下の例外を投げます:

    Exception: Action "register" was not found on handler "signup"
    

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

Phalconは、C言語で書かれた初めてのPHP用ORMを提供します。これは、開発の複雑さを増す事なく単純化します。

最初のモデルを作る前に、Phalconがマッピングできるようデータベースのテーブルを作る必要があります。登録ユーザーを格納するための単純なテーブルは、次のように定義できます:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

モデルは、`app/models`ディレクトリに配置する必要があります (`app/models/Users.php`)。このモデルは "users" テーブルにマッピングされます。

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

not null (required) として定義されているフィールドに対しては、追加のバリデーションが自動的に実行されます。サインアップフォームに必要なフィールドを入力しないと、画面は次のようになります:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## まとめ

ご覧のとおり、Phalconを使用してアプリケーションを構築するのは簡単です。 Phalconがextensionから実行されているという事実は、プロジェクトのフットプリントを大幅に減らし、パフォーマンスを大幅に向上させます。

あなたがもっと学ぶ準備ができているなら、次に[Restチュートリアル](/[[language]]/[[version]]/tutorial-rest)をチェックしてください。