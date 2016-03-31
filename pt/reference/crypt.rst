Encriptação/Decriptação
=======================

Phalcon provê utilitários de encriptação pelo componente :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>`.
Essa classe oferece uma simples camada orientada a objetos baseada na biblioteca mcrypt_ do PHP.

Por padrão, esse componente provê uma encriptação segura usando AES-256 (rijndael-256-cbc).

Uso Básico
----------
Esse componente foi projetado para fornecer um uso muito simples:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt     = new Crypt();

    $key       = 'le password';
    $text      = 'This is a secret text';

    $encrypted = $crypt->encrypt($text, $key);

    echo $crypt->decrypt($encrypted, $key);

Você pode usar a mesma instância para encriptar/decriptar várias vezes:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt = new Crypt();

    $texts = array(
        'my-key'    => 'This is a secret text',
        'other-key' => 'This is a very secret'
    );

    foreach ($texts as $key => $text) {

        // Perform the encryption
        $encrypted = $crypt->encrypt($text, $key);

        // Now decrypt
        echo $crypt->decrypt($encrypted, $key);
    }

Opções de Encriptação
---------------------
As seguintes opções estão disponíveis para alterar o comportamento da encriptação:

+------------+--------------------------------------------------------------------------------------------------------------+
| Nome       | Descrição                                                                                                    |
+============+==============================================================================================================+
| Cipher     | É um dos tipos de algoritmo de encriptografia suportados pela libmcrypt. Você pode ver a lista aqui_         |
+------------+--------------------------------------------------------------------------------------------------------------+
| Mode       | Um modo de encriptação suportado pela libmcrypt (ecb, cbc, cfb, ofb)                                         |
+------------+--------------------------------------------------------------------------------------------------------------+


Exemplo:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt = new Crypt();

    // Use blowfish
    $crypt->setCipher('blowfish');

    $key   = 'le password';
    $text  = 'This is a secret text';

    echo $crypt->encrypt($text, $key);

Suporte a Base64
----------------
Para que a criptografia possa ser trafegada (emails, urls) ou exibida (navegadores), normalmente aplicamos nos textos a codificação base64_.

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Create an instance
    $crypt   = new Crypt();

    $key     = 'le password';
    $text    = 'This is a secret text';

    $encrypt = $crypt->encryptBase64($text, $key);

    echo $crypt->decryptBase64($encrypt, $key);

Configurando um serviço de Encriptação
--------------------------------------
Você pode configurar um componente de encriptação no container de serviços para usá-lo em qualquer parte da aplicação:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    $di->set('crypt', function () {

        $crypt = new Crypt();

        // Set a global encryption key
        $crypt->setKey('%31.1e$i86e$f!8jz');

        return $crypt;
    }, true);

Então, por exemplo, em um controlador você pode usá-lo da seguinte forma:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SecretsController extends Controller
    {
        public function saveAction()
        {
            $secret = new Secrets();

            $text = $this->request->getPost('text');

            $secret->content = $this->crypt->encrypt($text);

            if ($secret->save()) {
                $this->flash->success('Secret was successfully created!');
            }
        }
    }

.. _mcrypt: http://www.php.net/manual/en/book.mcrypt.php
.. _aqui: http://www.php.net/manual/en/mcrypt.ciphers.php
.. _base64: http://www.php.net/manual/en/function.base64-encode.php
