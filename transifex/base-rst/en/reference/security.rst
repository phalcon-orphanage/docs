%{security_e0ef2e95a1440df19d63e9e955ae6abf}%
========
%{security_559a9f19f25768b1c7d3fd048bb1440b}%

%{security_964a2cfc27d9a6128aded38b913c6f1b}%
----------------
%{security_c4051b348232ee1179906b7dfa5cb325}%

%{security_97e50a912d71f47c3fc9a4d2d602e559}%

%{security_5a90a95f09c27a892b48f618ca39e207}%

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

            //{%security_0ab97edf50fd5ec2569aa910deba8f89%}
            $user->password = $this->security->hash($password);

            $user->save();
        }

    }

%{security_c517b7bfa84e40c992a4c1cfa12d83a8}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {

        public function loginAction()
        {

            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');

            $user = Users::findFirstByLogin($login);
            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    //{%security_d6c5533d83067194760edb4307f97b3d%}
                }
            }

            //{%security_7f3aba84d7bd4d1a7655091b43a9cda6%}
        }

    }

%{security_bd4619c4495c0a9ae0993f0c89a3a4ee}%

%{security_e7b1ff65893c115cca3b6108c16ccc9c}%
--------------------------------------------
%{security_d22af5e2a1eeba75c4b48781faf0085d}%

%{security_b7e8084b42539d7c45ad1acb575cf3ef}%

.. code-block:: html+php

    <?php echo Tag::form('session/login') ?>

        <!-- login and password inputs ... -->

        <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"
            value="<?php echo $this->security->getToken() ?>"/>

    </form>

%{security_8217074a00f1ee08b580e160acd002b9}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {

        public function loginAction()
        {
            if ($this->request->isPost()) {
                if ($this->security->checkToken()) {
                    //{%security_d18843843677d4214d39430e547164b0%}
                }
            }
        }

    }

%{security_a9096615e5d0b316628d6d46d809dc17}%

.. code-block:: php

    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

%{security_d389e6c51ec7250e99f9bd4004f0e8d4}%

%{security_09fcbfa5b4310f13bfd02a2a7730defa}%
------------------------
%{security_9457196fa73d45bf471dcfe6ab181165}%

.. code-block:: php

    <?php

    $di->set('security', function(){

        $security = new Phalcon\Security();

        //{%security_655fb53228f3035a6214d0c03ff391f7%}
        $security->setWorkFactor(12);

        return $security;
    }, true);

%{security_b0492394b589b5ff8f6fb98048d65d8f}%
------------------
* {%security_1f26c7817c542777631056622af5971d%}

%{security_53c525ce454ebba9887fc2e265a32e9f}%

