<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">لایه انتزاعی پایگاه داده</a> <ul>
        <li>
          <a href="#adapters">وقفه دهنده های پایگاه داده</a> <ul>
            <li>
              <a href="#adapters-factory">کارخانه</a>
            </li>
            <li>
              <a href="#adapters-custom">پیاده سازی آداپتورهای خود</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#dialects">گفتگوهای بانک اطلاعاتی</a> <ul>
            <li>
              <a href="#dialects-custom">Implementing your own dialects</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#connection">Connecting to Databases</a>
        </li>
        <li>
          <a href="#options">Setting up additional PDO options</a>
        </li>
        <li>
          <a href="#finding-rows">Finding Rows</a>
        </li>
        <li>
          <a href="#binding-parameters">Binding Parameters</a>
        </li>
        <li>
          <a href="#crud">درج، به روز رسانی و حذف ردیف ها</a>
        </li>
        <li>
          <a href="#transactions">معاملات و معاملات نشتی</a>
        </li>
        <li>
          <a href="#events">رویدادهای بانک اطلاعاتی</a>
        </li>
        <li>
          <a href="#profiling">تدوین بیانیه های اس کیو ال</a>
        </li>
        <li>
          <a href="#logging-statements">ثبت گزارشات اس کیو ال</a>
        </li>
        <li>
          <a href="#logger-custom">پیاده سازی لاگر خودتان</a>
        </li>
        <li>
          <a href="#describing-tables">توصیف جداول/ نمایش ها</a>
        </li>
        <li>
          <a href="#tables">ایجاد/تغییر/حذف جداول</a> <ul>
            <li>
              <a href="#tables-create">ایجاد جداول</a>
            </li>
            <li>
              <a href="#tables-altering">تغییر جداول</a>
            </li>
            <li>
              <a href="#tables-dropping">سقوط جداول</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Database Abstraction Layer

`Phalcon\Db` is the component behind `Phalcon\Mvc\Model` that powers the model layer in the framework. It consists of an independent high-level abstraction layer for database systems completely written in C.

این اجزا به شما اجازه می دهد تا دستکاری پایگاه داده سطح پایین تر از استفاده از مدل های سنتی.

<a name='adapters'></a>

## وقفه دهنده های پایگاه داده

این مولفه از آداپتور ها برای ذخیره سازی جزئیات سیستم خاص اطلاعاتی استفاده می کند. فالکون از پی دی او برای اتصال به پایگاه داده استفاده می کند. موتورهای پایگاه اطلاعاتی زیر پشتیبانی شده اند:

| کلاس                                    | توضیحات                                                                                                                                                                                                                              |
| --------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `Phalcon\Db\Adapter\Pdo\Mysql`      | آیا این سیستم مدیریت پایگاه داده اطلاعاتی (آر دی پی ام اس) است که بیشترین استفاده را در جهان دارد و به عنوان سروری که دسترسی چند کاربره را به تعدادی از پایگاه های اطلاعاتی مهیا می کند                                              |
| `Phalcon\Db\Adapter\Pdo\Postgresql` | PostgreSQL is a powerful, open source relational database system. It has more than 15 years of active development and a proven architecture that has earned it a strong reputation for reliability, data integrity, and correctness. |
| `Phalcon\Db\Adapter\Pdo\Sqlite`     | اس کیو لایت یک کتابخانه نرم افزاری است که یک موتور کامل، بدون سرور، بدون سرور، بدون پیکربندی و با اطلاعات تراکنش اس کیو ال را اجرا می کند                                                                                            |

<a name='adapters-factory'></a>

### Factory

<a name='factory'></a>

Loads PDO Adapter class using `adapter` option

```php
<?php

use Phalcon\Db\Adapter\Pdo\Factory;

$options = [
    'host'     => 'localhost',
    'dbname'   => 'blog',
    'port'     => 3306,
    'username' => 'sigma',
    'password' => 'secret',
    'adapter'  => 'mysql',
];

$db = Factory::load($options);
```

<a name='adapters-custom'></a>

### پیاده سازی آداپتورهای خود

