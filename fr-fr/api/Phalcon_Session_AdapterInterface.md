* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Session\AdapterInterface'

* * *

# Interface **Phalcon\Session\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/session/adapterinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

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