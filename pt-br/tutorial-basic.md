---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Tutorial - Básico'
keywords: 'tutorial, tutorial básico, passo a passo, mvc'
---

# Tutorial - Básico

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg) ![](/assets/images/level-beginner.svg)

## Visão Geral

Ao longo deste tutorial, criaremos um aplicativo com um formulário de registro simples, introduzindo os aspectos principais do design do Phalcon.

Este tutorial cobre a implementação de uma simples aplicação MVC, mostrando o quão rápido e fácil isso pode ser feito com Phalcon. Uma vez desenvolvido, você pode extender este aplicativo para atender às suas necessidades. O código deste tutorial também pode ser usado como um playground para aprender outros conceitos e ideias específicas do Phalcon. <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe> 

Se deseja começar já, você pode pular este tutorial e criar um projeto do Phalcon automaticamente com as nossas [ferramentas de desenvolvedor](devtools).

A melhor maneira de utilizar este guia é seguir em frente e tentar se divertir. Você pode obter o código completo [aqui](https://github.com/phalcon/tutorial). Se você ficar travado ou tiver dúvidas, por favor, nos visite no [Discord](https://phalcon.io/discord) ou no nosso [Fórum](https://phalcon.io/forum).

## Estrutura de Arquivos

Uma das principais características do Phalcon é a sua baixa dependência. Por causa disso, você pode usar qualquer estrutura de diretório que seja conveniente para você. Neste tutorial, usaremos uma estrutura de diretórios *padrão*, comumente usada nos aplicativos MVC.

```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

> **NOTA**: Já que todo o código que o Phalcon expõe está encapsulado na extensão (que você carregou no seu servidor web), você não verá o diretório `vendor` contendo código do Phalcon. Tudo o que você precisa está na memória. Se você ainda não instalou o aplicativo, vá para a página de [instalação](installation) e a complete antes de continuar com este tutorial.
{: .alert .alert-warning }

Se tudo isso é novo para você, recomendamos que instale o [Devtools do Phalcon](devtools). O servidor web embutido do DevTools permite que você execute seu aplicativo quase que instantâneamente. Se você escolher esta opção, precisará de um arquivo `.htrouter.php` na raiz do seu projeto com o seguinte conteúdo:

```php
<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

$_GET['_url'] = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/public/index.php';
```

No caso de nosso tutorial, este arquivo deve estar localizado no diretório `tutorial`.

Você também pode usar nginX, apache, cherokee ou outros servidores web. Você pode verificar a página [configuração do servidor web](webserver-setup) para obter instruções.

## Inicialização

O primeiro arquivo que você precisa criar é o arquivo de inicialização (bootstrap). Este arquivo atua como o ponto de entrada e configuração para sua aplicação. Neste arquivo, você pode implementar a inicialização de componentes bem como definir o comportamento da aplicação.

Este arquivo lida com 3 coisas:

- Registro de componentes autoloaders
- Configuração de Serviços e seus registros no contexto de Injeção de Dependência
- Resolver as requisições HTTP da aplicação

### Autoloader

Nós vamos usar [Phalcon\Loader](loader) um carregador de arquivos compatível com a [PSR-4](https://www.php-fig.org/psr/psr-4/). Coisas comuns que devem ser adicionadas ao autoloader são seus "controllers" e "models". Você também pode registrar diretórios que serão escaneados por arquivos exigidos pela aplicação.

Para começar, vamos registrar os diretórios `controllers` e `models` do nosso aplicativo usando o [Phalcon\Loader](loader):

`public/index.php`

```php
<?php

use Phalcon\Loader;

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

Já que o Phalcon tem baixa dependência, serviços são registrados com o "Gerenciador de Dependência" do framework para que eles possam ser injetados automaticamente nos componentes e serviços envolvidos no contêiner de [IoC](https://en.wikipedia.org/wiki/Inversion_of_control). Frequentemente você encontrará o termo DI que significa em inglês - Dependency Injection, ou, Injeção de Dependência. Injeção de Dependência e Inversão de Control(IoC) podem parecer termos complexos, mas o Phalcon garante que seu uso seja simples, prático e eficiente. O contêiner de IoC do Phalcon consiste dos seguintes conceitos:

- Contêiner de Serviço: Uma "caixa" em que os serviços para o funcionamento da aplicação são guardados globalmente.
- Serviço ou Componente: Objetos processadores de dados que serão injetados em componentes.

Toda a vez que o framework requerer um componente ou serviço, ele perguntará ao contêiner pelo nome conhecido do serviço. Desta forma, temos uma maneira fácil de recuperar os objetos necessários para a nossa aplicação, como logger, conexão com banco de dados, etc.

> **NOTA**: Se você ainda estiver interessado nos detalhes, por favor, veja este artigo de [Martin Fowler](https://martinfowler.com/articles/injection.html). Nós também temos um [bom tutorial](di) cobrindo vários casos de uso.
{: .alert .alert-warning }

### Factory Default

O [Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) é uma variante de [Phalcon\Di](api/Phalcon_Di). Para facilitar as coisas, ele registrará automaticamente a maioria dos componentes que são requeridos por padrão em uma aplicação escrita com Phalcon. Embora seja recomendado criar serviços manualmente, você pode usar o contêiner [Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) inicialmente e depois ao personalizá-lo para atender suas necessidades.

Serviços podem ser registrados de várias formas, mas para nosso tutorial, usaremos uma [função anônima](https://php.net/manual/en/functions.anonymous.php):

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// Create a DI
$container = new FactoryDefault();
```

Agora precisamos registrar o serviço *view*, definindo o diretório onde a estrutura encontrará os arquivos de exibição. Como as views não correspondem a classes, elas não podem ser carregadas automaticamente pelo nosso autoloader.

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');

        return $view;
    }
);
```

Precisamos agora de registrar uma URI base, que ofereça a funcionalidade de criar todas as URIs do Phalcon. O componente garantirá que se você executar sua aplicação através do diretório superior ou de um subdiretório, todos os seus URIs estarão corretos. Para este tutorial, nosso caminho base é `/`. Isso se mostrará importante mais adiante neste tutorial, quando utilizarmos a classe `Phalcon\Tag` para gerar os links.

`public/index.php`

```php
<?php

use Phalcon\Url;

// ...

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');

        return $url;
    }
);
```

### Tratando as Requisições da Aplicação

Para lidar com quaisquer requisições, o objeto [Phalcon\Mvc\Application](application) é usado para fazer todo o trabalho pesado para nós. O componente aceitará a solicitação do usuário, detectará as rotas, despachará o controlador e renderizará a view retornando os resultados.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($container);

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

$response->send();
```

### Juntando Tudo

O arquivo `tutorial/public/index.php` deve se parecer com o seguinte:

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;

// Define some absolute path constants to aid in locating resources
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

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);

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

Como você pode ver, o arquivo de inicialização é muito curto e não precisamos incluir nenhum arquivo adicional. Parabéns por ter criado uma aplicação MVC flexível com menos de 60 linhas de código bem estruturado.

## Criando um Controller

Por padrão o Phalcon procurará por um controlador chamado `IndexController`. Ele é o ponto de partida quando nenhum comtrolador ou ação é inserido na Url da requisição (ex: `https://localhost/`). Um `IndexController` e seu `IndexAction` devem se parecer com o seguinte exemplo:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return '<h1>Hello!</h1>';
    }
}
```

As classes do controller devem ter o sufixo `Controller` e as ações do controller devem ter o sufixo `Action`. Para obter mais informações, você pode ler nosso documento sobre os <controllers>. Se você acessar a aplicação pelo seu navegador, deverá ver algo parecido com isto:

![](/assets/images/content/tutorial-basic-1.png)

> **Parabéns, você está Foando com o Falcão (Phlying with Phalcon)!**
{: .alert .alert-info }

## Enviando a Saída pela View

O envio de dados para a tela através do controlador é por vezes necessário, mas não é desejável como a maioria dos puristas da comunidade MVC atestarão. Tudo deve ser passado para a view que é responsável por enviar os dados na tela. O Phalcon procurará por uma "view" com o mesmo nome da última "action" executada dentro do diretório com o nome do último "controller" executado.

Portanto, no nosso caso, se a URL é:

```php
http://localhost/
```

irá invocar o `IndexController` e `indexAction`, e irá pesquisar a visualização:

```php
/views/index/index.phtml
```

Se for encontrado, irá analisá-lo e enviar a saída na tela. Nossa visão então terá o seguinte conteúdo:

`app/views/index/index.phtml`

```php
<?php echo "<h1>Hello!</h1>";
```

e já que nós movemos o `echo` de nosso controller para a view, ele estará vazio agora:

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

A saída do navegador permanecerá a mesma. O componente `Phalcon\Mvc\View` é criado automaticamente quando a ação de execução termina. Você pode ler mais sobre views em Phalcon [aqui](views).

## Criando um Formulário de Cadastro

Agora vamos alterar o arquivo de exibição `index.phtml` para adicionar um link para um novo controlador chamado *signup*. O objetivo é permitir que os usuários possam se cadastrar em nossa aplicação:

`app/views/index/index.phtml`

```php
<?php

echo "<h1>Hello!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    'signup',
    'Sign Up Here!'
);
```

O código HTML gerado exibe um link (`<a>`) HTML com endereço para um novo controlador:

`app/views/index/index.phtml` (rendered)

```html
<h1>Hello!</h1>

<a href="/signup">Sign Up Here!</a>
```

Para gerar o link para a tag `<a>`, usamos o componente[Phalcon\Tag](tag). Esta é uma classe de utilitários que oferece uma maneira fácil de construir tags HTML com as convenções do framework em mente. Esta classe também é um serviço registrado no Injetor de Dependência, assim podemos usar `$this->etiqueta` para acessar sua funcionalidade.

> **NOTA**: `Phalcon\Tag` já está registrado no contêiner de DI, uma vez que usamos o recipiente `Phalcon\Di\FactoryDefault`. Se você registrou todos os serviços manualmente, você precisará registrar este componente em seu contêiner para torná-lo disponível em seu aplicativo.
{: .alert .alert-info }

O componente [Phalcon\Tag](tag) também usa o componente [Phalcon\Uri](uri) registrado anteriormente para gerar URIs corretamente. Um artigo mais detalhado sobre a geração de HTML [pode ser encontrado aqui](tag).

![](/assets/images/content/tutorial-basic-2.png)

E o Signup controller é (`app/controllers/SignupController.php`):

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

A ação index vazia dá passagem livre para a view com a definição do formulário (`app/views/signup/index.phtml`):

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

Visualizando o formulário em seu navegador exibirá o seguinte:

![](/assets/images/content/tutorial-basic-3.png)

Como mencionado acima, a classe utilitária [Phalcon\Tag](tag) expõe métodos úteis que permitem construir elementos HTML com facilidade. O método `Phalcon\Tag::form()` recebe apenas um parâmetro por instância, uma URI relativa para o controller/action na aplicação. O `Phalcon\Tag::textField()` cria um elemento HTML de texto com o nome como parâmetro passado, enquanto o `Phalcon\Tag::submitButton()` cria um botão HTML de envio.

Clicando no botão *Register*, você notará uma exceção lançada do framework indicando que está faltando a ação `register` no controller `signup`. Nosso arquivo `public/index.php` lançou a seguinte exceção:

```bash
Exception: Action "register" was not found on handler "signup"
```

Implementando este método iremos remover a exceção:

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

Se você clicar no botão *Register* novamente, você verá uma página em branco. Mais tarde adicionaremos uma visão que fornecerá um feedback mais interessante. Mas, primeiro, devemos trabalhar no código para armazenar as entradas do usuário em uma base de dados.

De acordo com as orientações do MVC, as interacções no banco de dados devem ser feitas através de "models" que assegurem um código limpo e orientado para objetos.

## Criando um Model

O Phalcon trás o primeiro ORM para PHP escrito completamente em linguagem C. Ao invés de aumentar a complexidade do desenvolvimento, ele o simplifica.

Antes de criar nosso primeiro modelo, precisamos criar uma tabela de banco de dados usando uma ferramenta de acesso ao banco de dados ou o cliente de linha de comando do banco de dados. Para este tutorial, estamos utilizando o MySQL como nosso banco de dados, uma tabela simples para armazenar usuários registrados pode ser criada da seguinte forma:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

Um model (`app/models/Users.php`) deve estar localizado no diretório `app/models`. O model aponta para a tabela *users*:

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

> **NOTA**: Observe que as propriedades públicas do model correspondem aos nomes dos campos em nossa tabela. 
{: .alert .alert-info }

## Configurando uma Conexão com o Banco

Para utilizar uma conexão com o banco de dados e, posteriormente, acessar os dados através de nossos modelos, precisamos especificá-la em nosso processo de bootstrap. Uma conexão com uma base de dados é apenas outro serviço que a nossa aplicação tem, que pode ser utilizado em toda a nossa aplicação:

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);
```

Ajuste o trecho de código acima de forma apropriada para o seu banco de dados.

Com os parâmetros corretos da base de dados, nosso model está pronto para interagir com o resto da aplicação para que possamos salvar a entrada do usuário. Primeiramente, vamos dar um tempo e criar uma view para `SignupController::registerAction()` que irá exibir uma mensagem que permitirá que o usuário saiba o resultado da operação *save*.

`app/views/signup/register.phtml`

```php
<div class="alert alert-<?php echo $success === true ? 'success' : 'danger'; ?>">
    <?php echo $message; ?>
</div>

<?php echo $this->tag->linkTo(['/', 'Go back', 'class' => 'btn btn-primary']); ?>
```

Note que adicionamos algum estilo css no código acima. Vamos cobrir a inclusão da folha de estilos na seção [Estilos](#styling) abaixo.

## Armazenando Dados Usando Models

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

        //atribui o valor do formulário para $user
        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        // grava e verifica por erros
        $success = $user->save();

        // envia o resultado para a view
        $this->view->success = $success;

        if ($success) {
            $message = "Thanks for registering!";
        } else {
            $message = "Sorry, the following problems were generated:<br>"
                     . implode('<br>', $user->getMessages());
        }

        // passa a mensagem para a view
        $this->view->message = $message;
    }
}
```

No início da `registerAction` nós criamos um objeto de usuário vazio usando a classe `Users` que criamos anteriormente. Nós usaremos essa classe para gerenciar o registro de um usuário. Como mencionado acima, as propriedades públicas da classe são mapeadas para os campos da tabela </code>users` em nosso banco de dados. Definir os valores relevantes no novo registro e chamar <code>save()` armazenará os dados no banco de dados para esse registro. O método `save()` retorna um valor `booleano` que indica se a inserção foi bem sucedida ou não.

O ORM escapa automaticamente a entrada de dados prevenindo SQL injection, desta forma nós precisamos apenas passar a requisição para o método `save()`.

Validações adicionais acontecem automaticamente para campos que são definidos como not null (obrigatório). Se não informarmos nenhum dos campos obrigatórios no formulário de cadastro, nossa tela ficará assim:

![](/assets/images/content/tutorial-basic-4.png)

## Listar os Usuários Registrados

Agora precisamos obter e exibir todos os usuários registrados no nosso banco de dados

A primeira coisa que vamos fazer em nossa `indexAction` do `IndexController` é mostrar o resultado da busca de todos os usuários que é feito simplesmente chamando o método estático `find()` em nosso model (`Usuários::find()`).

`indexAction` ficaria da seguinte forma:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * Bem-vindo e lista de usuários
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
    }
}
```

