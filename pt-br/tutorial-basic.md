---
layout: default
language: 'pt-br'
version: '4.0'
---

# Tutorial - Básico

* * *

## Básico

Ao seguir este tutorial, nós o conduziremos através da criação de uma aplicação do zero com um simples formulário de cadastro. Este guia provê uma introdução aos aspectos do design do framework Phalcon.

Este tutorial cobre a implementação de uma simples aplicação MVC, mostrando o quão rápido e fácil isso pode ser feito com Phalcon. Esse tutorial o ajudara a começar a criar uma aplicação que você poderá adaptar para qualquer necessidade. O código deste tutorial pode ser utilizado como um laboratório para aprender outros conceitos e idéias específicos do Phalcon.

<div class="alert alert-info">
    <p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe>
    </p>
</div>

Se deseja começar já, você pode pular este tutorial e criar um projeto do Phalcon automaticamente com as nossas [ferramentas de densevolvimento](devtools). (É recomendado que caso você não tenha experiência com o framework que volte para cá caso fique estagnado.).

A melhor forma de utilizar este guia é seguindo em frente e tentar se divertir. Você pode baixar o código completo [aqui](https://github.com/phalcon/tutorial). Se você se sentir entusiasmado com algo, por favor nos visite no [Discord](https://phalcon.link/discord) ou em nosso \[Forum\]\[forum\].

## Estrutura de arquivos

Uma das características chaves do Phalcon é sua baixa dependência, você pode construir um projeto com Phalcon em uma estrutura de diretório que seja conveniente para as especificidades da sua aplicação. Dito isso, uma certa uniformidade ajuda quando estamos colaborando com outras pessoas, e este tutorial utilizará uma estrutura "Padrão" para que você se sinta em casa caso já tenha trabalhado com outros MVC's no passado.

```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

> Nota: Você não verá um diretório `vendor` já que todas as dependências principais do Phalcon são carregadas em memória através da extensão que você já deve ter instalado. Se você se esqueceu dessa parte e não instalou a extensão do Phalcon [por favor volte](installation) e finalize a instalação antes de continuar.
{: .alert .alert-warning }

Se está começando agora, é recomendado que você instale o [Phalcon Devtools](devtools) já que elas se baseiam no servidor embutido do PHP para que você rode sua aplicação sem ter que configurar um servidor web, bastando adicionar esse [.htrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) na raíz do seu projeto.

Entretanto, se você deseja utilizar o Nginx, [aqui](webserver-setup#nginx) estão as configurações adicionais.

O Apache também pode ser utilizado com [estas](webserver-setup#apache) configurações.

E, finalmente, se você prefere o Cherokee, utilize [estas](webserver-setup#cherokee) configurações.

## Inicialização

O primeiro arquivo que você precisa criar é o arquivo de inicialização (bootstrap). Este arquivo age como um ponto de entrada para sua aplicação e carrega suas configurações. Neste arquivo você pode implementar a inicialização de componentes bem como o comportamento de sua aplicação.

Este arquivo é responsável por três coisas:

- Registro de componentes autoloaders
- Configuração de Serviços e seus registros no contexto de Injeção de Dependência
- Resolver as requisições HTTP da aplicação

### Autoloaders

Autoloaders (carregadores automáticos) baseiam-se no arquivo carregador em conformidade com a [PSR-4](https://www.php-fig.org/psr/psr-4/) que roda através do Phalcon. Coisas comuns que devem ser adicionadas ao autoloader são suas controllers e models. Você pode registrar diretórios que serão pesquisados por arquivos dentro do namespace da aplicação. Se você deseja saber mais sobre outras formas de utilizar os autoloaders leia [aqui](loader#overview).

Para começar, vamos registrar os diretórios `controllers` e `models` da nossa aplicação. Não esqueça de incluir o carregador de `Phalcon\Loader`.

`public/index.php`

```php
<?php

use Phalcon\Loader;

// Define algumas constantes com caminhos absolutos para ajudar na localização
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();
```

### Gerenciamento de Dependência

Já que o Phalcon possuí baixa dependência, serviços são registrados com o Gerenciador de Dependência do framework para que eles possam ser injetados automaticamente nos componentes e serviços englobados pelo contêiner de [IC](https://pt.wikipedia.org/wiki/Invers%C3%A3o_de_controle). Frequentemente você encontrará o termo DI que significa em inglês - Dependency Injection, ou, Injeção de Dependência. Injeção de Dependência e Inversão de Controle podem soar como características complexas, mas no Phalcon o seu uso é muito simples e prático. O contêiner de IC do Phalcon consiste dos seguintes conceitos:

- Contêiner de Serviço: Uma "caixa" em que os serviços para o funcionamento da aplicação são guardados globalmente.
- Serviço ou Componente: Objetos processadores de dados que serão injetados em componentes.

Toda a vez que o framework requerer um componente ou serviço, ele perguntará ao contêiner pelo nome conhecido do serviço. Não se esqueça de incluir o `Phalcon\Di` que configurará o contêiner de serviço.

> Se você estiver interesando nos detalhes, por favor veja este artigo [Martin Fowler](https://martinfowler.com/articles/injection.html). Nós também temos um [bom tutorial](di) cobrindo vários casos de uso.
{: .alert .alert-warning }

### Factory Default

O [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) - fábrica padrão - é uma variação do [Phalcon\Di](api/Phalcon_Di). Para tornar as coisas mais fáceis ele irá registrar automaticamente a maioria dos componentes existentes no Phalcon. Nós recomendamos que você registre seus serviços manualmente, mas o incluímos para facilitar sua utilização quando tratamos de Gerenciamento de Dependência. Mais tarde, quando estiver mais cofortável com o conceito, você poderá especificá-las.

Serviços podem ser registrados de várias formas, mas para este tutorial utilizaremos [funções anônimas](https://www.php.net/manual/pt_BR/functions.anonymous.php).

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

Na próxima parte, nós registraremos um serviços de "view" - visualização - indicando o diretório em que o framework irá procurar pelos arquivos de view. Como as views não correspondem para classes, elas não podem ser carregadas com o autoloader.

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

// Definindo o componente de view
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);
```

A seguir, registraremos a URI base para que todas as URIs geradas pelo Phalcon correspondam ao caminho base da aplicação `/`. Isso se mostrará importante mais adiante neste tutorial, quando utilizarmos a classe `Phalcon\Tag` para gerar os links.

`public/index.php`

```php
<?php

use Phalcon\Url as UrlProvider;

// ...

// Definindo a URI base
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);
```

### Tratando da requisição da aplicação

Na última parte deste arquivo vemos um [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application). Seu propósito é inicializar o ambiente de requisições, roteando a requisição que chega e então despachando para qualquer ação conhecida; ela agrega qualquer resposta e as retorna assim que o processo é completo.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

$response->send();
```

### Juntando tudo

O arquivo `tutorial/public/index.php` deverá se parecer com o seguinte:

`public/index.php`

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Url as UrlProvider;

// Define algumas constantes com caminhos absolutos para ajudar na localização
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

// Create a DI
$di = new FactoryDefault();

// Definindo o componente de view
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

// Definindo a URI base
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

Como você pode ver, o arquivo de inicialização é bastante pequeno e nós não precisamos incluir nenhum arquivo adicional. Parabéns por ter criado uma aplicação MVC flexível com menos de 60 linhas de código bem estruturado!

## Criando um  Controller

Por padrão o Phalcon procurará por um controller - controlador - chamado `IndexController`. É o seu ponto de partida quando nenhum controle ou ação foi adicionado na requisição (ex: `https://localhost:8000/`). Um `IndexController` e seu `IndexAction` devem se basear no seguinte exemplo:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return '<h1>Ol&aacute;!</h1>';
    }
}
```

A classe do controller deve possuír o sufixo `Controller` e as ações do controller devem possuír o sufix `Action`. Se você acessar sua aplicação pelo browser, deverá ver algo parecido com isso:

![](/assets/images/content/tutorial-basic-1.png)

Parabéns, você está voando com o "Phalcão"!

## Enviando dados para a view

Enviar dados para a tela através do controller é muitas vezes necessário, mas não é algo muito bem visto pelos membros mais assíduos da comunidade MVC. Tudo deve ser enviado para a view, que é a responsável por escrever os dados na tela. O Phalcon procurará por uma view com o mesmo nome da última ação executada dentro do diretório com o nome do último controller executado. No nosso caso (`app/views/index/index.phtml`):

`app/views/index/index.phtml`

```php
<?php echo "<h1>Ol&aacute;!</h1>";
```

Nosso controller (`app/controllers/IndexController.php`) agora possuirá uma ação vazia:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {

    }
}
```

