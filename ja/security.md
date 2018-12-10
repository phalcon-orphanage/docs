<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">セキュリティ</a> <ul>
        <li>
          <a href="#hashing">パスワードのハッシュ</a>
        </li>
        <li>
          <a href="#csrf">Cross-Site Request Forgery (CSRF) の保護</a>
        </li>
        <li>
          <a href="#setup">コンポーネントの設定</a>
        </li>
        <li>
          <a href="#random">乱数</a>
        </li>
        <li>
          <a href="#resources">外部リソース</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# セキュリティ

このコンポーネントは、パスワードハッシュやCross-Site Request Forgery ([CSRF](https://en.wikipedia.org/wiki/Cross-site_request_forgery)) 対策などの, 一般的なセキュリティタスクで開発者を支援します。

<a name='hashing'></a>

## パスワードのハッシュ

プレーンテキストでパスワードを保存することは、セキュリティ上の習慣としては不適切です。 データベースへのアクセス権を持つ人は、すぐにすべてのユーザーアカウントにアクセスし、権限がなくても行動することができてしまいます。 この問題に対処するために、多くのアプリケーションは、有名な一方向ハッシュ メソッド'[md5](http://php.net/manual/en/function.md5.php)' や '[sha1](http://php.net/manual/en/function.sha1.php) 'を使用します。 しかし、ハードウェアは毎日進化し、より高速になり、これらのアルゴリズムは総当たり攻撃に対して脆弱になっています。 これらの攻撃は、[レインボー テーブル](http://en.wikipedia.org/wiki/Rainbow_table) とも呼ばれます。

この問題を解決するために、[bcrypt](http://en.wikipedia.org/wiki/Bcrypt) ハッシュ アルゴリズムを使用できます。 なぜ bcryptか? その ' [Eksblowfish'](http://en.wikipedia.org/wiki/Bcrypt#Algorithm) キー設定アルゴリズムのおかげで パスワードの暗号化を望むだけ '遅く' できます。 遅いアルゴリズムは、不可能ではないにしても、ハッシュの背後にある本当のパスワードを計算するプロセスを非常に困難にします。 これにより、レインボーテーブルを使った攻撃から長い時間あなたを守ることができます。

このコンポーネントを使用すると、このアルゴリズムを簡単な方法で使用できます:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function registerAction()
    {
        $user = new Users();

        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user->login = $login;

        // パスワードのハッシュの保存
        $user->password = $this->security->hash($password);

        $user->save();
    }
}
```

デフォルトの作業係数でパスワードのハッシュを保存します。より高い作業係数により暗号化が遅くなれば、パスワードの脆弱性が低くなります。パスワードが正しいかどうかを次のように確認できます。

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user = Users::findFirstByLogin($login);
        if ($user) {
            if ($this->security->checkHash($password, $user->password)) {
                // パスワード有効
            }
        } else {
            // タイミング攻撃への対応 ユーザーの有無に関わらず、
            // このスクリプトは常にハッシュ計算と
            // 同程度の時間をかける
            $this->security->hash(rand());
        }

        // バリデーション失敗時
    }
}
```

[openssl_random_pseudo_bytes](http://php.net/manual/en/function.openssl-random-pseudo-bytes.php)という PHPの関数により疑似乱数で saltを生成します。このためには [openssl](http://php.net/manual/en/book.openssl.php) 拡張モジュールのロードが必要です。

<a name='csrf'></a>

## Cross-Site Request Forgery (CSRF) の保護

これは、Webサイトやアプリケーションに対するもう1つの一般的な攻撃です。 ユーザーの登録やコメントの追加などのタスクを実行するように設計されたフォームは、この攻撃に対して脆弱です。

そのアイデアは、フォームの値がアプリケーションの外部に送信されないようにすることです。 この問題への対処として、各フォームで[random nonce](http://en.wikipedia.org/wiki/Cryptographic_nonce) （トークン）を生成し、トークンをセッションに保存します。それから、フォームから送信されたトークンと、セッションに保存していたトークンを比較して検証します: 

```php
<?php echo Tag::form('session/login') ?>

    <!-- ログイン と パスワードの入力 ... -->

    <input type='hidden' name='<?php echo $this->security->getTokenKey() ?>'
        value='<?php echo $this->security->getToken() ?>'/>

</form>
```

このコントローラのアクションでは、CSRFトークンが有効かどうかを確認できます:

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                // トークンOK
            }
        }
    }
}
```

セッションアダプターをあなたのDIに追加するのを忘れないでください。そうしないと、このトークンチェックは動作しません。

```php
<?php

$di->setShared(
    'session',
    function () {
        $session = new \Phalcon\Session\Adapter\Files();

        $session->start();

        return $session;
    }
);
```

[captcha](http://www.google.com/recaptcha)をフォームに追加することも、この攻撃のリスクを完全に回避できるのでお勧めです。

<a name='setup'></a>

## コンポーネントの設定

このコンポーネントは`security`としてサービスコンテナに自動的に登録されます。オプションを設定するために再登録することができます:

```php
<?php

use Phalcon\Security;

$di->set(
    'security',
    function () {
        $security = new Security();

        // パスワードハッシュの係数を12ラウンドに設定
        $security->setWorkFactor(12);

        return $security;
    },
    true
);
```

<a name='random'></a>

## 乱数

`Phalcon\Security\Random` クラスは、本当に簡単に、さまざまな種類のランダムなデータを生成します。

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

// ...
$bytes      = $random->bytes();

// 長さ $len の ランダム16進数文字列の生成
$hex        = $random->hex($len);

// 長さ $len のbase64文字列の生成
$base64     = $random->base64($len);

// 長さ $len の URL-safeなbase64文字列の生成
$base64Safe = $random->base64Safe($len);

// UUID (version 4) の生成
// 詳細については以下を参照してください https://en.wikipedia.org/wiki/Universally_unique_identifier
$uuid       = $random->uuid();

// 0 から $n の間の乱数の生成
$number     = $random->number($n);
```

<a name='resources'></a>

## 外部リソース

- [Vökuró](https://vokuro.phalconphp.com) はCSRFとパスワードハッシュ攻撃を避けるためのセキュリティコンポーネントを使うサンプルアプリケーションです。[Github](https://github.com/phalcon/vokuro)