%{session_961ade92d171ac826834b6f63182e0b1}%
=======================
%{session_b9582f2bd8e772e6946609d88c33af10|:doc:`Phalcon\\Session <../api/Phalcon_Session>`}%

%{session_38d2fe6e9c58265de29d17ae9b99a96b}%

* {%session_a2db5644ceaeb65c4119ad98b8442d57%}
* {%session_6d6fbd30d8f41b93139a5b54def291a6%}
* {%session_1b9e74d9e73da4617b8994f10942160b%}

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
%{session_87ec8cb4e8370ad36c308f9df4267121|:doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>`}%

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
%{session_0984532cbe02c59931523ca2d6309f3d|:doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`}%

.. code-block:: php

    <?php

    $user       = new Phalcon\Session\Bag('user');
    $user->setDI($di);
    $user->name = "Kimbra Johnson";
    $user->age  = 22;



%{session_e19c5c57ed64b3c3b7b34a9e22e1ebaa}%
-----------------------------
%{session_030dee748e8517caa90f774c3ab0e157|:doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>`|:doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`}%

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
%{session_8d76ebf6ce9c56b07418472e0ee234b0|:doc:`Phalcon\\Session\\AdapterInterface <../api/Phalcon_Session_AdapterInterface>`}%

