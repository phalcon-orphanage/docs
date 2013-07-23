Nossa Motivação
==============
Hoje em dia existem muitos frameworks em php, todavia nenhum deles é como o Phalcon (Sério, acredite em nós quanto a esse framework).

A maioria dos programadores atualmente preferem utilizar um framework, esse fato ocorre principalmente pelo grande conjunto de funcionalidades já prontas e testadas para o uso, mantendo o code base DRY (acrônimo de Don't Repeat Yourself). Entretanto, um framework por si só demanda uma porção de inclusões de arquivos e centenas de linhas de código para serem interpretadas e executadas a cada requisição da aplicação. Frameworks Orientados à Objeto também adicionam bastante overhead à cada execução, deixando a aplicação complexa e lenta. Todas essas operações retardam a aplicação e consequentemente afeta a experiencia do usuário final.

A Questão
------------
Porque não podemos ter um framework robusto com todas suas vantagens sem nenhuma ou pouca desvantagem?

É por esse motivo que nasceu o Phalcon!

Durante os último meses, pesquisamos extensivamente o comportamento do PHP, investigando áreas de significantes otimizações (pequenas ou grande).
Através desse entendimento, removemos validações desnecessárias, compactando o código, executamos otimizações à um baixo nível de solução, assim alcançamos o máximo de performance para o Phalcon.

Por que?
----
* O uso do framework tornou-se mandatório para um profissional de desenvolvimento em PHP.
* Frameworks oferecem um conjunto de princípios estruturados que facilitam a manutenção do projeto, escrevendo menos código e tornando o trabalho mais divertido. 
* Nós adoramos PHP e o consideramos que o mesmo pode ser utilizado na criação de grandes e ambiciosos projetos.

Como é o funcionamento interno do PHP?
----------------------
* PHP possui tipagem de variáveis dinâmica e fraca. Toda vez que uma operação ocorre (ex. 2 + “2”), o PHP verifica o tipo de operação e executa as devidas conversões dos dados.
* PHP é interpretado e não compilado. A maior desvantagem dessa característica é a perda de performance.
* Toda vez que um script é requisitado, primeiramente deverá ser interpretado.
* Se o cache do bytecode (como o APC) não estiver habilitado, a cada requisição o compilador ira fazer a checagem da sintaxe para todos os arquivos.

Como os tradicionais frameworks em PHP funcionam?
------------------------------------
* Muitos arquivos com definição de classes e funções são lidos a cada requisição. A leitura em disco onera em termos de performance, especialmente quando os arquivos são estruturados em profundas hierárquica de diretórios. 
* Frameworks modernos possuem inclusão automática de arquivos (autoload ou lazy-loading) para melhorar a performance, executando os arquivos sob demanda.
* Some of these classes contain methods that aren't used in every request but they're loaded always consuming memory
* Continuous loading or interpreting is expensive and impacts performance
* The framework code does not change very often, therefore an application needs to load and interpret it every time a request is made

How does a PHP C-extension work?
------------Object-Oriented frameworks also add a lot of overhead to execution making complex application slow.--------------------
* C extensions are loaded together with PHP one time on the web server's daemon start process
* Classes and functions provided by the extension are ready to use for any application
* The code isn't interpreted because is already compiled to a specific platform and processor

How does Phalcon work?
----------------------
* Components are loosely coupled. With Phalcon, nothing is imposed on you: you're free to use the full framework, or just some parts of it as a glue components.
* Low-level optimizations provides the lowest overhead for MVC-based applications
* Interact with databases with maximum performance by using a C-language ORM for PHP
* Phalcon directly accesses internal PHP structures optimizing execution in that way as well

Why do I need Phalcon?
----------------------
Each application requirements and tasks are different than another's. Some for instance are designed to do a set
of tasks and generate content that rarely changes. These applications can be created with any programming language or
framework. Using a front-end cache, usually makes such an application, no matter how poorly designed or slow it might be,
perform very fast.

Other applications generate content almost immediately that changes from request to request. In this case, PHP is used
to address all requests and generate the content. These applications can be APIs, discussion forums with high traffic loads,
blogs with a high number of comments and contributors, statistic applications, admin dashboards, enterprise resource
planners (ERP), business-intelligence software dealing with real time data and more.

An application will be as slow as its slowest component/process. Phalcon offers a very fast yet feature rich framework
that allows developers to concentrate on making their applications/code faster. Following proper coding processes,
Phalcon can deliver a lot more functionality/requests with less memory consumption and processing cycles.

Conclusion
----------
Phalcon is an effort to build the fastest framework for PHP. You now have an even easier and robust way
to develop applications with a framework implemented with the philosophy "Performance Really Matters"! Enjoy!
