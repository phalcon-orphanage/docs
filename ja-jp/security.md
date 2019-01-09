* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# セキュリティ

このコンポーネントは、パスワードハッシュやCross-Site Request Forgery ([CSRF](https://en.wikipedia.org/wiki/Cross-site_request_forgery)) 対策などの, 一般的なセキュリティタスクで開発者を支援します。

<a name='hashing'></a>

## パスワードのハッシュ

プレーンテキストでパスワードを保存することは、セキュリティ上の習慣としては不適切です。 データベースへのアクセス権を持つ人は、すぐにすべてのユーザーアカウントにアクセスし、権限がなくても行動することができてしまいます。 この問題に対処するために、多くのアプリケーションは、有名な一方向ハッシュ メソッド'[md5](http://php.net/manual/en/function.md5.php)' や '[sha1](http://php.net/manual/en/function.sha1.php) 'を使用します。 しかし、ハードウェアは毎日進化し、より高速になり、これらのアルゴリズムは総当たり攻撃に対して脆弱になっています。 これらの攻撃は、[レインボー テーブル](http://en.wikipedia.org/wiki/Rainbow_table) とも呼ばれます。

セキュリティコンポーネントは、ハッシュアルゴリズムに[bcrypt](http://en.wikipedia.org/wiki/Bcrypt) を採用しています。 その ' [Eksblowfish'](http://en.wikipedia.org/wiki/Bcrypt#Algorithm) キー設定アルゴリズムのおかげで パスワードの暗号化を望むだけ`遅く` できます。 遅いアルゴリズムは、総当たり攻撃の影響を最小限に抑えます。

Bcrypt はBlowfish 対称ブロック暗号アルゴリズムに基づく、アダプティブハッシュ関数です。 また、ハッシュ関数がハッシュを生成する速度を決定する、セキュリティまたは作業係数も導入されています。 これは、FPGAまたはGPUのハッシュ技術の使用を効果的に無効にします。

将来的にハードウェアが高速化すれば、これを軽減するために作業係数を増やすことができます。

このコンポーネントでは、このアルゴリズムを使用するシンプルなインターフェイスを提供しています。

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

We saved the password hashed with a default work factor. A higher work factor will make the password less vulnerable as its encryption will be slow. We can check if the password is correct as follows:

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

This is another common attack against web sites and applications. Forms designed to perform tasks such as user registration or adding comments are vulnerable to this attack.

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

The [Phalcon\Security\Random](api/Phalcon_Security_Random) class makes it really easy to generate lots of types of random data.

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

* [Vökuró](https://vokuro.phalconphp.com) はCSRFとパスワードハッシュ攻撃を避けるためのセキュリティコンポーネントを使うサンプルアプリケーションです。[Github](https://github.com/phalcon/vokuro)