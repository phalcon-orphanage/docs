安全（Security）
================

该组件可以帮助开发人员在共同安全方面的一些工作，比如密码散列和跨站点请求伪造(CSRF)保护。

密码散列（Password Hashing）
----------------------------
将密码以纯文本方式保存是一个糟糕的安全实践。任何可以访问数据库的人可立即访问所有用户账户，因此能够从事未经授权的活动。为解决这个问题，许多应用程序使用熟悉的
单向散列方法比如"md5_"和"sha1_"。然而，硬件每天都在发展，变得更快，这些算法在蛮力攻击面前变得脆弱不堪。这些攻击也被称为“彩虹表（`rainbow tables`_ ）。

为了解决这个问题我们可以使用哈希算法 bcrypt_。为什么 bcrypt？ 由于其"Eksblowfish_"键设置算法，我们可以使密码加密如同我们想要的"慢"。慢的算法使计算
Hash背后的真实密码的过程非常困难甚至不可能。这可以在一个很长一段时间内免遭可能的彩虹表攻击。

这个组件使您能够以一个简单的方法使用该算法：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function registerAction()
        {
            $user = new Users();

            $login    = $this->request->getPost("login");
            $password = $this->request->getPost("password");

            $user->login = $login;

            // Store the password hashed
            $user->password = $this->security->hash($password);

            $user->save();
        }
    }

我们保存一个用默认因子散列的密码。更高的因子可以使密码更加可靠。我们可以用如下的方法检查密码是否正确:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {
        public function loginAction()
        {
            $login    = $this->request->getPost("login");
            $password = $this->request->getPost("password");

            $user = Users::findFirstByLogin($login);
            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    // The password is valid
                }
            } else {
                // To protect against timing attacks. Regardless of whether a user exists or not, the script will take roughly the same amount as it will always be computing a hash.
                $this->security->hash(rand());
            }

            // The validation has failed
        }
    }

Salt使用PHP的 openssl_random_pseudo_bytes_ 函数的伪随机字节生成的，所以需要加载扩展 openssl_。

防止跨站点请求伪造攻击（Cross-Site Request Forgery (CSRF) protection）
----------------------------------------------------------------------
这是另一个常见的web站点和应用程序攻击。如用户注册或添加注释的这类表单就很容易受到这种攻击。

可以想到的方式防止表单值发送自外部应用程序。为了解决这个问题，我们为每个表单生成一个一次性随机令牌（`random nonce`_），在会话中添加令牌，然后一旦表单数据提交到
程序之后，将提交的数据中的的令牌和存储在会中的令牌进行比较，来验证是否合法。

.. code-block:: html+php

    <?php echo Tag::form('session/login') ?>

        <!-- Login and password inputs ... -->

        <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"
            value="<?php echo $this->security->getToken() ?>"/>

    </form>

在控制器的动作中可以检查CSRF令牌是否有效:

.. code-block:: php

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

记得添加一个会话适配器到依赖注入器中，否则令牌检查是行不通的:

.. code-block:: php

    <?php

    $di->setShared(
        "session",
        function () {
            $session = new \Phalcon\Session\Adapter\Files();

            $session->start();

            return $session;
        }
    );

同时也建议为表单添加一个 captcha_ ，以完全避免这种攻击的风险。

设置组件（Setting up the component）
------------------------------------
该组件自动在服务容器中注册为“security”,你亦可以重新注册它并为它设置参数:

.. code-block:: php

    <?php

    use Phalcon\Security;

    $di->set(
        "security",
        function () {
            $security = new Security();

            // Set the password hashing factor to 12 rounds
            $security->setWorkFactor(12);

            return $security;
        },
        true
    );

Random
------
The :doc:`Phalcon\\Security\\Random <../api/Phalcon_Security_Random>` class makes it really easy to generate lots of types of random data.

.. code-block:: php

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

    // Generate a UUID (version 4). See https://en.wikipedia.org/wiki/Universally_unique_identifier
    $uuid       = $random->uuid();

    // Generate a random integer between 0 and $n.
    $number     = $random->number($n);

外部资源（External Resources）
------------------------------
* `Vökuró <http://vokuro.phalconphp.com>`_, 是一个使用的安全组件避免CSRF和密码散列的示例应用程序 [`Github <https://github.com/phalcon/vokuro>`_]

.. _sha1: http://php.net/manual/en/function.sha1.php
.. _md5: http://php.net/manual/en/function.md5.php
.. _openssl_random_pseudo_bytes: http://php.net/manual/en/function.openssl-random-pseudo-bytes.php
.. _openssl: http://php.net/manual/en/book.openssl.php
.. _captcha: http://www.google.com/recaptcha
.. _`random nonce`: http://en.wikipedia.org/wiki/Cryptographic_nonce
.. _bcrypt: http://en.wikipedia.org/wiki/Bcrypt
.. _Eksblowfish: http://en.wikipedia.org/wiki/Bcrypt#Algorithm
.. _`rainbow tables`: http://en.wikipedia.org/wiki/Rainbow_table
