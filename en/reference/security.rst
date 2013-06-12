Security
========
This component aids the developer in common security tasks such as password hashing and Cross-Site Request Forgery protection (CSRF).

Password Hashing
----------------
Storing passwords in plain text is a bad security practice. Anyone with access to the database will immediately have access to all user
accounts thus being able to engage in unauthorized activities. To combat that, many applications use the familiar one way hashing methods
“md5_” and “sha1_”. However, hardware evolves each day, and becomes faster, these algorithms are becoming vulnerable
to brute force attacks. These attacks are also known as `rainbow tables`_.

To solve this problem we can use hash algorithms as bcrypt_. Why bcrypt? Thanks to its “Eksblowfish_” key setup algorithm
we can make the password encryption as “slow” as we want. Slow algorithms make the process to calculate the real
password behind a hash extremely difficult if not impossible. This will protect your for a long time from a
possible attack using rainbow tables.

This component gives you the ability to use this algorithm in a simple way:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {

        public function registerAction()
        {

            $user = new Users();

            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');

            $user->login = $login;

            //Store the password hashed
            $user->password = $this->security->hash($password);

            $user->save();
        }

    }

We saved the password hashed with a default work factor. A higher work factor will make the password less vulnerable as
its encryption will be slow. We can check if the password is correct as follows:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {

        public function loginAction()
        {

            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');

            $user = Users::findFirst(array(
                "login = ?0",
                "bind" => array($login)
            ));
            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    //The password is valid
                }
            }

            //The validation failed
        }

    }

The salt is generated using pseudo-random bytes with the PHP's function openssl_random_pseudo_bytes_ so is required to have the openssl_ extension loaded.

Cross-Site Request Forgery (CSRF) protection
--------------------------------------------
This is another common attack against web sites and applications. Forms designed to perform tasks such as user registration or adding comments
are vulnerable to this attack.

The idea is to prevent the form values from being sent outside our application. To fix this, we generate a `random nonce`_ (token) in each
form, add the token in the session and then validate the token once the form posts data back to our application by comparing the stored
token in the session to the one submitted by the form:

.. code-block:: html+php

    <?php echo Tag::form('session/login') ?>

        <!-- login and password inputs ... -->

        <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"
            value="<?php echo $this->security->getToken() ?>"/>

    </form>

Then in the controller's action you can check if the CSRF token is valid:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {

        public function loginAction()
        {
            if ($this->request->isPost()) {
                if ($this->security->checkToken()) {
                    //The token is ok
                }
            }
        }

    }

Adding a captcha_ to the form is also recommended to completely avoid the risks of this attack.

Setting up the component
------------------------
This component is automatically registered in the services container as 'security', you can re-register it
to setup it's options:

.. code-block:: php

    <?php

    $di->set('security', function(){

        $security = new Phalcon\Security();

        //Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);

        return $security;
    }, true);

External Resources
------------------
* `Vökuró <http://vokuro.phalconphp.com>`_, is a sample application that uses the Security component for avoid CSRF and password hashing, [`Github <https://github.com/phalcon/vokuro>`_]

.. _sha1 : http://php.net/manual/en/function.sha1.php
.. _md5 : http://php.net/manual/en/function.md5.php
.. _openssl_random_pseudo_bytes : http://php.net/manual/en/function.openssl-random-pseudo-bytes.php
.. _openssl : http://php.net/manual/en/book.openssl.php
.. _captcha : http://www.google.com/recaptcha
.. _`random nonce`: http://en.wikipedia.org/wiki/Cryptographic_nonce
.. _bcrypt : http://en.wikipedia.org/wiki/Bcrypt
.. _Eksblowfish : http://en.wikipedia.org/wiki/Bcrypt#Algorithm

.. _`rainbow tables`: http://en.wikipedia.org/wiki/Rainbow_table
