<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">チュートリアル: INVO</a> 
      <ul>
        <li>
          <a href="#structure">プロジェクトの構成</a>
        </li>
        <li>
          <a href="#routing">ルーティング</a>
        </li>
        <li>
          <a href="#configuration">設定</a>
        </li>
        <li>
          <a href="#autoloaders">オートローダー</a>
        </li>
        <li>
          <a href="#services">サービスの登録</a>
        </li>
        <li>
          <a href="#handling-requests">リクエストの処理</a>
        </li>
        <li>
          <a href="#dependency-injection">依存性の注入</a>
        </li>
        <li>
          <a href="#log-in">アプリケーションへのログイン</a>
        </li>
        <li>
          <a href="#securing-backend">バックエンドのセキュリティ保護</a> 
          <ul>
            <li>
              <a href="#events-manager">イベント管理</a>
            </li>
            <li>
              <a href="#acl">ACLリストの提供</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#working-with-crud">CRUDを使用した作業</a>
        </li>
        <li>
          <a href="#search-form">検索フォーム</a>
        </li>
        <li>
          <a href="#performing-searches">検索の実行</a>
        </li>
        <li>
          <a href="#creating-updating-records">レコードの登録の更新</a>
        </li>
        <li>
          <a href="#user-components">ユーザーコンポーネント</a>
        </li>
        <li>
          <a href="#dynamic-titles">タイトルの動的な変更</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# チュートリアル: INVO

