---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Model\Transaction'
---
# Class **Phalcon\Mvc\Model\Transaction**

*implements* [Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transaction.zep)

事务是保护块 SQL 语句只是永久性的如果他们能成功作为一个原子操作。 Phalcon\Transaction is intended to be used with Phalcon_Model_Base. Phalcon Transactions should be created using Phalcon\Transaction\Manager.

```php
<?php

try {
    $manager = new \Phalcon\Mvc\Model\Transaction\Manager();

    $transaction = $manager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");

    if ($robot->save() === false) {
        $transaction->rollback("Can't save robot");
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->type = "head";

    if ($robotPart->save() === false) {
        $transaction->rollback("Can't save robot part");
    }

    $transaction->commit();
} catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
    echo "Failed, reason: ", $e->getMessage();
}

```

## 方法

public **__construct** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, [*boolean* $autoBegin], [*string* $service])

Phalcon\Mvc\Model\Transaction constructor

public **setTransactionManager** ([Phalcon\Mvc\Model\Transaction\ManagerInterface](Phalcon_Mvc_Model_Transaction_ManagerInterface) $manager)

设置事务管理器与事务有关的

public **begin** ()

启动事务

public **commit** ()

提交事务

public *boolean* **rollback** ([*string* $rollbackMessage], [[Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $rollbackRecord])

回滚事务

public **getConnection** ()

返回与事务相关的连接

public **setIsNewTransaction** (*mixed* $isNew)

设置重复使用的事务或启动一个新的

public **setRollbackOnAbort** (*mixed* $rollbackOnAbort)

设置标识回滚中止 HTTP 连接

public **isManaged** ()

检查是否事务都由事务管理器管理

public **getMessages** ()

返回验证消息从上次保存试

public **isValid** ()

检查内部连接是否下一个活动事务

public **setRollbackedRecord** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record)

设置对象的操作将生成回滚操作