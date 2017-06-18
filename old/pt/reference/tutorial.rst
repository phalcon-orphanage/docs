Tutorial 1: Vamos aprender pelo exemplo
=======================================
Ao longo deste primeiro tutorial, nós vamos guiar você através da criação de um aplicativo com um simples formulário de registro a partir do zero. Também iremos explicar os aspectos básicos do comportamento do framework. Se você estiver interessado em utilizar ferramentas automáticas de geração de código para Phalcon, utilize nosso :doc:`developer tools <tools>`.

A melhor maneira de usar este guia é seguir cada passo de cada vez. Você pode obter o código completo
`aqui <https://github.com/phalcon/tutorial>`_.

Estrutura de arquivos
---------------------
Phalcon não impõe uma estrutura de arquivo específico para desenvolvimento de aplicativos. Devido ao fato de que ele é de baixo acoplamento, você pode implementar aplicativos Phalcon alimentado com uma estrutura de arquivo do modo que seja mais fácil para você.

Para fins deste tutorial e como ponto de partida, sugerimos essa estrutura muito simples:

.. code-block:: php

    tutorial/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/

Note que você não precisa de qualquer diretório "library" relacionado com Phalcon. A estrutura está disponível na memória, prontos para usar.

Before continuing, please be sure you've successfully :doc:`installed Phalcon <install>` and have setup either :doc:`Nginx <nginx>`, :doc:`Apache <apache>` or :doc:`Cherokee <cherokee>`.

Autoinicialização
-----------------
O primeiro arquivo que você precisa para criar é o arquivo de inicialização. Este arquivo é muito importante; uma vez que serve como a base de sua aplicação, o que lhe dá o controle de todos os aspectos do mesmo. Neste arquivo você pode implementar
a inicialização de componentes, bem como o comportamento do aplicativo.

Ultimately, it is responsible for doing 3 things:

1. Setting up the autoloader.
2. Configuring the Dependency Injector.
3. Handling the application request.

Autoloaders
^^^^^^^^^^^
A primeira parte que encontramos no bootstrap é registrar em um autoloader. Isso será usado para carregar classes como controladores e modelos na aplicação. Por exemplo, podemos registrar um ou mais diretórios de controladores aumentando a flexibilidade da aplicação. No nosso exemplo, utilizamos o componente :doc:`Phalcon\\Loader <../api/Phalcon_Loader>`.

Com ele, podemos carregar classes usando várias estratégias, mas para este exemplo escolhemos localizar classes com base em diretórios predefinidos:

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // ...

    $loader = new Loader();

    $loader->registerDirs(
        [
            "../app/controllers/",
            "../app/models/",
        ]
    );

    $loader->register();

Dependency Management
^^^^^^^^^^^^^^^^^^^^^
A very important concept that must be understood when working with Phalcon is its  It may sound complex but is actually very simple and practical.

Um conceito muito importante que deve ser entendido quando se trabalha com Phalcon é o seu :doc:`dependency injection container <di>`. Pode soar complexo, mas é realmente muito simples e prático.

A service container is a bag where we globally store the services that our application will use to function. Each time the framework requires a component, it will ask the container using an agreed upon name for the service. Since Phalcon is a highly decoupled framework, :doc:`Phalcon\\Di <../api/Phalcon_Di>` acts as glue facilitating the integration of the different components achieving their work together in a transparent manner.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    // ...

    // Create a DI
    $di = new FactoryDefault();

:doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>` is a variant of :doc:`Phalcon\\Di <../api/Phalcon_Di>`. To make things easier,
it has registered most of the components that come with Phalcon. Thus we should not register them one by one.
Later there will be no problem in replacing a factory service.

Na próxima parte, registramos a "view" indicando o diretório onde o framework encontrará os arquivos de views.
Como as visualizações não correspondem a classes, elas não podem ser carregadas com um carregador automático.

Os serviços podem ser registrados de várias maneiras, mas para o nosso tutorial usaremos uma `anonymous function`_:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    // ...

    // Setup the view component
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../app/views/");

            return $view;
        }
    );

Em seguida, registramos um URI de base para que todos os URIs gerados pelo Phalcon incluam a pasta "tutorial" que configuramos anteriormente.
Isso se tornará importante mais adiante neste tutorial quando usarmos a classe :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`
para gerar um hiperlink.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url as UrlProvider;

    // ...

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set(
        "url",
        function () {
            $url = new UrlProvider();

            $url->setBaseUri("/tutorial/");

            return $url;
        }
    );

