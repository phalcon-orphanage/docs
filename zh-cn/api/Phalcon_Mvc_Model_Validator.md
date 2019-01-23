---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator'
---
# Abstract class **Phalcon\Mvc\Model\Validator**

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator.zep)

This is a base class for Phalcon\Mvc\Model validators

This class is only for backward compatibility reasons to use with Phalcon\Mvc\Collection. Otherwise please use the validators provided by Phalcon\Validation.

## 方法

public **__construct** (*array* $options)

Phalcon\Mvc\Model\Validator constructor

protected **appendMessage** (*string* $message, [*string* | *array* $field], [*string* $type])

将消息追加到验证器

public **getMessages** ()

返回由该验证程序生成的消息

public *array* **getOptions** ()

从验证器返回的所有选项

public **getOption** (*mixed* $option, [*mixed* $defaultValue])

返回选项

public **isSetOption** (*mixed* $option)

检查是否已验证程序选项中定义的选项

abstract public **validate** ([Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface) $record) inherited from [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

...