この第2のチュートリアルでは、より完全なアプリケーションを例にして説明し、Phalconを使用した開発について理解を深めます。 INVOは、私達が制作したサンプルアプリケーションの1つです。 INVOは小さなWebサイトで、ユーザーは請求書を作成したり、顧客や製品を管理したりといったタスクを行うことができます。 コードは [Github](https://github.com/phalcon/invo) からcloneすることができます。

INVOはクライアントサイドフレームワークである [Bootstrap](http://getbootstrap.com/) を使用して作られています。 アプリケーションは実際の請求書を生成しませんが、フレームワークの働きを理解するサンプルにはなります。

<a name='structure'></a>

## プロジェクトの構成

ドキュメントルートでプロジェクトをcloneすると、次のような構造が表示されます:

```bash
invo/
    app/
        config/
        controllers/
        forms/
        library/
        logs/
        models/
        plugins/
        views/
    cache/
        volt/
    docs/
    public/
        css/
        fonts/
        js/
    schemas/
```

ご存知のように、Phalconはアプリケーション開発に際して特定の構造を強制しません。このプロジェクトはシンプルなMVC構造を持ち、publicディレクトリをドキュメントルートとします。

ブラウザで `http://localhost/invo` にアクセスしてアプリケーションを開くと、以下のように表示されるでしょう:

![](/images/content/tutorial-invo-1.png)

アプリケーションは2つの部分に分かれています: フロント／バックエンド。 フロントエンドは公開されている部分で、訪問者はINVOの概要を知ったり、連絡先情報をリクエストする事ができます。 バックエンドは管理用の領域で、登録ユーザーが製品や顧客情報の管理ができます。

<a name='routing'></a>

## ルーティング

INVOは[Router](/[[language]]/[[version]]/routing)コンポーネントに組み込みの標準的なルートを使用します。 これらのルートは、 `/:controller/:action/:params` というパターンにマッチします。 これは、URIの最初の部分がコントローラー、2番めの部分がアクション、残りがパラメーターになる、ということを意味しています。

`/session/register` というルートでは、`SessionController` コントローラの `registerAction` アクションが実行されます。

<a name='configuration'></a>

## 設定

INVOにはアプリケーション内で、一般的なパラメーターをセットする設定ファイルがあります。 このファイルは `app/config/config.ini` にあり、アプリケーションのブートストラップ (`public/index.php`) の最初の数行で読み込まれています:

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

// ...

// 設定の読み込み
$config = new ConfigIni(
    APP_PATH . 'app/config/config.ini'
);

```

[Phalcon Config](/[[language]]/[[version]]/config) (`Phalcon\Config`) を使うと、オブジェクト指向のやり方でファイルの操作を可能にします。 この例では、設定にiniファイルを使用していますが、Phalconは他のファイルタイプに対しても[アダプター](/[[language]]/[[version]]/config)を持っています。 構成ファイルには、次の設定が含まれています:

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

Phalconには、あらかじめ定義された設定規則はありません。 セクションは必要に応じてオプションを整理するのに役立ちます。 このファイルには、2つのセクションが使用されます: `application`と`database`。

<a name='autoloaders'></a>

## オートローダー

ブートストラップ(`public/index.php`)に記述されている2番目の部分はオートローダーです:

```php
<?php

/**
 * オートローダーの設定
 */
require APP_PATH . 'app/config/loader.php';
```

オートローダーは、アプリケーションが最終的に必要とするクラスを探すディレクトリーのセットを登録します。

```php
<?php

$loader = new Phalcon\Loader();

// 設定ファイルからディレクトリの設定を取得して登録
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

上記のコードは、設定ファイルで定義されたディレクトリを登録していることに注意してください。 viewsDirにはHTMLファイルとPHPファイルが含まれますが、クラスは含まれていないためviewsDirディレクトリだけは登録しません。 また、APP_PATHという定数を使っていることに注意してください。 この定数はブートストラップ(`public/index.php`)で定義されているもので、プロジェクトのルートパスを参照することができます。

```php
<?php

// ...

define(
    'APP_PATH',
    realpath('..') . '/'
);
```

<a name='services'></a>

## サービスの登録

ブートストラップで必要とされる他のファイルは(`app/config/services.php`)です。 このファイルでINVOが利用するサービスを設定することができます。

```php
<?php

/**
 * アプリケーションのサービスを登録
 */
require APP_PATH . 'app/config/services.php';
```

サービス登録は、必要なコンポーネントを遅延ロードするためのクロージャによって実現されます。

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

/**
 * URLコンポーネントはアプリケーションにおける全てのURLを生成するに使われる
 */
$di->set(
    'url',
    function () use ($config) {
        $url = new UrlProvider();

        $url->setBaseUri(
            $config->application->baseUri
        );

        return $url;
    }
);
```

後でこのファイルについてより詳しく説明します。

<a name='handling-requests'></a>

## リクエストの処理

ファイル(`public/index.php`)の最後では、リクエストは最終的に`Phalcon\Mvc\Application`で処理されています。このクラスは、アプリケーションの実行に必要な全ての初期化と処理の実行を行います:

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);

$response = $application->handle();

$response->send();
```

<a name='dependency-injection'></a>

## 依存性の注入

上記コード例の1行目を見てください。 Application クラスのコンストラクタは、`$di` 変数を引数として受け取っています。 この変数の目的は何でしょう？ Phalconは高度に分割されたフレームワークなので、全てが協調して動作するための接着剤の役割を果たすコンポーネントが必要です。 そのコンポーネントは、`Phalcon\Di` です。 これはサービスコンテナで、依存性の注入（Dependency Injection）や、アプリケーションに必要なコンポーネントの初期化も実行します。

コンテナにサービスを登録するには、様々な方法があります。 INVOでは、ほとんどのサービスは無名関数/クロージャーを使って登録されています。 このおかげで、オブジェクトは必要になるまでインスタンス化されないので、アプリケーションに必要なリソースが節約できます。

たとえば以下の抜粋では、sessionサービスが登録されています。無名関数はアプリケーションがsessionへのアクセスを要求した時に初めて呼ばれます:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// ...

// コンポーネントがsessionサービスを最初に要求した時にセッションを開始する
$di->set(
    'session',
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);
```

これでアダプタを変更して、初期化処理を追加する等が自由に行えるようになりました。 サービスは “session” という名前で登録されていることに注意してください。 これは、フレームワークがサービスコンテナ内のアクティブなサービスを識別できるようにする規約です。

リクエストは多数のサービスを利用する可能性があり、それらを1つずつ登録するのは面倒な作業です。 そのため、Phalconは `Phalcon\Di\FactoryDefault` という `Phalcon\Di` の別バージョンを用意しています。

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// FactoryDefault Dependency Injectorは、フルスタックフレームワークを提供するのに
// 最適なサービスを、自動的に登録します
$di = new FactoryDefault();
```

FactoryDefault はフレームワークが標準的に提供しているコンポーネントサービスのほぼ全てを登録します。 サービスの定義をオーバーライドする必要がある場合は、上記のように`session`や`url`を再設定することができます。 以上が、`$di` 変数が存在する理由です。

<a name='log-in'></a>

## アプリケーションへのログイン

`ログイン`機能によって、私たちはバックエンドコントローラの作業に取りかかることができます。 バックエンドとフロントエンドのコントローラーの分割は、あくまで論理上のものです。 全てのコントローラーは、同じディレクトリ (`app/controllers/`) に含まれています。

システムを利用するために、ユーザーは有効なユーザー名とパスワードを持っている必要があります。ユーザー情報は `invo` データベースの`users` テーブルに保存されます。

セッションを開始する前に、アプリケーションがデータベースに接続できるよう設定する必要があります。 接続情報を持った `db` という名前のサービスが、サービスコンテナ内で用意されます。 オートローダーと同様、サービスを設定するための情報は設定ファイルから取得します:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// ...

// 設定ファイルに定義されたパラメーターに基いてデータベース接続が作成される
$di->set(
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

ここで、MySQL接続アダプターのインスタンスを返しています。ロガーやプロファイラの追加、アダプターの変更等が必要であれば、それらの処理を追加することもできます。

以下の簡単なフォーム (`app/views/session/index.volt`) では、ユーザーにログイン情報を求めています。サンプルを簡潔にするため、いくつかのHTMLコードは省いています:

```twig
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
```

以前のチュートリアルでは生のPHPを使用する代わりに、[Volt](/[[language]]/[[version]]/volt)を使ってチュートリアルを始めました。 これは、Jinja_に触発された組み込みのテンプレートエンジンで、テンプレートを作成するためのよりシンプルで使いやすい構文を提供します。 Voltに精通するのに時間はかかりません。

`SessionController::startAction`関数 (`app/controllers/SessionController.php`) が、フォームに入力されたデータのバリデーションを行います。これには、データベース内の有効なユーザーかの確認も含まれます:

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

    /**
     * このアクションはユーザーを認証しアプリケーションにログインさせる
     */
    public function startAction()
    {
        if ($this->request->isPost()) {
            // POSTで送信された変数を受け取る
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // データベースからユーザーを検索
            $user = Users::findFirst(
                [
                    "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
                    'bind' => [
                        'email'    => $email,
                        'password' => sha1($password),
                    ]
                ]
            );

            if ($user !== false) {
                $this->_registerSession($user);

                $this->flash->success(
                    'Welcome ' . $user->name
                );

                // ユーザーが有効なら、'invoices' コントローラーに転送する
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

        // ログインフォームへ再度転送
        return $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }
}
```

簡単にするため、 データベースに保存するパスワードハッシュに[sha1](http://php.net/manual/en/function.sha1.php)を使用していますが、このアルゴリズムは実際のアプリケーションでは推奨されません。代わりに[bcrypt](/[[language]]/[[version]]/security)を使ってください。

コントローラー内で `$this->flash`、`$this->request`、`$this->session` のようなpublic属性へのアクセスに注目してください。 これらは、サービスコンテナであらかじめ定義したサービスです (`app/config/services.php`)。 初めてアクセスされると、コントローラの一部として注入されます。 これらのサービスは`共有`されているため、これらのオブジェクトをどこから呼び出しても、常に同じインスタンスにアクセスすることになります。 例えば、ここで`session`サービスを呼び出して、ユーザーを識別する情報を`auth`という変数に保存しています:

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

このセクションのもう1つの重要な側面は、ユーザーが有効なものとして検証される方法です。まず、リクエストが`POST`メソッドを使用して行われたかどうかを検証します:

```php
<?php

if ($this->request->isPost()) {
    // ...
}
```

次に、フォームからパラメータを受け取ります:

```php
<?php

$email    = $this->request->getPost('email');
$password = $this->request->getPost('password');
```

ここで、同じユーザー名または電子メールとパスワードを持つユーザーが1人いるかどうかを確認する必要があります。

```php
<?php

$user = Users::findFirst(
    [
        "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
        'bind' => [
            'email'    => $email,
            'password' => sha1($password),
        ]
    ]
);
```

'バインドパラメータ'を使う事で、プレースホルダ`:email:`と`:password:`を値が存在すべき場所に設置する事で、パラメータ`bind`の値が'バインド'されます。 これにより、SQLインジェクションのリスクがなくても、これらのカラムの値が安全に置き換えられます。

ユーザーが有効な場合、セッションに登録し、ダッシュボードに転送します:

```php
<?php

if ($user !== false) {
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

ユーザーが存在しない場合は、フォームが表示されているアクションにユーザーを再度戻します:

```php
<?php

return $this->dispatcher->forward(
    [
        'controller' => 'session',
        'action'     => 'index',
    ]
);
```

<a name='securing-backend'></a>

## バックエンドのセキュリティ保護

バックエンドは登録されたユーザーだけがアクセスできるプライベートな領域です。 したがって、登録されたユーザーだけがそれらのコントローラーにアクセスできるようチェックする必要があります。 たとえば、ログインせずに products コントローラー (プライベート領域) にアクセスしようとすると、以下のように表示されるはずです:

![](/images/content/tutorial-invo-2.png)

コントローラー・アクションにアクセスしようとしたときにはいつでも、アプリケーションは現在のロール (セッションに含まれる) が、アクセス権を持っているか確認します。アクセス権がない場合は、上のようなメッセージを表示し、インデックスページに遷移させます。

次に、アプリケーションがこの動きをどのように実現しているか見ていきましょう。 最初に知るべきは、[Dispatcher](/[[language]]/[[version]]/dispatcher) コンポーネントです。 これは、[Routing](/[[language]]/[[version]]/routing)コンポーネントによって発見されたルートの情報を受け取ります。 次に、適切なコントローラーを読み込んで、対応するアクションのメソッドを実行します。

通常、フレームワークはディスパッチャを自動的に作成します。 今回は、要求されたアクションを実行する前に、認証を行い、ユーザーがアクセスできるか否かチェックする必要があります。 これを実現するため、ブートストラップの中に関数を用意して、ディスパッチャを置き換えています:

```php
<?php

use Phalcon\Mvc\Dispatcher;

// ...

/**
 * MVCディスパッチャー
 */
$di->set(
    'dispatcher',
    function () {
        // ...

        $dispatcher = new Dispatcher();

        return $dispatcher;
    }
);
```

これで、アプリケーションで使用されるディスパッチャを完全に制御できるようになりました。 フレーワークの多くのコンポーネントはイベントを発火するので、内部の処理の流れを変更することができます。 DIコンポーネントが接着剤として機能し、[EventsManager](/[[language]]/[[version]]/events)がコンポーネントが生み出すイベントをインターセプトし、イベントをリスナーに通知します。

<a name='events-manager'></a>

### イベント管理

[EventsManager](/[[language]]/[[version]]/events)によって、特定のタイプのイベントにリスナーを割り当てることができます。 今、私達が取り組んでいるイベントのタイプは 'dispatch' です。 以下のコードは、ディスパッチャによって生成される全てのイベントをフィルタリングしています:

```php
<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // イベントマネージャを作成する
        $eventsManager = new EventsManager();

        // Securityプラグインを使用して、ディスパッチャが生成するイベントを監視する
        $eventsManager->attach(
            'dispatch:beforeExecuteRoute',
            new SecurityPlugin()
        );

        // NotFoundPluginを使用して例外や未発見の例外を処理する
        $eventsManager->attach(
            'dispatch:beforeException',
            new NotFoundPlugin()
        );

        $dispatcher = new Dispatcher();

        // イベントマネージャーをディスパッチャにアサインする
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

`beforeExecuteRoute`というイベントが発生すると、次のプラグインが通知されます。

```php
<?php

/**
 * ユーザーがSecurityPluginを使用して特定のアクションにアクセスすることを許可されているかどうかを確認します
 */
$eventsManager->attach(
    'dispatch:beforeExecuteRoute',
    new SecurityPlugin()
);
```

`beforeException`がトリガされると、他のプラグインに通知されます:

```php
<?php

/**
 * NotFoundPluginを使用して例外や未発見の例外を処理する
 */
$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundPlugin()
);
```

SecurityPluginは (`app/plugins/SecurityPlugin.php`) にあるクラスです。 このクラスは`beforeExecuteRoute`メソッドを実装しています。 これは、ディスパッチャーが生成するイベントの1つと同じ名前です:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    // ...

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // ...
    }
}
```

フックイベントは常に2つの引数を取ります。第1引数はイベントが生成されたコンテキストの情報(`$event`) で、第2引数はイベントを生成したオブジェクト自身 (`$dispatcher`) です。 プラグインが`Phalcon\Mvc\User\Plugin`を継承することは必須ではありませんが、継承することでアプリケーションのサービスに簡単にアクセスできるようになります。

ACLリストを使用してユーザーがアクセス権を持つかチェックすることで、現在のセッションのロールを検証するようになりました。ユーザーがアクセス権を持たない場合、前述したように最初のページにリダイレクトされます:

```php
<?php

use Phalcon\Acl;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    // ...

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // ロールを定義するため、セッションに'auth'変数があるかチェックする
        $auth = $this->session->get('auth');

        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        // ディスパッチャからアクティブなコントローラー名とアクション名を取得する
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        // ACLリストを取得
        $acl = $this->getAcl();

        // ロールがコントローラー (又はリソース) にアクセス可能かチェックする
        $allowed = $acl->isAllowed($role, $controller, $action);

        if (!$allowed) {
            // アクセス権が無い場合、indexコントローラーに転送する
            $this->flash->error(
                "You don't have access to this module"
            );

            $dispatcher->forward(
                [
                    'controller' => 'index',
                    'action'     => 'index',
                ]
            );

            // 'false'を返し、ディスパッチャーに現在の処理を停止させる
            return false;
        }
    }
}
```

<a name='acl'></a>

### ACLリストの提供

上の例では、`$this->getAcl()`メソッドでACLを取得しました。 このメソッドもプラグインに実装されています。 ここでは、アクセス制御リスト (ACL) をどのように作ったか、ステップバイステップで解説します:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;

// ACLオブジェクトを作る
$acl = new AclList();

// デフォルトの挙動はDENY（拒否）
$acl->setDefaultAction(
    Acl::DENY
);

// 2つのロールを登録する
// ユーザーは登録済みユーザー、ゲストは未登録ユーザー
$roles = [
    'users'  => new Role('Users'),
    'guests' => new Role('Guests'),
];

foreach ($roles as $role) {
    $acl->addRole($role);
}
```

次に、それぞれのエリアのリソースを個別に定義していきます。コントローラー名がリソースで、これらのアクションがリソースへのアクセス権です:

```php
<?php

use Phalcon\Acl\Resource;

// ...

// プライベートエリアのリソース (バックエンド)
$privateResources = [
    'companies'    => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
    'products'     => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
    'producttypes' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
    'invoices'     => ['index', 'profile'],
];

foreach ($privateResources as $resourceName => $actions) {
    $acl->addResource(
        new Resource($resourceName),
        $actions
    );
}



// 公開エリアのリソース (フロントエンド)
$publicResources = [
    'index'    => ['index'],
    'about'    => ['index'],
    'register' => ['index'],
    'errors'   => ['show404', 'show500'],
    'session'  => ['index', 'register', 'start', 'end'],
    'contact'  => ['index', 'send'],
];

foreach ($publicResources as $resourceName => $actions) {
    $acl->addResource(
        new Resource($resourceName),
        $actions
    );
}
```

いま、ACLは既存のコントローラーと関連するアクションの情報を知っている状態になっています。 `Users`ロールはバックエンドとフロントエンド双方の全てのリソースにアクセスできます。 `Guests`ロールは公開エリアにだけアクセスできます:

```php
<?php

// 公開エリアのアクセス権をユーザーとゲストの双方に与える
foreach ($roles as $role) {
    foreach ($publicResources as $resource => $actions) {
        $acl->allow(
            $role->getName(),
            $resource,
            '*'
        );
    }
}

// ユーザーにだけ、プライベートエリアへのアクセス権を与える
foreach ($privateResources as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow(
            'Users',
            $resource,
            $action
        );
    }
}
```

<a name='working-with-crud'></a>

## CRUDを使用した作業

Backends usually provide forms to allow users to manipulate data. Continuing the explanation of INVO, we now address the creation of CRUDs, a very common task that Phalcon will facilitate you using forms, validations, paginators and more.

Most options that manipulate data in INVO (companies, products and types of products) were developed using a basic and common [CRUD](http://en.wikipedia.org/wiki/Create,_read,_update_and_delete) (Create, Read, Update and Delete). Each CRUD contains the following files:

```bash
invo/
    app/
        controllers/
            ProductsController.php
        models/
            Products.php
        forms/
            ProductsForm.php
        views/
            products/
                edit.volt
                index.volt
                new.volt
                search.volt
```

Each controller has the following actions:

```php
<?php

class ProductsController extends ControllerBase
{
    /**
     * The start action, it shows the 'search' view
     */
    public function indexAction()
    {
        // ...
    }

    /**
     * Execute the 'search' based on the criteria sent from the 'index'
     * Returning a paginator for the results
     */
    public function searchAction()
    {
        // ...
    }

    /**
     * Shows the view to create a 'new' product
     */
    public function newAction()
    {
        // ...
    }

    /**
     * Shows the view to 'edit' an existing product
     */
    public function editAction()
    {
        // ...
    }

    /**
     * Creates a product based on the data entered in the 'new' action
     */
    public function createAction()
    {
        // ...
    }

    /**
     * Updates a product based on the data entered in the 'edit' action
     */
    public function saveAction()
    {
        // ...
    }

    /**
     * Deletes an existing product
     */
    public function deleteAction($id)
    {
        // ...
    }
}
```

<a name='search-form'></a>

## 検索フォーム

Every CRUD starts with a search form. This form shows each field that the table has (products), allowing the user to create a search criteria for any field. The `products` table has a relationship with the table `products_types`. In this case, we previously queried the records in this table in order to facilitate the search by that field:

```php
<?php

/**
 * The start action, it shows the 'search' view
 */
public function indexAction()
{
    $this->persistent->searchParams = null;

    $this->view->form = new ProductsForm();
}
```

An instance of the `ProductsForm` form (`app/forms/ProductsForm.php`) is passed to the view. This form defines the fields that are visible to the user:

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
    /**
     * Initialize the products form
     */
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

The form is declared using an object-oriented scheme based on the elements provided by the [forms](/[[language]]/[[version]]/forms) component. Every element follows almost the same structure:

```php
<?php

// Create the element
$name = new Text('name');

// Set its label
$name->setLabel('Name');

// Before validating the element apply these filters
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

// Apply this validators
$name->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'Name is required',
            ]
        )
    ]
);

