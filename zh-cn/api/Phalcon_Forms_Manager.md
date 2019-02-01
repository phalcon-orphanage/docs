---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Forms\Manager'
---
# Class **Phalcon\Forms\Manager**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/manager.zep)

## 方法

public **create** (*string* $name, [*object* $entity])

创建一个表单，注册于表单管理器中

public **get** (*mixed* $name)

按其名称返回表单

public **has** (*mixed* $name)

检查表单是否在表单管理程序注册

public **set** (*mixed* $name, [Phalcon\Forms\Form](Phalcon_Forms_Form) $form)

在表单管理程序中注册表单