A saída do navegador deverá continuar a mesma. O componente estático `Phalcon\Mvc\View` é automaticamente criado quando a ação executada termina. Aprenda mais sobre a utilização das views [aqui](views). 

## Modelando um formulário de cadastro

Agora modificaremos o arquivo da view `index.phtml` para adicionar um link para o novo controller chamado "singup". O objetivo é permitir que os usuários possam se cadastrar em nossa aplicação:

`app/views/index/index.phtml`

```php
<?php

echo "<h1>Ol&aacute;!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    'signup',
    'Sign Up Here!'
);
```

O código HTML gerado exibe um link (`<a>`) apontando para o novo controller:

`app/views/index/index.phtml` (interpretado)

```html
<h1>Ol&aacute;!</h1>

<a href="/signup">Sign Up Here!</a>
```

Para gerar esse link nós utilizamos a classe `Phalcon\Tag`. Essa é uma classe de utilidades que nos permite construir tags HTML com as convenções de um framework em mente. Como essa classe também é um serviço registrado no DI nós utilizamos `$this->tag` para acessá-la.

Um artigo mais detalhado sobre a geração de HTML pode ser encontrado [aqui](tag).

![](/images/content/tutorial-basic-2.png)

Aqui está o Signup controller (`app/controllers/SignupController.php`):

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }
}
```

Essa ação index vazia dá livre passagem para a view com a definição do formulário (`app/views/signup/index.phtml`):

`app/views/signup/index.phtml`

```html
<h2>Sign up using this form</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">Name</label>
        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">E-Mail</label>
        <?php echo $this->tag->textField("email"); ?>
    </p>

    <p>
        <?php echo $this->tag->submitButton("Register"); ?>
    </p>