رابطه `Phalcon\Db\AdapterInterface` باید به منظور ایجاد آداپتورهای پایگاه خود یا گسترش آنهایی که وجود دارند، عمل کند.

<a name='dialects'></a>

## Database Dialects

فالکون جزئیات خاص موتور هر پایگاه اطلاعاتی را در نسخه ها ذخیره می کند. همان هایی که توابع مشترک و ژنراتور اس کیو ال را به آداپتورها ارائه می دهند.

| Class                              | Description                                         |
| ---------------------------------- | --------------------------------------------------- |
| `Phalcon\Db\Dialect\Mysql`      | SQL specific dialect for MySQL database system      |
| `Phalcon\Db\Dialect\Postgresql` | SQL specific dialect for PostgreSQL database system |
| `Phalcon\Db\Dialect\Sqlite`     | SQL specific dialect for SQLite database system     |

<a name='dialects-custom'></a>

### Implementing your own dialects

رابطه 0>Phalcon\Db\DialectInterface</code> باید به منظور ایجاد نسخ پایگاه های اطلاعاتی یا گسترش آنهایی که وجود دارند، عمل کند.

<a name='connection'></a>

## Connecting to Databases

برای ایجاد یک پیوند، نمونه سازی از کلاس آداپتور الزامی است. این فقط یک آرایه با پارامترهای اتصال نیاز دارد. مثال زیر چگونگی ایجاد یک پیوند که از پارامتر های اختیاری و مورد نظر بگذرد را نشان می دهد:

```php
<?php

// ضروری
$config = [
    'میزبان'     => '127.0.0.1',
    'نام کاربری' => 'mike',
    'کلمه عبور' => 'sigma',
    'نام پایگاه داده'   => 'test_db',
];

// اختیاری
$config['persistent'] = false;

// ایجاد یک اتصال
$connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);
```

```php
<?php

// ضروری
$config = [
    'میزبان'     => 'localhost',
    'نام کاربری' => 'postgres',
    'کلمه عبور' => 'secret1',
    'نام پایگاه داده'   => 'template',
];

// اختیاری
$config['schema'] = 'عمومی';

// ایجاد یک اتصال
$connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);
```

```php
<?php

// ضروری
$config = [
    'dbname' => '/path/to/database.db',
];

// ایجاد یک اتصال
$connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);
```

<a name='options'></a>

## Setting up additional PDO options

شما می توانید گزینه های پی دی او را هنگام اتصال با استفاده از عبور از گزینه های پارامترها، `تنظیم ها` کنید:

```php
<?php

// Create a connection with PDO options
$connection = new \Phalcon\Db\Adapter\Pdo\Mysql(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'sigma',
        'dbname'   => 'test_db',
        'options'  => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            PDO::ATTR_CASE               => PDO::CASE_LOWER,
        ]
    ]
);
```

<a name='finding-rows'></a>

## Finding Rows

`Phalcon\Db` چندین روش را برای پرس و جو از سطرهای جداول آماده می کند. ترکیب خاصی از اس کیو ال در موتور پایگاه داده هدف، در این مورد، نیاز است:

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';

// Send a SQL statement to the database system
$result = $connection->query($sql);

// Print each robot name
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Get all rows in an array
$robots = $connection->fetchAll($sql);
foreach ($robots as $robot) {
   echo $robot['name'];
}

// Get only the first row
$robot = $connection->fetchOne($sql);
```

به طور پیش فرض، این تماس ها، آرایه ها را با هر دو شاخص وابسته و عددی ایجاد می کنند. شما می توانید این رفتار را با استفاده از `Phalcon\Db\Result::setFetchMode()` تغییر دهید. این روش یک تعریف پایدار که نوعی از شاخص های مورد نیاز است را دریافت می کند.

| Constant                   | Description                                               |
| -------------------------- | --------------------------------------------------------- |
| `Phalcon\Db::FETCH_NUM`   | Return an array with numeric indexes                      |
| `Phalcon\Db::FETCH_ASSOC` | Return an array with associative indexes                  |
| `Phalcon\Db::FETCH_BOTH`  | Return an array with both associative and numeric indexes |
| `Phalcon\Db::FETCH_OBJ`   | Return an object instead of an array                      |

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';
$result = $connection->query($sql);

$result->setFetchMode(Phalcon\Db::FETCH_NUM);
while ($robot = $result->fetch()) {
   echo $robot[0];
}
```

