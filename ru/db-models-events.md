<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">События модели</a> 
      <ul>
        <li>
          <a href="#events">События и управление событиями</a> 
          <ul>
            <li>
              <a href="#events-in-models">Реализация событий в классе модели</a>
            </li>
            <li>
              <a href="#custom-events-manager">Использование пользовательского менеджера событий</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#logging-sql-statements">Логирование низкоуровневых SQL запросов</a>
        </li>
        <li>
          <a href="#profiling-sql-statements">Профилирование SQL запросов</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# События модели

<a name='events'></a>

## События и управление событиями

Модели позволяют реализовать события, которые будут срабатывать при выполнении вставки/обновления/удаления. Другими словами, события помогают определить бизнес-логику для определенной модели. Ниже приведены события, поддерживаемые `Phalcon\Mvc\Model` и порядок их выполнения:

| Операция           | Название                 | Может остановить операцию? | Пояснение                                                                                                           |
| ------------------ | ------------------------ |:--------------------------:| ------------------------------------------------------------------------------------------------------------------- |
| Вставка            | afterCreate              |            Нет             | Выполняется после выполнения требуемой операции над системой базы данных только при выполнении операции вставки     |
| Удаление           | afterDelete              |            Нет             | Выполняется после выполнения операции удаления                                                                      |
| Обновление         | afterUpdate              |            Нет             | Выполняется после требуемой операции над системой базы данных для операции обновления                               |
| Вставка/Обновление | afterSave                |            Нет             | Выполняется после требуемой операции над системой базы данных                                                       |
| Вставка/Обновление | afterValidation          |             Да             | Выполняется после проверки поля на не нулевую/пустую строку или на внешние ключи                                    |
| Вставка            | afterValidationOnCreate  |             Да             | Выполняется после проверки поля на не нулевую/пустую строку или на внешние ключи при выполнении операции вставки    |
| Обновление         | afterValidationOnUpdate  |             Да             | Выполняется после проверки поля на не нулевую/пустую строку или на внешние ключи при выполнении операции обновления |
| Вставка/Обновление | beforeValidation         |             Да             | Выполняется до проверки поля на не нулевую/пустую строку или на внешние ключи                                       |
| Вставка            | beforeCreate             |             Да             | Выполняется до требуемой операции над системой базы данных для операции вставки                                     |
| Удаление           | beforeDelete             |             Да             | Выполняется до выполнения операции удаления                                                                         |
| Вставка/Обновление | beforeSave               |             Да             | Выполняется до требуемой операции над системой базы данных                                                          |
| Обновление         | beforeUpdate             |             Да             | Выполняется до требуемой операции над системой базы данных для операции обновления                                  |
| Вставка            | beforeValidationOnCreate |             Да             | Выполняется до проверки поля на не нулевую/пустую строку или на внешние ключи при выполнении операции вставки       |
| Обновление         | beforeValidationOnUpdate |             Да             | Выполняется до проверки поля на не нулевую/пустую строку или на внешние ключи при выполнении операции обновления    |
| Вставка/Обновление | onValidationFails        |    Да (уже остановлена)    | Выполняется после обнаружения нарушения целостности                                                                 |
| Вставка/Обновление | validation               |             Да             | Выполняется до проверки поля на не нулевую/пустую строку или на внешние ключи при выполнении операции обновления    |

<a name='events-in-models'></a>

### Реализация событий в классе модели

Простой способ заставить модель реагировать на события — это реализовать метод с тем же именем события в классе модели:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function beforeValidationOnCreate()
    {
        echo 'This is executed before creating a Robot!';
    }
}
```

События могут быть полезны для присвоения значений перед выполнением операции, например:

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    public function beforeCreate()
    {
        // Установить дату создания
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        // Установить дату модификации
        $this->modified_in = date('Y-m-d H:i:s');
    }
}
```

<a name='custom-events-manager'></a>

### Использование пользовательского менеджера событий

Кроме того, этот компонент интегрируется с `Phalcon\Events\Manager`, это означает, что мы можем создать слушателей, которые запускаются при срабатывании события.

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

class Robots extends Model
{
    public function initialize()
    {
        $eventsManager = new EventsManager();

        // Добавляем анонимную функцию в качестве слушателя для событий "model"
        $eventsManager->attach(
            'model:beforeSave',
            function (Event $event, $robot) {
                if ($robot->name === 'Scooby Doo') {
                    echo "Scooby Doo isn't a robot!";

                    return false;
                }

                return true;
            }
        );

        // Устанавливаем менеджер событий для события
        $this->setEventsManager($eventsManager);
    }
}
```

В примере, приведенном выше, менеджер событий действует только в качестве моста между объектом и слушателем (анонимной функцией). События сработают сразу при сохренении `robots`:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->name = 'Scooby Doo';
$robot->year = 1969;

$robot->save();
```

