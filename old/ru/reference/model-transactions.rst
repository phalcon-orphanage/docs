Транзакциии модели
==================

Когда приложение выполняет несколько операций в базе данных одновременно, нет гарантии, что каждый процес будет
успешно завершен. Транзакции дают возможность гарантировать, чтобы все операции с базой
данных были успешно выполнены прежде, чем данные фиксируются в базе данных.

Транзакции в Phalcon позволяют совершать все операции, если они были успешно выполнены, или откатить все операции,
если что-то пошло не так.

Ручные Транзакции
-----------------
Если приложение использует только одно соединение и транзакции не очень сложны, транзакция может быть
создана просто переводом текущего соединения в режим транзакции, и система делает откат или коммит,
в зависимости от того, операция успешна или нет:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class RobotsController extends Controller
    {
        public function saveAction()
        {
            // Start a transaction
            $this->db->begin();

            $robot = new Robots();

            $robot->name       = "WALL·E";
            $robot->created_at = date("Y-m-d");

            // Не удалось сохранить модель, поэтому откатываем транзакцию
            if ($robot->save() === false) {
                $this->db->rollback();
                return;
            }

            $robotPart = new RobotParts();

            $robotPart->robots_id = $robot->id;
            $robotPart->type      = "head";

            // Не удалось сохранить модель, поэтому откатываем транзакцию
            if ($robotPart->save() === false) {
                $this->db->rollback();

                return;
            }

            // Фиксируем транзакцию
            $this->db->commit();
        }
    }

Неявные транзакции
------------------
Существующие отношения могут быть использованы для хранения записей и связанных с ними случаев.
Этот вид операций неявно создает транзакцию, чтобы удостовериться, что данные сохраняются правильно:

.. code-block:: php

    <?php

    $robotPart = new RobotParts();

    $robotPart->type = "head";



    $robot = new Robots();

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");
    $robot->robotPart  = $robotPart;

    // Создает неявную транзакцию, чтобы сохранить обе записи
    $robot->save();

Изолированные транзакции
^^^^^^^^^^^^^^^^^^^^^^^^
Изолированные транзакции выполняются  в новом соединении, гарантируя, что все сгенерированные SQL,
виртуальные проверки внешних ключей и рабочие правила изолированы от основного соединения.
Этот вид транзакции требует менеджера транзакций, который глобально управляет каждой транзакции,
гарантируя правильные откат/совершение операций перед окончанием запроса:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
    use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

    try {
        // Создаем менеджера транзакций
        $manager = new TxManager();

        // Запрос транзакции
        $transaction = $manager->get();

        $robot = new Robots();

        $robot->setTransaction($transaction);

        $robot->name       = "WALL·E";
        $robot->created_at = date("Y-m-d");

        if ($robot->save() === false) {
            $transaction->rollback(
                "Невозможно сохранить робота"
            );
        }

        $robotPart = new RobotParts();

        $robotPart->setTransaction($transaction);

        $robotPart->robots_id = $robot->id;
        $robotPart->type      = "head";

        if ($robotPart->save() === false) {
            $transaction->rollback(
                "Невозможно сохранить часть робота"
            );
        }

        // Все идет хорошо, совершить транзакцию
        $transaction->commit();
    } catch (TxFailed $e) {
        echo "Не удалось, причина: ", $e->getMessage();
    }

Транзакции могут быть использованы для удаления нескольких записей на постоянной основе:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
    use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

    try {
        // Создать менеджер транзакций
        $manager = new TxManager();

        // Запрос транзакции
        $transaction = $manager->get();

        // Получить роботов для удаления
        $robots = Robots::find(
            "type = 'mechanical'"
        );

        foreach ($robots as $robot) {
            $robot->setTransaction($transaction);

            // Что-то идет не так, мы должны откатить транзакцию
            if ($robot->delete() === false) {
                $messages = $robot->getMessages();

                foreach ($messages as $message) {
                    $transaction->rollback(
                        $message->getMessage()
                    );
                }
            }
        }

        // Все идет хорошо, давайте завершим транзакцию
        $transaction->commit();

        echo "Роботы успешно удалены!";
    } catch (TxFailed $e) {
        echo "Не удалось, причина: ", $e->getMessage();
    }

Транзакция продолжается, независимо от того, где получается объект транзакции.
Новая транзакция формируется только при выполнении методов :code:`commit()` или :code:`rollback()`.
Вы можете воспользоваться di контейнером, чтобы создать общий менеджер транзакций
для всего приложения:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager

    $di->setShared(
        "transactions",
        function () {
            return new TransactionManager();
        }
    );

Тогда доступ к нему из контроллера или вида:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function saveAction()
        {
            // Получить TransactionsManager из контейнера услуг
            $manager = $this->di->getTransactions();

            // Или
            $manager = $this->transactions;

            // Запрос транзакции
            $transaction = $manager->get();

            // ...
        }
    }

Пока транзакция активна, менеджер транзакций по заявке будет всегда возвращать одну и ту же транзакцию.
