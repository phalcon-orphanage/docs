Консольные приложения
=====================

CLI приложения выполняются в командной строке. Они часто используются для работы cron'a, скриптов с долгим временем выполнения, командных утилит и т.п.

Задачи
------
Задачи похожи на контроллеры, в них может быть реализовано:

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

	// Используйте CLI factory в качестве контейнера ресурсов
	$di = new Phalcon\DI\FactoryDefault\CLI();

	// Создание консольного приложения
	$console = new \Phalcon\CLI\Console();
	$console->setDI($di);

	// Выполнение действия
	$console->handle(array('shell_script_name', 'echo'));