// Add the element to the form
$this->add($name);
```

Other elements are also used in this form:

```php
<?php

// Add a hidden input to the form
$this->add(
    new Hidden('id')
);

// ...

$productTypes = ProductTypes::find();

// Add a HTML Select (list) to the form
// and fill it with data from 'product_types'
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

Note that `ProductTypes::find()` contains the data necessary to fill the SELECT tag using `Phalcon\Tag::select()`. Once the form is passed to the view, it can be rendered and presented to the user:

```twig
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
```

This produces the following HTML:

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
            <label for='profilesId' class='control-label'>profilesId</label>

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
            <input type='submit' value='Search' class='btn btn-primary' />
        </div>

    </fieldset>

</form>
```

When the form is submitted, the `search` action is executed in the controller performing the search based on the data entered by the user.

<a name='performing-searches'></a>

## 検索の実行

The `search` action has two behaviors. When accessed via POST, it performs a search based on the data sent from the form but when accessed via GET it moves the current page in the paginator. To differentiate HTTP methods, we check it using the [Request](/[[language]]/[[version]]/request) component:

```php
<?php

/**
 * Execute the 'search' based on the criteria sent from the 'index'
 * Returning a paginator for the results
 */
public function searchAction()
{
    if ($this->request->isPost()) {
        // Create the query conditions
    } else {
        // Paginate using the existing conditions
    }

    // ...
}
```

With the help of `Phalcon\Mvc\Model\Criteria`, we can create the search conditions intelligently based on the data types and values sent from the form:

```php
<?php