`Phalcon\Db::query()` نمونه ای از `Phalcon\Db\Result\Pdo` را باز می گرداند. این اشیا تمام قابلیت های مرتبط با نتایج بازگشتی را محاسبه می کنند؛ برای مثال: تراورس، جستجوی پرونده های خاص، شمارش و غیره.

```php
<?php

$sql = 'SELECT id, name FROM robots';
$result = $connection->query($sql);

// Traverse the resultset
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Seek to the third row
$result->seek(2);
$robot = $result->fetch();

// Count the resultset
echo $result->numRows();
```

<a name='binding-parameters'></a>

## Binding Parameters

پارامتر های متصل نیز در `Phalcon\Db` پشتیبانی می شوند. اگرچه با استفاده از پارامتر های محدود، اثر کمتری بر عملکرد شما تاثیر می گذارد، شما را تشویق می کند که از این روش استفاده کنید تا بتوانید کد خود را در معرض حمله ی انتقال اس کیو ال قرار دهید. هم متغیرهای رشته ای و هم متغیرهای موقعیتی پشتیبانی می شوند. به سادگی می توان پارامتر های مرتبط را به صورت زیر بدست آورد:

```php
<?php

// Binding with numeric placeholders
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        'Wall-E',
    ]
);

// Binding with named placeholders
$sql     = 'INSERT INTO `robots`(name`, year) VALUES (:name, :year)';
$success = $connection->query(
    $sql,
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);
```

هنگام استفاده از متغیرهای عددی، شما باید آنها را به صورت صحیح و به عنوان مثال ۱ یا ۲ تعریف کنید. در این مورد "۱" یا "۲" به عنوان رشته درنظر گرفته می شوند نه به عنوان اعداد؛ بنابراین، محل نگهداری را نمی توان به صورت موفقیت آمیز جایگزین کرد. با هر آداپتور داده ها، به طور خودکار، با استفاده از [نقل قول پی دی او](http://www.php.net/manual/en/pdo.quote.php) می پرد.

این عمل، ارتباط چارست را به حساب می آورد. بنابراین توصیه می شود که پارامترهای صحیح را در پارامترهای اتصال یا پیکربندی سرور پایگاه داده تعریف کنید. زیرا به عنوان یک چارست اشتباه، هنگام ذخیره یا بازیابی داده ها، اثرات نامطلوب ایجاد می کند.

همچنین شما می توانید پارامترهای خود را به طور مستقیم به روش اجرا/پرس و جو منتقل کنید. در این حالت پارامترهای محدود به طور مستقیم به PDO منتقل می شوند:

```php
<?php

// Binding with PDO placeholders
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        1 => 'Wall-E',
    ]
);
```

<a name='crud'></a>

## درج، به روز رسانی و حذف ردیف ها

برای وارد کردن، به روزرسانی یا حذف ردیفها، میتوانید از اس کیوال خام استفاده کنید یا از توابع پیش تعیین شده ارائه شده توسط کلاس استفاده کنید:

```php
<?php

// Inserting data with a raw SQL statement
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        1952,
    ]
);

// Generating dynamically the necessary SQL
$success = $connection->insert(
    'robots',
    [
        'Astro Boy',
        1952,
    ],
    [
        'name',
        'year',
    ],
);

// Generating dynamically the necessary SQL (another syntax)
$success = $connection->insertAsDict(
    'robots',
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);

// Updating data with a raw SQL statement
$sql     = 'UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'UPDATE `robots` SET `name` = ? WHERE `id` = ?';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        101,
    ]
);

// Generating dynamically the necessary SQL
$success = $connection->update(
    'robots',
    [
        'name',
    ],
    [
        'New Astro Boy',
    ],
    'id = 101' // Warning! In this case values are not escaped
);

// Generating dynamically the necessary SQL (another syntax)
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    'id = 101' // Warning! In this case values are not escaped
);

