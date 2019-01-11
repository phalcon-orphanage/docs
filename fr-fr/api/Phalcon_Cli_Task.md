* * *

layout: default language: 'en' version: '4.0' title: 'Phalcon\Cli\Task'

* * *

# Class **Phalcon\Cli\Task**

*extends* abstract class [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](/3.4/en/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/3.4/en/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Cli\TaskInterface](/3.4/en/api/Phalcon_Cli_TaskInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/cli/task.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Every command-line task should extend this class that encapsulates all the task functionality

A task can be used to run "tasks" such as migrations, cronjobs, unit-tests, or anything that you want. The Task class should at least have a "mainAction" method

```php
<?php

class HelloTask extends \Phalcon\Cli\Task
{
    // This action will be executed by default
    public function mainAction()
    {

    }

    public function findAction()
    {

    }
}

```

## Methods

final public **__construct** ()

Phalcon\Cli\Task constructor

public **setDI** ([Phalcon\DiInterface](/3.4/en/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/3.4/en/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Returns the internal event manager

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/3.4/en/api/Phalcon_Di_Injectable)

Magic method __get