<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Управление куками</a>
       <ul>
        <li>
          <a href="#usage">Базовое использование</a>
        </li>
        <li>
          <a href="#encryption-decryption">Шифрование/дешифрование кук</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Управление куками

[Куки](http://en.wikipedia.org/wiki/HTTP_cookie)очень полезный способ хранения маленьких фрагментов данных на стороне клиента, которые могут быть получены, даже если пользователь закроет свой браузер. `Phalcon\Http\Response\Cookies` выступает в качестве глобального хранилища для кук. Куки хранятся в таком хранилище во время выполнения запроса и отправляются автоматически по его окончанию.

<a name='usage'></a>

## Базовое использование

Вы можете установить или извлечь куки простым обращением к сервису `cookies` из любого места в приложении:

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        // Check if the cookie has previously set
        if ($this->cookies->has('remember-me')) {
            // Get the cookie
            $rememberMeCookie = $this->cookies->get('remember-me');

            // Get the cookie's value
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

        // Delete the cookie
        $rememberMeCookie->delete();
    }
}
```

<a name='encryption-decryption'></a>

## Шифрование/дешифрование кук

По умолчанию Куки автоматически шифруются перед отправкой клиенту и расшифровываются при получении. Такая защита не позволяет неавторизированным пользователям видеть содержимое кук на стороне клиента (в браузере). Но несмотря на это, хранить в них конфиденциальные (персональные) данные не следует.

Вы можете отключить шифрование следующим образом:

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

При использовании шифрования должен быть установлен глобальный ключ в сервисе [crypt](/[[language]]/[[version]]/crypt):

```php
    <?php

    use Phalcon\Crypt;

    $di->set(
        'crypt',
        function () {
            $crypt = new Crypt();

            /**
             * Set the cipher algorithm.
             *
             * The `aes-256-gcm' is the preferable cipher, but it is not usable until the
             * openssl library is upgraded, which is available in PHP 7.1.
             *
             * The `aes-256-ctr' is arguably the best choice for cipher
             * algorithm in these days.
             */
            $crypt->setCipher('aes-256-ctr');

            /**
             * Setting the encryption key.
             *
             * The key should have been previously generated in a cryptographically safe way.
             *
             * Bad key:
             * "le password"
             *
             * Better (but still unsafe):
             * "#1dj8$=dp?.ak//j1V$~%*0X"
             *
             * Good key:
             * "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c"
             *
             * Use your own key. Do not copy and paste this example key.
             */
            $key = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";

            $crypt->setKey($key);

            return $crypt;
        }
    );
```

<div class="alert alert-danger">
    <p>
        Отправка клиентам в куки без шифрования объектов со сложной структурой, наборы результатов, служебную информацию и другую подобную информацию, может раскрыть детали реализации приложения, которыми могут воспользоваться злоумышленники для взлома вашего приложения. Если вы не хотите использовать шифрование, мы настоятельно рекомендуем вам отправлять только очень простые данные, такие как числа и небольшие строки.
    </p>
</div>
