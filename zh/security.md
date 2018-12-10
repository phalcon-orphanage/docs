<div class='article-menu'>
  <ul>
    <li>
      <a href="总览">安全</a> <ul>
        <li>
          <a href="#哈希">密码哈希</a>
        </li>
        <li>
          <a href="#csrf">跨站点请求伪造 (CSRF) 保护</a>
        </li>
        <li>
          <a href="#setup">设置该组件</a>
        </li>
        <li>
          <a href="#random">随机</a>
        </li>
        <li>
          <a href="#resources">外部资源</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 安全

此组件帮助开发人员执行常见的安全任务, 如密码哈希和跨站点请求伪造保护 ([ CSRF ](https://en.wikipedia.org/wiki/Cross-site_request_forgery))。

<a name='hashing'></a>

## 密码哈希

以纯文本存储密码是一种糟糕的安全做法。 任何有权访问数据库的人都可以立即访问所有用户帐户, 从而能够从事未经授权的活动。 为了消除这种, 许多应用程序使用熟悉的单向哈希方法 "[ md5 ](http://php.net/manual/en/function.md5.php)" 和 "[ sha1 ](http://php.net/manual/en/function.sha1.php)"。 然而，硬件每天都在进化，而且速度越来越快，这些算法越来越容易受到暴力攻击。 这些攻击也被称为[彩虹表](http://en.wikipedia.org/wiki/Rainbow_table)。

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
            // To protect against timing attacks. 不管用户怎么样
            //  存在或者不存在, 脚本的使用次数基本相同
            // 它总是在计算哈希。
            $this->security->hash(rand());
        }

        // The validation has failed
    }
}
```

使用带有 PHP 函数 [ openssl_random_pseudo_bytes ](http://php.net/manual/en/function.openssl-random-pseudo-bytes.php) 的伪随机字节生成 salt, 因此需要加载 [ openssl ](http://php.net/manual/en/book.openssl.php) 扩展。

<a name='csrf'></a>

## 跨站点请求伪造 (CSRF) 保护

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

## 设置该组件

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

## 随机

`Phalcon\Security\Random`类使得生成大量随机数据变得非常容易。

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

// ...
$bytes      = $random->bytes();

//生成一个长度为$len的随机十六进制字符串。
$hex        = $random->hex($len);

// 生成一个长度为$len的随机base64字符串。
$base64     = $random->base64($len);

// 生成一个随机的url安全的长度$len的base64字符串。
$base64Safe = $random->base64Safe($len);

// 生成UUID(version 4)。
// See https://en.wikipedia.org/wiki/Universally_unique_identifier
$uuid       = $random->uuid();

// Generate a random integer between 0 and $n.
$number     = $random->number($n);
```

<a name='resources'></a>

## 外部资源

- [ Vokuro ](https://vokuro.phalconphp.com)，是一个示例应用程序，它使用安全组件来避免CSRF和密码哈希，[Github](https://github.com/phalcon/vokuro)