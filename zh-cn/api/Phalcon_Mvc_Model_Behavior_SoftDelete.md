---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Model\Behavior\SoftDelete'
---
# Class **Phalcon\Mvc\Model\Behavior\SoftDelete**

*extends* abstract class [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

*implements* [Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/behavior/softdelete.zep)

它将记录标记为, 而不是永久删除记录, 从而更改标志列的值

## 方法

public **notify** (*mixed* $type, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Listens for notifications from the models manager

public **__construct** ([*array* $options]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Phalcon\Mvc\Model\Behavior

protected **mustTakeAction** (*mixed* $eventName) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Checks whether the behavior must take action on certain event

protected *array* **getOptions** ([*string* $eventName]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Returns the behavior options related to an event

public **missingMethod** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *string* $method, [*array* $arguments]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Acts as fallbacks when a missing method is called on the model