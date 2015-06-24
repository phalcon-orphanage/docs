Aplicações de Linha de Comando
=========================
Aplicações CLI são executadas pela linha de comando. Elas são usadas para criar tarefas agendadas (Cron Jobs), scripts, comandos úteis e muito mais.

Tarefas (Tasks)
-----
Tarefas são similares aos controladores, são implementadas como eles

.. code-block:: php

    <?php

    class MonitoringTask extends \Phalcon\CLI\Task
    {

        public function mainAction()
        {

        }

    }

Criando um Bootstrap
--------------------
Como nas aplicações MVC, o bootstrap também é disponível
.. code-block:: php

    <?php

    use Phalcon\DI\FactoryDefault\CLI as CliDI,
        Phalcon\CLI\Console as ConsoleApp;

    //Using the CLI factory default services container
    $di = new CliDI();

    //Create a console application
    $console = new ConsoleApp();
    $console->setDI($di);

    //
    $console->handle(array('task' => 'shell_script_name', 'action' => 'echo'));

