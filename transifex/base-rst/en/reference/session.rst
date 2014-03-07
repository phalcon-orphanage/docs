%{session_961ade92d171ac826834b6f63182e0b1}%
=======================
%{session_56daaf4c7a750ae3122b3e809deba99f}%

%{session_38d2fe6e9c58265de29d17ae9b99a96b}%

%{session_79b4a7a8ea5fc2107c2ea9b73f365dae}%

%{session_61d74fee93771ffdddeab2a05d73d187}%
--------------------
%{session_c036a3eb6338211e378a3e7b6e1699fa}%

.. code-block:: php

    <?php

    //{%session_f700b9cef8843a4ab8f824640f637637%}
    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

%{session_abc90f1094f9dbe4b58d5a265c369631}%
----------------------------------
%{session_231c5d26b99f3ebcb4c7d4fa58173200}%

.. code-block:: php

    <?php

    class UserController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            //{%session_fda95d2732416a25a000e397454ec98b%}
            $this->session->set("user-name", "Michael");
        }

        public function welcomeAction()
        {

            //{%session_982181258da22edbf3bb53590b36053c%}
            if ($this->session->has("user-name")) {

                //{%session_ee433eaada1b253c7e95e182f476cdae%}
                $name = $this->session->get("user-name");
            }
        }

    }

%{session_02fd8072d25fb0bc8a802a753f8714a2}%
----------------------------
%{session_74cbe7902d402d8c9a49df86d72665b8}%

.. code-block:: php

    <?php

    class UserController extends Phalcon\Mvc\Controller
    {

        public function removeAction()
        {
            //{%session_262d69448626454d1e163b4b515dd963%}
            $this->session->remove("user-name");
        }

        public function logoutAction()
        {
            //{%session_35837c66952906c2e7f1e3e0626e47b3%}
            $this->session->destroy();
        }

    }

%{session_628bce7a00ed8678f1687552bce2c536}%
-------------------------------------------
%{session_5cc00375b165d0d4f0c8aa130b12e07d}%

.. code-block:: php

    <?php

    //{%session_0390f99e84e91d9289ec90111a12944f%}
    $di->set('session', function(){

        //{%session_cebed604aa5015b17aab37dc330ea8c8%}
        $session = new Phalcon\Session\Adapter\Files(
            array(
                'uniqueId' => 'my-app-1'
            )
        );

        $session->start();

        return $session;
    });

%{session_9f2d377c6b1d6a3308b97290c79339b2}%
------------
%{session_b610736ecc58a9c50fb6048524b03ba2}%

.. code-block:: php

    <?php

    $user       = new Phalcon\Session\Bag('user');
    $user->setDI($di);
    $user->name = "Kimbra Johnson";
    $user->age  = 22;


%{session_e19c5c57ed64b3c3b7b34a9e22e1ebaa}%
-----------------------------
%{session_7aa6ce2eeaa1521067a8e46555fc143c}%

.. code-block:: php

    <?php

    class UserController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            // {%session_e6e14abeec0ee634ee4ff9f356bb8333%}
            $this->persistent->name = "Laura";
        }

        public function welcomeAction()
        {
            if (isset($this->persistent->name))
            {
                echo "Welcome, ", $this->persistent->name;
            }
        }

    }

%{session_7c0521393288a294669cf9d6429a9452}%

.. code-block:: php

    <?php

    class Security extends Phalcon\Mvc\User\Component
    {

        public function auth()
        {
            // {%session_e6e14abeec0ee634ee4ff9f356bb8333%}
            $this->persistent->name = "Laura";
        }

        public function getAuthName()
        {
            return $this->persistent->name;
        }

    }

%{session_ff9875bf58f62ce9648ffc3204ab1753}%

%{session_206bd6266ccc781d8844f3db2de5d557}%
------------------------------
%{session_48588cac7e0db092898287389fcf5296}%