$query = Criteria::fromInput(
    $this->di,
    'Products',
    $this->request->getPost()
);
```

This method verifies which values are different from '' (empty string) and null and takes them into account to create the search criteria:

* If the field data type is text or similar (char, varchar, text, etc.) It uses an SQL `like` operator to filter the results.
* If the data type is not text or similar, it'll use the operator `=`.

Additionally, `Criteria` ignores all the `$_POST` variables that do not match any field in the table. Values are automatically escaped using `bound parameters`.

Now, we store the produced parameters in the controller's session bag:

```php
<?php

$this->persistent->searchParams = $query->getParams();
```

A session bag, is a special attribute in a controller that persists between requests using the session service. When accessed, this attribute injects a `Phalcon\Session\Bag` instance that is independent in each controller.

Then, based on the built params we perform the query:

```php
<?php

$products = Products::find($parameters);

if (count($products) === 0) {
    $this->flash->notice(
        'The search did not found any products'
    );

    return $this->dispatcher->forward(
        [
            'controller' => 'products',
            'action'     => 'index',
        ]
    );
}
```

If the search doesn't return any product, we forward the user to the index action again. Let's pretend the search returned results, then we create a paginator to navigate easily through them:

```php
<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

// ...

$paginator = new Paginator(
    [
        'data'  => $products,   // Data to paginate
        'limit' => 5,           // Rows per page
        'page'  => $numberPage, // Active page
    ]
);

