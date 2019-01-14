* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Безопасность

Этот компонент помогает разработчику в общих задачах обеспечения безопасности, таких как хеширование паролей и защите от атак вида Cross-Site Request Forgery ([CSRF](https://en.wikipedia.org/wiki/Cross-site_request_forgery)).

<a name='hashing'></a>

## Хэширование паролей

Хранение паролей в открытом виде является плохой практикой. Любой, кто имеет доступ к базе данных, мгновенно получит доступ ко всем пользовательским аккаунтам и, таким образом, получает возможность производить неавторизованные действия. To combat that, many applications use the familiar one way hashing methods '[md5](https://php.net/manual/en/function.md5.php)' and '[sha1](https://php.net/manual/en/function.sha1.php)'. Однако аппаратное обеспечение развивается с каждым днем, становится быстрее, и эти алгоритмы становятся уязвимы к атакам методом перебора. These attacks are also known as [rainbow tables](https://en.wikipedia.org/wiki/Rainbow_table).

The security component uses [bcrypt](https://en.wikipedia.org/wiki/Bcrypt) as the hashing algorithm. Thanks to the '[Eksblowfish](https://en.wikipedia.org/wiki/Bcrypt#Algorithm)' key setup algorithm, we can make the password encryption as `slow` as we want. Slow algorithms minimize the impact of bruce force attacks.

Bcrypt, is an adaptive hash function based on the Blowfish symmetric block cipher cryptographic algorithm. It also introduces a security or work factor, which determines how slow the hash function will be to generate the hash. This effectively negates the use of FPGA or GPU hashing techniques.

Should hardware becomes faster in the future, we can increase the work factor to mitigate this.

This component offers a simple interface to use the algorithm:

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

        // Сохраняем пароль хэшированным
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
                // Пароль верный
            }
        } else {
            // Защита от атак по времени. Regardless of whether a user
            // exists or not, the script will take roughly the same amount as
            // it will always be computing a hash.
            $this->security->hash(rand());
        }

        // The validation has failed
    }
}
```

The salt is generated using pseudo-random bytes with the PHP's function [openssl_random_pseudo_bytes](https://php.net/manual/en/function.openssl-random-pseudo-bytes.php) so is required to have the [openssl](https://php.net/manual/en/book.openssl.php) extension loaded.

<a name='csrf'></a>

## Защита от Cross-Site Request Forgery (CSRF)

This is another common attack against web sites and applications. Forms designed to perform tasks such as user registration or adding comments are vulnerable to this attack.

The idea is to prevent the form values from being sent outside our application. To fix this, we generate a [random nonce](https://en.wikipedia.org/wiki/Cryptographic_nonce) (token) in each form, add the token in the session and then validate the token once the form posts data back to our application by comparing the stored token in the session to the one submitted by the form:

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

Adding a [captcha](https://www.google.com/recaptcha) to the form is also recommended to completely avoid the risks of this attack.

<a name='setup'></a>

## Настройка компонента

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

## Компонент Random

The [Phalcon\Security\Random](api/Phalcon_Security_Random) class makes it really easy to generate lots of types of random data.

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

## Дополнительная литература

* [Vökuró](https://vokuro.phalconphp.com), is a sample application that uses the Security component for avoid CSRF and password hashing, [Github](https://github.com/phalcon/vokuro)