<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">安全</a> 
      <ul>
        <li>
          <a href="#hashing">密码哈希</a>
        </li>
        <li>
          <a href="#csrf">Cross-Site Request Forgery (CSRF) protection</a>
        </li>
        <li>
          <a href="#setup">设置该组件</a>
        </li>
        <li>
          <a href="#random">Random</a>
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

This component aids the developer in common security tasks such as password hashing and Cross-Site Request Forgery protection ([CSRF](https://en.wikipedia.org/wiki/Cross-site_request_forgery)).

<a name='hashing'></a>

## Password Hashing

Storing passwords in plain text is a bad security practice. Anyone with access to the database will immediately have access to all user accounts thus being able to engage in unauthorized activities. To combat that, many applications use the familiar one way hashing methods '[md5](http://php.net/manual/en/function.md5.php)' and '[sha1](http://php.net/manual/en/function.sha1.php)'. However, hardware evolves each day, and becomes faster, these algorithms are becoming vulnerable to brute force attacks. These attacks are also known as [rainbow tables](http://en.wikipedia.org/wiki/Rainbow_table).

安全组件使用[bcrypt](http://en.wikipedia.org/wiki/Bcrypt)作为散列算法。 通过“[Eksblowfish](http://en.wikipedia.org/wiki/Bcrypt#Algorithm)”密钥设置算法，我们可以将密码加密为`slow`”。 慢算法最小化了布鲁斯力攻击的影响。

Bcrypt是一种基于Blowfish对称分组密码算法的自适应哈希函数。 它还引入了一个安全性或工作因素，它决定了哈希函数生成哈希的速度。 这有效地否定了FPGA或GPU哈希技术的使用。

如果将来硬件变得更快，我们可以增加工作因素来缓解这个问题。

这个组件提供了一个简单的界面来使用算法:

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

        // Store the password hashed
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

## External Resources

* [Vökuró](https://vokuro.phalconphp.com), is a sample application that uses the Security component for avoid CSRF and password hashing, [Github](https://github.com/phalcon/vokuro)