Handling the application request
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
In the last part of this file, we find :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`. Its purpose
is to initialize the request environment, route the incoming request, and then dispatch any discovered actions;
it aggregates any responses and returns them when the process is complete.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // ...

    $application = new Application($di);

    $response = $application->handle();

    $response->send();

Putting everything together
^^^^^^^^^^^^^^^^^^^^^^^^^^^
O arquivo tutorial/public/index.php deve ser igual a este:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Mvc\Url as UrlProvider;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;



    // Register an autoloader
    $loader = new Loader();

    $loader->registerDirs(
        [
            "../app/controllers/",
            "../app/models/",
        ]
    );

    $loader->register();



    // Create a DI
    $di = new FactoryDefault();

    // Setup the view component
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../app/views/");

            return $view;
        }
    );

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set(
        "url",
        function () {
            $url = new UrlProvider();

            $url->setBaseUri("/tutorial/");

            return $url;
        }
    );



    $application = new Application($di);

    try {
        // Handle the request
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

Como você pode ver, o arquivo de bootstrap é muito curto e não precisamos incluir nenhum arquivo adicional. Nós definimos
Um aplicativo MVC flexível em menos de 30 linhas de código.

Criando um Controlador
---------------------
Por padrão, o Phalcon procurará um controlador chamado "Index". É o ponto de partida quando nenhum controlador ou
Ação foi aprovada na requisição. O controlador de índice (app/controllers/IndexController.php) se parece com:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function indexAction()
        {
            echo "<h1>Hello!</h1>";
        }
    }

As classes do controlador devem ter o sufixo "Controller" e as ações do controlador devem ter o sufixo "Action". Se você acessar o aplicativo a partir do seu navegador, você deverá ver algo como isto:

.. figure:: ../_static/img/tutorial-1.png
    :align: center

Congratulations, you're flying with Phalcon!

Sending output to a view
------------------------
Sending output to the screen from the controller is at times necessary but not desirable as most purists in the MVC community will attest. Everything must be passed to the view that is responsible for outputting data on screen. Phalcon will look for a view with the same name as the last executed action inside a directory named as the last executed controller. In our case (app/views/index/index.phtml):

.. code-block:: php

    <?php echo "<h1>Hello!</h1>";

Nosso controlador (app/controllers/IndexController.php) agora tem uma definição de ação vazia:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function indexAction()
        {

        }
    }

The browser output should remain the same. The :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` static component is automatically created when the action execution has ended. Learn more about :doc:`views usage here <views>`.

Designing a sign up form
------------------------
Now we will change the index.phtml view file, to add a link to a new controller named "signup". The goal is to allow users to sign up within our application.

.. code-block:: php

    <?php

    echo "<h1>Hello!</h1>";

    echo PHP_EOL;

    echo PHP_EOL;

    echo $this->tag->linkTo(
        "signup",
        "Sign Up Here!"
    );

The generated HTML code displays an anchor ("a") HTML tag linking to a new controller:

.. code-block:: html

    <h1>Hello!</h1>

    <a href="/tutorial/signup">Sign Up Here!</a>

To generate the tag we use the class :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`. This is a utility class that allows
us to build HTML tags with framework conventions in mind. As this class is a also a service registered in the DI
we use :code:`$this->tag` to access it.

Um artigo mais detalhado sobre a geração de HTML pode ser :doc:`found here <tags>`.

.. figure:: ../_static/img/tutorial-2.png
    :align: center

Aqui está o controlador Signup (app/controllers/SignupController.php):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }
    }

The empty index action gives the clean pass to a view with the form definition (app/views/signup/index.phtml):

.. code-block:: html+php

    <h2>
        Sign up using this form
    </h2>

    <?php echo $this->tag->form("signup/register"); ?>

        <p>
            <label for="name">
                Name
            </label>

            <?php echo $this->tag->textField("name"); ?>
        </p>

        <p>
            <label for="email">
                E-Mail
            </label>

            <?php echo $this->tag->textField("email"); ?>
        </p>



        <p>
            <?php echo $this->tag->submitButton("Register"); ?>
        </p>

    </form>

Visualizar o formulário no seu navegador mostrará algo como isto:

.. figure:: ../_static/img/tutorial-3.png
    :align: center

:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` also provides useful methods to build form elements.

