* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# セッションにデータを保存する

セッションコンポーネントは、セッションデータにアクセスする、オブジェクト指向のラッパーを提供します。

直接セッションを使用せずにコンポーネントを使う理由:

* 同じドメイン上のアプリケーション間で簡単にセッションデータを分離できます
* セッションデータがアプリケーションで設定/取得されるところへ割り込み
* アプリケーションのニーズに応じてセッションアダプターを変更

<a name='start'></a>

## セッションの開始

アプリケーションによってはセッション集約型のものがあり、実行するほとんどすべての処理でセッションデータへのアクセスが必要です。 セッションデータに無意識にアクセスする人もいます。 サービスコンテナのおかげで、セッションが明らかに必要なときにのみセッションにアクセスできるようにすることができます:

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// なんらかのコンポーネントがセッションサービスを要求する最初の時にセッションを開始
$di->setShared(
    'session',
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);
```

<a name='start-factory'></a>

## Factory

`adaper`オプションを使用してSession Adapterクラスをロードします

```php
<?php

use Phalcon\Session\Factory;

$options = [
    'uniqueId'   => 'my-private-app',
    'host'       => '127.0.0.1',
    'port'       => 11211,
    'persistent' => true,
    'lifetime'   => 3600,
    'prefix'     => 'my_',
    'adapter'    => 'memcache',
];

$session = Factory::load($options);
$session->start();
```

<a name='store'></a>

## セッションへのデータ保存と取得

From a controller, a view or any other component that extends [Phalcon\Di\Injectable](api/Phalcon_Di_Injectable) you can access the session service and store items and retrieve them in the following way:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // セッシュン変数のセット
        $this->session->set('user-name', 'Michael');
    }

    public function welcomeAction()
    {
        // この変数が定義されているかを確認
        if ($this->session->has('user-name')) {
            // その値を取得
            $name = $this->session->get('user-name');
        }
    }

}
```

<a name='remove-destroy'></a>

## セッションの削除と破棄

また、特定の変数の削除やセッション全体の破棄が可能です。

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function removeAction()
    {
        // セッション変数の削除
        $this->session->remove('user-name');
    }

    public function logoutAction()
    {
        // セッション全体の破棄
        $this->session->destroy();
    }
}
```

<a name='data-isolation'></a>

## アプリケーション間のセッションデータの分離

ユーザーは同じサーバーの同じセッションで、同じアプリケーションを二回使うこともあります。 確かに、セッションで変数を使用する場合、すべてのアプリケーションが別のセッションデータを持っていることを望みます (しかし、同じコードで同じ変数名です)。 この問題を解決するため、あなたは特定のアプリケーションに作成したそれぞれのセッシュン変数にプレフィックスを追加できます。

```php
<?php

use Phalcon\Session\Adapter\Files as Session;

// セッションデータの隔離
$di->set(
    'session',
    function () {
        // 作成した全ての変数に 'my-app-1' とプレフィックスを追加
        $session = new Session(
            [
                'uniqueId' => 'my-app-1',
            ]
        );

        $session->start();

        return $session;
    }
);
```

ユニークIDの追加は必須ではありません。

<a name='bags'></a>

## セッションバッグ

[Phalcon\Session\Bag](api/Phalcon_Session_Bag) is a component that helps separating session data into `namespaces`. この方法で、セッシュン変数のグループをアプリケーションに簡単に作成できます。 `bag</ 0>の変数を設定するだけで、自動的にセッションに格納されます:</p>

<pre><code class="php"><?php

use Phalcon\Session\Bag as SessionBag;

$user = new SessionBag('user');

$user->setDI($di);

$user->name = 'Kimbra Johnson';
$user->age  = 22;
`</pre> 

<a name='data-persistence'></a>

## コンポーネントの不揮発性データ

Controller, components and classes that extends [Phalcon\Di\Injectable](api/Phalcon_Di_Injectable) may inject a [Phalcon\Session\Bag](api/Phalcon_Session_Bag). このクラスはそれぞれのクラスで変数を隔離します。 これのおかげで、それぞれの方法のすべてのクラスでリクエスト間でデータを保持できます。

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        // persistent 変数 'name' の作成
        $this->persistent->name = 'Laura';
    }

    public function welcomeAction()
    {
        if (isset($this->persistent->name)) {
            echo 'Welcome, ', $this->persistent->name;
        }
    }
}
```

コンポーネント内:

```php
<?php

use Phalcon\Mvc\User\Component;

class Security extends Component
{
    public function auth()
    {
        // persistent 変数 'name' の作成
        $this->persistent->name = 'Laura';
    }

    public function getAuthName()
    {
        return $this->persistent->name;
    }
}
```

このセッシュンに追加したデータ(`$this->session`)はそのアプリケーション内で利用可能です。一方persistent (`$this->persistent`) は現在のクラスのスコープ内でのみアクセス可能です。

<a name='custom-adapters'></a>

## Implementing your own adapters

The [Phalcon\Session\AdapterInterface](api/Phalcon_Session_AdapterInterface) interface must be implemented in order to create your own session adapters or extend the existing ones.

[Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter) には、このコンポーネントを利用するための複数のアダプターが用意されています。