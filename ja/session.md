<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">セッションにデータを保存する</a> <ul>
        <li>
          <a href="#start">セッションの開始</a>
        </li>
        <li>
          <a href="#store">セッションへのデータ保存と取得</a>
        </li>
        <li>
          <a href="#remove-destroy">セッションの削除と破棄</a>
        </li>
        <li>
          <a href="#data-isolation">アプリケーション間のセッションデータの分離</a>
        </li>
        <li>
          <a href="#bags">セッションバッグ</a>
        </li>
        <li>
          <a href="#data-persistency">コンポーネントの不揮発性データ</a>
        </li>
        <li>
          <a href="#custom-adapters">独自のアダプターを実装</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# セッションにデータを保存する

セッションコンポーネントは、セッションデータにアクセスする、オブジェクト指向のラッパーを提供します。

直接セッションを使用せずにコンポーネントを使う理由:

- 同じドメイン上のアプリケーション間で簡単にセッションデータを分離できます
- セッションデータがアプリケーションで設定/取得されるところへ割り込み
- アプリケーションのニーズに応じてセッションアダプターを変更

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

<a name='store'></a>

## セッションへのデータ保存と取得

コントローラ、ビュー、または`Phalcon\Di\Injectable`を拡張する他のコンポーネントから、セッションサービスにアクセスしてアイテムを格納し、次のように取得できます:

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

`Phalcon\Session\Bag` はセッシュンデータを `namespaces` に分離することができるコンポーネントです。 この方法で、セッシュン変数のグループをアプリケーションに簡単に作成できます。 `bag</ 0>の変数を設定するだけで、自動的にセッションに格納されます:</p>

<pre><code class="php"><?php

use Phalcon\Session\Bag as SessionBag;

$user = new SessionBag('user');

$user->setDI($di);

$user->name = 'Kimbra Johnson';
$user->age  = 22;
`</pre> 

<a name='data-persistency'></a>

## コンポーネントの不揮発性データ

`Phalcon\Di\Injectable` を拡張する、コント ローラー、コンポーネント、クラスは、 `Phalcon\Session\Bag`を挿入する可能性があります。 このクラスはそれぞれのクラスで変数を隔離します。 これのおかげで、それぞれの方法のすべてのクラスでリクエスト間でデータを保持できます。

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

## 独自のアダプターを実装

独自のセッションアダプターを作成したり、既存のセッションアダプターを拡張するには、`Phalcon\Session\AdapterInterface`インターフェースを実装する必要があります。

[Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Session/Adapter) には、このコンポーネントを利用するための複数のアダプターが用意されています。