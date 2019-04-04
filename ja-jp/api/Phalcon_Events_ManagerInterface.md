---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Events\ManagerInterface'
---
# Interface **Phalcon\Events\ManagerInterface**

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/events/managerinterface.zep)

## メソッド

abstract public **attach** (*mixed* $eventType, *mixed* $handler)

...

abstract public **detach** (*mixed* $eventType, *mixed* $handler)

...

abstract public **detachAll** ([*mixed* $type])

...

abstract public **fire** (*mixed* $eventType, *mixed* $source, [*mixed* $data])

...

abstract public **getListeners** (*mixed* $type)

...