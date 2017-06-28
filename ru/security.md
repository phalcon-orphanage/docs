<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Безопасность</a> <ul>
        <li>
          <a href="#hashing">Хэширование паролей</a>
        </li>
        <li>
          <a href="#csrf">Защита от Cross-Site Request Forgery (CSRF)</a>
        </li>
        <li>
          <a href="#setup">Настройка компонента</a>
        </li>
        <li>
          <a href="#random">Компонент Random</a>
        </li>
        <li>
          <a href="#resources">External Resources</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Security

Этот компонент помогает разработчику в общих задачах обеспечения безопасности, таких как хеширование паролей и защите от атак вида Cross-Site Request Forgery ([CSRF](https://en.wikipedia.org/wiki/Cross-site_request_forgery)).

<a name='hashing'></a>

## Password Hashing

Хранение паролей в открытом виде является плохой практикой. Любой, кто имеет доступ к базе данных, мгновенно получит доступ ко всем пользовательским аккаунтам и, таким образом, получает возможность производить неавторизованные действия. Для противостояния этому, многие приложения используют знакомые методы одностороннего хеширования вроде '[md5](http://php.net/manual/en/function.md5.php)' и '[sha1](http://php.net/manual/en/function.sha1.php)'. Однако аппаратное обеспечение развивается с каждым днем, становится быстрее, и эти алгоритмы становятся уязвимы к атакам методом перебора. Данные атаки также известны как [радужные таблицы](http://en.wikipedia.org/wiki/Rainbow_table).

Для решения этой проблемы, мы можем использовать такие алгоритмы хеширования, как [bcrypt](http://en.wikipedia.org/wiki/Bcrypt). Почему bcrypt? Благодаря алгоритму установки ключа '[Eksblowfish](http://en.wikipedia.org/wiki/Bcrypt#Algorithm)' мы можем сделать шифрование пароля настолько "медленным", насколько мы этого захотим. Медленные алгоритмы делают процесс вычисления настоящего пароля, скрытого за хешем, крайне сложным, если не невозможным. Это защитит вас на долгое время от возможных атак с использованием радужных таблиц.

Этот компонент дает вам возможность простым способом использовать данный алгоритм:

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

Мы сохранили пароль хешированным с коэффициентом хеширования по-умолчанию. Более высокий коэффициент хеширования сделает пароль менее уязвимым, так как его шифрование будет медленным. Мы можем проверить правильность пароля следующим способом:

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

The salt is generated using pseudo-random bytes with the PHP's function [openssl_random_pseudo_bytes](http://php.net/manual/en/function.openssl-random-pseudo-bytes.php) so is required to have the [openssl](http://php.net/manual/en/book.openssl.php) extension loaded.

<a name='csrf'></a>

## Cross-Site Request Forgery (CSRF) protection

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

## Setting up the component

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

## Random

Класс `Phalcon\Security\Random` позволяет очень легко генерировать много разных типов случайных данных.

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

## External Resources

- [Vökuró](https://vokuro.phalconphp.com), is a sample application that uses the Security component for avoid CSRF and password hashing, [Github](https://github.com/phalcon/vokuro)