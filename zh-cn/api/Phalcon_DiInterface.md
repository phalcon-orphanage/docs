---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\DiInterface'
---
# Interface **Phalcon\DiInterface**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/diinterface.zep)

## 方法

abstract public **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

...

abstract public **setShared** (*mixed* $name, *mixed* $definition)

...

abstract public **remove** (*mixed* $name)

...

abstract public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared])

...

abstract public **get** (*mixed* $name, [*mixed* $parameters])

...

abstract public **getShared** (*mixed* $name, [*mixed* $parameters])

...

abstract public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition)

...

abstract public **getRaw** (*mixed* $name)

...

abstract public **getService** (*mixed* $name)

...

abstract public **has** (*mixed* $name)

...

abstract public **wasFreshInstance** ()

...

abstract public **getServices** ()

...

abstract public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

...

abstract public static **getDefault** ()

...

abstract public static **reset** ()

...

abstract public **offsetExists** (*mixed* $offset) inherited from [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

...

abstract public **offsetGet** (*mixed* $offset) inherited from [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

...

abstract public **offsetSet** (*mixed* $offset, *mixed* $value) inherited from [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

...

abstract public **offsetUnset** (*mixed* $offset) inherited from [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

...