Если мы хотим, чтобы все объекты, созданные в нашем приложении использовали один и тот же EventsManager, то мы должны назначить его менеджеру модели:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Регистрация сервиса modelsManager
$di->setShared(
    'modelsManager',
    function () {
        $eventsManager = new EventsManager();

        // Добавляем анонимную функцию в качестве
        // слушателя для событий "model"
        $eventsManager->attach(
            'model:beforeSave',
            function (Event $event, $model) {
                // Перехватываем события, производимые моделью Robots
                if (get_class($model) === 'Store\Toys\Robots') {
                    if ($model->name === 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";

                        return false;
                    }
                }

                return true;
            }
        );

        // Устанавливаем EventsManager по умолчанию
        $modelsManager = new ModelsManager();

        $modelsManager->setEventsManager($eventsManager);

        return $modelsManager;
    }
);
```

Если слушатель возвращает false, то это прерывает выполняемую операцию.

<a name='logging-sql-statements'></a>

## Логирование низкоуровневых SQL запросов

При использовании компонентов абстракции высокого уровня, таких как `Phalcon\Mvc\Model`, для доступа к базе данных, трудно понять, какие операции, в конечном итоге, посылаются базе данных. `Phalcon\Mvc\Model` поддерживается изнутри `Phalcon\Db`. `Phalcon\Logger` взаимодействует с `Phalcon\Db`, обеспечивая возможность ведения логов на уровне абстракции базы данных, таким образом, позволяя нам логировать SQL запросы.

```php
<?php

use Phalcon\Logger;
use Phalcon\Events\Manager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

$di->set(
    'db',
    function () {
        $eventsManager = new EventsManager();

        $logger = new FileLogger('app/logs/debug.log');

        // Слушаем все события базы данных
        $eventsManager->attach(
            'db:beforeQuery',
            function ($event, $connection) use ($logger) {
                $logger->log(
                    $connection->getSQLStatement(),
                    Logger::INFO
                );
            }
        );

        $connection = new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );

        // Назначаем EventsManager экземпляру адаптера базы данных
        $connection->setEventsManager($eventsManager);

        return $connection;
    }
);
```

Как только модель взаимодействует с соединением, все SQL запросы, которые передаются в базу данных, будут сохранены в файле:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->name       = 'Robby the Robot';
$robot->created_at = '1956-07-21';

if ($robot->save() === false) {
    echo 'Не удалось сохранить робота';
}
```

Упомянутый выше файл *app/logs/db.log* будет содержать что-то вроде этого:

> `[Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots` `(name, created_at) VALUES ('Robby the Robot', '1956-07-21')`

<a name='profiling-sql-statements'></a>

## Профилирование SQL запросов

Благодаря `Phalcon\Db`, основе компонента `Phalcon\Mvc\Model`, возможно профилировать SQL запросы, генерируемые ORM, в целях анализа производительности операций с базой данных. При этом вы можете диагностировать проблемы производительности и выявлять узкие места.

```php
<?php

use Phalcon\Db\Profiler as ProfilerDb;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;

$di->set(
    'profiler',
    function () {
        return new ProfilerDb();
    },
    true
);

$di->set(
    'db',
    function () use ($di) {
        $eventsManager = new EventsManager();

        // Получаем общий экземпляр DbProfiler
        $profiler = $di->getProfiler();

        // Слушаем все события базы данных
        $eventsManager->attach(
            'db',
            function ($event, $connection) use ($profiler) {
                if ($event->getType() === 'beforeQuery') {
                    $profiler->startProfile(
                        $connection->getSQLStatement()
                    );
                }

                if ($event->getType() === 'afterQuery') {
                    $profiler->stopProfile();
                }
            }
        );

        $connection = new MysqlPdo(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );

        // Назначаем EventsManager экземпляру адаптера базы данных
        $connection->setEventsManager($eventsManager);

        return $connection;
    }
);
```

Профилирование некоторых запросов:

```php
<?php

use Store\Toys\Robots;

// Отправим некоторый SQL запрос в базу данных
Robots::find();

Robots::find(
    [
        'order' => 'name',
    ]
);

Robots::find(
    [
        'limit' => 30,
    ]
);

// Получим данные профилировщика
$profiles = $di->get('profiler')->getProfiles();

foreach ($profiles as $profile) {
   echo 'SQL запрос: ', $profile->getSQLStatement(), "\n";
   echo 'Начальное время: ', $profile->getInitialTime(), "\n";
   echo 'Конечное время: ', $profile->getFinalTime(), "\n";
   echo 'Общее истекшее время: ', $profile->getTotalElapsedSeconds(), "\n";
}
```

Каждый генерируемый профиль содержит продолжительность выполнения каждого запроса в миллисекундах, а также сами сгенерированные SQL запросы.