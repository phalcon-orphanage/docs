命令行程序
=========================

命令行程序是指在命名行下执行的程序，他们通常用来创建定时(cron)任务，脚本，命令行式实用程序或其他。

Tasks
-----
Tasks are similar to controllers, on them can be implemented

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

