---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Pengatur Acara

The purpose of this component is to intercept the execution of most of the other components of the framework by creating 'hook points'. These hook points allow the developer to obtain status information, manipulate data or change the flow of execution during the process of a component.

<a name='naming-convention'></a>

## Persetujuan Menamai

Phalcon events use namespaces to avoid naming collisions. Each component in Phalcon occupies a different event namespace and you are free to create your own as you see fit. Event names are formatted as `component:event`. For example, as [Phalcon\Db](api/Phalcon_Db) occupies the `db` namespace, its `afterQuery` event's full name is `db:afterQuery`.

When attaching event listeners to the events manager, you can use `component` to catch all events from that component (eg. `db` to catch all of the [Phalcon\Db](api/Phalcon_Db) events) or `component:event` to target a specific event (eg. `db:afterQuery`).

<a name='usage'></a>

## Contoh penggunaan

In the following example, we will use the EventsManager to listen for the `afterQuery` event produced in a MySQL connection managed by [Phalcon\Db](api/Phalcon_Db):

```php
<?php

menggunakan Phalcon\Acara\Peristiwa;
menggunakan Phalcon\Acara\Pengelola sebagai EventsManager;
menggunakan Phalcon\Db\Penghubung\Pdo\Mysql sebagai DbAdapter;

$eventsManager = EventsManager(); baru

$eventsManager->attach(
    'db:afterQuery',
    fungsi (Acara $event, $connection) {
        echo $connection->getSQLStatement();
    }
);

$connection = DbAdapter( baru
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Tetapkan eventManager ke sampel adaptor db
$connection->setEventsManager($eventsManager);

// kirimkan perintah SQL ke server database 
$connection->pertanyaan(
    'MEMILIH * DARI produk p DIMANA p.keadaan = 1'
);
```

Now every time a query is executed, the SQL statement will be echoed out. The first parameter passed to the lambda function contains contextual information about the event that is running, the second is the source of the event (in this case the connection itself). A third parameter may also be specified which will contain arbitrary data specific to the event.

<h5 class='alert alert-warning'>You must explicitly set the Events Manager to a component using the <code>setEventsManager()</code> method in order for that component to trigger events. You can create a new Events Manager instance for each component or you can set the same Events Manager to multiple components as the naming convention will avoid conflicts </h5>

Instead of using lambda functions, you can use event listener classes instead. Event listeners also allow you to listen to multiple events. In this example, we will implement the [Phalcon\Db\Profiler](api/Phalcon_Db_Profiler) to detect the SQL statements that are taking longer to execute than expected:

```php
<?php

menggunakan Phalcon\Db\Profiler;
menggunakan Phalcon\Acara\Peristiwa;
menggunakan Phalcon\Logger;
menggunakan Phalcon\Logger\Adapter\Berkas;

kelas MyDbListener
{
    perlindungan $profiler;

    perlindungan $logger;

    /**
     * Ciptakan profiler dan mulailah logging
     */
    fungsi umum  __membangun()
    {
        $this->profiler = Profiler(); baru
        $this->logger   = Logger('../apps/logs/db.log'); baru
    }

    /**
     * Ini dijalankan jika acara dipicu 'beforeQuery'
     */
    fungsi umum beforeQuery(Event $event, $connection)
    {
        $this->profiler->startProfile(
            $connection->getSQLStatement()
        );
    }

    /**
     * Ini dijalankan jika acara dipicu 'afterQuery'
     */
    fungsi umum afterQuery(Event $event, $connection)
    {
        $this->logger->log(
            $connection->getSQLStatement(),
            Logger::INFO
        );

        $this->profiler->stopProfile();
    }

    fungsi umum getProfiler()
    {
        kembali $this->profiler;
    }
}
```

Attaching an event listener to the events manager is as simple as:

```php
<?php

// Ciptakan sebuah pendengar database
$dbListener = MyDbListener(); baru

// Dengarkan semua database acara 
$eventsManager->attach(
    'db',
    $dbListener
);
```

