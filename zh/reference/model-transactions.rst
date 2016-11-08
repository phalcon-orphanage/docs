事务管理（Model Transactions）
==============================

当一个进程执行多个数据库操作时，通常需要每一步都是成功完成以便保证数据完整性。事务可以确保在数据提交到数据库保存之前所有数据库操作都成功执行。

Phalcon中通过事务，可以在所有操作都成功执行之后提交到服务器，或者当有错误发生时回滚所有的操作。

自定义事务（Manual Transactions）
---------------------------------
如果一个应用只用到了一个数据库连接并且这些事务都不太复杂，那么可以通过简单的将当前数据库连接设置成事务模式实现事务功能，根据操作的成功与否提交或者回滚：

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

            // The model failed to save, so rollback the transaction
            if ($robot->save() === false) {
                $this->db->rollback();
                return;
            }

            $robotPart = new RobotParts();

            $robotPart->robots_id = $robot->id;
            $robotPart->type      = "head";

            // The model failed to save, so rollback the transaction
            if ($robotPart->save() === false) {
                $this->db->rollback();

                return;
            }

            // Commit the transaction
            $this->db->commit();
        }
    }

隐含的事务（Implicit Transactions）
-----------------------------------
也可以通过已有的关系来存储记录以及其相关记录，这种操作将隐式地创建一个事务来保证所有数据都能够正确地保存：

.. code-block:: php

    <?php

    $robotPart = new RobotParts();

    $robotPart->type = "head";



    $robot = new Robots();

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");
    $robot->robotPart  = $robotPart;

    // Creates an implicit transaction to store both records
    $robot->save();

单独的事务（Isolated Transactions）
-----------------------------------
单独事务在一个新的连接中执行所有的SQL，虚拟外键检查和业务规则与主数据库连接是相互独立的。
这种事务需要一个事务管理器来全局的管理每一个事务，保证他们在请求结束前能正确的回滚或者提交。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
    use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

    try {
        // Create a transaction manager
        $manager = new TxManager();

        // Request a transaction
        $transaction = $manager->get();

        $robot = new Robots();

        $robot->setTransaction($transaction);

        $robot->name       = "WALL·E";
        $robot->created_at = date("Y-m-d");

        if ($robot->save() === false) {
            $transaction->rollback(
                "Cannot save robot"
            );
        }

        $robotPart = new RobotParts();

        $robotPart->setTransaction($transaction);

        $robotPart->robots_id = $robot->id;
        $robotPart->type      = "head";

        if ($robotPart->save() === false) {
            $transaction->rollback(
                "Cannot save robot part"
            );
        }

        // Everything's gone fine, let's commit the transaction
        $transaction->commit();
    } catch (TxFailed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }

事务可以用以保证以一致性的方式删除多条记录：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
    use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

    try {
        // Create a transaction manager
        $manager = new TxManager();

        // Request a transaction
        $transaction = $manager->get();

        // Get the robots to be deleted
        $robots = Robots::find(
            "type = 'mechanical'"
        );

        foreach ($robots as $robot) {
            $robot->setTransaction($transaction);

            // Something's gone wrong, we should rollback the transaction
            if ($robot->delete() === false) {
                $messages = $robot->getMessages();

                foreach ($messages as $message) {
                    $transaction->rollback(
                        $message->getMessage()
                    );
                }
            }
        }

        // Everything's gone fine, let's commit the transaction
        $transaction->commit();

        echo "Robots were deleted successfully!";
    } catch (TxFailed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }

事务对象可以重用，不管事务对象是在什么地方获取的。只有当一个:code:`commit()`或者一个:code:`rollback()`执行时才会创建一个新的事务对象。可以通过服务容器在整个应用中来创建和管理全局事务管理器。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager

    $di->setShared(
        "transactions",
        function () {
            return new TransactionManager();
        }
    );

然后在控制器或者视图中访问：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function saveAction()
        {
            // Obtain the TransactionsManager from the services container
            $manager = $this->di->getTransactions();

            // Or
            $manager = $this->transactions;

            // Request a transaction
            $transaction = $manager->get();

            // ...
        }
    }

当一个事务处于活动状态时，在整个应用中事务管理器将总是返回这个相同的事务。