> **NOTA**: Atribuímos os resultados de `find` a uma propriedade mágica no objeto `view`. Isso define essa variável com os dados atribuídos e a disponibiliza em nossa view
{: .alert .alert-info } 

Em nosso arquivo de view `views/index/index.phtml` podemos usar a variável `$users` da seguinte forma:

A view deverá parecer com o seguinte:

`views/index/index.phtml`

```html
<?php

echo "<h1>Hello!</h1>";

echo $this->tag->linkTo(["signup", "Sign Up Here!", 'class' => 'btn btn-primary']);

if ($users->count() > 0) {
    ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3">Users quantity: <?php echo $users->count(); ?></td>
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

As you can see our variable `$users` can be iterated and counted. Você pode obter mais informações sobre como os modelos funcionam no nosso documento sobre [models](db-models).

![](/assets/images/content/tutorial-basic-5.png)

## Estilo

Agora podemos adicionar pequenos toques de design ao nosso aplicativo. Podemos adicionar o [Bootstrap CSS](https://getbootstrap.com/) em nosso código para que ele seja usado nas nossas view. Adicionaremos um arquivo `index.phtml` no diretório `views`, com o seguinte conteúdo:

`app/views/index.phtml`

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phalcon Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

No template acima, a linha mais importante é a chamada para o método `getContent()`. Esse método retorna todo o conteúdo gerado pela nossa view. Nosso aplicativo agora irá mostrar:

![](/assets/images/content/tutorial-basic-6.png)

## Conclusão

Como você pode ver é muito fácil começar a construir uma aplicação utilizando o Phalcon. Porque Phalcon é uma extensão carregada na memória, o tamanho do seu projeto será mínimo, enquanto ao mesmo tempo você vai desfrutar de um bom ganho de desempenho.

Se você está pronto para aprender mais dê uma olhada a seguir no [Tutorial Vökuró](tutorial-vokuro).