The resulting profile data can be obtained from the listener:

```php
<?php

// Kirim perintah SQL ke server database
$connection->execute(
    'SELECT * FROM products p WHERE p.status = 1'
);

bagi tiap-tiap ($dbListener->getProfiler()->getProfiles() as $profile) {
    echo 'SQL Statement: ', $profile->getSQLStatement(), '\n';
    echo 'Start Time: ', $profile->getInitialTime(), '\n';
    echo 'Final Time: ', $profile->getFinalTime(), '\n';
    echo 'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), '\n';
}
```

<a name='components-that-trigger-events'></a>

## Mencipta bagian-bagian yang memicu Acara

You can create components in your application that trigger events to an EventsManager. As a consequence, there may exist listeners that react to these events when generated. In the following example we're creating a component called `MyComponent`. This component is EventsManager aware (it implements [Phalcon\Events\EventsAwareInterface](api/Phalcon_Events_EventsAwareInterface)); when its `someTask()` method is executed it triggers two events to any listener in the EventsManager:

```php
<?php

use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;

class MyComponent implements EventsAwareInterface
{
    protected $eventsManager;

    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->eventsManager = $eventsManager;
    }

    public function getEventsManager()
    {
        return $this->eventsManager;
    }

    public function someTask()
    {
        $this->eventsManager->fire('my-component:beforeSomeTask', $this);

        // Do some task
        echo 'Here, someTask\n';

        $this->eventsManager->fire('my-component:afterSomeTask', $this);
    }
}
```

Notice that in this example, we're using the `my-component` event namespace. Now we need to create an event listener for this component:

```php
<?php

menggunakan Phalcon\Acara\Peristiwa;

kelas SomeListener
{
    fungsi umum beforeSomeTask(Peristiwa $event, $myComponent)
    {
        echo "Here, beforeSomeTask\n";
    }

    fungsi umum afterSomeTask(Event $event, $myComponent)
    {
        echo "Here, afterSomeTask\n";
    }
}
```

Now let's make everything work together:

```php
<?php

menggunakan Phalcon\Acara\Pengatur seperti EventsManager;

// Ciptakan sebuah Pengatur Acara
$eventsManager = EventsManager(); baru

// Ciptakan contoh MyComponent
$myComponent = MyComponent(); baru

// Mengikat contoh ke eventManager
$myComponent->setEventsManager($eventsManager);

// Lampirkan pendengar ke EventManager
$eventsManager->attach(
    'my-component',
    new SomeListener()
);

// Jalankan metode di bagian
$myComponent->someTask();
```

As `someTask()` is executed, the two methods in the listener will be executed, producing the following output:

```bash
Sini, beforeSomeTask
Sini, someTask
Sini, afterSomeTask
```

Additional data may also be passed when triggering an event using the third parameter of `fire()`:

```php
<?php

$eventsManager->fire('my-component:afterSomeTask', $this, $extraData);
```

In a listener the third parameter also receives this data:

```php
<?php

menggunakan Phalcon\Acara\Peristiwa;

// Menerima data dalam parameter ketiga
$eventsManager->attach(
    'my-component',
    fungsi (Event $event, $component, $data) {
        print_r($data);
    }
);

// Menerima data dari konteks acara
$eventsManager->attach(
    'my-component',
    fungsi (Event $event, $component) {
        print_r($event->getData());
    }
);
```

<a name='using-services'></a>

## Menggunakan Layanan Dari DI

By extending [Phalcon\Mvc\User\Plugin](api/Phalcon_Mvc_User_Plugin), you can access services from the DI, just like you would in a controller:

```php
<?php

menggunakan Phalcon\Acara\Peristiwa;
menggunakan Phalcon\Mvc\Pengguna\Plugin;

kelas SomeListener memperluas Plugin
{
    fungsi umum beforeSomeTask(Event $event, $myComponent)
    {
        echo 'Here, beforeSomeTask\n';

        $this->logger->debug(
            'beforeSomeTask has been triggered'
        );
    }

    fungsi umum afterSomeTask(Event $event, $myComponent)
    {
        echo 'Here, afterSomeTask\n';

        $this->logger->debug(
            'afterSomeTask has been triggered'
        );
    }
}
```