// With escaping conditions
$success = $connection->update(
    'robots',
    [
        'name',
    ],
    [
        'New Astro Boy',
    ],
    [
        'conditions' => 'id = ?',
        'bind'       => [101],
        'bindTypes'  => [PDO::PARAM_INT], // Optional parameter
    ]
);
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    [
        'conditions' => 'id = ?',
        'bind'       => [101],
        'bindTypes'  => [PDO::PARAM_INT], // Optional parameter
    ]
);

// Deleting data with a raw SQL statement
$sql     = 'DELETE `robots` WHERE `id` = 101';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'DELETE `robots` WHERE `id` = ?';
$success = $connection->execute($sql, [101]);

// Generating dynamically the necessary SQL
$success = $connection->delete(
    'robots',
    'id = ?',
    [
        101,
    ]
);
```

<a name='transactions'></a>

## معاملات و معاملات نشتی

کار با معاملات، همانطور که با پی دی او است پشتیبانی می شود. دستکاری داده ها در میان معامله، اغلب، عملکرد در اکثر سیستم های پایگاه داده را افزایش می دهد:

```php
<?php

try {
    // Start a transaction
    $connection->begin();

    // Execute some SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 101');
    $connection->execute('DELETE `robots` WHERE `id` = 102');
    $connection->execute('DELETE `robots` WHERE `id` = 103');

    // Commit if everything goes well
    $connection->commit();
} catch (Exception $e) {
    // An exception has occurred rollback the transaction
    $connection->rollback();
}
```

علاوه بر معاملات استاندارد، `فالکون/پایگاه داده` نیز پشتیبانی فراهم می کند برای [معاملات نشتی](http://en.wikipedia.org/wiki/Nested_transaction)و(اگر سیستم پایگاه داده مورد استفاده آنها را پشتیبانی کند). هنگامی که شما شروع)) را فرا می خوانید، یک معامله ی نشتی برای بار دوم ایجاد می شود:

```php
<?php

try {
    // Start a transaction
    $connection->begin();

    // Execute some SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 101');

    try {
        // Start a nested transaction
        $connection->begin();

        // Execute these SQL statements into the nested transaction
        $connection->execute('DELETE `robots` WHERE `id` = 102');
        $connection->execute('DELETE `robots` WHERE `id` = 103');

        // Create a save point
        $connection->commit();
    } catch (Exception $e) {
        // An error has occurred, release the nested transaction
        $connection->rollback();
    }

    // Continue, executing more SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 104');

    // Commit if everything goes well
    $connection->commit();
} catch (Exception $e) {
    // An exception has occurred rollback the transaction
    $connection->rollback();
}
```

<a name='events'></a>

## رویدادهای بانک اطلاعاتی

`فالکون/پایگاه داده` رویدادها را به آن می فرستد اگر [مدیریت رویدادها](/[[language]]/[[version]]/events) وجود داشته باشد. برخی از رویدادها هنگام باز گشت بولین اشتباه، می توانند عملیات فعال را متوقف کنند. رویدادهای زیر پشتیبانی شده اند:

| نام رویداد          | باعث شد                                              | می توانید عملیات را متوقف کنید؟ |
| ------------------- | ---------------------------------------------------- |:-------------------------------:|
| `پس از اتصال`       | بعد از اتصال موفقیت آمیز به یک پایگاه داده           |               No                |
| `قبل از جستجو`      | قبل از فرستادن بیانیه اس کیو ال به سیستم پایگاه داده |               Yes               |
| `بعد از جستجو`      | بعد از فرستادن بیانیه اس کیو ال به سیستم پایگاه داده |               No                |
| `قبل از قطع اتصال`  | قبل از اتمام اتصال پایگاه اطلاعاتی در حال اجرا       |               No                |
| `شروع معامله`       | قبل از اینکه یک معامله شروع شود                      |               No                |
| `عقب گرد به معامله` | قبل از اینکه معامله عقب گرد کند                      |               No                |
| `انجام معامله`      | قبل از اینکه معامله صورت گیرد                        |               No                |

ارتباط میریت رویدادها به اتصال ساده است، `فالکون/پایگاه داده` رویدادها را با نوع `پابگاه داده` راه می اندازد:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

$eventsManager = new EventsManager();

// Listen all the database events
$eventsManager->attach('db', $dbListener);

$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Assign the eventsManager to the db adapter instance
$connection->setEventsManager($eventsManager);
```

