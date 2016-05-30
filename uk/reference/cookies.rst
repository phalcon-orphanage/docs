Cookies Management
==================

Cookies_ are a very useful way to store small pieces of data on the client's machine that can be retrieved even
if the user closes his/her browser. :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`
acts as a global bag for cookies. Cookies are stored in this bag during the request execution and are sent
automatically at the end of the request.

Basic Usage
-----------
You can set/get cookies by just accessing the 'cookies' service in any part of the application where services can be
accessed:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {
        public function loginAction()
        {
            // Check if the cookie has previously set
            if ($this->cookies->has('remember-me')) {

                // Get the cookie
                $rememberMe = $this->cookies->get('remember-me');

                // Get the cookie's value
                $value      = $rememberMe->getValue();
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
By default, cookies are automatically encrypted before being sent to the client and are decrypted when retrieved from the user.
This protection allows unauthorized users to see the cookies' contents in the client (browser).
Despite this protection, sensitive data should not be stored in cookies.

You can disable encryption in the following way:

.. code-block:: php

    <?php

    use Phalcon\Http\Response\Cookies;

    $di->set('cookies', function () {
        $cookies = new Cookies();

        $cookies->useEncryption(false);

        return $cookies;
    });

If you wish to use encryption, a global key must be set in the 'crypt' service:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    $di->set('crypt', function () {
        $crypt = new Crypt();

        $crypt->setKey('#1dj8$=dp?.ak//j1V$'); // Use your own key!

        return $crypt;
    });

.. highlights::

    Sending cookies data without encryption to clients including complex objects structures, resultsets,
    service information, etc. could expose internal application details that could be used by an attacker
    to attack the application. If you do not want to use encryption, we highly recommend you only send very
    basic cookie data like numbers or small string literals.

.. _Cookies: http://en.wikipedia.org/wiki/HTTP_cookie
