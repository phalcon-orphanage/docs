# Phalcon sınıfı**\\Cli\\Görev**

*uzanır* soyut sınıf [Phalcon\Di\Enjekt et](/en/3.2/api/Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Cli\TaskInterface](/en/3.2/api/Phalcon_Cli_TaskInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cli/task.zep" class="btn btn-default btn-sm">Github Kaynağı</a>

Every command-line task should extend this class that encapsulates all the task functionality

Bir görev, geçişler, cron işleri, birim testler veya istediğiniz herhangi bir şey gibi "görevler" i çalıştırmak için kullanılabilir. Görev sınıfının en azından bir "ana eylem" yöntemine sahip olması gerekir

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

Phalcon\\Cli\\Görev yapıcı

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

İç bağımlılık enjektörünü döndürür

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Sets the event manager

herkese açık **Etkinlik Yöneticisi'ni al** () [Phalcon\Di\Enjekte et](/en/3.2/api/Phalcon_Di_Injectable)'den alındı

Returns the internal event manager

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

Magic method __get