<a name='propagation-cancellation'></a>

## Peristiwa Propaganda/Pembatalan

Many listeners may be added to the same event manager. This means that for the same type of event, many listeners can be notified. The listeners are notified in the order they were registered in the EventsManager. Some events are cancelable, indicating that these may be stopped preventing other listeners from being notified about the event:

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db',
    function (Event $event, $connection) {
        // We stop the event if it is cancelable
        if ($event->isCancelable()) {
            // Stop the event, so other listeners will not be notified about this
            $event->stop();
        }

        // ...
    }
);
```

By default, events are cancelable - even most of the events produced by the framework are cancelables. You can fire a not-cancelable event by passing `false` in the fourth parameter of `fire()`:

```php
<?php

$eventsManager->fire('my-component:afterSomeTask', $this, $extraData, false);
```

<a name='listener-priorities'></a>

## Prioaritas Pendengar

When attaching listeners you can set a specific priority. With this feature you can attach listeners indicating the order in which they must be called:

```php
<?php

$eventsManager->enablePriorities(true);

$eventsManager->attach('db', new DbListener(), 150); // More priority
$eventsManager->attach('db', new DbListener(), 100); // Normal priority
$eventsManager->attach('db', new DbListener(), 50);  // Less priority
```

<a name='collecting-responses'></a>

## Mengumpulkan Tanggapan

The events manager can collect every response returned by every notified listener. This example explains how it works:

```php
<?php

use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();

// Set up the events manager to collect responses
$eventsManager->collectResponses(true);

// Attach a listener
$eventsManager->attach(
    'custom:custom',
    function () {
        return 'first response';
    }
);

// Attach a listener
$eventsManager->attach(
    'custom:custom',
    function () {
        return 'second response';
    }
);

// Fire the event
$eventsManager->fire('custom:custom', null);

// Get all the collected responses
print_r($eventsManager->getResponses());
```

The above example produces:

```php
    Array ( [0] => first response [1] => second response )
