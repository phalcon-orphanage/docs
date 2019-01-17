---
layout: article
language: 'cs-cz'
version: '4.0'
title: 'Phalcon\Mvc\Model\Transaction\ManagerInterface'
---
# Interface **Phalcon\Mvc\Model\Transaction\ManagerInterface**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transaction/managerinterface.zep)

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

abstract public **notifyRollback** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

...

abstract public **notifyCommit** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

...

abstract public **collectTransactions** ()

...