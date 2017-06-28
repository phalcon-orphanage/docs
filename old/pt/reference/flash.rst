Flashing Messages
=================

As mensagens flash são usadas para notificar o usuário sobre o estado das ações que ele / ela fez ou simplesmente mostrar informações para os usuários. Estes tipos de mensagens podem ser gerados utilizando este componente.

Adapters
--------
Este componente faz uso de adaptadores para definir o comportamento das mensagens depois de ser passada para o Flasher:

+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Adapter | Description                                                                                   | API                                                                        |
+=========+===============================================================================================+============================================================================+
| Direct  | Directly outputs the messages passed to the flasher                                           | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Session | Temporarily stores the messages in session, then messages can be printed in the next request  | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`              |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

Uso
-----
Normalmente, o serviço do Flash Messaging é solicitada a partir do recipiente de serviços.
Se você estiver usando :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>`
then :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`é automaticamente registrado como serviço "flash" and
:doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`é automaticamente registrado como serviço "flashSession".
You can also manually register it:

.. code-block:: php

    <?php

    use Phalcon\Flash\Direct as FlashDirect;
    use Phalcon\Flash\Session as FlashSession;

    // Set up the flash service
    $di->set(
        "flash",
        function () {
            return new FlashDirect();
        }
    );

    // Set up the flash session service
    $di->set(
        "flashSession",
        function () {
            return new FlashSession();
        }
    );

Dessa forma, você pode usá-lo em controladores ou vistas:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            $this->flash->success("The post was correctly saved!");
        }
    }

Existem quatro tipos de mensagens embutidas suportados:

.. code-block:: php

    <?php

    $this->flash->error("too bad! the form had errors");

    $this->flash->success("yes!, everything went very smoothly");

    $this->flash->notice("this a very important information");

    $this->flash->warning("best check yo self, you're not looking too good.");

Você pode adicionar mensagens com os seus próprios tipos usando o :code:`message()` método:

.. code-block:: php

    <?php

    $this->flash->message("debug", "this is debug message, you don't say");

Printing Messages
-----------------
As mensagens enviadas para o serviço de flash são automaticamente formatado com HTML:

.. code-block:: html

    <div class="errorMessage">too bad! the form had errors</div>

    <div class="successMessage">yes!, everything went very smoothly</div>

    <div class="noticeMessage">this a very important information</div>

    <div class="warningMessage">best check yo self, you're not looking too good.</div>

Como você pode ver, classes CSS são adicionados automaticamente para os :code:`<div>`s. Essas classes permitem definir a apresentação gráfica
das mensagens no navegador. As classes CSS pode ser substituído, por exemplo, se você estiver usando o Twitter de Bootstrap, as classes podem ser configurados como:

.. code-block:: php

    <?php

    use Phalcon\Flash\Direct as FlashDirect;

    // Register the flash service with custom CSS classes
    $di->set(
        "flash",
        function () {
            $flash = new FlashDirect(
                [
                    "error"   => "alert alert-danger",
                    "success" => "alert alert-success",
                    "notice"  => "alert alert-info",
                    "warning" => "alert alert-warning",
                ]
            );

            return $flash;
        }
    );

Em seguida, as mensagens seriam impressas como é mostrado a seguir:

.. code-block:: html

    <div class="alert alert-danger">too bad! the form had errors</div>

    <div class="alert alert-success">yes!, everything went very smoothly</div>

    <div class="alert alert-info">this a very important information</div>

    <div class="alert alert-warning">best check yo self, you're not looking too good.</div>

Implicit Flush vs. Session
--------------------------
Dependendo do adaptador usado para enviar as mensagens, que pode ser a produção de saída diretamente, ou temporariamente armazenar as mensagens em sessão para ser mostrado mais tarde.
Quando você deve usar cada um? Isso geralmente depende do tipo de redirecionamento que você faz depois de enviar as mensagens. Por exemplo,
se você fizer um "forward" não é necessário armazenar as mensagens na sessão, mas se você fizer um redirecionamento HTTP, em seguida, eles precisam ser armazenados na sessão:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ContactController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Store the post

            // Using direct flash
            $this->flash->success("Your information was stored correctly!");

            // Forward to the index action
            return $this->dispatcher->forward(
                [
                    "action" => "index"
                ]
            );
        }
    }

Ou usando um redirecionamento de HTTP:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ContactController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Store the post

            // Using session flash
            $this->flashSession->success("Your information was stored correctly!");

            // Make a full HTTP redirection
            return $this->response->redirect("contact/index");
        }
    }

Neste caso, você precisará imprimir manualmente as mensagens na view correspondente:

.. code-block:: html+php

    <!-- app/views/contact/index.phtml -->

    <p><?php $this->flashSession->output() ?></p>

O atributo 'flashSession' é como o flash foi previamente definido para o recipiente de injeção de dependência.
Você precisa iniciar o  :doc:`session <session>` primeiro para usar com sucesso o mensageiro flashSession.
