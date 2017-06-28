Suporte multilíngue
===================

O componente :doc:`Phalcon\\Translate <../api/Phalcon_Translate>` auxilia na criação de aplicações multilíngues.
Os aplicativos que usam este componente, exibi o conteúdo em diferentes línguas, com base no idioma escolhido pelo usuário e suportado pelo aplicativo.

Adaptadores
-----------
Este componente faz uso de adaptadores para ler mensagens de tradução de diferentes fontes em uma forma unificada.

+------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| Adapter                                                                                        | Description                                                                             |
+================================================================================================+=========================================================================================+
| :doc:`Phalcon\\Translate\\Adapter\\NativeArray <../api/Phalcon_Translate_Adapter_NativeArray>` | Uses PHP arrays to store the messages. This is the best option in terms of performance. |
+------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+

Uso de componentes
------------------
As palavras traduzidas são armazenados em arquivos. A estrutura destes ficheiros pode variar dependendo do adaptador usado. Phalcon lhe dá a liberdade para organizar suas seqüências de tradução como você desejar. Uma estrutura simples seria:

.. code-block:: bash

    app/messages/en.php
    app/messages/es.php
    app/messages/fr.php
    app/messages/zh.php

Cada arquivo contém um conjunto de forma chave/valor para tradução. Para cada arquivo de tradução, as chaves são únicas. A mesma disposição é usada em arquivos diferentes, onde as chaves permanecem os mesmos valores e contêm as mensagens traduzidas dependendo de cada idioma.

.. code-block:: php

    <?php

    // app/messages/en.php
    $messages = [
        "hi"      => "Hello",
        "bye"     => "Good Bye",
        "hi-name" => "Hello %name%",
        "song"    => "This song is %song%",
    ];

.. code-block:: php

    <?php

    // app/messages/fr.php
    $messages = [
        "hi"      => "Bonjour",
        "bye"     => "Au revoir",
        "hi-name" => "Bonjour %name%",
        "song"    => "La chanson est %song%",
    ];

Aplicar o mecanismo de tradução em seu aplicativo é trivial, mas depende de como você deseja implementá-lo. Você pode usar uma detecção automática do idioma do navegador do usuário ou você pode fornecer uma página de configurações de onde o usuário pode selecionar seu idioma.

Uma maneira simples de detectar o idioma do usuário é para analisar o conteudo do :code:`$_SERVER['HTTP_ACCEPT_LANGUAGE']` , ou, se desejar, acessá-lo diretamente através de uma chamada :code:`$this->request->getBestLanguage()` no action do controller:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;
    use Phalcon\Translate\Adapter\NativeArray;

    class UserController extends Controller
    {
        protected function getTranslation()
        {
            // Ask browser what is the best language
            $language = $this->request->getBestLanguage();

            $translationFile = "app/messages/" . $language . ".php";

            // Check if we have a translation file for that lang
            if (file_exists($translationFile)) {
                require $translationFile;
            } else {
                // Fallback to some default
                require "app/messages/en.php";
            }

            // Return a translation object
            return new NativeArray(
                [
                    "content" => $messages,
                ]
            );
        }

        public function indexAction()
        {
            $this->view->name = "Mike";
            $this->view->t    = $this->getTranslation();
        }
    }

O método :code:`_getTranslation()` está disponível para todas as ações que requerem traduções. A variável :code:`$t` é passado para os pontos das views, e com ela, podemos traduzir as seqüências em camada::

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi => 'Hello' -->
    <p><?php echo $t->_("hi"), " ", $name; ?></p>

The :code:`_()` method is returning the translated string based on the index passed. Some strings need to incorporate placeholders for
calculated data i.e. Hello %name%. These placeholders can be replaced with passed parameters in the :code:`_()` method. The passed parameters
are in the form of a key/value array, where the key matches the placeholder name and the value is the actual data to be replaced:

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi-name => 'Hello %name%' -->
    <p><?php echo $t->_("hi-name", ["name" => $name]); ?></p>

Some applications implement multilingual on the URL such as http://www.mozilla.org/**es-ES**/firefox/. Phalcon can implement
this by using a :doc:`Router <routing>`.

Implementing your own adapters
------------------------------
The :doc:`Phalcon\\Translate\\AdapterInterface <../api/Phalcon_Translate_AdapterInterface>` interface must be implemented
in order to create your own translate adapters or extend the existing ones:

.. code-block:: php

    <?php

    use Phalcon\Translate\AdapterInterface;

    class MyTranslateAdapter implements AdapterInterface
    {
        /**
         * Adapter constructor
         *
         * @param array $data
         */
        public function __construct($options);

        /**
         * Returns the translation string of the given key
         *
         * @param   string $translateKey
         * @param   array $placeholders
         * @return  string
         */
        public function _($translateKey, $placeholders = null);

        /**
         * Returns the translation related to the given key
         *
         * @param   string $index
         * @param   array $placeholders
         * @return  string
         */
        public function query($index, $placeholders = null);

        /**
         * Check whether is defined a translation key in the internal array
         *
         * @param   string $index
         * @return  bool
         */
        public function exists($index);
    }

There are more adapters available for this components in the `Phalcon Incubator <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter>`_
