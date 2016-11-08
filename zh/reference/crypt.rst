Encryption/Decryption
=====================

Phalcon通过 :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>` 组件提供了加密和解密工具。这个类提供了对PHP openssl_ 的封装。

默认情况下这个组件使用AES-256-CFB。

.. highlights::
    You must use a key length corresponding to the current algorithm.
    For the algorithm used by default it is 32 bytes.

基本使用
--------
这个组件极易使用：

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt = new Crypt();

    $key  = "This is a secret key (32 bytes).";
    $text = "This is the text that you want to encrypt.";

    $encrypted = $crypt->encrypt($text, $key);

    echo $crypt->decrypt($encrypted, $key);

也可以使用同一实例加密多次：

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // 创建实例
    $crypt = new Crypt();

    $texts = [
        "my-key"    => "This is a secret text",
        "other-key" => "This is a very secret",
    ];

    foreach ($texts as $key => $text) {
        // 加密
        $encrypted = $crypt->encrypt($text, $key);

        // 解密
        echo $crypt->decrypt($encrypted, $key);
    }

加密选项（Encryption Options）
------------------------------
下面的选项可以改变加密的行为：

+------------+------------------------------------------------------------------+
| 名称       | 描述                                                             |
+============+==================================================================+
| Cipher     | cipher是libmcrypt提供支持的一种加密算法。 查看这里 here_         |
+------------+------------------------------------------------------------------+

例子:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // 创建实例
    $crypt = new Crypt();

    // 使用 blowfish
    $crypt->setCipher("bf-cbc");

    $key  = "le password";
    $text = "This is a secret text";

    echo $crypt->encrypt($text, $key);

提供 Base64（Base64 Support）
-----------------------------
为了方便传输或显示我们可以对加密后的数据进行 base64_ 转码：

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // 创建实例
    $crypt = new Crypt();

    $key  = "le password";
    $text = "This is a secret text";

    $encrypt = $crypt->encryptBase64($text, $key);

    echo $crypt->decryptBase64($encrypt, $key);

配置加密服务（Setting up an Encryption service）
------------------------------------------------
你也可以把加密组件放入服务容器中这样我们可以在应用中的任何一个地方访问这个组件：

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    $di->set(
        'crypt',
        function () {
            $crypt = new Crypt();

            // 设置全局加密密钥
            $crypt->setKey(
                "%31.1e$i86e$f!8jz"
            );

            return $crypt;
        },
        true
    );

然后，例如，我们可以在控制器中使用它了：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SecretsController extends Controller
    {
        public function saveAction()
        {
            $secret = new Secrets();

            $text = $this->request->getPost("text");

            $secret->content = $this->crypt->encrypt($text);

            if ($secret->save()) {
                $this->flash->success(
                    "Secret was successfully created!"
                );
            }
        }
    }

.. _openssl: http://www.php.net/manual/en/book.openssl.php
.. _here: http://www.php.net/manual/en/function.openssl-get-cipher-methods.php
.. _base64: http://www.php.net/manual/en/function.base64-encode.php
