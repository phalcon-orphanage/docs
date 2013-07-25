Nossa Motivação
==============
Hoje em dia existem muitos frameworks em php, todavia nenhum deles é como o Phalcon (Sério, acredite em nós quanto a esse framework).

A maioria dos programadores atualmente preferem utilizar um framework, esse fato ocorre principalmente pelo grande conjunto de funcionalidades já prontas e testadas para o uso, mantendo o code base DRY (acrônimo de Don't Repeat Yourself). Entretanto, um framework por si só demanda uma porção de inclusões de arquivos e centenas de linhas de código para serem interpretadas e executadas a cada requisição da aplicação. Frameworks Orientados à Objeto também adicionam bastante overhead à cada execução, deixando a aplicação complexa e lenta. Todas essas operações retardam a aplicação e consequentemente afeta a experiencia do usuário final.

A Questão
------------
Porque não podemos ter um framework robusto com todas suas vantagens sem nenhuma ou pouca desvantagem?

É por essa questão que o Phalcon nasceu!

Durante os último meses, pesquisamos extensivamente o comportamento do PHP, investigando áreas de significantes otimizações (pequenas ou grande).
Através desse entendimento, removemos validações desnecessárias, compactando o código, executando otimizações e geramos soluções de baixo nível, assim alcançamos o máximo de performance para o Phalcon.

Por que?
----
* O uso do framework tornou-se mandatório para um profissional de desenvolvimento em PHP.
* Frameworks oferecem um conjunto de princípios estruturados que facilitam a manutenção do projeto, escrevendo menos código e tornando o trabalho mais divertido. 
* Nós adoramos PHP e consideramos que o mesmo pode ser utilizado na criação de grandes e ambiciosos projetos.

Como é o funcionamento interno do PHP?
----------------------
* PHP possui tipagem de variáveis dinâmica e fraca. Toda vez que uma operação ocorre (ex. 2 + “2”), o PHP verifica o tipo dos operadores e executa as devidas conversões dos dados.
* PHP é interpretado e não compilado. A maior desvantagem dessa característica é a perda de performance.
* Toda vez que um script é requisitado, primeiramente deverá ser interpretado.
* Se o cache do bytecode (como o APC) não estiver habilitado, a cada requisição o compilador ira fazer a checagem da sintaxe para todos os arquivos.

Como os tradicionais frameworks em PHP funcionam?
------------------------------------
* Muitos arquivos com definição de classes e métodos são lidos a cada requisição. A leitura em disco onera em termos de performance, especialmente quando os arquivos são estruturados em profundas hierarquias de diretórios. 
* Frameworks modernos possuem inclusão automática de arquivos (autoload,lazy loading) para melhorar a performance, executando os arquivos sob demanda.
* Algumas dessas classes contêm métodos que não são utilizados a toda requisição, todavia a toda requisição tais métodos são interpretados e sempre consumindo memória 
* O carregamento continuo e a interpretação dos códigos onera e impacta na performance 
* O código de um framework não é alterado com frequência, entretanto uma aplicação precisa carregar e interpretar esse código a toda requisição.

Como uma extensão em C funciona no PHP?
--------------------------------
* Extensões em C são carregadas junto com o PHP uma única vez quando o daemon do servidor web é startado.
* Classes e funções fornecidas pela extensão ficam prontas para uso por qualquer aplicação no servidor.
* O código não é interpretado, pois já foi compilado para a plataforma e processador específicos 

Como o Phalcon funciona?
----------------------
* Componentes possuem baixo acoplamento. Com o Phalcon, nada é imposto a você (desenvolvedor): você é livre para utilizar o framework completo, ou somente algumas partes, utilizando os componentes do frameworks de forma independente. 
* As otimizações de baixo nível fornecem menos overhead para aplicações baseadas em MVC. 
* Utilizando ORM para PHP com a linguagem em C, interage com banco de dados com o máximo de desempenho 
* Phalcon acessa diretamente as estruturas internas do PHP, otimizando a execução da melhor forma.

Por que preciso do Phalcon?
----------------------
Os requisitos de cada aplicação e suas atividades são diferentes uma das outras. Algumas dessas, por exemplo, são projetadas para executar um conjunto de atividades que raramente geram conteúdos modificados. Tais aplicações podem ser criadas com qualquer linguagem ou framework. Utilizando um sistema de cache para o conteúdo, e normalmente tais aplicações o utilizam, não importa o quão mal projetada ou quão lenta ela pode ser, elas executam rapidamente.

Outras aplicações geram conteúdos quase que instantaneamente com alterações à toda requisição. E nesse caso, o PHP trata todas as requisições e gera o respectivo conteúdo. Essas aplicações podem ser APIs,forums de discussão com cargas de alto tráfego, blogs com um grade número de comentários e colaboradores, aplicações de estatísticas, painéis administrativo, sistemas integrados de gestão empresarial (SIGE ou SIG, do inglês ERP), softwares de Inteligência Empresarial (Business Intelligence) que tratam os dados em tempo real e muito mais outros.

Uma aplicação será tão lenta quanto os seus componentes/processos mais lentos forem. Phalcon oferece um framework muito rápido (de grande performance) e ainda  repleto de ricas funcionalidades, que permiti aos desenvolvedores concentrarem em fazer suas aplicações/código mais veloz. Seguindo adequadamente os processos de codificação, Phalcon pode produzir muito mais funcionalidades por requisições, com menos consumo de memória e ciclos de processamento.

Conclusão
----------
Phalcon é um esforço para criar o mais rápido framework para PHP. Agora você tem uma forma fácil e robusta para desenvolver aplicações com um framework implementado com a filosofia: ”Desempenho Realmente Importa”! Aproveite!

