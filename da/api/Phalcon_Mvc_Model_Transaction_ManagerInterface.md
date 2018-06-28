# Interface **Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/transaction/managerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **has** ()

...

abstract public **get** ([*mixed* $autoBegin])

...

abstract public **rollbackPendent** ()

...

abstract public **commit** ()

...

abstract public **rollback** ([*mixed* $collect])

...

abstract public **notifyRollback** ([Phalcon\Mvc\Model\TransactionInterface](/en/3.2/api/Phalcon_Mvc_Model_TransactionInterface) $transaction)

...

abstract public **notifyCommit** ([Phalcon\Mvc\Model\TransactionInterface](/en/3.2/api/Phalcon_Mvc_Model_TransactionInterface) $transaction)

...

abstract public **collectTransactions** ()

...