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

プレーンテキストでパスワードを保存することは、セキュリティ上の習慣としては不適切です。 データベースへのアクセス権を持つ人は、すぐにすべてのユーザーアカウントにアクセスし、権限がなくても行動することができてしまいます。 この問題に対処するために、多くのアプリケーションは、有名な一方向ハッシュ メソッド'[md5](http://php.net/manual/en/function.md5.php)' や '[sha1](http://php.net/manual/en/function.sha1.php) 'を使用します。 しかし、ハードウェアは毎日進化し、より高速になり、これらのアルゴリズムは総当たり攻撃に対して脆弱になっています。 これらの攻撃は、[レインボーテーブル](http://en.wikipedia.org/wiki/Rainbow_table) とも呼ばれます。

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
                // The password is valid
            }
        } else {
            // To protect against timing attacks. Regardless of whether a user
            // exists or not, the script will take roughly the same amount as
            // it will always be computing a hash.
            $this->security->hash(rand());
        }

        // The validation has failed
    }
}
```

The salt is generated using pseudo-random bytes with the PHP's function [openssl_random_pseudo_bytes](http://php.net/manual/en/function.openssl-random-pseudo-bytes.php) so is required to have the [openssl](http://php.net/manual/en/book.openssl.php) extension loaded.

<a name='csrf'></a>

## Cross-Site Request Forgery (CSRF) の保護

This is another common attack against web sites and applications. Forms designed to perform tasks such as user registration or adding comments are vulnerable to this attack.

The idea is to prevent the form values from being sent outside our application. To fix this, we generate a [random nonce](http://en.wikipedia.org/wiki/Cryptographic_nonce) (token) in each form, add the token in the session and then validate the token once the form posts data back to our application by comparing the stored token in the session to the one submitted by the form:

```php
<?php echo Tag::form('session/login') ?>

    <!-- Login and password inputs ... -->

    <input type='hidden' name='<?php echo $this->security->getTokenKey() ?>'
        value='<?php echo $this->security->getToken() ?>'/>

</form>
```

Then in the controller's action you can check if the CSRF token is valid:

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                // The token is OK
            }
        }
    }
}
```

Remember to add a session adapter to your Dependency Injector, otherwise the token check won't work:

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

Adding a [captcha](http://www.google.com/recaptcha) to the form is also recommended to completely avoid the risks of this attack.

<a name='setup'></a>

## コンポーネントの設定

This component is automatically registered in the services container as `security`, you can re-register it to setup its options:

```php
<?php

use Phalcon\Security;

$di->set(
    'security',
    function () {
        $security = new Security();

        // Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);

        return $security;
    },
    true
);
```

<a name='random'></a>

## 乱数

The `Phalcon\Security\Random` class makes it really easy to generate lots of types of random data.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

// ...
$bytes      = $random->bytes();

// Generate a random hex string of length $len.
$hex        = $random->hex($len);

// Generate a random base64 string of length $len.
$base64     = $random->base64($len);

// Generate a random URL-safe base64 string of length $len.
$base64Safe = $random->base64Safe($len);

// Generate a UUID (version 4).
// See https://en.wikipedia.org/wiki/Universally_unique_identifier
$uuid       = $random->uuid();

// Generate a random integer between 0 and $n.
$number     = $random->number($n);
```

<a name='resources'></a>

## 外部リソース

- [Vökuró](https://vokuro.phalconphp.com), is a sample application that uses the Security component for avoid CSRF and password hashing, [Github](https://github.com/phalcon/vokuro)