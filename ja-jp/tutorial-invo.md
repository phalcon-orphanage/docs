* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# チュートリアル: INVO

この第2のチュートリアルでは、より完全なアプリケーションを例にして説明し、Phalconを使用した開発について理解を深めます。 INVOは、私達が制作したサンプルアプリケーションの1つです。 INVOは小さなWebサイトで、ユーザーは請求書を作成したり、顧客や製品を管理したりといったタスクを行うことができます。 コードは [Github](https://github.com/phalcon/invo) からcloneすることができます。

INVO was made with the client-side framework [Bootstrap](https://getbootstrap.com/). アプリケーションは実際の請求書を生成しませんが、フレームワークの働きを理解するサンプルにはなります。

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

Once you open the application in your browser `https://localhost/invo` you'll see something like this:

![](/assets/images/content/tutorial-invo-1.png)

アプリケーションは2つの部分に分かれています: フロントエンド、バックエンド。 フロントエンドは公開されている部分で、訪問者はINVOの概要を知ったり、連絡先情報をリクエストする事ができます。 バックエンドは管理用の領域で、登録ユーザーが製品や顧客情報の管理ができます。

<a name='routing'></a>

## Routing

INVO uses the standard route that is built-in with the [Router](/4.0/en/routing) component. これらのルートは、 `/:controller/:action/:params` というパターンにマッチします。 これは、URIの最初の部分がコントローラー、2番めの部分がアクション、残りがパラメーターになる、ということを意味しています。

`/session/register` というルートでは、`SessionController` コントローラの `registerAction` アクションが実行されます。

<a name='configuration'></a>

## Configuration

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

[Phalcon Config](/4.0/en/config) ([Phalcon\Config](api/Phalcon_Config)) allows us to manipulate the file in an object-oriented way. In this example, we're using an ini file for configuration but Phalcon has [adapters](/4.0/en/config) for other file types as well. 構成ファイルには、次の設定が含まれています:

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

## オートローダ

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

Service registration is achieved with closures for lazy loading the required components:

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

If we skip to the end of the file (`public/index.php`), the request is finally handled by [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) which initializes and executes all that is necessary to make the application run:

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

上記コード例の1行目を見てください。 Application クラスのコンストラクタは、`$di` 変数を引数として受け取っています。 この変数の目的は何でしょう？ Phalconは高度に分割されたフレームワークなので、全てが協調して動作するための接着剤の役割を果たすコンポーネントが必要です。 That component is [Phalcon\Di](api/Phalcon_Di). これはサービスコンテナで、依存性の注入（Dependency Injection）や、アプリケーションに必要なコンポーネントの初期化も実行します。

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

リクエストは多数のサービスを利用する可能性があり、それらを1つずつ登録するのは面倒な作業です。 For that reason, the framework provides a variant of [Phalcon\Di](api/Phalcon_Di) called [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) whose task is to register all services providing a full-stack framework.

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

Instead of using raw PHP as the previous tutorial, we started to use [Volt](/4.0/en/volt). This is a built-in template engine inspired by Jinja_ providing a simpler and friendly syntax to create templates. It will not take too long before you become familiar with Volt.

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

For the sake of simplicity, we have used [sha1](https://php.net/manual/en/function.sha1.php) to store the password hashes in the database, however, this algorithm is not recommended in real applications, use [bcrypt](/4.0/en/security) instead.

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

![](/assets/images/content/tutorial-invo-2.png)

コントローラー・アクションにアクセスしようとしたときにはいつでも、アプリケーションは現在のロール (セッションに含まれる) が、アクセス権を持っているか確認します。アクセス権がない場合は、上のようなメッセージを表示し、インデックスページに遷移させます。

次に、アプリケーションがこの動きをどのように実現しているか見ていきましょう。 The first thing to know is that there is a component called [Dispatcher](/4.0/en/dispatcher). It is informed about the route found by the [Routing](/4.0/en/routing) component. 次に、適切なコントローラーを読み込んで、対応するアクションのメソッドを実行します。

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

これで、アプリケーションで使用されるディスパッチャを完全に制御できるようになりました。 フレーワークの多くのコンポーネントはイベントを発火するので、内部の処理の流れを変更することができます。 As the Dependency Injector component acts as glue for components, a new component called [EventsManager](/4.0/en/events) allows us to intercept the events produced by a component, routing the events to listeners.

<a name='events-manager'></a>

### イベント管理

The [EventsManager](/4.0/en/events) allows us to attach listeners to a particular type of event. 今、私達が取り組んでいるイベントのタイプは 'dispatch' です。 以下のコードは、ディスパッチャによって生成される全てのイベントをフィルタリングしています:

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

フックイベントは常に2つの引数を取ります。第1引数はイベントが生成されたコンテキストの情報(`$event`) で、第2引数はイベントを生成したオブジェクト自身 (`$dispatcher`) です。 It is not mandatory that plugins extend the class [Phalcon\Mvc\User\Plugin](api/Phalcon_Mvc_User_Plugin), but by doing this they gain easier access to the services available in the application.

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

バックエンドは一般的に、ユーザーがデータを操作できるようなフォームを提供します。 INVOの説明を続けると、今はCRUDの作成に取り組んでいます。Phalconにとっては、フォーム、バリデーション、ページネーターなどを利用する事で簡単に実装できる一般的な事例です。

Most options that manipulate data in INVO (companies, products and types of products) were developed using a basic and common [CRUD](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete) (Create, Read, Update and Delete). 各CRUDには、次のファイルが含まれています:

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

各コントローラーは、次のようなアクションを持っています:

```php
<?php

class ProductsController extends ControllerBase
{
    /**
     * 開始アクション。'search' ビューを表示
     */
    public function indexAction()
    {
        // ...
    }

    /**
     * 'index'から送信された検索条件に基づいて'search'を実行
     * 結果のページネーターを返す
     */
    public function searchAction()
    {
        // ...
    }

    /**
     * 'new' productを作成するビューを表示
     */
    public function newAction()
    {
        // ...
    }

    /**
     * 既存のproductを 'edit' するビューを表示
     */
    public function editAction()
    {
        // ...
    }

    /**
     * 'new' アクションで入力されたデータに基づいてproductを作成
     */
    public function createAction()
    {
        // ...
    }

    /**
     * 'edit' アクションで入力されたデータに基づいてproductを更新
     */
    public function saveAction()
    {
        // ...
    }

    /**
     * 既存のproductを削除
     */
    public function deleteAction($id)
    {
        // ...
    }
}
```

<a name='search-form'></a>

## 検索フォーム

すべてのCRUDは検索フォームから始まります。 このフォームは、テーブル (products) にある各フィールドを表示し、任意のフィールドの検索条件をユーザーが作成できるようにします。 `products`テーブルは`products_types`テーブルとのリレーションを持っています。 今回はフィールドでの検索を簡単に実装するために、テーブルのレコードを事前に取得しておきます:

```php
<?php

/**
 * 開始アクション。'search' ビューを表示
 */
public function indexAction()
{
    $this->persistent->searchParams = null;

    $this->view->form = new ProductsForm();
}
```

`ProductsForm`フォーム (`app/forms/ProductsForm.php`) のインスタンスがビューに渡されます。このフォームは、ユーザーに表示されるフィールドを定義します:

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
     * productsフォームの初期化
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

The form is declared using an object-oriented scheme based on the elements provided by the [forms](/4.0/en/forms) component. Every element follows almost the same structure:

```php
<?php

// 要素を作成
$name = new Text('name');

// ラベルを設定
$name->setLabel('Name');

// 要素を検証する前にフィルタを適用
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

// バリデーションを適用
$name->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'Name is required',
            ]
        )
    ]
);

// フォームに要素を追加
$this->add($name);
```

他の要素もフォームで使用されます:

```php
<?php

// 非表示項目をフォームに追加
$this->add(
    new Hidden('id')
);

// ...

$productTypes = ProductTypes::find();

// フォームにHTMLのSELECT （リスト）を追加
// 'product_types' のデータで埋める
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

`ProductTypes::find()`には、`Phalcon\Tag::select()`を使用してSELECTタグを埋めるために必要なデータが含まれています。 フォームがビューに渡されると、レンダリングしてユーザーに表示することができます:

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

次の HTML が生成されます:

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

フォームが送信されると、`search`アクションは、ユーザーが入力したデータに基づいて検索を実行するコントローラーの中で実行されます。

<a name='performing-searches'></a>

## 検索の実行

`search`アクションには2つの動作があります。 POSTでアクセスすると、フォームから送信されたデータに基づいて検索が実行されますが、GETでアクセスするとページネーション内のページに移動します。 To differentiate HTTP methods, we check it using the [Request](/4.0/en/request) component:

```php
<?php

/**
 * 'index' から送信された検索条件に基づいて 'search' を実行
 * 結果のページネーターを返す
 */
public function searchAction()
{
    if ($this->request->isPost()) {
        // クエリ条件を作成する
    } else {
        // 既存の条件を使用してページ切り替え
    }

    // ...
}
```

With the help of [Phalcon\Mvc\Model\Criteria](api/Phalcon_Mvc_Model_Criteria), we can create the search conditions intelligently based on the data types and values sent from the form:

```php
<?php

$query = Criteria::fromInput(
    $this->di,
    'Products',
    $this->request->getPost()
);
```

このメソッドは、どの値が ''（空の文字列）およびnullであるかを検証し、それらを考慮して検索条件を作成します。

* フィールドのデータ型がテキストまたは同様のもの（char、varchar、textなど）の場合、SQLの`like`演算子を使用して結果をフィルタリングします。
* データ型がテキストでない場合、演算子`=`が使用されます。

さらに、`Criteria</ 0>は、テーブルのどのフィールドとも一致しないすべての<code>$POST`変数を無視します。 値は`バインドされたパラメータ`を使用して自動的にエスケープされます。

ここでは、生成されたパラメータをコントローラのセッションバッグに格納します:

```php
<?php

$this->persistent->searchParams = $query->getParams();
```

セッションバッグはリクエスト間で値を維持する、セッションサービスを利用したコントローラの特殊な変数です。 When accessed, this attribute injects a [Phalcon\Session\Bag](api/Phalcon_Session_Bag) instance that is independent in each controller.

次に、生成されたパラメータに基づいてクエリを実行します:

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

検索でproductが返されない場合は、ユーザーをindexアクションに再度転送します。 返された検索結果をふりかえってみましょう。その後、それらを簡単にナビゲートするためにページネーションを作成します。

```php
<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

// ...

$paginator = new Paginator(
    [
        'data'  => $products,   // ページネーション用データ
        'limit' => 5,           // ページ内行数
        'page'  => $numberPage, // 現在のページ
    ]
);

// paginatorの現在のページを取得
$page = $paginator->getPaginate();
```

最後に、返されたページを渡して表示します:

```php
<?php

$this->view->page = $page;
```

ビュー (`app/views/products/search.volt`) では、現在のページに対応する結果を取得し、取得した全ての行が表示されます。

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
{% endraw %}
```

上記の例には、細かい部分で価値あることがたくさんあります。 まず第一に、現在のページ内のアクティブなアイテムは、Voltの`for`を使用して取得されます。 VoltはPHPの`foreach`を使うための、より簡単な構文を提供します。

```twig
{% raw %}
{% for product in page.items %}
{% endraw %}
```

PHPで同じ事は:

```php
<?php foreach ($page->items as $product) { ?>
```

`for`ブロック全体は以下を提供します:

```twig
{% raw %}
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
{% endraw %}
```

すぐにビューに戻り、すべてのブロックが何をしているのかを調べることができます。 `product`のすべてのフィールドがそれに応じて出力されます:

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

`product.id`を使用する前に見たように、PHPの場合ではこうなります: `$product->id`。`product.name`の場合も同様です。 他のフィールドは異なる方法でレンダリングされます。たとえば、`product.productTypes.name`に注目しましょう。 この部分を理解するには、Productsモデル (`app/models/Products.php`) を確認する必要があります。

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
     * Products初期処理
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

モデルは`initialize()`というメソッドを持つことができます。このメソッドはリクエストごとに1回呼び出され、ORMを使用してモデルを初期化します。 この場合、 'Products'は、このモデルが 'ProductTypes'と呼ばれる別のモデルと1対多の関係を持つことを定義することによって初期化されます。

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

つまり、`Products`の属性`product_types_id`は、`ProductTypes`モデルの`id`属性と、1対多の関係をもっています。 この関係を定義することによって、以下を使用してproductのタイプ名にアクセスできます:

```twig
{% raw %}
<td>{{ product.productTypes.name }}</td>
{% endraw %}
```

フィールド`price`は、Voltのフィルタを使用してフォーマットされて出力されています。

```twig
{% raw %}
<td>{{ '%.2f'|format(product.price) }}</td>
{% endraw %}
```

素のPHPでは、次のようになります:

```php
<?php echo sprintf('%.2f', $product->price) ?>
```

productがアクティブかどうかを表示するには、モデルに実装されているヘルパーを使用します。

```php
{% raw %}
<td>{{ product.getActiveDetail() }}</td>
{% endraw %}
```

このメソッドはモデルに定義されています。

<a name='creating-updating-records'></a>

## レコードの登録と更新

CRUDがレコードを作成し更新する方法を見てみましょう。 `new`および`edit`ビューからユーザーが入力したデータは`create`および`save`アクションに送られ、それぞれproductsの`作成`および`更新`の処理を実行します。

作成の場合、送信されたデータを取得し、新しい`Products`インスタンスに割り当てます:

```php
<?php

/**
 * 'new' アクションで入力されたデータに基づいてproductを作成
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

Productsフォームで定義したフィルタを覚えていますか？ データは、オブジェクト`$product`に割り当てられる前にフィルタリングされます。 このフィルタリングはオプションです。 ORMはまた、入力データをエスケープし、列の種類に応じて追加の変換を実行します:

```php
<?php

// ...

$name = new Text('name');

$name->setLabel('Name');

// nameをフィルタ
$name->setFilters(
    [
        'striptags',
        'string',
    ]
);

// nameのバリデーション
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

保存すると、データが`ProductsForm`フォーム (`app/forms/ProductsForm.php`)の形式で実装されたビジネスルールとバリデーションに沿っているかどうかがわかります。

```php
<?php

// ...

$form = new ProductsForm();

$product = new Products();

// 入力内容をバリデーション
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

最後に、フォームからバリデーションメッセージが返されない場合は、productインスタンスを保存できます:

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

さて、productを更新する場合は、まず編集されたレコードに現在あるデータをユーザーに表示する必要があります:

```php
<?php

/**
 * IDに紐づいたproductを編集
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

見つかったデータは、最初のパラメータとしてモデルを渡すことによってフォームにバインドされます。 これにより、ユーザーは任意の値を変更し、`save`アクションを使用してデータベースを更新することができます:

```php
<?php

/**
 * 'edit' アクションで入力されたデータに基づいてproductを更新
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

All the UI elements and visual style of the application has been achieved mostly through [Bootstrap](https://getbootstrap.com/). アプリケーションの状態に応じてナビゲーションバーなどの一部の要素が変更されます。 たとえば、ユーザーがアプリケーションにログインしている場合、右上隅にある`Log in / Sign Up`リンクは`Log out`に変わります。

アプリケーションのこの部分は、コンポーネント`Elements` (`app/library/Elements.php`) で実装されています。

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

This class extends the [Phalcon\Mvc\User\Component](api/Phalcon_Mvc_User_Component). このクラスを使ってコンポーネントを拡張することは必須ではありませんが、アプリケーションのサービスへのアクセスをスムーズにするのに役立ちます。 ここでは、最初のユーザーコンポーネントをサービスコンテナに登録します:

```php
<?php

// ユーザーコンポーネントを登録
$di->set(
    'elements',
    function () {
        return new Elements();
    }
);
```

ビュー内のコントローラ、プラグイン、コンポーネントとして、このコンポーネントは、コンテナに登録されているサービスにアクセスし、登録したサービスと同じ名前の属性にアクセスするだけでアクセスできます。

```twig
{% raw %}
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
{% endraw %}
```

重要な部分は次の箇所です:

```twig
{% raw %}
{{ elements.getMenu() }}
{% endraw %}
```

<a name='dynamic-titles'></a>

## タイトルの動的な変更

あるオプションと別のオプションを参照すると、現在作業している場所を示すタイトルが動的に変更されます。 これは、各コントローラーの初期化処理で実現されます:

```php
<?php

class ProductsController extends ControllerBase
{
    public function initialize()
    {
        // ページタイトルを指定
        $this->tag->setTitle(
            'Manage your product types'
        );

        parent::initialize();
    }

    // ...
}
```

`parent::initialize()`メソッドも呼び出され、タイトルにデータを追加します:

```php
<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        // タイトルの前にアプリケーション名を追加
        $this->tag->prependTitle('INVO | ');
    }

    // ...
}
```

最後に、メインビュー (app/views/index.volt) でタイトルを出力:

```php
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <!-- ... -->
</html>
```