</form>
```

Visualizando o formulário em seu browser aparecerá algo semelhante a isto:

![](/assets/images/content/tutorial-basic-3.png)

O [Phalcon\Tag](api/Phalcon_Tag) também provê métodos úteis para construir elementos de formulário.

O método `Phalcon\Tag::form()` recebe apenas um parâmetro por instância, uma URI relativa para o controller/action da aplicação.

Clicando no botão "Send", você notará uma excessão sendo disparada pelo framework, indicando que a action `register` está falando no controller `signup`. Nosso arquivo `public/index.php` lançou a seguinte excessão:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementando este método irá remover a excessão:

`app/controllers/SignupController.php`

```php
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
```

Se você clicar no botão "Send" novamente verá uma tela em branco. Os campos name e email informados pelo usuário devem ser guardados em uma base de dados. De acordo com as boas práticas do MVC, interações com banco de dados devem ser feitas através de models para garantir um código limpo completamente orientado à objetos.

## Criando um Model

O Phalcon trás o primeiro ORM para PHP escrito completamente em linguagem C. Ao invés de aumentar a complexidade do desenvolvimento, ele o simplifica.

Antes de criarmos nosso primeiro model, nós precisamos criar a base de dados com a tabela fora do Phalcon para então mapeá-la para dentro dele. Uma simples tabela para guardar os usuários registrados pode ser criada da seguinte forma:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

Um model (`app/models/Users.php`) deve estar localizado no diretório `app/models`. O model aponta para a tabela "users":

`app/models/Users.php`

```php
<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $name;
    public $email;
}
```

## Configurando uma Conexão com o Banco

Para que possamos utilizar uma conexão com o banco e dados e consequentemente acessar os dados através de nossos models, precisamos especificá-la em nosso arquivo de inicialização. Uma conexão com um banco de dados é simplesmente outro serviço que nossa aplicação possuí e que pode ser utilizada por vários componentes:

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Define o serviço do banco de dados
$di->set(
    'db',
    function () {
        return new DbAdapter(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial1',
            ]
        );
    }
);
```

