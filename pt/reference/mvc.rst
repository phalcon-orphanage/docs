A arquitetura MVC
=================

Phalcon oferece as classes orientadas a objeto, necessárias para implementar o Model, View, Controller architecture (muitas vezes referida como MVC_) em sua aplicação. Este padrão de projeto é amplamente utilizado por outros frameworks web e aplicações desktop.

Os benefícios MVC incluem: 

* Isolamento de lógica de negócios a partir da interface do usuário e a camada de banco de dados
* Deixando claro onde diferentes tipos de código pertencem para facilitar a manutenção

Se você decidir usar MVC, cada pedido dos recursos de seu aplicativo será gerido pela arquitetura MVC
As classes Phalcon são escritas na linguagem C, oferecendo uma abordagem de alto desempenho deste padrão em um aplicativo baseado em PHP.

Modelos
-------
Um modelo representa as informações (dados) da aplicação e as regras para manipular esses dados. Modelos são utilizados principalmente para gerir as regras de interação com uma tabela de banco de dados correspondente. Na maioria dos casos, cada tabela no banco de dados corresponderá a um modelo em seu aplicativo. A maior parte da sua lógica de negócios do aplicativo será concentrada nos modelos. :doc:`Learn more <models>`

Views
-----
Views representam a interface do usuário do seu aplicativo. As views são arquivos frequentemente HTML com código PHP embutido que executam tarefas referem-se exclusivamente à apresentação dos dados. Views lidam com o trabalho de fornecer dados para o navegador web ou outra ferramenta que é usado para fazer solicitações do seu aplicativo. :doc:`Learn more <views>`

Controladores
-------------
Os controladores fornecem o "fluxo" entre os modelos e as views. Controladores são responsáveis pelo processamento dos pedidos recebidos a partir do navegador web, interrogar os modelos de dados, e passando os dados as views para a apresentação. :doc:`Learn more <controllers>`

.. _MVC: http://pt.wikipedia.org/wiki/MVC
