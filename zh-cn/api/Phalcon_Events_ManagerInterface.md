* * *

layout: article language: 'zh-cn' version: '4.0' title: 'Phalcon\Events\ManagerInterface'

* * *

# Interface **Phalcon\Events\ManagerInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/events/managerinterface.zep" class="btn btn-default btn-sm">源码在GitHub</a>

## 方法

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