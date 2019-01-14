* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Cookies Management

[Cookies](https://en.wikipedia.org/wiki/HTTP_cookie) are a very useful way to store small pieces of data on the client's machine that can be retrieved even if the user closes his/her browser. `Phalcon\Http\Response\Cookies` acts as a global bag for cookies. Cookies are stored in this bag during the request execution and are sent automatically at the end of the request.

<a name='usage'></a>

## Základní použití

You can set/get cookies by just accessing the `cookies` service in any part of the application where services can be accessed:

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

## Encryption/Decryption of Cookies

By default, cookies are automatically encrypted before being sent to the client and are decrypted when retrieved from the user. This protection prevents unauthorized users to see the cookies' contents in the client (browser). Despite this protection, sensitive data should not be stored in cookies.

You can disable encryption as follows:

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

If you wish to use encryption, a global key must be set in the [crypt](/4.0/en/crypt) service:

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
             * "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\x5c"
             *
             * Use your own key. Do not copy and paste this example key.
             */
            $key = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\x5c";

            $crypt->setKey($key);

            return $crypt;
        }
    );
```

<div class="alert alert-danger">
    <p>
        Sending cookies data without encryption to clients including complex objects structures, resultsets, service information, etc. could expose internal application details that could be used by an attacker to attack the application. If you do not want to use encryption, we highly recommend you only send very basic cookie data like numbers or small string literals.
    </p>
</div>
