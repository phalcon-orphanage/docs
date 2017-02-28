Formulários
===========

:code:`Phalcon\Forms` é um componente que ajuda você na criação e manutenção de formulários em aplicações web.

O exemplo a seguir mostra seu uso básico:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Select;

    $form = new Form();

    $form->add(
        new Text(
            "name"
        )
    );

    $form->add(
        new Text(
            "telephone"
        )
    );

    $form->add(
        new Select(
            "telephoneType",
            [
                "H" => "Home",
                "C" => "Cell",
            ]
        )
    );

Os formulários podem ser renderizados com base na definição do formulário:

.. code-block:: html+php

    <h1>
        Contacts
    </h1>

    <form method="post">

        <p>
            <label>
                Name
            </label>

            <?php echo $form->render("name"); ?>
        </p>

        <p>
            <label>
                Telephone
            </label>

            <?php echo $form->render("telephone"); ?>
        </p>

        <p>
            <label>
                Type
            </label>

            <?php echo $form->render("telephoneType"); ?>
        </p>



        <p>
            <input type="submit" value="Save" />
        </p>

    </form>

Cada elemento no formulário pode ser processado conforme exigido pelo desenvolvedor. Internamente,
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` é usado para produzir um HTML correto para cada elemento e você pode passar atributos HTML adicionais como segundo parâmetro de :code:`render()`:

.. code-block:: html+php

    <p>
        <label>
            Name
        </label>

        <?php echo $form->render("name", ["maxlength" => 30, "placeholder" => "Type your name"]); ?>
    </p>

Os atributos HTML também podem ser definidos na definição do elemento:

.. code-block:: php

    <?php

    $form->add(
        new Text(
            "name",
            [
                "maxlength"   => 30,
                "placeholder" => "Type your name",
            ]
        )
    );

Inicializando formulários
-------------------------
Como visto anteriormente, os formulários podem ser inicializados fora da classe do formulário, adicionando elementos a ele. Você pode reutilizar o código ou organizar suas classes de formulário implementando o formulário em um arquivo separado:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Select;

    class ContactForm extends Form
    {
        public function initialize()
        {
            $this->add(
                new Text(
                    "name"
                )
            );

            $this->add(
                new Text(
                    "telephone"
                )
            );

            $this->add(
                new Select(
                    "telephoneType",
                    TelephoneTypes::find(),
                    [
                        "using" => [
                            "id",
                            "name",
                        ]
                    ]
                )
            );
        }
    }

:doc:`Phalcon\\Forms\\Form <../api/Phalcon_Forms_Form>` Estende :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>`
assim você tem acesso aos serviços de aplicativos, se necessário:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;

    class ContactForm extends Form
    {
        /**
         * This method returns the default value for field 'csrf'
         */
        public function getCsrf()
        {
            return $this->security->getToken();
        }

        public function initialize()
        {
            // Set the same form as entity
            $this->setEntity($this);

            // Add a text element to capture the 'email'
            $this->add(
                new Text(
                    "email"
                )
            );

            // Add a text element to put a hidden CSRF
            $this->add(
                new Hidden(
                    "csrf"
                )
            );
        }
    }

A entidade associada adicionada ao formulário na inicialização e as opções de usuário personalizadas são passadas para o construtor do formulário:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;

    class UsersForm extends Form
    {
        /**
         * Forms initializer
         *
         * @param Users $user
         * @param array $options
         */
        public function initialize(Users $user, array $options)
        {
            if ($options["edit"]) {
                $this->add(
                    new Hidden(
                        "id"
                    )
                );
            } else {
                $this->add(
                    new Text(
                        "id"
                    )
                );
            }

            $this->add(
                new Text(
                    "name"
                )
            );
        }
    }

Na instanciação do formulário você deve usar:

.. code-block:: php

    <?php

    $form = new UsersForm(
        new Users(),
        [
            "edit" => true,
        ]
    );

Validação
---------
Os formulários Phalcon são integrados com o componente :doc:`validation <validation>` para oferecer validação instantânea. Built-in or
custom validators could be set to each element:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element\Text;
    use Phalcon\Validation\Validator\PresenceOf;
    use Phalcon\Validation\Validator\StringLength;

    $name = new Text(
        "name"
    );

    $name->addValidator(
        new PresenceOf(
            [
                "message" => "The name is required",
            ]
        )
    );

    $name->addValidator(
        new StringLength(
            [
                "min"            => 10,
                "messageMinimum" => "The name is too short",
            ]
        )
    );

    $form->add($name);

