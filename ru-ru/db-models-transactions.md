* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Транзакции модели

Когда процесс выполняет несколько операций в базе данных, очень важно, чтобы каждый шаг в этой группе выполнился успешно, тем самым поддерживая целостность данных. Транзакции предоставляют возможность реализации такого подхода, когда группа операций с базой данных может быть выполнена либо целиком и успешно, соблюдая целостность данных, либо не выполнена вообще.

Транзакции в Phalcon позволяют зафиксировать результат всех операции, если они были успешно выполнены, или откатить все операции, если хоть что-то пошло не так.

<a name='manual'></a>

## Ручные транзакции

Если приложение использует только одно соединение с базой данных и транзакции не очень сложны, транзакция может быть создана просто переводом текущего соединения в режим транзакции, и система делает откат или фиксацию, в зависимости от того, операция успешна или нет:

```php
<?php

use Phalcon\Mvc\Controller;

class RobotsController extends Controller
{
    public function saveAction()
    {
        // Запуск транзакции
        $this->db->begin();

        $robot = new Robots();

        $robot->name       = 'WALL-E';
        $robot->created_at = date('Y-m-d');

        // Не удалось сохранить модель, поэтому откатываем транзакцию
        if ($robot->save() === false) {
            $this->db->rollback();
            return;
        }

        $robotPart = new RobotParts();

        $robotPart->robots_id = $robot->id;
        $robotPart->type      = 'head';

        // Не удалось сохранить модель, поэтому откатываем транзакцию
        if ($robotPart->save() === false) {
            $this->db->rollback();

            return;
        }

        // Фиксация транзакции
        $this->db->commit();
    }
}
```

<a name='implicit'></a>

## Неявные транзакции

Существующие отношения (связи) между таблицами могут быть использованы для хранения записей и связанных с ними моделей. Этот вид операций неявно создает транзакцию, чтобы удостовериться, что данные сохраняются правильно:

```php
<?php

$robotPart = new RobotParts();

$robotPart->type = 'head';



$robot = new Robots();

$robot->name       = 'WALL-E';
$robot->created_at = date('Y-m-d');
$robot->robotPart  = $robotPart;

// Создает неявную транзакцию, чтобы сохранить обе записи
$robot->save();
```

<a name='isolated'></a>

## Изолированные транзакции

Изолированные транзакции выполняются в новом соединении, гарантируя, что все сгенерированные SQL-запросы, проверки виртуальных внешних ключей и бизнес логика изолированы от основного соединения. Этот вид транзакции требует менеджера транзакций, который в свою очередь, глобально управляет каждой транзакции, гарантируя правильные откат/фиксацию операций перед окончанием запроса:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

try {
    // Создаём менеджера транзакций
    $manager = new TxManager();

    // Запрос транзакции
    $transaction = $manager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = 'WALL·E';
    $robot->created_at = date('Y-m-d');

    if ($robot->save() === false) {
        $transaction->rollback(
            'Невозможно сохранить робота'
        );
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->robots_id = $robot->id;
    $robotPart->type      = 'head';

    if ($robotPart->save() === false) {
        $transaction->rollback(
            'Невозможно сохранить часть робота'
        );
    }

    // Всё прошло хорошо, фиксация
    $transaction->commit();
} catch (TxFailed $e) {
    echo 'Не удалось, причина: ', $e->getMessage();
}
```

Транзакции могут быть использованы для удаления нескольких записей на постоянной основе:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

try {
    // Создаём менеджера транзакций
    $manager = new TxManager();

    // Запрос транзакции
    $transaction = $manager->get();

    // Получить роботов для удаления
    $robots = Robots::find(
        "type = 'mechanical'"
    );

    foreach ($robots as $robot) {
        $robot->setTransaction($transaction);

        // Что-то идёт не так, мы должны откатить транзакцию
        if ($robot->delete() === false) {
            $messages = $robot->getMessages();

            foreach ($messages as $message) {
                $transaction->rollback(
                    $message->getMessage()
                );
            }
        }
    }

    // Всё прошло хорошо, давайте зафиксируем транзакцию
    $transaction->commit();

    echo 'Роботы успешно удалены!';
} catch (TxFailed $e) {
    echo 'Не удалось, причина: ', $e->getMessage();
}
```

Транзакция продолжается, независимо от того, где получается объект транзакции. A new transaction is generated only when a `commit()` or :code:`rollback()` is performed. Вы можете воспользоваться DI-контейнером, чтобы создать общий менеджер транзакций для всего приложения:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

$di->setShared(
    'transactions',
    function () {
        return new TransactionManager();
    }
);
```

Тогда доступ к нему из контроллера или представления может быть осуществлён следующим образом:

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function saveAction()
    {
        // Получить TransactionsManager из DI-контейнера
        $manager = $this->di->getTransactions();

        // Или
        $manager = $this->transactions;

        // Запрос транзакции
        $transaction = $manager->get();

        // ...
    }
}
```

Пока транзакция активна, менеджер транзакций всегда будет возвращать одну и ту же транзакцию.