Com os parâmetros corretos da base de dados, nossos models estão prontos para interagir com o resto da aplicação.

## Guardando dados utilizando models

`app/controllers/SignupController.php`

```php
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

        $user->assign(
            $this->request->getPost(),
            null,
            [
                "name",
                "email",
            ]
        );

        // Guarda e verificar por erros
        $success = $user->save();

        if ($success) {
            echo "Obrigado por se registrar!";
        } else {
            echo "Desculpe, os seguintes problemas foram gerados: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
```

No começo da `registerAction` nós criamos um objeto "user" vazio para a classe Users que gerencia os registros de usuários. As propriedades públicas da classe apontam para os campos da tabela `users` em nossa base de dados. Configurar os valores relevantes para um novo registro e chamar o método `save()` irá gravar os dados na dabase para aquele registro. O método `save()` retorna um valor booleano que indica se os dados foram salvos com sucesso ou não.

O ORM escapa automaticamente a entrada de dados prevenindo SQL injection, desta forma nós precisamos apenas passar a requisição para o método `save()`.

Validações adicionais acontecem automaticamente para os campos que são definidos como not null (obrigatórios). Se nós não escrevermos nenhum dos campos obrigatórios no formulário de cadastro, nossa tela será parecida com a seguinte:

![](/assets/images/content/tutorial-basic-4.png)

## Lista de Usuários

Agora vamos ver como obter e visualizar os usuários que nós registramos no banco de dados.

A primeira coisa que nós vamos fazer é modificar a `indexAction` do `IndexController` exibindo o resultado da busca de todos os usuários, que é feito simplesmente chamando `Users::find()`. Vamos ver como nossa `indexAction` deverá parecer:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * Boas vindas e a lista de usuários
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
    }
}
```

Agora em nosso arquivo `views/index/index.phtml` nós vamos acessar os usuários encontrados na base de dados. Eles estarão disponíveis na variável `$users`. Essa variável possuí o mesmo nome que utilizamos em `$this->view->users`.

A view deverá parecer com o seguinte:

`views/index/index.phtml`

```html
<?php

echo "<h1>Ol&aacute;!</h1>";

echo $this->tag->linkTo(["signup", "Cadastre-se aqui!", 'class' => 'btn btn-primary']);

if ($users->count() > 0) {
    ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Email</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3">Quantidade de usuários: <?php echo $users->count(); ?></td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->email; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
```

Como você pode ver, nossa variável `$users` pode ser iterada e somada. Nós veremos isso mais a fundo adiante ao analisar os [models](db-models).

![](/images/content/tutorial-basic-5.png)

## Adicionando um estilo

Para dar um toque de estilo para a nossa primeira aplicação, vamos adicionar um bootstrap e um pequeno template que será utilizado em todas as views.

Adicionaremos um arquivo `index.phtml` no diretório `views`, com o seguinte conteúdo:

`app/views/index.phtml`

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutorial Phalcon</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

O ponto mais importante a se notar em nosso template é a função `getContent()` que nos retornará o conteúdo gerado pela view. Agora nossa aplicação se parece com algo assim:

![](/images/content/tutorial-basic-6.png)

## Conclusão

Como você pode ver é muito fácil começar a construir uma aplicação utilizando o Phalcon. O fato de que o Phalcon roda através de uma extensão reduz significamente o tamanho de nosso projetos bem como nos dá um ganho significante na performance.

Se você está pronto para aprender mais dê uma olhada a seguir em [Rest Tutorial](tutorial-rest).
