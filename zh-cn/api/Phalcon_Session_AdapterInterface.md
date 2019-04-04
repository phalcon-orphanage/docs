---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Session\AdapterInterface'
---
# Interface **Phalcon\Session\AdapterInterface**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/session/adapterinterface.zep)

## 方法

abstract public **start** ()

...

abstract public **setOptions** (*array* $options)

...

abstract public **getOptions** ()

...

abstract public **get** (*mixed* $index, [*mixed* $defaultValue])

...

abstract public **set** (*mixed* $index, *mixed* $value)

...

abstract public **has** (*mixed* $index)

...

abstract public **remove** (*mixed* $index)

...

abstract public **getId** ()

...

abstract public **isStarted** ()

...

abstract public **destroy** ([*mixed* $removeData])

...

abstract public **regenerateId** ([*mixed* $deleteOldSession])

...

abstract public **setName** (*mixed* $name)

...

abstract public **getName** ()

...