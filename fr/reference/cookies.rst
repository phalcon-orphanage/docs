Cookies Management
==================
Cookies_ are very useful way to store small pieces of data in the client that can be retrieved even
if the user closes his/her browser. :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`
acts as a global bag for cookies. Cookies are stored in this bag during the request execution and are sent
automatically at the end of the request.

Basic Usage
-----------
You can set/get cookies by just accessing the 'cookies' service in any part of the application where services can be
accessed:

.. code-block:: php

    <?php

    class SessionController extends Phalcon\Mvc\Controller
    {
        public function loginAction()
        {
            // Check if the cookie has previously set
            if ($this->cookies->has('remember-me')) {

                // Get the cookie
                $rememberMe = $this->cookies->get('remember-me');

                // Get the cookie's value
                $value = $rememberMe->getValue();

            }
        }

        public function startAction()
        {
            $this->cookies->set('remember-me', 'some value', time() + 15 * 86400);
        }

        public function logoutAction()
        {
            // Delete the cookie
            $this->cookies->get('remember-me')->delete();
        }
    }

Encryption/Decryption of Cookies
--------------------------------
By default, cookies are automatically encrypted before be sent to the client and decrypted when retrieved.
This protection allow unauthorized users to see the cookies' contents in the client (browser).
Although this protection sensitive data should not be stored on cookies.

You can disable encryption in the following way:

.. code-block:: php

    <?php

    $di->set('cookies', function () {
        $cookies = new Phalcon\Http\Response\Cookies();
        $cookies->setEncryption(false);
        return $cookies;
    });

In case of using encryption a global key must be set in the 'crypt' service:

.. code-block:: php

    <?php

    $di->set('crypt', function () {
        $crypt = new Phalcon\Crypt();
        $crypt->setKey('#1dj8$=dp?.ak//j1V$'); // Use your own key!
        return $crypt;
    });


.. _Cookies : http://en.wikipedia.org/wiki/HTTP_cookie