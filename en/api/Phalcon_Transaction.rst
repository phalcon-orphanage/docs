Class **Phalcon_Transaction**
=============================

Transactions are protective blocks where SQL statements are only permanent if they can  all succeed as one atomic action. Phalcon_Transaction is intended to be used with Phalcon_Model_Base.  Phalcon Transactions should be created using Phalcon_Transaction_Manager.  

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

**__construct** (boolean $autoBegin)

Phalcon_Transaction constructor

**setTransactionManager** (Phalcon_Transaction_Manager $manager)

Sets transaction manager related to the transaction

**boolean** **begin** ()

Starts the transaction

**boolean** **commit** ()

Commits the transaction

**boolean** **rollback** (string $rollbackMessage, Phalcon_Model_Base $rollbackRecord)

Rollbacks the transaction

**Phalcon_Db** **getConnection** ()

Returns connection related to transaction

**setIsNewTransaction** (boolean $isNew)

Sets if is a reused transaction or new once

**setRollbackOnAbort** (boolean $rollbackOnAbort)

Sets flag to rollback on abort the HTTP connection

**boolean** **isManaged** ()

Checks whether transaction is managed by a transaction manager

**setDependencyPointer** (int $pointer)

Changes dependency internal pointer

**attachDependency** (int $pointer, Phalcon_Model_Base $object)

Attaches Phalcon_Model_Base object to the active transaction

**boolean** **save** ()

Make a bulk save on all attached objects

**array** **getMessages** ()

Returns validations messages from last save try

**boolean** **isValid** ()

Checks whether internal connection is under an active transaction

**setRollbackedRecord** (Phalcon_Model_Base $record)

Sets object which generates rollback action