```

<a name='custom'></a>

## Melaksanakan EventsManager milik kamu sendiri

The [Phalcon\Events\ManagerInterface](api/Phalcon_Events_ManagerInterface) interface must be implemented to create your own EventsManager replacing the one provided by Phalcon.

<a name='list'></a>

## List of Events

The events available in Phalcon are:

| Component          | Acara                                  |
| ------------------ | -------------------------------------- |
| ACL                | `acl:afterCheckAccess`                 |
| ACL                | `acl:beforeCheckAccess`                |
| Application        | `application:afterHandleRequest`       |
| Application        | `application:afterStartModule`         |
| Application        | `application:beforeHandleRequest`      |
| Application        | `application:beforeSendResponse`       |
| Application        | `application:beforeStartModule`        |
| Application        | `application:boot`                     |
| Application        | `application:viewRender`               |
| CLI                | `dispatch:beforeException`             |
| Collection         | `afterCreate`                          |
| Collection         | `afterSave`                            |
| Collection         | `afterUpdate`                          |
| Collection         | `setelahPengesahan`                    |
| Collection         | `setelahPengesahanPadaBuat`            |
| Collection         | `setelahPengesahanDiUpdate`            |
| Collection         | `sebelummembuat`                       |
| Collection         | `sebelumdisimpan`                      |
| Collection         | `sebelummemperbarui`                   |
| Collection         | `sebelumValidasi`                      |
| Collection         | `sebelumPengesahanPadaBuat`            |
| Collection         | `sebelumPengesahanDiPerbaharui`        |
| Collection         | `notDeleted`                           |
| Collection         | `notSave`                              |
| Collection         | `tidak disimpan`                       |
| Collection         | `padaPengesahanGagal`                  |
| Collection         | `validation`                           |
| Collection Manager | `collectionManager:afterInitialize`    |
| Console            | `console:afterHandleTask`              |
| Console            | `console:afterStartModule`             |
| Console            | `console:beforeHandleTask`             |
| Console            | `console:beforeStartModule`            |
| Db                 | `db:afterQuery`                        |
| Db                 | `db:beforeQuery`                       |
| Db                 | `db:beginTransaction`                  |
| Db                 | `db:createSavepoint`                   |
| Db                 | `db:commitTransaction`                 |
| Db                 | `db:releaseSavepoint`                  |
| Db                 | `db:rollbackTransaction`               |
| Db                 | `db:rollbackSavepoint`                 |
| Dispatcher         | `dispatch:afterExecuteRoute`           |
| Dispatcher         | `dispatch:afterDispatch`               |
| Dispatcher         | `dispatch:afterDispatchLoop`           |
| Dispatcher         | `dispatch:afterInitialize`             |
| Dispatcher         | `dispatch:beforeException`             |
| Dispatcher         | `dispatch:beforeExecuteRoute`          |
| Dispatcher         | `dispatch:beforeDispatch`              |
| Dispatcher         | `dispatch:beforeDispatchLoop`          |
| Dispatcher         | `dispatch:beforeForward`               |
| Dispatcher         | `dispatch:beforeNotFoundAction`        |
| Loader             | `loader:afterCheckClass`               |
| Loader             | `loader:beforeCheckClass`              |
| Loader             | `loader:beforeCheckPath`               |
| Loader             | `loader:pathFound`                     |
| Micro              | `micro:afterHandleRoute`               |
| Micro              | `micro:afterExecuteRoute`              |
| Micro              | `micro:beforeExecuteRoute`             |
| Micro              | `micro:beforeHandleRoute`              |
| Micro              | `micro:beforeNotFound`                 |
| Middleware         | `setelah mengikat`                     |
| Middleware         | `setelah melakukan eksekusi rute`      |
| Middleware         | `setelahHandleRoute`                   |
| Middleware         | `sebelum melakukan eksekusi rute`      |
| Middleware         | `sebelum menangani router`             |
| Middleware         | `sebelum tidak ditemukan`              |
| Model              | `afterCreate`                          |
| Model              | `afterDelete`                          |
| Model              | `afterSave`                            |
| Model              | `afterUpdate`                          |
| Model              | `setelahPengesahan`                    |
| Model              | `setelahPengesahanPadaBuat`            |
| Model              | `setelahPengesahanDiUpdate`            |
| Model              | `beforeDelete`                         |
| Model              | `notDeleted`                           |
| Model              | `sebelummembuat`                       |
| Model              | `beforeDelete`                         |
| Model              | `sebelumdisimpan`                      |
| Model              | `sebelummemperbarui`                   |
| Model              | `sebelumValidasi`                      |
| Model              | `sebelumPengesahanPadaBuat`            |
| Model              | `sebelumPengesahanDiPerbaharui`        |
| Model              | `notSave`                              |
| Model              | `tidak disimpan`                       |
| Model              | `padaPengesahanGagal`                  |
| Model              | `prepareSave`                          |
| Manajer Model      | `manajermodel:setelahmenginisialisasi` |
| Request            | `request:afterAuthorizationResolve`    |
| Request            | `request:beforeAuthorizationResolve`   |
| Router             | `router:beforeCheckRoutes`             |
| Router             | `router:beforeCheckRoute`              |
| Router             | `router:matchedRoute`                  |
| Router             | `router:notMatchedRoute`               |
| Router             | `router:afterCheckRoutes`              |
| Router             | `router:beforeMount`                   |
| View               | `view:afterRender`                     |
| View               | `view:afterRenderView`                 |
| View               | `view:beforeRender`                    |
| View               | `view:beforeRenderView`                |
| View               | `view:notFoundView`                    |
| Volt               | `compileFilter`                        |
| Volt               | `compileFunction`                      |
| Volt               | `compileStatement`                     |
| Volt               | `resolveExpression`                    |