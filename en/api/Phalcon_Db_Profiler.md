# Class **Phalcon\\Db\\Profiler**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/profiler.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Instances of Phalcon\\Db can generate execution profiles
on SQL statements sent to the relational database. Profiled
information includes execution time in milliseconds.
This helps you to identify bottlenecks in your applications.

```php
<?php
use Phalcon\Db\Profiler;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

$profiler = new Profiler();
$eventsManager = new Manager();

$eventsManager->attach(
     "db",
     function (Event $event, $connection) use ($profiler) {
        if ($event->getType() === "beforeQuery") {
            $sql = $connection->getSQLStatement();

            // Start a profile with the active connection
            $profiler->startProfile($sql);
        }

        if ($event->getType() === "afterQuery") {
            // Stop the active profile
            $profiler->stopProfile();
        }
    }
);
// Set the event manager on the connection
$connection->setEventsManager($eventsManager);

$sql = "SELECT buyer_name, quantity, product_name
FROM buyers LEFT JOIN products ON
buyers.pid=products.id";

// Execute a SQL statement
$connection->query($sql);

// Get the last profile in the profiler
$profile = $profiler->getLastProfile();

echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
echo "Start Time: ", $profile->getInitialTime(), "\n";
echo "Final Time: ", $profile->getFinalTime(), "\n";
echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";

```


## Methods
public [Phalcon\Db\Profiler](/en/3.2/api/Phalcon_Db_Profiler) **startProfile** (*string* $sqlStatement, [*mixed* $sqlVariables], [*mixed* $sqlBindTypes])

Starts the profile of a SQL sentence



public  **stopProfile** ()

Stops the active profile



public  **getNumberTotalStatements** ()

Returns the total number of SQL statements processed



public  **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profiles



public  **getProfiles** ()

Returns all the processed profiles



public  **reset** ()

Resets the profiler, cleaning up all the profiles



public  **getLastProfile** ()

Returns the last profile executed in the profiler



