%{cookies_2bc6eb5dcb5fc829123a7ef49f094b59}%
==================
%{cookies_37ba613bc19059e2b198dd55b1d80cdc|Cookies_ }%

%{cookies_b0320f4a950d93f7f09a91c29ce5132b}%
-----------
%{cookies_81f9971fb3a1d23601430671ff54a629}%

.. code-block:: php

    <?php

    class SessionController extends Phalcon\Mvc\Controller
    {
        public function loginAction()
        {
            //{%cookies_a912fae0257816ab039dfbb5b51b10e0%}
            if ($this->cookies->has('remember-me')) {

                //{%cookies_328b0799bfc67eec8628bfce07966a2e%}
                $rememberMe = $this->cookies->get('remember-me');

                //{%cookies_29b453b5f5336185352c0488cdac3a19%}
                $value = $rememberMe->getValue();

            }
        }

        public function startAction()
        {
            $this->cookies->set('remember-me', 'some value', time() + 15 * 86400);
        }
    }


%{cookies_48634baf01678a8c66fbd3bf5b695a29}%
--------------------------------
%{cookies_2fe5d1efd435ab35347d86560a1332fe}%

%{cookies_bfc7061d6ef54f180e58861b30542c31}%

.. code-block:: php

    <?php

    $di->set('cookies', function() {
        $cookies = new Phalcon\Http\Response\Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    });


%{cookies_090e575523786a71d4c283962598e79c}%