عملیات متوقف کردن اس کیو ال بسیار مفید است. برای مثال شما می خواهید برخی از آخرین منابع چاک دهنده انژکتور اسکیوال را اجرا کنید:

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) {
        $sql = $connection->getSQLStatement();

        // Check for malicious words in SQL statements
        if (preg_match('/DROP|ALTER/i', $sql)) {
            // DROP/ALTER operations aren't allowed in the application,
            // this must be a SQL injection!
            return false;
        }

        // It's OK
        return true;
    }
);
```

<a name='profiling'></a>

## تدوین بیانیه های اس کیو ال

`Phalcon\Db` شامل یک جز پروفایل نامیده می شود `Phalcon\Db\Profiler`، این است که برای تجزیه و تحلیل عملکرد عملیات پایگاه داده به منظور تشخیص مشکلات عملکرد و کشف تنگناها مورد استفاده قرار گیرد.

پروفیل پایگاه داده با استفاده از آن بسیار آسان است `Phalcon\Db\Profiler`:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;

$eventsManager = new EventsManager();

$profiler = new DbProfiler();

// Listen all the database events
$eventsManager->attach(
    'db',
    function (Event $event, $connection) use ($profiler) {
        if ($event->getType() === 'beforeQuery') {
            $sql = $connection->getSQLStatement();

            // Start a profile with the active connection
            $profiler->startProfile($sql);
        }

        if ($event->getType() === 'afterQuery') {
            // Stop the active profile
            $profiler->stopProfile();
        }
    }
);

// Assign the events manager to the connection
$connection->setEventsManager($eventsManager);

$sql = 'SELECT buyer_name, quantity, product_name '
     . "از خریداران"
     . 'LEFT JOIN products ON buyers.pid = products.id';

// Execute a SQL statement
$connection->query($sql);

// Get the last profile in the profiler
$profile = $profiler->getLastProfile();

echo 'SQL Statement: ', $profile->getSQLStatement(), "\n";
echo 'Start Time: ', $profile->getInitialTime(), "\n";
echo 'Final Time: ', $profile->getFinalTime(), "\n";
echo 'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), "\n";
```

شما همچنین می توانید طبق مشخصات خود را بر اساس `Phalcon\Db\Profiler` برای ثبت آمار زمان واقعی اظهارات ارسال شده به سیستم پایگاه داده:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as Profiler;
use Phalcon\Db\Profiler\Item as Item;

class DbProfiler extends Profiler
{
    /**
     * Executed before the SQL statement will sent to the db server
     */
    public function beforeStartProfile(Item $profile)
    {
        echo $profile->getSQLStatement();
    }

    /**
     * Executed after the SQL statement was sent to the db server
     */
    public function afterEndProfile(Item $profile)
    {
        echo $profile->getTotalElapsedSeconds();
    }
}

// Create an Events Manager
$eventsManager = new EventsManager();

// Create a listener
$dbProfiler = new DbProfiler();

// Attach the listener listening for all database events
$eventsManager->attach('db', $dbProfiler);
```

<a name='logging-statements'></a>

## ثبت گزارشات اس کیو ال

با استفاده از اجزای انتزاعی سطح بالا از قبیل `Phalcon\Db` برای دسترسی به یک پایگاه داده، دشوار است که بدانیم کدام عبارت به سیستم پایگاه داده ارسال می شود. `فالکون/لوگر` تعامل با `فالکون/پایگاه داده` برای ارائه قابلیت های ورود به سیستم در لایه انتزاعی پایگاه داده ارتباط برقرار می کند.

```php
<?php

use Phalcon\Logger;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;

$eventsManager = new EventsManager();

$logger = new FileLogger('app/logs/db.log');

$eventsManager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) use ($logger) {
        $sql = $connection->getSQLStatement();

        $logger->log($sql, Logger::INFO);
    }
);