O método :code:`Phalcon\Tag::form()` recebe apenas um parâmetro, por exemplo, um URI relativo a um controlador/ação na aplicação.

By clicking the "Send" button, you will notice an exception thrown from the framework, indicating that we are missing the "register" action in the controller "signup". Our public/index.php file throws this exception:

    Exception: Action "register" was not found on handler "signup"

Implementing that method will remove the exception:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }

        public function registerAction()
        {

        }
    }

If you click the "Send" button again, you will see a blank page. The name and email input provided by the user should be stored in a database. According to MVC guidelines, database interactions must be done through models so as to ensure clean object-oriented code.

Creating a Model
----------------
Phalcon brings the first ORM for PHP entirely written in C-language. Instead of increasing the complexity of development, it simplifies it.

Antes de criar nosso primeiro modelo, precisamos criar uma tabela de banco de dados fora do Phalcon para mapeá-la. Uma tabela simples para armazenar usuários registrados pode ser definida assim:

.. code-block:: sql

    CREATE TABLE `users` (
        `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
        `name`  varchar(70)          NOT NULL,
        `email` varchar(70)          NOT NULL,

        PRIMARY KEY (`id`)
    );

A model should be located in the app/models directory (app/models/Users.php). The model maps to the "users" table:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Users extends Model
    {
        public $id;

        public $name;

        public $email;
    }

Setting a Database Connection
-----------------------------
Para poder usar uma conexão de banco de dados e, posteriormente, acessar dados através de nossos modelos, precisamos especificá-lo em nosso processo de bootstrap. Uma conexão de banco de dados é apenas outro serviço que nosso aplicativo tem que pode ser usado para vários componentes:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    // Setup the database service
    $di->set(
        "db",
        function () {
            return new DbAdapter(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "test_db",
                ]
            );
        }
    );

Com os parâmetros de banco de dados corretos, nossos modelos estão prontos para trabalhar e interagir com o resto do aplicativo.

Storing data using models
-------------------------
Receber dados do formulário e armazená-los na tabela é o próximo passo.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }

        public function registerAction()
        {
            $user = new Users();

            // Store and check for errors
            $success = $user->save(
                $this->request->getPost(),
                [
                    "name",
                    "email",
                ]
            );

            if ($success) {
                echo "Thanks for registering!";
            } else {
                echo "Sorry, the following problems were generated: ";

                $messages = $user->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }

            $this->view->disable();
        }
    }

We then instantiate the Users class, which corresponds to a User record. The class public properties map to the fields
of the record in the users table. Setting the relevant values in the new record and calling :code:`save()` will store the data in the database for that record. The :code:`save()` method returns a boolean value which indicates whether the storing of the data was successful or not.

O ORM escapa automaticamente a entrada impedindo injeções SQL, portanto, só precisamos passar o pedido para o método :code:`save()`.

A validação adicional acontece automaticamente em campos que são definidos como não nulos (obrigatório). Se não inseriremos nenhum dos campos obrigatórios no formulário de inscrição, nossa tela ficará assim:

.. figure:: ../_static/img/tutorial-4.png
    :align: center

Conclusão
----------
Este é um tutorial muito simples e como você pode ver, é fácil começar a construir um aplicativo usando Phalcon. O fato de que o Phalcon é uma extensão em seu servidor não interfere com uma facilidade de desenvolvimento ou recursos disponíveis. Convidamo-lo a continuar a ler o manual para que você possa descobrir como características adicionais oferecidas por Phalcon!

.. _anonymous function: http://php.net/manual/pt_BR/functions.anonymous.php