// Get active page in the paginator
$page = $paginator->getPaginate();
```

Finally we pass the returned page to view:

```php
<?php

$this->view->page = $page;
```

In the view (`app/views/products/search.volt`), we traverse the results corresponding to the current page, showing every row in the current page to the user:

```twig
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
                            {{ link_to('products/search', 'First') }}
                            {{ link_to('products/search?page=' ~ page.before, 'Previous') }}
                            {{ link_to('products/search?page=' ~ page.next, 'Next') }}
                            {{ link_to('products/search?page=' ~ page.last, 'Last') }}
                            <span class='help-inline'>{{ page.current }} of {{ page.total_pages }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    {% endif %}
{% else %}
    No products are recorded
{% endfor %}
```

There are many things in the above example that worth detailing. First of all, active items in the current page are traversed using a Volt's `for`. Volt provides a simpler syntax for a PHP `foreach`.

```twig
{% for product in page.items %}
```

Which in PHP is the same as:

```php
<?php foreach ($page->items as $product) { ?>
```

The whole `for` block provides the following:

```twig
{% for product in page.items %}
    {% if loop.first %}
        Executed before the first product in the loop
    {% endif %}

    Executed for every product of page.items

    {% if loop.last %}
        Executed after the last product is loop
    {% endif %}
{% else %}
    Executed if page.items does not have any products
{% endfor %}
```

Now you can go back to the view and find out what every block is doing. Every field in `product` is printed accordingly:

```twig
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
```

As we seen before using `product.id` is the same as in PHP as doing: `$product->id`, we made the same with `product.name` and so on. Other fields are rendered differently, for instance, let's focus in `product.productTypes.name`. To understand this part, we have to check the Products model (`app/models/Products.php`):

```php
<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Products extends Model
{
    // ...

    /**
     * Products initializer
     */
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

A model can have a method called `initialize()`, this method is called once per request and it serves the ORM to initialize a model. In this case, 'Products' is initialized by defining that this model has a one-to-many relationship to another model called 'ProductTypes'.

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

Which means, the local attribute `product_types_id` in `Products` has an one-to-many relation to the `ProductTypes` model in its attribute `id`. By defining this relationship we can access the name of the product type by using:

```twig
<td>{{ product.productTypes.name }}</td>
```

The field `price` is printed by its formatted using a Volt filter:

```twig
<td>{{ '%.2f'|format(product.price) }}</td>
```

In plain PHP, this would be:

```php
<?php echo sprintf('%.2f', $product->price) ?>
```

Printing whether the product is active or not uses a helper implemented in the model:

```php
<td>{{ product.getActiveDetail() }}</td>
```

This method is defined in the model.

<a name='creating-updating-records'></a>

## レコードの登録の更新

Now let's see how the CRUD creates and updates records. From the `new` and `edit` views, the data entered by the user is sent to the `create` and `save` actions that perform actions of `creating` and `updating` products, respectively.

In the creation case, we recover the data submitted and assign them to a new `Products` instance:

```php
<?php

/**
 * Creates a product based on the data entered in the 'new' action
 */
public function createAction()
{
    if (!$this->request->isPost()) {
        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $form = new ProductsForm();

    $product = new Products();

    $product->id               = $this->request->getPost('id', 'int');
    $product->product_types_id = $this->request->getPost('product_types_id', 'int');
    $product->name             = $this->request->getPost('name', 'striptags');
    $product->price            = $this->request->getPost('price', 'double');
    $product->active           = $this->request->getPost('active');

    // ...
}
```

Remember the filters we defined in the Products form? Data is filtered before being assigned to the object `$product`. This filtering is optional; the ORM also escapes the input data and performs additional casting according to the column types:

```php
<?php

// ...

$name = new Text('name');

$name->setLabel('Name');

// Filters for name
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

// Validators for name
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

When saving, we'll know whether the data conforms to the business rules and validations implemented in the form `ProductsForm` form (`app/forms/ProductsForm.php`):

```php
<?php

// ...

$form = new ProductsForm();

$product = new Products();

// Validate the input
$data = $this->request->getPost();

if (!$form->isValid($data, $product)) {
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

Finally, if the form does not return any validation message we can save the product instance:

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

Now, in the case of updating a product, we must first present the user with the data that is currently in the edited record:

```php
<?php

/**
 * Edits a product based on its id
 */
public function editAction($id)
{
    if (!$this->request->isPost()) {
        $product = Products::findFirstById($id);

        if (!$product) {
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

The data found is bound to the form by passing the model as first parameter. Thanks to this, the user can change any value and then sent it back to the database through to the `save` action:

```php
<?php

/**
 * Updates a product based on the data entered in the 'edit' action
 */
public function saveAction()
{
    if (!$this->request->isPost()) {
        return $this->dispatcher->forward(
            [
                'controller' => 'products',
                'action'     => 'index',
            ]
        );
    }

    $id = $this->request->getPost('id', 'int');

    $product = Products::findFirstById($id);

    if (!$product) {
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

    if (!$form->isValid($data, $product)) {
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

<a name='user-components'></a>

## ユーザーコンポーネント

All the UI elements and visual style of the application has been achieved mostly through [Bootstrap](http://getbootstrap.com/). Some elements, such as the navigation bar changes according to the state of the application. For example, in the upper right corner, the link `Log in / Sign Up` changes to `Log out` if a user is logged into the application.

This part of the application is implemented in the component `Elements` (`app/library/Elements.php`).

```php
<?php

use Phalcon\Mvc\User\Component;

class Elements extends Component
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

This class extends the `Phalcon\Mvc\User\Component`. It is not imposed to extend a component with this class, but it helps to get access more quickly to the application services. Now, we are going to register our first user component in the services container:

```php
<?php

// Register a user component
$di->set(
    'elements',
    function () {
        return new Elements();
    }
);
```

As controllers, plugins or components within a view, this component also has access to the services registered in the container and by just accessing an attribute with the same name as a previously registered service:

```twig
<div class='navbar navbar-fixed-top'>
    <div class='navbar-inner'>
        <div class='container'>
            <a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
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
        <p>&copy; Company 2017</p>
    </footer>
</div>
```

The important part is:

```twig
{{ elements.getMenu() }}
```

<a name='dynamic-titles'></a>

## Changing the Title Dynamically

When you browse between one option and another will see that the title changes dynamically indicating where we are currently working. This is achieved in each controller initializer:

```php
<?php

class ProductsController extends ControllerBase
{
    public function initialize()
    {
        // Set the document title
        $this->tag->setTitle(
            'Manage your product types'
        );

        parent::initialize();
    }

    // ...
}
```

Note, that the method `parent::initialize()` is also called, it adds more data to the title:

```php
<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        // Prepend the application name to the title
        $this->tag->prependTitle('INVO | ');
    }

    // ...
}
```

Finally, the title is printed in the main view (app/views/index.volt):

```php
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <!-- ... -->
</html>
```