Em seguida, você pode validar o formulário de acordo com a entrada inserida pelo usuário:

.. code-block:: php

    <?php

    if (!$form->isValid($_POST)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Os validadores são executados na mesma ordem em que foram registrados.

Por padrão mensagens geradas por todos os elementos no formulário são unidos para que eles possam ser atravessados usando um foreach único, você pode alterar esse comportamento para obter as mensagens separadas pelo campo:

.. code-block:: php

    <?php

    foreach ($form->getMessages(false) as $attribute => $messages) {
        echo "Messages generated by ", $attribute, ":", "\n";

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Ou obter mensagens específicas para um elemento:

.. code-block:: php

    <?php

    $messages = $form->getMessagesFor("name");

    foreach ($messages as $message) {
        echo $message, "<br>";
    }

Filtragem
---------
Um formulário também é capaz de filtrar dados antes de ser validado. Você pode definir filtros em cada elemento:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element\Text;

    $name = new Text(
        "name"
    );

    // Set multiple filters
    $name->setFilters(
        [
            "string",
            "trim",
        ]
    );

    $form->add($name);



    $email = new Text(
        "email"
    );

    // Set one filter
    $email->setFilters(
        "email"
    );

    $form->add($email);

.. highlights::

    Saiba mais sobre a filtragem em Phalcon :doc:`Filter documentation <filter>`.

Formulários + Entidades
-----------------------
Uma entidade como uma instância modelo/collection/plain ou apenas uma classe PHP simples pode ser vinculada ao formulário para definir valores padrão nos elementos do formulário ou atribuir facilmente os valores do formulário à entidade:

.. code-block:: php

    <?php

    $robot = Robots::findFirst();

    $form = new Form($robot);

    $form->add(
        new Text(
            "name"
        )
    );

    $form->add(
        new Text(
            "year"
        )
    );

Uma vez que o formulário é processado se não houver nenhum valor padrão atribuído aos elementos ele usará os fornecidos pela entidade:

.. code-block:: html+php

    <?php echo $form->render("name"); ?>

Você pode validar o formulário e atribuir os valores da entrada do usuário da seguinte maneira:

.. code-block:: php

    <?php

    $form->bind($_POST, $robot);

    // Check if the form is valid
    if ($form->isValid()) {
        // Save the entity
        $robot->save();
    }

A criação de uma classe simples como entidade também é possível:

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone = "Europe/Amsterdam";

        public $receiveEmails = "No";
    }

Usando essa classe como entidade, permite que o formulário tome os valores padrão dele:

.. code-block:: php

    <?php

    $form = new Form(
        new Preferences()
    );

    $form->add(
        new Select(
            "timezone",
            [
                "America/New_York"  => "New York",
                "Europe/Amsterdam"  => "Amsterdam",
                "America/Sao_Paulo" => "Sao Paulo",
                "Asia/Tokyo"        => "Tokyo",
            ]
        )
    );

    $form->add(
        new Select(
            "receiveEmails",
            [
                "Yes" => "Yes, please!",
                "No"  => "No, thanks",
            ]
        )
    );

As entidades podem implementar getters, que têm uma precedência maior do que propriedades públicas. Esses métodos proporcionam mais liberdade para produzir valores:

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone;

        public $receiveEmails;



        public function getTimezone()
        {
            return "Europe/Amsterdam";
        }

        public function getReceiveEmails()
        {
            return "No";
        }
    }

Elementos do formulário
-----------------------
Phalcon fornece um conjunto de elementos embutidos para usar em seus formulários, todos esses elementos estão localizados em :doc:`Phalcon\\Forms\\Element <../api/Phalcon_Forms_Element>` namespace:

+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| Name                                                                             | Description                                                 |
+==================================================================================+=============================================================+
| :doc:`Phalcon\\Forms\\Element\\Text <../api/Phalcon_Forms_Element_Text>`         | Generate INPUT[type=text] elements                          |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Password <../api/Phalcon_Forms_Element_Password>` | Generate INPUT[type=password] elements                      |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Select <../api/Phalcon_Forms_Element_Select>`     | Generate SELECT tag (combo lists) elements based on choices |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Check <../api/Phalcon_Forms_Element_Check>`       | Generate INPUT[type=check] elements                         |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\TextArea <../api/Phalcon_Forms_Element_TextArea>` | Generate TEXTAREA elements                                  |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Hidden <../api/Phalcon_Forms_Element_Hidden>`     | Generate INPUT[type=hidden] elements                        |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\File <../api/Phalcon_Forms_Element_File>`         | Generate INPUT[type=file] elements                          |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Date <../api/Phalcon_Forms_Element_Date>`         | Generate INPUT[type=date] elements                          |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Numeric <../api/Phalcon_Forms_Element_Numeric>`   | Generate INPUT[type=number] elements                        |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Submit <../api/Phalcon_Forms_Element_Submit>`     | Generate INPUT[type=submit] elements                        |
+----------------------------------------------------------------------------------+-------------------------------------------------------------+

Chamadas de Retorno do Evento
-----------------------------
Sempre que os formulários são implementados como classes, os retornos de chamada :code:`beforeValidation()` e :code:`afterValidation()` podem ser implementados na classe do formulário para realizar pré-validações e pós-validações:

.. code-block:: html+php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function beforeValidation()
        {

        }
    }

Renderização de Formulários
---------------------------
Você pode processar o formulário com flexibilidade total, o exemplo a seguir mostra como processar cada elemento usando um procedimento padrão:

.. code-block:: html+php

    <?php

    <form method="post">
        <?php

            // Traverse the form
            foreach ($form as $element) {
                // Get any generated messages for the current element
                $messages = $form->getMessagesFor(
                    $element->getName()
                );

                if (count($messages)) {
                    // Print each element
                    echo '<div class="messages">';

                    foreach ($messages as $message) {
                        echo $message;
                    }

                    echo "</div>";
                }

                echo "<p>";

                echo '<label for="', $element->getName(), '">', $element->getLabel(), "</label>";

                echo $element;

                echo "</p>";
            }

        ?>

        <input type="submit" value="Send" />
    </form>

Ou reutilize a lógica na sua classe de formulário:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function initialize()
        {
            // ...
        }

        public function renderDecorated($name)
        {
            $element  = $this->get($name);

            // Get any generated messages for the current element
            $messages = $this->getMessagesFor(
                $element->getName()
            );

            if (count($messages)) {
                // Print each element
                echo '<div class="messages">';

                foreach ($messages as $message) {
                    echo $this->flash->error($message);
                }

                echo "</div>";
            }

            echo "<p>";

            echo '<label for="', $element->getName(), '">', $element->getLabel(), "</label>";

            echo $element;

            echo "</p>";
        }
    }

Na view:

.. code-block:: php

    <?php

    echo $element->renderDecorated("name");

    echo $element->renderDecorated("telephone");

Criando Elementos de Formulário
-------------------------------
Além dos elementos de formulário fornecidos pelo Phalcon, você pode criar seus próprios elementos personalizados:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element;

    class MyElement extends Element
    {
        public function render($attributes = null)
        {
            $html = // ... Produce some HTML

            return $html;
        }
    }

Gerenciador de formulários
--------------------------
Este componente fornece um gerenciador de formulários que pode ser usado pelo desenvolvedor para registrar formulários e acessá-los através do localizador de serviços:

.. code-block:: php

    <?php

    use Phalcon\Forms\Manager as FormsManager;

    $di["forms"] = function () {
        return new FormsManager();
    };

Os formulários são adicionados ao gerenciador de formulários e referenciados por um nome exclusivo:

.. code-block:: php

    <?php

    $this->forms->set(
        "login",
        new LoginForm()
    );

Usando o nome exclusivo, os formulários podem ser acessados em qualquer parte do aplicativo:

.. code-block:: php

    <?php

    $loginForm = $this->forms->get("login");

    echo $loginForm->render();

Recursos externos
-----------------
* `Vökuró <http://vokuro.phalconphp.com>`_, é um aplicativo de exemplo que usa o construtor de formulários para criar e gerenciar formulários, [`Github <https://github.com/phalcon/vokuro>`_]
