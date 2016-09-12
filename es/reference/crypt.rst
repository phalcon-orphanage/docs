Encryption/Decryption
=====================

Phalcon provides encryption facilities via the :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>` component.
This class offers simple object-oriented wrappers to the openssl_ PHP's encryption library.

By default, this component provides secure encryption using AES-256-CFB.

.. highlights::
    You must use a key length corresponding to the current algorithm.
    For the algorithm used by default it is 32 bytes.

Basic Usage
-----------
This component is designed to provide a very simple usage:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt = new Crypt();

    $key  = "This is a secret key (32 bytes).";
    $text = "This is the text that you want to encrypt.";

    $encrypted = $crypt->encrypt($text, $key);

    echo $crypt->decrypt($encrypted, $key);

You can use the same instance to encrypt/decrypt several times:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt = new Crypt();

    $texts = [
        "my-key"    => "This is a secret text",
        "other-key" => "This is a very secret",
    ];

    foreach ($texts as $key => $text) {
        // Perform the encryption
        $encrypted = $crypt->encrypt($text, $key);

        // Now decrypt
        echo $crypt->decrypt($encrypted, $key);
    }

Encryption Options
------------------
The following options are available to change the encryption behavior:

+------------+---------------------------------------------------------------------------------------------------+
| Name       | Description                                                                                       |
+============+===================================================================================================+
| Cipher     | The cipher is one of the encryption algorithms supported by openssl. You can see a list here_     |
+------------+---------------------------------------------------------------------------------------------------+

Example:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt = new Crypt();

    // Use blowfish
    $crypt->setCipher("bf-cbc");

    $key  = "le password";
    $text = "This is a secret text";

    echo $crypt->encrypt($text, $key);

Base64 Support
--------------
In order for encryption to be properly transmitted (emails) or displayed (browsers) base64_ encoding is usually applied to encrypted texts:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt = new Crypt();

    $key  = "le password";
    $text = "This is a secret text";

    $encrypt = $crypt->encryptBase64($text, $key);

    echo $crypt->decryptBase64($encrypt, $key);

Setting up an Encryption service
--------------------------------
You can set up the encryption component in the services container in order to use it from any part of the application:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    $di->set(
        "crypt",
        function () {
            $crypt = new Crypt();

            // Set a global encryption key
            $crypt->setKey(
                "%31.1e$i86e$f!8jz"
            );

            return $crypt;
        },
        true
    );

Then, for example, in a controller you can use it as follows:

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
