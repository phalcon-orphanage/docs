<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">cookieの管理</a> <ul>
        <li>
          <a href="#usage">基本的な使い方</a>
        </li>
        <li>
          <a href="#encryption-decryption">cookieの暗号化/復号化</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# cookieの管理

[cookie](http://en.wikipedia.org/wiki/HTTP_cookie) は、たとえユーザーがブラウザーを閉じた場合でも、取得することができる、クライアントのコンピュータ上にごく少量のデータを格納する非常に便利な方法です。 `Phalcon\Http\Response\Cookies` はcookieのグローバルなバッグのように振舞います。 cookieは、リクエストの処理中にこのバッグに格納されて、リクエストのの最後に自動的に送信されます。

<a name='usage'></a>

## 基本的な使い方

アプリケーション内のどこででも、サービスにアクセスできるのであれば`cookies`サービスにアクセスするだけでcookieを設定/取得することができます:

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        // cookieがすでに設定されているかどうかを確認
        if ($this->cookies->has('remember-me')) {
            // cookieの値を取得
            $rememberMeCookie = $this->cookies->get('remember-me');

            // クッキーの値を取得
            $value = $rememberMeCookie->getValue();
        }
    }

    public function startAction()
    {
        $this->cookies->set(
            'remember-me',
            'some value',
            time() + 15 * 86400
        );
    }

    public function logoutAction()
    {
        $rememberMeCookie = $this->cookies->get('remember-me');

        // cookieを削除
        $rememberMeCookie->delete();
    }
}
```

<a name='encryption-decryption'></a>

## cookieの暗号化/復号化

デフォルトでは、cookieはクライアントに送信される前に自動的に暗号化され、ユーザーが取得する際に解読されます。 この保護は、許可されていないユーザーがcookieの内容をクライアント（ブラウザー）で見ることを防ぎます。 この保護があったとしても、機密データはクッキーに保存されてはなりません。

以下のようにして、暗号化を無効にすることができます。

```php
<?php

use Phalcon\Http\Response\Cookies;

$di->set(
    'cookies',
    function () {
        $cookies = new Cookies();

        $cookies->useEncryption(false);

        return $cookies;
    }
);
```

暗号化を使用したい場合、グローバルな鍵は [crypt](/[[language]]/[[version]]/crypt) サービスで設定しなければなりません。

```php
    <?php

    use Phalcon\Crypt;

    $di->set(
        'crypt',
        function () {
            $crypt = new Crypt();

            $crypt->setKey('#1dj8$=dp?.ak//j1V$'); // 自分の鍵を使ってください！

            return $crypt;
        }
    );
```

<h5 class='alert alert-danger'>暗号化なしに、複雑なオブジェクト、構造体、結果のセット、サービス情報などを含むクッキーデータをクライアントに送信すること は、そのアプリケーションを攻撃する攻撃者によって使用するヒントとなりうる内部のアプリケーションの詳細を晒すことになります。 もしあなたが暗号を使用したくない場合、私達は数字や短い文字列リテラルのような基本的なcookieデータだけを送信することを強く勧めます。</h5>
