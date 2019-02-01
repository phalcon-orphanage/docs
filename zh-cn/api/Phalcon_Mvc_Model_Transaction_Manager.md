---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Model\Transaction\Manager'
---
# Class **Phalcon\Mvc\Model\Transaction\Manager**

*implements* [Phalcon\Mvc\Model\Transaction\ManagerInterface](Phalcon_Mvc_Model_Transaction_ManagerInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transaction/manager.zep)

A transaction acts on a single database connection. If you have multiple class-specific databases, the transaction will not protect interaction among them.

This class manages the objects that compose a transaction. A transaction produces a unique connection that is passed to every object part of the transaction.

```php
<?php

try {
   use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

   $transactionManager = new TransactionManager();

   $transaction = $transactionManager->get();

   $robot = new Robots();

   $robot->setTransaction($transaction);

   $robot->name       = "WALL·E";
   $robot->created_at = date("Y-m-d");

   if ($robot->save() === false){
       $transaction->rollback("Can't save robot");
   }

   $robotPart = new RobotParts();

   $robotPart->setTransaction($transaction);

   $robotPart->type = "head";

   if ($robotPart->save() === false) {
       $transaction->rollback("Can't save robot part");
   }

   $transaction->commit();
} catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
   echo "Failed, reason: ", $e->getMessage();
}

```

## 方法

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Mvc\Model\Transaction\Manager constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injection container

public **getDI** ()

Returns the dependency injection container

public **setDbService** (*mixed* $service)

设置用于运行隔离级别的事务的数据库服务

public *string* **getDbService** ()

返回用于隔离该事务的数据库服务

public **setRollbackPendent** (*mixed* $rollbackPendent)

如果事务管理器必须注册关机功能清理下垂交易，设置

public **getRollbackPendent** ()

Check if the transaction manager is registering a shutdown function to clean up pendent transactions

public **has** ()

检查是否经理有一个活动事务

public **get** ([*mixed* $autoBegin])

Returns a new \Phalcon\Mvc\Model\Transaction or an already created once This method registers a shutdown function to rollback active connections

public **getOrCreateTransaction** ([*mixed* $autoBegin])

创建/返回到新事务或一个现有

public **rollbackPendent** ()

回滚活动事务管理器中

public **commit** ()

提交活动事务管理器中

public **rollback** ([*boolean* $collect])

回滚活动事务管理器收集内的将从管理器删除交易记录

public **notifyRollback** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

通知关于回滚的事务管理器

public **notifyCommit** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

通知关于已提交的事务管理器

protected **_collectTransaction** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

从事务管理器删除事务

public **collectTransactions** ()

从管理器中删除的所有的事务