Class **Phalcon_Transaction_Manager**
=====================================

A transaction acts on a single database connection. If you have multiple class-specific databases, the transaction will not protect interaction among them  

.. code-block:: php

    <?php

    
    try {

        $transaction = Phalcon_Transaction_Manager::get();

        $robot = new Robots();
        $robot->setTransaction($transaction);
        $robot->name = 'WALL·E';
        $robot->created_at = date('Y-m-d');
        
        if ($robot->save() == false) {
            $transaction->rollback("Can't save robot");
        }

        $robotPart = new RobotParts();
        $robotPart->setTransaction($transaction);
        $robotPart->type = 'head';
        
        if ($robotPart->save() == false) {
            $transaction->rollback("Can't save robot part");
        }

        $transaction->commit();

    }
    catch(Phalcon_Transaction_Failed $e){
        echo 'Failed, reason: ', $e->getMessage();
    }

Methods
---------

**boolean** **has** ()

Checks whether manager has an active transaction

**Phalcon_Transaction** **get** (boolean $autoBegin)

Returns a new Phalcon_Transaction or an already created once

**rollbackPendent** ()

Rollbacks active transactions within the manager

**commit** ()

Commits active transactions within the manager

**rollback** (boolean $collect)

Rollbacks active transactions within the manager  Collect will remove transaction from the manager

**notifyRollback** (Phalcon_Transaction $transaction)

Notifies the manager about a rolled back transaction

**notifyCommit** (Phalcon_Transaction $transaction)

Notifies the manager about a committed transaction

**collectTransactions** ()

Remove all the transactions from the manager

**boolean** **isAutomatic** ()

Checks whether manager will inject an automatic transaction to all newly  created instances of Phalcon_Model_base

**Phalcon_Transaction** **getAutomatic** ()

Returns automatic transaction for instances of Phalcon_Model_base

