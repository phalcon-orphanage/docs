* * *

layout: default language: 'en' version: '4.0'

* * *

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

我们用默认的工作因子保存了哈希的密码。更高的工作因素将使密码不易受到攻击, 因为其加密速度会很慢。我们可以检查密码是否正确, 如下所示:

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

使用带有 PHP 函数 [ openssl_random_pseudo_bytes ](http://php.net/manual/en/function.openssl-random-pseudo-bytes.php) 的伪随机字节生成 salt, 因此需要加载 [ openssl ](http://php.net/manual/en/book.openssl.php) 扩展。

<a name='csrf'></a>

## Cross-Site Request Forgery (CSRF) protection

这是针对web站点和应用程序的另一种常见攻击。用于执行用户注册或添加评论等任务的表单很容易受到这种攻击。

其思想是防止表单值被发送到应用程序之外。 为了解决这个问题，我们在每个表单中生成一个[random nonce](http://en.wikipedia.org/wiki/Cryptographic_nonce) (token)，在会话中添加令牌，然后在表单将数据发送回应用程序时验证令牌，将会话中的存储令牌与表单提交的令牌进行比较:

```php
<?php echo Tag::form('session/login') ?>

    <!-- Login and password inputs ... -->

    <input type='hidden' name='<?php echo $this->security->getTokenKey() ?>'
        value='<?php echo $this->security->getToken() ?>'/>

</form>
```

然后在控制器的操作中，您可以检查CSRF令牌是否有效:

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

记住要向依赖注入器添加会话适配器，否则令牌检查将不起作用:

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

还建议在表单中添加[captcha](http://www.google.com/recaptcha)，以完全避免这种攻击的风险。

<a name='setup'></a>

## Setting up the component

此组件在服务容器中自动注册为`security`，您可以重新注册它来设置它的选项:

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

## External Resources

* [Vökuró](https://vokuro.phalconphp.com), is a sample application that uses the Security component for avoid CSRF and password hashing, [Github](https://github.com/phalcon/vokuro)