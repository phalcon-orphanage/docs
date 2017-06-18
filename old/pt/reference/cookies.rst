Gerenciamento de Cookies
========================

Cookies_ são um caminho muito útil para armazenar pequenas partes de dados nas máquinas dos clientes que podem
ser recuperados mesmo se o usuário fechar seu navegador. :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`
age como um recipiente global para os cookies. Os cookies são armazenados nesse recipiente durante a execução da requisição e são
enviados automaticamente no fim da requisição.

Uso Básico
----------
Você pode setar/recuperar cookies acessando o serviço 'cookies' em qualquer parte da aplicação onde os serviços
podem ser acessados:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {
        public function loginAction()
        {
            // Check if the cookie has previously set
            if ($this->cookies->has("remember-me")) {
                // Get the cookie
                $rememberMeCookie = $this->cookies->get("remember-me");

                // Get the cookie's value
                $value = $rememberMeCookie->getValue();
            }
        }

        public function startAction()
        {
            $this->cookies->set(
                "remember-me",
                "some value",
                time() + 15 * 86400
            );
        }

        public function logoutAction()
        {
            $rememberMeCookie = $this->cookies->get("remember-me");

            // Delete the cookie
            $rememberMeCookie->delete();
        }
    }

Encriptação/Decriptação de Cookies
----------------------------------
Por padrão, cookies são automaticamente encriptados antes de serem enviados ao cliente e são decriptados quando recuperados do usuário.
Essa proteção evita que usuários não autorizados vejam o conteúdo dos cookies no cliente (navegador).
Apesar dessa proteção, dados sensíveis não devem ser armazenados em cookies.

Você pode desabilitar a encriptação da seguinte forma:

.. code-block:: php

    <?php

    use Phalcon\Http\Response\Cookies;

    $di->set(
        "cookies",
        function () {
            $cookies = new Cookies();

            $cookies->useEncryption(false);

            return $cookies;
        }
    );

Se você deseja user encriptação, uma chave global precisa ser setada no serviço 'crypt':

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    $di->set(
        "crypt",
        function () {
            $crypt = new Crypt();

            $crypt->setKey('#1dj8$=dp?.ak//j1V$'); // Use your own key!

            return $crypt;
        }
    );

.. highlights::

    Enviando dados de cookies sem encriptação para os clientes, incluindo objetos com estrutura complexa, resultsets,
    service information, etc; pode expor detalhes internos da aplicação que podem ser usados por um invasor
    para explorar a aplicação. Se você não quer usar encriptação, nós altamente recomendamos que você somente envie dados
    simples via cookie, como numeros ou pequenas strings literais.

.. _Cookies: http://en.wikipedia.org/wiki/HTTP_cookie
