<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">cookieの管理</a>
       <ul>
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
        $this->cookies->send();
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

            /**
             * 暗号アルゴリズムの設定
             *
             * `aes-256-gcm' は好ましい暗号です。しかし opensslライブラリが
             * アップグレードされるまで利用できません。これは PHP 7.1で利用できます。
             *
             * `aes-256-ctr' は今日の暗号アルゴリズムの中で、間違いなく
             * 最高のものです。
             */
            $crypt->setCipher('aes-256-ctr');

            /**
             * 暗号鍵の設定
             *
             * この鍵は暗号学上安全な方法で、前もって生成されているものとします。
             *
             * 悪い鍵:
             * "le password"
             *
             * 少しよい鍵 (安全ではない):
             * "#1dj8$=dp?.ak//j1V$~%*0X"
             *
             * 良い鍵:
             * "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c"
             *
             * あなたの鍵を使う この例の鍵をコピーペーストしないでください。
             */
            $key = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";

            $crypt->setKey($key);

            return $crypt;
        }
    );
```

<div class="alert alert-danger">
    <p>
        暗号化なしに、複雑なオブジェクト、構造体、結果のセット、サービス情報などを含むクッキーデータをクライアントに送信すること は、そのアプリケーションを攻撃する攻撃者によって使用するヒントとなりうる内部のアプリケーションの詳細を晒すことになります。 もしあなたが暗号を使用したくない場合、私達は数字や短い文字列リテラルのような基本的なcookieデータだけを送信することを強く勧めます。
    </p>
</div>
