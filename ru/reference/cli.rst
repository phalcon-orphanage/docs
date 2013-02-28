Консольные приложения
=====================

CLI приложения выполняются в командной строке. Они часто используются для работы cron'a, скриптов с долгим временем выполнения, командных утилит и т.п.

Задачи
------
Задачи похожи на контроллеры, в них может быть реализовано

.. code-block:: php

	<?php

	class MonitoringTask extends \Phalcon\CLI\Task
	{

	    public function mainAction()
	    {

	    }

	}

.. code-block:: php

	<?php

	//Using the CLI factory default services container
	$di = new Phalcon\DI\FactoryDefault\CLI();

	//Create a console application
	$console = new \Phalcon\CLI\Console();
	$console->setDI($di);

	//
	$console->handle(array('shell_script_name', 'echo'));