// Assign the eventsManager to the db adapter instance
$connection->setEventsManager($eventsManager);

// Execute some SQL statement
$connection->insert(
    'products',
    [
        'Hot pepper',
        3.50,
    ],
    [
        'name',
        'price',
    ]
);
```

همانطور که در بالا، فایل `app/logs/db.log` چیزی شبیه به این خواهد بود:

```bash
[Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
(name, price) VALUES ('Hot pepper', 3.50)
```

<a name='logger-custom'></a>

## پیاده سازی لاگر خودتان

شما می توانید کلاس لاگر خود را برای جستجوی پایگاه داده، با ایجاد کلاسی که از روش ساده به نام `لوگ` استفاده می کند، پیاده سازی کنید. روش باید یک رشته را به عنوان اولین شناسه قبول کند. پس از آن شما می توانید شیء ثبت نام خود را به `Phalcon\Db::setLogger()` منتقل کنید و از آن پس، هر بیانیه اس کیو ال این روش را برای ورود به نتیجه های جستجو، فراخوانی می کند.

<a name='describing-tables'></a>

## توصیف جداول/ نمایش ها

همچنین `Phalcon\Db` روش هایی را برای بازیابی جزئیات اطلاعات درباره ی جداول و نمایش ها فراهم می کند:

```php
<?php

// دریافت جداول در پایگاه داده _db آزمون
$tables = $connection->listTables('test_db');

// آیا یک روبات جدول در پایگاه داده وجود دارد؟
$exists = $connection->tableExists('robots');

// Get name, data types and special features of 'robots' fields
$fields = $connection->describeColumns('robots');
foreach ($fields as $field) {
    echo 'Column Type: ', $field['Type'];
}

// Get indexes on the 'robots' table
$indexes = $connection->describeIndexes('robots');
foreach ($indexes as $index) {
    print_r(
        $index->getColumns()
    );
}

// Get foreign keys on the 'robots' table
$references = $connection->describeReferences('robots');
foreach ($references as $reference) {
    // Print referenced columns
    print_r(
        $reference->getReferencedColumns()
    );
}
```

توضیحات یک جدول بسیار شبیه به دستور مای اس کیو ال است که شامل اطلاعات زیر می شود:

| فیلد       | نوع      | کلید                               | خالی                                 |
| ---------- | -------- | ---------------------------------- | ------------------------------------ |
| نام فیلدها | نوع ستون | آیا ستون یک بخش اولیه یا شاخص است؟ | آیا ستون به مقادیر تهی اجازه می دهد؟ |

روش های دریافت اطلاعات درمورد دیدگاه ها نیز برای هر پایگاه داده پشتیبانی می شود:

```php
<?php

// Get views on the test_db database
$tables = $connection->listViews('test_db');

// Is there a view 'robots' in the database?
$exists = $connection->viewExists('robots');
```

<a name='tables'></a>

## ایجاد/تغییر/حذف جداول

سیستم های مختلف پایگاه داده(مای اسکیوال،پست گرسکیوال و غیره) توانایی ایجاد، تغییر یا حذف جداول را با استفاده از دستوراتی مانندایجاد، تغییر یا رها کردن ارائه می دهند. آرایه اس کیو ال بر اساس اینکه کدام سیستم پایگاه داده استفاده شده است، متفاوت می باشد. `فالکون/پایگاه داده` رابط کاربری یکپارچه برای تغییر جداول را بدون نیاز به تفاوت قائل شدن به آرایه ی اس کیو ال بر اساس سیستم ذخیره ای هدف، فراهم می کند.

<a name='tables-create'></a>

### ایجاد جداول

مثال زیر نشان می دهد که چگونه یک جدول بسازید:

```php
<?php

use \Phalcon\Db\Column as Column;

$connection->createTable(
    'robots',
    null,
    [
       'columns' => [
            new Column(
                'id',
                [
                    'type'          => Column::TYPE_INTEGER,
                    'size'          => 10,
                    'notNull'       => true,
                    'autoIncrement' => true,
                    'primary'       => true,
                ]
            ),
            new Column(
                'name',
                [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 70,
                    'notNull' => true,
                ]
            ),
            new Column(
                'year',
                [
                    'type'    => Column::TYPE_INTEGER,
                    'size'    => 11,
                    'notNull' => true,
                ]
            ),
        ]
    ]
);
```

`Phalcon\Db::createTable()` آرایه وابسته که جدول را می پذیرد را می پذیرد. ستون ها با کلاس تعریف می شوند `فالکون/پایگاه داده/ستون`. جدول زیر گزینه های موجود برای تعریف یک ستون را نشان می دهد:

| گزینه           | توضیحات                                                                                                                                    | اختیاری |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |:-------:|
| `نوع`           | نوع ستون. باید براساس `فالکون/پایگاه داده/ستون` پایدار باشد ( در پایین یک لیست آمده است)                                                   |   No    |
| `اصلی`          | صحیح بودن اولیه اگر ستون جز اولیه ی کلید باشد                                                                                              |   Yes   |
| `اندازه`        | برخی از ستون ها مانند `VARCHAR` یا `INTEGER` ممکن است اندازه مخصوصی داشته باشند                                                            |   Yes   |
| `scale`         | `DECIMAL` or `NUMBER` columns may be have a scale to specify how many decimals should be stored                                            |   Yes   |
| `unsigned`      | `INTEGER` columns may be signed or unsigned. This option does not apply to other types of columns                                          |   Yes   |
| `notNull`       | Column can store null values?                                                                                                              |   Yes   |
| `default`       | Default value (when used with `'notNull' => true`).                                                                                     |   Yes   |
| `autoIncrement` | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. |   Yes   |
| `bind`          | One of the `BIND_TYPE_*` constants telling how the column must be bound before save it                                                     |   Yes   |
| `first`         | Column must be placed at first position in the column order                                                                                |   Yes   |
| `after`         | Column must be placed after indicated column                                                                                               |   Yes   |

`Phalcon\Db` supports the following database column types:

- `Phalcon\Db\Column::TYPE_INTEGER`
- `Phalcon\Db\Column::TYPE_DATE`
- `Phalcon\Db\Column::TYPE_VARCHAR`
- `Phalcon\Db\Column::TYPE_DECIMAL`
- `Phalcon\Db\Column::TYPE_DATETIME`
- `Phalcon\Db\Column::TYPE_CHAR`
- `Phalcon\Db\Column::TYPE_TEXT`

The associative array passed in `Phalcon\Db::createTable()` can have the possible keys:

| Index        | توضیحات                                                                                                                                | Optional |
| ------------ | -------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | An array with a set of table columns defined with `Phalcon\Db\Column`                                                                |    No    |
| `indexes`    | An array with a set of table indexes defined with `Phalcon\Db\Index`                                                                 |   Yes    |
| `references` | An array with a set of table references (foreign keys) defined with `Phalcon\Db\Reference`                                           |   Yes    |
| `options`    | An array with a set of table creation options. These options often relate to the database system in which the migration was generated. |   Yes    |

<a name='tables-altering'></a>

### تغییر جداول

As your application grows, you might need to alter your database, as part of a refactoring or adding new features. Not all database systems allow to modify existing columns or add columns between two existing ones. `Phalcon\Db` is limited by these constraints.

```php
<?php

use Phalcon\Db\Column as Column;

// Adding a new column
$connection->addColumn(
    'robots',
    null,
    new Column(
        'robot_type',
        [
            'type'    => Column::TYPE_VARCHAR,
            'size'    => 32,
            'notNull' => true,
            'after'   => 'name',
        ]
    )
);

// Modifying an existing column
$connection->modifyColumn(
    'robots',
    null,
    new Column(
        'name',
        [
            'type'    => Column::TYPE_VARCHAR,
            'size'    => 40,
            'notNull' => true,
        ]
    )
);

// Deleting the column 'name'
$connection->dropColumn(
    'robots',
    null,
    'name'
);
```

<a name='tables-dropping'></a>

### سقوط جداول

Examples on dropping tables:

```php
<?php

// Drop table robot from active database
$connection->dropTable('robots');

// Drop table robot from database 'machines'
$connection->dropTable('robots', 'machines');
```