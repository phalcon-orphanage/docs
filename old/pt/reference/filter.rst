Filtrando e Normalizando
========================

Limpar a entrada do usuário é uma parte crítica do desenvolvimento de software. Confiando nos dados passados pelo usuário pode levar ao acesso não autorizado ao conteúdo de sua aplicação, principalmente os dados do usuário, ou até mesmo o servidor o aplicativo está hospedado.

.. figure:: ../_static/img/sql.png
   :align: center

`Imagem completa (de xkcd)`_

O componente :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` provê um conjunto de filtros e normalizadores. Fornece uma camada orientada a objetos em torno da extensão filter do PHP.

Tipos de Filtros imbutidos
--------------------------
Os seguintes filtros imbutidos estão disponíveis por esse componente:

+-----------+------------------------------------------------------------------------------+
| Nome      | Descrição                                                                    |
+===========+==============================================================================+
| string    | Remove tags e codificar entidades HTML, incluindo aspas duplas e simples.    |
+-----------+------------------------------------------------------------------------------+
| email     | Remove todos os caracteres exceto letras, digitos e !#$%&*+-/=?^_`{\|}~@.[]  |
+-----------+------------------------------------------------------------------------------+
| int       | Remove todos os caracteres exceto digitos, simbolos de mais e menos          |
+-----------+------------------------------------------------------------------------------+
| float     | Remove todos os caracteres exceto digitos, ponto, simbolos de mais e menos   |
+-----------+------------------------------------------------------------------------------+
| alphanum  | Remove todos os caracteres exceto [a-zA-Z0-9]                                |
+-----------+------------------------------------------------------------------------------+
| striptags | Aplica a função strip_tags_                                                  |
+-----------+------------------------------------------------------------------------------+
| trim      | Aplica a função trim_                                                        |
+-----------+------------------------------------------------------------------------------+
| lower     | Aplica a função strtolower_                                                  |
+-----------+------------------------------------------------------------------------------+
| upper     | Aplica a função strtoupper_                                                  |
+-----------+------------------------------------------------------------------------------+

Normalizando dados
------------------
Normalização é o processo que remove caracteres específicos de um valor, que não são requeridos ou desejados pelo usuário ou aplicação.
Pelas entradas de normalização de dados podemos garantir que a integridade da aplicação estará intacta.

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Returns "someone@example.com"
    $filter->sanitize("some(one)@exa\mple.com", "email");

    // Returns "hello"
    $filter->sanitize("hello<<", "string");

    // Returns "100019"
    $filter->sanitize("!100a019", "int");

    // Returns "100019.01"
    $filter->sanitize("!100a019.01a", "float");


Normalizando a partir de Controladores
--------------------------------------
Você pode usar um objeto :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` a partir de seus controladores quando estiver acessando dados de entrada via GET ou POST
(pelo objeto de requisição). O primeiro parâmetro é o nome da variável que foi obtida; o segundo parâmetro é o filtro a ser aplicado.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Sanitizing price from input
            $price = $this->request->getPost("price", "double");

            // Sanitizing email from input
            $email = $this->request->getPost("customerEmail", "email");
        }
    }

Filtrando parâmetros de uma action
----------------------------------
O próximo exemplo mostra como você normaliza parâmetros passados para uma "action" de um controlador:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($productId)
        {
            $productId = $this->filter->sanitize($productId, "int");
        }
    }

Filtrando dados
---------------
Além de normalização, :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` também disponhe de filtragem por remoção ou modificação de dados de entrada para
o formato que esperamos.

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Returns "Hello"
    $filter->sanitize("<h1>Hello</h1>", "striptags");

    // Returns "Hello"
    $filter->sanitize("  Hello   ", "trim");

Combining Filters
-----------------
You can also run multiple filters on a string at the same time by passing an array of filter identifiers as the second parameter:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Returns "Hello"
    $filter->sanitize(
        "   <h1> Hello </h1>   ",
        [
            "striptags",
            "trim",
        ]
    );

Criando seus próprios filtros
-----------------------------
Você pode adicionar seus próprios filtros em :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`. O filtro pode ser uma função anônima (lambda, closure):

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Using an anonymous function
    $filter->add(
        "md5",
        function ($value) {
            return preg_replace("/[^0-9a-f]/", "", $value);
        }
    );

    // Sanitize with the "md5" filter
    $filtered = $filter->sanitize($possibleMd5, "md5");

Ou, se preferir, você pode implementar uma classe filtro:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    class IPv4Filter
    {
        public function filter($value)
        {
            return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        }
    }

    $filter = new Filter();

    // Using an object
    $filter->add(
        "ipv4",
        new IPv4Filter()
    );

    // Sanitize with the "ipv4" filter
    $filteredIp = $filter->sanitize("127.0.0.1", "ipv4");

Filtragem e normalização complexa
---------------------------------
O PHP provê uma excelente extensão de filtros, você pode usá-la. Consulte a documentação: `Filtragem de Dados na Documentação PHP`_

Implementando seu próprio componente Filtro
-------------------------------------------
A :doc:`Phalcon\\FilterInterface <../api/Phalcon_FilterInterface>` interface precisa ser implementada para criar seu próprio serviço de filtragem, substituindo o provido pelo Phalcon.

.. _Imagem completa (de xkcd): http://xkcd.com/327/
.. _Filtragem de Dados na Documentação PHP: http://www.php.net/manual/pt_BR/book.filter.php
.. _strip_tags: http://www.php.net/manual/pt_BR/function.strip-tags.php
.. _trim: http://www.php.net/manual/pt_BR/function.trim.php
.. _strtolower: http://www.php.net/manual/pt_BR/function.strtolower.php
.. _strtoupper: http://www.php.net/manual/pt_BR/function.strtoupper.php
