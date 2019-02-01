---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\TransactionInterface'
---
# Interface **Phalcon\Mvc\Model\TransactionInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transactioninterface.zep)

## Metode

abstract public **setTransactionManager** ([Phalcon\Mvc\Model\Transaction\ManagerInterface](Phalcon_Mvc_Model_Transaction_ManagerInterface) $manager)

...

abstract public **begin** ()

...

abstract public **commit** ()

...

publik abstrak **putarkembali** ([*campuraduk* $putarkembalipesan], [*campuraduk* $putarkembalirekaman])

...

publik abstrak **getConnection** ()

...

abstract public **setIsNewTransaction** (*mixed* $isNew)

...

abstract public **setRollbackOnAbort** (*mixed* $rollbackOnAbort)

...

abstract public **isManaged** ()

...

abstrak publik **getMessages** ()

...

abstract public **isValid** ()

...

abstract public **setRollbackedRecord** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record)

...